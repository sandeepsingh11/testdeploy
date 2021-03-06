<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\GearController;
use App\Http\Controllers\User\GearsetController;
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

// home
Route::get('/', [IndexController::class, 'index'])->name('home');

// register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// logout
// setting Logout to GET is vul to csrf. use POST instead
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// reset password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

// dashboard
Route::get('/{user:username}', [DashboardController::class, 'index'])->name('dashboard');

// gears
Route::get('/{user:username}/gears', [GearController::class, 'index'])->name('gears');
Route::get('/{user:username}/gears/create', [GearController::class, 'create'])->name('gears.create');
Route::post('/{user:username}/gears/create', [GearController::class, 'store'])->name('gears.store');
Route::get('/{user:username}/gears/{gear:id}', [GearController::class, 'show'])->name('gears.show');
Route::get('/{user:username}/gears/{gear:id}/edit', [GearController::class, 'edit'])->name('gears.edit');
Route::put('/{user:username}/gears/{gear:id}', [GearController::class, 'update'])->name('gears.update');
Route::delete('/{user:username}/gears/{gear:id}', [GearController::class, 'destroy'])->name('gears.delete');

// gearsets
Route::get('/{user:username}/gearsets', [GearsetController::class, 'index'])->name('gearsets');
Route::get('/{user:username}/gearsets/create', [GearsetController::class, 'create'])->name('gearsets.create');
Route::post('/{user:username}/gearsets/create', [GearsetController::class, 'store'])->name('gearsets.store');
Route::get('/{user:username}/gearsets/{gearset:id}', [GearsetController::class, 'show'])->name('gearsets.show');
Route::get('/{user:username}/gearsets/{gearset:id}/edit', [GearsetController::class, 'edit'])->name('gearsets.edit');
Route::put('/{user:username}/gearsets/{gearset:id}', [GearsetController::class, 'update'])->name('gearsets.update');
Route::delete('/{user:username}/gearsets/{gearset:id}', [GearsetController::class, 'destroy'])->name('gearsets.delete');