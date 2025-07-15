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
        $rootCausePotential = $this->permanentActionRepository->store($request);
        if ($rootCausePotential->getStatusCode() === 500) {
            return $rootCausePotential;
        }
        return $rootCausePotential;
    }
}
