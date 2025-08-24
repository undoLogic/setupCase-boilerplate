@ECHO OFF
REM rebuild without a cache
docker-compose down --volumes
docker-compose build --no-cache
