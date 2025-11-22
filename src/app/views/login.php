<?php
$page_title = 'Login';
?>

<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include SRC_PATH . 'app/views/components/head.php';
?>

<body class="bg-[var(--color-background)] flex flex-col min-h-screen">
    <!-- Componente HeaderAuth -->
    <?php include SRC_PATH . 'app/views/components/headerAuth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div class="form-container">
            <h2 class="text-2xl font-bold mb-6 text-center text-[var(--color-primary)]">Login</h2>
            <?php
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-4 text-center">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                unset($_SESSION['error_message']); // Limpiar el mensaje para que no se muestre de nuevo
            }

            // Mostrar mensaje de éxito si existe (ej: después del registro)
            if (isset($_SESSION['success_message'])) {
                echo '<div class="bg-green-500/20 text-green-300 border border-green-500 p-3 rounded-md mb-4 text-center">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
                unset($_SESSION['success_message']); // Limpiar el mensaje
            }
            ?>
            <form action="?action=login" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Usuario</label>
                    <input required
                        type="text"
                        id="username"
                        name="username"
                        class="w-full
                        px-3 py-2
                        bg-[var(--color-background)]
                        border border-[var(--color-border)]
                        rounded-md
                        focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]
                        ">
                </div>
                <div class="form-group mb-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <input required
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                </div>
                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>
            <p class="mt-4 text-center text-[var(--color-text-muted)]">¿No tienes cuenta? <a href="register" class="form-link">Regístrate</a></p>
        </div>
    </main>
    <!-- Componente Footer -->
    <?php include SRC_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>