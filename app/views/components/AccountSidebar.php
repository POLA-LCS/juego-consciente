<?php

/**
 * Juego Consciente - Sidebar de Cuenta (y de Trampa)
 * Ubicación: ludopatia/app/views/components/AccountSidebar.php
 * Espera $isLoggedIn (bool), $user (object/array), $isGameView (bool).
 */

$isLoggedIn = $data['isLoggedIn'] ?? false;
$user = $data['user'] ?? null;
$isGameView = $data['isGameView'] ?? false;

?>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"></div>

<aside id="account-sidebar"
    class="fixed right-0 top-0 h-full w-64 bg-gray-800 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 pt-16 border-l border-red-900/50">

    <div class="h-full flex flex-col">
        <header class="p-4 border-b border-red-700 bg-gray-900 text-center">
            <?php if ($isLoggedIn): ?>
            <img src="<?php echo BASE_URL; ?>public/assets/img/juegoconsciente.png" alt="Perfil"
                class="w-16 h-16 mx-auto rounded-full mb-2 border-2 border-red-500">
            <p class="font-['Montserrat'] text-lg font-semibold text-red-400">
                <?php echo htmlspecialchars($user['username'] ?? 'Usuario'); ?></p>
            <p class="text-xs text-gray-400">ID: #<?php echo htmlspecialchars($user['id'] ?? '000'); ?></p>
            <button id="btn-show-cheat"
                class="mt-2 text-sm text-red-500 hover:text-red-300 focus:outline-none <?php echo $isGameView ? 'block' : 'hidden'; ?>">
                ⚙️ Modo Trampas
            </button>
            <?php else: ?>
            <h3 class="text-xl font-['Grand Casino'] text-red-500">Mi Cuenta</h3>
            <?php endif; ?>
        </header>

        <nav id="sidebar-content-normal" class="flex-grow p-4 space-y-2 overflow-y-auto">
            <?php if ($isLoggedIn): ?>
            <a href="<?php echo BASE_URL; ?>user/logout" class="sidebar-item">Cerrar Sesión</a>
            <?php else: ?>
            <a href="<?php echo BASE_URL; ?>user/login" class="sidebar-item">Iniciar Sesión</a>
            <a href="<?php echo BASE_URL; ?>user/register" class="sidebar-item">Registrarse</a>
            <?php endif; ?>

            <div class="py-2"></div>
            <a href="<?php echo BASE_URL; ?>info/politicas" class="sidebar-item">Políticas y Privacidad</a>
            <a href="<?php echo BASE_URL; ?>info/ludopatia" class="sidebar-item">ℹ️ Ludopatía</a>
            <a href="<?php echo BASE_URL; ?>info/contacto" class="sidebar-item">📧 Contacto</a>

        </nav>

        <div id="sidebar-content-cheat" class="hidden flex-grow p-4 space-y-4 overflow-y-auto">
            <button id="btn-show-normal"
                class="text-sm text-red-500 hover:text-red-300 focus:outline-none mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Cuenta
            </button>

            <h4 class="text-xl font-['Montserrat'] text-red-400">Modo GOD</h4>
            <form id="cheat-form" class="space-y-4">
                <div>
                    <label for="cheat-balance" class="block text-sm font-medium text-gray-300">Establecer Saldo:</label>
                    <input type="number" id="cheat-balance" name="balance"
                        class="mt-1 block w-full bg-gray-700 border border-red-700 rounded-md shadow-sm p-2 text-white font-['Roboto'] focus:ring-red-500 focus:border-red-500">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                    <label for="winner-mode" class="text-white font-['Montserrat']">Modo Ganador (Gana Siempre)</label>
                    <input type="checkbox" id="winner-mode" name="winner_mode"
                        class="h-6 w-6 text-red-600 rounded border-gray-600 focus:ring-red-500">
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-900 rounded-lg">
                    <label for="loser-mode" class="text-white font-['Montserrat']">Modo Perdedor (Pierde
                        Siempre)</label>
                    <input type="checkbox" id="loser-mode" name="loser_mode"
                        class="h-6 w-6 text-red-600 rounded border-gray-600 focus:ring-red-500">
                </div>

                <div>
                    <label for="max-balance-lose" class="block text-sm font-medium text-gray-300">Pierde si saldo mayor
                        que:</label>
                    <input type="number" id="max-balance-lose" name="max_balance_lose"
                        class="mt-1 block w-full bg-gray-700 border border-red-700 rounded-md shadow-sm p-2 text-white font-['Roboto']">
                </div>

                <div>
                    <label for="max-wins-lose" class="block text-sm font-medium text-gray-300">Pierde si victorias
                        seguidas >:</label>
                    <input type="number" id="max-wins-lose" name="max_wins_lose"
                        class="mt-1 block w-full bg-gray-700 border border-red-700 rounded-md shadow-sm p-2 text-white font-['Roboto']">
                </div>

                <button type="submit"
                    class="w-full py-2 bg-red-600 hover:bg-red-500 text-white font-['Montserrat'] font-bold rounded-md transition duration-200">
                    Aplicar Trampas
                </button>
            </form>
        </div>

    </div>

    <style>
    .sidebar-item {
        @apply block p-2 text-gray-300 hover: bg-red-900/30 hover:text-red-300 rounded-md transition-colors duration-200 font-['Montserrat'];
    }
    </style>
</aside>