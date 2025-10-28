<aside id="userSidebar" class="fixed right-0 top-0 h-full w-64 bg-gray-800 p-4 transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex justify-end mb-4">
        <button id="closeUserSidebar" class="text-gray-400 hover:text-white text-4xl font-light leading-none">&times;</button>
    </div>
    <div class="text-center mb-6">
        <img src="/ludopatia/public/assets/images/logo.png" alt="Profile" class="h-16 w-16 rounded-full mx-auto mb-2">
        <p class="text-white font-bold"><?php echo $_SESSION['username']; ?></p>
        <p class="text-gray-400">ID: <?php echo $_SESSION['user_id']; ?></p>
    </div>
    <nav>
        <ul class="space-y-2">
            <li><a href="?page=dashboard" class="block py-2 px-4 text-white hover:bg-gray-700 rounded">Dashboard</a></li>
            <li><a href="?page=info" class="block py-2 px-4 text-white hover:bg-gray-700 rounded">Ludopatía</a></li>
            <li><a href="?page=contact" class="block py-2 px-4 text-white hover:bg-gray-700 rounded">Contacto</a></li>
            <li id="cheatOption" class="hidden"><a href="#" id="toggleCheat" class="block py-2 px-4 text-white hover:bg-gray-700 rounded">Cheat</a></li>
            <li><a href="?action=logout" class="block py-2 px-4 text-red-500 hover:bg-gray-700 rounded">Logout</a></li>
        </ul>
    </nav>
</aside>
