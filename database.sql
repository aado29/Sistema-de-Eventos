-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 21, 2017 at 09:27 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eventos`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `type`, `description`, `state`) VALUES
(1, 'equipo_', 'Alpinismo', 'equipo_', '0'),
(2, 'Equipo 2', 'Vialidad', 'Equipo acuatico', '1'),
(3, 'Cuerdas', 'Alpinismo', 'drisa', '1');

-- --------------------------------------------------------

--
-- Table structure for table `equipments_relations`
--

CREATE TABLE `equipments_relations` (
  `id` int(11) NOT NULL,
  `id_equipment` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `owner_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `equipments_relations`
--

INSERT INTO `equipments_relations` (`id`, `id_equipment`, `id_owner`, `owner_type`) VALUES
(7, 1, 4, 'group'),
(14, 1, 5, 'voluntary'),
(17, 1, 1, 'voluntary'),
(18, 2, 1, 'voluntary'),
(19, 2, 3, 'group'),
(24, 1, 1, 'group'),
(25, 2, 1, 'group'),
(26, 2, 2, 'voluntary'),
(27, 1, 4, 'voluntary'),
(28, 2, 4, 'voluntary');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `id_events_type` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `startDate` date NOT NULL DEFAULT '0000-00-00',
  `dueDate` date NOT NULL DEFAULT '0000-00-00',
  `startHour` time NOT NULL,
  `dueHour` time NOT NULL,
  `place` varchar(100) NOT NULL,
  `results` varchar(1200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `id_events_type`, `description`, `startDate`, `dueDate`, `startHour`, `dueHour`, `place`, `results`) VALUES
(1, 5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem iusto, recusandae possimus vel quisquam aperiam iste eaque.', '2017-07-03', '2017-07-06', '00:04:00', '00:03:00', 'hola', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem iusto, recusandae possimus vel quisquam aperiam iste eaque, ratione molestias repellat impedit ducimus consequuntur perferendis! Reprehenderit perspiciatis hic minus obcaecati eaque. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem iusto, recusandae possimus vel quisquam aperiam iste eaque, ratione molestias repellat impedit ducimus consequuntur perferendis! Reprehenderit perspiciatis hic minus obcaecati eaque.'),
(2, 2, 'descripcion evento 2', '2017-07-20', '2017-07-31', '00:00:00', '00:00:00', 'maracaibo', 'resultados'),
(3, 2, 'Descripcion evento 2', '2017-07-21', '2017-07-22', '00:00:00', '00:00:00', 'maracaibo', 'resultado'),
(4, 5, 'descripcion evento 1.1.2', '2017-07-20', '2017-07-31', '00:00:00', '00:00:00', 'plaza republica', 'todo de pinga');

-- --------------------------------------------------------

--
-- Table structure for table `events_relations`
--

