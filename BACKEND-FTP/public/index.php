<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Afficher les erreurs en mode développement
if (file_exists(__DIR__.'/../.env')) {
    $envContent = file_get_contents(__DIR__.'/../.env');
    if (strpos($envContent, 'APP_DEBUG=true') !== false || strpos($envContent, 'APP_ENV=local') !== false) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->handleRequest(Request::capture());
} catch (Throwable $e) {
    // Afficher l'erreur de manière claire
    http_response_code(500);
    
    if (file_exists(__DIR__.'/../.env') && strpos(file_get_contents(__DIR__.'/../.env'), 'APP_DEBUG=true') !== false) {
        echo json_encode([
            'error' => true,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            'error' => true,
            'message' => 'Erreur serveur. Activez APP_DEBUG=true dans .env pour voir les détails.'
        ]);
    }
    
    // Log l'erreur
    if (function_exists('logger')) {
        logger()->error($e->getMessage(), ['exception' => $e]);
    }
}
