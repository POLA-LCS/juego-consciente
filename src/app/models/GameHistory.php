<?php
// Strict typing
declare(strict_types=1);

require_once(SRC_PATH . 'config/database.php');

class GameHistory
{
    private PDO $conn;
    private string $table_name;

    public int $id;
    public int $user_id;
    public string $game;
    public int $result;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
        $this->table_name = Database::$GameHistoryTable;
    }

    public function create(): void
    {
        $query = "INSERT INTO " . $this->table_name .
            " (user_id, game, result) " .
            "VALUES (:user_id, :game, :result)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":game", $this->game);
        $stmt->bindParam(":result", $this->result);

        $stmt->execute();
    }

    public function getHistoryByUserId(int $user_id): array
    {
        $query = "SELECT id, game, result, played_at FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY played_at DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoryByGame(int $user_id, string $game): array
    {
        $query = "SELECT id, game, result, played_at FROM " . $this->table_name . " WHERE user_id = :user_id AND game = :game ORDER BY played_at DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":game", $game);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
