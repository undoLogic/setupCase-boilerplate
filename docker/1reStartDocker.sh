#!/usr/bin/env bash

if [ -n "$1" ]; then
  FILENAME=$1
  # param eixsts
else
  # not
  FILENAME="docker-compose.yml"
fi

echo docker-compose -f $FILENAME down
sleep 5
docker-compose -f $FILENAME up -d