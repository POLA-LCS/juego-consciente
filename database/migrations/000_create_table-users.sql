-- Migration: Crear la tabla de usuarios
--
CREATE TABLE
    `users` (
        `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
        `password` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `balance` DECIMAL(10, 2) NOT NULL DEFAULT 1000.00,
        `win_streak` INT NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        UNIQUE KEY `email` (`email`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;