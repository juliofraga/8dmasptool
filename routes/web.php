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
                return view('/admin/register/users');
            })->name('user-registration');
            Route::get('/areas', function () {
                return view('/admin/register/areas');
            })->name('area-registration');
        });
        Route::get('/meu-perfil', function () {
            return view('/admin/my-profile');
        })->name('admin-profile');
        Route::get('/incidente/novo', function () {
            return view('/admin/incident/new');
        })->name('new-incident');
        Route::get('/incidentes', function () {
            return view('/admin/incident/list');
        })->name('incidents');
        Route::get('/incidente/{visual_id}', function () {
            return view('/admin/incident/new');
        })->name('incident-stage1');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
