<?php
// ✅ Use __DIR__ to make the include path reliable everywhere
include __DIR__ . '/../../includes/constants.php';

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $host = DB_SERVER;
        $db   = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
