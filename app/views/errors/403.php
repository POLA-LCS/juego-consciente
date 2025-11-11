<?php
// ¡IMPORTANTE! Esta página NO debe llamar a protect_page() para evitar bucles de redirección.
?>
<?php
$footer_message = "Acceso denegado. Por favor, continúa con el flujo natural de la página.";
?>
<?php $pageTitle = 'Acceso Denegado'; ?>
<!DOCTYPE html>
<html lang="es">
<?php include ROOT_PATH . 'app/views/components/head.php'; // Componente Head 
?>

<body class="bg-[var(--color-background)] flex flex-col min-h-screen">

    <div class="text-center flex-1 flex items-center justify-center">
        <div class="max-w-md">
            <h1 class="text-9xl font-bold text-[var(--color-primary)]" style="font-family: 'Grand Casino', sans-serif;">
                403
            </h1>
            <p class="text-2xl md:text-3xl font-bold text-[var(--color-text-base)] mt-4 mb-8">
                Acceso Denegado
            </p>
            <a href="index.php" class="btn py-3 px-6 rounded-md font-bold text-lg">
                Volver al Inicio
            </a>
        </div>
    </div>

    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>