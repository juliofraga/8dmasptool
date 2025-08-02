<?php

namespace App\Http\Controllers;

use App\Models\verification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\VerificationRepository;

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
        return $this->verificationRepository->store($request);
    }
}
