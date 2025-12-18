<?php

use Illuminate\Support\Facades\Route;

// Route de test ultra-simple en premier
Route::get('/test-direct', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Route directe fonctionne !',
        'time' => date('Y-m-d H:i:s')
    ]);
});

Route::get('/', function () {
    try {
        // Retourner une réponse JSON pour les clients API, ou rediriger vers la page d'info
        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json([
                'message' => 'API Backend Laravel fonctionne !',
                'version' => app()->version(),
                'status' => 'OK',
                'endpoints' => [
                    'api_test' => url('/api/test'),
                    'api_login' => url('/api/auth/login'),
                    'api_register_apprenant' => url('/api/auth/register/apprenant'),
                    'api_register_formateur' => url('/api/auth/register/formateur'),
                ]
            ]);
        }
        
        // Sinon, retourner la vue welcome ou rediriger vers la page d'info
        if (file_exists(public_path('api-info.html'))) {
            return redirect('/api-info.html');
        }
        
        return response()->json([
            'message' => 'Serveur Laravel fonctionne !',
            'status' => 'OK',
            'test_urls' => [
                '/test-direct',
                '/api/ping',
                '/api/test'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Erreur lors du chargement',
            'details' => app()->environment('local') ? $e->getMessage() : 'Erreur serveur',
            'trace' => app()->environment('local') ? $e->getTraceAsString() : null
        ], 500);
    }
});
