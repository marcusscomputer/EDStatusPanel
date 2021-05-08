FROM debian:stretch

LABEL Component="apache" \
      Name="debian/apache-debian-stretch" \
      version="1.0.0" \
      release="1"

RUN DEBIAN_FRONTEND=noninteractive

RUN apt-get update &&\
    apt-get upgrade -y &&\
    apt-get install -y tzdata &&\
    apt-get install -y \
    wget apt-transport-https lsb-release ca-certificates apt-utils acl nano iproute2

RUN \
  apt-get -yqq install apt-transport-https lsb-release ca-certificates && \
  wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
  echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list && \
  apt-get -qq update && apt-get -qqy upgrade

ARG TARGET_PHP_VERSION=8.0
RUN apt-get update &&\
    apt-get upgrade -y &&\
    apt-get install -y \
    apache2 php${TARGET_PHP_VERSION} php${TARGET_PHP_VERSION}-apcu php${TARGET_PHP_VERSION}-mbstring php${TARGET_PHP_VERSION}-curl php${TARGET_PHP_VERSION}-gd \
    php${TARGET_PHP_VERSION}-imagick php${TARGET_PHP_VERSION}-intl php${TARGET_PHP_VERSION}-bcmath \
    php${TARGET_PHP_VERSION}-mysql php${TARGET_PHP_VERSION}-xdebug php${TARGET_PHP_VERSION}-xml php${TARGET_PHP_VERSION}-zip curl

# apache2 enviroment path￼

ENV APACHE_CONFDIR /etc/apache2
ENV APACHE_ENVVARS $APACHE_CONFDIR/envvars
RUN set -ex \
    && . "$APACHE_ENVVARS" \
    && ln -sfT /dev/stderr "$APACHE_LOG_DIR/error.log" \
    && ln -sfT /dev/stdout "$APACHE_LOG_DIR/access.log" \
    && ln -sfT /dev/stdout "$APACHE_LOG_DIR/other_vhosts_access.log"

# apache mods enable
RUN a2enmod rewrite \
    && a2enmod headers \
    && a2enmod expires

EXPOSE 80

WORKDIR /var/www/html

ARG PUID=33
ARG PGID=33
RUN groupmod -g $PGID www-data \
    && usermod -u $PUID www-data
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/html
RUN chmod 755 /var/www/html
# Laravel permission storage and bootstrap
#RUN chown -R $USER:www-data /var/www/html/storage /var/www/html/bootstrap/cache
#RUN chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
#RUN chmod -R ug+rwx /var/www/html/storage var/www/html/bootstrap/cache

## Composer Install
#RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer \
#&& composer global require hirak/prestissimo --no-plugins --no-scripts

COPY ./apache/config/apache.conf /etc/apache2/sites-available/000-default.conf

COPY ./apache/config/.htaccess /tmp/.htaccess
RUN ["cp", "/tmp/.htaccess", "/var/www/html"]

CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]