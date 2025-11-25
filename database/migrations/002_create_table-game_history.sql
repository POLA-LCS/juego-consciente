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