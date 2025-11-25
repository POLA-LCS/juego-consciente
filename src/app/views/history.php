<?php
$page_title = 'Historial de Partidas';

// Incluir el controlador y el modelo para obtener los datos del historial
require_once SRC_PATH . 'app/models/GameHistory.php';
$db = (new Database())->getConnection();
$historyModel = new GameHistory($db);
$gameHistory = $historyModel->getHistoryByUserId($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<!-- Componente head -->
<?php require SRC_PATH . 'app/views/components/head.php';
?>

<body class="flex flex-col min-h-screen">
    <!-- Componente Header -->
    <?php require SRC_PATH . 'app/views/components/header.php'; ?>

    <div class="flex flex-1">
        <?php require SRC_PATH . 'app/views/components/userSidebar.php'; ?>
        <main class="p-6 flex-1 sm:ml-64">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-4xl font-bold mb-8 text-center text-[var(--color-primary)]">Historial de Partidas</h1>

                <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-lg shadow-lg overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-[var(--color-background)]">
                            <tr>
                                <th class="p-4 text-lg font-bold text-[var(--color-primary)] text-center">Juego</th>
                                <th class="p-4 text-lg font-bold text-[var(--color-primary)] text-center">Resultado</th>
                                <th class="p-4 text-lg font-bold text-[var(--color-primary)] text-center">Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="history-body">
                            <!-- Las filas se generarán con JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Controles de Paginación -->
                <div id="pagination-controls" class="flex justify-center items-center space-x-4 mt-6">
                    <button id="prev-page" class="btn px-4 py-2 bg-[var(--color-primary)] text-white rounded-lg disabled:bg-gray-500 disabled:cursor-not-allowed">Anterior</button>
                    <span id="page-info" class="w-full text-center font-semibold"></span>
                    <button id="next-page" class="btn px-4 py-2 bg-[var(--color-primary)] text-white rounded-lg disabled:bg-gray-500 disabled:cursor-not-allowed">Siguiente</button>
                </div>


            </div>
        </main>
    </div>
    <!-- Componente Footer -->
    <?php require SRC_PATH . 'app/views/components/footer.php'; ?>

    <!-- Pasamos los datos de PHP a una variable de JavaScript -->
    <script>
        const gameHistoryData = <?php echo json_encode($gameHistory); ?>;
    </script>
    <!-- Incluimos el script externo que contiene la lógica -->
    <script src="assets/js/history_pages.js"></script>
</body>

</html>