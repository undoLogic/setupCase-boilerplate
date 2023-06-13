#!/bin/bash
# allow to import the paths from settings.json
source Z_share.sh

path=$LIVE_USER@$LIVE_URL
# echo $path

# show a list of php files edited in the last 10 minutes
files=( $(find ../sourceFiles/. -name "*.php" -mmin -30) )

if [ ${#files[@]} -eq 0 ]; then
    echo "No files recently modified - Modify a file and try again"
    exit
fi

PS3='Select file to upload, or 0 to exit: '
select file in "${files[@]}"; do
    if [[ $REPLY == "0" ]]; then
        echo "BYE!" >&2
        exit
    elif [[ -z $file ]]; then
        echo 'Invalid choice, try again' >&2
    else
        prefix="../sourceFiles/."

        # replace with variable
        variable=""
        serverLocation=$(echo "$file" | sed "s#$prefix#$variable#")
        # echo $serverLocation

        command="$file $path:$LIVE_ABSOLUTE_PATH$serverLocation"
        # echo $command
        echo "=== UPLOADING TO LIVE SERVER !!! >>> $command"
        rsync -av $command
        break
    fi
done

echo "DONE !"
# use scp to upload "$file" here

