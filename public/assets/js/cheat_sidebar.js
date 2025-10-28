document.addEventListener('DOMContentLoaded', () => {
    const cheatSidebar = document.getElementById('cheatSidebar');
    const openCheatSidebar = document.getElementById('openCheatSidebar'); // Botón en el userSidebar
    const closeCheatSidebar = document.getElementById('closeCheatSidebar'); // Botón 'x' en el cheatSidebar

    if (openCheatSidebar && cheatSidebar && closeCheatSidebar) {
        openCheatSidebar.addEventListener('click', (e) => {
            e.preventDefault(); // Prevenir la navegación si es un enlace
            cheatSidebar.classList.remove('translate-x-full');
        });

        closeCheatSidebar.addEventListener('click', () => {
            cheatSidebar.classList.add('translate-x-full');
        });
    }
});