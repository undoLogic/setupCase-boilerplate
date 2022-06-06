#!/usr/bin/env bash
docker volume prune -f
docker-compose up -d
sleep 5