<?php

namespace App\Http\Controllers;

use App\Models\containment_action;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IncidentController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\incident;
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
                    'created_at' => $item->created_at,
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

    }

    public function destroy(string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        return $this->containmentAction->delete($id);
    }
}
