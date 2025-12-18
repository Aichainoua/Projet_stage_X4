@echo off
echo ========================================
echo   Demarrage du serveur Laravel
echo ========================================
echo.

REM Vérifier si PHP est installé
php --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: PHP n'est pas installe ou n'est pas dans le PATH
    echo.
    pause
    exit /b 1
)

echo PHP detecte, version:
php --version
echo.

REM Vérifier si le fichier artisan existe
if not exist "artisan" (
    echo ERREUR: Le fichier artisan est introuvable
    echo Assurez-vous d'executer ce script depuis le dossier BACKEND-FTP
    echo.
    pause
    exit /b 1
)

echo Demarrage du serveur Laravel sur http://127.0.0.1:8000
echo Appuyez sur Ctrl+C pour arreter le serveur
echo.
echo Testez ces URLs dans votre navigateur:
echo   - http://localhost:8000/test-simple.php
echo   - http://localhost:8000/api/ping
echo   - http://localhost:8000
echo.

php artisan serve

