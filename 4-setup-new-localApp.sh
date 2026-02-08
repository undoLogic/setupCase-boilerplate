#!/bin/sh

TARGET_DIR="localApp_NEW"

# 1. Copy template
cp -R template_localApp "$TARGET_DIR"

# 2. Select runtime
cd "$TARGET_DIR/runtime/python" || exit 1

# 3. Setup environment
poetry install
