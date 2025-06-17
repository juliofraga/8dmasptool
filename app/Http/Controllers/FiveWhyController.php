<?php

namespace App\Http\Controllers;

use App\Models\five_why;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FiveWhyRepository;
use App\Http\Controllers\IncidentController;

class FiveWhyController extends Controller
{
    public $fiveWhy;
    public $fiveWhyRepository;

    public function __construct(five_why $fiveWhy) 
    {
        $this->fiveWhy = $fiveWhy;
        $this->fiveWhyRepository = new FiveWhyRepository($this->fiveWhy);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'whys' => 'required',
            'root_cause_potentials_id' => 'required',
            'root_cause_potentials_incidents_id' => 'required',
            'step_number' => 'required'
        ]);
        if (!is_array($validated)) {
            return response()->json([$validated], 500);
        }

        $whys = explode(',', $request->whys);
        $root_cause_potentials_id = $request->root_cause_potentials_id;
        $incident_id = IncidentController::getIncidentId($request->root_cause_potentials_incidents_id);
        $is_root_cause = $request->step_number;
        foreach ($whys as $step_number => $why) {
            $rightStepNumber = $step_number + 1;
            $record = new five_why();
            $record->step_number = $rightStepNumber;
            $record->why = $why;
            $record->root_cause_potentials_id = $root_cause_potentials_id;
            $record->root_cause_potentials_incidents_id = $incident_id;
            if ($rightStepNumber == $is_root_cause) {
                $record->is_root_cause = '1';
            }
            $record->save();
        }
        $data = $this->fiveWhy::where('root_cause_potentials_id', $root_cause_potentials_id)->where('root_cause_potentials_incidents_id', $incident_id)->get();
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há análises de porquês registradas'], 404);
        }
    }
}