<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: index.php?page=error403');
    exit();
}
?>
<aside id="cheatSidebar" class="fixed right-0 top-0 h-full w-64 bg-[var(--color-background)] border-l-2 border-[var(--color-primary)] p-4 transform translate-x-full transition-transform duration-300 z-50">
    <button id="closeCheatSidebar" class="absolute top-2 right-4 text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors text-4xl font-light leading-none">
        &times;
    </button>
    <h3 class="text-xl font-bold mb-4 text-[var(--color-primary)] text-center">Cheats</h3>
    <div class="space-y-4">
        <div class="space-y-2">
            <label for="cheatAmountInput" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Establecer monto</label>
            <div class="flex gap-2">
                <input type="number" id="cheatAmountInput" name="cheatAmount" class="w-full px-3 py-2 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" placeholder="Ej: 5000">
                <button id="setCheatAmountButton" class="btn px-4 rounded-md">OK</button>
            </div>
        </div>

        <hr class="border-[var(--color-border)]">

        <div class="flex items-center justify-between">
            <label for="winnerMode" class="text-sm font-medium text-[var(--color-text-muted)]">Modo Ganador</label>
            <label class="switch"><input type="checkbox" id="winnerMode"><span class="slider round"></span></label>
        </div>

        <div class="flex items-center justify-between">
            <label for="loserMode" class="text-sm font-medium text-[var(--color-text-muted)]">Modo Perdedor</label>
            <label class="switch"><input type="checkbox" id="loserMode"><span class="slider round"></span></label>
        </div>

        <hr class="border-[var(--color-border)]">

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="maxStreakToggle" class="text-sm font-medium text-[var(--color-text-muted)]">Máxima Racha</label>
                <label class="switch"><input type="checkbox" id="maxStreakToggle"><span class="slider round"></span></label>
            </div>
            <input type="number" id="maxStreakInput" name="maxStreak" class="w-full px-3 py-2 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" placeholder="Nº de victorias" disabled>
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="maxBalanceToggle" class="text-sm font-medium text-[var(--color-text-muted)]">Máximo Saldo</label>
                <label class="switch"><input type="checkbox" id="maxBalanceToggle"><span class="slider round"></span></label>
            </div>
            <input type="number" id="maxBalanceInput" name="maxBalance" class="w-full px-3 py-2 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" placeholder="Monto" disabled>
        </div>
    </div>
</aside>