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
    
    public function store(Request $request)
    {
        $incident = $this->incidentRepository->store($request);
        if ($incident->getStatusCode() === 500) {
            return $incident;
        }
        return $incident;
    }

}
