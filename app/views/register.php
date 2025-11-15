<?php



$pageTitle = 'Registro';
?>
<!DOCTYPE html>
<html lang="es">
<?php include ROOT_PATH . 'app/views/components/head.php'; // Componente Head
?>

<body class="bg-[var(--color-background)] flex flex-col min-h-screen">
    <!-- Componente HeaderAuth -->
    <?php include ROOT_PATH . 'app/views/components/headerAuth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div
            class="bg-[var(--color-surface)] border border-[var(--color-border)] p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-[var(--color-primary)]">Registro</h2>
            <?php
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-4 text-center">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Limpiar el mensaje para que no se muestre de nuevo
            }
            ?>
            <form action="?action=register" method="POST">
                <div class="mb-4">
                    <label for="username"
                        class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Usuario</label>
                    <input type="text" id="username" name="username"
                        class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email"
                        class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]"
                        required>
                </div>
                <div class="mb-6">
                    <label for="password"
                        class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Contraseña</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]"
                        required>
                </div>
                <button type="submit" class="w-full btn py-2 px-4 rounded-md font-bold">Registrarse</button>
            </form>
            <p class="mt-4 text-center text-[var(--color-text-muted)]">¿Ya tienes cuenta? <a href="?page=login"
                    class="text-[var(--color-primary)] hover:underline">Inicia Sesión</a></p>
        </div>
    </main>
    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>