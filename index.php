<?php
session_start();

// Definir la ruta raíz del proyecto para que los includes sean consistentes.
define('ROOT_PATH', __DIR__ . '/');

if (isset($_GET['action'])) {
    include 'app/controllers/UserController.php';
} else {
    // Lista de páginas que requieren autenticación
    $protected_pages = ['dashboard', 'contact', 'info', 'blackjack', 'cups', 'roulette', 'slots'];
    $page = isset($_GET['page']) ? $_GET['page'] : 'login';

    if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
        $page = 'login'; // Si no está logueado y pide una página protegida, lo mandamos al login
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 'login';
    switch ($page) {
        case 'login':
            include 'app/views/login.php';
            break;
        case 'register':
            include 'app/views/register.php';
            break;
        case 'dashboard':
            include 'app/views/dashboard.php';
            break;
        case 'contact':
            include 'app/views/contact.php';
            break;
        case 'info':
            include 'app/views/info.php';
            break;
        case 'blackjack':
            include 'app/views/games/blackjack.php';
            break;
        case 'cups':
            include 'app/views/games/cups.php';
            break;
        case 'roulette':
            include 'app/views/games/roulette.php';
            break;
        case 'slots':
            include 'app/views/games/slots.php';
            break;
        default:
            include 'app/views/login.php';
    }
}
?>
