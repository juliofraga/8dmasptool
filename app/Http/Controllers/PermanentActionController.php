<?php

namespace App\Http\Controllers;

use App\Models\permanent_action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PermanentActionRepository;
use App\Http\Controllers\IncidentController;

class PermanentActionController extends Controller
{
    public $permanentAction;
    public $permanentActionRepository;

    public function __construct(permanent_action $permanentAction) 
    {
        $this->permanentAction = $permanentAction;
        $this->permanentActionRepository = new PermanentActionRepository($this->permanentAction);
    }
    
    public function store(Request $request)
    {
        $incident_id = IncidentController::getIncidentId($request->incidents_id);
        $request->merge([
            'incidents_id' => $incident_id
        ]);
        $permanentAction = $this->permanentActionRepository->store($request);
        if ($permanentAction->getStatusCode() === 500) {
            return $permanentAction;
        }
        return $permanentAction;
    }

    public function show(string $visual_id)
    {
        $incident_id = IncidentController::getIncidentId($visual_id);
        if (!$incident_id) {
            return response()->json(['error' => 'Incidente não encontrado'], 404);
        }
        $data = $this->permanentAction::with('user')
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
                    'status' => $item->status,
                    'type' => $item->type,
                    'category' => $item->category,
                    'deadline' => $item->deadline
                ];
            });
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há ações corretivas permanentes cadastradas para este incidente'], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $action = $this->permanentAction->find($id);
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

    public static function get(int $id)
    {
        return permanent_action::where('id', $id)->get();
    }
}
