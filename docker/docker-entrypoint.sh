#!/bin/bash
set -e

# Run Composer install
composer install

# Create DB table
php bin/console doctrine:schema:update --force

# Run npm install
npm install

# Build assets
npm run dev

# Execute the container's main process (what's set as CMD in the Dockerfile)
exec "$@"
