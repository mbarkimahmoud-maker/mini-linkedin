<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;

// ROUTES PUBLIQUES — pas besoin d'être connecté
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ROUTES PROTÉGÉES — token JWT obligatoire
Route::middleware('auth:api')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //Route pour le candidat
    Route::middleware('role:candidat')->group(function () {
        Route::post('/profil',                           [ProfilController::class, 'store']);
        Route::get('/profil',                            [ProfilController::class, 'show']);
        Route::put('/profil',                            [ProfilController::class, 'update']);
        Route::post('/profil/competences',               [ProfilController::class, 'addCompetence']);
        Route::delete('/profil/competences/{competence}',[ProfilController::class, 'removeCompetence']);
    });
});