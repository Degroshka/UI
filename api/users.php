<?php
require_once '../config/database.php';
require_once '../auth/check_auth.php';
require_once '../auth/permissions.php';

header('Content-Type: application/json');

$database = new Database();
$pdo = $database->getConnection();

// Проверка и добавление поля must_change_password, если его нет
try {
    $pdo->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS must_change_password BOOLEAN DEFAULT TRUE");
} catch (PDOException $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка прав администратора
    requireAdmin();
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['username']) || empty($data['password']) || empty($data['full_name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Все поля обязательны']);
        exit;
    }
    try {
        // Проверка на уникальность логина
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$data['username']]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['error' => 'Пользователь с таким логином уже существует']);
            exit;
        }
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, role, must_change_password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['username'],
            $hashed,
            $data['full_name'],
            $data['role'] ?? 'student',
            true
        ]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} 