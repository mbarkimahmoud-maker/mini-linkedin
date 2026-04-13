<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ROUTES PUBLIQUES — pas besoin d'être connecté
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ROUTES PROTÉGÉES — token JWT obligatoire
Route::middleware('auth:api')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});