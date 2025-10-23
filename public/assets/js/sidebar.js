/**
 * Juego Consciente - Lógica del Sidebar de Cuenta y Trampas (Derecha)
 * Ubicación: ludopatia/public/assets/js/sidebar.js
 */

document.addEventListener('DOMContentLoaded', function () {
    // Referencias al Account Sidebar (Derecha)
    const accountSidebar = document.getElementById('account-sidebar');
    const toggleButton = document.getElementById('toggle-account-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const contentNormal = document.getElementById('sidebar-content-normal');
    const contentCheat = document.getElementById('sidebar-content-cheat');
    const btnShowCheat = document.getElementById('btn-show-cheat');
    const btnShowNormal = document.getElementById('btn-show-normal');

    // Referencias a los interruptores de Trampa
    const winnerModeCheckbox = document.getElementById('winner-mode');
    const loserModeCheckbox = document.getElementById('loser-mode');


    // =======================================================
    // 1. Lógica de Apertura y Cierre del Account Sidebar
    // =======================================================

    function showNormalMode() {
        if (contentNormal && contentCheat) {
            contentNormal.classList.remove('hidden');
            contentCheat.classList.add('hidden');
        }
    }

    function toggleSidebar() {
        const isHidden = accountSidebar.classList.contains('translate-x-full');

        if (isHidden) {
            accountSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        } else {
            accountSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('hidden');
            showNormalMode(); // Vuelve siempre al modo normal al cerrar
        }
    }

    if (toggleButton) toggleButton.addEventListener('click', toggleSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

    // Cierra con la tecla ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && accountSidebar && !accountSidebar.classList.contains('translate-x-full')) {
            toggleSidebar();
        }
    });


    // =======================================================
    // 2. Lógica de Cambio de Modo (Cuenta <-> Trampas)
    // =======================================================

    function showCheatMode() {
        if (contentNormal && contentCheat) {
            contentNormal.classList.add('hidden');
            contentCheat.classList.remove('hidden');
        }
    }

    if (btnShowCheat) btnShowCheat.addEventListener('click', showCheatMode);
    if (btnShowNormal) btnShowNormal.addEventListener('click', showNormalMode);

    // =======================================================
    // 3. Lógica de Exclusión de Modos de Trampa
    // =======================================================

    if (winnerModeCheckbox && loserModeCheckbox) {
        winnerModeCheckbox.addEventListener('change', function () {
            if (this.checked) {
                loserModeCheckbox.checked = false;
            }
        });

        loserModeCheckbox.addEventListener('change', function () {
            if (this.checked) {
                winnerModeCheckbox.checked = false;
            }
        });
    }

    // Opcional: Lógica para enviar el formulario de trampas (por implementar con Fetch/AJAX)
    const cheatForm = document.getElementById('cheat-form');
    if (cheatForm) {
        cheatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            // Lógica para enviar los datos de trampas al servidor
            console.log('Datos de trampas enviados (Pendiente de AJAX)');
            // Después de enviar, podrías cerrar el sidebar
            // toggleSidebar();
        });
    }
});