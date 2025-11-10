<?php
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

class CheatSettings {
    private $conn;
    private $table_name = "user_cheat_settings";

    public $user_id;
    public $mode;
    public $max_streak;
    public $max_balance;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSettings() {
        $query = "SELECT mode, max_streak, max_balance FROM " . $this->table_name . " WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no existen settings, crea y devuelve los por defecto
            $this->createDefaultSettings();
            return ['mode' => 0, 'max_streak' => -1, 'max_balance' => -1];
        }
    }

    public function updateSettings() {
        $query = "UPDATE " . $this->table_name . " SET mode = :mode, max_streak = :max_streak, max_balance = :max_balance WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":mode", $this->mode);
        $stmt->bindParam(":max_streak", $this->max_streak);
        $stmt->bindParam(":max_balance", $this->max_balance);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }

    private function createDefaultSettings() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, mode, max_streak, max_balance) VALUES (:user_id, 0, -1, -1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
    }

    public static function ensureSettingsExist($db, $user_id) {
        $settings = new self($db);
        $settings->user_id = $user_id;
        $settings->getSettings(); // Esto creará los settings si no existen
    }
}
?>