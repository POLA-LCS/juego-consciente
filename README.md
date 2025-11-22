# Juego Consciente: Plataforma Educativa sobre Ludopatía

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

## 4. Instalación y Puesta en Marcha

Para ejecutar este proyecto en un entorno local, sigue estos pasos:

1.  **Clonar el Repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/tu-repositorio.git
    ```

2.  **Configurar el Entorno:**
    - Asegúrate de tener **XAMPP** instalado y los servicios de Apache y MySQL en funcionamiento.
    - Coloca la carpeta del proyecto dentro del directorio `htdocs` de XAMPP.

3.  **Base de Datos:**
    - Accede a **phpMyAdmin** desde el panel de control de XAMPP (generalmente en `http://localhost/phpmyadmin`).
    - Ve a la pestaña **"Importar"**.
    - Selecciona el archivo `env/ludopatia.sql` del proyecto.
    - Ejecuta la importación para crear la base de datos `ludopatia` y todas las tablas necesarias.

4.  **Configuración de Conexión:**
    - Abre el archivo `app/config/database.php`.
    - Verifica que las credenciales (`$host`, `$db_name`, `$username`, `$password`) coincidan con la configuración de tu entorno MySQL. Por defecto, está configurado para un XAMPP estándar.

5.  **Acceder a la Aplicación:**
    - Abre tu navegador y navega a `http://localhost/nombre-de-la-carpeta-del-proyecto/`.

## 5. Tecnologías Utilizadas

- **Backend:** PHP 8+ (Vanilla, sin frameworks) para la lógica del servidor, gestión de sesiones y comunicación con la base de datos.
- **Frontend:** HTML5, CSS3 y JavaScript (ES6+) para la estructura, interactividad y lógica del cliente.
- **Base de Datos:** MySQL para el almacenamiento de datos de usuarios, saldos y configuraciones de trampas.
- **Estilos:** **Tailwind CSS** para un diseño rápido y responsivo, complementado con CSS personalizado para la temática del casino.
- **APIs Nativas del Navegador:** Web Animations API para transiciones suaves y Custom Events para la comunicación desacoplada entre módulos de JavaScript.

## 6. Integrantes del Proyecto

- Pilling, Baltazar Zara
- Pesci, Elias
- Roche, Lautaro
- Torres, Joaquin

## 7. Licencia

Este proyecto se distribuye bajo una licencia privada. Todos los derechos reservados. Consulta el archivo `LICENSE.md` para más detalles.