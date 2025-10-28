document.addEventListener('DOMContentLoaded', () => {
    // --- LÓGICA DE APUESTAS (Reutilizada) ---
    const MIN_BET = 25;
    const balanceDisplay = document.getElementById('balance');
    const currentBetDisplay = document.getElementById('currentBet');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');

    let userBalance = 0;
    let currentBetValue = MIN_BET;

    function updateBetUI() { currentBetDisplay.textContent = currentBetValue; }
    function updateUserBalance(newBalance) {
        userBalance = newBalance;
        balanceDisplay.textContent = userBalance;
        if (currentBetValue > userBalance) { currentBetValue = userBalance; }
        updateBetUI();
    }
    function addToBet(amount) {
        const newBet = currentBetValue + amount;
        currentBetValue = (newBet > userBalance) ? userBalance : newBet;
        updateBetUI();
    }
    function resetBet() {
        currentBetValue = (MIN_BET > userBalance) ? userBalance : MIN_BET;
        updateBetUI();
    }

    fetch('?action=getBalance').then(r => r.json()).then(data => {
        updateUserBalance(parseInt(data, 10));
        resetBet();
    });

    betChips.forEach(b => b.addEventListener('click', () => addToBet(parseInt(b.dataset.amount, 10))));
    resetBetButton.addEventListener('click', resetBet);
    document.addEventListener('balanceUpdated', e => updateUserBalance(e.detail.newBalance));

    // --- LÓGICA DEL JUEGO CUPS ---
    const cups = document.querySelectorAll('.cup');
    const messageContainer = document.getElementById('message-container');
    const playAgainButton = document.getElementById('playAgain');

    let winningCup = -1;
    let canChoose = false;

    function startGame() {
        if (currentBetValue <= 0 || currentBetValue > userBalance) {
            alert("Apuesta inválida.");
            return;
        }

        // Deshabilitar controles de apuesta
        placeBetButton.disabled = true;
        betChips.forEach(b => b.disabled = true);
        resetBetButton.disabled = true;

        // Lógica para restar la apuesta del saldo
        const formData = new FormData();
        formData.append('amount', -currentBetValue);
        fetch('?action=updateBalance', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    updateUserBalance(userBalance - currentBetValue);
                    // Iniciar el juego
                    messageContainer.textContent = "Elige un vaso...";
                    winningCup = Math.floor(Math.random() * 3) + 1;
                    canChoose = true;
                } else {
                    alert('Error al realizar la apuesta.');
                    resetGame();
                }
            });
    }

    function chooseCup(cupNumber) {
        if (!canChoose) return;
        canChoose = false;

        const chosenCup = document.getElementById(`cup-${cupNumber}`);
        const isWinner = cupNumber === winningCup;

        // Animar el vaso elegido
        chosenCup.style.transform = 'translateY(-30px)';

        if (isWinner) {
            messageContainer.textContent = `¡Has ganado ${currentBetValue * 2}!`;
            messageContainer.style.color = 'var(--color-primary)';
            // Lógica para sumar el premio al saldo
            const formData = new FormData();
            formData.append('amount', currentBetValue * 2);
            fetch('?action=updateBalance', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => { if (data.success) updateUserBalance(userBalance + (currentBetValue * 2)); });
        } else {
            messageContainer.textContent = "Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';
        }
        playAgainButton.classList.remove('hidden');
    }

    function resetGame() {
        placeBetButton.disabled = false;
        betChips.forEach(b => b.disabled = false);
        resetBetButton.disabled = false;
        playAgainButton.classList.add('hidden');
        messageContainer.innerHTML = '&nbsp;';
        cups.forEach(cup => cup.style.transform = 'translateY(0)');
    }

    placeBetButton.addEventListener('click', startGame);
    playAgainButton.addEventListener('click', resetGame);
    cups.forEach((cup, index) => cup.addEventListener('click', () => chooseCup(index + 1)));
});