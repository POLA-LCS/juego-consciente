<?php
$page_title = 'Registro';
?>

<!DOCTYPE html>
<html lang="es">
<?php include ROOT_PATH . 'app/views/components/head.php'; // Componente Head
?>

<body class="bg-[var(--color-background)] flex flex-col min-h-screen">
    <!-- Componente HeaderAuth -->
    <?php include ROOT_PATH . 'app/views/components/headerAuth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div class="form-container">
            <h2 class="text-2xl font-bold mb-6 text-center text-[var(--color-primary)]">Registro</h2>
            <?php
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-4 text-center">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                unset($_SESSION['error_message']); // Limpiar el mensaje para que no se muestre de nuevo
            }
            ?>
            <form action="?action=register" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
                <div class="form-group mb-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="btn">Registrarse</button>
            </form>
            <p class="mt-4 text-center text-[var(--color-text-muted)]">¿Ya tienes cuenta? <a href="?page=login" class="form-link">Inicia Sesión</a></p>
        </div>
    </main>
    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>