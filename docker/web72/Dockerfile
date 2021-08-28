FROM php:7.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
        dvtm \
        dtach \
        dos2unix \
        wkhtmltopdf \
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
        subversion \
        curl \
        imagemagick \
        libcurl4-gnutls-dev \
        --no-install-recommends \
        libmagickwand-dev \
    && rm -r /var/lib/apt/lists/* \
    && pecl install imagick-3.4.3 \
    && docker-php-ext-enable imagick

RUN docker-php-ext-install pdo pdo_mysql curl sockets mysqli

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap