FROM php:8.1-cli

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar todo el código
COPY . .

# Instalar dependencias
RUN composer install --no-dev

# Comando de inicio
CMD php -S 0.0.0.0:$PORT -t public 