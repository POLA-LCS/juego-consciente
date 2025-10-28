-- Base de datos: `ludopatia`
--

-- --------------------------------------------------------

--
-- Estructura de la base de datos y la tabla `users`
--

-- Crear la base de datos si no existe y seleccionarla
CREATE DATABASE IF NOT EXISTS `ludopatia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ludopatia`;

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `balance` int(11) NOT NULL DEFAULT 1000,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;