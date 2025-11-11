document.addEventListener('DOMContentLoaded', async () => {
    // =================================================================
    // 1. ELEMENTOS DEL DOM (Juego)
    // =================================================================
    const resultDisplay = document.getElementById('result-display');
    const resultNumber = document.getElementById('result-number');
    const messageContainer = document.getElementById('message-container');

    // =================================================================
    // 2. ESTADO DEL JUEGO
    // =================================================================
    const ROULETTE_NUMBERS = [
        0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6, 27, 13, 36, 11, 30, 8, 23, 10,
        5, 24, 16, 33, 1, 20, 14, 31, 9, 22, 18, 29, 7, 28, 12, 35, 3, 26
    ];
    const REDS = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];

    let gameState = {
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
    };

    // =================================================================
    // 3. LÓGICA DEL JUEGO
    // =================================================================
    function startGame(betDetails) {
        messageContainer.textContent = "Girando...";
        messageContainer.style.color = 'var(--color-text-muted)';

        // Simulación de giro
        let spinCount = 0;
        const spinInterval = setInterval(() => {
            const randomIndex = Math.floor(Math.random() * ROULETTE_NUMBERS.length);
            const number = ROULETTE_NUMBERS[randomIndex];
            resultNumber.textContent = number;
            resultDisplay.style.backgroundColor = getNumberColor(number, true);
            spinCount++;
            if (spinCount > 30) { // Detener después de ~3 segundos
                clearInterval(spinInterval);
                endGame(betDetails);
            }
        }, 100);
    }

    async function endGame(betDetails) {
        const winningNumber = determineWinningNumber(betDetails.bets);

        resultNumber.textContent = winningNumber;
        resultDisplay.style.backgroundColor = getNumberColor(winningNumber, false);

        const winnings = calculateWinnings(winningNumber, betDetails.bets);

        if (winnings > 0) {
            messageContainer.textContent = `¡Has ganado ${winnings}!`;
            messageContainer.style.color = 'var(--color-primary)';

            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': winnings })
            });
        } else {
            messageContainer.textContent = "¡Perdiste! Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
        }

        document.dispatchEvent(new CustomEvent('gameEnded'));
    }

    function calculateWinnings(winningNumber, bets) {
        let totalWinnings = 0;
        const winningColor = REDS.includes(winningNumber) ? 'red' : (winningNumber === 0 ? 'green' : 'black');

        for (const betKey in bets) {
            const [type, value] = betKey.split('_');
            const betAmount = bets[betKey];

            if (type === 'number' && parseInt(value) === winningNumber) totalWinnings += betAmount * 36;
            if (type === 'color' && value === winningColor) totalWinnings += betAmount * 2;
            if (type === 'dozen') {
                if (value == 1 && winningNumber >= 1 && winningNumber <= 12) totalWinnings += betAmount * 3;
                if (value == 2 && winningNumber >= 13 && winningNumber <= 24) totalWinnings += betAmount * 3;
                if (value == 3 && winningNumber >= 25 && winningNumber <= 36) totalWinnings += betAmount * 3;
            }
        }
        return totalWinnings;
    }

    function determineWinningNumber(bets) {
        // --- MODO GANADOR ---
        if (gameState.cheatSettings.mode === 1) {
            const possibleWins = { color: [], dozen: [], number: [] };
            for (const betKey in bets) {
                if (bets[betKey] > 0) {
                    const [type, value] = betKey.split('_');
                    if (type === 'number') {
                        possibleWins.number.push(parseInt(value));
                    } else if (type === 'color') {
                        const colorNumbers = (value === 'red')
                            ? REDS
                            : Array.from({ length: 36 }, (_, i) => i + 1).filter(n => !REDS.includes(n) && n !== 0);
                        possibleWins.color.push(...colorNumbers);
                    } else if (type === 'dozen') {
                        const dozen = parseInt(value);
                        const start = (dozen - 1) * 12 + 1;
                        const end = dozen * 12;
                        for (let i = start; i <= end; i++) possibleWins.dozen.push(i);
                    }
                }
            }

            // Prioriza las victorias menos "obvias" (pago menor)
            if (possibleWins.color.length > 0) {
                return possibleWins.color[Math.floor(Math.random() * possibleWins.color.length)];
            }
            if (possibleWins.dozen.length > 0) {
                return possibleWins.dozen[Math.floor(Math.random() * possibleWins.dozen.length)];
            }
            if (possibleWins.number.length > 0) {
                return possibleWins.number[Math.floor(Math.random() * possibleWins.number.length)];
            }
        }

        // --- MODO PERDEDOR ---
        if (gameState.cheatSettings.mode === 2) {
            const winningNumbers = new Set();
            for (const betKey in bets) {
                if (bets[betKey] > 0) {
                    const [type, value] = betKey.split('_');
                    if (type === 'number') {
                        winningNumbers.add(parseInt(value));
                    } else if (type === 'color') {
                        if (value === 'red') REDS.forEach(n => winningNumbers.add(n));
                        else Array.from({ length: 36 }, (_, i) => i + 1).filter(n => !REDS.includes(n) && n !== 0).forEach(n => winningNumbers.add(n));
                    } else if (type === 'dozen') {
                        const dozen = parseInt(value);
                        const start = (dozen - 1) * 12 + 1;
                        const end = dozen * 12;
                        for (let i = start; i <= end; i++) winningNumbers.add(i);
                    }
                }
            }

            const losingNumbers = Array.from({ length: 37 }, (_, i) => i).filter(n => !winningNumbers.has(n));
            // Si hay números perdedores disponibles, elige uno. Si no (apostó a todo), juega normal.
            if (losingNumbers.length > 0) {
                return losingNumbers[Math.floor(Math.random() * losingNumbers.length)];
            }
        }

        // --- JUEGO NORMAL ---
        return Math.floor(Math.random() * 37);
    }

    function getNumberColor(number, isSpinning) {
        if (isSpinning) return '#374151'; // Gris durante el giro
        if (number === 0) return '#0c9d5b'; // Verde
        return REDS.includes(number) ? 'var(--color-primary)' : '#1f1f1f'; // Rojo o Negro
    }

    // =================================================================
    // 4. INICIALIZACIÓN Y EVENT LISTENERS
    // =================================================================
    async function initializeGame() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        gameState.cheatSettings = data.cheat_settings;
    }

    document.addEventListener('betPlaced', (e) => startGame(e.detail));
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    initializeGame();
});