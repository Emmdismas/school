# ================================
# Base PHP image with Apache
# ================================
FROM php:8.2-apache

# ================================
# Install PHP Extensions + Python + Supervisor
# ================================
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libonig-dev libxml2-dev \
    python3 python3-pip supervisor \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath xml

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# ================================
# Set working directory for Laravel
# ================================
WORKDIR /var/www/html

# ================================
# Copy all project files
# ================================
COPY . .

# ================================
# Install Composer
# ================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# ================================
# Set Laravel Permissions
# ================================
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage \
 && chmod -R 775 /var/www/html/bootstrap/cache

# ================================
# OPTION 1: Default – Install Python dependencies directly from current context
# (Note: works only if whatsapp_bot/requirements.txt is already copied)
# ================================
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install --upgrade pip
RUN pip3 install -r requirements.txt

# ================================
# OPTION 2: (Uncomment these lines to use this method if above fails)
# RUN mkdir -p /var/www/html/whatsapp_bot
# COPY whatsapp_bot/requirements.txt /var/www/html/whatsapp_bot/requirements.txt
# WORKDIR /var/www/html/whatsapp_bot
# RUN pip3 install --upgrade pip
# RUN pip3 install -r requirements.txt
# ================================

# ================================
# Copy Supervisor config
# ================================
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ================================
# Expose Apache Port
# ================================
EXPOSE 80

# ================================
# Start Supervisor (manages both Apache and Python bot)
# ================================
CMD ["/usr/bin/supervisord"]
