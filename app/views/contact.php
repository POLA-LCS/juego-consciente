<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body>
    <?php include ROOT_PATH . 'app/views/partials/header.php'; ?>
    <?php include ROOT_PATH . 'app/views/partials/sidebar.php'; ?>

    <main class="p-6">
        <div class="flex justify-end items-center mb-6">
            <h1 class="text-3xl font-bold text-[var(--color-primary)]">Contacto</h1>
        </div>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-center text-[var(--color-primary)]">Contacto</h1>
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">¿Necesitas Ayuda?</h2>
            <p class="mb-4">Si tú o alguien que conoces está luchando con la ludopatía, no estás solo. Hay recursos disponibles para ayudarte.</p>
            <div class="mb-4">
                <h3 class="text-xl font-bold mb-2 text-[var(--color-primary)]">Líneas de Ayuda</h3>
                <ul class="list-disc list-inside">
                    <li>Argentina: Línea Nacional de Prevención del Suicidio - 135</li>
                    <li>España: Teléfono de la Esperanza - 717 003 717</li>
                    <li>México: Línea de la Vida - 800 911 2000</li>
                    <li>Colombia: Línea 106</li>
                    <li>Chile: Fono Ayuda - 600 360 7777</li>
                </ul>
            </div>
            <div class="mb-4">
                <h3 class="text-xl font-bold mb-2 text-[var(--color-primary)]">Organizaciones Internacionales</h3>
                <ul class="list-disc list-inside">
                    <li>Gamblers Anonymous: <a href="https://www.gamblersanonymous.org/" class="text-[var(--color-primary)] hover:underline">www.gamblersanonymous.org</a></li>
                    <li>World Health Organization: Información sobre adicciones</li>
                </ul>
            </div>
        </div>
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">Contáctanos</h2>
            <form>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Nombre</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium mb-2 text-[var(--color-text-muted)]">Mensaje</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 bg-[var(--color-background)] border border-[var(--color-border)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]" required></textarea>
                </div>
                <button type="submit" class="w-full btn py-2 px-4 rounded-md font-bold">Enviar Mensaje</button>
            </form>
        </div>
        <div class="text-center mt-6">
            <a href="?page=dashboard" class="btn py-2 px-6 rounded-md font-bold">Volver al Dashboard</a>
        </div>
    </main>

    <?php include ROOT_PATH . 'app/views/partials/footer.php'; ?>

    <script>
        const userSidebar = document.getElementById('userSidebar');
        const openUserSidebar = document.getElementById('openUserSidebar'); // Botón en el header
        const closeUserSidebar = document.getElementById('closeUserSidebar'); // Botón 'x' en el sidebar

        openUserSidebar.addEventListener('click', () => {
            userSidebar.classList.remove('translate-x-full');
        });

        closeUserSidebar.addEventListener('click', () => {
            userSidebar.classList.add('translate-x-full');
        });
    </script>
</body>
</html>
