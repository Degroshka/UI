<?php
// Ensure no output before headers
ob_start();

require_once '../config/database.php';
require_once '../auth/check_auth.php';
require_once '../auth/permissions.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set headers
header('Content-Type: application/json; charset=utf-8');

// Clear any previous output
ob_clean();

$database = new Database();
$pdo = $database->getConnection();

// GET request - retrieve all groups
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // First check if the table exists
        $tableExists = $pdo->query("SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'groups')")->fetchColumn();
        
        if (!$tableExists) {
            http_response_code(500);
            echo json_encode(['error' => 'Database table does not exist']);
            exit;
        }

        $stmt = $pdo->query("SELECT * FROM groups ORDER BY name");
        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Ensure we have a valid array
        if ($groups === false) {
            $groups = [];
        }
        
        $response = json_encode($groups, JSON_UNESCAPED_UNICODE);
        if ($response === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to encode response']);
            exit;
        }
        echo $response;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

// POST request - add new group
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isAdmin()) {
        http_response_code(403);
        echo json_encode(['error' => 'Access denied']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO groups (name, description) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['description'] ?? null]);
        
        $id = $pdo->lastInsertId();
        echo json_encode(['id' => $id, 'name' => $data['name'], 'description' => $data['description'] ?? null]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

// DELETE request - remove group
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (!isAdmin()) {
        http_response_code(403);
        echo json_encode(['error' => 'Access denied']);
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Group ID is required']);
        exit;
    }

    try {
        // Check if group exists
        $stmt = $pdo->prepare("SELECT id FROM groups WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Group not found']);
            exit;
        }

        // Delete the group
        $stmt = $pdo->prepare("DELETE FROM groups WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}

// Invalid request method
else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
} 