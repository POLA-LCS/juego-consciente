document.addEventListener('DOMContentLoaded', async () => {
    /**
     * Este script gestiona la lógica de las apuestas en la mesa de la ruleta.
     * Se encarga de:
     * - Cargar y mostrar el saldo y la racha del jugador.
     * - Permitir al jugador seleccionar fichas y colocarlas en la mesa.
     * - Calcular y mostrar el total apostado.
     * - Funciones de deshacer, rehacer y limpiar apuestas.
     * - Enviar la información de la apuesta al script del juego de la ruleta.
     */

    // ================================================================= //
    // 1. ELEMENTOS DEL DOM                                              //
    // ================================================================= //
    // Guardamos en variables las partes de la página con las que vamos a interactuar.
    const balanceDisplay = document.getElementById('balance');
    const winStreakDisplay = document.getElementById('winStreak');
    const totalBetDisplay = document.getElementById('totalBet');
    const betSpots = document.querySelectorAll('.bet-spot'); // Todos los sitios donde se puede apostar.
    const chipSelectors = document.querySelectorAll('.chip-selector'); // Los botones para elegir el valor de la ficha.
    const clearBetsButton = document.getElementById('clearBets');
    const spinButton = document.getElementById('spinButton');
    const undoButton = document.getElementById('undoBet');
    const redoButton = document.getElementById('redoBet');

    // Agrupamos algunos elementos para poder deshabilitarlos todos a la vez fácilmente.
    const interactiveElements = [
        betSpots, chipSelectors, clearBetsButton, spinButton, undoButton, redoButton
    ];

    // ================================================================= //
    // 2. ESTADO DEL JUEGO                                               //
    // ================================================================= //
    // El objeto 'state' es como la "memoria" de nuestro script. Guarda toda la
    // información importante que necesita para funcionar.
    let state = {
        balance: 0,
        winStreak: 0,
        selectedChip: 50,
        bets: {}, // Guarda las apuestas. Ej: { "color_red": 50, "number_10": 100 }
        history: [], // Guarda cada clic de apuesta para poder "deshacer".
        redoHistory: [], // Guarda las acciones deshechas para poder "rehacer".
        totalBet: 0,
        isBettingLocked: false, // Bloquea los controles mientras la ruleta gira.
    };

    // ================================================================= //
    // 3. FUNCIONES DE INTERFAZ (UI) Y LÓGICA DE APUESTAS                //
    // ================================================================= //

    /**
     * Actualiza todos los textos y elementos visuales en la pantalla
     * para que reflejen el estado actual del juego.
     */
    function updateUI() {
        balanceDisplay.textContent = state.balance;
        winStreakDisplay.textContent = state.winStreak;
        totalBetDisplay.textContent = state.totalBet;

        // Actualiza la apariencia de cada casilla de apuesta en la mesa.
        for (const spot of betSpots) {
            const betKey = `${spot.dataset.betType}_${spot.dataset.betValue}`;
            const betAmount = state.bets[betKey] || 0;

            if (betAmount > 0) {
                // Si hay una apuesta en esta casilla, muestra una ficha con el monto.
                spot.innerHTML = `<span class="chip">${betAmount}</span>`;
            } else {
                // Si no hay apuesta, muestra el texto original de la casilla.
                const type = spot.dataset.betType;
                const value = spot.dataset.betValue;
                if (type === 'number') spot.innerHTML = value;
                else if (type === 'dozen') spot.innerHTML = `${value}ra Docena`;
                else if (type === 'color') spot.innerHTML = value.toUpperCase();
            }
        }

        // Activa o desactiva los botones de deshacer/rehacer si hay algo en sus historiales.
        undoButton.disabled = state.history.length === 0 || state.isBettingLocked;
        redoButton.disabled = state.redoHistory.length === 0 || state.isBettingLocked;
    }

    /**
     * Se ejecuta cuando el jugador elige una ficha de un valor diferente.
     * @param {number} value - El valor de la ficha seleccionada (ej. 50, 100).
     */
    function selectChip(value) {
        state.selectedChip = value;
        // Resalta visualmente la ficha seleccionada y quita el resaltado de las demás.
        for (const chip of chipSelectors) {
            chip.classList.toggle('active-chip', parseInt(chip.dataset.chipValue) === value);
        }
    }

    /**
     * Coloca una apuesta en una casilla específica de la mesa.
     * @param {HTMLElement} spot - La casilla de la mesa donde se hizo clic.
     */
    function placeBetOnSpot(spot) {
        if (state.isBettingLocked) return;

        const betAmount = state.selectedChip;
        if (state.balance < state.totalBet + betAmount) {
            alert("Saldo insuficiente.");
            return;
        }

        // Creamos una clave única para esta casilla (ej. "color_red").
        const betKey = `${spot.dataset.betType}_${spot.dataset.betValue}`;
        // Añadimos la apuesta a nuestra "memoria".
        state.bets[betKey] = (state.bets[betKey] || 0) + betAmount;
        state.totalBet += betAmount;

        // Guardamos esta acción en el historial para poder deshacerla.
        state.history.push({ key: betKey, amount: betAmount });
        // Si hacemos una nueva apuesta, el historial de "rehacer" ya no tiene sentido.
        state.redoHistory = [];

        updateUI();
    }

    /** Deshace la última apuesta realizada. */
    function undoLastBet() {
        if (state.history.length === 0 || state.isBettingLocked) return;

        // Saca la última acción del historial y la pone en el historial de "rehacer".
        const lastAction = state.history.pop();
        state.redoHistory.push(lastAction);

        // Resta el monto de la apuesta deshecha.
        state.bets[lastAction.key] -= lastAction.amount;
        state.totalBet -= lastAction.amount;

        updateUI();
    }

    /** Rehace la última apuesta que fue deshecha. */
    function redoLastBet() {
        if (state.redoHistory.length === 0 || state.isBettingLocked) return;

        // Saca la acción del historial de "rehacer" y la devuelve al historial normal.
        const nextAction = state.redoHistory.pop();
        state.history.push(nextAction);

        // Vuelve a sumar el monto de la apuesta rehecha.
        state.bets[nextAction.key] = (state.bets[nextAction.key] || 0) + nextAction.amount;
        state.totalBet += nextAction.amount;

        updateUI();
    }

    /** Limpia todas las apuestas de la mesa. */
    function clearAllBets() {
        if (state.isBettingLocked) return;
        // Reinicia todas las variables relacionadas con las apuestas.
        state.history = [];
        state.redoHistory = [];
        state.bets = {};
        state.totalBet = 0;
        updateUI();
    }

    /**
     * Inicia el giro de la ruleta.
     * Descuenta el saldo y notifica al script del juego.
     */
    async function spin() {
        if (state.totalBet <= 0) {
            alert("Realiza una apuesta antes de girar.");
            return;
        }
        state.isBettingLocked = true;
        toggleControls(false);

        // Le pedimos al servidor que descuente el total apostado de nuestro saldo.
        const response = await fetch(`?action=updateBalance`, {
            method: 'POST',
            body: new URLSearchParams({ 'amount': -state.totalBet })
        });
        const data = await response.json();

        if (data.success) {
            // Si el servidor confirma, actualizamos nuestro saldo local.
            state.balance = data.newBalance;
            updateUI();
            // Avisamos al script del juego de la ruleta que la apuesta está lista,
            // enviándole todas las apuestas que hicimos.
            document.dispatchEvent(new CustomEvent('betPlaced', {
                detail: { bets: state.bets, totalBet: state.totalBet }
            }));
        } else {
            alert("Error al realizar la apuesta.");
            // Si algo falla, desbloqueamos los controles para que el jugador pueda intentarlo de nuevo.
            state.isBettingLocked = false;
            toggleControls(true);
        }
    }

    /**
     * Habilita o deshabilita todos los controles de la mesa de apuestas.
     * @param {boolean} enabled - `true` para habilitar, `false` para deshabilitar.
     */
    function toggleControls(enabled) {
        spinButton.disabled = !enabled;
        clearBetsButton.disabled = !enabled;
        for (const c of chipSelectors) c.disabled = !enabled;
        undoButton.disabled = !enabled || state.history.length === 0;
        redoButton.disabled = !enabled || state.redoHistory.length === 0;

        // Añade o quita una clase a las casillas para que se vean bloqueadas.
        for (const spot of betSpots) {
            spot.classList.toggle('locked', !enabled);
        }
    }

    // ================================================================= //
    // 4. INICIALIZACIÓN Y MANEJO DE EVENTOS                             //
    // ================================================================= //

    /** Carga los datos iniciales del jugador desde el servidor. */
    async function initializeBetting() {
        const response = await fetch('?action=getPlayerData');
        const data = await response.json();
        state.balance = parseInt(data.balance, 10);
        state.winStreak = parseInt(data.win_streak, 10);
        updateUI();
    }

    // Asignamos las funciones a los eventos de clic de cada botón.
    for (const c of chipSelectors) {
        c.addEventListener('click', () => selectChip(parseInt(c.dataset.chipValue)));
    }
    for (const spot of betSpots) {
        spot.addEventListener('click', () => placeBetOnSpot(spot));
    }
    clearBetsButton.addEventListener('click', clearAllBets);
    undoButton.addEventListener('click', undoLastBet);
    redoButton.addEventListener('click', redoLastBet);
    spinButton.addEventListener('click', spin);

    // --- Eventos Globales ---

    // Cuando el juego de la ruleta nos avisa que ha terminado...
    document.addEventListener('gameEnded', () => {
        // ...desbloqueamos los controles para la siguiente ronda.
        state.isBettingLocked = false;
        toggleControls(true);
        // Limpiamos la mesa para la siguiente partida.
        clearAllBets();
        // Volvemos a cargar los datos del jugador por si han cambiado (saldo, racha).
        initializeBetting();
    });

    // Si otro script (como el panel de trucos) cambia nuestro saldo, nos enteramos aquí.
    document.addEventListener('balanceUpdated', e => {
        state.balance = e.detail.newBalance;
        updateUI();
    });

    // Inicia todo al cargar la página.
    initializeBetting();
});