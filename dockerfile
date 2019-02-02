FROM  php:7.3-apache-stretch

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

#RUN apt-get update && apt-get install -y git
#RUN apt-get install -y unzip
#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#        && php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
#        && php composer-setup.php --install-dir=/var/www/html \
#        && php -r "unlink('composer-setup.php');"

#RUN composer require --dev phpunit/phpunit ^7
