<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\GearController;
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

// root
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::post('/', [IndexController::class, 'store']);

// register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// logout
// setting Logout to GET is vul to csrf. use POST instead
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// gearpieces
Route::get('/{user:username}/gearpieces', [GearPieceController::class, 'index'])->name('gearpieces');
Route::get('/{user:username}/gearpieces/create', [GearPieceController::class, 'create'])->name('gearpieces.create');
Route::post('/{user:username}/gearpieces/create', [GearPieceController::class, 'store'])->name('gearpieces.store');
Route::get('/{user:username}/gearpieces/{gearpiece:id}', [GearPieceController::class, 'show'])->name('gearpieces.show');
Route::delete('/{user:username}/gearpieces/{gearpiece:id}', [GearPieceController::class, 'destroy'])->name('gearpieces.delete');

// gears
Route::get('/{user:username}/gears', [GearController::class, 'index'])->name('gears');
Route::get('/{user:username}/gears/create', [GearController::class, 'create'])->name('gears.create');
Route::post('/{user:username}/gears/create', [GearController::class, 'store'])->name('gears.store');
Route::get('/{user:username}/gears/{gear:id}', [GearController::class, 'show'])->name('gears.show');
Route::get('/{user:username}/gears/{gear:id}/edit', [GearController::class, 'edit'])->name('gears.edit');
Route::put('/{user:username}/gears/{gear:id}', [GearController::class, 'update'])->name('gears.update');
Route::delete('/{user:username}/gears/{gear:id}', [GearController::class, 'destroy'])->name('gears.delete');