<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $balance;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password, balance=1000";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        // Usamos bindValue para pasar el resultado de la función password_hash.
        // bindParam requiere una variable, bindValue puede tomar un valor directo.
        $stmt->bindValue(":password", password_hash($this->password, PASSWORD_DEFAULT));

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function isEmailTaken() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return true; // Email está en uso
        }
        return false; // Email está disponible
    }

    public function login() {
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                return true;
            }
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getBalance() {
        $query = "SELECT balance FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["balance"];
    }

    public function updateBalance($amount) {
        $query = "UPDATE " . $this->table_name . " SET balance = balance + :amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $amount = htmlspecialchars(strip_tags($amount));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return $this->getBalance(); // Devuelve el nuevo saldo
        }
        return false;
    }

    public function setBalance($newBalance) {
        $query = "UPDATE " . $this->table_name . " SET balance = :newBalance WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $newBalance = htmlspecialchars(strip_tags($newBalance));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":newBalance", $newBalance);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return $this->getBalance(); // Devuelve el nuevo saldo
        }
        return false;
    }

    public function getCheatMode() {
        $query = "SELECT cheat_mode FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["cheat_mode"];
    }

    public function setCheatMode($newMode) {
        $query = "UPDATE " . $this->table_name . " SET cheat_mode = :newMode WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $newMode = htmlspecialchars(strip_tags($newMode));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":newMode", $newMode);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getWinStreak() {
        $query = "SELECT win_streak FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["win_streak"];
    }

    public function setWinStreak($streak) {
        $query = "UPDATE " . $this->table_name . " SET win_streak = :streak WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $streak = htmlspecialchars(strip_tags($streak));

        $stmt->bindParam(":streak", $streak);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function incrementWinStreak() {
        $query = "UPDATE " . $this->table_name . " SET win_streak = win_streak + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
