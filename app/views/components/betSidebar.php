<aside id="bet-sidebar"
    class="w-56 bg-[var(--color-surface)] p-3 border-r-2 border-[var(--color-primary)] flex flex-col justify-between">
    <div>
        <div class="text-center mb-2">
            <span class="text-lg text-[var(--color-text-muted)]">Saldo</span>
            <p id="balance" class="text-3xl font-bold text-[var(--color-text-base)]">1000</p>
        </div>
        <hr class="border-[var(--color-border)] mb-2">
        <div class="text-center mb-2">
            <span class="text-lg text-[var(--color-text-muted)]">Racha Victorias</span>
            <p id="winStreak" class="text-3xl font-bold text-[var(--color-text-base)]">0</p>
        </div>
        <hr class="border-[var(--color-border)] mb-2">
        <div class="text-center mb-3">
            <span class="text-lg text-[var(--color-text-muted)]">Apuesta</span>
            <p id="currentBet" class="text-4xl font-bold text-[var(--color-primary)]">25</p>
        </div>

    </div>
    <!-- Chips para añadir a la apuesta -->
    <div class="grid grid-cols-1 gap-2">
        <div class="grid grid-cols-2 gap-2">
            <button data-amount="1" class="btn bet-chip py-1 rounded-md">+1</button>
            <button data-amount="5" class="btn bet-chip py-1 rounded-md">+5</button>
            <button data-amount="10" class="btn bet-chip py-1 rounded-md">+10</button>
            <button data-amount="25" class="btn bet-chip py-1 rounded-md">+25</button>
            <button data-amount="100" class="btn bet-chip py-1 rounded-md">+100</button>
            <button data-amount="250" class="btn bet-chip py-1 rounded-md">+250</button>
        </div>
        <div class="space-y-2">
            <button id="placeBet" class="btn w-full py-2 px-4 rounded-md font-bold">Apostar</button>
            <button id="maxBetButton" class="btn-secondary w-full py-2 px-2 rounded-md font-bold transition-all duration-200">APUESTA
                MAXIMA</button>
            <button id="resetBet" class="w-full text-[var(--color-text-muted)] hover:text-white">Reset</button>
        </div>
    </div>
</aside>