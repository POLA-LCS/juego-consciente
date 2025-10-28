<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<aside id="cheatSidebar" class="fixed right-0 top-0 h-full w-64 bg-[var(--color-background)] border-l border-[var(--color-border)] p-4 transform translate-x-full transition-transform duration-300 z-50">
    <button id="closeCheatSidebar" class="absolute top-2 right-4 text-[var(--color-text-muted)] hover:text-[var(--color-primary)] transition-colors text-4xl font-light leading-none">
        &times;
    </button>
    <h3 class="text-xl font-bold mb-4 text-[var(--color-primary)] text-center">Cheats</h3>
    <div class="space-y-4">
        <div>
            <label for="cheatAmountInput" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Establecer monto</label>
            <div class="flex gap-2">
                <input type="number" id="cheatAmountInput" name="cheatAmount" class="w-full px-3 py-2 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" placeholder="Ej: 5000">
                <button id="setCheatAmountButton" class="btn px-4 rounded-md">OK</button>
            </div>
        </div>
        <!-- Aquí se pueden añadir más opciones de trampas en el futuro -->
    </div>
</aside>