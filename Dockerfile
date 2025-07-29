FROM php:8.1-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    unzip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application code
COPY . .

# Create necessary directories
RUN mkdir -p storage/logs storage/tmp && \
    chmod -R 755 storage

# Expose port
EXPOSE 8080

# Start command
CMD php -S 0.0.0.0:${PORT:-8080} -t public 