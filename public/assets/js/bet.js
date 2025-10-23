/**
 * Juego Consciente - Lógica de la Interfaz de Apuesta (Bet Sidebar)
 * Ubicación: ludopatia/public/assets/js/bet.js
 */

document.addEventListener('DOMContentLoaded', function () {
    const betAmountDisplay = document.getElementById('bet-amount');
    const betControlButtons = document.querySelectorAll('.bet-control-btn');
    const resetBetButton = document.getElementById('reset-bet');
    const placeBetButton = document.getElementById('place-bet');

    // Solo inicializar si los elementos existen (es decir, si estamos en una vista de juego)
    if (!betAmountDisplay) return;

    let currentBet = 0;

    /**
     * Actualiza el monto de la apuesta y el display.
     * @param {number} value El valor a sumar/restar a la apuesta.
     */
    function updateBetAmount(value) {
        // Obtenemos el saldo actual para límites (Necesita estar en la vista HTML)
        const currentBalanceElement = document.getElementById('current-balance');
        const currentBalance = currentBalanceElement ? parseFloat(currentBalanceElement.textContent.replace(/[$,]/g, '')) : Infinity;

        const newBet = currentBet + value;

        // Regla 1: No permitir apuestas negativas.
        // Regla 2: No permitir apostar más del saldo disponible.
        if (newBet >= 0 && newBet <= currentBalance) {
            currentBet = newBet;
        } else if (newBet < 0) {
            currentBet = 0; // Mínimo a 0
        } else if (newBet > currentBalance) {
            currentBet = currentBalance; // Máximo al saldo
        }

        betAmountDisplay.textContent = currentBet;
    }

    // Asignar eventos a los botones de control
    betControlButtons.forEach(button => {
        button.addEventListener('click', function () {
            const value = parseInt(this.getAttribute('data-value'));
            updateBetAmount(value);
        });
    });

    // Evento para el botón de resetear
    if (resetBetButton) {
        resetBetButton.addEventListener('click', function () {
            currentBet = 0;
            betAmountDisplay.textContent = currentBet;
        });
    }

    // Evento para iniciar el juego (lógica AJAX/Fetch pendiente)
    if (placeBetButton) {
        placeBetButton.addEventListener('click', function () {
            if (currentBet > 0) {
                console.log(`Apostando: ${currentBet}. Lógica de juego pendiente.`);
                // Aquí iría el llamado Fetch/AJAX al controlador del juego (ej: BlackjackController/play)
            } else {
                alert('Debes apostar una cantidad mayor a 0.');
            }
        });
    }
});