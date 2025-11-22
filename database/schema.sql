-- Base de datos: `ludopatia`
-- Archivo de Esquema de Base de Datos para Juego Consciente
-- Este archivo representa el estado final de la estructura de la base de datos.
-- NO DEBE EJECUTARSE DIRECTAMENTE. Utilice las migraciones para construir la base de datos.
-- ------------------------------------------------------------------------------------
--
-- Base de datos: `ludopatia`
--
-- Estructura de tabla para la tabla `users`
--
CREATE TABLE
    `users` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `balance` int (11) NOT NULL DEFAULT 1000,
        `win_streak` int (11) NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Estructura de tabla para la tabla `user_cheat_settings`
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