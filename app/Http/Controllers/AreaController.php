<?php

namespace App\Http\Controllers;

use App\Models\area;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AreaRepository;

class AreaController extends Controller
{
    public $area;
    public $areaRepository;

    public function __construct(area $area) 
    {
        $this->area = $area;
        $this->areaRepository = new AreaRepository($this->area);
    }

    public function index(Request $request)
    {
        return $this->areaRepository->paginate($request, null, ['name', 'asc']);
    }

    public function store(Request $request)
    {
        $area = $this->areaRepository->store($request);
        if ($area->getStatusCode() === 500) {
            return $area;
        }
        $area_id = $area->getData(true)['id'];
        $area_object = $this->area->find($area_id);
        $users = $request->users;
        if (!empty($users)) {
            $users = explode(',', $users);
            $managers = explode(',', $request->managers);
            $this->connectUserArea($area_object, $users, $managers);
        }
        $this->areaRepository->storeLog($area, 'insert');
        return $area;
    }

    public function show(int $id)
    {
        return $this->areaRepository->show($id);
    }

    public function update(Request $request, int $id)
    {
        $area = $this->area->find($id);
        if (!$area) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }
        $request->merge([
            'description' => $request->description === 'null' ? NULL : $request->description,
        ]);
        $update = $area->update($request->all());
        $area->users()->detach();
        $users = $request->users;
        if (!empty($users)) {
            $users = explode(',', $users);
            $managers = explode(',', $request->managers);
            $this->connectUserArea($area, $users, $managers);
        }
        if ($update) {
            $this->areaRepository->storeLog($area, 'update');
            return response()->json($area, 200);
        } else {
            return response()->json(['erro' => 'Falha ao atualizar o registro.'], 500);
        }
    }

    public function destroy(int $id)
    {
        return $this->areaRepository->delete($id);
    }

    public function inactivate(int $id)
    {
        return $this->areaRepository->updateStatus($id, 'inactive');
    }

    public function activate(int $id)
    {
        return $this->areaRepository->updateStatus($id, 'active');
    }

    public function getAll(Request $request, string $status)
    {
        return $this->areaRepository->getAllRecords($request, $status);
    }

    public function connectUserArea(Area $area, array $users, array $managers)
    {
        foreach ($users as $user_id) {
            $user = User::find($user_id);
            if ($user) {
                $isManager = in_array($user_id, $managers) ? 1 : 0;
                $area->users()->syncWithoutDetaching([
                    $user->id => ['manager' => $isManager]
                ]);
            }
        }
    }
}
