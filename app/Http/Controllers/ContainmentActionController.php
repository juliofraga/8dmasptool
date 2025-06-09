<?php

namespace App\Http\Controllers;

use App\Models\containment_action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\incident;
use App\Repositories\ContainmentActionRepository;

class ContainmentActionController extends Controller
{
    public $containmentAction;
    public $containmentActionRepository;

    public function __construct(containment_action $containmentAction) 
    {
        $this->containmentAction = $containmentAction;
        $this->containmentActionRepository = new ContainmentActionRepository($this->containmentAction);
    }

    public function index(Request $request)
    {
        return $this->containmentActionRepository->paginate($request, null, ['created_at', 'asc']);
    }

    public function store(Request $request)
    {
        $containmentAction = $this->containmentActionRepository->store($request);
        if ($containmentAction->getStatusCode() === 500) {
            return $containmentAction;
        }
        return $containmentAction;
    }

    public function show(string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        return $this->containmentAction->show($id);
    }

    public function update(Request $request, int $id)
    {

    }

    public function destroy(string $visual_id)
    {
        $id = incident::where('visual_id', $visual_id)->value('id');
        return $this->containmentAction->delete($id);
    }
}
