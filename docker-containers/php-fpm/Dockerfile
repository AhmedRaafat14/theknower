FROM php:7.3-fpm

RUN apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y vim openssh-server zlib1g-dev libpq-dev git libicu-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install mysqli pdo_mysql pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip xml

# Install composer: Remove the --version or update it once symfon/flex updated to support composer ^2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.7.2

# Will uese the script to wait untill the application be up so we can run
# composer install or Db migration commands: https://github.com/vishnubob/wait-for-it
COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime
RUN "date"

WORKDIR /var/www/theknower

CMD ["php-fpm"]

# Using the `wait-for-it` script
CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm

EXPOSE 9000
