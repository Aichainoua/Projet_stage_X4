<?php
// Fichier de test PHP simple pour vérifier que le serveur répond
header('Content-Type: application/json');
echo json_encode([
    'status' => 'ok',
    'message' => 'PHP fonctionne !',
    'server_time' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION
]);

