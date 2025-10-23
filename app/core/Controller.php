<?php

namespace Core;

/**
 * Juego Consciente - Clase Base para Controladores
 * Ubicación: ludopatia/app/core/Controller.php
 */
class Controller
{
    /**
     * Carga el modelo solicitado.
     * @param string $model Nombre del modelo (ej: 'User').
     * @return object Instancia del modelo.
     */
    protected function model($model)
    {
        // Ruta al archivo del modelo.
        $modelPath = MODELS_PATH . ucfirst($model) . '.php';

        if (file_exists($modelPath)) {
            // Incluir el archivo
            require_once $modelPath;

            // Retornar la instancia del modelo.
            $modelClass = 'App\\Models\\' . ucfirst($model);
            return new $modelClass();
        } else {
            // Manejo de error si el modelo no existe
            die("Error: Modelo no encontrado: " . $model);
        }
    }

    /**
     * Renderiza una vista y le pasa datos.
     * @param string $view Ruta de la vista (ej: 'auth/login').
     * @param array $data Datos a pasar a la vista (opcional).
     */
    protected function view($view, $data = [])
    {
        // Ruta al archivo de la vista.
        $viewPath = VIEWS_PATH . $view . '.php';

        if (file_exists($viewPath)) {
            // Extraer el array $data para que las claves se conviertan en variables
            // (ej: $data['title'] se convierte en $title en la vista).
            extract($data);

            // Incluir la vista.
            require_once $viewPath;
        } else {
            // Manejo de error si la vista no existe
            die("Error: Vista no encontrada: " . $view);
        }
    }
}