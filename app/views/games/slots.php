<?php
// Verificación de acceso válido
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Slots ';
?>
<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include ROOT_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>

    <div class="game-container">
        <!-- Componente BetSidebar -->
        <?php include ROOT_PATH . 'app/views/components/betSidebar.php'; ?>

        <!-- Contenido Principal del Juego de Slots -->
        <main class="p-6 flex-1 flex flex-col items-center justify-start">
            <div class="text-center w-full mb-12">
                <h1 class="text-5xl font-bold text-[var(--color-primary)]"
                    style="font-family: 'Grand Casino', sans-serif;">Slots</h1>
                <p class="text-xl text-[var(--color-text-muted)] mt-2">¡Gira y gana!</p>
            </div>
            <div id="slots-container"
                class="flex gap-4 mb-8 bg-black/50 p-6 rounded-xl border-4 border-[var(--color-primary)] shadow-lg shadow-[var(--color-primary)]/20">
                <div id="reel-1"
                    class="reel w-28 h-36 bg-[var(--color-surface)] text-6xl flex items-center justify-center rounded-lg border-2 border-[var(--color-border)] shadow-inner">
                    ?
                </div>
                <div id="reel-2"
                    class="reel w-28 h-36 bg-[var(--color-surface)] text-6xl flex items-center justify-center rounded-lg border-2 border-[var(--color-border)] shadow-inner">
                    ?
                </div>
                <div id="reel-3"
                    class="reel w-28 h-36 bg-[var(--color-surface)] text-6xl flex items-center justify-center rounded-lg border-2 border-[var(--color-border)] shadow-inner">
                    ?
                </div>
            </div>
            <div id="message-container" class="text-2xl font-bold h-10">&nbsp;</div>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <!-- Componente UserSidebar -->
        <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
        <!-- Componente CheatSidebar -->
        <?php include ROOT_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

    <script src="public/assets/js/bet.js"></script>
    <script src="public/assets/js/slots.js"></script>
</body>

</html>