<?php

namespace App\Http\Controllers;

use App\Models\root_cause_test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RootCauseTestRepository;
use App\Http\Controllers\IncidentController;

class RootCauseTestController extends Controller
{
    public $rootCauseTest;
    public $rootCauseTestRepository;

    public function __construct(root_cause_test $rootCauseTest) 
    {
        $this->rootCauseTest = $rootCauseTest;
        $this->rootCauseTestRepository = new RootCauseTestRepository($this->rootCauseTest);
    }

    public function store(Request $request)
    {
        $incident_id = IncidentController::getIncidentId($request->incident_id);
        $request->merge([
            'result' => $request->result ?? null,
            'approved_at' => $request->approved == 2 ? NULL : date('Y-m-d H:i:s'),
            'incident_id' => $incident_id
        ]);
        return $this->rootCauseTestRepository->store($request);
    }

    public function show(string $visual_id)
    {
        $incident_id = IncidentController::getIncidentId($visual_id);
        if (!$incident_id) {
            return response()->json(['error' => 'Incidente não encontrado'], 404);
        }
        $data = $this->rootCauseTest::with('user')->with('fiveWhy')->where('incident_id', $incident_id)->get();
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há testes de causa raiz cadastrados para este incidente'], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $test = $this->rootCauseTest->find($id);
        if (!$test) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }
        $request->merge([
            'result' => $request->result == 'null' ? NULL : $request->result,
            'approved_at' => $request->approved == 2 ? NULL : date('Y-m-d H:i:s'),
        ]);
        $update = $test->update($request->all());
        if ($update) {
            return response()->json($test, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }
}