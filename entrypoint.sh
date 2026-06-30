#!/bin/sh

# Exit immediately if a command exits with a non-zero status
set -e

# Run migrations on startup (important for databases linked to justrunmy.app)
echo "Checking database connection and running migrations..."
php artisan migrate --force

# Create storage symlink if it does not exist
if [ ! -d "public/storage" ]; then
    echo "Creating public storage symlink..."
    php artisan storage:link --force
fi

# Cache config, routes, and views for production optimization
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground
echo "Starting Apache..."
exec apache2-foreground
