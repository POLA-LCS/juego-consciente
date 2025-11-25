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
                        <tbody>
                            <?php if (empty($gameHistory)): ?>
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-[var(--color-text-muted)]">No hay partidas en tu historial todavía.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($gameHistory as $record): ?>
                                    <tr class="border-t border-[var(--color-border)] hover:bg-[var(--color-background)] transition-colors">
                                        <td class="p-4 uppercase font-semibold text-center"><?php echo strtoupper(htmlspecialchars($record['game'])); ?></td>
                                        <td class="p-4 text-center font-bold <?php echo $record['result'] > 0 ? 'text-green-400' : 'text-red-400'; ?>">
                                            <?php
                                            $string_number = ((string)$record['result']);
                                            $string_number = ($record['result'] < 0) ? '- ' . substr($string_number, 1) : '+ ' . $string_number;
                                            echo htmlspecialchars($string_number);
                                            ?>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="block font-semibold"><?php echo date('d/m/Y', strtotime($record['played_at'])); ?></span>
                                            <span class="block text-xs text-[var(--color-text-muted)]"><?php echo date('H:i:s', strtotime($record['played_at'])); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <!-- Componente Footer -->
    <?php require SRC_PATH . 'app/views/components/footer.php'; ?>
</body>

</html>