<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

// Generate password hash for 'admin'
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update admin user
$query = "UPDATE users SET password = :password WHERE username = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bindParam(":password", $hashed_password);

if ($stmt->execute()) {
    echo "Admin password updated successfully. New hash: " . $hashed_password;
} else {
    echo "Error updating admin password";
} 