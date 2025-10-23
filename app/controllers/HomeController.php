<?php

namespace App\Controllers;

use Core\Controller;

/**
 * Juego Consciente - Controlador de la Página de Inicio
 * Ubicación: ludopatia/app/controllers/HomeController.php
 */
class HomeController extends Controller
{
    /**
     * Método por defecto: Muestra la página de inicio.
     * Ruta de acceso: / o /home
     */
    public function index()
    {
        // Datos que se pasarán a la vista
        $data = [
            'title' => 'Juego Consciente | Inicio',
            'heading' => '¡Bienvenido al Juego Consciente!',
            // Puedes añadir aquí el modelo de usuario si necesitas saber si está logueado
        ];

        // Cargar la vista principal (app/views/home/index.php)
        $this->view('home/index', $data);
    }
}