<?php
$page_title = 'Cups Game';
?>

<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include SRC_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php include SRC_PATH . 'app/views/components/header.php'; ?>

    <div class="game-container">
        <!-- Bet Sidebar (Componente Reutilizable) -->
        <!-- Componente BetSidebar -->
        <?php include SRC_PATH . 'app/views/components/betSidebar.php'; ?>

        <!-- Contenido Principal del Juego -->
        <main class="p-6 flex-1 flex flex-col items-center justify-start">
            <div class="text-center w-full mb-12">
                <h1 class="text-5xl font-bold text-[var(--color-primary)]"
                    style="font-family: 'Grand Casino', sans-serif;">Cups Game</h1>
                <p class="text-xl text-[var(--color-text-muted)] mt-2">¡Encuentra la bola!</p>
            </div>
            <div id="cups-container" class="flex gap-8 mb-8">
                <div id="cup-1"
                    class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300">
                </div>
                <div id="cup-2"
                    class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300">
                </div>
                <div id="cup-3"
                    class="cup w-32 h-32 bg-gray-500 rounded-t-full cursor-pointer transition-transform duration-300">
                </div>
            </div>
            <div id="message-container" class="text-2xl font-bold h-10">&nbsp;</div>
            <button id="playAgain" class="btn py-2 px-6 rounded-md font-bold mt-4 hidden">Jugar de Nuevo</button>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <!-- Componente UserSidebar -->
        <?php include SRC_PATH . 'app/views/components/userSidebar.php'; ?>
        <!-- Componente CheatSidebar -->
        <?php include SRC_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <!-- Componente Footer -->
    <?php include SRC_PATH . 'app/views/components/footer.php'; ?>

    <script src="assets/js/bet.js"></script>
    <script src="assets/js/cups.js"></script>
</body>

</html>