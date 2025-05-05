#!/bin/bash
set -e

# Подключение через переменные
export PGPASSWORD="$DB_PASSWORD"

# Ожидаем, пока PostgreSQL не станет доступен
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER"; do
  echo "⏳ Waiting for PostgreSQL at $DB_HOST:$DB_PORT..."
  sleep 2
done

echo "✅ PostgreSQL is accepting connections"

# Проверка и создание таблицы users
psql -h "$DB_HOST" -U "$DB_USER" -d "$DB_NAME" -c "
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL
);

INSERT INTO users (username, password, role) 
VALUES ('admin', '\$2y\$10\$wXZUCBQi7BfTo6q3YJd3vOIE6qM9vAu4/kz7ZXaAoSLRxYFvqqxz6', 'admin')
ON CONFLICT (username) DO NOTHING;
"