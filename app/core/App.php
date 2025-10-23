<?php

namespace Core;

/**
 * Juego Consciente - Clase Principal de la Aplicación (Router)
 * Ubicación: ludopatia/app/core/App.php
 */
class App
{
    protected $controller = 'Home'; // Controlador por defecto
    protected $method     = 'index';  // Método por defecto
    protected $params     = [];     // Parámetros de la URL

    public function __construct()
    {
        // Obtener y analizar la URL
        $url = $this->parseUrl();

        // 1. Manejo del Controlador
        if (!empty($url) && file_exists(CONTROLLERS_PATH . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]); // Eliminar el controlador del array
        }

        // El nombre completo de la clase del controlador
        $controllerClass = 'App\\Controllers\\' . $this->controller . 'Controller';

        // Instanciar el controlador
        if (!class_exists($controllerClass)) {
            // Esto debería manejarse con una vista 404, por ahora solo muere.
            die("Error: Controlador no encontrado: " . $controllerClass);
        }
        $this->controller = new $controllerClass;

        // 2. Manejo del Método
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]); // Eliminar el método del array
            }
            // Si el método no existe, simplemente se ignora y se usa el por defecto (index)
        }

        // 3. Manejo de Parámetros
        // Los parámetros restantes se reindexan y se pasan como argumentos
        $this->params = $url ? array_values($url) : [];

        // Llamar al método del controlador con sus parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Extrae la URL de la superglobal $_GET y la limpia.
     * @return array La URL segmentada.
     */
    protected function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}