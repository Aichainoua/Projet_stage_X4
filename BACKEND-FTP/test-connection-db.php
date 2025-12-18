<?php
/**
 * Test de connexion à la base de données
 * Exécutez: php test-connection-db.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "========================================\n";
echo "  TEST DE CONNEXION BASE DE DONNEES\n";
echo "========================================\n\n";

// Charger .env
if (!file_exists('.env')) {
    echo "ERREUR: Fichier .env introuvable!\n";
    exit(1);
}

$envFile = file_get_contents('.env');
preg_match('/DB_CONNECTION=([^\r\n]+)/', $envFile, $matches);
$dbConnection = isset($matches[1]) ? trim($matches[1]) : 'sqlite';

echo "Configuration detectee: DB_CONNECTION=$dbConnection\n\n";

if ($dbConnection === 'pgsql') {
    echo "[TEST PostgreSQL]\n";
    
    preg_match('/DB_HOST=([^\r\n]+)/', $envFile, $matches);
    $host = isset($matches[1]) ? trim($matches[1]) : '127.0.0.1';
    
    preg_match('/DB_PORT=([^\r\n]+)/', $envFile, $matches);
    $port = isset($matches[1]) ? trim($matches[1]) : '5432';
    
    preg_match('/DB_DATABASE=([^\r\n]+)/', $envFile, $matches);
    $database = isset($matches[1]) ? trim($matches[1]) : 'laravel';
    
    preg_match('/DB_USERNAME=([^\r\n]+)/', $envFile, $matches);
    $username = isset($matches[1]) ? trim($matches[1]) : 'postgres';
    
    preg_match('/DB_PASSWORD=([^\r\n]+)/', $envFile, $matches);
    $password = isset($matches[1]) ? trim($matches[1]) : '';
    
    echo "  Host: $host\n";
    echo "  Port: $port\n";
    echo "  Database: $database\n";
    echo "  Username: $username\n";
    echo "  Password: " . (empty($password) ? "(vide)" : "***") . "\n\n";
    
    echo "  Tentative de connexion...\n";
    
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$database";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        
        echo "  ✓ SUCCES - Connexion PostgreSQL reussie!\n\n";
        
        $stmt = $pdo->query("SELECT version()");
        $version = $stmt->fetchColumn();
        echo "  Version PostgreSQL: $version\n\n";
        
    } catch (PDOException $e) {
        echo "  ✗ ERREUR - Impossible de se connecter a PostgreSQL\n";
        echo "  Message: " . $e->getMessage() . "\n\n";
        
        echo "  CAUSES POSSIBLES:\n";
        echo "  1. PostgreSQL n'est pas demarre\n";
        echo "  2. Les identifiants sont incorrects\n";
        echo "  3. La base de donnees n'existe pas\n";
        echo "  4. Le port est incorrect\n";
        echo "  5. Le pare-feu bloque la connexion\n\n";
        
        echo "  SOLUTION TEMPORAIRE:\n";
        echo "  Dans .env, changez:\n";
        echo "    DB_CONNECTION=pgsql\n";
        echo "  En:\n";
        echo "    DB_CONNECTION=sqlite\n\n";
        
        exit(1);
    }
    
} elseif ($dbConnection === 'sqlite') {
    echo "[TEST SQLite]\n";
    echo "  SQLite ne necessite pas de serveur\n";
    echo "  ✓ OK - Configuration SQLite valide\n\n";
} else {
    echo "[TEST $dbConnection]\n";
    echo "  Configuration: $dbConnection\n";
    echo "  (Test non implemente pour ce type de base)\n\n";
}

echo "========================================\n";
echo "  TEST TERMINE\n";
echo "========================================\n";


