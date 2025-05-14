<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AreaRepository extends AbstractRepository {

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }  
    
    public function paginate(Request $request, int $qtd = null) 
    {
        $qtd = $qtd ?? self::NUM_RESULTS_PAGE;
        $data = [];
        if($request->has('filtro')) {
            $this->filter($request->filtro);
        }
        $data = $this->model->with('users')->paginate($qtd);
        return response()->json($data, 200);
    }
}