<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información sobre Ludopatía - Juego Consciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/ludopatia/public/assets/css/main.css">
</head>
<body>
    <?php include ROOT_PATH . 'app/views/partials/header.php'; ?>
    <?php include ROOT_PATH . 'app/views/partials/sidebar.php'; ?>

    <main class="p-6">
        <!-- El botón de menú de usuario ahora está en el header -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">¿Qué es la Ludopatía?</h2>
            <p class="mb-4">La ludopatía, también conocida como adicción al juego, es un trastorno del comportamiento caracterizado por la incapacidad de controlar el impulso de jugar, a pesar de las consecuencias negativas que esto pueda tener en la vida personal, familiar y laboral.</p>
            <p class="mb-4">Esta adicción puede afectar a cualquier persona, independientemente de su edad, género o estatus social. Los juegos de azar pueden ser emocionantes al principio, pero cuando se convierten en una compulsión, pueden llevar a problemas graves como deudas, aislamiento social y problemas de salud mental.</p>
        </div>
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">Signos y Síntomas</h2>
            <ul class="list-disc list-inside mb-4">
                <li>Preocupación constante por el juego</li>
                <li>Necesidad de apostar cantidades cada vez mayores para obtener la misma emoción</li>
                <li>Intentos fallidos de controlar o dejar de jugar</li>
                <li>Irritabilidad o ansiedad cuando se intenta reducir el juego</li>
                <li>Uso del juego como escape de problemas</li>
                <li>Mentir sobre la cantidad de tiempo o dinero gastado en el juego</li>
                <li>Pérdida de oportunidades laborales o educativas por el juego</li>
                <li>Pedir dinero prestado para jugar</li>
            </ul>
        </div>
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">Consecuencias</h2>
            <p class="mb-4">La ludopatía puede tener graves consecuencias en múltiples aspectos de la vida:</p>
            <ul class="list-disc list-inside mb-4">
                <li><strong>Económicas:</strong> Deudas, bancarrota, pérdida de ahorros</li>
                <li><strong>Personales:</strong> Problemas de salud mental como depresión, ansiedad, pensamientos suicidas</li>
                <li><strong>Familiares:</strong> Conflictos, divorcios, abandono de responsabilidades</li>
                <li><strong>Sociales:</strong> Aislamiento, pérdida de amistades</li>
                <li><strong>Laborales:</strong> Pérdida de empleo, bajo rendimiento</li>
            </ul>
        </div>
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">Prevención y Tratamiento</h2>
            <p class="mb-4">La prevención es clave. Establece límites de tiempo y dinero para jugar, juega solo por diversión, no como medio para ganar dinero, y busca ayuda si sientes que el juego está controlando tu vida.</p>
            <p class="mb-4">Si crees que tienes un problema con el juego, busca ayuda profesional. Existen tratamientos como terapia cognitivo-conductual, grupos de apoyo y, en casos graves, medicamentos para controlar los síntomas asociados.</p>
        </div>
        <div class="text-center">
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
