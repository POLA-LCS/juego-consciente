<?php
// ¡IMPORTANTE! Esta página NO debe llamar a protect_page() para evitar bucles de redirección.
?>
<?php
$footer_message = "No intentes acceder a contenido protegido.";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="public/assets/css/main.css">
</head>
<body class="bg-[var(--color-background)] flex flex-col min-h-screen">

    <div class="text-center flex-1 flex items-center justify-center">
        <div class="max-w-md">
            <h1 class="text-9xl font-bold text-[var(--color-primary)]" style="font-family: 'Grand Casino', sans-serif;">
                404
            </h1>
            <p class="text-2xl md:text-3xl font-bold text-[var(--color-text-base)] mt-4 mb-8">
                Página no Encontrada
            </p>
            <a href="" class="btn py-3 px-6 rounded-md font-bold text-lg">
                Volver al Inicio
            </a>
        </div>
    </div>

    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>
</html>