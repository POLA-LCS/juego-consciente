<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
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
    <title>Blackjack - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/partials/header.php'; ?>

    <div class="game-container">
        <!-- Bet Sidebar (Componente Reutilizable) -->
        <?php include ROOT_PATH . 'app/views/partials/bet_sidebar.php'; ?>

        <!-- Contenido Principal del Juego -->
        <main class="p-6 flex-1">
            <h1 class="text-3xl font-bold text-[var(--color-primary)] mb-6">Blackjack</h1>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <?php include ROOT_PATH . 'app/views/partials/sidebar.php'; ?>
        <?php /* include ROOT_PATH . 'app/views/partials/cheat_sidebar.php'; */ ?>
    </div>

    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>

    <script src="/ludopatia/public/assets/js/user_sidebar.js"></script>
    <script src="/ludopatia/public/assets/js/bet_sidebar.js"></script>
    <script src="/ludopatia/public/assets/js/blackjack.js"></script>
</body>
</html>
