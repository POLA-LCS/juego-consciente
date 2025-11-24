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