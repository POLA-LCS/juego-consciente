document.addEventListener('DOMContentLoaded', () => {
    // --- LÓGICA DE APUESTAS (Reutilizada) ---
    const MIN_BET = 25;
    const balanceDisplay = document.getElementById('balance');
    const currentBetDisplay = document.getElementById('currentBet');
    const betChips = document.querySelectorAll('.bet-chip');
    const resetBetButton = document.getElementById('resetBet');
    const placeBetButton = document.getElementById('placeBet');
    const winStreakDisplay = document.getElementById('winStreak');

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

    // Cargar la racha de victorias inicial
    fetch('?action=getWinStreak').then(r => r.json()).then(data => {
        winStreak = parseInt(data.win_streak, 10);
        winStreakDisplay.textContent = winStreak;
    });

    betChips.forEach(b => b.addEventListener('click', () => addToBet(parseInt(b.dataset.amount, 10))));
    resetBetButton.addEventListener('click', resetBet);
    document.addEventListener('balanceUpdated', e => updateUserBalance(e.detail.newBalance));

    // --- LÓGICA DEL JUEGO CUPS ---
    const cups = document.querySelectorAll('.cup');
    const messageContainer = document.getElementById('message-container');
    const playAgainButton = document.getElementById('playAgain');

    let canChoose = false;
    let winStreak = 0; // Contador para la racha de victorias
    let cheatSettings = { mode: 0, max_streak: -1, max_balance: -1 }; // Configuración de trampas

    // Función para actualizar la configuración de trampas localmente
    function updateLocalCheatSettings(newSettings) {
        cheatSettings = newSettings;
        console.log('Local cheat settings updated:', cheatSettings);
    }

    // Cargar la configuración de trampas al iniciar
    fetch('?action=getCheatSettings')
        .then(response => response.json())
        .then(settings => {
            cheatSettings = settings;
            // Convertir a números para comparaciones seguras
            cheatSettings.mode = parseInt(settings.mode, 10);
            cheatSettings.max_streak = parseInt(settings.max_streak, 10);
            cheatSettings.max_balance = parseInt(settings.max_balance, 10);
            console.log('Initial cheat settings loaded:', cheatSettings);
        });

    // Escuchar el evento personalizado desde cheat_sidebar.js para actualizaciones en tiempo real
    document.addEventListener('cheatSettingsChanged', (e) => {
        updateLocalCheatSettings(e.detail);
    });

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
                    canChoose = true;
                } else {
                    alert('Error al realizar la apuesta.');
                    resetGame();
                }
            });
    }

    // --- NUEVA LÓGICA DE DECISIÓN ---
    // Esta función determina si el jugador debe ganar o perder
    function shouldPlayerWin() {
        // Condición 1: ¿La ganancia potencial superaría el máximo saldo? Si es así, forzar derrota.
        const potentialWinAmount = currentBetValue * 2;
        const potentialBalance = userBalance + potentialWinAmount;
        if (cheatSettings.max_balance !== -1 && potentialBalance > cheatSettings.max_balance) {
            console.log("Cheat: Forzando derrota por alcanzar máximo saldo.");
            return false;
        }

        // Condición 2: ¿Se ha alcanzado la máxima racha? Si es así, forzar derrota.
        if (cheatSettings.max_streak !== -1 && winStreak >= cheatSettings.max_streak) {
            console.log("Cheat: Forzando derrota por alcanzar máxima racha.");
            return false;
        }

        // Condición 3: ¿Está activado el modo ganador?
        if (cheatSettings.mode === 1) {
            console.log("Cheat: Forzando victoria.");
            return true;
        }

        // Condición 4: ¿Está activado el modo perdedor?
        if (cheatSettings.mode === 2) {
            console.log("Cheat: Forzando derrota.");
            return false;
        }

        // Si no hay trampas activas, el resultado es aleatorio (1/3 de probabilidad de ganar).
        return Math.random() < (1 / 3);
    }

    function chooseCup(cupNumber) {
        if (!canChoose) return;
        canChoose = false;

        const chosenCup = document.getElementById(`cup-${cupNumber}`);
        const isWinner = shouldPlayerWin();

        console.log(`isWinner: ${isWinner}`);

        // Animar el vaso elegido
        chosenCup.style.transform = 'translateY(-30px)';

        if (isWinner) {
            messageContainer.textContent = `¡Has ganado ${currentBetValue * 2}!`;
            messageContainer.style.color = 'var(--color-primary)';
            // Incrementar racha de victorias en el backend
            fetch('?action=incrementWinStreak', { method: 'POST' })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        winStreak++;
                        winStreakDisplay.textContent = winStreak;
                    }
                });
            // Lógica para sumar el premio al saldo
            const formData = new FormData();
            formData.append('amount', currentBetValue * 2);
            fetch('?action=updateBalance', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => { if (data.success) updateUserBalance(userBalance + (currentBetValue * 2)); });
        } else {
            messageContainer.textContent = "Inténtalo de nuevo...";
            messageContainer.style.color = 'var(--color-text-muted)';
            // Resetear racha de victorias en el backend
            const formData = new FormData();
            formData.append('streak', 0);
            fetch('?action=setWinStreak', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        winStreak = 0;
                        winStreakDisplay.textContent = winStreak;
                    }
                });
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