<?php



$pageTitle = 'Roulette';
?>
<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php include ROOT_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php include ROOT_PATH . 'app/views/components/header.php'; ?>

    <div class="game-container">
        <!-- Panel de Apuestas de la Ruleta -->
        <aside id="roulette-bet-panel"
            class="w-full lg:w-3/4 bg-[var(--color-surface)] p-4 border-r-2 border-[var(--color-border)] flex flex-col">
            <!-- Info Superior -->
            <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                <div class="bg-[var(--color-background)] p-2 rounded-lg"><span
                        class="text-sm text-[var(--color-text-muted)]">SALDO</span>
                    <p id="balance" class="text-xl font-bold">1000</p>
                </div>
                <div class="bg-[var(--color-background)] p-2 rounded-lg"><span
                        class="text-sm text-[var(--color-text-muted)]">RACHA</span>
                    <p id="winStreak" class="text-xl font-bold">0</p>
                </div>
                <div class="bg-[var(--color-background)] p-2 rounded-lg"><span
                        class="text-sm text-[var(--color-text-muted)]">APUESTA TOTAL</span>
                    <p id="totalBet" class="text-xl font-bold text-[var(--color-primary)]">0</p>
                </div>
            </div>

            <!-- Tapete de Apuestas -->
            <div id="betting-mat" class="flex-1 space-y-2">
                <!-- Números -->
                <div class="grid grid-cols-12 gap-1 text-center text-white font-bold">
                    <div class="col-span-12 bet-spot rounded-t-lg" data-bet-type="number" data-bet-value="0"
                        style="background-color: #0c9d5b;">0</div>
                    <?php
                    $reds = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
                    for ($i = 1; $i <= 36; $i++):
                        $color = in_array($i, $reds) ? 'var(--color-primary)' : '#1f1f1f';
                    ?>
                        <div class="bet-spot h-16 flex items-center justify-center" data-bet-type="number"
                            data-bet-value="<?php echo $i; ?>" style="background-color: <?php echo $color; ?>;">
                            <?php echo $i; ?>
                        </div>
                    <?php endfor; ?>
                </div>
                <!-- Docenas -->
                <div class="grid grid-cols-3 gap-1 text-center text-white font-bold">
                    <div class="bet-spot h-12 flex items-center justify-center bg-gray-700" data-bet-type="dozen"
                        data-bet-value="1">1ra Docena</div>
                    <div class="bet-spot h-12 flex items-center justify-center bg-gray-700" data-bet-type="dozen"
                        data-bet-value="2">2da Docena</div>
                    <div class="bet-spot h-12 flex items-center justify-center bg-gray-700" data-bet-type="dozen"
                        data-bet-value="3">3ra Docena</div>
                </div>
                <!-- Colores -->
                <div class="grid grid-cols-2 gap-1 text-center text-white font-bold">
                    <div class="bet-spot h-12 flex items-center justify-center" data-bet-type="color"
                        data-bet-value="red" style="background-color: var(--color-primary);">ROJO</div>
                    <div class="bet-spot h-12 flex items-center justify-center" data-bet-type="color"
                        data-bet-value="black" style="background-color: #1f1f1f;">NEGRO</div>
                </div>
            </div>

            <!-- Controles de Apuesta -->
            <div class="mt-4">
                <div class="flex justify-center items-center gap-2 mb-4">
                    <button id="undoBet" class="btn-chip text-xl px-4" title="Deshacer">&larr;</button>
                    <button class="chip-selector btn-chip" data-chip-value="10">10</button>
                    <button class="chip-selector btn-chip" data-chip-value="25">25</button>
                    <button class="chip-selector btn-chip active-chip" data-chip-value="50">50</button>
                    <button class="chip-selector btn-chip" data-chip-value="100">100</button>
                    <button class="chip-selector btn-chip" data-chip-value="500">500</button>
                    <button id="redoBet" class="btn-chip text-xl px-4" title="Rehacer">&rarr;</button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button id="clearBets" class="btn py-2">Limpiar</button>
                    <button id="spinButton" class="btn-secondary py-2">Girar</button>
                </div>
            </div>
        </aside>

        <!-- Display del Resultado -->
        <main class="p-6 flex-1 flex flex-col items-center justify-center text-center bg-black">
            <div id="result-display"
                class="w-48 h-48 rounded-full flex items-center justify-center bg-gray-800 transition-colors duration-500">
                <span id="result-number" class="text-6xl font-bold text-white">--</span>
            </div>
            <div id="message-container" class="text-2xl font-bold h-10 mt-8">&nbsp;</div>
        </main>

        <!-- User Sidebar (Derecha, Oculto) -->
        <!-- Componente UserSidebar -->
        <?php include ROOT_PATH . 'app/views/components/userSidebar.php'; ?>
        <!-- Componente CheatSidebar -->
        <?php include ROOT_PATH . 'app/views/components/cheatSidebar.php'; ?>
    </div>

    <!-- Componente Footer -->
    <?php include ROOT_PATH . 'app/views/components/footer.php'; ?>

    <script src="public/assets/js/roulette_bet.js"></script>
    <script src="public/assets/js/roulette_game.js"></script>
</body>

</html>