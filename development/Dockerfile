FROM dorowu/ubuntu-desktop-lxde-vnc

# --- Disable broken Chrome repo ---
RUN rm -f /etc/apt/sources.list.d/google-chrome.list

# --- Install base tools ---
RUN apt-get update && \
    apt-get install -y curl git vim wget && \
    apt-get clean

# --- Install code-server (VS Code in browser) ---
RUN curl -fsSL https://code-server.dev/install.sh | sh

# --- Configure code-server ---
# --- Configure code-server ---
RUN mkdir -p /root/.config/code-server && \
    cat << 'EOF' > /root/.config/code-server/config.yaml
bind-addr: 0.0.0.0:8080
auth: password
password: devpass
cert: false
EOF

# --- Set working directory ---
WORKDIR /workspace

# --- Expose ports ---
EXPOSE 80 5901 8080

# --- Start both VNC desktop and code-server ---
CMD /startup.sh & \
    exec /usr/bin/code-server --config /root/.config/code-server/config.yaml --bind-addr 0.0.0.0:8080

