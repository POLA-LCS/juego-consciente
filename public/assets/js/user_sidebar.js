document.addEventListener('DOMContentLoaded', () => {
    /**
     * Este script gestiona la apertura y cierre de los paneles laterales
     * (sidebar de usuario y sidebar de trucos).
     * - Controla los clics en los botones de abrir/cerrar.
     * - Permite cerrar los paneles con la tecla "Escape".
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM Y LÓGICA DEL SIDEBAR DE USUARIO              //
    // ================================================================= //
    const userSidebar = document.getElementById('userSidebar');
    const openUserSidebar = document.getElementById('openUserSidebar');
    const closeUserSidebar = document.getElementById('closeUserSidebar');

    if (openUserSidebar && userSidebar && closeUserSidebar) {
        openUserSidebar.addEventListener('click', () => {
            // Muestra el sidebar quitando la clase que lo oculta fuera de la pantalla.
            userSidebar.classList.remove('translate-x-full');
        });

        closeUserSidebar.addEventListener('click', () => {
            // Oculta el sidebar añadiendo la clase que lo mueve fuera de la pantalla.
            userSidebar.classList.add('translate-x-full');
        });
    }

    // ================================================================= //
    // 2. CERRAR PANELES CON LA TECLA ESCAPE                             //
    // ================================================================= //
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const cheatSidebar = document.getElementById('cheatSidebar');
            const userSidebar = document.getElementById('userSidebar');

            // Prioridad: si el panel de trucos está abierto, ciérralo primero.
            if (cheatSidebar && !cheatSidebar.classList.contains('translate-x-full')) {
                cheatSidebar.classList.add('translate-x-full');
                return; // Evita que se cierre también el de usuario en el mismo evento.
            }

            // Si el panel de trucos no estaba abierto, cierra el de usuario si lo está.
            if (userSidebar && !userSidebar.classList.contains('translate-x-full')) {
                userSidebar.classList.add('translate-x-full');
            }
        }
    });
});