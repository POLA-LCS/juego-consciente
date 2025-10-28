<aside id="betSidebar" class="fixed left-0 top-0 h-full w-64 bg-gray-800 p-4 transform -translate-x-full transition-transform duration-300 z-50">
    <h3 class="text-xl font-bold mb-4 text-red-500">Configurar Apuesta</h3>
    <div class="flex flex-wrap gap-2 mb-4">
        <button id="minus1" class="btn-red text-white py-2 px-4 rounded-md">-1</button>
        <button id="minus10" class="btn-red text-white py-2 px-4 rounded-md">-10</button>
        <button id="minus100" class="btn-red text-white py-2 px-4 rounded-md">-100</button>
        <button id="plus1" class="btn-red text-white py-2 px-4 rounded-md">+1</button>
        <button id="plus10" class="btn-red text-white py-2 px-4 rounded-md">+10</button>
        <button id="plus100" class="btn-red text-white py-2 px-4 rounded-md">+100</button>
        <button id="resetBet" class="btn-red text-white py-2 px-4 rounded-md">Reset</button>
    </div>
    <div class="mb-4">
        <span>Apuesta actual: <span id="currentBet">10</span></span>
    </div>
    <button id="placeBet" class="btn-red text-white py-2 px-4 rounded-md">Apostar</button>
    <button id="closeBetSidebar" class="btn-red text-white py-2 px-4 rounded-md mt-4">Cerrar</button>
</aside>
