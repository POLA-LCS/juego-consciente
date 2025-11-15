document.querySelectorAll('details.animated').forEach((detail) => {
    const summary = detail.querySelector('summary');
    const content = detail.querySelector('.details-content');

    summary.addEventListener('click', (event) => {
        // Prevenir el comportamiento por defecto para controlarlo nosotros
        event.preventDefault();

        // Si ya se está animando, no hacer nada
        if (detail.dataset.animating) {
            return;
        }
        detail.dataset.animating = 'true';

        if (detail.open) {
            // === Animación de Cierre ===
            const startHeight = `${detail.offsetHeight}px`;
            const endHeight = `${summary.offsetHeight}px`;

            const animation = detail.animate({
                height: [startHeight, endHeight]
            }, {
                duration: 300,
                easing: 'ease-out'
            });

            // Cuando la animación termina, cerramos el <details>
            animation.onfinish = () => {
                detail.open = false;
                detail.style.height = ''; // Limpiar estilos
                delete detail.dataset.animating;
            };

        } else {
            // === Animación de Apertura ===
            detail.style.height = `${detail.offsetHeight}px`;
            detail.open = true; // Abrir para medir la altura final

            const startHeight = `${detail.offsetHeight}px`;
            const endHeight = `${summary.offsetHeight + content.offsetHeight}px`;

            const animation = detail.animate({
                height: [startHeight, endHeight]
            }, {
                duration: 350, // Aumentamos la duración para una animación más lenta
                easing: 'ease-in-out'
            });

            // Cuando la animación termina, limpiamos los estilos
            animation.onfinish = () => {
                detail.style.height = ''; // Dejar que el navegador controle la altura
                delete detail.dataset.animating;
            };

            // Scroll into view after a short delay to let the animation begin.
            // This ensures the user sees the content they've just revealed.
            setTimeout(() => {
                detail.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            }, 175); // Reducimos el delay para que el scroll empiece antes
        }
    });
});