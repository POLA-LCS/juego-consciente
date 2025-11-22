/**
 * Este script mejora el comportamiento de los elementos <details> de HTML.
 * En lugar de abrirse y cerrarse de golpe, les añade una animación suave de
 * despliegue y repliegue. También se encarga de que el contenido sea visible
 * en la pantalla cuando se abre.
 */
document.querySelectorAll('details.animated').forEach((detail) => {
    // 1. Buscamos todos los elementos <details> que tengan la clase "animated".
    // 2. Para cada uno de ellos, ejecutaremos la siguiente lógica.

    // ================================================================= //
    // 1. OBTENER ELEMENTOS IMPORTANTES                              //
    // ================================================================= //
    const summary = detail.querySelector('summary');
    const content = detail.querySelector('.details-content');

    // ================================================================= //
    // 2. AGREGAR EL EVENTO DE CLIC                                    //
    // ================================================================= //
    summary.addEventListener('click', (event) => {
        // Cuando el usuario hace clic en el título (<summary>)...

        // Evitamos que el navegador haga su acción por defecto (abrir/cerrar de golpe).
        // Así, podemos controlar la animación nosotros mismos.
        event.preventDefault();

        // Si ya hay una animación en curso, no hacemos nada para evitar errores.
        if (detail.dataset.animating) {
            return;
        }
        // Marcamos el elemento para saber que la animación ha comenzado.
        detail.dataset.animating = 'true';

        // ================================================================= //
        // 3. LÓGICA DE ANIMACIÓN                                          //
        // ================================================================= //

        // Verificamos si el <details> está actualmente abierto.
        if (detail.open) {
            // --- ANIMACIÓN DE CIERRE ---

            // Medimos la altura inicial (cuando está abierto).
            const startHeight = `${detail.offsetHeight}px`;
            // La altura final será solo la del título.
            const endHeight = `${summary.offsetHeight}px`;

            // Creamos la animación usando la Web Animations API.
            const animation = detail.animate({
                height: [startHeight, endHeight] // Animamos la altura desde 'startHeight' a 'endHeight'.
            }, {
                duration: 300,      // La animación durará 300 milisegundos.
                easing: 'ease-out'  // El efecto de desaceleración hace que sea suave al final.
            });

            // Cuando la animación termine...
            animation.onfinish = () => {
                // ...cerramos el elemento <details> oficialmente.
                detail.open = false;
                // Limpiamos la altura que pusimos para que el navegador la controle de nuevo.
                detail.style.height = '';
                // Quitamos la marca de "animando".
                delete detail.dataset.animating;
            };

        } else {
            // --- ANIMACIÓN DE APERTURA ---

            // Preparamos el elemento para la animación.
            detail.style.height = `${detail.offsetHeight}px`;
            // Abrimos el <details> para que el navegador calcule su altura final (con el contenido).
            detail.open = true;

            // La altura inicial es la del <details> cerrado.
            const startHeight = `${detail.offsetHeight}px`;
            // La altura final es la suma del título y el contenido.
            const endHeight = `${summary.offsetHeight + content.offsetHeight}px`;

            // Creamos la animación de apertura.
            const animation = detail.animate({
                height: [startHeight, endHeight]
            }, {
                duration: 350,          // Un poco más lenta para que se lea mejor.
                easing: 'ease-in-out'   // Acelera al inicio y desacelera al final.
            });

            // Cuando la animación termine...
            animation.onfinish = () => {
                // ...limpiamos la altura para que el contenido se ajuste si cambia.
                detail.style.height = '';
                // Quitamos la marca de "animando".
                delete detail.dataset.animating;
            };

            // Hacemos scroll para que el usuario vea el contenido que acaba de abrir.
            setTimeout(() => {
                // Usamos un pequeño retraso para que el scroll comience junto con la animación.
                detail.scrollIntoView({
                    behavior: 'smooth', // La animación de scroll será suave.
                    block: 'center',    // Intentará centrar el elemento en la pantalla.
                });
            }, 175);
        }
    });
});