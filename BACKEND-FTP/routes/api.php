<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- IMPORTS OBLIGATOIRES ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReferenceController; 

/*
|--------------------------------------------------------------------------
| Routes Publiques (Sans Token)
|--------------------------------------------------------------------------
*/

// Test de connexion simple (Ping)
Route::get('/ping', function () {
    return response()->json(['message' => 'API opérationnelle']);
});

// Récupérer la liste des pays (nécessaire pour le formulaire d'inscription)
Route::get('/pays', [ReferenceController::class, 'indexPays']);

// Authentification (Login / Register)
Route::prefix('auth')->group(function () {
    Route::post('/register/apprenant', [AuthController::class, 'registerApprenant']);
    Route::post('/register/formateur', [AuthController::class, 'registerFormateur']);
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Routes Protégées (Nécessitent un Token)
|--------------------------------------------------------------------------
| Tout ce qui est ici nécessite que l'utilisateur soit connecté.
*/

Route::middleware('auth:sanctum')->group(function () {

    // 1. Déconnexion
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // 2. Route de test pour le Dashboard (Celle qu'on va tester !)
    // URL à appeler : http://127.0.0.1:8000/api/dashboard
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie ! Vous êtes authentifié.',
            'user' => $request->user(),       // Renvoie les infos de l'utilisateur
            'role' => $request->user()->role  // Renvoie son rôle (apprenant/formateur)
        ]);
    });

});