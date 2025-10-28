<?php
// Este archivo es un punto de entrada obsoleto. Se protege para forzar el flujo correcto.
require_once __DIR__ . '/../app/helpers/security.php';
protect_page();

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../app/views/dashboard.php");
    exit();
} else {
    header("Location: ../app/views/login.php");
    exit();
}
?>
