<?php
// Strict typing
declare(strict_types=1);

if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

class CheatSettings
{
    private PDO $conn;
    private string $table_name = "user_cheat_settings";

    public int $user_id = 0;
    public int $mode = 0;
    public int $max_streak = -1;
    public int $max_balance = -1;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Obtiene los settings del usuario. Si no existen, los crea.
     * Devuelve un array con los settings o null si ocurre un error.
     */
    public function ensureSettings(): array
    {
        $query = "SELECT mode, max_streak, max_balance FROM " . $this->table_name . " WHERE user_id = :user_id LIMIT 1";;
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }

        $this->createDefaultSettings();

        return [
            'mode' => 0,
            'max_streak' => -1,
            'max_balance' => -1
        ];
    }

    public function updateSettings(): void
    {
        $query = "UPDATE " . $this->table_name . " SET mode = :mode, max_streak = :max_streak, max_balance = :max_balance WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":mode", $this->mode);
        $stmt->bindParam(":max_streak", $this->max_streak);
        $stmt->bindParam(":max_balance", $this->max_balance);
        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();
    }

    private function createDefaultSettings(): void
    {
        $query = "INSERT INTO " . $this->table_name . " (user_id, mode, max_streak, max_balance) VALUES (:user_id, 0, -1, -1)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();
    }

    /**
     * Asegura que los settings para un usuario existan.
     * No devuelve nada. Lanza una excepción en caso de error.
     */
    public static function settingsExist(PDO $db, int $user_id): void
    {
        $settings = new self($db);
        $settings->user_id = $user_id;
        $settings->ensureSettings(); // Esto lanzará una excepción en caso de error
    }
}
