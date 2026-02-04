# src sub-structure
rsync -av ../mobile-app/src/. ./src/.

# root-level config files
rsync -av ../mobile-app/vite.config.ts       ./
rsync -av ../mobile-app/tsconfig.json        ./
rsync -av ../mobile-app/capacitor.config.ts  ./
rsync -av ../mobile-app/.gitignore            ./
rsync -av ../mobile-app/README.md             ./
