#!/usr/bin/env bash

set -e

# Create www-data if missing
if ! id www-data &>/dev/null; then
    sudo groupadd -g 33 www-data
    sudo useradd -u 33 -g www-data -s /usr/sbin/nologin www-data
fi

# Ensure developer is in group
sudo usermod -aG www-data "$USER"
