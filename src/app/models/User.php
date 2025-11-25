<?php
// Strict typing
declare(strict_types=1);

require_once(SRC_PATH . 'config/database.php');

class User
{
    private PDO $conn;
    private string $table_name;

    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public int $balance = 1000;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
        $this->table_name = Database::$UserTable;
    }

    public function create(): void
    {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password, balance=1000";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindValue(":password", password_hash($this->password, PASSWORD_DEFAULT));

        $stmt->execute();
    }

    public function isEmailAvailable(): bool
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        // Devolver si el email ya está en uso
        return $stmt->rowCount() <= 0;
    }

    public function login(): bool
    {
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if ($stmt->rowCount() <= 0)
            return false;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || !password_verify($this->password, $row['password']))
            return false;

        $this->id = (int)$row['id'];
        return true;
    }

    public function verifyPassword(string $password): bool
    {
        $query = "SELECT password FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return password_verify($password, $row['password']);
        }

        return false;
    }

    public function updatePassword(string $current_password, string $new_password): void
    {
        // Primero, verificar la contraseña actual
        if (!$this->verifyPassword($current_password)) {
            return;
        }

        // Si es correcta, actualizar a la nueva
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":password", password_hash($new_password, PASSWORD_DEFAULT));
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
    }

    public function getById(): array
    {
        $query = "SELECT id, username, email, created_at FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: [];
    }

    public function delete(): void
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
    }

    public function getBalance(): int
    {
        $query = "SELECT balance FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row["balance"] ?? 0);
    }

    public function updateBalance(int $amount): int
    {
        $query = "UPDATE " . $this->table_name . " SET balance = balance + :amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $this->getBalance();
    }

    public function setBalance(int $newBalance): int
    {
        $query = "UPDATE " . $this->table_name . " SET balance = :newBalance WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":newBalance", $newBalance);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $this->getBalance();
    }

    public function getCheatMode(): int
    {
        $query = "SELECT cheat_mode FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row["cheat_mode"] ?? 0);
    }

    public function setCheatMode(int $newMode): void
    {
        $query = "UPDATE " . $this->table_name . " SET cheat_mode = :newMode WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":newMode", $newMode);
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
    }

    public function getWinStreak(): int
    {
        $query = "SELECT win_streak FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row["win_streak"] ?? 0);
    }

    public function setWinStreak(int $streak): void
    {
        $query = "UPDATE " . $this->table_name . " SET win_streak = :streak WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":streak", $streak);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function incrementWinStreak(): void
    {
        $query = "UPDATE " . $this->table_name . " SET win_streak = win_streak + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }
}
