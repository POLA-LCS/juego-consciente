<?php

/**
 * Juego Consciente - Archivo de Configuración Global
 * Ubicación: ludopatia/app/config/Config.php
 */

// URL BASE
// Definimos la URL base para generar enlaces internos correctamente.
// Asumiendo que 'ludopatia' es la carpeta raíz del proyecto en htdocs.
define('BASE_URL', 'http://localhost/ludopatia/');

// CONFIGURACIÓN DE BASE DE DATOS
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Asume usuario por defecto de XAMPP
define('DB_PASS', '');     // Asume contraseña vacía por defecto de XAMPP
define('DB_NAME', 'juegoconsciente_db');

// CONFIGURACIÓN DE JUEGO
define('DEFAULT_STARTING_BALANCE', 1000.00);

// CONFIGURACIÓN DE RUTAS CLAVE
define('APP_PATH', ROOT_PATH . 'app' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', APP_PATH . 'views' . DIRECTORY_SEPARATOR);
define('CONTROLLERS_PATH', APP_PATH . 'controllers' . DIRECTORY_SEPARATOR);
define('MODELS_PATH', APP_PATH . 'models' . DIRECTORY_SEPARATOR);

// CONFIGURACIÓN DE SESIÓN
// Para seguridad, siempre inicia la sesión antes de usarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}