<?php
session_start();

define('ROOT_PATH', __DIR__ . '/');

if (isset($_GET['action'])) {
    include 'app/controllers/UserController.php';
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
$routes = [
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
];

// Entrada inicial
$page = isset($_GET['page']) ? $_GET['page'] : 'register';

// Verificar si la página es protegida y si el usuario no está autenticado
if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    $page = 'login';
}

// Pagina no existente
if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    include 'app/views/errors/404.php';
    exit();
}

if ($page === 'ERROR_403') {
    http_response_code(403);
}

include $routes[$page];
exit();
