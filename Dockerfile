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

# --- CRITICAL: Install Node.js and NPM ---
# This must happen BEFORE the "npm install" line
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

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

# Now this will work because Node.js is installed above
RUN npm install && npm run build

# 3. Setup Permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx config setup
COPY nginx/eskoylar.conf /etc/nginx/sites-available/eskoylar.conf
RUN ln -s /etc/nginx/sites-available/eskoylar.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

# 5. Expose port 80
EXPOSE 80

# 6. Start Nginx and PHP-FPM
CMD sh -c "php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php-fpm -D && \
    nginx -g 'daemon off;'"