ARG TARGET_PHP_VERSION=7.2
FROM php:${TARGET_PHP_VERSION}-fpm

LABEL Component="php-fpm" \
      Name="php-fpm-${TARGET_PHP_VERSION}" \
      version="${TARGET_PHP_VERSION}" \
      release="1.0.0" \
      author="JanoPL"

COPY ./php-fpm/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/

ARG TZ=UTC
RUN /tmp/scripts/set-timezone.sh ${TZ}

# add users
ARG APP_USER=www-data
ARG APP_GROUP=www-data
ARG APP_USER_ID=1000
ARG APP_GROUP_ID=1000

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}
RUN /tmp/scripts/php_extension_install.sh
RUN /tmp/scripts/install_software.sh

COPY ./php-fpm/config/php/* /usr/local/etc/php/conf.d/

COPY ./php-fpm/config/php-fpm/* /usr/local/etc/php-fpm.d/

ARG APP_CODE_PATH_HOST="/usr/share/nginx/html"
WORKDIR ${APP_CODE_PATH_HOST}

RUN mkdir -p /bin/docker-entrypoint/ \
 && cp /tmp/scripts/resolve-docker-host-ip.sh /bin/docker-entrypoint/ \
 && chmod +x -R /bin/docker-entrypoint/

ENTRYPOINT ["/bin/docker-entrypoint/resolve-docker-host-ip.sh","php-fpm"]
EXPOSE 9000
