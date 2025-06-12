FROM php:8.3-apache

# Habilita o módulo de reescrita do Apache
RUN a2enmod rewrite

# Instala extensões necessárias e o Composer
RUN apt-get update && \
    apt-get install -y unzip libzip-dev libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia os arquivos do projeto
COPY . /var/www/html

WORKDIR /var/www/html

# Instala as dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80 (padrão do Apache)
EXPOSE 80

# Inicia o Apache no modo foreground
CMD ["apache2-foreground"]
