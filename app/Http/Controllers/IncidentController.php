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

    private function generateVisualId(int $id)
    {
        return 'ID' . str_pad($id, 8, '0', STR_PAD_LEFT);
    }

}
