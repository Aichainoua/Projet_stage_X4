# Guide de dépannage - Serveur Laravel en attente

## Problèmes courants et solutions

### 1. Vérifier que le serveur est démarré

```bash
cd BACKEND-FTP
php artisan serve
```

Vous devriez voir :
```
INFO  Server running on [http://127.0.0.1:8000]
```

### 2. Vérifier que le port 8000 n'est pas déjà utilisé

Si le port est occupé, utilisez un autre port :
```bash
php artisan serve --port=8001
```

### 3. Vérifier le fichier .env

Assurez-vous que le fichier `.env` existe et contient au minimum :
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:... (doit être généré avec php artisan key:generate)
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# ou
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Générer la clé d'application

Si `APP_KEY` est vide :
```bash
php artisan key:generate
```

### 5. Nettoyer le cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 6. Vérifier les logs

**Sur Windows (PowerShell)** :
```powershell
# Voir les 50 dernières lignes
Get-Content storage\logs\laravel.log -Tail 50

# Surveiller en temps réel (comme tail -f)
Get-Content storage\logs\laravel.log -Wait -Tail 10

# Ou utilisez le script fourni
.\voir-logs.ps1
```

**Sur Linux/Mac** :
```bash
tail -f storage/logs/laravel.log
```

**Alternative Windows (lecture simple)** :
```cmd
type storage\logs\laravel.log
```

### 7. Tester avec une route simple

Accédez à : `http://localhost:8000/api/ping`

Cela devrait retourner immédiatement un JSON sans dépendances.

### 8. Vérifier les permissions

Sur Linux/Mac, assurez-vous que les dossiers sont accessibles :
```bash
chmod -R 775 storage bootstrap/cache
```

### 9. Vérifier les erreurs PHP

Activer l'affichage des erreurs dans `php.ini` :
```ini
display_errors = On
error_reporting = E_ALL
```

### 10. Si le problème persiste

1. Arrêtez le serveur (Ctrl+C)
2. Vérifiez les logs : `storage/logs/laravel.log`
3. Testez avec : `php artisan route:list` pour voir si les routes sont chargées
4. Testez : `php artisan config:show app` pour vérifier la configuration

## Routes de test disponibles

- `GET /api/ping` - Test simple sans dépendances
- `GET /api/test` - Test avec AuthController
- `GET /` - Page d'accueil avec redirection

## Commandes Windows utiles

### Voir les logs
```powershell
# Dernières 50 lignes
Get-Content storage\logs\laravel.log -Tail 50

# Surveiller en temps réel
Get-Content storage\logs\laravel.log -Wait -Tail 10

# Chercher des erreurs
Get-Content storage\logs\laravel.log | Select-String "error" -CaseSensitive
```

### Démarrer le serveur
```powershell
php artisan serve
# ou sur un port spécifique
php artisan serve --port=8001
```

### Vérifier si le port est utilisé
```powershell
netstat -ano | findstr :8000
```

