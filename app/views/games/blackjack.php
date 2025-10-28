<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body>
    <?php include ROOT_PATH . 'app/views/partials/header.php'; ?>
    <?php include ROOT_PATH . 'app/views/partials/sidebar.php'; ?>
    <?php /* include ROOT_PATH . 'app/views/partials/cheat_sidebar.php'; */ // Descomenta si tienes este archivo ?>

    <div class="p-6">
    <main class="p-6">
        <div class="flex justify-between items-center mb-6">
            <button id="openBetSidebar" class="btn-red text-white py-2 px-4 rounded-md mr-4">Apuesta</button>
            <h1 class="text-3xl font-bold text-red-500">Blackjack</h1>
            <div>
                <span>Saldo: <span id="balance">1000</span></span>
                <a href="?page=dashboard" class="btn-red text-white py-2 px-4 rounded-md ml-4">Volver</a>
            </div>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800 p-4 rounded-lg">
            <h2 class="text-xl font-bold mb-4 text-red-500">Dealer</h2>
            <div id="dealerCards" class="mb-4"></div>
            <div id="dealerScore">Puntuación: 0</div>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg">
            <h2 class="text-xl font-bold mb-4 text-red-500">Jugador</h2>
            <div id="playerCards" class="mb-4"></div>
            <div id="playerScore">Puntuación: 0</div>
        </div>
    </div>

    <!-- Bet Sidebar -->
    <aside id="betSidebar" class="fixed left-0 top-0 h-full w-64 bg-gray-800 p-4 transform -translate-x-full transition-transform duration-300 z-50">
        <h3 class="text-xl font-bold mb-4 text-red-500">Configurar Apuesta</h3>
        <div class="flex flex-wrap gap-2 mb-4">
            <button id="minus1" class="btn-red text-white py-2 px-4 rounded-md">-1</button>
            <button id="minus10" class="btn-red text-white py-2 px-4 rounded-md">-10</button>
            <button id="minus100" class="btn-red text-white py-2 px-4 rounded-md">-100</button>
            <button id="plus1" class="btn-red text-white py-2 px-4 rounded-md">+1</button>
            <button id="plus10" class="btn-red text-white py-2 px-4 rounded-md">+10</button>
            <button id="plus100" class="btn-red text-white py-2 px-4 rounded-md">+100</button>
            <button id="resetBet" class="btn-red text-white py-2 px-4 rounded-md">Reset</button>
        </div>
        <div class="mb-4">
            <span>Apuesta actual: <span id="currentBet">10</span></span>
        </div>
        <button id="placeBet" class="btn-red text-white py-2 px-4 rounded-md">Apostar</button>
        <button id="closeBetSidebar" class="btn-red text-white py-2 px-4 rounded-md mt-4">Cerrar</button>
    </aside>

    <div class="mt-6">
        <button id="hit" class="btn-red text-white py-2 px-4 rounded-md mr-4" disabled>Pedir Carta</button>
        <button id="stand" class="btn-red text-white py-2 px-4 rounded-md" disabled>Plantarse</button>
    </div>

    </div>
    </main>

    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>

    <script>
        const userSidebar = document.getElementById('userSidebar');
        const openUserSidebar = document.getElementById('openUserSidebar');
        const closeUserSidebar = document.getElementById('closeUserSidebar');
        const betSidebar = document.getElementById('betSidebar');
        const openBetSidebar = document.getElementById('openBetSidebar');
        const closeBetSidebar = document.getElementById('closeBetSidebar');

        openUserSidebar.addEventListener('click', () => {
            userSidebar.classList.remove('translate-x-full');
        });

        closeUserSidebar.addEventListener('click', () => {
            userSidebar.classList.add('translate-x-full');
        });

        openBetSidebar.addEventListener('click', () => {
            betSidebar.classList.toggle('-translate-x-full');
        });

        closeBetSidebar.addEventListener('click', () => {
            betSidebar.classList.add('-translate-x-full');
        });

    </script>
    <script src="/ludopatia/public/assets/js/blackjack.js"></script>
</body>
</html>
