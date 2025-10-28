<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="bg-[var(--color-background)] flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/partials/header_auth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-[var(--color-primary)]">Login</h2>
            <?php
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-4 text-center">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Limpiar el mensaje para que no se muestre de nuevo
            }

            // Mostrar mensaje de éxito si existe (ej: después del registro)
            if (isset($_SESSION['success_message'])) {
                echo '<div class="bg-green-500/20 text-green-300 border border-green-500 p-3 rounded-md mb-4 text-center">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']); // Limpiar el mensaje
            }
            ?>
            <form action="?action=login" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Usuario</label>
                    <input type="text" id="username" name="username" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <button type="submit" class="w-full btn py-2 px-4 rounded-md font-bold">Iniciar Sesión</button>
            </form>
            <p class="mt-4 text-center text-[var(--color-text-muted)]">¿No tienes cuenta? <a href="?page=register" class="text-[var(--color-primary)] hover:underline">Regístrate</a></p>
        </div>
    </main>
    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>
</body>
</html>
    </div>
</body>
</html>
