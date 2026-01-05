FROM undologic/setupcase-base

ARG UID=1000
ARG GID=1000

# Ensure www-data matches host UID/GID
RUN groupmod -g ${GID} www-data \
 && usermod -u ${UID} www-data

# Enable Apache modules
RUN a2enmod rewrite ssl

# System packages
RUN apt-get update && apt-get install -y \
        dos2unix \
        zip \
        unzip \
        rsync \
        mariadb-client \
        subversion \
        curl \
        libcurl4-gnutls-dev \
        libkrb5-dev \
        libc-client-dev \
        screen \
        vim \
        git \
        imagemagick \
        libmagickwand-dev \
        --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql curl sockets mysqli

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
 && docker-php-ext-install imap

RUN apt-get update \
 && apt-get install -y libicu-dev \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl \
 && rm -rf /var/lib/apt/lists/*

# ---- Composer (install as root, run as www-data) ----
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && composer --version

# Fix HOME for www-data
ENV HOME=/var/www

WORKDIR /var/www/vhosts/website.com/www

USER www-data

EXPOSE 80
EXPOSE 443
