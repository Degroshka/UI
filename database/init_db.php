<?php
require_once __DIR__ . '/../config/database.php';

try {
    // Initialize database connection
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Read and execute schema.sql
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    
    // Split the file into individual queries
    $queries = array_filter(array_map('trim', explode(';', $schema)));
    
    // Execute each query
    foreach ($queries as $query) {
        if (!empty($query)) {
            $pdo->exec($query);
        }
    }
    
    echo "Database initialized successfully!\n";
} catch (PDOException $e) {
    die("Error initializing database: " . $e->getMessage() . "\n");
} 