document.addEventListener('DOMContentLoaded', () => {
    // --- LÓGICA DE APUESTAS ---
    const MIN_BET = 25;
    const balanceDisplay = document.getElementById('balance');
    const currentBetDisplay = document.getElementById('currentBet');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');

    let userBalance = 0;
    let currentBetValue = MIN_BET;

    // Función para actualizar la UI de la apuesta
    function updateBetUI() {
        currentBetDisplay.textContent = currentBetValue;
    }

    // Función para añadir a la apuesta
    function addToBet(amount) {
        const newBet = currentBetValue + amount;
        // La apuesta no puede superar el saldo actual
        if (newBet > userBalance) {
            currentBetValue = userBalance;
        } else {
            currentBetValue = newBet;
        }
        updateBetUI();
    }

    // Función para resetear la apuesta al mínimo
    function resetBet() {
        currentBetValue = MIN_BET;
        // Asegurarse de que el mínimo no sea mayor que el saldo
        if (currentBetValue > userBalance) {
            currentBetValue = userBalance;
        }
        updateBetUI();
    }

    // Obtener el saldo inicial del usuario
    fetch('?action=getBalance')
        .then(response => response.json())
        .then(data => {
            userBalance = parseInt(data, 10);
            balanceDisplay.textContent = userBalance;
            // Ajustar la apuesta inicial si el saldo es menor que el mínimo
            if (userBalance < MIN_BET) {
                currentBetValue = userBalance;
                updateBetUI();
            }
        })
        .catch(error => console.error('Error al obtener el saldo:', error));

    // Asignar eventos a los chips de apuesta
    betChips.forEach(button => {
        button.addEventListener('click', () => {
            const amount = parseInt(button.dataset.amount, 10);
            addToBet(amount);
        });
    });

    // Evento para el botón de reset
    resetBetButton.addEventListener('click', resetBet);

    // --- LÓGICA DEL JUEGO BLACKJACK ---
    let deck = [];
    let playerCards = [];
    let dealerCards = [];
    let gameStarted = false;

    const suits = ['♠', '♥', '♦', '♣'];
    const values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    function createDeck() {
        deck = [];
        for (let suit of suits) {
            for (let value of values) {
                deck.push({ suit, value });
            }
        }
        shuffleDeck();
    }

    function shuffleDeck() {
        for (let i = deck.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [deck[i], deck[j]] = [deck[j], deck[i]];
        }
    }

    function getCardValue(card) {
        if (card.value === 'A') return 11;
        if (['J', 'Q', 'K'].includes(card.value)) return 10;
        return parseInt(card.value);
    }

    function calculateScore(cards) {
        let score = 0;
        let aces = 0;
        for (let card of cards) {
            score += getCardValue(card);
            if (card.value === 'A') aces++;
        }
        while (score > 21 && aces > 0) {
            score -= 10;
            aces--;
        }
        return score;
    }

    // La lógica para renderizar cartas, scores, etc. iría aquí.
    // ...

    function startGame() {
        if (currentBetValue <= 0 || currentBetValue > userBalance) {
            alert("Apuesta inválida.");
            return;
        }
        console.log(`Apostando ${currentBetValue}...`);
        // Aquí comenzaría la lógica del juego de Blackjack
        // Por ejemplo: deshabilitar botones de apuesta, repartir cartas, etc.
        betChips.forEach(b => b.disabled = true);
        placeBetButton.disabled = true;
        resetBetButton.disabled = true;

        // Lógica para actualizar el saldo en el backend
        const formData = new FormData();
        formData.append('amount', -currentBetValue);

        fetch('?action=updateBalance', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                userBalance -= currentBetValue;
                balanceDisplay.textContent = userBalance;
                // Ahora que el saldo está actualizado, reparte las cartas
                // dealCards(); // (Función a implementar)
            } else {
                alert('Error al actualizar el saldo.');
                // Reactivar botones si falla
                betChips.forEach(b => b.disabled = false);
                placeBetButton.disabled = false;
                resetBetButton.disabled = false;
            }
        });
    }

    // Evento para el botón de apostar
    placeBetButton.addEventListener('click', startGame);
});
