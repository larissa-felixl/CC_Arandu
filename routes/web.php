<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionWebController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GarbageController;
use App\Http\Controllers\FireController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php';

Route::get('/login', [AuthenticatedSessionWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticatedSessionWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthenticatedSessionWebController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthenticatedSessionWebController::class, 'showLogout'])->name('logout.page');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/garbage', [GarbageController::class, 'index'])
    ->middleware('auth')
    ->name('garbage');

Route::get('/fire', [FireController::class, 'index'])
    ->middleware('auth')
    ->name('fire');

Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile');

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
