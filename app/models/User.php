<?php
// Strict typing
declare(strict_types=1);

// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

class User
{
    private PDO $conn;
    private string $table_name = "users";

    public string $id;
    public string $username;
    public string $email;
    public string $password;
    public float $balance;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function create(): ?bool
    {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password, balance=1000";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindValue(":password", password_hash($this->password, PASSWORD_DEFAULT));

        return $stmt->execute();
    }

    public function isEmailTaken(): ?bool
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        if (!$stmt->execute()) return null;

        // Devolver si el email ya está en uso
        return $stmt->rowCount() <= 0;
    }

    public function login(): ?bool
    {
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":username", $this->username);
        if (!$stmt->execute()) return null;

        if ($stmt->rowCount() <= 0)
            return false;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($this->password, $row['password']))
            return false;

        $this->id = strval($row['id']);
        return true;
    }

    public function delete(): ?bool
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function getBalance(): ?float
    {
        $query = "SELECT balance FROM " . $this->table_name . " WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        if (!$stmt->execute())
            return null;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["balance"];
    }

    public function updateBalance(float $amount): ?float
    {
        $query = "UPDATE " . $this->table_name . " SET balance = balance + :amount WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $amount = htmlspecialchars(strip_tags(strval($amount)));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":id", $this->id);
        if (!$stmt->execute())
            return null;

        return $this->getBalance();
    }

    public function setBalance(float $newBalance): ?float
    {
        $query = "UPDATE " . $this->table_name . " SET balance = :newBalance WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $newBalance = htmlspecialchars(strip_tags(strval($newBalance)));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":newBalance", $newBalance);
        $stmt->bindParam(":id", $this->id);
        if (!$stmt->execute())
            return null;
        return $this->getBalance();
    }

    public function getCheatMode(): ?int
    {
        $query = "SELECT cheat_mode FROM " . $this->table_name . " WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) == false)
            return null;

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        if (!$stmt->execute())
            return null;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["cheat_mode"];
    }

    public function setCheatMode(int $newMode)
    {
        $query = "UPDATE " . $this->table_name . " SET cheat_mode = :newMode WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $newMode = htmlspecialchars(strip_tags(strval($newMode)));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":newMode", $newMode);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function getWinStreak(): ?int
    {
        $query = "SELECT win_streak FROM " . $this->table_name . " WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $stmt->bindParam(":id", $this->id);
        if (!$stmt->execute())
            return null;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["win_streak"];
    }

    public function setWinStreak(int $streak): ?bool
    {
        $query = "UPDATE " . $this->table_name . " SET win_streak = :streak WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $streak = htmlspecialchars(strip_tags(strval($streak)));

        $stmt->bindParam(":streak", $streak);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function incrementWinStreak(): ?bool
    {
        $query = "UPDATE " . $this->table_name . " SET win_streak = win_streak + 1 WHERE id = :id";
        if (($stmt = $this->conn->prepare($query)) === false)
            return null;

        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
