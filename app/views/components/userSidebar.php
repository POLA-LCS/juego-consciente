<aside id="userSidebar"
    class="fixed right-0 top-0 h-full w-64 bg-[var(--color-surface)] border-l-2 border-[var(--color-primary)] p-4 transform translate-x-full transition-transform duration-300 z-50">
    <button id="closeUserSidebar"
        class="absolute top-2 right-4 text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors text-4xl font-light leading-none">
        &times;
    </button>
    <div class="text-center mb-10">
        <a class="w-fit h-fit" href="?page=account">
            <img class="h-20 w-20 rounded-full mx-auto mb-3" src="public/assets/images/logo.png" alt="Profile">
        </a>
        <p class="text-lg text-[var(--color-text-base)] font-bold"><?php echo strtoupper($_SESSION['username']); ?></p>
    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="?page=dashboard" class="sidebar-link text-[var(--color-text-base)]">Inicio</a></li>
            <li><a href="?page=account" class="sidebar-link text-[var(--color-text-base)]">Mi Cuenta</a></li>
            <li><a href="?page=info" class="sidebar-link text-[var(--color-text-base)]">Sobre Ludopatía</a></li>
            <li><a href="?page=contact" class="sidebar-link text-[var(--color-text-base)]">Contacto</a></li>
            <?php
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