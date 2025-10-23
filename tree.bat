@echo off
echo Creando la estructura de directorios para Juego Consciente...

:: Directorios principales
mkdir app
mkdir public
mkdir vendor

:: Subdirectorios de 'app'
mkdir app\config
mkdir app\controllers
mkdir app\core
mkdir app\models
mkdir app\views

:: Subdirectorios de 'app\views'
mkdir app\views\components
mkdir app\views\games
mkdir app\views\auth
mkdir app\views\info

:: Subdirectorios de 'public'
mkdir public\assets
mkdir public\assets\css
mkdir public\assets\fonts
mkdir public\assets\img
mkdir public\assets\js

echo Estructura de directorios creada exitosamente.

:: Archivos placeholders (Opcional, pero útil)
echo ^<?php // app/core/App.php > app\core\App.php
echo ^<?php // public/index.php > public\index.php
echo DB_NAME=juegoconsciente_db > .env
echo module.exports = { ... }; > tailwind.config.js
type NUL > public\.htaccess
type NUL > setup.sql

pause