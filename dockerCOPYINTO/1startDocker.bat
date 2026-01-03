@ECHO OFF
docker volume prune -f

docker-compose up -d

timeout /t 5