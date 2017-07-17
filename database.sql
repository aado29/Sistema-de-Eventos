-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 17, 2017 at 06:43 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eventos`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `startDate` date NOT NULL DEFAULT '0000-00-00',
  `dueDate` date NOT NULL DEFAULT '0000-00-00',
  `place` varchar(100) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_voluntary` int(11) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `startDate`, `dueDate`, `place`, `id_group`, `id_voluntary`, `id_team`) VALUES
(1, 'Hola_', '2017-07-03', '2017-07-06', 'hola', 3, 1, 1);

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
  `type` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `membersNumber` int(2) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_2`
--

INSERT INTO `groups_2` (`id`, `name`, `type`, `description`, `phone`, `address`, `email`, `membersNumber`, `state`) VALUES
(1, 'Hola', 'ahola', 'hola', 2147483647, 'dn;dd alDNL', 'aado@sda.akd', 20, 'estado'),
(2, 'Hola', 'ahola', 'hola', 2147483647, 'dn;dd alDNL', 'aado@sda.akd', 20, 'estado'),
(3, 'Hola', 'ahola', 'hola', 2147483647, 'dn;dd alDNL', 'aado@sda.akd', 20, 'estado');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `description`, `state`) VALUES
(1, 'equipo_', 'equipo_', 'equipo_');

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
  `phone` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ci`, `username`, `password`, `salt`, `firstName`, `lastName`, `phone`, `email`, `joined`, `group`) VALUES
(1, 21367773, 'aado29', 'c9ed5c749ebc269bf230aebc23ec7c5b79af8271842e53eea6d8ba587e6de978', '', 'Alberto', 'Diaz', 2147483647, 'aado29@gmail.com', '2017-07-01 00:30:59', 1),
(2, 21367773, 'aado_', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '', 'alber', 'diaz', 2147483647, 'aa@hma.com', '2017-07-01 00:33:34', 2),
(3, 21367773, 'Alberto', 'c9ed5c749ebc269bf230aebc23ec7c5b79af8271842e53eea6d8ba587e6de978', '', 'Alberto', 'Diaz', 2147483647, 'aado29@hshsk.com', '2017-07-03 22:02:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `hash`) VALUES
(1, 1, '27b76812cdbebd7a17e6646f84860b4ceca03f06a1c8c5b29d99f54bfaa4022e');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `plate` varchar(7) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL,
  `year` int(4) NOT NULL,
  `bodywork` varchar(20) NOT NULL,
  `motor` varchar(20) NOT NULL,
  `chassis` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `plate`, `brand`, `model`, `color`, `year`, `bodywork`, `motor`, `chassis`, `state`) VALUES
(1, 'GHR23GH', 'Marca', 'Modelo', 'Color', 2017, '10000001', '10000000', '10000000', 'Estado');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `ci` int(8) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sizeShirt` varchar(2) NOT NULL,
  `sizePants` varchar(2) NOT NULL,
  `sizeShoes` int(2) NOT NULL,
  `position` varchar(20) NOT NULL,
  `profession` varchar(20) NOT NULL,
  `speciality` varchar(20) NOT NULL,
  `employment` varchar(20) NOT NULL,
  `id_team` int(11) NOT NULL,
  `id_vehicle` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`id`, `ci`, `firstName`, `lastName`, `address`, `phone`, `email`, `sizeShirt`, `sizePants`, `sizeShoes`, `position`, `profession`, `speciality`, `employment`, `id_team`, `id_vehicle`, `type`, `state`, `photo`) VALUES
(1, 21367773, 'Nombre', 'Apellido', 'Direccion', 2147483647, 'amadlna@lmafl.as', 'L', '34', 37, 'Cargo', 'Profecion', 'Especialidad', 'Ocupacion', 1, 1, 'Tipo', 'Estado_', ''),
(2, 12343829, 'alberto', 'alberot', 'jbdkaDKPq ', 2147483647, 'kandkNA@KANDKSAN.ASKDN', 'SS', '20', 30, 'as da,da', 'daldlas`', 'knkandsan', 'm asdna', 1, 1, 'saldalmda;', 'asdmalsdma', './uploads/a8761aa4df53b9ead41d02786f371bcb.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
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
-- Indexes for table `teams`
--
ALTER TABLE `teams`
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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `groups_2`
--
ALTER TABLE `groups_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;