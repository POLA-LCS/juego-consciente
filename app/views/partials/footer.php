<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<footer class="bg-[var(--color-surface)] text-[var(--color-text-muted)] py-4 mt-8 border-t border-[var(--color-border)]">
    <div class="container mx-auto text-center">
        <p>&copy; 2025 Juego Consciente. Todos los derechos reservados.</p>
        <p class="mt-2">Este sitio es una herramienta educativa para concienciar sobre la ludopatía. No promueve el juego real con dinero.</p>
    </div>
</footer>
