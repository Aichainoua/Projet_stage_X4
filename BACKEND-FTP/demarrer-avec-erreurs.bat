@echo off
echo ========================================
echo   DEMARRAGE AVEC AFFICHAGE DES ERREURS
echo ========================================
echo.
echo Ce script va demarrer le serveur et afficher toutes les erreurs
echo.
pause

echo.
echo [1/3] Nettoyage du cache...
php artisan config:clear 2>&1
php artisan cache:clear 2>&1
echo OK
echo.

echo [2/3] Test de connexion a la base de donnees...
php test-connection-db.php
echo.

echo [3/3] Demarrage du serveur avec affichage des erreurs...
echo.
echo Les erreurs s'afficheront ci-dessous:
echo Appuyez sur Ctrl+C pour arreter
echo.
echo ========================================
echo.

REM Démarrer avec affichage des erreurs
php -d display_errors=1 -d error_reporting=E_ALL artisan serve --host=127.0.0.1 --port=8000

pause


