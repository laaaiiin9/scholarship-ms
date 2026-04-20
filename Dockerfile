FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# 1. Copy application code
COPY . /var/www

# 2. Install production dependencies
RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

# 3. Setup Permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY nginx/eskoylar.conf /etc/nginx/sites-available/eskoylar.conf
RUN ln -s /etc/nginx/sites-available/eskoylar.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

# 4. Copy a basic Nginx config (See note below)
# If you don't have a custom conf, Render can use a default, 
# but it's better to provide one.

# 5. Expose port 80
EXPOSE 80

# 6. Start Nginx and PHP-FPM
# CMD sh -c "php artisan config:cache && php artisan route:cache && php-fpm -D && nginx -g 'daemon off;'"

# We use --force because migrations won't run in production without it
CMD sh -c "php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php-fpm -D && \
    nginx -g 'daemon off;'"