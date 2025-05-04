<?php
// Ensure no output before headers
ob_start();

require_once '../config/database.php';
require_once '../auth/check_auth.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set headers
header('Content-Type: application/json');

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
            error_log("Groups table does not exist");
            http_response_code(500);
            echo json_encode(['error' => 'Database table does not exist']);
            exit;
        }

        $stmt = $pdo->query("SELECT * FROM groups ORDER BY name");
        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug output
        error_log("Groups data: " . print_r($groups, true));
        
        // Ensure we have a valid array
        if ($groups === false) {
            $groups = [];
        }
        
        $response = json_encode($groups);
        if ($response === false) {
            error_log("JSON encode error: " . json_last_error_msg());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to encode response']);
        } else {
            echo $response;
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

// POST request - create a new group
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || empty($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Group name is required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO groups (name, description) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['description'] ?? null]);
        
        echo json_encode([
            'success' => true,
            'id' => $pdo->lastInsertId(),
            'message' => 'Group created successfully'
        ]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

// DELETE request - delete a group
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Group ID is required']);
            exit;
        }

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