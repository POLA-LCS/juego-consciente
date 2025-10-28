<?php

/**
 * Verifica si la constante ROOT_PATH está definida. Si no lo está, significa que
 * el script no se ha ejecutado a través de index.php.
 * Si no, muestra una página de error 403 y detiene la ejecución.
 */
function protect_page() {
    if (!defined('ROOT_PATH')) {
        // Redirigimos al router principal para que muestre la página de error.
        header('Location: /ludopatia/index.php?page=error403');
        exit(); // Es crucial detener la ejecución después de una redirección.
    }
}