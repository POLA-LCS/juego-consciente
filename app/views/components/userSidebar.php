<aside id="userSidebar" class="fixed right-0 top-0 h-full w-64 bg-[var(--color-background)] border-l border-[var(--color-border)] p-3 transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex justify-end mb-2">
        <button id="closeUserSidebar" class="text-[var(--color-text-muted)] hover:text-white text-4xl font-light leading-none">&times;</button>
    </div>
    <div class="text-center mb-6">
        <img src="/ludopatia/public/assets/images/logo.png" alt="Profile" class="h-20 w-20 rounded-full mx-auto mb-3">
        <p class="text-lg text-[var(--color-text-base)] font-bold"><?php echo $_SESSION['username']; ?></p>
        <p class="text-sm text-[var(--color-text-muted)]">ID: <?php echo $_SESSION['user_id']; ?></p>
    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="?page=dashboard" class="sidebar-link text-[var(--color-text-base)]">Dashboard</a></li>
            <li><a href="?page=info" class="sidebar-link text-[var(--color-text-base)]">Ludopatía</a></li>
            <li><a href="?page=contact" class="sidebar-link text-[var(--color-text-base)]">Contacto</a></li>
            <li><a href="#" id="openCheatSidebar" class="sidebar-link text-[var(--color-text-base)]">Cheats</a></li>
            <li><a href="?action=logout" class="sidebar-link sidebar-link-danger">Logout</a></li>
        </ul>
    </nav>
</aside>
