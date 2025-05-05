<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: "postgres";
        $this->db_name = getenv('DB_NAME') ?: "schedule";
        $this->username = getenv('DB_USER') ?: "admin";
        $this->password = getenv('DB_PASSWORD') ?: "postgres";
        $this->port = getenv('DB_PORT') ?: "5432";
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }

        return $this->conn;
    }
}
