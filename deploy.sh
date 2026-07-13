#!/bin/bash
set -e

echo "Deployment started..."

# Enter maintenance mode
php artisan down || true

# Pull the latest version of the repository
git pull origin main

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recreate caches for performance optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install node modules and compile assets if npm is installed
if command -v npm &> /dev/null; then
    echo "Node.js/NPM found. Compiling assets..."
    npm install
    npm run build
else
    echo "NPM not found. Skipping asset compilation (ensure assets are pre-built or deployed)."
fi

# Ensure storage link is created
rm -rf public/storage
php artisan storage:link --relative || true

# Exit maintenance mode
php artisan up

# Restart queue workers gracefully
php artisan queue:restart

echo "Restarting Reverb WebSocket Server..."
# Restart Reverb worker if managed by Supervisor
if command -v supervisorctl &> /dev/null; then
    sudo supervisorctl restart all || supervisorctl restart all || echo "Could not restart supervisor automatically. Please restart it manually."
else
    echo "Supervisor not found. You may need to manually restart the Reverb daemon (php artisan reverb:start)."
fi

echo "Deployment finished successfully!"
