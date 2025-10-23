<?php

/**
 * Juego Consciente - Archivo de Arranque
 * Ubicación: ludopatia/public/index.php
 */

// 1. Definir la constante de la raíz de la aplicación (fuera de public)
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// 2. Cargar el Autoloader (simulado para este ejemplo sin Composer)
// En un proyecto real, se usaría require ROOT_PATH . 'vendor/autoload.php';
spl_autoload_register(function ($class) {
    // Convierte el namespace a ruta de archivo. Ejemplo: Core\App -> app/core/App.php
    $file = ROOT_PATH . 'app' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, strtolower($class)) . '.php';

    // Si la convención de nombres es PascalCase (ej: App), se ajusta para el require
    $parts = explode(DIRECTORY_SEPARATOR, $file);
    $className = end($parts);

    // Ajustar el nombre de la clase a PascalCase real para el require
    $path = implode(DIRECTORY_SEPARATOR, array_slice($parts, 0, -1)) . DIRECTORY_SEPARATOR;

    // Buscamos la clase real
    if (file_exists($path . ucfirst($className))) {
        require_once $path . ucfirst($className);
    } elseif (file_exists($file)) {
        require_once $file;
    }
});


// 3. Cargar la configuración
require_once ROOT_PATH . 'app/config/Config.php';

// 4. Instanciar y ejecutar el núcleo de la aplicación (Router)
$app = new Core\App();