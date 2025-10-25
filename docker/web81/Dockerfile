FROM undologic/setupcase-base

RUN a2enmod rewrite
RUN a2enmod ssl

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
        subversion \
        curl \
        imagemagick \
        libcurl4-gnutls-dev \
        --no-install-recommends \
        libmagickwand-dev \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql curl sockets mysqli

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

########## Set up Composer #################
ENV HOME=/root
ENV COMPOSER_HOME=/root/.composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer --version


EXPOSE 80
EXPOSE 443