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

