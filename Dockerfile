FROM php:8.2-apache

# Install PHP extensions & system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libonig-dev libxml2-dev \
    python3 python3-pip supervisor \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath xml

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage \
 && chmod -R 775 /var/www/html/bootstrap/cache

# Install Python dependencies for WhatsApp bot
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose Apache port
EXPOSE 80

# Start Laravel (Apache) + WhatsApp bot
CMD ["/usr/bin/supervisord"]
