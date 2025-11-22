<aside id="userSidebar"
    class="fixed right-0 top-0 h-full w-64 bg-[var(--color-surface)] border-l-2 border-[var(--color-primary)] p-4 transform translate-x-full transition-transform duration-300 z-50">
    <button id="closeUserSidebar"
        class="absolute top-2 right-4 text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors text-4xl font-light leading-none">
        &times;
    </button>
    <div class="text-center w-full h-fit mt-5 mb-5">
        <p class="text-lg text-[var(--color-text-base)] font-bold"><?php echo $_SESSION['username']; ?></p>
        <a class="w-fit h-fit" href="account">
            <img class="h-2/3 w-2/3 rounded-full mx-auto" src="assets/images/logo.png" alt="Profile">
        </a>
    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="dashboard" class="sidebar-link text-[var(--color-text-base)]">Inicio</a></li>
            <li><a href="account" class="sidebar-link text-[var(--color-text-base)]">Mi Cuenta</a></li>
            <li><a href="info" class="sidebar-link text-[var(--color-text-base)]">Sobre Ludopatía</a></li>
            <li><a href="contact" class="sidebar-link text-[var(--color-text-base)]">Contacto</a></li>
            <?php
            // Si es un juego entonces añade la opcion de trampas
            if (isset($page) && in_array($page, [
                'blackjack',
                'cups',
                'roulette',
                'slots'
            ])):
            ?>
                <li><a href="#" id="openCheatSidebar" class="sidebar-link-danger sidebar-link text-[var(--color-primary-hover)]">Trampas</a></li>
            <?php endif; ?>
            <li><a href="?action=logout" class="sidebar-link sidebar-link-danger">Cerrar sesión</a></li>
        </ul>
    </nav>
</aside>