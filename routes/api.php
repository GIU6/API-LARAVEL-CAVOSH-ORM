<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthClienteController;



Route::prefix('clientes')->group(function () {
    Route::post('/register', [AuthClienteController::class, 'register']);
    Route::post('/login', [AuthClienteController::class, 'login']);
    Route::post('/enviar-codigo', [AuthClienteController::class, 'enviarCodigo']);
    Route::post('/validar-codigo', [AuthClienteController::class, 'validarCodigo']);
});