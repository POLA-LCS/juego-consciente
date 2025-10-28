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
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>

    <div class="game-container">
        <!-- Contenido Principal del Juego -->
        <main class="p-6 flex-1 flex flex-col items-center justify-center text-center">
            <h1 class="text-5xl font-bold text-[var(--color-primary)] mb-4">Blackjack</h1>
            <p class="text-2xl text-[var(--color-text-muted)] mb-8">Próximamente...</p>
            <a href="?page=dashboard" class="btn py-2 px-6 rounded-md font-bold">Volver al Dashboard</a>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
        <?php include ROOT_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

    <script src="/ludopatia/public/assets/js/user_sidebar.js"></script>
    <script src="/ludopatia/public/assets/js/cheat_sidebar.js"></script>
</body>
</html>
