#!/bin/sh

# Exit immediately if a command exits with a non-zero status
set -e

# For SQLite databases, create the file if it doesn't exist and set correct folder permissions
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    # Default path is database/database.sqlite
    DB_PATH="database/database.sqlite"
    if [ ! -f "$DB_PATH" ]; then
        echo "Creating SQLite database file..."
        mkdir -p database
        touch "$DB_PATH"
    fi
    # Set permissions for both the file and the folder (SQLite requires folder write access for lock files)
    chown -R www-data:www-data database
    chmod -R 775 database
fi

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
