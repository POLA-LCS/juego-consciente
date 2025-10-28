<?php
// Si ROOT_PATH no está definido, significa que se está accediendo directamente. Redirigimos al router.
if (!defined('ROOT_PATH')) {
    header('Location: /ludopatia/index.php?page=error403');
    exit();
}
?>
<?php
// Define el mensaje por defecto si no se ha pasado uno específico
$default_footer_message = "Este sitio es una herramienta educativa para concienciar sobre la ludopatía. <span class=\"text-[var(--color-primary)]\">No promueve el juego real con dinero.</span>";
$current_footer_message = isset($footer_message) ? "<span class=\"text-[var(--color-primary)]\">" . $footer_message . "</span>" : $default_footer_message;
?>
<footer class="bg-[var(--color-surface)] text-[var(--color-text-muted)] py-5 border-t border-[var(--color-border)] text-sm">
    <div class="container mx-auto text-center px-4">
        <p>&copy; 2025 Juego Consciente. Todos los derechos reservados.</p>
        <p class="mt-2 font-bold"><?php echo $current_footer_message; ?></p>
    </div>
</footer>