CREATE TABLE `events_relations` (
  `id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_partaker` int(11) NOT NULL,
  `partaker` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `events_relations`
--

INSERT INTO `events_relations` (`id`, `id_event`, `id_partaker`, `partaker`) VALUES
(44, 2, 1, 'group'),
(45, 2, 3, 'group'),
(46, 2, 2, 'voluntary'),
(47, 2, 4, 'voluntary'),
(48, 2, 1, 'equipment'),
(49, 2, 2, 'equipment'),
(50, 3, 1, 'group'),
(51, 3, 2, 'group'),
(52, 3, 3, 'group'),
(53, 3, 1, 'voluntary'),
(54, 3, 1, 'equipment'),
(55, 3, 2, 'equipment'),
(71, 1, 1, 'group'),
(72, 1, 2, 'group'),
(73, 1, 3, 'group'),
(74, 1, 4, 'group'),
(75, 1, 1, 'voluntary'),
(76, 1, 2, 'voluntary'),
(77, 1, 4, 'voluntary'),
(78, 1, 5, 'voluntary'),
(79, 1, 1, 'equipment'),
(80, 1, 2, 'equipment'),
(81, 1, 3, 'equipment'),
(82, 4, 1, 'group'),
(83, 4, 3, 'group'),
(84, 4, 1, 'voluntary'),
(85, 4, 5, 'voluntary'),
(86, 4, 1, 'equipment'),
(87, 4, 3, 'equipment');

-- --------------------------------------------------------

--
-- Table structure for table `events_type`
--

CREATE TABLE `events_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events_type`
--

INSERT INTO `events_type` (`id`, `name`, `parent_id`) VALUES
(1, 'Evento 1', 0),
(2, 'Evento 2', 0),
(3, 'Evento 1.1', 1),
(4, 'Evento 1.2', 1),
(5, 'Evento 1.1.2', 3),
(6, 'Evento 1.2.1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `permissions` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Usuario estándar', ''),
(2, 'Administrador', '{\"admin\":1,\"moderator\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `groups_2`
--

CREATE TABLE `groups_2` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `speciality` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `membersNumber` int(2) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_2`
--

INSERT INTO `groups_2` (`id`, `name`, `speciality`, `description`, `phone`, `address`, `email`, `membersNumber`, `state`) VALUES
(1, 'Grupo 1', 'ahola', 'hola', '04149641997', 'dn;dd alDNL', 'aado@sda.akd', 23, '1'),
(2, 'Grupo 2', 'ahola', 'hola', '2147483647', 'dn;dd alDNL', 'aado@sda.akd', 20, '1'),
(3, 'Grupo 3', 'ahola', 'hola', '2147483647', 'dn;dd alDNL', 'aado@sda.akd', 20, '0'),
(4, 'Grupo 4', 'Spect 2', 'descripcion', '2147483647', 'kshaddkas', 'dmsdlnd@znls.com', 23, '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ci` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ci`, `username`, `password`, `salt`, `firstName`, `lastName`, `phone`, `email`, `joined`, `group`) VALUES
(1, 12345678, 'aado29', 'c9ed5c749ebc269bf230aebc23ec7c5b79af8271842e53eea6d8ba587e6de978', '', 'Alberto', 'Diaz', '04149641997', 'aado29@gmail.com', '2017-07-01 00:30:59', 2),
(2, 21367773, 'aado_', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '', 'alber', 'diaz', '2147483647', 'aa@hma.com', '2017-07-01 00:33:34', 2),
(3, 21367773, 'Alberto', 'c9ed5c749ebc269bf230aebc23ec7c5b79af8271842e53eea6d8ba587e6de978', '', 'Alberto', 'Diaz', '2147483647', 'aado29@hshsk.com', '2017-07-03 22:02:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `plate` varchar(7) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL,
  `year` int(4) NOT NULL,
  `bodywork` varchar(20) NOT NULL,
  `motor` varchar(20) NOT NULL,
  `chassis` varchar(20) NOT NULL,
  `id_voluntary` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `type`, `plate`, `brand`, `model`, `color`, `year`, `bodywork`, `motor`, `chassis`, `id_voluntary`, `state`) VALUES
(1, 'Coupe', 'GHR23GH', 'Marca&ntilde;', 'Modelo', 'Color', 2017, '10000001', '10000000', '10000000', 1, 0),
(2, 'Deportivo', '123456', 'honda', 'modelo', 'verde', 2002, '3298', '291290', '3282', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `ci` int(8) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `gender` varchar(9) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profession` varchar(20) NOT NULL,
  `employment` varchar(20) NOT NULL,
  `sizeShirt` varchar(2) NOT NULL,
  `sizePants` varchar(2) NOT NULL,
  `sizeShoes` int(2) NOT NULL,
  `id_group` int(11) NOT NULL,
  `position` varchar(20) NOT NULL,
  `speciality` varchar(20) NOT NULL,
  `id_equipment` int(11) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`id`, `photo`, `ci`, `firstName`, `lastName`, `gender`, `birthday`, `address`, `phone`, `email`, `profession`, `employment`, `sizeShirt`, `sizePants`, `sizeShoes`, `id_group`, `position`, `speciality`, `id_equipment`, `state`) VALUES
(1, '', 21367773, 'Nombre', 'Apellido', 'Masculino', '0000-00-00', 'Direccion', '04145382773', 'amadlna@lmafl.as', 'Profecion', 'Ocupacion', 'L', '34', 37, 1, 'Directivo', 'Especialidad', 1, '1'),
(2, './uploads/a8761aa4df53b9ead41d02786f371bcb.jpg', 12343829, 'alberto', 'alberot', 'Femenino', '2017-07-21', 'jbdkaDKPq ', '04146930816', 'kandkNA@KANDKSAN.ASKDN', 'daldlas`', 'm asdna', 'SS', '20', 30, 1, 'Directivo', 'knkandsan', 1, '0'),
(4, '', 21367774, 'aiNDs', 'aldlms', 'Femenino', '1994-11-29', 'sndadkl', '04149641997', 'askndkal@djso.sdkn', 'pelabola', '', 'SS', '20', 30, 1, 'Directivo', '', 1, '1'),
(5, '', 26234987, 'nom2', 'ape2', 'Otro', '0000-00-00', 'dirsaddsada1', '2147483647', 'frergreg@fsdfa.43', 'dgfdfsgdfsg', 'dsfg', '', '', 0, 2, 'Directivo', 'dfsdfsdfdsafsa', 0, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipments_relations`
--
ALTER TABLE `equipments_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_relations`
--
ALTER TABLE `events_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_type`
--
ALTER TABLE `events_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_2`
--
ALTER TABLE `groups_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `equipments_relations`
--
ALTER TABLE `equipments_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `events_relations`
--
ALTER TABLE `events_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `events_type`
--
ALTER TABLE `events_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `groups_2`
--
ALTER TABLE `groups_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;