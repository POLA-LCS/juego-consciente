<?php

/**
 * Juego Consciente - Componente Interfaz de Apuesta
 * Ubicación: ludopatia/app/views/components/BetSidebar.php
 * Se espera que este componente sea incluido en las vistas de juego.
 */

// $userBalance se pasa desde el controlador de juego
$currentBalance = $data['balance'] ?? 0.00;
?>

<div class="w-full md:w-64 bg-gray-800 p-4 rounded-xl shadow-2xl border border-red-900/50 flex-shrink-0">
    <h3 class="text-2xl font-['Montserrat'] text-red-400 mb-4 text-center">Tu Apuesta</h3>

    <div class="bg-gray-900 p-3 rounded-lg mb-4 text-center">
        <p class="text-sm text-gray-400 font-['Roboto']">Saldo Actual</p>
        <p class="text-3xl font-bold text-red-500 font-['Grand Casino'] mt-1">
            $<span id="current-balance"><?php echo number_format($currentBalance, 2); ?></span>
        </p>
    </div>

    <div class="bg-red-900/30 p-3 rounded-lg mb-6 text-center">
        <p class="text-sm text-gray-300 font-['Roboto']">Monto a Apostar</p>
        <p class="text-4xl font-extrabold text-white font-['Montserrat'] mt-1">
            $<span id="bet-amount">0</span>
        </p>
    </div>

    <div class="grid grid-cols-3 gap-2 mb-4">
        <button data-value="-100" class="bet-control-btn bg-red-700 hover:bg-red-600">-100</button>
        <button data-value="-10" class="bet-control-btn bg-red-700 hover:bg-red-600">-10</button>
        <button data-value="-1" class="bet-control-btn bg-red-700 hover:bg-red-600">-1</button>

        <button data-value="1" class="bet-control-btn bg-red-500 hover:bg-red-400">+1</button>
        <button data-value="10" class="bet-control-btn bg-red-500 hover:bg-red-400">+10</button>
        <button data-value="100" class="bet-control-btn bg-red-500 hover:bg-red-400">+100</button>
    </div>

    <div class="space-y-2">
        <button id="reset-bet"
            class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-['Montserrat'] rounded-md transition duration-200">
            Reestablecer (0)
        </button>
        <button id="place-bet"
            class="w-full py-3 bg-green-600 hover:bg-green-500 text-white font-['Montserrat'] font-bold rounded-md transition duration-200 shadow-lg shadow-green-900/50">
            Volver a Apostar (Jugar)
        </button>
    </div>

    <style>
    .bet-control-btn {
        @apply p-2 text-white font-bold rounded-md transition duration-150 shadow-md font-['Montserrat'];
    }
    </style>
</div>