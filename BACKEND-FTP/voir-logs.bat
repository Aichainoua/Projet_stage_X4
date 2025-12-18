@echo off
REM Script batch pour voir les dernières lignes des logs Laravel
REM Usage: voir-logs.bat

echo Lecture des dernieres lignes du fichier de log...
echo.

if exist "storage\logs\laravel.log" (
    powershell -Command "Get-Content 'storage\logs\laravel.log' -Tail 50"
) else (
    echo Fichier de log introuvable: storage\logs\laravel.log
    echo Assurez-vous d'executer ce script depuis le repertoire BACKEND-FTP
)

pause

