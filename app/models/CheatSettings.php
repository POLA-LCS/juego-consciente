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
    public function ensureSettings(): ?array
    {
        $query = "SELECT mode, max_streak, max_balance FROM " . $this->table_name . " WHERE user_id = :user_id LIMIT 1";;
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $stmt->bindParam(":user_id", $this->user_id);
        if (!$stmt->execute()) return null;

        if ($stmt->rowCount() > 0)
            return $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$this->createDefaultSettings())
            return null;

        return [
            'mode' => 0,
            'max_streak' => -1,
            'max_balance' => -1
        ];
    }

    public function updateSettings(): ?bool
    {
        $query = "UPDATE " . $this->table_name . " SET mode = :mode, max_streak = :max_streak, max_balance = :max_balance WHERE user_id = :user_id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $stmt->bindParam(":mode", $this->mode);
        $stmt->bindParam(":max_streak", $this->max_streak);
        $stmt->bindParam(":max_balance", $this->max_balance);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }

    private function createDefaultSettings(): ?bool
    {
        $query = "INSERT INTO " . $this->table_name . " (user_id, mode, max_streak, max_balance) VALUES (:user_id, 0, -1, -1)";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }

    /**
     * Asegura que los settings para un usuario existan.
     * Devuelve los settings o null en caso de error.
     */
    public static function settingsExist(PDO $db, int $user_id): bool
    {
        $settings = new self($db);
        $settings->user_id = $user_id;
        return $settings->ensureSettings() !== null;
    }
}
