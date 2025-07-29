FROM php:8.1-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos de dependencias
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Copiar código de la aplicación
COPY . .

# Crear directorios necesarios
RUN mkdir -p storage/logs storage/tmp

# Dar permisos de escritura
RUN chmod -R 755 storage

# Exponer puerto
EXPOSE 8000

# Comando de inicio
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"] 