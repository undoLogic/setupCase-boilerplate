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


