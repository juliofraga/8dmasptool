<?php

namespace App\Http\Controllers;

use App\Models\escape_point;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\IncidentController;
use App\Repositories\EscapePointRepository;

class EscapePointController extends Controller
{
    public $escapePoint;
    public $escapePointRepository;

    public function __construct(escape_point $escapePoint) 
    {
        $this->escapePoint = $escapePoint;
        $this->escapePointRepository = new EscapePointRepository($this->escapePoint);
    }

    public function store(Request $request)
    {
        $incident_id = IncidentController::getIncidentId($request->incident_id);
        $request->merge([
            'incident_id' => $incident_id
        ]);
        return $this->escapePointRepository->store($request);
    }
}
