document.addEventListener('DOMContentLoaded', async () => {
    /**
     * Este script controla la lógica del juego de la ruleta en sí.
     * Se encarga de:
     * - Iniciar la animación de giro cuando recibe una apuesta.
     * - Determinar el número ganador (considerando los trucos).
     * - Calcular las ganancias y mostrar el resultado.
     * - Comunicarse con el servidor para actualizar saldo y racha.
     * - Notificar a otros scripts cuando el juego ha terminado.
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM Y CONSTANTES                                 //
    // ================================================================= //
    const resultDisplay = document.getElementById('result-display');
    const resultNumber = document.getElementById('result-number');
    const messageContainer = document.getElementById('message-container');

    // Estas son "constantes", valores que no cambian.
    // El orden de los números en la ruleta real.
    const ROULETTE_NUMBERS = [
        0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6, 27, 13, 36, 11, 30, 8, 23, 10,
        5, 24, 16, 33, 1, 20, 14, 31, 9, 22, 18, 29, 7, 28, 12, 35, 3, 26
    ];
    // Una lista de todos los números que son rojos.
    const REDS = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];

    // ================================================================= //
    // 2. ESTADO DEL JUEGO                                               //
    // ================================================================= //
    // La "memoria" del juego, donde guardamos la configuración de los trucos.
    let gameState = {
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
    };

    // ================================================================= //
    // 3. LÓGICA DEL JUEGO                                               //
    // ================================================================= //

    /**
     * Inicia el juego y la animación de giro.
     * @param {object} betDetails - La información de las apuestas desde `roulette_bet.js`.
     */
    function startGame(betDetails) {
        messageContainer.textContent = "Girando...";
        messageContainer.style.color = 'var(--color-text-muted)';

        // Para simular el giro, cambiamos el número rápidamente durante unos segundos.
        let spinCount = 0;
        const spinInterval = setInterval(() => {
            // Elegimos un número al azar de la ruleta.
            const randomIndex = Math.floor(Math.random() * ROULETTE_NUMBERS.length);
            const number = ROULETTE_NUMBERS[randomIndex];

            // Lo mostramos en la pantalla.
            resultNumber.textContent = number;
            // Ponemos el fondo gris para indicar que está girando.
            resultDisplay.style.backgroundColor = getNumberColor(number, true);

            spinCount++;
            // Después de unos 3 segundos (30 giros * 100ms)...
            if (spinCount > 30) {
                // ...detenemos la animación y calculamos el resultado final.
                clearInterval(spinInterval);
                endGame(betDetails);
            }
        }, 100); // Esto se repite cada 100 milisegundos.
    }

    /**
     * Finaliza el juego, calcula el resultado y las ganancias, y actualiza la UI.
     * @param {object} betDetails - La información de las apuestas.
     */
    async function endGame(betDetails) {
        // Decidimos cuál será el número ganador (considerando los trucos).
        const winningNumber = determineWinningNumber(betDetails.bets);

        // Mostramos el número y color finales.
        resultNumber.textContent = winningNumber;
        resultDisplay.style.backgroundColor = getNumberColor(winningNumber, false);

        // Calculamos cuánto dinero ha ganado el jugador.
        const winnings = calculateWinnings(winningNumber, betDetails.bets);

        if (winnings > 0) {
            messageContainer.textContent = `¡Has ganado ${winnings}!`;
            messageContainer.style.color = 'var(--color-primary)';

            // Le pedimos al servidor que actualice nuestra racha y nos dé el premio.
            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': winnings })
            });
        } else {
            messageContainer.textContent = "¡Perdiste! Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';

            // Le pedimos al servidor que reinicie nuestra racha de victorias.
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
        }

        // Avisamos a los otros scripts (como el de apuestas) que el juego ha terminado.
        document.dispatchEvent(new CustomEvent('gameEnded'));
    }

    /**
     * Calcula las ganancias totales basándose en el número ganador y las apuestas realizadas.
     * @param {number} winningNumber - El número que ha salido en la ruleta.
     * @param {object} bets - El objeto con todas las apuestas del jugador.
     * @returns {number} - La cantidad total ganada.
     */
    function calculateWinnings(winningNumber, bets) {
        let totalWinnings = 0;
        const winningColor = REDS.includes(winningNumber) ? 'red' : (winningNumber === 0 ? 'green' : 'black');

        // Recorremos cada apuesta que hizo el jugador.
        for (const betKey in bets) {
            // Separamos la clave de la apuesta, ej: "color_red" -> "color" y "red".
            const [type, value] = betKey.split('_');
            const betAmount = bets[betKey];

            // Comprobamos si la apuesta es ganadora y añadimos el premio.
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

    /**
     * Decide el número ganador. Si hay trucos activos, intenta forzar un resultado.
     * @param {object} bets - Las apuestas del jugador.
     * @returns {number} - El número ganador.
     */
    function determineWinningNumber(bets) {
        // --- LÓGICA DE TRUCOS: MODO GANADOR ---
        if (gameState.cheatSettings.mode === 1) {
            // 1. Averiguamos a qué ha apostado el jugador.
            const playerBets = new Set(); // Usamos un Set para no tener números repetidos.
            for (const betKey in bets) {
                if (bets[betKey] > 0) {
                    const [type, value] = betKey.split('_');
                    if (type === 'number') playerBets.add(parseInt(value));
                    if (type === 'color') {
                        const numbersForColor = (value === 'red') ? REDS : ROULETTE_NUMBERS.filter(n => n > 0 && !REDS.includes(n));
                        numbersForColor.forEach(n => playerBets.add(n));
                    }
                    if (type === 'dozen') {
                        const dozen = parseInt(value);
                        const start = (dozen - 1) * 12 + 1;
                        const end = dozen * 12;
                        for (let i = start; i <= end; i++) playerBets.add(i);
                    }
                }
            }

            // 2. Si el jugador ha apostado a algo, elegimos uno de esos números para que gane.
            const winningOptions = Array.from(playerBets);
            if (winningOptions.length > 0) {
                return winningOptions[Math.floor(Math.random() * winningOptions.length)];
            }
        }

        // --- LÓGICA DE TRUCOS: MODO PERDEDOR ---
        if (gameState.cheatSettings.mode === 2) {
            // 1. Averiguamos a qué ha apostado el jugador (los números que le harían ganar).
            const playerWinningNumbers = new Set();
            for (const betKey in bets) {
                if (bets[betKey] > 0) {
                    const [type, value] = betKey.split('_');
                    if (type === 'number') playerWinningNumbers.add(parseInt(value));
                    if (type === 'color') {
                        const numbersForColor = (value === 'red') ? REDS : ROULETTE_NUMBERS.filter(n => n > 0 && !REDS.includes(n));
                        numbersForColor.forEach(n => playerWinningNumbers.add(n));
                    }
                    if (type === 'dozen') {
                        const dozen = parseInt(value);
                        const start = (dozen - 1) * 12 + 1;
                        const end = dozen * 12;
                        for (let i = start; i <= end; i++) playerWinningNumbers.add(i);
                    }
                }
            }

            // 2. Creamos una lista de todos los números que harían PERDER al jugador.
            const losingNumbers = ROULETTE_NUMBERS.filter(n => !playerWinningNumbers.has(n));

            // 3. Si hay números perdedores disponibles, elegimos uno de ellos.
            if (losingNumbers.length > 0) {
                return losingNumbers[Math.floor(Math.random() * losingNumbers.length)];
            }
        }

        // --- JUEGO NORMAL (sin trucos o si no se pudo forzar un resultado) ---
        // Elegimos un número completamente al azar entre 0 y 36.
        return Math.floor(Math.random() * 37);
    }

    /**
     * Devuelve el código de color para un número de la ruleta.
     * @param {number} number - El número de la ruleta.
     * @param {boolean} isSpinning - `true` si la ruleta está girando.
     * @returns {string} - El color (ej. '#0c9d5b', 'var(--color-primary)').
     */
    function getNumberColor(number, isSpinning) {
        if (isSpinning) return '#374151'; // Gris mientras gira.
        if (number === 0) return '#0c9d5b'; // Verde para el 0.
        return REDS.includes(number) ? 'var(--color-primary)' : '#1f1f1f'; // Rojo o Negro.
    }

    // ================================================================= //
    // 4. INICIALIZACIÓN Y MANEJO DE EVENTOS                             //
    // ================================================================= //

    /** Carga la configuración de trucos al iniciar. */
    async function initializeGame() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        gameState.cheatSettings = data.cheat_settings;
    }

    // Cuando el script de apuestas nos avisa, iniciamos el juego.
    document.addEventListener('betPlaced', (e) => startGame(e.detail));
    // Si cambian los trucos, actualizamos nuestro estado.
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    // Inicia todo al cargar la página.
    initializeGame();
});