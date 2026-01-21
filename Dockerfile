FROM php:8.2-apache

# Install SQLite development headers and tools
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    unzip \
    curl \
    python3 \
    python3-pip \
    python3-venv \
    && rm -rf /var/lib/apt/lists/*

# Enable PDO SQLite extension
RUN docker-php-ext-install pdo_sqlite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY src/ .

# Ensure the web server can write to the database file
RUN touch database.sqlite && chown www-data:www-data database.sqlite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
