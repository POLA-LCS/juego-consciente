<?php
// Verificación de acceso válido
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}

$pageTitle = 'Cuenta';

// Incluir el controlador para obtener los datos del usuario
require_once ROOT_PATH . 'app/controllers/UserController.php';
$userController = new UserController();
$userData = $userController->getUserDetails($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include ROOT_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php $dontUseUserSidebarIcon = true; ?>
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>

    <main class="p-6 flex-1">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold mb-6 text-center text-[var(--color-primary)]">Mi Cuenta</h1>

            <?php
            // Mostrar mensajes de error o éxito
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-6 text-center">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            if (isset($_SESSION['success_message'])) {
                echo '<div class="bg-green-500/20 text-green-300 border border-green-500 p-3 rounded-md mb-6 text-center">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            ?>

            <!-- Tarjeta de Perfil del Usuario -->
            <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-10 flex items-center space-x-6">
                <img src="public/assets/images/logo.png" alt="Foto de perfil" class="h-24 w-24 rounded-full border-2 border-[var(--color-primary)]">
                <div>
                    <h2 class="leading-relaxed text-3xl font-bold text-white"><?php echo htmlspecialchars($userData['username']); ?></h2>
                    <p class="leading-relaxed text-sm text-[var(--color-text-muted)]"><strong class="text-[var(--color-primary-hover)]">ID:</strong> <?php echo htmlspecialchars($userData['id']); ?></p>
                    <p class="leading-relaxed text-sm text-[var(--color-text-muted)]"><strong class="text-[var(--color-primary-hover)]">Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                    <p class="leading-relaxed text-sm text-[var(--color-text-muted)]"><strong class="text-[var(--color-primary-hover)]">Miembro desde:</strong> <?php echo date('d/m/Y', strtotime($userData['created_at'])); ?></p>
                </div>
            </div>

            <!-- Opciones de la cuenta -->
            <div class="space-y-4">
                <!-- Cambiar Contraseña (Desplegable) -->
                <details class="animated bg-[var(--color-surface)] border border-[var(--color-border)] rounded-lg shadow-lg cursor-pointer overflow-hidden">
                    <summary class="p-4 text-lg font-bold text-[var(--color-primary)]">Cambiar Contraseña</summary>
                    <div class="details-content px-4 pb-4">
                        <form action="?action=updatePassword" method="POST" class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Contraseña Actual</label>
                                <input type="password" id="current_password" name="current_password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Nueva Contraseña</label>
                                <input type="password" id="new_password" name="new_password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                            </div>
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Confirmar Nueva Contraseña</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                            </div>
                            <button type="submit" class="w-full btn py-2 px-4 rounded-md font-bold">Actualizar Contraseña</button>
                        </form>
                    </div>
                </details>

                <!-- Eliminar Cuenta (Desplegable) -->
                <details class="animated bg-red-900/30 border border-red-500 rounded-lg shadow-lg cursor-pointer overflow-hidden">
                    <summary class="p-4 text-lg font-bold text-red-400">Eliminar Cuenta</summary>
                    <div class="details-content px-4 pb-4">
                        <p class="text-red-300 mb-4 text-sm">Esta acción es irreversible. Perderás todo tu progreso y datos de la cuenta. Para confirmar, introduce tu contraseña actual.</p>
                        <form action="?action=delete" method="POST" class="space-y-4">
                            <div>
                                <label for="delete_confirm_password" class="block text-sm font-medium mb-2 text-red-300">Contraseña Actual</label>
                                <input type="password" id="delete_confirm_password" name="password" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md font-bold transition-colors">Eliminar Mi Cuenta Permanentemente</button>
                        </form>
                    </div>
                </details>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="?page=dashboard" class="btn py-2 px-6 rounded-md font-bold">Volver al Inicio</a>
        </div>
    </main>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
    <script src="public/assets/js/details_animation.js"></script>

</body>

</html>