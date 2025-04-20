<?php

namespace App\Http\Controllers;

use App\Models\area;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AreaRepository;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public $area;
    public $areaRepository;

    public function __construct(Area $area) 
    {
        $this->area = $area;
        $this->areaRepository = new AreaRepository($this->area);
    }

    public function index(Request $request)
    {
        return $this->areaRepository->paginate($request);
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
            $this->ligaUserArea($area_object, $users);
        }
        return $area;
    }

    public function show(int $id)
    {
        return $this->areaRepository->show($id);
    }

    public function update(Request $request, int $id)
    {
        return $this->areaRepository->update($request, $id, []);
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

    public function ligaUserArea(Area $area, array $users)
    {
        // verificar pq nao funciona
        foreach ($users as $user_id) {
            $user = User::find($user_id);
            if ($user) {
                DB::enableQueryLog();
                $area->users()->syncWithoutDetaching([
                    $user->id => ['manager' => 0]
                ]);
                dd(DB::getQueryLog());
            }
        }
    }
}
