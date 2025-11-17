<?php
$page_title = 'Cuenta';

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

    <main class="p-8 flex-1">
        <div class="max-w-lg mx-auto">
            <h1 class="text-4xl font-bold mb-6 text-center text-[var(--color-primary)]">Mi Cuenta</h1>

            <?php
            // Mostrar mensajes de error o éxito
            if (isset($_SESSION['error_message'])) {
                echo '<div class="bg-red-500/20 text-red-300 border border-red-500 p-3 rounded-md mb-6 text-center">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                unset($_SESSION['error_message']);
            }
            if (isset($_SESSION['success_message'])) {
                echo '<div class="bg-green-500/20 text-green-300 border border-green-500 p-3 rounded-md mb-6 text-center">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
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
                        <form action="?action=updatePassword" method="POST" class="pt-4">
                            <div class="form-group">
                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                <input required
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="form-label">Nueva Contraseña</label>
                                <input required
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <input required
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                            </div>
                            <button type="submit" class="btn mt-6">Actualizar Contraseña</button>
                        </form>
                    </div>
                </details>

                <!-- Eliminar Cuenta (Desplegable) -->
                <details class="animated bg-red-900/30 border border-red-500 rounded-lg shadow-lg cursor-pointer overflow-hidden">
                    <summary class="p-4 text-lg font-bold text-red-400">Eliminar Cuenta</summary>
                    <div class="details-content px-4 pb-4">
                        <p class="text-red-300 mb-4 text-sm pt-4">Esta acción es irreversible. Perderás todo tu progreso y datos de la cuenta. Para confirmar, introduce tu contraseña actual.</p>
                        <form action="?action=delete" method="POST">
                            <div class="form-group">
                                <label for="delete_confirm_password" class="form-label text-red-300">Contraseña Actual</label>
                                <input required
                                    type="password"
                                    id="delete_confirm_password"
                                    name="password"
                                    class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md font-bold transition-colors mt-4">Eliminar Mi Cuenta Permanentemente</button>
                        </form>
                    </div>
                </details>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="?page=dashboard" class="btn inline-block w-auto px-6">Volver al Inicio</a>
        </div>
    </main>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>
    <script src="public/assets/js/details_animation.js"></script>

</body>

</html>