<?php
// Verificación de acceso válido
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

// Define el título de la página. Si $pageTitle no está definida, usa un título por defecto.
$title = isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Juego Consciente' : 'Juego Consciente';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="public/assets/css/main.css">
</head>