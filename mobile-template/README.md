# Mobile App Template (Vue + Capacitor)

## Purpose
Minimal, opinionated mobile shell:
- Vue 3
- Vue Router
- Pinia
- Bootstrap
- Capacitor
- No frameworks, no SSR, no magic

## Usage

1. Create a new Vite Vue TS project

```php
npm create vite@latest mobile-app -- --template vue-ts
```

2. Hello world will start automatically confirming it is running
```php
http://localhost:5173/
```
3. Exit out of the hello world (Ctrl+C)

4. Copy our template into our project
```bash
# From root of boilerplate
rsync -av mobile-template/. mobile-app/.
```

5. Update our packages and install required libraries
```bash
cd mobile-app
npm install
```

6. Start up our test project
```bash
npm run dev
```

7. Open in your browser to test
```php
http://localhost:5173/
```




## Requirements

This requires
- Node 20+

On Ubuntu the node is usually old so you must upgrade first

```bash
# ensure you do Not have an older Node version installed 
node -v
# should say: command not found
```

If there IS an older version installed remove first
```bash
sudo apt remove -y nodejs
sudo apt autoremove -y
```

Install the latest version
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

Install latest dependancies
```bash
cd mobile-app
rm -rf node_modules package-lock.json
npm install
```
