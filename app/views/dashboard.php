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
    <div class="p-6">
        <div class="flex justify-end items-center mb-6">
            <h1 class="text-3xl font-bold text-red-500">Dashboard</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg text-center cursor-pointer hover:bg-gray-700 transition" onclick="window..href='?page=blackjack'">
                <img src="/ludopatia/public/assets/images/card.jpg" alt="Blackjack" class="w-full h-32 object-cover rounded mb-2">
                <h2 class="text-xl font-bold text-red-500">Blackjack</h2>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg text-center cursor-pointer hover:bg-gray-700 transition" onclick="window.location.href='?page=cups'">
                <img src="/ludopatia/public/assets/images/card.jpg" alt="Cups Game" class="w-full h-32 object-cover rounded mb-2">
                <h2 class="text-xl font-bold text-red-500">Cups Game</h2>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg text-center cursor-pointer hover:bg-gray-700 transition" onclick="window.location.href='?page=roulette'">
                <img src="/ludopatia/public/assets/images/card.jpg" alt="Roulette" class="w-full h-32 object-cover rounded mb-2">
                <h2 class="text-xl font-bold text-red-500">Roulette</h2>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg text-center cursor-pointer hover:bg-gray-700 transition" onclick="window.location.href='?page=slots'">
                <img src="/ludopatia/public/assets/images/card.jpg" alt="Slots" class="w-full h-32 object-cover rounded mb-2">
                <h2 class="text-xl font-bold text-red-500">Slots</h2>
            </div>
        </div>
    </div>

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
