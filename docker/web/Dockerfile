FROM undologic/setupcase-base

# Base images includes many common linux libraries > If you want any extra you can optionally add them here
#RUN apt-get update && apt-get install -y \
#    && rm -rf /var/lib/apt/lists/*

# Add code to copy in from windows into the container here
ENV APP_DIR=/var/www/vhosts/website.com/www/sourceFiles \
    SEED_DIR=/sourceFiles
# Optional: create the target dir so 'cp' has a place to go
RUN mkdir -p "$APP_DIR"
# Add the tiny entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]



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