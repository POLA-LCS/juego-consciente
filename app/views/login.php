<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body class="flex flex-col min-h-screen">
    <?php include ROOT_PATH . 'app/views/partials/header_auth.php'; ?>
    <main class="flex items-center justify-center flex-1">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-red-500">Login</h2>
            <form action="?action=login" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium mb-2">Usuario</label>
                    <input type="text" id="username" name="username" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>
                <button type="submit" class="w-full btn-red text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-200">Iniciar Sesión</button>
            </form>
            <p class="mt-4 text-center">¿No tienes cuenta? <a href="?page=register" class="text-red-500 hover:underline">Regístrate</a></p>
        </div>
    </main>
    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>
</body>
</html>
    </div>
</body>
</html>
