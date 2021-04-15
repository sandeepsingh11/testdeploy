<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\User\GearPieceController;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::post('/', [IndexController::class, 'store']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// setting Logout to GET is vul to csrf. use POST instead
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/{user:username}/gearpieces', [GearPieceController::class, 'index'])->name('gearpieces');
Route::get('/{user:username}/gearpieces/{gearpiece:id}', [GearPieceController::class, 'show'])->name('gearpieces.show')
        ->missing(function () { 
            return Redirect::route('home'); 
        });
Route::delete('/{user:username}/gearpieces/{gearpiece:id}', [GearPieceController::class, 'destroy'])->name('gearpieces.delete');