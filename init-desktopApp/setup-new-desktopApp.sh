#!/bin/sh

TEMPLATE_DIR="template_localApp"
TARGET_DIR="desktopApp_NEW"

if [ ! -d "$TEMPLATE_DIR" ]; then
  echo "Template not found: $TEMPLATE_DIR"
  exit 1
fi

# 1. Copy template
cp -R "$TEMPLATE_DIR" "$TARGET_DIR"

# 2. Select runtime
cd "$TARGET_DIR/runtime/python" || exit 1

# 3. Setup environment
poetry install
