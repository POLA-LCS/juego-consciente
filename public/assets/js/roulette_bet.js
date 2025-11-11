document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM (Apuestas)
    // =================================================================
    const balanceDisplay = document.getElementById('balance');
    const winStreakDisplay = document.getElementById('winStreak');
    const totalBetDisplay = document.getElementById('totalBet');
    const betSpots = document.querySelectorAll('.bet-spot');
    const chipSelectors = document.querySelectorAll('.chip-selector');
    const clearBetsButton = document.getElementById('clearBets');
    const spinButton = document.getElementById('spinButton');
    const undoButton = document.getElementById('undoBet');
    const redoButton = document.getElementById('redoBet');

    // =================================================================
    // 2. ESTADO DE LA APUESTA
    // =================================================================
    let state = {
        balance: 0,
        winStreak: 0,
        selectedChip: 50,
        bets: {}, // Objeto para guardar las apuestas: { "red": 50, "number_10": 10 }
        history: [], // Para la función de deshacer
        redoHistory: [], // Para la función de rehacer
        totalBet: 0,
        isBettingLocked: false,
    };

    // =================================================================
    // 3. FUNCIONES DE UI Y LÓGICA DE APUESTAS
    // =================================================================
    function updateUI() {
        balanceDisplay.textContent = state.balance;
        winStreakDisplay.textContent = state.winStreak;
        totalBetDisplay.textContent = state.totalBet;

        // Actualizar visualmente cada apuesta
        betSpots.forEach(spot => {
            const betKey = `${spot.dataset.betType}_${spot.dataset.betValue}`;
            const betAmount = state.bets[betKey] || 0;
            if (betAmount > 0) {
                spot.innerHTML = `<span class="chip">${betAmount}</span>`;
            } else {
                // Si no hay apuesta se restaura el contenido original
                const type = spot.dataset.betType;
                const value = spot.dataset.betValue;
                if (type === 'number') {
                    spot.innerHTML = value;
                } else if (type === 'dozen') {
                    spot.innerHTML = `${value}ra Docena`;
                } else if (type === 'color') {
                    spot.innerHTML = value.toUpperCase();
                }
            }
        });

        undoButton.disabled = state.history.length === 0 || state.isBettingLocked;
        redoButton.disabled = state.redoHistory.length === 0 || state.isBettingLocked;
    }

    function selectChip(value) {
        state.selectedChip = value;
        chipSelectors.forEach(chip => {
            chip.classList.toggle('active-chip', parseInt(chip.dataset.chipValue) === value);
        });
    }

    function placeBetOnSpot(spot) {
        if (state.isBettingLocked) return;

        const betAmount = state.selectedChip;
        if (state.balance < state.totalBet + betAmount) {
            alert("Saldo insuficiente.");
            return;
        }

        const betKey = `${spot.dataset.betType}_${spot.dataset.betValue}`;
        state.bets[betKey] = (state.bets[betKey] || 0) + betAmount;
        state.history.push({ key: betKey, amount: betAmount });
        state.redoHistory = []; // Al iniciar una nueva apuesta se borra el historial
        state.totalBet += betAmount;
        updateUI();
    }

    function undoLastBet() {
        if (state.history.length === 0 || state.isBettingLocked) return;

        const lastAction = state.history.pop();
        state.redoHistory.push(lastAction);

        state.bets[lastAction.key] -= lastAction.amount;
        state.totalBet -= lastAction.amount;

        updateUI();
    }

    // Para avanzar en el historial de chips en la apuesta actual
    function redoLastBet() {
        if (state.redoHistory.length === 0 || state.isBettingLocked) return;

        const nextAction = state.redoHistory.pop();
        state.history.push(nextAction);

        state.bets[nextAction.key] = (state.bets[nextAction.key] || 0) + nextAction.amount;
        state.totalBet += nextAction.amount;

        updateUI();
    }

    // Para limpiar la apuesta actual
    function clearAllBets() {
        if (state.isBettingLocked) return;
        state.history = [];
        state.redoHistory = [];
        state.bets = {};
        state.totalBet = 0;
        updateUI();
    }

    async function spin() {
        if (state.totalBet <= 0) {
            alert("Realiza una apuesta antes de girar.");
            return;
        }
        state.isBettingLocked = true;
        toggleControls(false);

        // Descontar la apuesta total del saldo
        const response = await fetch(`?action=updateBalance`, {
            method: 'POST',
            body: new URLSearchParams({ 'amount': -state.totalBet })
        });
        const data = await response.json();

        if (data.success) {
            state.balance = data.newBalance;
            updateUI();
            // Notificar al script del juego que la apuesta fue colocada
            document.dispatchEvent(new CustomEvent('betPlaced', {
                detail: { bets: state.bets, totalBet: state.totalBet }
            }));
        } else {
            alert("Error al realizar la apuesta.");
            state.isBettingLocked = false;
            toggleControls(true);
        }
    }

    // Si los botones están habilitados
    function toggleControls(enabled) {
        spinButton.disabled = !enabled;
        clearBetsButton.disabled = !enabled;
        chipSelectors.forEach(c => c.disabled = !enabled);
        undoButton.disabled = !enabled || state.history.length === 0;
        redoButton.disabled = !enabled || state.redoHistory.length === 0;
    }

    // =================================================================
    // 4. INICIALIZACIÓN Y EVENT LISTENERS
    // =================================================================
    async function initializeBetting() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        state.balance = parseInt(data.balance, 10);
        state.winStreak = parseInt(data.win_streak, 10);
        updateUI();
    }

    chipSelectors.forEach(c => c.addEventListener('click', () => selectChip(parseInt(c.dataset.chipValue))));
    betSpots.forEach(spot => spot.addEventListener('click', () => placeBetOnSpot(spot)));
    clearBetsButton.addEventListener('click', clearAllBets);
    undoButton.addEventListener('click', undoLastBet);
    redoButton.addEventListener('click', redoLastBet);
    spinButton.addEventListener('click', spin);

    document.addEventListener('gameEnded', () => {
        state.isBettingLocked = false;
        toggleControls(true);
        // Limpiar apuestas y historial para la siguiente ronda y actualizar UI
        state.bets = {};
        state.totalBet = 0;
        state.history = [];
        state.redoHistory = [];
        updateUI();

        initializeBetting(); // Recargar datos del jugador
    });

    // Listener para cuando el saldo cambia desde fuera (ej: cheat sidebar)
    document.addEventListener('balanceUpdated', e => {
        state.balance = e.detail.newBalance;
        updateUI();
    });

    initializeBetting();
});