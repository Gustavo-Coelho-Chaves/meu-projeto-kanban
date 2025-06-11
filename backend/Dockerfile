FROM php:8.1-apache

# Habilita o módulo de reescrita do Apache (útil para frameworks como Laravel)
RUN a2enmod rewrite

# Copia os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80
EXPOSE 3000

# Inicia o Apache no modo foreground
CMD ["apache2-foreground"]
