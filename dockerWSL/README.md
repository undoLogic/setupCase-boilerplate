# DockerSH

Linux shell (.sh) scripts used to:
- Start containers
- Manage Docker services
- Standardize environment bootstrapping across systems

## Roadmap / Planned Enhancements
...

## Setup WSL

install Ubuntu on WSL
```
wsl --install -d Ubuntu
```

Login to Ubuntu
```
wsl -d Ubuntu
```

Delete Ubuntu and start again 
```
wsl --unregister Ubuntu
```


Restart WSL after install
```aiignore
wsl --shutdown
```

## Step 2 - Create Linux Projects Directory
eg /home/username/projects/APPS
```
mkdir -p ~/projects
cd ~/projects
```

## Step 3 - Create in PHP Storm
- PhpStorm
- file Or clone
- Choose the file picker and navigate to Linux / Projects / name of app





## Ensure docker-desktop is configured to work with WSL2
- Open docker desktop settings
- Resources
- WSL intergration
- Check "enable intergration with my default WSL distro
- Also checkbox Enable intergration with other versions of WSL eg Ubuntu"
