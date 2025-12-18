# Script pour vérifier la connexion PostgreSQL
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  VERIFICATION POSTGRESQL" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si PostgreSQL est installé
Write-Host "[1/4] Verification de PostgreSQL..." -ForegroundColor Yellow
$pgPath = Get-Command psql -ErrorAction SilentlyContinue
if ($pgPath) {
    Write-Host "  OK - PostgreSQL est installe" -ForegroundColor Green
    Write-Host "  Chemin: $($pgPath.Source)" -ForegroundColor Gray
} else {
    Write-Host "  ATTENTION - psql non trouve dans le PATH" -ForegroundColor Yellow
    Write-Host "  PostgreSQL peut etre installe mais pas dans le PATH" -ForegroundColor Gray
}

# Vérifier si le service PostgreSQL tourne
Write-Host "[2/4] Verification du service PostgreSQL..." -ForegroundColor Yellow
$pgService = Get-Service -Name "*postgresql*" -ErrorAction SilentlyContinue
if ($pgService) {
    foreach ($service in $pgService) {
        $status = if ($service.Status -eq 'Running') { "OK" } else { "ARRETE" }
        $color = if ($service.Status -eq 'Running') { "Green" } else { "Red" }
        Write-Host "  Service: $($service.Name) - Status: $status" -ForegroundColor $color
    }
} else {
    Write-Host "  ATTENTION - Service PostgreSQL non trouve" -ForegroundColor Yellow
    Write-Host "  (Peut etre normal si PostgreSQL n'est pas installe comme service Windows)" -ForegroundColor Gray
}

# Lire la configuration .env
Write-Host "[3/4] Lecture de la configuration .env..." -ForegroundColor Yellow
if (Test-Path ".env") {
    $envContent = Get-Content .env -Raw
    
    $dbConnection = ($envContent | Select-String "DB_CONNECTION=([^\r\n]+)").Matches[0].Groups[1].Value
    $dbHost = ($envContent | Select-String "DB_HOST=([^\r\n]+)").Matches[0].Groups[1].Value
    $dbPort = ($envContent | Select-String "DB_PORT=([^\r\n]+)").Matches[0].Groups[1].Value
    $dbDatabase = ($envContent | Select-String "DB_DATABASE=([^\r\n]+)").Matches[0].Groups[1].Value
    $dbUsername = ($envContent | Select-String "DB_USERNAME=([^\r\n]+)").Matches[0].Groups[1].Value
    
    Write-Host "  DB_CONNECTION: $dbConnection" -ForegroundColor Cyan
    Write-Host "  DB_HOST: $dbHost" -ForegroundColor Cyan
    Write-Host "  DB_PORT: $dbPort" -ForegroundColor Cyan
    Write-Host "  DB_DATABASE: $dbDatabase" -ForegroundColor Cyan
    Write-Host "  DB_USERNAME: $dbUsername" -ForegroundColor Cyan
    
    if ($dbConnection -eq "pgsql") {
        Write-Host ""
        Write-Host "  ⚠ ATTENTION - PostgreSQL est configure!" -ForegroundColor Yellow
        Write-Host "  Si PostgreSQL n'est pas accessible, Laravel peut bloquer au demarrage" -ForegroundColor Yellow
    }
} else {
    Write-Host "  ERREUR - Fichier .env introuvable" -ForegroundColor Red
}

# Tester la connexion
Write-Host "[4/4] Test de connexion..." -ForegroundColor Yellow
if ($dbConnection -eq "pgsql" -and $dbHost -and $dbDatabase) {
    Write-Host "  Tentative de connexion a PostgreSQL..." -ForegroundColor Gray
    
    # Test avec psql si disponible
    if ($pgPath) {
        $pgTest = & psql -h $dbHost -p $dbPort -U $dbUsername -d $dbDatabase -c "SELECT version();" 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "  ✓ OK - Connexion PostgreSQL reussie" -ForegroundColor Green
        } else {
            Write-Host "  ✗ ERREUR - Impossible de se connecter a PostgreSQL" -ForegroundColor Red
            Write-Host "  Message: $pgTest" -ForegroundColor Gray
            Write-Host ""
            Write-Host "  SOLUTIONS:" -ForegroundColor Yellow
            Write-Host "  1. Verifiez que PostgreSQL est demarre" -ForegroundColor White
            Write-Host "  2. Verifiez les identifiants dans .env" -ForegroundColor White
            Write-Host "  3. Utilisez SQLite temporairement: DB_CONNECTION=sqlite" -ForegroundColor White
        }
    } else {
        Write-Host "  ⚠ Impossible de tester (psql non trouve)" -ForegroundColor Yellow
    }
} else {
    Write-Host "  Configuration PostgreSQL incomplete" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  SOLUTION RAPIDE" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Si PostgreSQL cause des problemes, utilisez SQLite temporairement:" -ForegroundColor Yellow
Write-Host ""
Write-Host "Dans le fichier .env, changez:" -ForegroundColor White
Write-Host "  DB_CONNECTION=pgsql" -ForegroundColor Gray
Write-Host "  En:" -ForegroundColor White
Write-Host "  DB_CONNECTION=sqlite" -ForegroundColor Green
Write-Host ""
Write-Host "Puis commentez les lignes DB_HOST, DB_PORT, etc." -ForegroundColor White
Write-Host ""

