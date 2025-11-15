<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/models/User.php';
require_once ROOT_PATH . 'app/models/CheatSettings.php';

$controller = new UserController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'];

                if (empty($username) || empty($email) || empty($password)) {
                    $_SESSION['error_message'] = "Todos los campos son obligatorios.";
                    header("Location: index.php?page=register");
                    exit();
                }

                $is_email_available = $controller->isEmailAvailable($email);

                // ERROR durante la verificacion del email
                if ($is_email_available === null) {
                    $_SESSION['error_message'] = "Lo sentimos, ha ocurrido un error al verificar el e-mail.";
                    header("Location: index.php?page=register");
                    exit();
                }

                if (!$is_email_available) {
                    $_SESSION['error_message'] = "El e-mail ya está en uso.";
                    header("Location: index.php?page=register");
                    exit();
                }

                // Redireccion al login
                $controller->register($username, $email, $password);
                $_SESSION['success_message'] = "¡Registro completado! Por favor, inicia sesión.";
                header("Location: index.php?page=login");
                exit();
            }

        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];

                if ($controller->login($username, $password)) {
                    // Asegurarse de que el usuario tenga settings de cheat al iniciar sesión
                    $controller->ensureCheatSettings($_SESSION['user_id']);
                    header("Location: index.php?page=dashboard");
                    exit();
                } else {
                    // Si el login falla, guardamos un error en la sesión y redirigimos al login.
                    $_SESSION['error_message'] = "Usuario o contraseña incorrectos.";
                    header("Location: index.php?page=login");
                    exit();
                }
            }
            break;
        case 'logout':
            echo $controller->logout();
            header("Location: index.php");
            exit();

        case 'updatePassword':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_id = $_SESSION['user_id'];
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $controller->updatePassword($user_id, $current_password, $new_password, $confirm_password);
            }
            break;
        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_id = $_SESSION['user_id'];
                $controller->deleteAccount($user_id, $_POST['password']);
            }
            exit();
        case 'getBalance':
            $user_id = $_SESSION['user_id'];
            echo $controller->getBalance($user_id);
            break;
        case 'updateBalance':
            $user_id = $_SESSION['user_id'];
            $amount = $_POST['amount'];
            $result = $controller->updateBalance($user_id, $amount);

            // Establecer la cabecera para indicar que la respuesta es JSON
            header('Content-Type: application/json');

            echo json_encode(['success' => ($result !== false), 'newBalance' => $result]);
            exit(); // Es buena práctica usar exit() después de enviar una respuesta AJAX.
        case 'setBalance':
            $user_id = $_SESSION['user_id'];
            $amount = $_POST['amount'];
            $result = $controller->setBalance($user_id, $amount);

            // Establecer la cabecera para indicar que la respuesta es JSON
            header('Content-Type: application/json');

            echo json_encode(['success' => ($result !== false), 'newBalance' => $result]);
            exit();
        case 'getCheatSettings':
            $user_id = $_SESSION['user_id'];
            $settings = $controller->getCheatSettings($user_id);
            header('Content-Type: application/json');
            echo json_encode($settings);
            exit();
        case 'updateCheatSettings':
            $user_id = $_SESSION['user_id'];
            $settings = $_POST; // Recibe todos los datos del formulario
            $result = $controller->updateCheatSettings($user_id, $settings);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit();
        case 'getWinStreak':
            $user_id = $_SESSION['user_id'];
            $streak = $controller->getWinStreak($user_id);
            header('Content-Type: application/json');
            echo json_encode(['win_streak' => $streak]);
            exit();
        case 'setWinStreak':
            $user_id = $_SESSION['user_id'];
            $streak = $_POST['streak'];
            $result = $controller->setWinStreak($user_id, $streak);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit();
        case 'incrementWinStreak':
            $user_id = $_SESSION['user_id'];
            $result = $controller->incrementWinStreak($user_id);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit();
        case 'getPlayerData':
            $user_id = $_SESSION['user_id'];
            $playerData = [
                'balance' => $controller->getBalance($user_id),
                'win_streak' => $controller->getWinStreak($user_id),
                'cheat_settings' => $controller->getCheatSettings($user_id)
            ];
            header('Content-Type: application/json');
            echo json_encode($playerData);
            exit();
    }
}

