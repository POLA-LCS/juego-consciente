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
            <p id="currentBet" class="text-4xl font-bold text-[var(--color-primary)]">10</p>
        </div>
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <button id="minus1" class="btn w-1/2 py-1 rounded-md mr-1">-1</button>
                <button id="plus1" class="btn w-1/2 py-1 rounded-md ml-1">+1</button>
            </div>
            <div class="flex items-center justify-between">
                <button id="minus10" class="btn w-1/2 py-1 rounded-md mr-1">-10</button>
                <button id="plus10" class="btn w-1/2 py-1 rounded-md ml-1">+10</button>
            </div>
            <div class="flex items-center justify-between">
                <button id="minus100" class="btn w-1/2 py-1 rounded-md mr-1">-100</button>
                <button id="plus100" class="btn w-1/2 py-1 rounded-md ml-1">+100</button>
            </div>
        </div>
    </div>
    <div class="space-y-3">
        <button id="placeBet" class="btn w-full py-2 px-4 rounded-md font-bold">Apostar</button>
        <button id="resetBet" class="w-full text-[var(--color-text-muted)] hover:text-white">Reset</button>
    </div>
</aside>