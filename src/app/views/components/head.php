<?php
$title = !isset($page_title)
    ? 'Juego Consciente'
    : htmlspecialchars($page_title) . ' - Juego Consciente';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
</head>