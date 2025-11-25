document.addEventListener('DOMContentLoaded', async () => {
    /**
     * Este script controla la lógica del juego de la máquina tragaperras (Slots).
     * Se encarga de:
     * - Iniciar el juego y la animación de giro cuando se realiza una apuesta.
     * - Determinar el resultado (victoria o derrota) considerando los trucos.
     * - Animar los rodillos y mostrar el resultado final.
     * - Comunicarse con el servidor para actualizar el saldo y la racha.
     */

    // Constantes para que el código sea más legible. En lugar de usar números
    // como 1 y 2, usamos nombres que explican lo que significan.
    const WINNER_MODE = 1;
    const LOSER_MODE = 2;

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM Y CONSTANTES                                 //
    // ================================================================= //
    const reels = [
        document.getElementById('reel-1'),
        document.getElementById('reel-2'),
        document.getElementById('reel-3')
    ];
    const messageContainer = document.getElementById('message-container');

    // Los símbolos que pueden aparecer en los rodillos.
    const symbols = ['🍒', '⭐', '💎'];

    // ================================================================= //
    // 2. ESTADO DEL JUEGO                                               //
    // ================================================================= //
    // La "memoria" del juego, donde guardamos toda la información importante.
    let gameState = {
        balance: 0,
        winStreak: 0,
        currentBet: 0,
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
        gameInProgress: false, // ¿Hay una partida en curso?
    };

    // ================================================================= //
    // 3. LÓGICA DEL JUEGO                                               //
    // ================================================================= //

    /**
     * Inicia una nueva partida. Se llama cuando se realiza una apuesta.
     * @param {object} betDetails - La información de la apuesta.
     */
    function startGame(betDetails) {
        if (gameState.gameInProgress) return; // Si ya hay un juego, no hacemos nada.
        gameState.gameInProgress = true;

        // Actualizamos nuestro estado con la información de la apuesta.
        gameState.balance = betDetails.newBalance;
        gameState.currentBet = betDetails.betAmount;

        // Limpiamos los estilos de la partida anterior.
        reels.forEach(reel => {
            reel.classList.remove('winning-reel', 'losing-reel');
        });

        messageContainer.textContent = "Girando...";
        messageContainer.style.color = 'var(--color-text-muted)';

        // Simulación de giro: cambiamos los símbolos rápidamente.
        let spinCount = 0;
        const spinInterval = setInterval(() => {
            // Cambiamos el símbolo de cada rodillo.
            reels.forEach(reel => {
                reel.textContent = symbols[Math.floor(Math.random() * symbols.length)];
            });

            spinCount++;
            // Después de unos 1.5 segundos, detenemos la animación y vemos el resultado.
            if (spinCount > 10) {
                clearInterval(spinInterval);
                endGame();
            }
        }, 150); // Se repite cada 150 milisegundos.
    }

    /**
     * Determina el resultado final y lo muestra en los rodillos.
     */
    async function endGame() {
        let finalReels = [];

        // Decidimos si el jugador debe ganar o perder, según los trucos.
        const result = shouldPlayerWin();

        if (result === WINNER_MODE) {
            // --- Forzar Victoria ---
            const winningSymbol = symbols[Math.floor(Math.random() * symbols.length)];
            // Creamos una combinación ganadora (3 iguales o 2 iguales).
            finalReels = [winningSymbol, winningSymbol, winningSymbol];

        } else if (result === LOSER_MODE) {
            // --- Forzar Derrota ---
            // Creamos una combinación que garantice que no hay 2 símbolos iguales seguidos.
            let s1 = symbols[Math.floor(Math.random() * symbols.length)];
            let s2 = symbols[Math.floor(Math.random() * symbols.length)];
            let s3 = symbols[Math.floor(Math.random() * symbols.length)];
            // Nos aseguramos de que no haya premio.
            while (s1 === s2 || s2 === s3) {
                s2 = symbols[Math.floor(Math.random() * symbols.length)];
                s3 = symbols[Math.floor(Math.random() * symbols.length)];
            }
            finalReels = [s1, s2, s3];

        } else {
            // --- Juego Normal ---
            // Generamos 3 símbolos al azar.
            for (let i = 0; i < 3; i++) {
                finalReels.push(symbols[Math.floor(Math.random() * symbols.length)]);
            }
        }

        // Mostramos el resultado final con una pequeña animación de retraso.
        showDelayedReels(finalReels);
    }

    /**
     * Muestra los símbolos finales en los rodillos uno por uno para crear suspense.
     * @param {string[]} finalReels - El array con los 3 símbolos finales.
     */
    function showDelayedReels(finalReels) {
        // Detenemos el primer rodillo.
        setTimeout(() => { reels[0].textContent = finalReels[0]; }, 300);
        // Detenemos el segundo rodillo.
        setTimeout(() => { reels[1].textContent = finalReels[1]; }, 600);
        // Detenemos el tercer rodillo y comprobamos el resultado.
        setTimeout(() => {
            reels[2].textContent = finalReels[2];
            checkWinAndFinalize(finalReels);
        }, 1200);
    }

    /**
     * Comprueba si la combinación es ganadora, calcula el premio y finaliza la partida.
     * @param {string[]} finalReels - El array con los 3 símbolos finales.
     */
    async function checkWinAndFinalize(finalReels) {
        let prize = 0;
        let winningReels = [];

        // Comprobamos si hay 3 símbolos iguales.
        if (finalReels[0] === finalReels[1] && finalReels[1] === finalReels[2]) {
            prize = Math.floor(gameState.currentBet * 5); // Premio gordo
            winningReels = [0, 1, 2];
        }
        // Comprobamos si los 2 primeros son iguales.
        else if (finalReels[0] === finalReels[1]) {
            prize = Math.floor(gameState.currentBet * 1.5); // Premio pequeño
            winningReels = [0, 1];
        }
        // Comprobamos si los 2 últimos son iguales.
        else if (finalReels[1] === finalReels[2]) {
            prize = Math.floor(gameState.currentBet * 1.5); // Premio pequeño
            winningReels = [1, 2];
        }

        if (prize > 0) {
            await logGameResult('slots', prize);
            messageContainer.textContent = `¡Has ganado ${prize}!`;
            messageContainer.style.color = 'var(--color-primary)';
            winningReels.forEach(index => reels[index].classList.add('winning-reel'));

            // Pedimos al servidor que actualice nuestra racha y saldo.
            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            const response = await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': prize })
            });
            const data = await response.json();
            if (data.success) {
                gameState.balance = Math.floor(data.newBalance);
                gameState.winStreak++;
            }
        } else {
            await logGameResult('slots', -Math.floor(gameState.currentBet));
            messageContainer.textContent = "¡Perdiste, intenta de nuevo!";
            messageContainer.style.color = 'var(--color-text-muted)';
            reels.forEach(reel => reel.classList.add('losing-reel'));

            // Pedimos al servidor que reinicie nuestra racha.
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
            gameState.winStreak = 0;
        }

        // Avisamos a otros scripts que el juego ha terminado y que el saldo/racha han cambiado.
        document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: gameState.balance } }));
        document.dispatchEvent(new CustomEvent('winStreakUpdated', { detail: { newWinStreak: gameState.winStreak } }));
        document.dispatchEvent(new CustomEvent('gameEnded'));

        gameState.gameInProgress = false; // La partida ha terminado.
    }

    /**
     * Decide si el jugador debe ganar o perder, considerando los trucos.
     * @returns {number} - WINNER_MODE, LOSER_MODE o 0 (juego normal).
     */
    function shouldPlayerWin() {
        const potentialWinAmount = Math.floor(gameState.currentBet * 5); // Calculamos con el premio máximo.
        const potentialBalance = gameState.balance + potentialWinAmount;

        // --- Lógica de Trucos ---
        if (gameState.cheatSettings.max_balance != -1 && potentialBalance > gameState.cheatSettings.max_balance) {
            return LOSER_MODE; // Si ganar supera el saldo máximo, forzamos derrota.
        }
        if (gameState.cheatSettings.max_streak != -1 && gameState.winStreak >= gameState.cheatSettings.max_streak) {
            return LOSER_MODE; // Si ya alcanzó la racha máxima, forzamos derrota.
        }
        if (gameState.cheatSettings.mode === WINNER_MODE) return WINNER_MODE; // Forzar victoria.
        if (gameState.cheatSettings.mode === LOSER_MODE) return LOSER_MODE; // Forzar derrota.

        // --- Juego Normal ---
        return 0; // 0 significa que el resultado será aleatorio.
    }

    /**
     * Envía el resultado de la partida al servidor para que se guarde en el historial.
     * @param {string} gameName - El nombre del juego.
     * @param {number} resultAmount - El monto ganado o perdido (negativo si es pérdida).
     */
    async function logGameResult(gameName, resultAmount) {
        console.log(`[Game History] Logging result for '${gameName}'. Amount: ${resultAmount}`);
        await fetch('?action=logGame', {
            method: 'POST',
            body: new URLSearchParams({ 'game': gameName, 'result': resultAmount })
        });
    }

    // ================================================================= //
    // 4. INICIALIZACIÓN Y MANEJO DE EVENTOS                             //
    // ================================================================= //

    /** Carga los datos iniciales del jugador y los trucos desde el servidor. */
    async function initializeGame() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();

        gameState.balance = Math.floor(parseInt(data.balance, 10));
        gameState.winStreak = parseInt(data.win_streak, 10);
        gameState.cheatSettings = {
            mode: parseInt(data.cheat_settings.mode, 10),
            max_streak: parseInt(data.cheat_settings.max_streak, 10),
            max_balance: parseInt(data.cheat_settings.max_balance, 10),
        };
    }

    // --- Eventos Globales ---
    // Cuando el script de apuestas nos avisa, iniciamos el juego.
    document.addEventListener('betPlaced', (e) => startGame(e.detail));
    // Si cambian los trucos, actualizamos nuestro estado.
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    // Inicia todo al cargar la página.
    initializeGame();
});