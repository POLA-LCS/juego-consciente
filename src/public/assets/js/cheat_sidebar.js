document.addEventListener('DOMContentLoaded', () => {
    /**
     * Este script gestiona la funcionalidad del panel lateral de trucos (Cheat Sidebar).
     * Permite:
     * - Abrir y cerrar el panel.
     * - Establecer un monto de saldo específico.
     * - Activar modos de juego (ganador/perdedor).
     * - Establecer límites de racha y saldo.
     * - Guardar y comunicar estos ajustes a otros scripts.
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM Y LÓGICA DEL SIDEBAR                         //
    // ================================================================= //
    const cheatSidebar = document.getElementById('cheatSidebar');
    const openCheatSidebar = document.getElementById('openCheatSidebar');
    const closeCheatSidebar = document.getElementById('closeCheatSidebar');

    if (openCheatSidebar && cheatSidebar && closeCheatSidebar) {
        openCheatSidebar.addEventListener('click', (e) => {
            e.preventDefault();
            loadCheatSettings(); // Carga la configuración actual al abrir el panel.
            cheatSidebar.classList.remove('translate-x-full');
        });

        closeCheatSidebar.addEventListener('click', () => {
            cheatSidebar.classList.add('translate-x-full');
        });
    }

    // ================================================================= //
    // 2. ELEMENTOS DE LOS TRUCOS                                        //
    // ================================================================= //
    // Referencias a los interruptores y campos de entrada del panel.
    const cheatAmountInput = document.getElementById('cheatAmountInput');
    const setCheatAmountButton = document.getElementById('setCheatAmountButton');

    const winnerModeToggle = document.getElementById('winnerMode');
    const loserModeToggle = document.getElementById('loserMode');

    const maxStreakToggle = document.getElementById('maxStreakToggle');
    const maxStreakInput = document.getElementById('maxStreakInput');

    const maxBalanceToggle = document.getElementById('maxBalanceToggle');
    const maxBalanceInput = document.getElementById('maxBalanceInput');

    // ================================================================= //
    // 3. LÓGICA DE TRUCOS                                               //
    // ================================================================= //

    /**
     * Carga la configuración de trucos desde el servidor y actualiza
     * la interfaz del panel de trucos.
     */
    function loadCheatSettings() {
        fetch('?action=getCheatSettings')
            .then(response => response.json())
            .then(settings => {
                // Actualiza los interruptores y campos con los valores recibidos.
                winnerModeToggle.checked = (settings.mode == 1);
                loserModeToggle.checked = (settings.mode == 2);

                maxStreakToggle.checked = (settings.max_streak != -1);
                maxStreakInput.value = (settings.max_streak != -1) ? settings.max_streak : '';
                maxStreakInput.disabled = !maxStreakToggle.checked;

                maxBalanceToggle.checked = (settings.max_balance != -1);
                maxBalanceInput.value = (settings.max_balance != -1) ? settings.max_balance : '';
                maxBalanceInput.disabled = !maxBalanceToggle.checked;
            });
    }

    /**
     * Recopila la configuración actual del panel, la envía al servidor para guardarla
     * y notifica a otros scripts sobre los cambios.
     */
    function saveCheatSettings() {
        const newSettings = {
            mode: 0,
            max_streak: -1,
            max_balance: -1
        };

        if (winnerModeToggle.checked) newSettings.mode = 1;
        if (loserModeToggle.checked) newSettings.mode = 2;

        // Si el toggle está activo, usa el valor del input (o -1 si está vacío). Si no, usa -1.
        newSettings.max_streak = maxStreakToggle.checked ? (maxStreakInput.value || -1) : -1;
        newSettings.max_balance = maxBalanceToggle.checked ? (maxBalanceInput.value || -1) : -1;

        const formData = new FormData();
        formData.append('mode', newSettings.mode);
        formData.append('max_streak', newSettings.max_streak);
        formData.append('max_balance', newSettings.max_balance);

        fetch('?action=updateCheatSettings', {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Notifica a los scripts de los juegos que la configuración ha cambiado.
                    document.dispatchEvent(new CustomEvent('cheatSettingsChanged', { detail: newSettings }));
                    console.log('Cheat settings saved and event dispatched:', newSettings);
                }
            });
    }

    // ================================================================= //
    // 4. MANEJO DE EVENTOS                                              //
    // ================================================================= //

    // --- Modos Ganador/Perdedor (Exclusión mutua) ---
    winnerModeToggle.addEventListener('change', () => {
        if (winnerModeToggle.checked) loserModeToggle.checked = false;
        saveCheatSettings();
    });

    loserModeToggle.addEventListener('change', () => {
        if (loserModeToggle.checked) winnerModeToggle.checked = false;
        saveCheatSettings();
    });

    // --- Límites de Racha y Saldo ---
    maxStreakToggle.addEventListener('change', () => {
        maxStreakInput.disabled = !maxStreakToggle.checked;
        if (!maxStreakToggle.checked) maxStreakInput.value = '';
        saveCheatSettings();
    });
    maxStreakInput.addEventListener('input', saveCheatSettings); // Guarda al escribir.

    maxBalanceToggle.addEventListener('change', () => {
        maxBalanceInput.disabled = !maxBalanceToggle.checked;
        if (!maxBalanceToggle.checked) maxBalanceInput.value = '';
        saveCheatSettings();
    });
    maxBalanceInput.addEventListener('input', saveCheatSettings); // Guarda al escribir.

    // --- Establecer Monto de Saldo ---
    setCheatAmountButton.addEventListener('click', () => {
        const newAmount = parseInt(cheatAmountInput.value, 10);
        if (isNaN(newAmount) || newAmount < 0) {
            alert('Por favor, introduce un monto válido.');
            return;
        }

        const formData = new FormData();
        formData.append('amount', newAmount);

        fetch('?action=setBalance', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (!data.success) {
                    alert('Error al establecer el nuevo monto.');
                    return;
                }
                // Notifica a otros scripts (como el de apuestas) que el saldo ha cambiado.
                document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: data.newBalance } }));
            });
    });

    // Permite usar la tecla "Enter" para establecer el monto.
    cheatAmountInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); setCheatAmountButton.click(); }
    });
});