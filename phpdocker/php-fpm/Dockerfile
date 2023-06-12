FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.2-bcmath \ 
        php8.2-intl \ 
        php8.2-mcrypt \ 
        php8.2-mysql \ 
        php8.2-redis \ 
        php8.2-sqlite3 \ 
        php8.2-xdebug; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN mkdir -p /var/log/apache2/
RUN chown -R www-data:www-data /var/log/apache2/
COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf
