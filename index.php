<?php
session_start();

define('ROOT_PATH', __DIR__ . '/');

if (isset($_GET['action'])) {
    include 'app/controllers/UserController.php';
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

    $protected_pages = ['account', 'dashboard', 'contact', 'info', 'blackjack', 'cups', 'roulette', 'slots'];

    $routes = [
        'login'     => 'app/views/login.php',
        'register'  => 'app/views/register.php',
        'dashboard' => 'app/views/dashboard.php',
        'account'   => 'app/views/account.php',
        'contact'   => 'app/views/contact.php',
        'info'      => 'app/views/info.php',
        'blackjack' => 'app/views/games/blackjack.php',
        'cups'      => 'app/views/games/cups.php',
        'roulette'  => 'app/views/games/roulette.php',
        'slots'     => 'app/views/games/slots.php',
        'error403'  => 'app/views/errors/403.php',
        'error404'  => 'app/views/errors/404.php',
    ];

    if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
        $page = 'login';
    }

    if (array_key_exists($page, $routes)) {
        if ($page === 'error403') {
            http_response_code(403);
        }

        include $routes[$page];
    } else {
        http_response_code(404);
        include 'app/views/errors/404.php';
    }
}
