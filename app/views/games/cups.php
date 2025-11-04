<?php
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cups Game - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>

    <div class="game-container">
        <!-- Bet Sidebar (Componente Reutilizable) -->
        <?php include ROOT_PATH . 'app/views/components/betSidebar.php'; ?>

        <!-- Contenido Principal del Juego -->
        <main class="p-6 flex-1 flex flex-col items-center justify-start">
            <div class="text-center w-full mb-12">
                <h1 class="text-5xl font-bold text-[var(--color-primary)]" style="font-family: 'Grand Casino', sans-serif;">Cups Game</h1>
                <p class="text-xl text-[var(--color-text-muted)] mt-2">¡Encuentra la bola!</p>
            </div>
            <div id="cups-container" class="flex gap-8 mb-8">
                <div id="cup-1" class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300"></div>
                <div id="cup-2" class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300"></div>
                <div id="cup-3" class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300"></div>
            </div>
            <div id="message-container" class="text-2xl font-bold h-10">&nbsp;</div>
            <button id="playAgain" class="btn py-2 px-6 rounded-md font-bold mt-4 hidden">Jugar de Nuevo</button>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
        <?php include ROOT_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

    <script src="/ludopatia/public/assets/js/user_sidebar.js"></script>
    <script src="/ludopatia/public/assets/js/cheat_sidebar.js"></script>
    <script src="/ludopatia/public/assets/js/cups.js"></script>
</body>
</html>