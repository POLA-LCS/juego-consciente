# 🕵️‍♂️ Guía de Estudio del Proyecto: Juego Consciente

¡Hola! Bienvenido/a a la guía de estudio de "Juego Consciente". Este documento está diseñado para explicarte, de una manera sencilla y clara, cómo está construido este proyecto. No te preocupes si no eres un experto, ¡vamos a desglosar los conceptos clave paso a paso! ❤️

---

## 🎯 1. ¿Qué es "Juego Consciente"?

Antes de sumergirnos en el código, recordemos el propósito del proyecto. "Juego Consciente" no es un casino real. Es una **herramienta educativa** creada para mostrar los riesgos de la adicción al juego (ludopatía).

Simulamos juegos de azar para que los usuarios puedan experimentar de forma segura cómo funcionan y, lo más importante, cómo se puede perder el control.

---

## 🏛️ 2. La Arquitectura del Backend: El Patrón MVC

Para organizar el código del servidor (el "cerebro" de la aplicación), usamos un patrón de diseño muy popular llamado **MVC**.

**MVC** son las siglas de **M**odelo, **V**ista y **C**ontrolador.

Imagina que estás en un restaurante:

*   La **Vista (View)**: Es el **menú y tu mesa**. Es todo lo que tú, como cliente, puedes ver e interactuar. En nuestro proyecto, son los archivos `.php` dentro de `app/views/` que contienen el HTML.

*   El **Modelo (Model)**: Es la **cocina**. Se encarga de toda la "lógica de negocio" y de manejar los datos. Sabe cómo preparar los platos (obtener datos de la base de datos) y gestionar los ingredientes (actualizar, crear o borrar datos). En nuestro proyecto, son los archivos como `User.php` y `CheatSettings.php` en `app/models/`.

*   El **Controlador (Controller)**: Es el **camarero**. Actúa como intermediario. Toma tu pedido (la petición del usuario desde la Vista), se lo comunica a la cocina (el Modelo) y, cuando el plato está listo, te lo sirve (envía los datos a la Vista para que los muestre). En nuestro proyecto, el archivo principal es `UserController.php` en `app/controllers/`.

#### ¿Y cómo empieza todo? Con el Router 📍

Nuestro archivo `index.php` actúa como el **recepcionista del restaurante**. Es el primer punto de contacto. Cuando llegas (haces una petición a la web, como `?page=dashboard`), el recepcionista mira su libro de reservas (`$routes`) y te dirige a la mesa correcta (carga la Vista) o avisa a un camarero (llama a una acción del Controlador).

**En resumen:**

1.  El usuario pide una página (`index.php`).
2.  El **Router** (`index.php`) decide qué hacer.
3.  Si es una acción (como `?action=login`), llama al **Controlador** (`UserController.php`).
4.  El **Controlador** le pide al **Modelo** (`User.php`) que verifique los datos en la base de datos.
5.  El **Controlador** recibe la respuesta y le dice al navegador que vaya a una nueva **Vista** (como `dashboard.php`).

¡Esta separación hace que el código sea mucho más organizado y fácil de mantener!

---

## ✨ 3. La Magia del Frontend: AJAX y los Eventos

El "Frontend" es todo lo que ocurre en el navegador del usuario (HTML, CSS y JavaScript). Queremos que la experiencia sea fluida, sin que la página se recargue a cada rato. Aquí es donde entra en juego la magia de AJAX.

### ¿Qué es AJAX? (Asynchronous JavaScript and XML)

Imagina que estás escribiendo un mensaje de texto. Mientras lo envías, no tienes que dejar de usar tu teléfono, ¿verdad? Puedes seguir haciendo otras cosas. Eso es "asíncrono": hacer algo en segundo plano sin detener todo lo demás.

**AJAX** permite que nuestro JavaScript (en el navegador) hable con nuestro PHP (en el servidor) **en segundo plano, sin recargar la página**.

En nuestro proyecto, usamos la función `fetch()` de JavaScript, que es la forma moderna de hacer AJAX.

#### Puntos Clave de AJAX en "Juego Consciente":

1.  **Apostar en un juego**:
    *   Cuando haces clic en "Apostar" (`bet.js`), JavaScript envía una petición `fetch()` al servidor (`?action=updateBalance`).
    *   El servidor descuenta el dinero de tu saldo en la base de datos y responde con tu nuevo saldo.
    *   JavaScript recibe la respuesta y actualiza el número del saldo en la pantalla. **¡Todo sin recargar la página!**

2.  **Guardar "Cheats"**:
    *   Cuando activas el "Modo Ganador" en el `cheatSidebar.js`, se envía otra petición `fetch()` al servidor (`?action=updateCheatSettings`).
    *   El servidor guarda tu nueva configuración.
    *   La página no se entera de que algo ha cambiado... a menos que se lo digamos. Y para eso, usamos eventos.

### La Comunicación entre Scripts: Eventos Personalizados 📢

Tenemos varios archivos JavaScript: `bet.js`, `cups.js`, `slots.js`, `cheat_sidebar.js`. ¿Cómo hacen para hablar entre ellos sin crear un caos?

Usamos un sistema de **eventos personalizados**. Es como un sistema de megafonía en un aeropuerto.

*   Un script puede "anunciar" por megafonía que algo ha sucedido.
*   Otros scripts pueden estar "escuchando" ese anuncio específico y reaccionar cuando lo oyen.

**Ejemplo del Flujo en el Juego de Slots:**

1.  **Anuncio 1: "¡Apuesta Realizada!"**
    *   El usuario hace clic en "Apostar".
    *   `bet.js`, después de confirmar con el servidor que la apuesta es válida, anuncia: `document.dispatchEvent(new CustomEvent('betPlaced', ...));`

2.  **Escucha y Reacción:**
    *   `slots.js` ha estado escuchando atentamente el anuncio `'betPlaced'`.
    *   Cuando lo oye, dice "¡Genial, me toca!" y empieza la lógica del juego (gira los rodillos).

3.  **Anuncio 2: "¡El Juego ha Terminado!"**
    *   Una vez que los rodillos se detienen y se muestra el resultado, `slots.js` anuncia: `document.dispatchEvent(new CustomEvent('gameEnded'));`

4.  **Escucha y Reacción Final:**
    *   `bet.js` estaba escuchando el anuncio `'gameEnded'`.
    *   Cuando lo oye, reactiva los botones de apuesta para que el usuario pueda jugar de nuevo.

**Otro ejemplo con los Cheats:**

*   `cheat_sidebar.js` anuncia `'cheatSettingsChanged'` cuando cambias una opción.
*   `cups.js` y `slots.js` escuchan este anuncio y actualizan su lógica interna para saber si deben forzar una victoria o una derrota en la siguiente partida.

Este sistema de eventos es increíblemente poderoso porque permite que nuestros scripts colaboren sin estar directamente "acoplados". `slots.js` no necesita saber nada sobre cómo funciona `bet.js`, solo necesita saber que existe un anuncio llamado `'betPlaced'`.

---

## 🎉 Conclusión

¡Y eso es todo! Ahora tienes una visión general de cómo las piezas del proyecto "Juego Consciente" encajan entre sí:

*   **Backend (PHP)**: Organizado con el patrón **MVC** para separar responsabilidades entre datos, presentación y lógica.
*   **Frontend (JavaScript)**: Usa **AJAX (`fetch`)** para una comunicación fluida con el backend y **Eventos Personalizados** para que los diferentes scripts colaboren de forma limpia.

Espero que esta guía te haya sido de gran ayuda. ¡Ahora estás listo/a para explorar el código con una mejor comprensión de su estructura!
