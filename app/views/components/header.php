<header
    class="bg-[var(--color-surface)] text-white py-4 px-6 border-b border-[var(--color-border)] flex justify-between items-center">
    <a href="dashboard" class="flex items-center gap-4 group">
        <img src="public/assets/images/logo.png" alt="Logo" class="h-16 w-16">
        <h1
            style="font-family: 'Grand Casino', sans-serif;"
            class="text-4xl text-[var(--color-primary)] group-hover:text-[var(--color-primary-hover)] transition-colors">
            Juego Consciente
        </h1>
    </a>
    <?php if (!isset($dontUseUserSidebarIcon)): ?>
        <button id="openUserSidebar"
            class="text-[var(--color-text-base)] hover:text-[var(--color-primary)] focus:outline-none transition-all duration-350 p-1 rounded-full hover:bg-gray-800">
            <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    class="stroke-[2] hover:stroke-[2]"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    <?php endif; ?>
</header>