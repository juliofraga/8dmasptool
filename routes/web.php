<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {
    Route::prefix('admin')->group(function () {
        Route::get('/home', function () {
            return view('/admin/home');
        })->name('admin-home');
        Route::prefix('cadastro')->group(function () {
            Route::get('/usuarios', function () {
                return view('/admin/cadastro/usuarios');
            })->name('user-registration');
            Route::get('/areas', function () {
                return view('/admin/cadastro/areas');
            })->name('area-registration');
        });
        Route::get('/meu-perfil', function () {
            return view('/admin/meu-perfil');
        })->name('admin-profile');
        Route::get('/new-incident', function () {
            return view('/admin/incidente/novo');
        })->name('new-incident');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
