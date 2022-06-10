#!/usr/bin/env bash
docker volume prune -f
sleep 1
docker-compose down
sleep 3
docker-compose up -d