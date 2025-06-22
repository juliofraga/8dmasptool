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

    public function show(string $visual_id)
    {
        $incident_id = IncidentController::getIncidentId($visual_id);
        if (!$incident_id) {
            return response()->json(['error' => 'Incidente não encontrado'], 404);
        }
        $data = $this->escapePoint::where('incident_id', $incident_id)->get();
        if ($data) {
            return response()->json(['data' => $data, 200]);
        } else {
            return response()->json(['error' => 'Não há pontos de escapes cadastrados para este incidente'], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $escapePoint = $this->escapePoint->find($id);
        if (!$escapePoint) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }
        $update = $escapePoint->update($request->all());
        if ($update) {
            return response()->json($escapePoint, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }
}
