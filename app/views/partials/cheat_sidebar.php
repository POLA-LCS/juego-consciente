<aside id="cheatSidebar" class="fixed right-0 top-0 h-full w-64 bg-gray-800 p-4 transform translate-x-full transition-transform duration-300 z-50">
    <button id="closeCheatSidebar" class="text-red-500 mb-4">Cerrar</button>
    <h3 class="text-xl font-bold mb-4 text-red-500">Cheat Sidebar</h3>
    <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Pierde si saldo mayor que:</label>
        <input type="number" id="loseThreshold" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" value="5000">
    </div>
    <div class="mb-4">
        <label class="flex items-center">
            <input type="checkbox" id="winnerMode" class="mr-2">
            Modo Ganador
        </label>
    </div>
    <div class="mb-4">
        <label class="flex items-center">
            <input type="checkbox" id="loserMode" class="mr-2">
            Modo Perdedor
        </label>
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium mb-2">Máximas victorias seguidas:</label>
        <input type="number" id="maxWins" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md" value="3">
    </div>
</aside>
