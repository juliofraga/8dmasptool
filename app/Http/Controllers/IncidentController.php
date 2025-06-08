<?php

namespace App\Http\Controllers;

use App\Models\incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IncidentRepository;
use App\Models\User;

class IncidentController extends Controller
{

    public $incident;
    public $incidentRepository;

    public function __construct(incident $incident) 
    {
        $this->incident = $incident;
        $this->incidentRepository = new IncidentRepository($this->incident);
    }

    public function index(Request $request)
    {
        return $this->incidentRepository->paginate($request, null, ['visual_id', 'asc']);
    }

    public function show(string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        return $this->incidentRepository->show($id);
    }
    
    public function store(Request $request)
    {
        if ($request->input('date_deadline') < $request->input('date_opening')) {
            return response()->json([
                'errors' => [
                    'date_deadline' => ['O prazo estimado para resolução do problema não pode ser menor que a data atual']
                ]
            ], 422);
        }
        $response = $this->incidentRepository->store($request);
        if ($response->getStatusCode() === 500) {
            return $response;
        }
        $incidentId = $response->getData(true)['id'];
        $visual_id = $this->generateVisualId(($incidentId));

        $incident = incident::find($incidentId);
        if ($incident) {
            $incident->visual_id = $visual_id;
            $incident->save();
        }
        return response()->json($incident);
    }

    function storeteam(Request $request)
    {
        $incidentId = incident::where('visual_id', $request->visual_id)->value('id');
        if (!$incidentId) {
            return response()->json([
                'errors' => [
                    'visual_id' => ['Não existem incidentes com o id informado, verifique novamente!']
                ]
            ], 422);
        }
        if (!User::find($request->leader)) {
            return response()->json([
                'errors' => [
                    'leader' => ['Líder do time informado não existe, verifique novamente!']
                ]
            ], 422);
        }
        $incident_object = $this->incident->find($incidentId);
        $members = explode(',', $request->members);
        if ($this->connectUserIncident($incident_object, $members, $request->leader)) {
            $incident_object = $this->incident
                ->with(['users' => function ($query) {
                    $query->withPivot('leader');
                }])
                ->find($incidentId);
            return response()->json($incident_object, 201);
        } else {
            return response()->json([
                'errors' => [
                    'members' => ['Ocorreu um erro ao adicionar os membros do time, tente novamente!']
                ]
            ], 422);
        }
    }

    public function update(Request $request, string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        if ($request->quantity_detected == 'null' || $request->quantity_detected == "null" || $request->quantity_detected === 'null' || $request->quantity_detected === "null") {
            $request->merge([
                'quantity_detected' => null
            ]);
        }
        return $this->incidentRepository->update($request, $id);
    }

    public function exists(string $visual_id)
    {
        if (incident::where('visual_id', $visual_id)->value('id')) {
            return response()->json([
                'exists' => true
            ], 200);
        } else {
            return response()->json([
                'exists' => false
            ], 200);
        }
    }

    public function connectUserIncident(incident $incident, array $members, string $leader)
    {
        $success = false;
        $leader = User::find($leader);
        if ($leader) {
            $incident->users()->syncWithoutDetaching([
                $leader->id => ['leader' => 1]
            ]);
            $success = true;
        }
        foreach ($members as $user_id) {
            $user = User::find($user_id);
            if ($user) {
                $incident->users()->syncWithoutDetaching([$user->id]);
            }
            $success = true;
        }
        return $success;
    }

    private function generateVisualId(int $id)
    {
        return 'ID' . str_pad($id, 8, '0', STR_PAD_LEFT);
    }

}
