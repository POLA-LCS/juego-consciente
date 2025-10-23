<?php

/**
 * Juego Consciente - Vista de Inicio
 * Ubicación: ludopatia/app/views/home/index.php
 * Datos esperados: $title, $heading
 */

// Placeholder para el componente de Cabecera (incluye HTML head y estilos)
// Lo implementaremos cuando definamos el layout base
// require_once VIEWS_PATH . 'components/header.php'; 

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Juego Consciente'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/css/tailwind.css">
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">

    <header class="bg-red-800 p-4 shadow-lg text-center">
        <h1 class="text-3xl font-bold font-['Grand Casino']">Juego Consciente</h1>
    </header>

    <main class="flex-grow container mx-auto p-6">
        <section class="text-center py-10">
            <h2 class="text-4xl font-['Montserrat'] font-semibold mb-4 text-red-400">
                <?php echo $heading ?? 'Cargando...'; ?>
            </h2>
            <p class="text-lg text-gray-300 font-['Roboto']">
                Si ves este mensaje, el **Flujo MVC** (`index.php -> App.php -> HomeController.php -> index.php`)
                funciona correctamente.
            </p>
            <p class="mt-4 text-sm text-gray-500">
                A continuación: **Configuración de Tailwind CSS** y el **`.htaccess`**.
            </p>
        </section>
    </main>

    <footer class="bg-gray-800 p-4 text-center text-sm text-gray-400">
        &copy; <?php echo date('Y'); ?> Juego Consciente.
    </footer>
</body>

</html>


<?php
// Placeholder para el componente de Pie de página
// require_once VIEWS_PATH . 'components/footer.php'; 
?>