# On part d'une image PHP officielle
FROM php:8.2-fpm

# Installation des extensions système nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Nettoyage du cache pour réduire la taille de l'image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer (le gestionnaire de paquets PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# On définit le dossier de travail
WORKDIR /var/www

# On copie tout ton dossier BACKEND-FTP dans le conteneur
COPY . .

# On installe les dépendances Laravel
RUN composer install

# On expose le port 8000
EXPOSE 8000

# La commande pour lancer le serveur
CMD php artisan serve --host=0.0.0.0 --port=8000