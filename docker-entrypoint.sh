#!/bin/sh
set -e

# Generate an APP_KEY only if one isn't already set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run any pending database migrations
php artisan migrate --force

# Start the actual process Docker was told to run (php-fpm)
exec "$@"