#!/bin/bash

# add wget
apt-get update -yqq && apt-get -f install -yyq wget

FILE=/tmp/scripts/install-php-extensions.sh

# Check the online script
status="$(curl -Is https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions | head -1)";
validate=($status);
if [ "${validate[-2]}" == "200" ]; then
  wget -q -O /usr/local/bin/install-php-extensions https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions \
      || (echo "Failed while downloading php extension installer!"; exit 1);
else
  cp /tmp/scripts/install-php-extensions.sh /usr/local/bin/install-php-extensions
fi

# install extensions
chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
    zip \
    xml \
    fileinfo \
;