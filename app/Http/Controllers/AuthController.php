<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LogController as Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all(['email', 'password']);
        $token = auth('api')->attempt($data);
        $email = $data['email'];
        if ($token) {
            UserController::registerUserLogin($email);
            return response()->json(['token' => $token]);
        } else {
            UserController::registerErrorLoginAttempt($email);
            return response()->json(['erro' => 'Credenciais Inválidas'], 403);
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout realizado com sucesso']);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}