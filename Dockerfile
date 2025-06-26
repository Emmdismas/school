FROM php:8.2-cli

# Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm python3 python3-pip supervisor \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath xml

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copy Laravel project and bot
COPY . .

# Install Laravel dependencies
RUN composer install
RUN npm install
RUN npm run build
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Install Python bot dependencies
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose Laravel port
EXPOSE 10000

# Start Supervisor to run both Laravel and the bot
CMD ["/usr/bin/supervisord"]
