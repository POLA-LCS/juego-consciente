document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM (Sidebar de Apuestas)
    // =================================================================
    const balanceDisplay = document.getElementById('balance');
    const winStreakDisplay = document.getElementById('winStreak');
    const currentBetDisplay = document.getElementById('currentBet');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');
    const maxBetButton = document.getElementById('maxBetButton');

    // =================================================================
    // 2. ESTADO DE LA APUESTA
    // =================================================================
    const MIN_BET = 100;
    let state = {
        balance: 0,
        winStreak: 0,
        currentBet: MIN_BET,
        isBettingLocked: false, // Para bloquear controles durante una acción
    };

    // =================================================================
    // 3. FUNCIONES DE ACTUALIZACIÓN DE UI
    // =================================================================
    function updateBetUI() {
        if (balanceDisplay) balanceDisplay.textContent = state.balance;
        if (winStreakDisplay) winStreakDisplay.textContent = state.winStreak;
        if (currentBetDisplay) currentBetDisplay.textContent = state.currentBet;
    }

    function toggleBetControls(enabled) {
        state.isBettingLocked = !enabled;
        if (placeBetButton) placeBetButton.disabled = !enabled;
        if (resetBetButton) resetBetButton.disabled = !enabled;
        if (maxBetButton) maxBetButton.disabled = !enabled;
        if (betChips) betChips.forEach(b => b.disabled = !enabled);
    }

    // =================================================================
    // 4. LÓGICA DE APUESTAS
    // =================================================================
    function addToBet(amount) {
        if (state.isBettingLocked) return;
        const newBet = state.currentBet + amount;
        state.currentBet = Math.min(newBet, state.balance);
        updateBetUI();
    }

    function resetBet() {
        if (state.isBettingLocked) return;
        state.currentBet = Math.min(MIN_BET, state.balance);
        updateBetUI();
    }

    function setMaxBet() {
        if (state.isBettingLocked) return;
        state.currentBet = state.balance;
        updateBetUI();
    }

    async function placeBet() {
        if (state.currentBet <= 0 || state.currentBet > state.balance) {
            alert("Apuesta inválida.");
            return;
        }

        toggleBetControls(false); // Bloquea los controles

        const response = await fetch(`?action=updateBalance`, {
            method: 'POST',
            body: new URLSearchParams({ 'amount': -state.currentBet })
        });
        const data = await response.json();

        if (data.success) {
            state.balance = data.newBalance;
            updateBetUI();
            // Dispara un evento global para que el juego actual sepa que la apuesta fue exitosa
            document.dispatchEvent(new CustomEvent('betPlaced', {
                detail: { newBalance: state.balance, betAmount: state.currentBet }
            }));
        } else {
            alert('Error al realizar la apuesta.');
            toggleBetControls(true); // Desbloquea si falla
        }
    }

    // =================================================================
    // 5. INICIALIZACIÓN Y EVENT LISTENERS
    // =================================================================
    async function initializeBetting() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        state.balance = parseInt(data.balance, 10);
        state.winStreak = parseInt(data.win_streak, 10);
        resetBet();
        updateBetUI();

        // Dispara un evento para notificar a los juegos que el script de apuestas está listo
        document.dispatchEvent(new CustomEvent('betScriptLoaded', {
            detail: { MIN_BET: MIN_BET }
        }));
    }

    // Listeners de la UI de apuestas
    betChips.forEach(b => b.addEventListener('click', () => addToBet(parseInt(b.dataset.amount, 10))));
    resetBetButton.addEventListener('click', resetBet);
    placeBetButton.addEventListener('click', placeBet);
    maxBetButton.addEventListener('click', setMaxBet);

    // Listener para actualizaciones externas (ej: desde cheat sidebar)
    document.addEventListener('balanceUpdated', e => {
        state.balance = e.detail.newBalance;
        updateBetUI();
    });

    // Listener para cuando un juego termina, para reactivar los controles de apuesta.
    document.addEventListener('gameEnded', () => {
        console.log('Game has ended. Re-enabling bet controls.');
        toggleBetControls(true);
    });

    // Listener para cuando la racha de victorias cambia
    document.addEventListener('winStreakUpdated', e => {
        state.winStreak = e.detail.newWinStreak;
        updateBetUI();
    });

    initializeBetting();
});