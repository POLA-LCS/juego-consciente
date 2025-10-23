<?php

/**
 * Juego Consciente - Componente Cabecera (Inicio del Layout)
 * Ubicación: ludopatia/app/views/components/Header.php
 * Espera $title para el tab del navegador.
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Juego Consciente'; ?></title>

    <style>
    /* Grand Casino para Títulos principales */
    @font-face {
        font-family: 'Grand Casino';
        src: url('<?php echo BASE_URL; ?>public/assets/fonts/GrandCasino.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    /* Montserrat para UI y Headings secundarios */
    @font-face {
        font-family: 'Montserrat';
        src: url('<?php echo BASE_URL; ?>public/assets/fonts/Montserrat-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    /* Roboto para Cuerpo de texto */
    @font-face {
        font-family: 'Roboto';
        src: url('<?php echo BASE_URL; ?>public/assets/fonts/Roboto-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }
    </style>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/css/tailwind.css">
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col font-['Roboto']">

    <nav class="bg-gray-800 shadow-xl fixed top-0 left-0 right-0 z-40">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="<?php echo BASE_URL; ?>" class="text-3xl text-red-500 font-['Grand Casino'] tracking-wider">
                Juego Consciente
            </a>

            <button id="toggle-account-sidebar" class="text-white hover:text-red-400 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </button>
        </div>
    </nav>

    <div class="pt-16 flex-grow flex">