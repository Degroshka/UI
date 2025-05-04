<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../auth/User.php';

// Подключение к базе данных
$database = new Database();
$db = $database->getConnection();

// Создание таблицы пользователей
$sql = file_get_contents(__DIR__ . '/create_users_table.sql');
$db->exec($sql);

// Создание суперпользователя
$user = new User();
if ($user->createSuperUser()) {
    echo "Суперпользователь успешно создан\n";
    echo "Логин: admin\n";
    echo "Пароль: admin\n";
} else {
    echo "Суперпользователь уже существует\n";
}
?> 