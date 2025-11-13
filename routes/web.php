<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionWebController;
use App\Http\Controllers\DashboardController;

require __DIR__.'/auth.php';

Route::get('/login', [AuthenticatedSessionWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticatedSessionWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthenticatedSessionWebController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
