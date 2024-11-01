#!/bin/bash
set -e

# Run Composer install
composer install

# Run npm install
npm install

# Build assets
npm run dev

exec "$@"
