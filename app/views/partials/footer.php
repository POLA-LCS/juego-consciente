<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<footer class="bg-[var(--color-surface)] text-[var(--color-text-muted)] py-5 mt-8 border-t border-[var(--color-border)] text-sm">
    <div class="container mx-auto text-center px-4">
        <p>&copy; 2025 Juego Consciente. Todos los derechos reservados.</p>
        <p class="mt-2 font-bold">Este sitio es una herramienta educativa para concienciar sobre la ludopatía. <span class="text-[var(--color-primary)]">No promueve el juego real con dinero.</span></p>
    </div>
</footer>
