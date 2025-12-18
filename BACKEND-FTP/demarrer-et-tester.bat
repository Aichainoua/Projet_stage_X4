@echo off
echo ========================================
echo   DEMARRAGE ET TEST SERVEUR LARAVEL
echo ========================================
echo.

REM Lancer le diagnostic d'abord
echo [1/2] Execution du diagnostic...
echo.
powershell -ExecutionPolicy Bypass -File "diagnostic-complet.ps1"
echo.

REM Test du bootstrap
echo [2/2] Test du bootstrap Laravel...
echo.
php test-bootstrap.php
echo.

echo ========================================
echo   DEMARRAGE DU SERVEUR
echo ========================================
echo.
echo Le serveur va demarrer dans 3 secondes...
timeout /t 3 /nobreak >nul

php artisan serve

