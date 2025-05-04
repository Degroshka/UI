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

// GET request - retrieve all schedule entries
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("
            SELECT s.*, 
                   sub.name as subject_name,
                   t.name as teacher_name,
                   g.name as group_name
            FROM schedule s
            LEFT JOIN subjects sub ON s.subject_id = sub.id
            LEFT JOIN teachers t ON s.teacher_id = t.id
            LEFT JOIN groups g ON s.group_id = g.id
            ORDER BY s.date, s.start_time
        ");
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($schedule === false) {
            $schedule = [];
        }
        
        echo json_encode($schedule);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}

// POST request - add a new schedule entry
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['subject_id']) || empty($data['teacher_id']) || empty($data['group_id']) || 
            empty($data['date']) || empty($data['start_time']) || empty($data['end_time']) || 
            empty($data['room']) || empty($data['type'])) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO schedule (
                subject_id, teacher_id, group_id, room, 
                date, start_time, end_time, type
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['subject_id'],
            $data['teacher_id'],
            $data['group_id'],
            $data['room'],
            $data['date'],
            $data['start_time'],
            $data['end_time'],
            $data['type']
        ]);

        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}

// DELETE request - delete a schedule entry
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Schedule entry ID is required']);
            exit;
        }

        // Check if schedule entry exists
        $stmt = $pdo->prepare("SELECT id FROM schedule WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Schedule entry not found']);
            exit;
        }

        // Delete the schedule entry
        $stmt = $pdo->prepare("DELETE FROM schedule WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} 