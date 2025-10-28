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
        <div class="flex justify-end items-center mb-6">
            <h1 class="text-5xl font-bold text-red-500" style="font-family: 'Grand Casino', sans-serif;">¡A Jugar!</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tarjeta de Juego -->
            <div class="game-card bg-gray-800 rounded-lg shadow-lg text-center cursor-pointer overflow-hidden" onclick="window.location.href='?page=blackjack'">
                <div class="relative h-56">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Blackjack" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <h2 class="absolute bottom-4 left-0 right-0 text-2xl font-bold text-white">Blackjack</h2>
                </div>
            </div>
            <div class="game-card bg-gray-800 rounded-lg shadow-lg text-center cursor-pointer overflow-hidden" onclick="window.location.href='?page=cups'">
                <div class="relative h-56">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Cups Game" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <h2 class="absolute bottom-4 left-0 right-0 text-2xl font-bold text-white">Cups Game</h2>
                </div>
            </div>
            <div class="game-card bg-gray-800 rounded-lg shadow-lg text-center cursor-pointer overflow-hidden" onclick="window.location.href='?page=roulette'">
                <div class="relative h-56">
                    <img src="/ludopatia/public/assets/images/card.jpg" alt="Roulette" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <h2 class="absolute bottom-4 left-0 right-0 text-2xl font-bold text-white">Roulette</h2>
                </div>
            </div>
        </div>
    </main>

    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>

    <script>
        const userSidebar = document.getElementById('userSidebar');
        const openUserSidebar = document.getElementById('openUserSidebar'); // Botón en el header
        const closeUserSidebar = document.getElementById('closeUserSidebar'); // Botón 'x' en el sidebar

        openUserSidebar.addEventListener('click', () => {
            userSidebar.classList.remove('translate-x-full');
        });

        closeUserSidebar.addEventListener('click', () => {
            userSidebar.classList.add('translate-x-full');
        });
    </script>
</body>
</html>
