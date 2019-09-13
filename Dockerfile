FROM php:7.2-fpm

WORKDIR /var/www

# Install stuff.
RUN apt-get update
RUN apt-get install -y zip unzip git libmcrypt-dev
RUN docker-php-ext-install pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Use this for "production".
COPY . .
# Use this during app development.
#VOLUME . .

# Run some commands to setup the project.
RUN chmod -R 777 .
RUN cp .env.example .env
RUN useradd userToRunComposer
USER userToRunComposer
RUN composer install
