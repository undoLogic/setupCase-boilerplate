# FROM undologic/php5
FROM php:5.6-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
        dvtm \
        dtach \
        unzip \
		vim \
		wkhtmltopdf \
		git \
		zip \
		unzip \
		dos2unix \
		mysql-client \
		#mysql-server \
		subversion \
		#mysqli \
		curl \
		libcurl4-gnutls-dev \
		libkrb5-dev \
		libc-client-dev \
		#php5-imap \
		libmcrypt-dev \
		libmagickwand-dev \
		imagemagick \
--no-install-recommends && rm -r /var/lib/apt/lists/* \
    && pecl install imagick-3.4.3 \
    && docker-php-ext-enable imagick

RUN docker-php-ext-install pdo pdo_mysql curl sockets mysqli

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

#required for the 3des encryption
RUN docker-php-ext-configure mcrypt
RUN docker-php-ext-install mcrypt

#RUN php5enmod imap

#COPY ./config/php.ini /usr/local/etc/php/

#@todo copy the files into the image - maybe later
#COPY ./files/. /var/www/vhosts/website.com/www/
#ADD  ../../back-end/. /var/www/vhosts/website.com/www/


# only if you need ssl
#RUN cd /etc/apache2/sites-available && a2ensite default-ssl.conf
#RUN a2enmod ssl

# RUN cd /var/www/vhosts/novaAssure.com/www/ && ./app/Console/cake ListenerTzAvlTcp &
# RUN cd /var/www/vhosts/novaAssure.com/www/ && ./app/Console/cake ListenerFj1000Udp &

# Set the working directory to /app
# WORKDIR /app

# Copy the current directory contents into the container at /app
# ADD . /app

# Install any needed packages specified in requirements.txt
# RUN pip install --trusted-host pypi.python.org -r requirements.txt

# Make port 80 available to the world outside this container
EXPOSE 80
EXPOSE 143
EXPOSE 993
EXPOSE 25
#EXPOSE 443

# EXPOSE 8109
# EXPOSE 8107

# Define environment variable
# ENV NAME World

# Run app.py when the container launches
# CMD ["python", "app.py"]
