<?php

/**
 * Verifica si la aplicación se está ejecutando a través del punto de entrada principal.
 * Si no, muestra una página de error 403 y detiene la ejecución.
 * Esta función debe ser llamada al principio de cada archivo PHP que no deba ser accedido directamente.
 */
function protect_page() {
    if (!defined('APP_RUNNING')) {
        http_response_code(403);
        // Usamos ROOT_PATH para una ruta absoluta y fiable.
        include_once(ROOT_PATH . 'app/views/errors/403.php');
        die();
    }
}