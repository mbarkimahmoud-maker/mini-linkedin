<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\OffreController;

// ROUTES PUBLIQUES pas besoin d'être connecté
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ROUTES PROTÉGÉES token JWT obligatoire
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

    //Route des offres publique
    Route::get('/offres',        [OffreController::class, 'index']);
    Route::get('/offres/{offre}', [OffreController::class, 'show']);

    //Route des offres pour le recruteur
    Route::middleware('role:recruteur')->group(function () {
        Route::post('/offres',           [OffreController::class, 'store']);
        Route::put('/offres/{offre}',    [OffreController::class, 'update']);
        Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);
    });

    // ── Candidatures ─────────────────────────────────
     Route::middleware('role:recruteur')->group(function () {
        Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'changerStatut']);
        Route::get('/offres/{offre}/candidatures',         [CandidatureController::class, 'offreCandidatures']);
    });

    Route::middleware('role:candidat')->group(function () {
        Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'postuler']);
        Route::get('/mes-candidatures',           [CandidatureController::class, 'mesCandidatures']);
    });
});