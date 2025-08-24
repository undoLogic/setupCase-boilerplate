FROM undologic/setupcase-base

# Base images includes many common linux libraries > If you want any extra you can optionally add them here
#RUN apt-get update && apt-get install -y \
#    && rm -rf /var/lib/apt/lists/*

########## Set up Composer #################
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

########### SSH Setup ################
RUN mkdir -p /var/run/sshd
RUN echo "root:root" | chpasswd
RUN echo "PermitRootLogin yes" >> /etc/ssh/sshd_config
RUN echo "PasswordAuthentication yes" >> /etc/ssh/sshd_config
EXPOSE 22


# Make all SetupCase files exec
#RUN chmod +x /var/www/vhosts/website.com/www/setupCase*

WORKDIR /var/www/vhosts/website.com/www

# Ensure CUPS and SSH start on container run & add printer dynamically
CMD service ssh start && \
    apache2-foreground