# Diagnostic - Serveur ne répond pas

## Étape par étape pour résoudre le problème

### ÉTAPE 1 : Vérifier que PHP fonctionne

Ouvrez PowerShell dans le dossier `BACKEND-FTP` et tapez :
```powershell
php --version
```

Si vous obtenez une erreur, PHP n'est pas installé ou pas dans le PATH.

### ÉTAPE 2 : Démarrer le serveur CORRECTEMENT

**Méthode 1 : Utiliser le script batch fourni**
1. Double-cliquez sur `demarrer-serveur.bat`
2. Un terminal s'ouvrira
3. Vous devriez voir : `Server running on [http://127.0.0.1:8000]`

**Méthode 2 : Manuellement dans PowerShell**
```powershell
cd BACKEND-FTP
php artisan serve
```

⚠️ **IMPORTANT** : Le terminal doit rester ouvert. Si vous le fermez, le serveur s'arrête !

### ÉTAPE 3 : Tester avec un fichier PHP simple

Pendant que le serveur tourne, ouvrez dans votre navigateur :
```
http://localhost:8000/test-simple.php
```

Si cela fonctionne → PHP et le serveur web fonctionnent
Si cela ne fonctionne pas → Vérifiez que le serveur est bien démarré

### ÉTAPE 4 : Tester les routes Laravel

Une fois que le serveur est démarré, testez dans l'ordre :

1. **Route ultra-simple** :
   ```
   http://localhost:8000/test-direct
   ```
   Doit retourner du JSON immédiatement

2. **Route ping** :
   ```
   http://localhost:8000/api/ping
   ```

3. **Route principale** :
   ```
   http://localhost:8000/
   ```

### ÉTAPE 5 : Vérifier les erreurs

Si rien ne fonctionne, ouvrez un **NOUVEAU terminal PowerShell** et :

```powershell
cd BACKEND-FTP
Get-Content storage\logs\laravel.log -Tail 100
```

Copiez les erreurs et partagez-les.

### ÉTAPE 6 : Vérifier le port

Si le port 8000 est occupé, le serveur essaiera un autre port. Regardez le message dans le terminal qui dit :
```
Server running on [http://127.0.0.1:8000]
```

Utilisez l'URL exacte affichée.

## Problèmes courants

### ❌ "Le serveur ne démarre pas"
- Vérifiez que vous êtes dans le dossier `BACKEND-FTP`
- Vérifiez que `artisan` existe
- Exécutez : `php artisan --version`

### ❌ "Le serveur démarre mais rien ne s'affiche"
- Vérifiez que vous utilisez l'URL EXACTE affichée dans le terminal
- Essayez `http://127.0.0.1:8000` au lieu de `http://localhost:8000`
- Vérifiez votre pare-feu Windows

### ❌ "Page en attente / Timeout"
- Le serveur n'est probablement pas démarré
- Vérifiez que le terminal avec `php artisan serve` est toujours ouvert
- Essayez de redémarrer le serveur

## Commandes utiles

```powershell
# Voir si le port 8000 est utilisé
netstat -ano | findstr :8000

# Vérifier les routes disponibles
php artisan route:list

# Nettoyer le cache
php artisan config:clear
php artisan cache:clear
```

