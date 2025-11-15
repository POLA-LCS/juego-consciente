<?php
// Verificación de acceso válido
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Blackjack';
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
        <!-- Contenido Principal del Juego -->
        <main class="p-6 flex-1 flex flex-col items-center justify-center text-center">
            <h1 class="text-5xl font-bold text-[var(--color-primary)] mb-4">Blackjack</h1>
            <p class="text-2xl text-[var(--color-text-muted)] mb-8">Próximamente...</p>
            <a href="?page=dashboard" class="btn py-2 px-6 rounded-md font-bold">Volver al Inicio</a>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <!-- Componente UserSidebar -->
        <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
        <!-- Componente CheatSidebar -->
        <?php include ROOT_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

</body>

</html>