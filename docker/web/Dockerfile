FROM undologic/setupcase-base

# Base images includes many common linux libraries > If you want any extra you can optionally add them here
#RUN apt-get update && apt-get install -y \
#    && rm -rf /var/lib/apt/lists/*

########### Initial webroot directory ##################
RUN mkdir -p /var/www/vhosts/website.com/www/sourceFiles
RUN echo '<!DOCTYPE html><html><head><title>Welcome</title></head><body><h1>Welcome to website.com!</h1></body></html>' > /var/www/vhosts/website.com/www/sourceFiles/index.html
RUN chmod 777 -R /var/www/vhosts/website.com/www/sourceFiles

# Add code to copy in from windows into the container here

########## Set up Composer #################
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

########### SSH Setup ################
RUN mkdir -p /var/run/sshd
RUN echo "root:root" | chpasswd
RUN echo "PermitRootLogin yes" >> /etc/ssh/sshd_config
RUN echo "PasswordAuthentication yes" >> /etc/ssh/sshd_config
EXPOSE 22

# Ensure CUPS and SSH start on container run & add printer dynamically
CMD service ssh start && \
    apache2-foreground