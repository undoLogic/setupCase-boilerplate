@ECHO OFF
docker volume prune -f
docker-compose down

timeout /t 1

docker-compose build --no-cache

timeout /t 1
docker-compose up -d

timeout /t 30

