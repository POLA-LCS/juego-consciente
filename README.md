# Juego Consciente: Plataforma Educativa
![Logo Juego Consciente](src/public/assets/images/logo.png "Logo Juego Consciente")

## 1. Objetivo del Proyecto

**Juego Consciente** es una aplicación web interactiva diseñada como material de apoyo para charlas y programas de concienciación sobre la **ludopatía** (adicción al juego).

El propósito fundamental de esta plataforma **no es promover el juego de azar**, sino **educar y prevenir**. A través de la simulación de un entorno de casino, los usuarios pueden experimentar de primera mano cómo funcionan estos juegos y, lo más importante, cómo los mecanismos detrás de ellos están diseñados para mantener al jugador enganchado.

La herramienta clave es el **"Panel de Trampas" (Cheat Sidebar)**, que permite a los usuarios o al presentador manipular las probabilidades y los resultados de los juegos. Esto sirve como una poderosa demostración práctica de que "la casa siempre gana" y ayuda a desmitificar la falsa percepción de control que muchos jugadores creen tener.

## 2. Alcance del Proyecto

### ¿Qué incluye?
- **Simulación de Juegos de Casino:** Implementación de juegos populares para demostrar sus mecánicas.
  - **Trileros (Cups Game):** Un juego de adivinanza simple para ilustrar probabilidades básicas.
  - **Ruleta (Roulette):** Con un tablero de apuestas completo que incluye apuestas a números, colores y docenas.
  - **Tragamonedas (Slots):** Una simulación clásica de una máquina tragaperras.
- **Sistema de Autenticación:** Registro e inicio de sesión para que cada usuario tenga una experiencia individual con su propio saldo y estadísticas.
- **Gestión de Saldo Virtual:** Cada usuario dispone de un saldo ficticio que se actualiza en tiempo real, permitiendo visualizar las ganancias y, más frecuentemente, las pérdidas.
- **Panel de Trampas (Cheat Sidebar):** Una herramienta educativa que permite:
  - **Establecer un Saldo Específico:** Simular una "recarga" de fondos para mostrar cómo se perpetúa el ciclo de juego.
  - **Forzar Resultados:** Activar un "Modo Ganador" o "Modo Perdedor" para demostrar la falta de aleatoriedad real en entornos controlados.
  - **Establecer Límites:** Configurar una racha máxima de victorias o un saldo máximo para ilustrar cómo los sistemas pueden estar diseñados para detener las ganancias de un jugador.
- **Contenido Educativo:** Secciones dedicadas a informar sobre qué es la ludopatía, sus síntomas y dónde buscar ayuda profesional.

### ¿Qué NO incluye?
- **Transacciones con Dinero Real:** La plataforma opera exclusivamente con un saldo virtual. No hay, ni habrá, ninguna integración con dinero real.
- **Un Casino Funcional:** El proyecto es una simulación con fines educativos, no una plataforma de juego operativo.
- **Garantía de Aleatoriedad Real:** Los resultados pueden ser manipulados intencionadamente a través del panel de trampas para cumplir los objetivos pedagógicos.

## 3. Requisitos Técnicos

Para ejecutar este proyecto en un entorno local, se necesita el siguiente stack de software:

- **Entorno de Servidor Local:** Se recomienda **XAMPP**, aunque cualquier solución que provea los siguientes componentes es válida (WAMP, MAMP, etc.).
  - **Servidor Web:** Apache 2.4 o superior.
  - **Backend:** PHP 8.0 o superior.
  - **Base de Datos:** MySQL o MariaDB.
- **Navegador Web:** Una versión moderna de Chrome, Firefox, Safari o Edge.

## 4. Modelo de Uso y Contratación

**Juego Consciente** no es un software de código abierto. Se ofrece como un servicio (SaaS) para instituciones, educadores y profesionales que deseen utilizarlo como herramienta de apoyo en charlas y programas de prevención de la ludopatía.

El código fuente de este repositorio se hace público con fines de **transparencia y evaluación educativa**. Permite a potenciales clientes y a la comunidad académica revisar nuestras prácticas de desarrollo y la lógica interna de la simulación.

Si representas a una institución educativa, centro de salud o eres un profesional interesado en utilizar "Juego Consciente" en tus presentaciones, por favor contáctanos para discutir las opciones de licenciamiento y firmar un contrato formal de uso.

**Contacto:** `juego.consciente.lcs@gmail.com`

El uso, copia, modificación, distribución o implementación de este software sin un contrato de licencia explícito está estrictamente prohibido y será objeto de acciones legales, como se detalla en nuestra licencia.

## 5. Tecnologías Utilizadas

- **Backend:** PHP 8+ (Vanilla, sin frameworks) para la lógica del servidor, gestión de sesiones y comunicación con la base de datos.
- **Frontend:** HTML5, CSS3 y JavaScript (ES6+) para la estructura, interactividad y lógica del cliente.
- **Base de Datos:** MySQL para el almacenamiento de datos de usuarios, saldos y configuraciones de trampas.
- **Estilos:** **Tailwind CSS** para un diseño rápido y responsivo, complementado con CSS personalizado para la temática del casino.
- **APIs Nativas del Navegador:** Web Animations API para transiciones suaves y Custom Events para la comunicación desacoplada entre módulos de JavaScript.

## 6. Integrantes del Proyecto

- Pesci, Elias
- Pilling, Baltazar Zara
- Roche, Lautaro
- Torres, Joaquin

## 7. Licencia

Este proyecto se distribuye bajo una licencia de **Código Fuente Disponible y Propietario**. El uso no autorizado está estrictamente prohibido. Consulta el archivo `LICENSE.md` para más detalles.

## 8. Setup
Para evaluar localmente el proyecto ve a [SETUP](SETUP.md).