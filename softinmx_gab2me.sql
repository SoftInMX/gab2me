-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-10-2014 a las 23:21:19
-- Versión del servidor: 5.5.37-cll
-- Versión de PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `softinmx_gab2me`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `g2m_ask`
--

CREATE TABLE IF NOT EXISTS `g2m_ask` (
  `id_ask` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idu_questioner` int(11) unsigned NOT NULL,
  `idu_questionado` int(11) unsigned NOT NULL,
  `question` varchar(300) NOT NULL DEFAULT '',
  `answer` varchar(300) DEFAULT '',
  `status` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ask`),
  UNIQUE KEY `idu_questioner` (`idu_questioner`),
  UNIQUE KEY `idu_questionado` (`idu_questionado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `g2m_follow`
--

CREATE TABLE IF NOT EXISTS `g2m_follow` (
  `id_follow` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_follower` int(11) unsigned NOT NULL,
  `id_following` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_follow`),
  KEY `usuario_seguidor` (`id_follower`),
  KEY `usuario_seguido` (`id_following`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `g2m_follow`
--

INSERT INTO `g2m_follow` (`id_follow`, `id_follower`, `id_following`) VALUES
(1, 2, 1),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `g2m_page`
--

CREATE TABLE IF NOT EXISTS `g2m_page` (
  `id_page` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  PRIMARY KEY (`id_page`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `g2m_page`
--

INSERT INTO `g2m_page` (`id_page`, `title`, `content`) VALUES
(1, 'Sobre Nosotros', ''),
(2, 'Ayuda', ''),
(3, 'Condiciones', ''),
(4, 'Privacidad', ''),
(5, 'Información sobre anuncios', ''),
(6, 'Marca', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `g2m_profile`
--

CREATE TABLE IF NOT EXISTS `g2m_profile` (
  `id_profile` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `cover` varchar(150) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `desc` varchar(400) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_profile`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `g2m_profile`
--

INSERT INTO `g2m_profile` (`id_profile`, `id_user`, `cover`, `name`, `last_name`, `gender`, `desc`, `city`) VALUES
(1, 1, 'back2.png', 'Juan Francisco', 'Herrera Espinosa', 'H', 'Enamorado de la tierra del sol naciente, geek, freak, soñador de tiempo completo.', 'México D.F'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `g2m_user`
--

CREATE TABLE IF NOT EXISTS `g2m_user` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(80) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `passwd` text NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `g2m_user`
--

INSERT INTO `g2m_user` (`id_user`, `user`, `email`, `passwd`, `avatar`) VALUES
(1, 'jok3r', 'fherrera@softin.mx', '49342000ca291986c11b009b3127356f', 'jok3r.jpg'),
(2, 'puppetmast3r', 'egarigaribay@gmail.com', '49342000ca291986c11b009b3127356f', NULL),
(3, 'jok3rcit0', 'francisco@givu.co', '49342000ca291986c11b009b3127356f', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `g2m_ask`
--
ALTER TABLE `g2m_ask`
  ADD CONSTRAINT `user_asked` FOREIGN KEY (`idu_questionado`) REFERENCES `g2m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_asker` FOREIGN KEY (`idu_questioner`) REFERENCES `g2m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `g2m_follow`
--
ALTER TABLE `g2m_follow`
  ADD CONSTRAINT `usuario_seguido` FOREIGN KEY (`id_following`) REFERENCES `g2m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_seguidor` FOREIGN KEY (`id_follower`) REFERENCES `g2m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `g2m_profile`
--
ALTER TABLE `g2m_profile`
  ADD CONSTRAINT `user_to_profile` FOREIGN KEY (`id_user`) REFERENCES `g2m_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
