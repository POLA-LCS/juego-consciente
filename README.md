# Juego Consciente

## Resumen del Proyecto

**Juego Consciente** es una aplicación web desarrollada en PHP vanilla, diseñada como una herramienta educativa para concienciar sobre los peligros de la ludopatía (adicción al juego). A través de la simulación de un casino online, el proyecto busca educar a los usuarios sobre los riesgos asociados al juego de azar, en lugar de promoverlo.

El objetivo principal no es ser un casino funcional, sino una plataforma interactiva que demuestra cómo funcionan los juegos de azar y cómo se puede perder el control. Incluye funcionalidades como un "Cheat Sidebar" que permite manipular los resultados de los juegos, sirviendo como una poderosa herramienta de demostración sobre la naturaleza de la adicción y las probabilidades.

---

## TODO
- Cambiar que la ruta relativa no es realmente relativa.
- Separar las dependencias de la apuesta y de cups game por algo mas sofisticado (bet.js, cups.js).

- - -

## Características Principales

- **Sistema de Autenticación:** Registro, inicio de sesión y gestión de sesiones de usuario.
- **Dashboard de Juegos:** Un lobby central para acceder a los diferentes juegos simulados.
- **Juegos Implementados:**
    - **Cups Game:** Juego de los vasos completamente funcional con animaciones.
    - **Blackjack, Roulette, Slots:** En estado "Próximamente".
- **Gestión de Saldo Virtual:** Cada usuario cuenta con un saldo virtual que se actualiza en tiempo real.
- **Contenido Educativo:** Páginas dedicadas a informar sobre qué es la ludopatía, sus síntomas y dónde buscar ayuda.
- **Cheat Sidebar:** Una herramienta de "trampas" que permite al usuario:
    - Establecer un saldo específico.
    - Activar un "Modo Ganador" o "Modo Perdedor" para forzar los resultados.
    - Establecer límites de racha de victorias o de saldo máximo para demostrar cómo se pueden manipular los juegos.

---

## Tecnologías Utilizadas

- **Backend:** PHP 8+ (sin frameworks)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Base de Datos:** MySQL
- **Estilos:** Tailwind CSS y CSS personalizado para la temática.
- **Entorno de Desarrollo:** XAMPP

---

## Instalación y Puesta en Marcha

Para ejecutar este proyecto en un entorno local, sigue estos pasos:

1.  **Clonar el Repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    ```

2.  **Configurar el Entorno:**
    - Asegúrate de tener un entorno de servidor local como **XAMPP** o similar instalado y en funcionamiento (con Apache y MySQL).
    - Coloca la carpeta del proyecto dentro del directorio `htdocs` de XAMPP.

3.  **Base de Datos:**
    - Abre **phpMyAdmin**.
    - Ve a la pestaña **"Importar"**.
    - Selecciona el archivo `env/ludopatia.sql` del proyecto.
    - Haz clic en "Importar" para crear la base de datos `ludopatia` y sus tablas.

4.  **Configuración de Conexión:**
    - Abre el archivo `config/database.php`.
    - Verifica que las credenciales (`$host`, `$db_name`, `$username`, `$password`) coincidan con la configuración de tu entorno MySQL. Por defecto, está configurado para un XAMPP estándar.

5.  **Acceder a la Aplicación:**
    - Abre tu navegador y ve a `http://localhost`.

---

## Integrantes del Proyecto

El proyecto fue desarrollado por:

- Pilling, Baltazar Zara
- Pesci, Elias
- Roche, Lautaro
- Torres, Joaquin

---

## Licencia

Este proyecto se distribuye bajo una licencia privada. Todos los derechos reservados. Consulta el archivo `LICENSE` para más detalles.