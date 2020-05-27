-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 27, 2020 alle 17:26
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tecweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Article`
--

CREATE TABLE `Article` (
  `id` int(11) NOT NULL COMMENT 'identificativo univoco',
  `title` text NOT NULL COMMENT 'titolo articolo',
  `content` text DEFAULT NULL COMMENT 'contentuo testuale',
  `brand` text DEFAULT NULL COMMENT 'marca',
  `model` text DEFAULT NULL COMMENT 'modello',
  `initial_price` float DEFAULT NULL COMMENT 'prezzo iniziale',
  `buy_link` text DEFAULT NULL COMMENT 'link acquisto',
  `launch_date` timestamp NULL DEFAULT NULL COMMENT 'data di lancio',
  `main_image` varchar(1000) NOT NULL COMMENT 'url immagine principale',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Article`
--

INSERT INTO `Article` (`id`, `title`, `content`, `brand`, `model`, `initial_price`, `buy_link`, `launch_date`, `main_image`, `created_at`, `updated_at`) VALUES
(7, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:13:13', '2020-05-27 12:13:13'),
(8, 'Test', 'content', 'alfa romeo', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:14:22', '2020-05-27 12:20:01'),
(9, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:14:45', '2020-05-27 12:14:45'),
(10, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:17:21', '2020-05-27 12:17:21'),
(11, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:18:21', '2020-05-27 12:18:21'),
(12, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:18:51', '2020-05-27 12:18:51'),
(13, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:20:01', '2020-05-27 12:20:01'),
(14, 'Test', 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:20:01', '2020-05-27 12:20:01');

--
-- Trigger `Article`
--
DELIMITER $$
CREATE TRIGGER `updater_med` BEFORE UPDATE ON `Article` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Comment`
--

CREATE TABLE `Comment` (
  `id` int(11) NOT NULL COMMENT 'identificatore univoco del commento',
  `content` text NOT NULL COMMENT 'contenuto testuale del commento',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di creazione del commento',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di ultimo aggiornamento del commento',
  `user_id` int(11) NOT NULL COMMENT 'idenficativo del autore del commento',
  `article_id` int(11) NOT NULL COMMENT 'identificativo dell''articolo del commento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `Comment`
--
DELIMITER $$
CREATE TRIGGER `updater` BEFORE UPDATE ON `Comment` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `FAQ`
--

CREATE TABLE `FAQ` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'identificatore univoco',
  `title` text NOT NULL COMMENT 'titolo elemento faq',
  `content` text NOT NULL COMMENT 'contenuto elemento faq',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `Keychain`
--

CREATE TABLE `Keychain` (
  `user_id` int(11) NOT NULL COMMENT 'identificatore univoco dell''account',
  `username` varchar(250) NOT NULL COMMENT 'username dell''account',
  `password` varchar(64) NOT NULL COMMENT 'password dell''account (sha256)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di creazione dell''account',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di aggiornamento dell''account',
  `can_publish` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'true se questo account è di tipo "amministratore di contenuti", altrimenti false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Keychain`
--

INSERT INTO `Keychain` (`user_id`, `username`, `password`, `created_at`, `updated_at`, `can_publish`) VALUES
(17, 'test', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', '2020-05-27 11:05:02', '2020-05-27 11:05:02', 0);

--
-- Trigger `Keychain`
--
DELIMITER $$
CREATE TRIGGER `updater_key` BEFORE UPDATE ON `Keychain` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `User`
--

CREATE TABLE `User` (
  `name` varchar(250) NOT NULL COMMENT 'nome dell''utente',
  `surname` varchar(250) NOT NULL COMMENT 'cognome dell''utente',
  `id` int(10) UNSIGNED NOT NULL COMMENT 'identificativo univoco dell''utente',
  `email` varchar(150) NOT NULL COMMENT 'email del''utente',
  `avatar_url` varchar(1000) NOT NULL DEFAULT '/assets/images/avatars/default.png' COMMENT 'url immagine profilo dell''utente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di creazione dell''utente',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di ultimo aggiornamento dell''utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `User`
--

INSERT INTO `User` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('tester', 'tester', 17, 'fdsf@sdfmc.com', '/assets/images/avatars/default.png', '2020-05-27 11:05:02', '2020-05-27 11:05:02');

--
-- Trigger `User`
--
DELIMITER $$
CREATE TRIGGER `updater_usr` BEFORE UPDATE ON `User` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Vote`
--

CREATE TABLE `Vote` (
  `id` int(11) NOT NULL COMMENT 'identificativo del voto',
  `user_id` int(11) NOT NULL COMMENT 'identificativo utente che ha votato',
  `article_id` int(11) NOT NULL COMMENT 'identificativo dell''articolo votato',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di ultimo aggiornamento',
  `positive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'true se il voto è positivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Vote`
--

INSERT INTO `Vote` (`id`, `user_id`, `article_id`, `created_at`, `updated_at`, `positive`) VALUES
(10, 17, 10, '2020-05-27 12:28:12', '2020-05-27 12:28:12', 1);

--
-- Trigger `Vote`
--
DELIMITER $$
CREATE TRIGGER `updater_vot` BEFORE UPDATE ON `Vote` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`article_id`);

--
-- Indici per le tabelle `FAQ`
--
ALTER TABLE `FAQ`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Keychain`
--
ALTER TABLE `Keychain`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `Keychain` ADD FULLTEXT KEY `username` (`username`);

--
-- Indici per le tabelle `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id` (`id`);

--
-- Indici per le tabelle `Vote`
--
ALTER TABLE `Vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`article_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Article`
--
ALTER TABLE `Article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco del commento', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `FAQ`
--
ALTER TABLE `FAQ`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco';

--
-- AUTO_INCREMENT per la tabella `User`
--
ALTER TABLE `User`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco dell''utente', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `Vote`
--
ALTER TABLE `Vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo del voto', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
