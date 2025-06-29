FROM php:8.2-apache

# ✅ Install PHP extensions & system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libonig-dev libxml2-dev \
    python3 python3-pip supervisor \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath xml

# ✅ Enable Apache rewrite module
RUN a2enmod rewrite

# ✅ Set working directory for Laravel
WORKDIR /var/www/html

# ✅ Copy entire project (including whatsapp_bot folder)
COPY . /var/www/html/

# ✅ Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# ✅ Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage \
 && chmod -R 775 /var/www/html/bootstrap/cache

# ====================================================================
# ✅ OPTION 1: Recommended – Install Python dependencies AFTER copying full project
# ====================================================================
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

# ====================================================================
# ✅ OPTION 2: Alternative – Install Python dependencies with separate copy
# NOTE: This is commented out to avoid conflict with Option 1
# ====================================================================
# WORKDIR /var/www/html/whatsapp_bot
# COPY whatsapp_bot/requirements.txt .
# RUN pip3 install -r requirements.txt

# ✅ Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ✅ Expose Apache port
EXPOSE 80

# ✅ Start Supervisor to run both Apache and WhatsApp bot
CMD ["/usr/bin/supervisord"]
