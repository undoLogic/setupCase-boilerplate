FROM undologic/setupcase-base

# Install necessary packages
RUN apt-get update && apt-get install -y \
    inetutils-ping \
    cups cups-client cups-bsd \
    nano \
    git \
    openssh-server \
    && rm -rf /var/lib/apt/lists/*

# Set permissions for tmp directory
RUN chmod 777 -R /var/www/vhosts/website.com/www/sourceFiles

########### SSH Setup ################
RUN mkdir -p /var/run/sshd
RUN echo "root:root" | chpasswd
RUN echo "PermitRootLogin yes" >> /etc/ssh/sshd_config
RUN echo "PasswordAuthentication yes" >> /etc/ssh/sshd_config
EXPOSE 22

# allow pdf to work with Image Magick
RUN sed -i 's|<policy domain="coder" rights="none" pattern="PDF" />|<policy domain="coder" rights="read\|write" pattern="PDF" />|' /etc/ImageMagick-6/policy.xml

# Ensure CUPS and SSH start on container run & add printer dynamically
CMD service ssh start && \
    apache2-foreground