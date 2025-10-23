/** @type {import('tailwindcss').Config} */
module.exports = {
    // Archivos donde Tailwind buscará clases para purgar/compilar
    content: [
        "./app/views/**/*.php",
        "./public/assets/js/*.js",
    ],

    // Tema oscuro activado
    darkMode: 'class',

    theme: {
        extend: {
            // 1. Paleta de Colores Personalizada
            colors: {
                // Tema principal oscuro
                'gray': {
                    900: '#121212', // Fondo muy oscuro
                    800: '#1f1f1f', // Headers y Sidebars
                    700: '#333333', // Fondos de input/card
                    400: '#a3a3a3', // Texto secundario
                    300: '#d4d4d4', // Texto principal
                },
                // Rojo llamativo para acentos
                'red': {
                    900: '#5c0a0a', // Borde y separadores oscuros
                    800: '#8b0d0d', // Acentos de fondo
                    700: '#b91c1c', // Rojo base (botones)
                    600: '#dc2626', // Rojo hover/activo
                    500: '#f95959', // Rojo llamativo (GANASTE)
                    400: '#fca5a5', // Texto de alerta
                },
            },

            // 2. Configuración de Fuentes
            fontFamily: {
                // Uso: Titulares principales, logo (Grand Casino)
                'casino': ['Grand Casino', 'serif'],
                // Uso: Botones, encabezados secundarios (Montserrat)
                'ui': ['Montserrat', 'sans-serif'],
                // Uso: Texto de cuerpo, formularios (Roboto)
                'sans': ['Roboto', 'sans-serif'],
            },
        },
    },

    plugins: [
        // Plugins útiles que podrías necesitar (opcional)
        require('@tailwindcss/forms'),
    ],
}