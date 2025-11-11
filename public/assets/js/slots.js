document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM
    // =================================================================
    const reels = [
        document.getElementById('reel-1'),
        document.getElementById('reel-2'),
        document.getElementById('reel-3')
    ];
    const messageContainer = document.getElementById('message-container');

    // Símbolos posibles para los rodillos
    const symbols = ['🍒', '🍋', '🍊', '🍉', '⭐', '🔔', '💎'];

    // =================================================================
    // 2. ESTADO DEL JUEGO (SLOTS)
    // =================================================================
    let gameState = {
        balance: 0,
        winStreak: 0,
        currentBet: 0,
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
        gameInProgress: false,
    };

    // =================================================================
    // 3. INICIALIZACIÓN Y LISTENERS
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
    // =================================================================
    // 5. LÓGICA DEL JUEGO
    // =================================================================
    function startGame(betDetails) {
        if (gameState.gameInProgress) return;
        gameState.gameInProgress = true;
        gameState.balance = betDetails.newBalance;
        gameState.currentBet = betDetails.betAmount;

        messageContainer.textContent = "Girando...";
        messageContainer.style.color = 'var(--color-text-muted)';

        // Simulación de giro
        let spinCount = 0;
        const spinInterval = setInterval(() => {
            reels.forEach(reel => {
                reel.textContent = symbols[Math.floor(Math.random() * symbols.length)];
            });
            spinCount++;
            if (spinCount > 15) { // Detener después de ~1.5 segundos
                clearInterval(spinInterval);
                endGame();
            }
        }, 100);
    }

    async function endGame() {
        // Lógica para determinar el resultado final
        const finalReels = reels.map(() => symbols[Math.floor(Math.random() * symbols.length)]);

        // Forzar resultado según los cheats
        const shouldWin = shouldPlayerWin();
        if (shouldWin) {
            const winningSymbol = symbols[Math.floor(Math.random() * symbols.length)];
            finalReels.fill(winningSymbol);
        }

        // Actualizar la UI con el resultado final
        reels.forEach((reel, index) => reel.textContent = finalReels[index]);

        // Comprobar si hay victoria (todos los símbolos son iguales)
        const isWinner = finalReels.every(symbol => symbol === finalReels[0]);

        if (isWinner) {
            const prize = gameState.currentBet * 5; // Premio x5
            messageContainer.textContent = `¡Has ganado ${prize}!`;
            messageContainer.style.color = 'var(--color-primary)';

            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            const response = await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': prize })
            });
            const data = await response.json();
            gameState.balance = data.newBalance;
            gameState.winStreak++;
        } else {
            messageContainer.textContent = "¡Perdiste! Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
            gameState.winStreak = 0;
        }

        // Notificar a otros scripts
        document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: gameState.balance } }));
        document.dispatchEvent(new CustomEvent('winStreakUpdated', { detail: { newWinStreak: gameState.winStreak } }));
        document.dispatchEvent(new CustomEvent('gameEnded')); // ¡Muy importante!

        gameState.gameInProgress = false;
    }

    function shouldPlayerWin() {
        const potentialWinAmount = gameState.currentBet * 5; // Premio x5
        const potentialBalance = gameState.balance + potentialWinAmount;

        // Comprobaciones de cheats
        if (gameState.cheatSettings.max_balance != -1 && potentialBalance > gameState.cheatSettings.max_balance) {
            return false;
        }
        if (gameState.cheatSettings.max_streak != -1 && gameState.winStreak >= gameState.cheatSettings.max_streak) {
            return false;
        }
        if (gameState.cheatSettings.mode === 1) return true;
        if (gameState.cheatSettings.mode === 2) return false;

        // Juego normal
        return Math.random() < 0.2; // Probabilidad de ganar en slots: 20%
    }

    // Listener principal que inicia el juego cuando se realiza una apuesta
    document.addEventListener('betPlaced', (e) => startGame(e.detail));

    // Listener para cuando los cheats cambian
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    initializeGame();
});