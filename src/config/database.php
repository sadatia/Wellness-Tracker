<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'ack_db';
    private $username = 'ack_db'; // Change for production
    private $password = 'ack_dback_db';     // Change for production
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>