<?php
// ¡IMPORTANTE! Esta página NO debe llamar a protect_page() para evitar bucles de redirección.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="bg-[var(--color-background)] flex flex-col items-center justify-center min-h-screen">

    <main class="text-center">
        <h1 class="text-9xl font-bold text-[var(--color-primary)]" style="font-family: 'Grand Casino', sans-serif;">
            403
        </h1>
        <p class="text-2xl md:text-3xl font-bold text-[var(--color-text-base)] mt-4 mb-8">
            Acceso Denegado
        </p>
        <a href="/ludopatia/" class="btn py-3 px-6 rounded-md font-bold text-lg">
            Volver al Inicio
        </a>
    </main>

    <footer class="text-[var(--color-text-muted)] py-4 mt-8 absolute bottom-0">
        <p>Acceso denegado. Por favor, continúa con el flujo natural de la página.</p>
    </footer>

</body>
</html>