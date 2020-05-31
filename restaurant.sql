-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2020 a las 05:54:40
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurant`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambioEstadoMesa` (IN `estadoMesaNew` INT, IN `idMesa` INT)  BEGIN
UPDATE gestordemesas
SET estado = estadoMesaNew
where id = idMesa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarUsuario` (IN `us` VARCHAR(50))  BEGIN
SELECT * FROM usuarios WHERE usuario LIKE us;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spCulminarMEsas` (IN `idFAc` INT, IN `idOrden` INT)  BEGIN
UPDATE ordenesdemesas
SET idFactura = idFAc, estadoOrden = 2
WHERE id = idOrden;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spEditUSuario` (IN `nom` VARCHAR(50), IN `contrase` VARCHAR(60), IN `perf` VARCHAR(50), IN `picture` VARCHAR(50), IN `userEdit` VARCHAR(50))  BEGIN
UPDATE usuarios
SET nombre = nom, password = contrase, perfil = perf, foto = picture
WHERE usuario = userEdit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spFactura` (IN `idMes` INT, IN `cantMonto` FLOAT, IN `esta` INT, IN `idclt` INT)  BEGIN
INSERT INTO `restaurant`.`factuaciones`
(`idMesa`,
`monto`,
`estado`,
`fechaEmision`)
VALUES
(
idMes,
cantMonto,
esta,
SYSDATE(),
idclt);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spListaUser` ()  BEGIN
SELECT * FROM usuarios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMesaOcupada` (IN `idMesa` INT)  BEGIN
SELECT * FROM gestorDeMesas mesa
INNER JOIN ordenesdemesas orden ON mesa.mesa = orden.idMesa AND mesa.id = idMesa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMesasConsulta` ()  BEGIN
SELECT * FROM gestorDeMesas; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarAperitivos` ()  BEGIN
SELECT * FROM aperitivosrestaurant WHERE estadAperitivo = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarDatoFact` (IN `idFactur` INT)  BEGIN
SELECT clientesRestaurant.nit, clientesRestaurant.nombre, clientesRestaurant.direccion,
factuaciones.fechaEmision FROM factuaciones
INNER JOIN clientesRestaurant ON factuaciones.idCliente = clientesRestaurant.id
where factuaciones.id = idFactur;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarDetalleFact` (IN `idFActuras` INT)  BEGIN
SELECT
ordenesdemesas.id AS 'idOrden', ordenesdemesas.tipoOp AS 'tipoOp', 
usuarios.nombre AS 'nombreMesero', ordenesdemesas.cantidad AS 'cantidad',
aper.nombreAperitivo AS 'aperitivo', menus.nombreMenu AS 'menu',
ordenesdemesas.idAperMenu AS 'idAperM'
 FROM ordenesdemesas
INNER JOIN usuarios ON usuarios.id = ordenesdemesas.idUsuario
LEFT JOIN aperitivosrestaurant aper ON aper.id = ordenesdemesas.idAperMenu
LEFT JOIN menus ON menus.id = ordenesdemesas.idAperMenu 
WHERE ordenesdemesas.idMesa = idMesa AND ordenesdemesas.estadoOrden = 2 
AND ordenesdemesas.idFActura=idFActuras;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarFacturas` ()  BEGIN
SELECT 
factuaciones.id AS 'identity',
factuaciones.id+1000000 AS 'factura', 
clientesrestaurant.nombre, 
factuaciones.monto, 
factuaciones.fechaEmision, factuaciones.estado
FROM factuaciones
INNER JOIN clientesrestaurant ON clientesrestaurant.id = factuaciones.idCliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarMenus` ()  BEGIN
SELECT * FROM restaurant.menus;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarMenuSelect` (IN `idMenu` INT)  BEGIN
SELECT * FROM restaurant.menus WHERE id=idMenu;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarMesas` ()  BEGIN
SELECT * FROM cantidadmesas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarNit` (IN `numeroNit` TEXT)  BEGIN
SELECT * FROM restaurant.clientesrestaurant WHERE nit LIKE numeroNit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarOrdeDeMesa` (IN `idMesa` INT)  BEGIN
SELECT 
ordenesdemesas.id AS 'idOrden', ordenesdemesas.tipoOp AS 'tipoOp', 
usuarios.nombre AS 'nombreMesero', ordenesdemesas.cantidad AS 'cantidad',
aper.nombreAperitivo AS 'aperitivo', menus.nombreMenu AS 'menu',
ordenesdemesas.idAperMenu AS 'idAperM'
 FROM ordenesdemesas
