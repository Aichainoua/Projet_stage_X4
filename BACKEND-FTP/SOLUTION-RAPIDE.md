# SOLUTION RAPIDE - Serveur en attente

## Problème
Le serveur reste "en attente" quand vous ouvrez http://localhost:8000

## Solution ÉTAPE PAR ÉTAPE

### ÉTAPE 1 : Vérifier l'erreur exacte

**Option A - Script automatique :**
```powershell
.\demarrer-avec-erreurs.bat
```

**Option B - Manuellement :**
```powershell
# Nettoyer le cache
php artisan config:clear
php artisan cache:clear

# Tester la connexion DB
php test-connection-db.php

# Démarrer avec affichage des erreurs
php -d display_errors=1 artisan serve
```

### ÉTAPE 2 : Si l'erreur concerne PostgreSQL

**Solution temporaire (pour tester) :**

1. Ouvrez le fichier `.env`
2. Changez :
   ```env
   DB_CONNECTION=pgsql
   ```
   En :
   ```env
   DB_CONNECTION=sqlite
   ```
3. Commentez les lignes PostgreSQL :
   ```env
   # DB_HOST=127.0.0.1
   # DB_PORT=5432
   # DB_DATABASE=...
   # DB_USERNAME=...
   # DB_PASSWORD=...
   ```
4. Nettoyez le cache :
   ```powershell
   php artisan config:clear
   ```
5. Redémarrez :
   ```powershell
   php artisan serve
   ```

### ÉTAPE 3 : Si vous devez utiliser PostgreSQL

**Vérifiez que PostgreSQL fonctionne :**

1. **Démarrez PostgreSQL :**
   - Ouvrez les Services Windows (touche Windows + R, tapez `services.msc`)
   - Cherchez "PostgreSQL"
   - Clic droit → Démarrer

2. **Vérifiez la connexion :**
   ```powershell
   php test-connection-db.php
   ```

3. **Vérifiez les identifiants dans `.env` :**
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=nom_exact_de_votre_base
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   ```

### ÉTAPE 4 : Vérifier les logs

```powershell
Get-Content storage\logs\laravel.log -Tail 50
```

## Erreurs courantes

### Erreur : "Connection refused" ou "Connection timed out"
→ PostgreSQL n'est pas démarré ou mauvais port

### Erreur : "Authentication failed"
→ Mauvais identifiants dans `.env`

### Erreur : "Database does not exist"
→ La base de données n'existe pas, créez-la

### Pas d'erreur mais reste en attente
→ Probablement une connexion PostgreSQL qui bloque
→ Solution : Utilisez SQLite temporairement

## Commandes utiles

```powershell
# Voir les dernières erreurs
Get-Content storage\logs\laravel.log -Tail 30

# Tester la connexion DB
php test-connection-db.php

# Nettoyer tout
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Démarrer avec erreurs visibles
php -d display_errors=1 artisan serve
```


