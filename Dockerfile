# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Включаем модуль mod_rewrite для Apache
RUN a2enmod rewrite

# Копируем файлы приложения
COPY . /var/www/html/

# Устанавливаем права на запись для сессий
RUN mkdir -p /var/www/html/sessions && \
    chown -R www-data:www-data /var/www/html/sessions

# Настраиваем Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Открываем порт 8000
EXPOSE 8000

# Запускаем Apache
CMD ["apache2-foreground"] 