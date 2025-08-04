<?php

namespace App\Http\Controllers;

use App\Models\verification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\VerificationRepository;
use App\Http\Controllers\PermanentActionController;

class VerificationController extends Controller
{
    public $verification;
    public $verificationRepository;

    public function __construct(verification $verification) 
    {
        $this->verification = $verification;
        $this->verificationRepository = new VerificationRepository($this->verification);
    }

    public function store(Request $request)
    {
        $permanentActionId = $request->permanent_actions_id;
        $permanentAction = PermanentActionController::get($permanentActionId);
        if (!$permanentAction) {
            return response()->json(['erro' => 'Ação permanente não encontrada'], 404);
        }
        return $this->verificationRepository->store($request);
    }
}
