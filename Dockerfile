FROM php:8.1.1-apache

RUN echo "Europe/Berlin" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

ENV APACHE_DOCUMENT_ROOT /var/www/html/web

RUN apt-get update && apt-get install -y ca-certificates gnupg
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -

RUN apt-get update && apt-get upgrade -y && apt-get install -y git nodejs

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN /usr/sbin/a2enmod rewrite && /usr/sbin/a2enmod headers && /usr/sbin/a2enmod expires

RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get install -y libtidy-dev && docker-php-ext-install tidy && docker-php-ext-enable tidy

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'session.save_path = "/tmp"' >> /usr/local/etc/php/php.ini

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN service apache2 restart

WORKDIR /var/www/html/web/github-api

COPY composer.json ./
RUN composer require
COPY ./ ./

EXPOSE 9000

CMD ["apache2-foreground"]
