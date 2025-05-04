<?php
require_once 'config/database.php';
require_once 'auth/User.php';

$database = new Database();
$pdo = $database->getConnection();

try {
    // Проверяем, существует ли уже пользователь admin
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = 'admin'");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        // Создаем пользователя admin
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, must_change_password) VALUES (?, ?, 'superuser', false)");
        $stmt->execute(['admin', $password]);
        echo "Пользователь admin успешно создан!\n";
    } else {
        echo "Пользователь admin уже существует.\n";
    }
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
} 