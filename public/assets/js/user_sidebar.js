document.addEventListener('DOMContentLoaded', () => {
    const userSidebar = document.getElementById('userSidebar');
    const openUserSidebar = document.getElementById('openUserSidebar'); // Botón en el header
    const closeUserSidebar = document.getElementById('closeUserSidebar'); // Botón 'x' en el sidebar

    if (openUserSidebar && userSidebar && closeUserSidebar) {
        openUserSidebar.addEventListener('click', () => {
            userSidebar.classList.remove('translate-x-full');
        });

        closeUserSidebar.addEventListener('click', () => {
            userSidebar.classList.add('translate-x-full');
        });
    }

    // Listener para la tecla "Escape" para cerrar los sidebars
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const cheatSidebar = document.getElementById('cheatSidebar');
            const userSidebar = document.getElementById('userSidebar');

            // Primero, verifica si el cheatSidebar está abierto y ciérralo.
            // La clase 'translate-x-full' indica que está cerrado.
            if (cheatSidebar && !cheatSidebar.classList.contains('translate-x-full')) {
                cheatSidebar.classList.add('translate-x-full');
                return; // Detiene la ejecución para no cerrar ambos a la vez.
            }

            // Si el cheatSidebar no estaba abierto, verifica si el userSidebar lo está y ciérralo.
            if (userSidebar && !userSidebar.classList.contains('translate-x-full')) {
                userSidebar.classList.add('translate-x-full');
            }
        }
    });
});