INNER JOIN usuarios ON usuarios.id = ordenesdemesas.idUsuario
LEFT JOIN aperitivosrestaurant aper ON aper.id = ordenesdemesas.idAperMenu
LEFT JOIN menus ON menus.id = ordenesdemesas.idAperMenu 
WHERE ordenesdemesas.idMesa = idMesa AND ordenesdemesas.estadoOrden = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spMostrarUserEdit` (IN `idUs` INT)  BEGIN
SELECT * FROM usuarios WHERE id = idUs;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spNuevaFactura` (IN `idMesaFact` INT, IN `montoFact` FLOAT, IN `estadoFact` INT, IN `idClienteFact` INT)  BEGIN
INSERT INTO `restaurant`.`factuaciones`
(
`idMesa`,
`monto`,
`estado`,
`fechaEmision`,
`idCliente`)
VALUES
(
idMesaFact,
montoFact,
estadoFact,
SYSDATE(),
idClienteFact);
SELECT @@identity AS 'identity';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spNuevaOrden` (IN `idMes` INT, IN `idMEnAper` INT, IN `tipo` INT, IN `idUser` INT, IN `cantidad` INT)  BEGIN
INSERT INTO `restaurant`.`ordenesdemesas`
(`idMesa`,
`idAperMenu`,
`tipoOp`,
`idUsuario`,
`fechaOrden`,
`cantidad`,
`estadoOrden`)
VALUES
(idMes,
idMEnAper,
tipo,
idUser,
SYSDATE(),
cantidad,
1);
UPDATE gestordemesas
SET estado = 1, mesero = idUser, idOrden = @@identity
WHERE id = idMes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spNuevoAperitivo` (IN `categ` TEXT, IN `nombreApe` TEXT, IN `descriA` TEXT, IN `prec` FLOAT, IN `foto` TEXT)  BEGIN
INSERT INTO `restaurant`.`aperitivosrestaurant`
(
`categoriaAperitivo`,
`nombreAperitivo`,
`descripcionAperitivo`,
`precioAperitivo`,
`fotoAperitivo`,
`estadAperitivo`)
VALUES
(
categ,
nombreApe,
descriA,
prec,
foto,
1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spNuevoCliente` (IN `numNit` TEXT, IN `nombreClt` TEXT, IN `direccionClt` TEXT)  BEGIN
INSERT INTO `restaurant`.`clientesrestaurant`
(
`nit`,
`nombre`,
`direccion`)
VALUES
(
numNit,
nombreClt,
direccionClt);
SELECT @@Identity AS 'Identity';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spNuevoMenu` (IN `nomMenu` TEXT, IN `cantPrecio` FLOAT, IN `listMenu` TEXT)  BEGIN
INSERT INTO `restaurant`.`menus`
(`nombreMenu`,
`precio`,
`idAperitivos`,
`estado`)
VALUES
(nomMenu,
cantPrecio,
listMenu,
1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spSelectAperitivo` (IN `idAperitivo` INT)  BEGIN
SELECT * FROM aperitivosrestaurant WHERE id = idAperitivo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperitivosrestaurant`
--

CREATE TABLE `aperitivosrestaurant` (
  `id` int(11) NOT NULL,
  `categoriaAperitivo` text COLLATE utf8_spanish_ci NOT NULL,
  `nombreAperitivo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcionAperitivo` text COLLATE utf8_spanish_ci NOT NULL,
  `precioAperitivo` float NOT NULL,
  `fotoAperitivo` text COLLATE utf8_spanish_ci NOT NULL,
  `estadAperitivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aperitivosrestaurant`
--

INSERT INTO `aperitivosrestaurant` (`id`, `categoriaAperitivo`, `nombreAperitivo`, `descripcionAperitivo`, `precioAperitivo`, `fotoAperitivo`, `estadAperitivo`) VALUES
(1, 'Comida', 'CAMARONES Y QUINUA', 'ESTE CAMARÓN CON MANTEQUILLA DE AJO Y QUINUA ESTÁ LISTO EN 30 MINUTOS Y ESTÁ LLENO DE SABOR A MANTEQUILLA DE AJO\r\n', 75, 'vistas/img/aperitivos/CAMARONES Y QUINUA/500.jpg', 1),
(2, 'Comida', 'PINCHOS', ' TOCINO DE BURBUJA DE MIEL, HIERBA CAJÚN Y LIMÓN \r\n', 55, 'vistas/img/aperitivos/PINCHOS/116.jpg', 1),
(3, 'Comida', 'PARMESANO DE POLLO AL HORNO', 'DEBIDO A QUE ESTE POLLO PARMESANO ESTÁ HORNEADO, ¡ES SALUDABLEL!  CRUJIENTE PARMESANO HORNEADO CON COSTRA\r\n', 78, 'vistas/img/aperitivos/PARMESANO DE POLLO AL HORNO/476.jpg', 1),
(4, 'Comida', 'POLLO CON TOCINO Y SALSA ', 'VINO BLANCO POR PIZCA DE YUM CRUJIENTE, PICANTE, DELICIOSA SARTÉN CHICKAENNN\r\n', 75, 'vistas/img/aperitivos/POLLO CON TOCINO Y SALSA /106.jpg', 1),
(5, 'Postre', 'PASTEL DE PATATA Y QUESO', 'PASTEL ESPONJOSO DE PURÉ DE PATATAS, CUBIERTO CON CREMOSA MOZZARELLA, TOMATES PICANTES E HIERBAS ITALIANAS\r\n', 30, 'vistas/img/aperitivos/PASTEL DE PATATA Y QUESO/647.jpg', 1),
(6, 'Bebida', 'REFRESCO DE SÚCHILES', 'EL FRESCO DE SÚCHILES ES UNA BEBIDA GUATEMALTECA QUE SE PREPARA CON FRUTAS FERMENTADAS COMO PIÑA, JOCOTES MADUROS, NANCES, GUAYABAS, ENTRE OTRAS.\r\n', 20, 'vistas/img/aperitivos/REFRESCO DE SÚCHILES/432.jpg', 1),
(7, 'Bebida', 'CREMITAS', 'ES UNA BEBIDA REFRESCANTE, DE SABOR ÚNICO, PREPARADA A BASE DE LECHE DE VACA, MEDIANTE UN PROCESO ARTESANAL, CONSERVANDO TODAS SUS CUALIDADES ALIMENTICIAS.\r\n', 20, 'vistas/img/aperitivos/CREMITAS/906.jpg', 1),
(8, 'Bebida', 'HORCHATA', 'SU PREPARACIÓN SE REALIZA CON ARROZ, CANELA, ALMENDRAS, AZÚCAR Y AGUA.\r\n', 20, 'vistas/img/aperitivos/HORCHATA/826.jpg', 1),
(9, 'Bebida', 'CHINCHIVIR', 'UNA BEBIDA REFRESCANTE A BASE DE LIMÓN CON DIFERENTES ESPECIAS ORIGINARIA DE ANTIGUA GUATEMALA. EL CHINCHIVIR NO ES FERMENTADO.\r\n', 20, 'vistas/img/aperitivos/CHINCHIVIR/507.jpg', 1),
(10, 'Bebida', 'PONCHE NAVIDEÑO', 'ESTA BEBIDA SE PREPARA ESPECIALMENTE EN LAS FIESTAS NAVIDEÑAS, ES UNA TRADICIÓN FAMILIAR EN DONDE LAS RECETAS PUEDEN VARIAR UN POCO. POR LO GENERAL SE COMPONE DE PIÑA, MANZANA, CANELA, PASAS Y CIRUELAS.\r\n', 20, 'vistas/img/aperitivos/PONCHE NAVIDEÑO/821.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantidadmesas`
--

CREATE TABLE `cantidadmesas` (
  `id` int(11) NOT NULL,
  `cantidadMesasRes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cantidadmesas`
--

INSERT INTO `cantidadmesas` (`id`, `cantidadMesasRes`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(1, 'Equipos Electromecánicos', '2017-12-21 20:53:29'),
(2, 'Taladros', '2017-12-21 20:53:29'),
(3, 'Andamios', '2017-12-21 20:53:29'),
(4, 'Generadores de energía', '2017-12-21 20:53:29'),
(5, 'Equipos para construcción', '2017-12-21 20:53:29'),
(6, 'Martillos mecánicos', '2017-12-21 23:06:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientesrestaurant`
--

CREATE TABLE `clientesrestaurant` (
  `id` int(11) NOT NULL,
  `nit` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` text COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientesrestaurant`
--

INSERT INTO `clientesrestaurant` (`id`, `nit`, `nombre`, `direccion`) VALUES
(1, '373154', 'AUGUSTO RUFINO GOMEZ CONCUAN', 'GUATEMALA 15 CALLE ZONA 23'),
(3, '3', '7', '3'),
(4, 'Array', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factuaciones`
--

CREATE TABLE `factuaciones` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `monto` float DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fechaEmision` datetime DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `factuaciones`
--

INSERT INTO `factuaciones` (`id`, `idMesa`, `monto`, `estado`, `fechaEmision`, `idCliente`) VALUES
(1, 1, 400, 1, '2020-05-29 18:31:14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestordemesas`
--

CREATE TABLE `gestordemesas` (
  `id` int(11) NOT NULL,
  `mesa` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `mesero` int(11) NOT NULL,
  `idOrden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gestordemesas`
--

INSERT INTO `gestordemesas` (`id`, `mesa`, `estado`, `mesero`, `idOrden`) VALUES
(1, 1, 2, 1, 3),
(2, 2, 0, 0, NULL),
(3, 3, 0, 0, NULL),
(4, 4, 0, 0, NULL),
(5, 5, 0, 0, NULL),
(6, 6, 0, 0, NULL),
(7, 7, 0, 0, NULL),
(8, 8, 0, 0, NULL),
(9, 9, 0, 0, NULL),
(10, 10, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `nombreMenu` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` float NOT NULL,
  `idAperitivos` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `nombreMenu`, `precio`, `idAperitivos`, `estado`) VALUES
(1, 'FULL SKILL DE LA CASA', 100, '[{\"idAperitivos\":\"1\"},{\"idAperitivos\":\"3\"},{\"idAperitivos\":\"5\"},{\"idAperitivos\":\"5\"},{\"idAperitivos\":\"6\"}]', 1),
(2, 'MENU XV', 50, '[{\"idAperitivos\":\"5\"},{\"idAperitivos\":\"3\"},{\"idAperitivos\":\"10\"}]', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientosdecajadiario`
--

CREATE TABLE `movimientosdecajadiario` (
  `id` int(11) NOT NULL,
  `fechaMovimiento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuarioApertura` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdemesas`
--

CREATE TABLE `ordenesdemesas` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `idAperMenu` int(11) DEFAULT NULL,
  `tipoOp` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaOrden` datetime DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estadoOrden` int(11) DEFAULT NULL,
  `idFactura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ordenesdemesas`
--

INSERT INTO `ordenesdemesas` (`id`, `idMesa`, `idAperMenu`, `tipoOp`, `idUsuario`, `fechaOrden`, `cantidad`, `estadoOrden`, `idFactura`) VALUES
(1, 1, 1, 0, 1, '2020-05-29 13:06:16', 4, 2, 1),
(2, 1, 2, 0, 1, '2020-05-29 21:22:06', 5, 1, NULL),
(3, 1, 8, 1, 1, '2020-05-29 21:22:06', 5, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
(1, 1, '101', 'Aspiradora Industrial ', 'vistas/img/productos/101/105.png', 13, 1000, 1200, 2, '2017-12-24 01:11:04'),
(2, 1, '102', 'Plato Flotante para Allanadora', 'vistas/img/productos/102/940.jpg', 6, 4500, 6300, 3, '2017-12-26 15:04:11'),
(3, 1, '103', 'Compresor de Aire para pintura', 'vistas/img/productos/103/763.jpg', 8, 3000, 4200, 12, '2017-12-26 15:03:22'),
(4, 1, '104', 'Cortadora de Adobe sin Disco ', 'vistas/img/productos/104/957.jpg', 16, 4000, 5600, 4, '2017-12-26 15:03:22'),
(5, 1, '105', 'Cortadora de Piso sin Disco ', 'vistas/img/productos/105/630.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:22'),
(6, 1, '106', 'Disco Punta Diamante ', 'vistas/img/productos/106/635.jpg', 15, 1100, 1540, 5, '2017-12-26 15:04:38'),
(7, 1, '107', 'Extractor de Aire ', 'vistas/img/productos/107/848.jpg', 12, 1540, 2156, 8, '2017-12-26 15:04:11'),
(8, 1, '108', 'Guadañadora ', 'vistas/img/productos/108/163.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:52'),
(9, 1, '109', 'Hidrolavadora Eléctrica ', 'vistas/img/productos/109/769.jpg', 15, 2600, 3640, 5, '2017-12-26 15:05:09'),
(10, 1, '110', 'Hidrolavadora Gasolina', 'vistas/img/productos/110/582.jpg', 18, 2210, 3094, 2, '2017-12-26 15:05:09'),
(11, 1, '111', 'Motobomba a Gasolina', 'vistas/img/productos/default/anonymous.png', 20, 2860, 4004, 0, '2017-12-21 21:56:28'),
(12, 1, '112', 'Motobomba El?ctrica', 'vistas/img/productos/default/anonymous.png', 20, 2400, 3360, 0, '2017-12-21 21:56:28'),
(13, 1, '113', 'Sierra Circular ', 'vistas/img/productos/default/anonymous.png', 20, 1100, 1540, 0, '2017-12-21 21:56:28'),
(14, 1, '114', 'Disco de tugsteno para Sierra circular', 'vistas/img/productos/default/anonymous.png', 20, 4500, 6300, 0, '2017-12-21 21:56:28'),
(15, 1, '115', 'Soldador Electrico ', 'vistas/img/productos/default/anonymous.png', 20, 1980, 2772, 0, '2017-12-21 21:56:28'),
(16, 1, '116', 'Careta para Soldador', 'vistas/img/productos/default/anonymous.png', 20, 4200, 5880, 0, '2017-12-21 21:56:28'),
(17, 1, '117', 'Torre de iluminacion ', 'vistas/img/productos/default/anonymous.png', 20, 1800, 2520, 0, '2017-12-21 21:56:28'),
(18, 2, '201', 'Martillo Demoledor de Piso 110V', 'vistas/img/productos/default/anonymous.png', 20, 5600, 7840, 0, '2017-12-21 21:56:28'),
(19, 2, '202', 'Muela o cincel martillo demoledor piso', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
(20, 2, '203', 'Taladro Demoledor de muro 110V', 'vistas/img/productos/default/anonymous.png', 20, 3850, 5390, 0, '2017-12-21 21:56:28'),
(21, 2, '204', 'Muela o cincel martillo demoledor muro', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
(22, 2, '205', 'Taladro Percutor de 1/2 Madera y Metal', 'vistas/img/productos/default/anonymous.png', 20, 8000, 11200, 0, '2017-12-21 22:28:24'),
(23, 2, '206', 'Taladro Percutor SDS Plus 110V', 'vistas/img/productos/default/anonymous.png', 20, 3900, 5460, 0, '2017-12-21 21:56:28'),
(24, 2, '207', 'Taladro Percutor SDS Max 110V (Mineria)', 'vistas/img/productos/default/anonymous.png', 20, 4600, 6440, 0, '2017-12-21 21:56:28'),
(25, 3, '301', 'Andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1440, 2016, 0, '2017-12-21 21:56:28'),
(26, 3, '302', 'Distanciador andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1600, 2240, 0, '2017-12-21 21:56:28'),
(27, 3, '303', 'Marco andamio modular ', 'vistas/img/productos/default/anonymous.png', 20, 900, 1260, 0, '2017-12-21 21:56:28'),
(28, 3, '304', 'Marco andamio tijera', 'vistas/img/productos/default/anonymous.png', 20, 100, 140, 0, '2017-12-21 21:56:28'),
(29, 3, '305', 'Tijera para andamio', 'vistas/img/productos/default/anonymous.png', 20, 162, 226, 0, '2017-12-21 21:56:28'),
(30, 3, '306', 'Escalera interna para andamio', 'vistas/img/productos/default/anonymous.png', 20, 270, 378, 0, '2017-12-21 21:56:28'),
(31, 3, '307', 'Pasamanos de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 75, 105, 0, '2017-12-21 21:56:28'),
(32, 3, '308', 'Rueda giratoria para andamio', 'vistas/img/productos/default/anonymous.png', 20, 168, 235, 0, '2017-12-21 21:56:28'),
(33, 3, '309', 'Arnes de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 1750, 2450, 0, '2017-12-21 21:56:28'),
(34, 3, '310', 'Eslinga para arnes', 'vistas/img/productos/default/anonymous.png', 20, 175, 245, 0, '2017-12-21 21:56:28'),
(35, 3, '311', 'Plataforma Met?lica', 'vistas/img/productos/default/anonymous.png', 20, 420, 588, 0, '2017-12-21 21:56:28'),
(36, 4, '401', 'Planta Electrica Diesel 6 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3500, 4900, 0, '2017-12-21 21:56:28'),
(37, 4, '402', 'Planta Electrica Diesel 10 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3550, 4970, 0, '2017-12-21 21:56:28'),
(38, 4, '403', 'Planta Electrica Diesel 20 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3600, 5040, 0, '2017-12-21 21:56:28'),
(39, 4, '404', 'Planta Electrica Diesel 30 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3650, 5110, 0, '2017-12-21 21:56:28'),
(40, 4, '405', 'Planta Electrica Diesel 60 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3700, 5180, 0, '2017-12-21 21:56:28'),
(41, 4, '406', 'Planta Electrica Diesel 75 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3750, 5250, 0, '2017-12-21 21:56:28'),
(42, 4, '407', 'Planta Electrica Diesel 100 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3800, 5320, 0, '2017-12-21 21:56:28'),
(43, 4, '408', 'Planta Electrica Diesel 120 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3850, 5390, 0, '2017-12-21 21:56:28'),
(44, 5, '501', 'Escalera de Tijera Aluminio ', 'vistas/img/productos/default/anonymous.png', 20, 350, 490, 0, '2017-12-21 21:56:28'),
(45, 5, '502', 'Extension Electrica ', 'vistas/img/productos/default/anonymous.png', 20, 370, 518, 0, '2017-12-21 21:56:28'),
(46, 5, '503', 'Gato tensor', 'vistas/img/productos/default/anonymous.png', 20, 380, 532, 0, '2017-12-21 21:56:28'),
(47, 5, '504', 'Lamina Cubre Brecha ', 'vistas/img/productos/default/anonymous.png', 20, 380, 532, 0, '2017-12-21 21:56:28'),
(48, 5, '505', 'Llave de Tubo', 'vistas/img/productos/default/anonymous.png', 20, 480, 672, 0, '2017-12-21 21:56:28'),
(49, 5, '506', 'Manila por Metro', 'vistas/img/productos/default/anonymous.png', 20, 600, 840, 0, '2017-12-21 21:56:28'),
(50, 5, '507', 'Polea 2 canales', 'vistas/img/productos/default/anonymous.png', 20, 900, 1260, 0, '2017-12-21 21:56:28'),
(51, 5, '508', 'Tensor', 'vistas/img/productos/508/500.jpg', 19, 100, 140, 1, '2017-12-26 22:26:51'),
(52, 5, '509', 'Bascula ', 'vistas/img/productos/509/878.jpg', 12, 130, 182, 8, '2017-12-26 22:26:51'),
(53, 5, '510', 'Bomba Hidrostatica', 'vistas/img/productos/510/870.jpg', 8, 770, 1078, 12, '2017-12-26 22:26:51'),
(54, 5, '511', 'Chapeta', 'vistas/img/productos/511/239.jpg', 16, 660, 924, 4, '2017-12-26 22:27:42'),
(55, 5, '512', 'Cilindro muestra de concreto', 'vistas/img/productos/512/266.jpg', 16, 400, 560, 4, '2017-12-26 22:27:41'),
(56, 5, '513', 'Cizalla de Palanca', 'vistas/img/productos/513/445.jpg', 3, 450, 630, 17, '2017-12-27 00:30:12'),
(57, 5, '514', 'Cizalla de Tijera', 'vistas/img/productos/514/249.jpg', 20, 580, 812, 13, '2017-12-27 04:29:22'),
(58, 5, '515', 'Coche llanta neumatica', 'vistas/img/productos/515/174.jpg', 17, 420, 588, 3, '2017-12-27 00:30:12'),
(59, 5, '516', 'Cono slump', 'vistas/img/productos/516/228.jpg', 15, 140, 196, 5, '2018-02-06 22:47:02'),
(60, 5, '517', 'Cortadora de Baldosin', 'vistas/img/productos/517/746.jpg', 13, 930, 1302, 7, '2018-02-06 22:47:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/191.jpg', 1, '2018-02-06 17:25:57', '2018-02-06 22:25:57'),
(57, 'Juan Fernando Urrego', 'juan', '$2a$07$asxx54ahjppf45sd87a5auGZEtGHuyZwm.Ur.FJvWLCql3nmsMbXy', 'Administrador', 'vistas/img/usuarios/juan/976.jpg', 1, '2018-02-06 16:58:50', '2020-05-24 17:21:26'),
(58, 'Julio Gómez', 'julio', '$2a$07$asxx54ahjppf45sd87a5auQhldmFjGsrgUipGlmQgDAcqevQZSAAC', 'Especial', 'vistas/img/usuarios/julio/100.png', 1, '2018-02-06 17:09:22', '2018-02-06 22:09:22'),
(59, 'Ana Gonzales', 'ana', '$2a$07$asxx54ahjppf45sd87a5auJRR6foEJ7ynpjisKtbiKJbvJsoQ8VPS', '', '', 1, '2017-12-26 19:21:40', '2020-05-30 03:18:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aperitivosrestaurant`
--
ALTER TABLE `aperitivosrestaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cantidadmesas`
--
ALTER TABLE `cantidadmesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientesrestaurant`
--
ALTER TABLE `clientesrestaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factuaciones`
--
ALTER TABLE `factuaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gestordemesas`
--
ALTER TABLE `gestordemesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientosdecajadiario`
--
ALTER TABLE `movimientosdecajadiario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenesdemesas`
--
ALTER TABLE `ordenesdemesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aperitivosrestaurant`
--
ALTER TABLE `aperitivosrestaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cantidadmesas`
--
ALTER TABLE `cantidadmesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientesrestaurant`
--
ALTER TABLE `clientesrestaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factuaciones`
--
ALTER TABLE `factuaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gestordemesas`
--
ALTER TABLE `gestordemesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimientosdecajadiario`
--
ALTER TABLE `movimientosdecajadiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenesdemesas`
--
ALTER TABLE `ordenesdemesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
