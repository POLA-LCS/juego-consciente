<?php
// Verificación de acceso válido
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Roulette';
?>
<!DOCTYPE html>
<html lang="es">
<?php include ROOT_PATH . 'app/views/components/head.php'; ?>
<body class="flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>
    <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>

    <main class="p-6 flex-1">
        <h1 class="text-3xl font-bold text-center">Roulette</h1>
        <p class="text-center">Contenido del juego Roulette...</p>
    </main>

    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>
</html>