<?php
require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Check if tables exist
    $tables = ['users', 'groups', 'schedule'];
    $missing_tables = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = '$table')");
        if (!$stmt->fetchColumn()) {
            $missing_tables[] = $table;
        }
    }
    
    if (empty($missing_tables)) {
        echo "All tables exist in the database.\n";
    } else {
        echo "Missing tables: " . implode(', ', $missing_tables) . "\n";
        echo "Please run schema.sql to create missing tables.\n";
    }
    
    // Check if there are any groups
    $stmt = $pdo->query("SELECT COUNT(*) FROM groups");
    $groupCount = $stmt->fetchColumn();
    echo "Number of groups in database: $groupCount\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?> 