<?php
// Cláusula de guarda: si la constante APP_RUNNING no está definida, significa que se está accediendo directamente al archivo.
if (!defined('APP_RUNNING')) {
    http_response_code(403);
    include_once(__DIR__ . '/../errors/403.php');
    die();
}
?>
<footer class="bg-[var(--color-surface)] text-[var(--color-text-muted)] py-4 mt-8 border-t border-[var(--color-border)]">
    <div class="container mx-auto text-center">
        <p>&copy; 2025 Juego Consciente. Todos los derechos reservados.</p>
        <p class="mt-2">Este sitio es una herramienta educativa para concienciar sobre la ludopatía. No promueve el juego real con dinero.</p>
    </div>
</footer>
