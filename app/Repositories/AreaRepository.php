<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AreaRepository extends AbstractRepository {

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }  
    
    public function paginate(Request $request, int $qtd = null, array $order) 
    {
        $by = $order[0];
        $direction = $order[1];
        $qtd = $qtd ?? self::NUM_RESULTS_PAGE;
        $data = [];
        if($request->has('filter')) {
            $this->filter($request->filter);
        }
        $data = $this->model->with('users')->orderby($by, $direction)->paginate($qtd);
        return response()->json($data, 200);
    }
}