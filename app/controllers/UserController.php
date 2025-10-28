<?php
// ROOT_PATH es definido en index.php
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/models/User.php';

$controller = new UserController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                echo $controller->register($username, $email, $password);
                header("Location: index.php");
            }
            break;
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username']; // Asumiendo que el login es solo con username y password
                $password = $_POST['password'];
                echo $controller->login($username, $password);
                header("Location: index.php?page=dashboard");
            }
            break;
        case 'logout':
            echo $controller->logout();
            header("Location: index.php");
            break;
        case 'delete':
            $user_id = $_SESSION['user_id'];
            echo $controller->deleteAccount($user_id);
            header("Location: index.php");
            break;
        case 'getBalance':
            $user_id = $_SESSION['user_id'];
            echo $controller->getBalance($user_id);
            break;
        case 'updateBalance':
            $user_id = $_SESSION['user_id'];
            $amount = $_POST['amount'];
            echo $controller->updateBalance($user_id, $amount);
            break;
    }
}

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function register($username, $email, $password) {
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = $password;
        if($this->user->create()) {
            return "Usuario registrado exitosamente.";
        } else {
            return "Error al registrar usuario.";
        }
    }

    public function login($username, $password) {
        $this->user->username = $username;
        $this->user->password = $password;
        if($this->user->login()) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['username'] = $this->user->username;
            return "Login exitoso.";
        } else {
            return "Credenciales incorrectas.";
        }
    }

    public function logout() {
        session_destroy();
        return "Logout exitoso.";
    }

    public function deleteAccount($user_id) {
        $this->user->id = $user_id;
        if($this->user->delete()) {
            session_destroy();
            return "Cuenta eliminada.";
        } else {
            return "Error al eliminar cuenta.";
        }
    }

    public function getBalance($user_id) {
        $this->user->id = $user_id;
        return $this->user->getBalance();
    }

    public function updateBalance($user_id, $amount) {
        $this->user->id = $user_id;
        return $this->user->updateBalance($amount);
    }
}
?>
