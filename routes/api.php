<?php

require __DIR__.'/auth.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FireLevelController;

// rota pública (sem auth) para testar criar denúncia
Route::post('/reports', [ReportController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// rotas protegidas
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/report-types', [ReportTypeController::class, 'index']);           // listar
    Route::post('/report-types', [ReportTypeController::class, 'store']);          // criar
    Route::put('/report-types/{id}', [ReportTypeController::class, 'update']);     // editar
    Route::delete('/report-types/{id}', [ReportTypeController::class, 'destroy']); // deletar

    Route::post('/reports', [ReportController::class, 'store']);                   // criar denúncia autenticado
    Route::get('/my-reports', [ReportController::class, 'myReports']);             // listar denúncias do usuário autenticado

    Route::post('/reports/{id}/fire-level', [FireLevelController::class, 'setLevel']); // criar/atualizar nível
    Route::get('/reports/{id}/fire-level', [FireLevelController::class, 'getLevel']);  // obter nível
});