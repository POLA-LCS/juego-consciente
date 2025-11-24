<?php
// Strict typing
declare(strict_types=1);

class History
{
    private PDO $conn;
    private string $table_name = "history";

    public int $id;
    public int $user_id;
    public bool $won;
    public string $game;
    public float $amount;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function add(): void
    {
        $query = "INSERT INTO " . $this->table_name .
            " (user_id, won, game, amount) " .
            "VALUES (:user_id, :won, :game, :amount)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":won", $this->won, PDO::PARAM_BOOL);
        $stmt->bindParam(":game", $this->game);
        $stmt->bindParam(":amount", $this->amount);

        $stmt->execute();
    }

    public function getHistoryByUserId(int $user_id): array
    {
        $query = "SELECT id, won, game, amount, created_at FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);

        $this->user_id = $user_id;

        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoryByGame(int $user_id, string $game): array
    {
        $query = "SELECT id, won, game, amount, created_at FROM " . $this->table_name . " WHERE user_id = :user_id AND game = :game ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);

        $this->user_id = $user_id;
        $this->game = htmlspecialchars(strip_tags($game));

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":game", $this->game);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
