document.addEventListener('DOMContentLoaded', async () => {
    /**
     * Este script controla la lógica del juego de los vasos (Trileros).
     * Se encarga de:
     * - Iniciar el juego cuando se realiza una apuesta.
     * - Determinar si el jugador gana o pierde, considerando los trucos.
     * - Animar los vasos y mostrar el resultado.
     * - Comunicarse con el servidor para actualizar el saldo y la racha.
     * - Resetear el juego para la siguiente ronda.
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM                                              //
    // ================================================================= //
    // Guardamos en variables las partes de la página con las que vamos a interactuar.
    const cups = document.querySelectorAll('.cup');
    const messageContainer = document.getElementById('message-container');
    const playAgainButton = document.getElementById('playAgain');

    // ================================================================= //
    // 2. ESTADO DEL JUEGO                                               //
    // ================================================================= //
    // El objeto 'gameState' es la "memoria" del juego. Guarda toda la
    // información importante que necesita para funcionar.
    let gameState = {
        balance: 0,
        winStreak: 0,
        currentBet: 0,
        MIN_BET: 0, // Se cargará desde el script de apuestas.
        cheatSettings: { mode: 0, max_streak: -1, max_balance: -1 },
        canChoose: false, // ¿Puede el jugador elegir un vaso ahora mismo?
        gameInProgress: false, // ¿Hay una partida en curso?
    };

    // ================================================================= //
    // 3. LÓGICA DEL JUEGO                                               //
    // ================================================================= //

    /**
     * Inicia una nueva ronda del juego. Se llama cuando se realiza una apuesta.
     * @param {object} betDetails - Contiene la información de la apuesta (monto, nuevo saldo).
     */
    function startGame(betDetails) {
        gameState.gameInProgress = true;
        gameState.balance = betDetails.newBalance;
        gameState.currentBet = betDetails.betAmount;

        messageContainer.textContent = "Elige un vaso...";
        gameState.canChoose = true; // A partir de ahora, el jugador puede hacer clic en un vaso.
    }

    /**
     * Decide si el jugador debe ganar o perder en esta ronda.
     * Tiene en cuenta los trucos activados (modo ganador/perdedor, límites).
     * @returns {boolean} - `true` si el jugador debe ganar, `false` si debe perder.
     */
    function shouldPlayerWin() {
        // Calculamos cuánto ganaría el jugador y cuál sería su nuevo saldo.
        const potentialWinAmount = gameState.currentBet * 2;
        const potentialBalance = gameState.balance + potentialWinAmount;

        // --- Lógica de Trucos ---
        // 1. Si ganar supera el saldo máximo permitido, forzamos una derrota.
        if (gameState.cheatSettings.max_balance != -1 && potentialBalance > gameState.cheatSettings.max_balance) {
            return false;
        }
        // 2. Si ya alcanzó la racha máxima permitida, forzamos una derrota.
        if (gameState.cheatSettings.max_streak != -1 && gameState.winStreak >= gameState.cheatSettings.max_streak) {
            return false;
        }
        // 3. Si el "Modo Ganador" está activo, forzamos una victoria.
        if (gameState.cheatSettings.mode === 1) return true;
        // 4. Si el "Modo Perdedor" está activo, forzamos una derrota.
        if (gameState.cheatSettings.mode === 2) return false;

        // --- Juego Normal (sin trucos) ---
        // Hay 3 vasos, así que la probabilidad normal de ganar es 1 entre 3.
        return Math.random() < (1 / 3);
    }

    /**
     * Se ejecuta cuando el jugador hace clic en un vaso.
     * @param {number} cupNumber - El número del vaso elegido (1, 2 o 3).
     */
    async function chooseCup(cupNumber) {
        // Si no es el momento de elegir (ej. el juego ya terminó), no hacemos nada.
        if (!gameState.canChoose) return;
        gameState.canChoose = false; // Bloqueamos para que no se pueda hacer clic de nuevo.

        const isWinner = shouldPlayerWin(); // Decidimos si gana o pierde.

        // Levantamos el vaso elegido para mostrar lo que hay debajo.
        document.getElementById(`cup-${cupNumber}`).style.transform = 'translateY(-30px)';

        if (isWinner) {
            const wonBalance = gameState.currentBet * 2;
            messageContainer.textContent = `¡Has ganado ${wonBalance}!`;
            messageContainer.style.color = 'var(--color-primary)';

            // Le pedimos al servidor que incremente nuestra racha y nos dé el premio.
            await fetch(`?action=incrementWinStreak`, { method: 'POST' });
            const response = await fetch(`?action=updateBalance`, {
                method: 'POST',
                body: new URLSearchParams({ 'amount': wonBalance })
            });
            const data = await response.json();
            if (data.success) {
                // Actualizamos nuestros datos locales con la respuesta del servidor.
                gameState.balance = data.newBalance;
                gameState.winStreak++;
                // Avisamos a otros scripts (como el de la barra de apuestas) que la racha cambió.
                document.dispatchEvent(new CustomEvent('winStreakUpdated', {
                    detail: { newWinStreak: gameState.winStreak }
                }));
            }
        } else {
            messageContainer.textContent = "¡Perdiste! Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';

            // Le pedimos al servidor que reinicie nuestra racha de victorias a 0.
            await fetch(`?action=setWinStreak`, {
                method: 'POST',
                body: new URLSearchParams({ 'streak': 0 })
            });
            gameState.winStreak = 0;
            // Avisamos a otros scripts del cambio en la racha.
            document.dispatchEvent(new CustomEvent('winStreakUpdated', {
                detail: { newWinStreak: gameState.winStreak }
            }));
        }

        // Avisamos a otros scripts que el saldo ha cambiado para que actualicen la pantalla.
        document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: gameState.balance } }));

        // Esperamos 2 segundos antes de preparar la siguiente ronda.
        setTimeout(() => {
            resetGame();
        }, 2000);
    }

    /** Prepara el juego para una nueva ronda. */
    function resetGame() {
        gameState.gameInProgress = false;
        messageContainer.innerHTML = '&nbsp;'; // Limpiamos el mensaje.
        cups.forEach(cup => cup.style.transform = 'translateY(0)'); // Bajamos los vasos.

        // Avisamos al script de apuestas que el juego ha terminado, para que reactive los botones.
        document.dispatchEvent(new CustomEvent('gameEnded'));

        // Volvemos a cargar los datos por si algo cambió.
        initializeGame();
    }

    // ================================================================= //
    // 4. INICIALIZACIÓN Y MANEJO DE EVENTOS                             //
    // ================================================================= //

    /** Carga los datos iniciales del jugador y los trucos desde el servidor. */
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

    // Asignamos las funciones a los eventos de clic.
    playAgainButton.addEventListener('click', resetGame);
    cups.forEach((cup, index) => cup.addEventListener('click', () => chooseCup(index + 1)));

    // --- Eventos Globales ---

    // Este es el evento principal: cuando el script de apuestas nos dice "¡Apuesta realizada!", iniciamos el juego.
    document.addEventListener('betPlaced', (e) => {
        startGame(e.detail);
    });

    // Esperamos a que el script de apuestas nos diga que está listo para obtener la apuesta mínima.
    document.addEventListener('betScriptLoaded', (e) => {
        console.log('Bet script loaded. MIN_BET:', e.detail.MIN_BET);
        gameState.MIN_BET = e.detail.MIN_BET;
    });

    // Si el saldo o los trucos cambian desde otro script (como el panel de trucos), actualizamos nuestro estado.
    document.addEventListener('balanceUpdated', e => gameState.balance = e.detail.newBalance);
    document.addEventListener('cheatSettingsChanged', e => gameState.cheatSettings = e.detail);

    // Inicia todo al cargar la página.
    initializeGame();
});