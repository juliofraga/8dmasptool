<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\LogController as Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

abstract class AbstractRepository {

    public $model;
    private const ERROR_NOT_FOUND = 'Registro não encontrado';
    protected const NUM_RESULTS_PAGE = 20;

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
        $data = $this->model->orderby($by, $direction)->paginate($qtd);
        return response()->json($data, 200);
    }

    public function getAllRecords(Request $request, string $status = null) 
    {
        if($request->has('filter')) {
            $this->filter($request->filter);
        }
        if ($status) {
            $status = 'active' ? 1 : 0;
            $data = $this->model::where('status', $status)->get();
        } else {
            $data = $this->model::all();
        }
        return response()->json($data, 200);
    }

    public function store(Request $request) 
    {
        $request->validate($this->model->rules(), $this->model->feedback());
        $model = $this->model->create($request->all());
        if ($model) {
            $this->storeLog($model, 'insert');
            return response()->json($model, 201);
        } else {
            return response()->json(['erro' => 'Falha ao criar o registro.'], 500);
        }
    }

    public function show(int $id)
    {
        $model = $this->model->find($id);
        if (!$model) {
            return response()->json(['erro' => self::ERROR_NOT_FOUND], 404);
        }
        return response()->json($model, 200);
    }

    public function update(Request $request, int $id, array $except)
    {
        $model = $this->model->find($id);
        if (!$model) {
            return response()->json(['erro' => self::ERROR_NOT_FOUND], 404);
        }
        if (empty($except)) {
            $update = $model->update($request->all());
        } else {
            $update = $model->update($request->except($except));
        }
        if ($update) {
            $this->storeLog($model, 'update');
            return response()->json($model, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }

    public function delete(int $id)
    {
        $model = $this->model->find($id);
        if (!$model) {
            return response()->json(['erro' => self::ERROR_NOT_FOUND], 404);
        }
        $delete = $model->delete();
        if ($delete) {
            $this->storeLog($model, 'delete');
            return response()->json(['msg' => 'Registro deletado com sucesso'], 200);
        } else {
            return response()->json(['erro' => 'Falha ao deletar o registro.'], 500);
        }
    }

    public function filter(string $filters) 
    {
        $filters = explode(';', $filters);
        $this->model = $this->model->where(function ($query) use ($filters) {
            foreach ($filters as $key => $condition) {
                $c = explode(':', $condition);
                $query->orWhere($c[0], $c[1], $c[2]);
            }
        });
    }

    public function getAllOrdered(array $fields, string $order)
    {
        $model = $this->model::select($fields)->orderBy($order)->get();
        return response()->json($model, 200);
    }

    public function updateStatus(int $id, string $action = 'inactive')
    {
        $status = $action === 'active' ? 1 : 0;
        $model = $this->model->find($id);
        if (!$model) {
            return response()->json(['erro' => self::ERROR_NOT_FOUND], 404);
        }
        $update = $model::where('id', $id)->update(['status' => $status]);
        if ($update) {
            $this->storeLog($model, 'update');
            return response()->json($model, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }

    public function storeLog($model, string $tipo)
    {
        $user = Auth::user()->id;
        Log::store($model, $user, $tipo);
    }
}