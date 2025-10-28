<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<aside id="bet-sidebar" class="w-64 bg-[var(--color-surface)] p-4 border-r border-[var(--color-border)] flex flex-col justify-between">
    <div>
        <div class="text-center mb-4">
            <span class="text-lg text-[var(--color-text-muted)]">Saldo</span>
            <p id="balance" class="text-3xl font-bold text-[var(--color-text-base)]">1000</p>
        </div>
        <hr class="border-[var(--color-border)] mb-4">
        <div class="text-center mb-4">
            <span class="text-lg text-[var(--color-text-muted)]">Apuesta</span>
            <p id="currentBet" class="text-4xl font-bold text-[var(--color-primary)]">25</p>
        </div>
        <!-- Chips para añadir a la apuesta -->
        <div class="grid grid-cols-2 gap-2">
            <button data-amount="1" class="btn bet-chip py-1 rounded-md">+1</button>
            <button data-amount="5" class="btn bet-chip py-1 rounded-md">+5</button>
            <button data-amount="10" class="btn bet-chip py-1 rounded-md">+10</button>
            <button data-amount="25" class="btn bet-chip py-1 rounded-md">+25</button>
            <button data-amount="100" class="btn bet-chip py-1 rounded-md">+100</button>
            <button data-amount="500" class="btn bet-chip py-1 rounded-md">+500</button>
        </div>
    </div>
    <div class="space-y-3">
        <button id="placeBet" class="btn w-full py-2 px-4 rounded-md font-bold">Apostar</button>
        <button id="resetBet" class="w-full text-[var(--color-text-muted)] hover:text-white">Reset</button>
    </div>
</aside>