<?php
// Verificación de acceso válido
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Slots';
?>
<!DOCTYPE html>
<html lang="es">
<?php include ROOT_PATH . 'app/views/components/head.php'; // Componente Head 
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>
    <!-- Componente UserSidebar -->
    <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>

    <main class="p-6 flex-1">
        <h1 class="text-3xl font-bold text-center">Slots</h1>
        <p class="text-center">Contenido del juego Slots...</p>
    </main>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>