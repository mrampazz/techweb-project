-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 28, 2020 alle 02:00
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
-- Database: `db-techweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL COMMENT 'identificativo univoco',
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
-- Dump dei dati per la tabella `article`
--

INSERT INTO `article` (`id`, `content`, `brand`, `model`, `initial_price`, `buy_link`, `launch_date`, `main_image`, `created_at`, `updated_at`) VALUES
(7, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:13:13', '2020-05-27 12:13:13'),
(8, 'Apple iPhone 11 è uno degli smartphone iOS più avanzati e completi che ci siano in circolazione. Dispone di un grande display da 6.1 pollici con una risoluzione di 1792x828 pixel. Le funzionalità offerte da questo Apple iPhone 11 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente. Fotocamera da 12 megapixel ma che permette ugualmente al Apple iPhone 11 di scattare foto di buona qualità con una risoluzione di 4000x3000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 8.3mm è contenuto e rende questo Apple iPhone 11 molto interessante.', 'Apple', 'iPhone 11', 829, 'https://amzn.to/3bQlAzS', '2019-09-19 22:00:00', 'iphone11.jpg', '2020-05-27 12:14:22', '2020-05-27 23:57:25'),
(9, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:14:45', '2020-05-27 12:14:45'),
(10, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:17:21', '2020-05-27 12:17:21'),
(11, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:18:21', '2020-05-27 12:18:21'),
(12, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:18:51', '2020-05-27 12:18:51'),
(13, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:20:01', '2020-05-27 12:20:01'),
(14, 'content', 'alfa', 'mod', 12.33, 'link', '2020-10-10 00:00:00', 'url', '2020-05-27 12:20:01', '2020-05-27 12:20:01');

--
-- Trigger `article`
--
DELIMITER $$
CREATE TRIGGER `updater_med` BEFORE UPDATE ON `article` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL COMMENT 'identificatore univoco del commento',
  `content` text NOT NULL COMMENT 'contenuto testuale del commento',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di creazione del commento',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di ultimo aggiornamento del commento',
  `user_id` int(11) NOT NULL COMMENT 'idenficativo del autore del commento',
  `article_id` int(11) NOT NULL COMMENT 'identificativo dell''articolo del commento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `comment`
--
DELIMITER $$
CREATE TRIGGER `updater` BEFORE UPDATE ON `comment` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `faq`
--

CREATE TABLE `faq` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'identificatore univoco',
  `title` text NOT NULL COMMENT 'titolo elemento faq',
  `content` text NOT NULL COMMENT 'contenuto elemento faq',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `keychain`
--

CREATE TABLE `keychain` (
  `user_id` int(11) NOT NULL COMMENT 'identificatore univoco dell''account',
  `username` varchar(250) NOT NULL COMMENT 'username dell''account',
  `password` varchar(64) NOT NULL COMMENT 'password dell''account (sha256)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di creazione dell''account',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di aggiornamento dell''account',
  `can_publish` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'true se questo account è di tipo "amministratore di contenuti", altrimenti false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `keychain`
--

INSERT INTO `keychain` (`user_id`, `username`, `password`, `created_at`, `updated_at`, `can_publish`) VALUES
(17, 'test', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', '2020-05-27 11:05:02', '2020-05-27 11:05:02', 0),
(19, 'ads', '049a68c15c0d6e26c8b4a0743e6b87f074864c2fae5983c88956cb2882d608f5', '2020-05-27 23:13:23', '2020-05-27 23:13:23', 0);

--
-- Trigger `keychain`
--
DELIMITER $$
CREATE TRIGGER `updater_key` BEFORE UPDATE ON `keychain` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `name` varchar(250) NOT NULL COMMENT 'nome dell''utente',
  `surname` varchar(250) NOT NULL COMMENT 'cognome dell''utente',
  `id` int(10) UNSIGNED NOT NULL COMMENT 'identificativo univoco dell''utente',
  `email` varchar(150) NOT NULL COMMENT 'email del''utente',
  `avatar_url` varchar(1000) NOT NULL DEFAULT '/assets/images/avatars/default.png' COMMENT 'url immagine profilo dell''utente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di creazione dell''utente',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di ultimo aggiornamento dell''utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('tester', 'tester', 17, 'fdsf@sdfmc.com', '/assets/images/avatars/default.png', '2020-05-27 11:05:02', '2020-05-27 11:05:02');

--
-- Trigger `user`
--
DELIMITER $$
CREATE TRIGGER `updater_usr` BEFORE UPDATE ON `user` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL COMMENT 'identificativo del voto',
  `user_id` int(11) NOT NULL COMMENT 'identificativo utente che ha votato',
  `article_id` int(11) NOT NULL COMMENT 'identificativo dell''articolo votato',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime di ultimo aggiornamento',
  `positive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'true se il voto è positivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `vote`
--

INSERT INTO `vote` (`id`, `user_id`, `article_id`, `created_at`, `updated_at`, `positive`) VALUES
(19, 17, 8, '2020-05-27 23:46:25', '2020-05-27 23:52:01', 1);

--
-- Trigger `vote`
--
DELIMITER $$
CREATE TRIGGER `updater_vot` BEFORE UPDATE ON `vote` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP()
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`article_id`);

--
-- Indici per le tabelle `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `keychain`
--
ALTER TABLE `keychain`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `keychain` ADD FULLTEXT KEY `username` (`username`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id` (`id`);

--
-- Indici per le tabelle `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`article_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco del commento', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco';

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco dell''utente', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo del voto', AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
