<?php

namespace App\Http\Controllers;

use App\Models\incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IncidentRepository;

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

    public function update(Request $request, string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        return $this->incidentRepository->update($request, $id);
    }

    private function generateVisualId(int $id)
    {
        return 'ID' . str_pad($id, 8, '0', STR_PAD_LEFT);
    }

}
