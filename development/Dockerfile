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
RUN mkdir -p /root/.config/code-server && \
    echo "bind-addr: 0.0.0.0:8080\n" \
         "auth:password\n" \
         "password:devpass\n" \
         "cert:false\n" \
         > /root/.config/code-server/config.yaml

# --- Set working directory ---
WORKDIR /workspace

# --- Expose ports ---
EXPOSE 80 5901 8080

# --- Run both VNC desktop and code-server ---
CMD /startup.sh & \
    /usr/bin/code-server --config /root/.config/code-server/config.yaml --bind-addr 0.0.0.0:8080
