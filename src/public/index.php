<?php
session_start();

// --- Definición de Rutas Principales ---

// SRC_PATH: La ruta absoluta a la carpeta 'src'. Ideal para includes de PHP.
// Ejemplo: C:\xampp\htdocs\balta\ludopatia\src\
define('SRC_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// BASE_URL: La URL base de tu proyecto. Ideal para redirecciones y assets.
// Asume que el proyecto está en la raíz del servidor (http://localhost/).
// Si está en un subdirectorio (ej. http://localhost/juego-consciente/),
// deberás ajustarlo a: define('BASE_URL', '/juego-consciente');
define('BASE_URL', '/');

// --- Controlador de Acciones (API) ---
if (isset($_GET['action'])) {
    // Todas las peticiones de acción (como login, register, etc.) se manejan aquí.
    include SRC_PATH . 'app/controllers/UserController.php';
    exit();
}

// Rutas protegidas
$protected_pages = [
    'account',
    'dashboard',
    'contact',
    'info',
    'blackjack',
    'cups',
    'roulette',
    'slots'
];

// Rutas validas
$view_routes = [
    'register'  => 'app/views/register.php',
    'login'     => 'app/views/login.php',
    'dashboard' => 'app/views/dashboard.php',
    'account'   => 'app/views/account.php',
    'info'      => 'app/views/info.php',
    'contact'   => 'app/views/contact.php',
    'blackjack' => 'app/views/games/blackjack.php',
    'cups'      => 'app/views/games/cups.php',
    'roulette'  => 'app/views/games/roulette.php',
    'slots'     => 'app/views/games/slots.php',
    'ERROR_403'  => 'app/views/errors/403.php',
    'ERROR_404'  => 'app/views/errors/404.php',
];

// Entrada inicial
$page = isset($_GET['page']) ? $_GET['page'] : 'register';

// --- Lógica de Enrutamiento ---

// 1. Si la página es protegida y el usuario no está autenticado, redirigir a login.
if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    $page = 'login';
}

// 2. Si la página solicitada no existe en nuestras rutas, mostrar un error 404.
if (!array_key_exists($page, $view_routes)) {
    http_response_code(404);
    $page = 'ERROR_404';
} else if ($page === 'ERROR_403') {
    http_response_code(403);
}

// 4. Cargar la vista correspondiente usando la ruta del servidor (SRC_PATH).
include SRC_PATH . $view_routes[$page];
exit();
