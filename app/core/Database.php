<?php

namespace Core;

use \PDO;
use \PDOException;

/**
 * Juego Consciente - Clase de Conexión a Base de Datos (Singleton)
 * Ubicación: ludopatia/app/core/Database.php
 */
class Database
{
    private static $instance = null;
    private $pdo;

    /**
     * Constructor privado para evitar la instanciación directa.
     */
    private function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Reportar errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch por defecto: array asociativo
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Deshabilitar emulación para seguridad
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // En un entorno de producción, esto debería loguearse y mostrar un mensaje genérico.
            // Para desarrollo, mostramos el error:
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la instancia única de la clase (Singleton).
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Devuelve el objeto PDO.
     * @return PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }

    /**
     * Evita que la instancia sea clonada.
     */
    private function __clone() {}

    /**
     * Evita que se deserialice la instancia.
     */
    public function __wakeup() {}
}