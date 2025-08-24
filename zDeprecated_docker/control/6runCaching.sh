#!/bin/sh
if [ "$1" = 'RESET' ]; then
    ./caching/reset.sh
    echo 'RESETTING FILES'
fi
if [ "$1" = 'reset' ]; then
    ./caching/reset.sh
    echo 'RESETTING FILES'
fi
./caching/SetupCase-Caching.sh