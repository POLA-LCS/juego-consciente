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
});