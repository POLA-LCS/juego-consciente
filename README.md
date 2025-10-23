# 🎲 Juego Consciente

Proyecto de simulación de juegos de casino construido con PHP en un patrón Modelo-Vista-Controlador (MVC) y Tailwind CSS. El enfoque está en el desarrollo de un sistema de gestión de usuarios (ABM) y demostración de lógica de juego. **Este proyecto no maneja dinero real.**

## ⚙️ Configuración del Entorno

### 1. Requisitos

* Servidor web con soporte para PHP (ej: **XAMPP** o Laragon).
* PHP 7.4+ (o superior).
* Base de datos MySQL/MariaDB.
* **Node.js y npm** (Necesario para compilar Tailwind CSS).

### 2. Instalación de Código y Base de Datos

1.  Clonar o descarga el proyecto en tu directorio de servidor web (ej: `htdocs/ludopatia`).
2.  **Configurar la Base de Datos:**
    * Importar el archivo `setup.sql` (pendiente) para el esquema de la base de datos.
3.  **Configurar la URL Base:**
    * Verificar que la constante `BASE_URL` en `app/config/Config.php` coincida con la ruta de tu servidor (ej: `http://localhost/ludopatia/`).
4.  **Verificar .htaccess:**
    * Asegúrarse de que el archivo `public/.htaccess` tenga la `RewriteBase` correcta.

### 3. Compilación de Tailwind CSS

Para generar los estilos CSS a partir de las clases de Tailwind (`@apply` incluido), debes usar la CLI de Node.js:

1.  **Instalar dependencias de Tailwind:**
    ```bash
    # Asegúrate de estar en el directorio raíz del proyecto (ludopatia/)
    npm install -D tailwindcss postcss autoprefixer
    ```
2.  **Crear el archivo de entrada CSS:**
    Crea el archivo **`public/assets/css/input.css`** y añade las directivas base de Tailwind:
    ```css
    /* Contenido de public/assets/css/input.css: */
    @tailwind base;
    @tailwind components;
    @tailwind utilities;
    ```
3.  **Compilar Tailwind:**
    Ejecuta el siguiente comando. Se recomienda usar la opción `--watch` para desarrollo:

    ```bash
    npx tailwindcss -i ./public/assets/css/input.css -o ./public/assets/css/tailwind.css --watch
    ```
    *El archivo de salida es `tailwind.css`, que es el que se enlaza en `Header.php`.*

## 📂 Estructura del Proyecto

```
ludopatia/
├── app/
│   ├── config/
│   ├── controllers/
│   ├── core/
│   ├── models/
│   └── views/
├── public/
│   ├── assets/
│   └── index.php
└── README.md
```