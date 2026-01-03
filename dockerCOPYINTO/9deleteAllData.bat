@ECHO OFF
@REM docker stop $(docker ps -aq)  # Stop all running containers
@REM docker rm $(docker ps -aq)    # Remove all containers
@REM docker rmi -f $(docker images -aq)  # Remove all images
@REM docker volume rm $(docker volume ls -q)  # Remove all volumes
@REM docker builder prune -a -f  # Remove all build cache

docker system prune -a --volumes -f
