document.addEventListener('DOMContentLoaded', () => {
    const cheatSidebar = document.getElementById('cheatSidebar');
    const openCheatSidebar = document.getElementById('openCheatSidebar'); // Botón en el userSidebar
    const closeCheatSidebar = document.getElementById('closeCheatSidebar'); // Botón 'x' en el cheatSidebar

    if (openCheatSidebar && cheatSidebar && closeCheatSidebar) {
        openCheatSidebar.addEventListener('click', (e) => {
            e.preventDefault(); // Prevenir la navegación si es un enlace
            loadCheatSettings(); // Cargar datos al abrir
            cheatSidebar.classList.remove('translate-x-full');
        });

        closeCheatSidebar.addEventListener('click', () => {
            cheatSidebar.classList.add('translate-x-full');
        });
    }

    // --- Lógica de Cheats ---

    // Elementos de "Establecer Monto"
    const cheatAmountInput = document.getElementById('cheatAmountInput');
    const setCheatAmountButton = document.getElementById('setCheatAmountButton');

    // Elementos de Modos
    const winnerModeToggle = document.getElementById('winnerMode');
    const loserModeToggle = document.getElementById('loserMode');

    // Elementos de Máxima Racha
    const maxStreakToggle = document.getElementById('maxStreakToggle');
    const maxStreakInput = document.getElementById('maxStreakInput');

    // Elementos de Máximo Saldo
    const maxBalanceToggle = document.getElementById('maxBalanceToggle');
    const maxBalanceInput = document.getElementById('maxBalanceInput');

    // Cargar la configuración inicial desde el backend
    function loadCheatSettings() {
        fetch('?action=getCheatSettings')
            .then(response => response.json())
            .then(settings => {
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

    // Guardar la configuración en el backend
    function saveCheatSettings() {
        const formData = new FormData();
        
        let mode = 0; // normal
        if (winnerModeToggle.checked) mode = 1;
        if (loserModeToggle.checked) mode = 2;

        formData.append('mode', mode);
        formData.append('max_streak', maxStreakToggle.checked ? maxStreakInput.value : -1);
        formData.append('max_balance', maxBalanceToggle.checked ? maxBalanceInput.value : -1);

        fetch('?action=updateCheatSettings', {
            method: 'POST',
            body: formData
        });
    }

    // --- Event Listeners ---

    // Exclusión mutua para modos ganador/perdedor
    winnerModeToggle.addEventListener('change', () => {
        if (winnerModeToggle.checked) {
            loserModeToggle.checked = false;
        }
        saveCheatSettings();
    });

    loserModeToggle.addEventListener('change', () => {
        if (loserModeToggle.checked) {
            winnerModeToggle.checked = false;
        }
        saveCheatSettings();
    });

    // Habilitar/deshabilitar inputs
    maxStreakToggle.addEventListener('change', () => {
        maxStreakInput.disabled = !maxStreakToggle.checked;
        if (!maxStreakToggle.checked) maxStreakInput.value = '';
        saveCheatSettings();
    });
    maxStreakInput.addEventListener('input', saveCheatSettings);

    maxBalanceToggle.addEventListener('change', () => {
        maxBalanceInput.disabled = !maxBalanceToggle.checked;
        if (!maxBalanceToggle.checked) maxBalanceInput.value = '';
        saveCheatSettings();
    });
    maxBalanceInput.addEventListener('input', saveCheatSettings);

    // Lógica para "Establecer Monto" (ya existente)
    setCheatAmountButton.addEventListener('click', () => {
        const newAmount = parseInt(cheatAmountInput.value, 10);
        if (isNaN(newAmount) || newAmount < 0) { alert('Por favor, introduce un monto válido.'); return; }
        const formData = new FormData();
        formData.append('amount', newAmount);
        fetch('?action=setBalance', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: newAmount } }));
                    cheatSidebar.classList.add('translate-x-full');
                } else {
                    alert('Error al establecer el nuevo monto.');
                }
            });
    });
    cheatAmountInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); setCheatAmountButton.click(); }
    });
});