<?php
require_once SRC_PATH . 'config/database.php';
require_once SRC_PATH . 'app/models/User.php';
require_once SRC_PATH . 'app/models/CheatSettings.php';
require_once SRC_PATH . 'app/models/History.php';

$controller = new UserController();

try {
    switch ($_GET['action']) {
        // ====== ACCIONES QUE MODIFICAN EL USUARIO =========
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                exit;
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'];

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error_message'] = "Todos los campos son obligatorios.";
                header("Location: register");
                exit;
            }

            if (!$controller->isEmailAvailable($email)) {
                $_SESSION['error_message'] = "El e-mail ya está en uso.";
                header("Location: register");
                exit;
            }

            // Redireccion al login
            $controller->register($username, $email, $password);
            $_SESSION['success_message'] = "¡Registro completado! Por favor, inicia sesión.";
            header("Location: login");
            exit;

        case 'login':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                exit;

            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($controller->login($username, $password)) {
                // Asegurarse de que el usuario tenga settings de cheat al iniciar sesión
                $controller->ensureCheatSettings($_SESSION['user_id']);
                header("Location: dashboard");
            } else {
                // Si el login falla, guardamos un error en la sesión y redirigimos al login.
                $_SESSION['error_message'] = "Usuario o contraseña incorrectos.";
                header("Location: login");
            }
            exit;

        case 'logout':
            $controller->logout();
            header("Location: login");
            exit;

        case 'updatePassword':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                exit;
            $user_id = $_SESSION['user_id'];
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            $controller->updatePassword($user_id, $current_password, $new_password, $confirm_password);
            exit;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
                exit;
            $user_id = $_SESSION['user_id'];
            $controller->deleteAccount($user_id, $_POST['password']);
            exit;
            // ====== ACCIONES QUE NO MODIFICAN AL USUARIO =========
        case 'getBalance':
            $user_id = $_SESSION['user_id'];
            echo $controller->getBalance($user_id);
            exit;

        case 'updateBalance':
            $user_id = $_SESSION['user_id'];
            $amount = (float)($_POST['amount'] ?? 0);
            $result = $controller->updateBalance($user_id, $amount);

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'newBalance' => $result]);
            exit;

        case 'setBalance':
            $user_id = $_SESSION['user_id'];
            $amount = (float)($_POST['amount'] ?? 0);
            $result = $controller->setBalance($user_id, $amount);

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'newBalance' => $result]);
            exit;

        case 'getCheatSettings':
            $user_id = $_SESSION['user_id'];
            $settings = $controller->getCheatSettings($user_id);
            header('Content-Type: application/json');
            echo json_encode($settings);
            exit;

        case 'updateCheatSettings':
            $user_id = $_SESSION['user_id'];
            $settings = $_POST; // Recibe todos los datos del formulario
            $controller->updateCheatSettings($user_id, $settings);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;

        case 'getWinStreak':
            $user_id = $_SESSION['user_id'];
            $streak = $controller->getWinStreak($user_id);
            header('Content-Type: application/json');
            echo json_encode(['win_streak' => $streak]);
            exit;

        case 'setWinStreak':
            $user_id = $_SESSION['user_id'];
            $streak = (int)($_POST['streak'] ?? 0);
            $controller->setWinStreak($user_id, $streak);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;

        case 'incrementWinStreak':
            $user_id = $_SESSION['user_id'];
            $controller->incrementWinStreak($user_id);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;

        case 'getPlayerData':
            $user_id = $_SESSION['user_id'];
            $playerData = [
                'balance' => $controller->getBalance($user_id),
                'win_streak' => $controller->getWinStreak($user_id),
                'cheat_settings' => $controller->getCheatSettings($user_id)
            ];
            header('Content-Type: application/json');
            echo json_encode($playerData);
            exit;
    }
} catch (PDOException $e) {
    // Loggear el error $e->getMessage() en un entorno de producción
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos.']);
    } else {
        $_SESSION['error_message'] = "Ha ocurrido un error inesperado en el servidor.";
        // Redirigir a una página de error o a la página anterior
        $page = $_GET['page'] ?? 'login';
        header("Location: " . $page);
    }
    exit;
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

    public function register(
        string $username,
        string $email,
        string $password
    ): void {
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = $password;

        $this->user->create();

        // Al registrar, también creamos sus settings de cheat por defecto
        $lastId = (int)$this->db->lastInsertId();
        $this->cheatSettings->user_id = $lastId;
        $this->cheatSettings->ensureSettings();
    }

    public function isEmailAvailable(string $email): bool
    {
        $this->user->email = $email;
        return $this->user->isEmailAvailable();
    }

    public function login(
        string $username,
        string $password
    ): bool {
        $this->user->username = $username;
        $this->user->password = $password;
        if ($this->user->login()) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['username'] = $this->user->username;
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_start(); // Asegura que la sesión esté activa para destruirla
        session_destroy();
    }

    public function updatePassword(
        int $user_id,
        string $current_password,
        string $new_password,
        string $confirm_password
    ) {
        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "Las nuevas contraseñas no coinciden.";
            header("Location: account");
            exit;
        }

        if ($new_password === $current_password) {
            $_SESSION['error_message'] = "La nueva contraseña no puede ser igual a la actual.";
            header("Location: account");
            exit;
        }

        $this->user->id = $user_id;
        $this->user->updatePassword($current_password, $new_password);
        $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
        header("Location: account");
        exit;
    }

    public function deleteAccount(
        int $user_id,
        string $password
    ): void {
        $this->user->id = $user_id;

        // Primero, verificamos la contraseña del usuario
        if (!$this->user->verifyPassword($password)) {
            $_SESSION['error_message'] = "Contraseña incorrecta. No se pudo eliminar la cuenta.";
            header("Location: account");
            exit;
        }

        // Si la contraseña es correcta, procedemos a eliminar
        $this->user->delete();
        $this->logout();
        header("Location: login");
        exit;
    }

    public function getUserDetails(int $user_id): array
    {
        $this->user->id = $user_id;
        return $this->user->getById();
    }

    public function getBalance(int $user_id): float
    {
        $this->user->id = $user_id;
        return $this->user->getBalance();
    }

    public function updateBalance(
        int $user_id,
        float $amount
    ): float {
        $this->user->id = $user_id;
        return $this->user->updateBalance($amount);
    }

    public function setBalance(
        int $user_id,
        float $amount
    ): float {
        $this->user->id = $user_id;
        return $this->user->setBalance($amount);
    }

    public function ensureCheatSettings(int $user_id): void
    {
        CheatSettings::settingsExist($this->db, $user_id);
    }

    public function getCheatSettings(int $user_id): array
    {
        $this->cheatSettings->user_id = $user_id;
        return $this->cheatSettings->ensureSettings();
    }

    public function updateCheatSettings(
        int $user_id,
        array $settings
    ): void {
        $this->cheatSettings->user_id = $user_id;
        $this->cheatSettings->mode = $settings['mode'] ?? 0;
        $this->cheatSettings->max_streak = $settings['max_streak'] ?? -1;
        $this->cheatSettings->max_balance = $settings['max_balance'] ?? -1;
        $this->cheatSettings->updateSettings();
    }

    public function getWinStreak(int $user_id): int
    {
        $this->user->id = $user_id;
        return $this->user->getWinStreak();
    }

    public function setWinStreak(
        int $user_id,
        int $streak
    ): void {
        $this->user->id = $user_id;
        $this->user->setWinStreak($streak);
    }

    public function incrementWinStreak(int $user_id): void
    {
        $this->user->id = $user_id;
        $this->user->incrementWinStreak();
    }
}
