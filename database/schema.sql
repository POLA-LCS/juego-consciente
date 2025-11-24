-- Migration: Crear la tabla de usuarios
--
CREATE DATABASE IF NOT EXISTS `ludopatia`;

USE `ludopatia`;

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

-- Migration: Crear la tabla de configuración de trucos
--
CREATE TABLE
    `cheat_settings` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `mode` INT NOT NULL DEFAULT 0 COMMENT '0: Normal, 1: Ganador, 2: Perdedor',
        `max_streak` INT NOT NULL DEFAULT -1 COMMENT '-1 para sin límite',
        `max_balance` INT NOT NULL DEFAULT -1 COMMENT '-1 para sin límite',
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_id` (`user_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Migration: Crear la tabla de historial de partidas
--
CREATE TABLE
    `game_history` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `game` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ej: roulette, cups, slots',
        `bet_amount` DECIMAL(10, 2) NOT NULL,
        `won` BOOLEAN NOT NULL COMMENT 'true si el usuario ganó, false si perdió',
        `winnings` DECIMAL(10, 2) NOT NULL,
        `played_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;