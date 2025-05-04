<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->db_name = getenv('DB_NAME') ?: "schedule_db";
        $this->username = getenv('DB_USER') ?: "postgres";
        $this->password = getenv('DB_PASSWORD') ?: "crfrfkmcrbq";
        $this->port = getenv('DB_PORT') ?: "5432";
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e; // Re-throw the exception to be handled by the calling code
        }

        return $this->conn;
    }
} 