-- Migration: Crear la tabla de configuración de trucos para usuarios
--
CREATE TABLE
    `user_cheat_settings` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `user_id` int (11) NOT NULL,
        `mode` tinyint (1) NOT NULL DEFAULT 0 COMMENT '0: normal, 1: winner, 2: loser',
        `max_streak` int (11) NOT NULL DEFAULT -1 COMMENT '-1: desactivado',
        `max_balance` int (11) NOT NULL DEFAULT -1 COMMENT '-1: desactivado',
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_id` (`user_id`),
        CONSTRAINT `user_cheat_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;