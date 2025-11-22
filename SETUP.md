# Configuración del entorno loca.

El siguiente es un guía para configurar un entorno de evaluación local. Recuerda que el uso de este software está restringido por la licencia.

1.  **Clonar el Repositorio:**
    ```bash
    git clone https://github.com/POLA-LCS/juego-consciente.git
    ```
    Coloca la carpeta del proyecto dentro del directorio `htdocs` de tu servidor local (ej. XAMPP).

2.  **Configurar la Base de Datos:**
    - Abre una herramienta de gestión de MySQL como **phpMyAdmin**.
    - **Paso 1: Crear la Base de Datos.** Importa y ejecuta el script: `database/setup/00_create_database.sql`.
    - **Paso 2: Ejecutar las Migraciones.** Importa y ejecuta los scripts de la carpeta `database/migrations/` en orden numérico para crear las tablas.

3.  **Configuración de Conexión:**
    - Verifica que las credenciales en `config/database.php` coincidan con tu configuración de MySQL.