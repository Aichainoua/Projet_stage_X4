<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- 1. IMPORTS ---
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReferenceController; 
use App\Http\Controllers\API\FormationController; 
use App\Http\Controllers\API\RessourceController;
use App\Http\Controllers\API\CoursController;
use App\Http\Controllers\API\InscriptionController; 


Route::get('/ping', function () {
    return response()->json(['message' => 'API opérationnelle 🚀']);
});


Route::get('/pays', [ReferenceController::class, 'indexPays']);


Route::prefix('auth')->group(function () {
    Route::post('/register/apprenant', [AuthController::class, 'registerApprenant']);
    Route::post('/register/formateur', [AuthController::class, 'registerFormateur']);
    Route::post('/login', [AuthController::class, 'login']);
});



Route::middleware('auth:sanctum')->group(function () {

    
    Route::post('/auth/logout', [AuthController::class, 'logout']);

 
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
            'role' => $request->user()->role ?? 'user' 
        ]);
    });

    Route::get('/mes-formations', [FormationController::class, 'mesFormations']);


    
    Route::get('/formateur/mes-creations', [FormationController::class, 'formationsDuFormateur']);


 
    Route::apiResource('formations', FormationController::class);


    Route::apiResource('cours', CoursController::class);


   
    
    Route::post('/formations/{id}/ressources', [RessourceController::class, 'store']);
    Route::delete('/ressources/{id}', [RessourceController::class, 'destroy']);


    Route::get('/formations/{id}/etudiants', [FormationController::class, 'etudiants']);
    
    
  
    Route::post('/inscriptions', [InscriptionController::class, 'store']);
    
});