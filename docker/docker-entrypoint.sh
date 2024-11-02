#!/bin/bash
set -e

# Run Composer install
composer install

# Add or update the DATABASE_URL in the .env file
echo 'Updating DATABASE_URL in .env file...'
if grep -q "^DATABASE_URL=" .env; then
    # Replace the existing DATABASE_URL line
    sed -i 's|^DATABASE_URL=.*|DATABASE_URL="mysql://symfony:symfony@db:3306/symfony?serverVersion=5.7"|g' .env
else
    # Add the DATABASE_URL line if it does not exist
    echo 'DATABASE_URL="mysql://symfony:symfony@db:3306/symfony?serverVersion=5.7"' >> .env
fi

# Create DB table
php bin/console doctrine:schema:update --force

# Run npm install
npm install

# Build assets
npm run dev

# Execute the container's main process (what's set as CMD in the Dockerfile)
exec "$@"
