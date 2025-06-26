# Base image with PHP, Composer, Node, npm, and Python
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev \
    php-mysql php-pgsql php-mbstring php-xml php-bcmath php-curl \
    nodejs npm python3 python3-pip supervisor

# Set working directory for Laravel
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copy entire Laravel app (since it's in root) + bot folder
COPY . .

# Install Laravel dependencies
RUN composer install
RUN npm install
RUN npm run build
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Install bot dependencies
WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose Laravel port
EXPOSE 10000

# Start Laravel and WhatsApp bot
CMD ["/usr/bin/supervisord"]
