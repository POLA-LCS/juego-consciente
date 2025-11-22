<?php
$page_title = 'Página no Encontrada';
$footer_message = "No intentes acceder a contenido protegido.";
?>

<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php require SRC_PATH . 'app/views/components/head.php';
?>

<body class="bg-[var(--color-background)] flex flex-col min-h-screen">
    <?php
    $dontUseUserSidebarIcon = true;
    require SRC_PATH . 'app/views/components/headerAuth.php';
    ?>

    <div class="text-center flex-1 flex items-center justify-center">
        <div class="max-w-md">
            <h1
                class="text-9xl font-bold text-[var(--color-primary)]"
                style="font-family: 'Grand Casino', sans-serif;">
                404
            </h1>
            <p class="text-2xl md:text-3xl font-bold text-[var(--color-text-base)] mt-4 mb-8">
                Página no Encontrada
            </p>
            <a href="dashboard" class="btn py-3 px-6 rounded-md font-bold text-lg">
                Volver al Inicio
            </a>
        </div>
    </div>

    <?php require SRC_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>