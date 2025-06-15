<?php

namespace App\Http\Controllers;

use App\Models\containment_action;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IncidentController;
use Illuminate\Http\Request;
use App\Repositories\ContainmentActionRepository;

class ContainmentActionController extends Controller
{
    public $containmentAction;
    public $containmentActionRepository;

    public function __construct(containment_action $containmentAction) 
    {
        $this->containmentAction = $containmentAction;
        $this->containmentActionRepository = new ContainmentActionRepository($this->containmentAction);
    }

    public function index(Request $request)
    {
        return $this->containmentActionRepository->paginate($request, null, ['created_at', 'asc']);
    }

    public function store(Request $request)
    {
        $incident_id = IncidentController::getIncidentId($request->incidents_id);
        $request->merge([
            'incidents_id' => $incident_id
        ]);
        $containmentAction = $this->containmentActionRepository->store($request);
        if ($containmentAction->getStatusCode() === 500) {
            return $containmentAction;
        }
        return $containmentAction;
    }

    public function show(string $visual_id)
    {
        $incident_id = IncidentController::getIncidentId($visual_id);
        if (!$incident_id) {
            return response()->json(['error' => 'Incidente não encontrado'], 404);
        }
        $data = $this->containmentAction::with('user')
            ->where('incidents_id', $incident_id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'user_name' => $item->user->name,
                    'user_id' => $item->user->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'status' => $item->status
                ];
            });
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há ações de contenções cadastradas para este incidente'], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $action = $this->containmentAction->find($id);
        if (!$action) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }
        $request->merge([
            'description' => $request->description === 'null' ? NULL : $request->description,
        ]);
        $update = $action->update($request->all());
        if ($update) {
            return response()->json($action, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }

    public function destroy(int $id)
    {
        return $this->containmentActionRepository->delete($id);
    }
}
