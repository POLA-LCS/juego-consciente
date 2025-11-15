<?php
// Verificación de acceso válido
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Inicio';
?>
<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include ROOT_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>
    <!-- Componente UserSidebar -->
    <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
    <?php /* 
    <!-- Componente CheatSidebar -->
    include ROOT_PATH . 'app/views/components/cheatSidebar.php'; */ ?>

    <!-- Main Content -->
    <main class="p-6">
        <div class="flex justify-center items-center mb-8">
            <h1
                style="font-family: 'Grand Casino', sans-serif;"
                class="text-5xl font-bold text-[var(--color-primary)] ludo-title">
                ¡A Jugar!</h1>
        </div>
        <div class="flex justify-center">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Tarjeta de Juego -->
                <!-- <div class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group"
                    onclick="window.location.href='?page=blackjack'">
                    <div class="relative h-80">
                        <img src="public/assets/images/card.jpg" alt="Blackjack" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h2
                                class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">
                                Blackjack</h2>
                        </div>
                    </div>
                </div> -->
                <a href="?page=cups" class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group">
                    <div class="relative h-80">
                        <img src="public/assets/images/cups.jpeg" alt="Cups Game" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-65 group-hover:bg-opacity-55 transition-all duration-200"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h2
                                class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">
                                Cups Game</h2>
                        </div>
                    </div>
                </a>
                <a href="?page=roulette" class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group">
                    <div class="relative h-80">
                        <img src="public/assets/images/roulette.jpeg" alt="Ruleta" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-65 group-hover:bg-opacity-55 transition-all duration-200"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h2
                                class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">
                                Ruleta</h2>
                        </div>
                    </div>
                </a>
                <a href="?page=slots" class="game-card bg-[var(--color-surface)] rounded-lg shadow-lg cursor-pointer overflow-hidden group">
                    <div class="relative h-80">
                        <img src="public/assets/images/slots.jpeg" alt="Slots" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-65 group-hover:bg-opacity-55 transition-all duration-200"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h2
                                class="text-3xl font-bold text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">
                                Slots</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

</body>

</html>