<?php
ob_start();
require_once '../config/database.php';
require_once '../auth/check_auth.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');
ob_clean();

$database = new Database();
$pdo = $database->getConnection();

// GET request - retrieve all teachers
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM teachers ORDER BY name");
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($teachers === false) {
            $teachers = [];
        }
        
        echo json_encode($teachers);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}

// POST request - add a new teacher
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Teacher name is required']);
            exit;
        }

        // Check if teacher with same name and email already exists
        if (!empty($data['email'])) {
            $stmt = $pdo->prepare("SELECT id FROM teachers WHERE (name = ? AND email = ?) OR email = ?");
            $stmt->execute([$data['name'], $data['email'], $data['email']]);
            if ($stmt->fetch()) {
                http_response_code(400);
                echo json_encode(['error' => 'Преподаватель с таким именем и email или email уже существует']);
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO teachers (name, department, position, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['name'],
            $data['department'] ?? null,
            $data['position'] ?? null,
            $data['email'] ?? null
        ]);

        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        if (strpos($e->getMessage(), 'unique constraint') !== false) {
            http_response_code(400);
            echo json_encode(['error' => 'Преподаватель с таким именем и email или email уже существует']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database error occurred']);
        }
    }
}

// DELETE request - delete a teacher
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Teacher ID is required']);
            exit;
        }

        // Check if teacher exists
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Teacher not found']);
            exit;
        }

        // Delete the teacher
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} 