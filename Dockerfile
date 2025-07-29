FROM php:8.1-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos de dependencias
COPY composer.json composer.lock ./

# Instalar dependencias (sin optimizar para evitar errores)
RUN composer install --no-dev

# Copiar código de la aplicación
COPY . .

# Crear directorios necesarios y dar permisos
RUN mkdir -p storage/logs storage/tmp && \
    chmod -R 755 storage

# Comando de inicio
CMD php -S 0.0.0.0:$PORT -t public 