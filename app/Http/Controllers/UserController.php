<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Controllers\LogController as Log;

class UserController extends Controller
{
    public $user;
    public $userRepository;

    public function __construct(User $user) 
    {
        $this->user = $user;
        $this->userRepository = new UserRepository($this->user);
    }
    
    public function index(Request $request)
    {
        return $this->userRepository->paginate($request);
    }

    public function store(Request $request)
    {
        if ($request->password) {
            $request->merge([
                'password' => bcrypt($request->password)
            ]);
        }
        $user = $this->userRepository->store($request);
        if ($user->getStatusCode() === 500) {
            return $user;
        }
        return $user;
    }

    public function show(int $id)
    {
        return $this->userRepository->show($id);
    }

    public function update(Request $request, int $id)
    {
        $except = [];
        if ($request->password) {
            $request->merge([
                'password' => bcrypt($request->password)
            ]);
        } else {
            $except[] = 'password';
        }
        return $this->userRepository->update($request, $id, $except);
    }

    public function destroy(int $id)
    {
        return $this->userRepository->delete($id);
    }

    public function inactivate(int $id)
    {
        return $this->userRepository->updateStatus($id, 'inactive');
    }

    public function activate(int $id)
    {
        return $this->userRepository->updateStatus($id, 'active');
    }

    public static function registerUserLogin(string $email) 
    {
        $first_login = User::where('email', $email)->value('first_login');
        
        if (!$first_login) {
            UserController::registerLogin($email, 'first_login');
        }
        UserController::registerLogin($email, 'last_login');
    }

    public static function registerLogin(string $email, string $field)
    {
        $now = date('Y-m-d H:i:s');
        User::where('email', $email)->update([$field => $now]);
        User::where('email', $email)->update(['login_error' => 0]);
        $user = User::where('email', $email)->value('id');
        Log::store(['login'], $user, 'login');
    }
    
    public static function registerErrorLoginAttempt(string $email)
    {
        User::where('email', $email)->increment('login_error');
        $user = User::where('email', $email)->value('id');
        if ($user) {
            Log::store(['login error'], $user, 'login error');
        } else {
            Log::store(['login error'], 0, 'login error');
        }
    }

    public function getAll(Request $request, string $status)
    {
        return $this->userRepository->getAllRecords($request, $status);
    }
}
