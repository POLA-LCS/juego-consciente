document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM
    // =================================================================
    const MIN_BET = 25;
    const balanceDisplay = document.getElementById('balance');
    const currentBetDisplay = document.getElementById('currentBet');
    const winStreakDisplay = document.getElementById('winStreak');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');
    const maxBetButton = document.getElementById('maxBetButton');
    const cups = document.querySelectorAll('.cup');
    const messageContainer = document.getElementById('message-container');
    const playAgainButton = document.getElementById('playAgain');

    // =================================================================
    // 2. ESTADO DEL JUEGO
    // =================================================================
    let state = {
        balance: 0,
        winStreak: 0,
        currentBet: MIN_BET,
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
        canChoose: false,
        gameInProgress: false,
    };

    // =================================================================
    // 3. FUNCIONES DE ACTUALIZACIÓN DE UI
    // =================================================================
    function updateUI() {
        balanceDisplay.textContent = state.balance;
        winStreakDisplay.textContent = state.winStreak;
        currentBetDisplay.textContent = state.currentBet;
    }

    // =================================================================
    // 4. LÓGICA DE APUESTAS
    // =================================================================
    function addToBet(amount) {
        if (state.gameInProgress) return;
        const newBet = state.currentBet + amount;
        state.currentBet = Math.min(newBet, state.balance); // No se puede apostar más de lo que se tiene
        updateUI();
    }

    function resetBet() {
        if (state.gameInProgress) return;
        state.currentBet = Math.min(MIN_BET, state.balance); // El mínimo es 25 o el saldo si es menor
        updateUI();
    }

    function setMaxBet() {
        if (state.gameInProgress) return;
        state.currentBet = state.balance;
        updateUI();
    }

    // =================================================================
    // 5. LÓGICA DEL JUEGO
    // =================================================================
    async function placeBet() {
        if (state.currentBet <= 0 || state.currentBet > state.balance) {
            alert("Apuesta inválida.");
            return;
        }

        state.gameInProgress = true;
        toggleBetControls(false);

        const response = await fetch(`?action=updateBalance`, {
            method: 'POST',
            body: new URLSearchParams({ 'amount': -state.currentBet })
        });
        const data = await response.json();

        if (data.success) {
            state.balance = data.newBalance;
            updateUI();
            messageContainer.textContent = "Elige un vaso...";
            state.canChoose = true;
        } else {
            alert('Error al realizar la apuesta.');
            resetGame();
        }
    }

    function shouldPlayerWin() {
        const potentialWinAmount = state.currentBet * 2;
        const potentialBalance = state.balance + potentialWinAmount;

        if (state.cheatSettings.max_balance != -1 && potentialBalance > state.cheatSettings.max_balance) {
            return false;
        }
        if (state.cheatSettings.max_streak != -1 && state.winStreak >= state.cheatSettings.max_streak) {
            return false;
        }
        if (state.cheatSettings.mode === 1) return true; // Modo ganador
        if (state.cheatSettings.mode === 2) return false; // Modo perdedor

        return Math.random() < (1 / 3); // Juego normal
    }

    async function chooseCup(cupNumber) {
        if (!state.canChoose) return;
        state.canChoose = false;

        const isWinner = shouldPlayerWin();
        document.getElementById(`cup-${cupNumber}`).style.transform = 'translateY(-30px)';

        if (isWinner) {
            messageContainer.textContent = `¡Has ganado ${state.currentBet * 2}!`;
            messageContainer.style.color = 'var(--color-primary)';
            
            // Incrementar racha y sumar premio
            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            const response = await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': state.currentBet * 2 })
            });
            const data = await response.json();
            if (data.success) {
                state.balance = data.newBalance;
                state.winStreak++;
            }
        } else {
            messageContainer.textContent = "Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';
            
            // Resetear racha
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
            state.winStreak = 0;
        }

        updateUI();
        playAgainButton.classList.remove('hidden');
    }

    function resetGame() {
        state.gameInProgress = false;
        toggleBetControls(true);
        playAgainButton.classList.add('hidden');
        messageContainer.innerHTML = '&nbsp;';
        cups.forEach(cup => cup.style.transform = 'translateY(0)');
        resetBet();
    }

    function toggleBetControls(enabled) {
        placeBetButton.disabled = !enabled;
        resetBetButton.disabled = !enabled;
        betChips.forEach(b => b.disabled = !enabled);
    }

    // =================================================================
    // 6. INICIALIZACIÓN Y EVENT LISTENERS
    // =================================================================
    async function initializeGame() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();

        state.balance = parseInt(data.balance, 10);
        state.winStreak = parseInt(data.win_streak, 10);
        state.cheatSettings = {
            mode: parseInt(data.cheat_settings.mode, 10),
            max_streak: parseInt(data.cheat_settings.max_streak, 10),
            max_balance: parseInt(data.cheat_settings.max_balance, 10),
        };
        
        resetGame();
        updateUI();
    }

    // Listeners de Apuestas
    betChips.forEach(b => b.addEventListener('click', () => addToBet(parseInt(b.dataset.amount, 10))));
    resetBetButton.addEventListener('click', resetBet);
    placeBetButton.addEventListener('click', placeBet);
    maxBetButton.addEventListener('click', setMaxBet);

    // Listeners del Juego
    playAgainButton.addEventListener('click', resetGame);
    cups.forEach((cup, index) => cup.addEventListener('click', () => chooseCup(index + 1)));

    // Listeners de Cheats (para actualizaciones en tiempo real)
    document.addEventListener('balanceUpdated', e => state.balance = e.detail.newBalance);
    document.addEventListener('cheatSettingsChanged', e => state.cheatSettings = e.detail);

    // Iniciar todo
    initializeGame();
});