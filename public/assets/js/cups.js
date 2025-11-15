document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM
    // =================================================================
    const cups = document.querySelectorAll('.cup');
    const messageContainer = document.getElementById('message-container');
    const playAgainButton = document.getElementById('playAgain');

    // =================================================================
    // 2. ESTADO DEL JUEGO (CUPS)
    // =================================================================
    let gameState = {
        balance: 0,
        winStreak: 0,
        currentBet: 0,
        MIN_BET: 0, // Se inicializará con el evento 'betScriptLoaded'
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
        canChoose: false,
        gameInProgress: false,
    };

    // =================================================================
    // 5. LÓGICA DEL JUEGO
    // =================================================================
    function startGame(betDetails) {
        gameState.gameInProgress = true;
        gameState.balance = betDetails.newBalance;
        gameState.currentBet = betDetails.betAmount;

        messageContainer.textContent = "Elige un vaso...";
        gameState.canChoose = true;
    }

    function shouldPlayerWin() {
        const potentialWinAmount = gameState.currentBet * 2;
        const potentialBalance = gameState.balance + potentialWinAmount;

        if (gameState.cheatSettings.max_balance != -1 && potentialBalance > gameState.cheatSettings.max_balance) {
            return false;
        }
        if (gameState.cheatSettings.max_streak != -1 && gameState.winStreak >= gameState.cheatSettings.max_streak) {
            return false;
        }
        if (gameState.cheatSettings.mode === 1) return true; // Modo ganador
        if (gameState.cheatSettings.mode === 2) return false; // Modo perdedor

        return Math.random() < (1 / 3); // Juego normal
    }

    async function chooseCup(cupNumber) {
        if (!gameState.canChoose) return;
        gameState.canChoose = false;

        const isWinner = shouldPlayerWin();
        document.getElementById(`cup-${cupNumber}`).style.transform = 'translateY(-30px)';

        if (isWinner) {
            const wonBalance = gameState.currentBet * 2;
            messageContainer.textContent = `¡Has ganado ${wonBalance}!`;
            messageContainer.style.color = 'var(--color-primary)';

            // Incrementar racha y sumar premio
            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            const response = await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': wonBalance })
            });
            const data = await response.json();
            if (data.success) {
                gameState.balance = data.newBalance;
                gameState.winStreak++;
                document.dispatchEvent(new CustomEvent('winStreakUpdated', {
                    detail: { newWinStreak: gameState.winStreak }
                }));
            }
        } else {
            messageContainer.textContent = "¡Perdiste! Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';

            // Resetear racha
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
            gameState.winStreak = 0;
            document.dispatchEvent(new CustomEvent('winStreakUpdated', {
                detail: { newWinStreak: gameState.winStreak }
            }));
        }

        // Disparamos un evento para que la UI de apuestas se actualice
        document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: gameState.balance } }));

        playAgainButton.classList.remove('hidden');
    }

    function resetGame() {
        gameState.gameInProgress = false;
        playAgainButton.classList.add('hidden');
        messageContainer.innerHTML = '&nbsp;';
        cups.forEach(cup => cup.style.transform = 'translateY(0)');

        // Dispara un evento para que los controles de apuesta se reactiven
        document.dispatchEvent(new CustomEvent('gameEnded'));

        initializeGame(); // Recarga los datos del jugador para la siguiente ronda
    }

    // =================================================================
    // 6. INICIALIZACIÓN Y EVENT LISTENERS
    // =================================================================
    async function initializeGame() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();

        gameState.balance = parseInt(data.balance, 10);
        gameState.winStreak = parseInt(data.win_streak, 10);
        gameState.cheatSettings = {
            mode: parseInt(data.cheat_settings.mode, 10),
            max_streak: parseInt(data.cheat_settings.max_streak, 10),
            max_balance: parseInt(data.cheat_settings.max_balance, 10),
        };
    }

    // Listeners del Juego
    playAgainButton.addEventListener('click', resetGame);
    cups.forEach((cup, index) => cup.addEventListener('click', () => chooseCup(index + 1)));

    // Listener principal que inicia el juego cuando se realiza una apuesta
    document.addEventListener('betPlaced', (e) => {
        startGame(e.detail);
    });

    // Listener para saber cuándo el script de apuestas está listo
    document.addEventListener('betScriptLoaded', (e) => {
        console.log('Bet script loaded. MIN_BET:', e.detail.MIN_BET);
        gameState.MIN_BET = e.detail.MIN_BET;
    });

    // Listeners de Cheats (para actualizaciones en tiempo real)
    document.addEventListener('balanceUpdated', e => gameState.balance = e.detail.newBalance);
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    // Iniciar todo
    initializeGame();
});