<?php
protect_page();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/partials/header_auth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-[var(--color-primary)]">Registro</h2>
            <form action="?action=register" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Usuario</label>
                    <input type="text" id="username" name="username" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <button type="submit" class="w-full btn py-2 px-4 rounded-md font-bold">Registrarse</button>
            </form>
            <p class="mt-4 text-center text-[var(--color-text-muted)]">¿Ya tienes cuenta? <a href="?page=login" class="text-[var(--color-primary)] hover:underline">Inicia Sesión</a></p>
        </div>
    </main>
    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>
</body>
</html>
