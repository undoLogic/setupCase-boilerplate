@ECHO OFF
docker volume prune -f

docker-compose down

sleep 3timeout /t 1

docker-compose up -d