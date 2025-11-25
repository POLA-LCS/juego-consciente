<?php
// Strict Typing
declare(strict_types=1);

class Database
{
    private string $host = 'localhost';
    private string $db_name = 'ludopatia';
    private string $username = 'root';
    private string $password = '';
    public PDO $conn;

    public static string $CheatSettingsTable = 'users_cheat_settings';
    public static string $UserTable = 'users';
    public static string $GameHistoryTable = 'game_history';

    public function getConnection(): PDO
    {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->exec("set names utf8mb4");
        return $this->conn;
    }
}
