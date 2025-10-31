FROM dorowu/ubuntu-desktop-lxde-vnc

# Install dependencies
RUN apt-get update && \
    apt-get install -y wget gpg apt-transport-https software-properties-common curl && \
    # Add Microsoft GPG key
    wget -qO- https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft.gpg && \
    # Add the VS Code repository
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/repos/code stable main" \
        > /etc/apt/sources.list.d/vscode.list && \
    # Update & install VS Code
    apt-get update && \
    apt-get install -y code && \
    # Clean up
    apt-get clean && rm -rf /var/lib/apt/lists/* /usr/share/keyrings/microsoft.gpg

# Set working directory
WORKDIR /workspace

# Optional tools
RUN apt-get update && apt-get install -y git curl vim && apt-get clean

# Desktop shortcut
RUN mkdir -p /root/Desktop && \
    echo "[Desktop Entry]\nType=Application\nName=VS Code\nExec=code --no-sandbox --unity-launch\nIcon=code\nTerminal=false" \
        > /root/Desktop/vscode.desktop && \
    chmod +x /root/Desktop/vscode.desktop

EXPOSE 80 5901
