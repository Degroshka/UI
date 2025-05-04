FROM php:8.2-apache

# Установка необходимых расширений PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql

# Включение mod_rewrite
RUN a2enmod rewrite

# Копирование файлов приложения
COPY . /var/www/html/

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html

# Настройка Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Создание скрипта инициализации
RUN echo '#!/bin/bash\n\
echo "Waiting for database to be ready..."\n\
while ! pg_isready -h db -U postgres -p 5432 > /dev/null 2>&1; do\n\
  sleep 1\n\
done\n\
echo "Database is ready!"\n\
php -f /var/www/html/database/create_superuser.php\n\
apache2-foreground' > /usr/local/bin/start.sh && \
chmod +x /usr/local/bin/start.sh

# Открытие порта
EXPOSE 80

# Запуск скрипта инициализации
CMD ["/usr/local/bin/start.sh"]

# Установка рабочей директории
WORKDIR /var/www/html 