-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 28 nov 2018 om 15:05
-- Serverversie: 5.7.23
-- PHP-versie: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ddwt18_week2`
--
CREATE DATABASE IF NOT EXISTS `ddwt18_week2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ddwt18_week2`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `seasons` int(11) NOT NULL,
  `abstract` varchar(255) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `series`
--

INSERT INTO `series` (`id`, `name`, `creator`, `seasons`, `abstract`, `user`) VALUES
(1, 'House of Cards', 'Beau Willimon', 6, 'A Congressman works with his equally conniving wife to exact revenge on the people who betrayed him.', 1),
(2, 'Game of Thrones', 'David Benioff', 7, 'Game of Thrones is an American fantasy drama television series created by David Benioff and D. B. Weiss.', 1),
(3, 'House of Cards', 'Beau Willimon', 6, 'A Congressman works with his equally conniving wife to exact revenge on the people who betrayed him.', 1),
(4, 'Game of Thrones', 'David Benioff', 7, 'Game of Thrones is an American fantasy drama television series created by David Benioff and D. B. Weiss.', 1),
(5, 'House of Cards', 'Beau Willimon', 6, 'A Congressman works with his equally conniving wife to exact revenge on the people who betrayed him.', 1),
(6, 'Game of Thrones', 'David Benioff', 7, 'Game of Thrones is an American fantasy drama television series created by David Benioff and D. B. Weiss.', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'martijn1815', '0000', 'Martijn', 'Schendstok');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
