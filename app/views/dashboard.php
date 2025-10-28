<?php
// Cláusula de guarda: si la constante APP_RUNNING no está definida, significa que se está accediendo directamente al archivo.
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    include_once(__DIR__ . '/errors/404.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body>
    <?php include ROOT_PATH . 'app/views/partials/header.php'; ?>
    <?php include ROOT_PATH . 'app/views/partials/sidebar.php'; ?>
    <?php /* include ROOT_PATH . 'app/views/partials/cheat_sidebar.php'; */ // Descomenta si tienes este archivo ?>

    <!-- Main Content -->
    <main class="p-6">
        <div class="flex justify-center items-center mb-8">
            <h1 class="text-5xl font-bold text-[var(--color-primary)]" style="font-family: 'Grand Casino', sans-serif;">¡A Jugar!</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 max-w-6xl mx-auto center-grid">
            <!-- Tarjeta de Juego -->
            <div class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group" onclick="window.location.href='?page=blackjack'">
                <div class="relative h-80">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Blackjack" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">Blackjack</h2>
                    </div>
                </div>
            </div>
            <div class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group" onclick="window.location.href='?page=cups'">
                <div class="relative h-80">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Cups Game" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">Cups Game</h2>
                    </div>
                </div>
            </div>
            <div class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group" onclick="window.location.href='?page=roulette'">
                <div class="relative h-80">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Roulette" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">Roulette</h2>
                    </div>
                </div>
            </div>
            <div class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group" onclick="window.location.href='?page=slots'">
                <div class="relative h-80">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Slots" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">Slots</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>

    <script src="/ludopatia/public/assets/js/sidebar.js"></script>
</body>
</html>
