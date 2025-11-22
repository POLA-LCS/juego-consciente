document.addEventListener('DOMContentLoaded', async () => {
    /**
     * Este script gestiona la lógica de la barra lateral de apuestas (Bet Sidebar).
     * Se encarga de:
     * - Cargar y mostrar el saldo y la racha de victorias del jugador.
     * - Permitir al jugador aumentar, reiniciar o establecer la apuesta máxima.
     * - Procesar la apuesta y comunicarla al juego correspondiente.
     * - Bloquear y desbloquear los controles de apuesta durante el juego.
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM                                              //
    // ================================================================= //
    // Referencias a los elementos de la interfaz con los que interactuamos.
    const balanceDisplay = document.getElementById('balance');
    const winStreakDisplay = document.getElementById('winStreak');
    const currentBetDisplay = document.getElementById('currentBet');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');
    const maxBetButton = document.getElementById('maxBetButton');

    // ================================================================= //
    // 2. ESTADO DEL JUEGO                                               //
    // ================================================================= //
    // Almacena la información clave que el script necesita para funcionar.
    const MIN_BET = 100;
    let betState = {
        balance: 0,
        winStreak: 0,
        currentBet: MIN_BET,
        isBettingLocked: false, // Bloquea los controles mientras un juego está en curso.
    };

    // ================================================================= //
    // 3. FUNCIONES DE INTERFAZ (UI)                                     //
    // ================================================================= //

    /**
     * Actualiza los elementos visuales (saldo, racha, apuesta) con los
     * valores actuales del estado del juego.
     */
    function updateBetUI() {
        if (balanceDisplay) balanceDisplay.textContent = betState.balance;
        if (winStreakDisplay) winStreakDisplay.textContent = betState.winStreak;
        if (currentBetDisplay) currentBetDisplay.textContent = betState.currentBet;
    }

    /**
     * Habilita o deshabilita todos los controles de apuesta.
     * @param {boolean} enabled - `true` para habilitar, `false` para deshabilitar.
     */
    function toggleBetControls(enabled) {
        betState.isBettingLocked = !enabled;
        if (placeBetButton) placeBetButton.disabled = !enabled;
        if (resetBetButton) resetBetButton.disabled = !enabled;
        if (maxBetButton) maxBetButton.disabled = !enabled;
        if (betChips) betChips.forEach(b => b.disabled = !enabled);
    }

    // ================================================================= //
    // 4. LÓGICA DE APUESTAS                                             //
    // ================================================================= //

    /** Añade una cantidad a la apuesta actual, sin superar el saldo. */
    function addToBet(amount) {
        if (betState.isBettingLocked) return;
        const newBet = betState.currentBet + amount;
        betState.currentBet = Math.min(newBet, betState.balance);
        updateBetUI();
    }

    /** Reinicia la apuesta a su valor mínimo. */
    function resetBet() {
        if (betState.isBettingLocked) return;
        betState.currentBet = Math.min(MIN_BET, betState.balance);
        updateBetUI();
    }

    /** Establece la apuesta al saldo máximo disponible. */
    function setMaxBet() {
        if (betState.isBettingLocked) return;
        betState.currentBet = betState.balance;
        updateBetUI();
    }

    /**
     * Procesa la apuesta: la descuenta del saldo y notifica al juego.
     * Bloquea los controles hasta que el juego termine.
     */
    async function placeBet() {
        if (betState.currentBet <= 0 || betState.currentBet > betState.balance) {
            alert("Apuesta inválida.");
            return;
        }

        toggleBetControls(false); // Bloquea los controles durante la partida.

        const response = await fetch(`?action=updateBalance`, {
            method: 'POST',
            body: new URLSearchParams({ 'amount': -betState.currentBet })
        });

        const data = await response.json();

        if (data.success) {
            betState.balance = data.newBalance;
            updateBetUI();
            // Notifica al script del juego que la apuesta se ha realizado.
            document.dispatchEvent(new CustomEvent('betPlaced', {
                detail: {
                    newBalance: betState.balance,
                    betAmount: betState.currentBet
                }
            }));
        } else {
            alert('Error al realizar la apuesta.');
            toggleBetControls(true); // Desbloquea los controles si la apuesta falla.
        }
    }

    // ================================================================= //
    // 5. INICIALIZACIÓN Y MANEJO DE EVENTOS                             //
    // ================================================================= //

    /**
     * Carga los datos iniciales del jugador (saldo, racha) desde el servidor
     * y configura el estado inicial de las apuestas.
     */
    async function initializeBetting() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        betState.balance = parseInt(data.balance, 10);
        betState.winStreak = parseInt(data.win_streak, 10);
        resetBet();
        updateBetUI();

        // Notifica a otros scripts (como los juegos) que este script está listo.
        document.dispatchEvent(new CustomEvent('betScriptLoaded', {
            detail: { MIN_BET: MIN_BET }
        }));
    }

    // Asigna las funciones a los clics de los botones.
    betChips.forEach(b => b.addEventListener('click', () => addToBet(parseInt(b.dataset.amount, 10))));
    resetBetButton.addEventListener('click', resetBet);
    placeBetButton.addEventListener('click', placeBet);
    maxBetButton.addEventListener('click', setMaxBet);

    // Escucha eventos de otros scripts para mantener el estado sincronizado.
    document.addEventListener('balanceUpdated', e => {
        betState.balance = e.detail.newBalance;
        updateBetUI();
    });

    document.addEventListener('gameEnded', () => {
        console.log('Game has ended. Re-enabling bet controls.');
        toggleBetControls(true); // Reactiva los controles para la siguiente ronda.
    });

    document.addEventListener('winStreakUpdated', e => {
        betState.winStreak = e.detail.newWinStreak;
        updateBetUI();
    });

    // Inicia el script.
    initializeBetting();
});