class UserController
{
    private PDO $db;
    private User $user;
    private CheatSettings $cheatSettings;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->cheatSettings = new CheatSettings($this->db);
    }

    public function register(string $username, string $email, string $password): ?bool
    {
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = $password;

        $user_create_result = $this->user->create();
        if ($user_create_result == false)
            return $user_create_result;

        // Al registrar, también creamos sus settings de cheat por defecto
        $lastId = $this->db->lastInsertId();
        $this->cheatSettings->user_id = $lastId;
        if ($this->cheatSettings->ensureSettings() === null)
            return null;

        return true;
    }

    public function isEmailAvailable(string $email): ?bool
    {
        $this->user->email = $email;
        return $this->user->isEmailAvailable();
    }

    public function login(string $username, string $password): ?bool
    {
        $this->user->username = $username;
        $this->user->password = $password;
        $is_login_valid = $this->user->login();
        if ($is_login_valid !== null) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['username'] = $this->user->username;
        }
        return $is_login_valid;
    }

    public function logout()
    {
        session_destroy();
        return "Logout exitoso.";
    }

    public function updatePassword(int $user_id, string $current_password, string $new_password, string $confirm_password)
    {
        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "Las nuevas contraseñas no coinciden.";
            header("Location: index.php?page=account");
            exit();
        }

        if ($new_password === $current_password) {
            $_SESSION['error_message'] = "La nueva contraseña no puede ser igual a la actual.";
            header("Location: index.php?page=account");
            exit();
        }

        $this->user->id = strval($user_id);
        if ($this->user->updatePassword($current_password, $new_password)) {
            $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
        } else {
            $_SESSION['error_message'] = "La contraseña actual es incorrecta o ha ocurrido un error.";
        }
        header("Location: index.php?page=account");
        exit();
    }

    public function deleteAccount(int $user_id, string $password)
    {
        $this->user->id = strval($user_id);

        // Primero, verificamos la contraseña del usuario
        if (!$this->user->verifyPassword($password)) {
            $_SESSION['error_message'] = "Contraseña incorrecta. No se pudo eliminar la cuenta.";
            header("Location: index.php?page=account");
            exit();
        }

        // Si la contraseña es correcta, procedemos a eliminar
        if ($this->user->delete()) {
            session_destroy();
            header("Location: index.php?page=login");
            exit();
        } else {
            $_SESSION['error_message'] = "Error al eliminar la cuenta.";
            header("Location: index.php?page=account");
            exit();
        }
    }

    public function getUserDetails(int $user_id): ?array
    {
        $this->user->id = strval($user_id);
        return $this->user->getById();
    }

    public function getBalance($user_id)
    {
        $this->user->id = $user_id;
        return $this->user->getBalance();
    }

    public function updateBalance($user_id, $amount)
    {
        $this->user->id = $user_id;
        return $this->user->updateBalance($amount);
    }

    public function setBalance($user_id, $amount)
    {
        $this->user->id = $user_id;
        return $this->user->setBalance($amount);
    }

    public function ensureCheatSettings($user_id)
    {
        CheatSettings::settingsExist($this->db, $user_id);
    }

    public function getCheatSettings($user_id)
    {
        $this->cheatSettings->user_id = $user_id;
        return $this->cheatSettings->ensureSettings();
    }

    public function updateCheatSettings(int $user_id, $settings)
    {
        $this->cheatSettings->user_id = $user_id;
        $this->cheatSettings->mode = $settings['mode'] ?? 0;
        $this->cheatSettings->max_streak = $settings['max_streak'] ?? -1;
        $this->cheatSettings->max_balance = $settings['max_balance'] ?? -1;
        return $this->cheatSettings->updateSettings();
    }

    public function getWinStreak(int $user_id)
    {
        $this->user->id = $user_id;
        return $this->user->getWinStreak();
    }

    public function setWinStreak(int $user_id, int $streak)
    {
        $this->user->id = $user_id;
        return $this->user->setWinStreak($streak);
    }

    public function incrementWinStreak(int $user_id)
    {
        $this->user->id = $user_id;
        return $this->user->incrementWinStreak();
    }
}
