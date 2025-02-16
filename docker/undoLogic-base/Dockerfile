FROM php:8.1-apache

# Enable Apache Modules
RUN a2enmod rewrite ssl headers

# Update and Install Dependencies
RUN apt-get update && apt-get install -y \
    lpr \
    qrencode \
    wkhtmltopdf \
    dos2unix \
    zip \
    unzip \
    rsync \
    mariadb-client \
    curl \
    libc-client-dev \
    screen \
    vim \
    git \
    imagemagick \
    libmagickwand-dev \
    libkrb5-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    libxslt1-dev \
    && rm -r /var/lib/apt/lists/*

# Install PHP Extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl

# Expose Ports
EXPOSE 80
EXPOSE 443
