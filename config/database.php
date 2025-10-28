<?php
// Cláusula de guarda: si la constante APP_RUNNING no está definida, significa que se está accediendo directamente al archivo.
if (!defined('APP_RUNNING')) {
    http_response_code(403);
    include_once(__DIR__ . '/../app/views/errors/403.php');
    die();
}

class Database {
    private $host = 'localhost';
    private $db_name = 'ludopatia';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
