# DockerSH

Linux shell (.sh) scripts used to:
- Start containers
- Manage Docker services
- Standardize environment bootstrapping across systems






## WSL2 Intergration for rocket speed (avoid Windows filesystem translation layers issues)

## Overview
```swift
Windows 11
├─ Docker Desktop (WSL2 backend)
├─ PhpStorm (Windows UI)
│   └─ Connected to WSL2 filesystem
│
WSL2 (Ubuntu 22.04 / 24.04)
├─ /home/<user>/projects/<project>
├─ Docker CLI + docker-compose
├─ PHP / Composer / Node (optional)
└─ Containers running natively in Linux FS
```


### Step 1 — Enable WSL2 (Clean)

Open PowerShell as Administrator:
``` 
wsl --install
```

Verify:
```angular2svg
wsl --version
```

### Step 2 - Create Linux Projects Directory
eg /home/username/projects/APPS
```
mkdir -p ~/projects
cd ~/projects
```

Do NOT use
```angular2svg
/mnt/c/Users/...
```

#### Step 3 - Create in PHPstorm
- PhpStorm
- file Or clone
- Choose the file picker and navigate to Linux
