<?php
// Cláusula de guarda: si la constante APP_RUNNING no está definida, significa que se está accediendo directamente al archivo.
defined('APP_RUNNING') or die('Acceso denegado');

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
