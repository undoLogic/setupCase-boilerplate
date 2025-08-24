#!/usr/bin/env bash

# this will disconnect from the boilerplate and allow to connect this to a fresh github project

# Remove association so boilerplate in github
rm -rf sourceFiles/.git*
rm -rf .git*

# change the README
rm README

# Create a new README file with some content
cat <<EOL > README
# New README
This is a new project
EOL
