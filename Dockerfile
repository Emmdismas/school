FROM php:8.2-apache

# Install PHP and system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libonig-dev libxml2-dev \
    python3 python3-pip supervisor \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath xml

RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy everything into container
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage \
 && chmod -R 775 /var/www/html/bootstrap/cache

# ===================================================================
# OPTION 1: default - run directly from current context (comment if using option 2)
# ===================================================================
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

# ===================================================================
# OPTION 2: force copy the file separately and run install (uncomment to test)
# WORKDIR /var/www/html/whatsapp_bot
# COPY whatsapp_bot/requirements.txt .
# RUN pip3 install -r requirements.txt
# ===================================================================

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose Apache port
EXPOSE 80

# Start Supervisor
CMD ["/usr/bin/supervisord"]
