# Script PowerShell pour voir les logs Laravel en temps réel
# Usage: .\voir-logs.ps1

$logFile = "storage\logs\laravel.log"

if (Test-Path $logFile) {
    Write-Host "Lecture des dernières lignes du fichier de log..." -ForegroundColor Green
    Write-Host "Appuyez sur Ctrl+C pour quitter`n" -ForegroundColor Yellow
    
    # Afficher les 50 dernières lignes
    Get-Content $logFile -Tail 50
    
    Write-Host "`nSurveillance en cours (nouveaux logs)...`n" -ForegroundColor Cyan
    
    # Surveiller le fichier pour les nouvelles lignes
    Get-Content $logFile -Wait -Tail 10
} else {
    Write-Host "Fichier de log introuvable: $logFile" -ForegroundColor Red
    Write-Host "Assurez-vous d'exécuter ce script depuis le répertoire BACKEND-FTP" -ForegroundColor Yellow
}

