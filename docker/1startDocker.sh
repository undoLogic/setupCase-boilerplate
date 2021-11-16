#!/usr/bin/env bash

if [ -n "$1" ]; then
  FILENAME=$1
  # param eixsts
else
  # not
  FILENAME="docker-compose.yml"
fi

docker-compose up -f $FILENAME -d