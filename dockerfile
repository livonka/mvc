FROM  php:7.3-apache-stretch

WORKDIR /var/www/html

RUN a2enmod rewrite

#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN apt-get update && apt-get install -y unzip

RUN docker-php-ext-install pdo_mysql \
 && sed -i 's/\;extension=pdo_mysql/extension=pdo_mysql/' /usr/local/etc/php/php.ini-production \
 && sed -i 's/\;extension=pdo_mysql/extension=pdo_mysql/' /usr/local/etc/php/php.ini-development
