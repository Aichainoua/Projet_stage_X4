# Script de diagnostic complet pour Laravel
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  DIAGNOSTIC LARAVEL - EDULAB AFRIK" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Vérifier PHP
Write-Host "[1/8] Verification de PHP..." -ForegroundColor Yellow
try {
    $phpVersion = php --version 2>&1 | Select-Object -First 1
    Write-Host "  OK - $phpVersion" -ForegroundColor Green
} catch {
    Write-Host "  ERREUR - PHP n'est pas installe!" -ForegroundColor Red
    exit
}

# 2. Vérifier Composer
Write-Host "[2/8] Verification de Composer..." -ForegroundColor Yellow
try {
    $composerVersion = composer --version 2>&1 | Select-Object -First 1
    Write-Host "  OK - $composerVersion" -ForegroundColor Green
} catch {
    Write-Host "  ATTENTION - Composer n'est pas installe" -ForegroundColor Yellow
}

# 3. Vérifier le fichier .env
Write-Host "[3/8] Verification du fichier .env..." -ForegroundColor Yellow
if (Test-Path ".env") {
    Write-Host "  OK - Fichier .env existe" -ForegroundColor Green
    
    # Vérifier APP_KEY
    $envContent = Get-Content .env -Raw
    if ($envContent -match "APP_KEY=") {
        $appKey = ($envContent | Select-String "APP_KEY=([^\r\n]+)").Matches[0].Groups[1].Value
        if ($appKey -eq "" -or $appKey -eq "base64:") {
            Write-Host "  ATTENTION - APP_KEY est vide!" -ForegroundColor Red
            Write-Host "  Executez: php artisan key:generate" -ForegroundColor Yellow
        } else {
            Write-Host "  OK - APP_KEY est configure" -ForegroundColor Green
        }
    }
} else {
    Write-Host "  ERREUR - Fichier .env manquant!" -ForegroundColor Red
    Write-Host "  Executez: copy .env.example .env" -ForegroundColor Yellow
    Write-Host "  Puis: php artisan key:generate" -ForegroundColor Yellow
}

# 4. Vérifier vendor
Write-Host "[4/8] Verification des dependances..." -ForegroundColor Yellow
if (Test-Path "vendor\autoload.php") {
    Write-Host "  OK - Dependencies installees" -ForegroundColor Green
} else {
    Write-Host "  ERREUR - Dependencies manquantes!" -ForegroundColor Red
    Write-Host "  Executez: composer install" -ForegroundColor Yellow
}

# 5. Vérifier les permissions
Write-Host "[5/8] Verification des permissions..." -ForegroundColor Yellow
if (Test-Path "storage") {
    Write-Host "  OK - Dossier storage existe" -ForegroundColor Green
} else {
    Write-Host "  ERREUR - Dossier storage manquant!" -ForegroundColor Red
}

if (Test-Path "bootstrap\cache") {
    Write-Host "  OK - Dossier bootstrap\cache existe" -ForegroundColor Green
} else {
    Write-Host "  ATTENTION - Dossier bootstrap\cache manquant" -ForegroundColor Yellow
}

# 6. Vérifier le port 8000
Write-Host "[6/8] Verification du port 8000..." -ForegroundColor Yellow
$portCheck = netstat -ano | findstr :8000
if ($portCheck) {
    Write-Host "  ATTENTION - Le port 8000 est deja utilise!" -ForegroundColor Yellow
    Write-Host "  Processus utilisant le port:" -ForegroundColor Yellow
    Write-Host $portCheck -ForegroundColor Gray
} else {
    Write-Host "  OK - Le port 8000 est disponible" -ForegroundColor Green
}

# 7. Vérifier les logs
Write-Host "[7/8] Verification des logs..." -ForegroundColor Yellow
if (Test-Path "storage\logs\laravel.log") {
    $logSize = (Get-Item "storage\logs\laravel.log").Length
    if ($logSize -gt 0) {
        Write-Host "  OK - Fichier de log existe ($logSize octets)" -ForegroundColor Green
        Write-Host "  Dernieres lignes du log:" -ForegroundColor Cyan
        Get-Content "storage\logs\laravel.log" -Tail 5 | ForEach-Object {
            Write-Host "    $_" -ForegroundColor Gray
        }
    } else {
        Write-Host "  OK - Fichier de log vide (aucune erreur)" -ForegroundColor Green
    }
} else {
    Write-Host "  OK - Aucun fichier de log (aucune erreur)" -ForegroundColor Green
}

# 8. Test de démarrage
Write-Host "[8/8] Test de demarrage..." -ForegroundColor Yellow
Write-Host "  Tentative de chargement de Laravel..." -ForegroundColor Gray

# Nettoyer le cache d'abord
Write-Host "  Nettoyage du cache..." -ForegroundColor Gray
php artisan config:clear 2>&1 | Out-Null
php artisan cache:clear 2>&1 | Out-Null

# Tester les routes
Write-Host "  Test des routes..." -ForegroundColor Gray
$routeTest = php artisan route:list --columns=uri,method 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "  OK - Routes chargees correctement" -ForegroundColor Green
    $routeCount = ($routeTest | Select-String "GET|POST").Count
    Write-Host "  Nombre de routes: $routeCount" -ForegroundColor Green
} else {
    Write-Host "  ERREUR - Impossible de charger les routes!" -ForegroundColor Red
    Write-Host $routeTest -ForegroundColor Red
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  DIAGNOSTIC TERMINE" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Pour demarrer le serveur:" -ForegroundColor Yellow
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Ou utilisez le script:" -ForegroundColor Yellow
Write-Host "  .\demarrer-serveur.bat" -ForegroundColor White
Write-Host ""

