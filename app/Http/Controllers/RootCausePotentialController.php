<?php

namespace App\Http\Controllers;

use App\Models\root_cause_potential;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IncidentController;
use Illuminate\Http\Request;
use App\Repositories\RootCausaPotentialRepository;

class RootCausePotentialController extends Controller
{
    public $rootCausePotential;
    public $rootCausePotentialRepository;

    public function __construct(root_cause_potential $rootCausePotential) 
    {
        $this->rootCausePotential = $rootCausePotential;
        $this->rootCausePotentialRepository = new RootCausaPotentialRepository($this->rootCausePotential);
    }
    
    public function store(Request $request)
    {
        $incident_id = IncidentController::getIncidentId($request->incidents_id);
        $request->merge([
            'incidents_id' => $incident_id
        ]);
        $rootCausePotential = $this->rootCausePotentialRepository->store($request);
        if ($rootCausePotential->getStatusCode() === 500) {
            return $rootCausePotential;
        }
        return $rootCausePotential;
    }

    public function setascausaraiz(Request $request, int $id)
    {
        $incident_id = IncidentController::getIncidentId($request->incidents_id);
        $this->rootCausePotential::where('incidents_id', $incident_id)->update(['is_root_cause' => 0]);
        $this->rootCausePotential::where('id', $id)->update(['is_root_cause' => 1]);
    }

    public function show(string $visual_id)
    {
        $incident_id = IncidentController::getIncidentId($visual_id);
        if (!$incident_id) {
            return response()->json(['error' => 'Incidente não encontrado'], 404);
        }
        $data = $this->rootCausePotential->where('incidents_id', $incident_id)->get();
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há ações de contenções cadastradas para este incidente'], 404);
        }
    }

    public function destroy(int $id)
    {
        return $this->rootCausePotentialRepository->delete($id);
    }
}
