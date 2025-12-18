<?php
/**
 * Script de test pour vérifier si Laravel peut démarrer
 * Exécutez: php test-bootstrap.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "========================================\n";
echo "  TEST DE BOOTSTRAP LARAVEL\n";
echo "========================================\n\n";

// Test 1: Vérifier l'autoloader
echo "[1/5] Test de l'autoloader Composer...\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
    echo "  ✓ OK - Autoloader charge\n\n";
} else {
    echo "  ✗ ERREUR - vendor/autoload.php introuvable\n";
    echo "  Executez: composer install\n\n";
    exit(1);
}

// Test 2: Vérifier le bootstrap
echo "[2/5] Test du bootstrap Laravel...\n";
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "  ✓ OK - Bootstrap charge\n\n";
} catch (Exception $e) {
    echo "  ✗ ERREUR - Bootstrap echoue\n";
    echo "  Message: " . $e->getMessage() . "\n";
    echo "  Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    exit(1);
}

// Test 3: Vérifier la configuration
echo "[3/5] Test de la configuration...\n";
try {
    $config = $app->make('config');
    echo "  ✓ OK - Configuration chargee\n\n";
} catch (Exception $e) {
    echo "  ✗ ERREUR - Configuration echoue\n";
    echo "  Message: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 4: Vérifier les routes
echo "[4/5] Test du chargement des routes...\n";
try {
    $router = $app->make('router');
    $routes = $router->getRoutes();
    $routeCount = count($routes);
    echo "  ✓ OK - $routeCount routes chargees\n\n";
} catch (Exception $e) {
    echo "  ✗ ERREUR - Routes echouent\n";
    echo "  Message: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 5: Test d'une requête simple
echo "[5/5] Test d'une requête HTTP...\n";
try {
    $request = \Illuminate\Http\Request::create('/test-direct', 'GET');
    $response = $app->handle($request);
    $statusCode = $response->getStatusCode();
    
    if ($statusCode === 200) {
        echo "  ✓ OK - Requête HTTP fonctionne (status: $statusCode)\n\n";
        echo "  Contenu de la réponse:\n";
        echo "  " . $response->getContent() . "\n\n";
    } else {
        echo "  ⚠ ATTENTION - Status code: $statusCode\n\n";
    }
} catch (Exception $e) {
    echo "  ✗ ERREUR - Requête HTTP echoue\n";
    echo "  Message: " . $e->getMessage() . "\n";
    echo "  Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    exit(1);
}

echo "========================================\n";
echo "  TOUS LES TESTS REUSSIS!\n";
echo "========================================\n";
echo "\nLe serveur devrait fonctionner. Essayez:\n";
echo "  php artisan serve\n\n";

