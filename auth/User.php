<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function authenticate($username, $password) {
        $query = "SELECT id, username, password, role FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Пароль в базе данных: " . $row['password']);
            if (password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->role = $row['role'];
                return true;
            } else {
                error_log("Неверный пароль");
            }
        }
        return false;
    }
    
    public function createSuperUser() {
        // Проверяем, существует ли уже суперпользователь
        $query = "SELECT id FROM " . $this->table_name . " WHERE role = 'superuser'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $username = "admin";
            $password = password_hash("admin", PASSWORD_DEFAULT);
            $role = "superuser";

            $query = "INSERT INTO " . $this->table_name . " (username, password, role) VALUES (:username, :password, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);
            
            return $stmt->execute();
        }
        return false;
    }

    public function createUser($username, $password, $role = 'user') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table_name . " (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);
        
        return $stmt->execute();
    }
}