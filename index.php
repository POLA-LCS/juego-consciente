<?php
session_start();

// Definir la ruta raíz del proyecto para que los includes sean consistentes.
define('ROOT_PATH', __DIR__ . '/');

if (isset($_GET['action'])) {
    include 'app/controllers/UserController.php';
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

    // Lista de páginas que requieren autenticación
    $protected_pages = ['dashboard', 'contact', 'info', 'blackjack', 'cups', 'roulette', 'slots'];

    // Mapeo de rutas a archivos de vista. Facilita añadir nuevas páginas.
    $routes = [
        'login'     => 'app/views/login.php',
        'register'  => 'app/views/register.php',
        'dashboard' => 'app/views/dashboard.php',
        'contact'   => 'app/views/contact.php',
        'info'      => 'app/views/info.php',
        'blackjack' => 'app/views/games/blackjack.php',
        'cups'      => 'app/views/games/cups.php',
        'roulette'  => 'app/views/games/roulette.php',
        'slots'     => 'app/views/games/slots.php',
        'error403'  => 'app/views/errors/403.php', // Ruta para la página de acceso denegado
    ];

    if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
        $page = 'login'; // Si no está logueado y pide una página protegida, lo mandamos al login
    }

    // Si la página solicitada existe en nuestras rutas, la incluimos.
    if (array_key_exists($page, $routes)) {
        // Si estamos mostrando una página de error, establecemos el código de estado HTTP correcto.
        if ($page === 'error403') {
            http_response_code(403);
        }

        include $routes[$page];
    } else {
        // Si la ruta no existe, mostramos un error 404.
        http_response_code(404);
        include 'app/views/errors/404.php'; // Corregido para apuntar a la ruta correcta
    }
}
?>
