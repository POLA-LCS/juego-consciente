document.addEventListener('DOMContentLoaded', () => {
    const cheatSidebar = document.getElementById('cheatSidebar');
    const openCheatSidebar = document.getElementById('openCheatSidebar'); // Botón en el userSidebar
    const closeCheatSidebar = document.getElementById('closeCheatSidebar'); // Botón 'x' en el cheatSidebar

    if (openCheatSidebar && cheatSidebar && closeCheatSidebar) {
        openCheatSidebar.addEventListener('click', (e) => {
            e.preventDefault(); // Prevenir la navegación si es un enlace
            cheatSidebar.classList.remove('translate-x-full');
        });

        closeCheatSidebar.addEventListener('click', () => {
            cheatSidebar.classList.add('translate-x-full');
        });
    }

    // Lógica para establecer el monto
    const cheatAmountInput = document.getElementById('cheatAmountInput');
    const setCheatAmountButton = document.getElementById('setCheatAmountButton');

    if (setCheatAmountButton && cheatAmountInput) {
        setCheatAmountButton.addEventListener('click', () => {
            const newAmount = parseInt(cheatAmountInput.value, 10);

            if (isNaN(newAmount) || newAmount < 0) {
                alert('Por favor, introduce un monto válido.');
                return;
            }

            const formData = new FormData();
            formData.append('amount', newAmount);

            fetch('?action=setBalance', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Disparamos un evento personalizado para que otros scripts (como blackjack.js) puedan escucharlo
                    document.dispatchEvent(new CustomEvent('balanceUpdated', { detail: { newBalance: newAmount } }));
                    cheatSidebar.classList.add('translate-x-full'); // Opcional: cerrar el sidebar al tener éxito
                } else {
                    alert('Error al establecer el nuevo monto.');
                }
            });
        });
    }
});