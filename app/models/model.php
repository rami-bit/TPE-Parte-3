<?php
require_once __DIR__ . '/../../config.php';
class Model
{
    protected $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        // Crear la base de datos si no existe
        $this->db->exec("CREATE DATABASE IF NOT EXISTS `" . MYSQL_DB . "` CHARACTER SET utf8 COLLATE utf8_general_ci");
        // Conectarse a la base de datos recién creada
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->_deploy();
    }

    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        $pass = '$2y$10$eYh/iNiGM0MGHd21fAn7he7RMu2dcx54GNSd3EIgOczfK72/0AgjO';
        if (count($tables) == 0) {
            $sql = <<<END
            -- 
            phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2025 a las 02:31:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `noticiero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `resumen` varchar(200) DEFAULT NULL,
  `contenido` longtext NOT NULL,
  `seccion_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `img`, `resumen`, `contenido`, `seccion_id`) VALUES
(1, 'Jugador de League of Legends logra subir de Bronce a Plata', 'https://pm1.aminoapps.com/7617/c4f970607c56d99ad65404e0a85c6477211eee04r1-499-580v2_uhq.jpg', 'Este jugador logra subir de rango después de que el servidor se cayó y todos perdieron puntos menos el', 'Jugador sube a Plata en League of Legends luego de caída del servidor que solo le sumó puntos a él\r\n\r\n18 de diciembre de 2018 — Peru.\r\nUn curioso incidente en los servidores de League of Legends dejó boquiabierta a la comunidad: un jugador logró ascender a la liga Plata IV sin terminar su partida, luego de que el servidor se cayera en plena partida… pero, misteriosamente, solo a él le contó como victoria.\r\n\r\nEl protagonista, conocido como “TeemoTaxista”, relató su experiencia en un post de Reddit que rápidamente se volvió viral. Según explicó, el servidor de la región LAS colapsó durante una partida clasificatoria cuando su equipo estaba siendo aplastado con un marcador de 7 a 42.\r\n\r\n“Se me congeló la pantalla, pensé que había perdido. Reinicié el cliente y cuando entré al perfil, había subido de Bronce I a Plata IV. Literalmente me ascendió el bug”, escribió el jugador entre risas.\r\n\r\nMientras la mayoría de los usuarios que participaron en esa partida reportaron haber recibido un error del tipo “Partida no procesada”, el sistema le otorgó a TeemoTaxista 23 PL y lo marcó como MVP del encuentro, pese a tener un KDA de 0/11/2.\r\n\r\nLa comunidad no tardó en reaccionar. En X (ex Twitter), el hashtag #RiotMeAscende se volvió tendencia, y cientos de jugadores comenzaron a bromear pidiendo “caídas selectivas” para mejorar su rank.\r\n\r\n“Me vengo comiendo derrotas hace tres años, y este tipo sube a Plata porque se le trabó el Wi-Fi”, comentó un usuario indignado.\r\nOtro agregó: “Primera vez que un crasheo beneficia a alguien en League of Legends”.\r\n\r\nRiot Games emitió un breve comunicado reconociendo “una inconsistencia menor” en los servidores de clasificación, y aseguró que el incidente no afectó la integridad competitiva del sistema.\r\n“Estamos investigando por qué el sistema de detección consideró una desconexión como victoria. Probablemente sea el primer caso donde el lag te hace ganar”, expresó un vocero de la compañía.\r\n\r\nHasta el momento, la cuenta de TeemoTaxista no ha sido penalizada, y él declaró que no piensa volver a jugar ranked “por miedo a que el milagro se revierta”.', 1),
(6, 'Riot banea a jugador de League of Legends por buena conducta', 'https://unbanster.com/wp-content/uploads/2022/06/League-of-Legends-Account-Suspended-for-Boosting.webp', 'El sistema lo detectó diciendo “buen juego” y “gracias”. “Era demasiado sospechoso para ser humano”', 'Riot Games banea a un jugador de League of Legends por “conducta sospechosamente buena”\r\n\r\n13 de octubre de 2025 — Buenos Aires.\r\nUn hecho insólito sacudió hoy a la comunidad de League of Legends: un jugador fue suspendido por siete días debido a un “comportamiento inusualmente positivo” durante sus partidas clasificatorias.\r\n\r\nEl usuario, conocido en los foros como “GentleSupport69”, fue notificado por Riot Games luego de mantener una racha de más de 100 partidas sin recibir reportes, y con una tasa de elogios del 98% por parte de sus compañeros. El sistema automatizado de comportamiento, aparentemente confundido, interpretó su actitud como una posible manipulación de conducta o actividad de bot.\r\n\r\n“Pensamos que nadie podía ser tan amable en el chat de League sin estar haciendo trampa”, declaró entre risas un desarrollador de Riot bajo anonimato.\r\n“Cuando alguien dice ‘buen trabajo equipo’ después de perder una partida 0-25, el sistema entra en pánico”, agregó.\r\n\r\nSegún los registros', 1),
(7, 'Nuevo Resident Evil incluirá modo “Factura de luz en Argentina”', 'https://i.ytimg.com/vi/5XDLYbZtU6U/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLC_HTG2N6K-x8C2BVhYX4Ow5TevhQ', 'Capcom revoluciona el survival horror: los zombies no atacan más, solo te muestran el monto a pagar.', 'Capcom anunció un nuevo modo para Resident Evil: los jugadores deberán sobrevivir a la experiencia de abrir una factura de luz con inflación. “Queríamos un miedo real, no zombies”, dijeron desde la compañía.\r\nLos testers aseguran que la primera misión es simplemente mirar el monto y no desmayarse. “Es el único juego que me dio pánico sin disparar un solo tiro”, confesó un fan.', 5),
(10, 'Joven pasa 12 años en Minecraft y sus padres lo felicitan', 'https://i.ytimg.com/vi/Z_aQFxhrPds/maxresdefault.jpg', 'Resumen: Tras más de una década construyendo castillos, ahora le pidieron que construya un curriculum.', 'Un jugador de Minecraft completó su megaproyecto tras 12 años de trabajo: una réplica exacta de la Tierra en escala 1:1. Sus padres, entre el orgullo y la preocupación, le pidieron que aplique esos conocimientos para “levantar algo en la vida real”.\r\nEl joven respondió: “No sé si el mundo real tiene Redstone, pero puedo intentarlo”. Mojang lo felicitó y le ofreció una beca… en modo supervivencia.', 6),
(11, 'Jugador de GTA V pasa 6 horas respetando los semáforos', 'https://i.ytimg.com/vi/yp5kNCsGO8s/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDRrxajMWtk_s1-0TRdI9RYzmXHAg', '“Solo quería vivir como una persona decente”, dijo antes de ser atropellado por un NPC que dobló sin mirar.', 'Un jugador decidió conducir correctamente por las calles de Los Santos para “ver cómo se sentía la vida civilizada”. Mantuvo el límite de velocidad, usó guiños y hasta esperó en rojo.\r\nSu experimento terminó abruptamente cuando un auto controlado por la IA lo embistió a toda velocidad. “Intenté ser un ciudadano ejemplar, pero el juego no está preparado para eso”, declaró antes de volver a atropellar medio barrio.', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `img_url` varchar(250) NOT NULL,
  `genero` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id`, `nombre`, `img_url`, `genero`) VALUES
(1, 'League of Legends', 'https://wallpapers.com/images/hd/stunning-league-of-legends-desktop-jk70emfq9rgxk1qm.jpg', 'Moba'),
(2, 'Gta 5', 'https://i.pinimg.com/736x/bd/93/4d/bd934dd07ad39bdd69ef0f721253f612.jpg', 'Acción/Sandbox'),
(5, 'Resident Evil', 'https://media.revistagq.com/photos/5efedc2009f9a6fc5dffb3b4/16:9/w_1280,c_limit/Resident-Evil-4-Remake.jpg', 'Accion/Horror/Supervivencia'),
(6, 'Minecraft', 'https://image.api.playstation.com/vulcan/ap/rnd/202407/0401/670c294ded3baf4fa11068db2ec6758c63f7daeb266a35a1.png', 'Supervivencia/Sandbox'),
(12, 'free fire', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNB7S3gVB92xLEPhkg_hxv3K1fEHg92cwuug&s', 'Accion/Battle Royale');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`) VALUES
(1, 'webadmin', $pass);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_noticiero_secciones` (`seccion_id`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_noticiero_secciones` FOREIGN KEY (`seccion_id`) REFERENCES `secciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
END;
            $this->db->query($sql);
        }
    }

}