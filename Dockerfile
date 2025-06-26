FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm python3 python3-pip supervisor \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath xml

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY . .

RUN composer install
RUN npm install
RUN npm run build

# ⚠️ Usijaribu ku-cache config hapa
# RUN php artisan config:cache ...

WORKDIR /var/www/html/whatsapp_bot
RUN pip3 install -r requirements.txt

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 10000
CMD ["/usr/bin/supervisord"]
