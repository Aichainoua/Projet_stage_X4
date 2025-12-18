# Script pour capturer et afficher les erreurs
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  CAPTURE D'ERREUR LARAVEL" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Afficher les dernières erreurs du log
Write-Host "[1/3] Dernieres erreurs dans le log..." -ForegroundColor Yellow
Write-Host ""
if (Test-Path "storage\logs\laravel.log") {
    Write-Host "--- DERNIERES 30 LIGNES DU LOG ---" -ForegroundColor Cyan
    Get-Content "storage\logs\laravel.log" -Tail 30
    Write-Host ""
} else {
    Write-Host "Aucun fichier de log trouve" -ForegroundColor Yellow
}

# 2. Tester le démarrage avec capture d'erreur
Write-Host "[2/3] Test de demarrage avec capture d'erreur..." -ForegroundColor Yellow
Write-Host ""

# Activer l'affichage des erreurs PHP
$env:PHP_INI_SCAN_DIR = ""
php -d display_errors=1 -d error_reporting=E_ALL artisan serve --host=127.0.0.1 --port=8000 2>&1 | Tee-Object -Variable output

Write-Host ""
Write-Host "[3/3] Analyse..." -ForegroundColor Yellow
Write-Host ""

if ($output -match "error|Error|ERROR|exception|Exception|EXCEPTION") {
    Write-Host "ERREURS DETECTEES:" -ForegroundColor Red
    $output | Select-String -Pattern "error|Error|ERROR|exception|Exception|EXCEPTION" -Context 2,2
} else {
    Write-Host "Aucune erreur detectee dans la sortie" -ForegroundColor Green
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan


