# Image PHP légère avec CLI (pas besoin d'Apache/Nginx séparé)
FROM php:8.3-cli-alpine

# Dépendances système + extensions PHP nécessaires à Laravel
RUN apk add --no-cache \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Installe Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copie tout le projet
COPY . .

# Installe les dépendances PHP (sans les paquets de dev, optimisé)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Droits d'écriture nécessaires pour Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Au démarrage : migre la base (si besoin) puis lance le serveur
# Railway fournit automatiquement la variable $PORT
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
