-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 30, 2020 alle 21:17
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
  `main_image` varchar(1000) NOT NULL DEFAULT 'default.png' COMMENT 'url immagine principale',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime creazione',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'datetime ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `article`
--

INSERT INTO `article` (`id`, `content`, `brand`, `model`, `initial_price`, `buy_link`, `launch_date`, `main_image`, `created_at`, `updated_at`) VALUES
(7, 'Xiaomi Mi 10 è indubbiamente uno degli smartphone Android più avanzati e completi disponibili sul mercato, grazie alla ricca dotazione e all\'elevata multimedialità. Dispone di un grande display da 6.67 pollici con una risoluzione di 2340x1080 pixel. Le funzionalità offerte da questo Xiaomi Mi 10 sono veramente tante e all\'avanguardia. A cominciare dal modulo 5G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Xiaomi Mi 10 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 108 megapixel che permette al Xiaomi Mi 10 di scattare foto di alta qualità con una risoluzione di 12000x9000 pixel e di registrare video in 8K alla risoluzione di 7680x4320 pixel. Lo spessore di 9mm è contenuto e rende questo Xiaomi Mi 10 molto interessante.', 'Xiaomi', 'Mi 10', 799.9, 'https://amzn.to/303biKL', '2020-04-06 22:00:00', 'xiaomimi10.jpg', '2020-05-27 12:13:13', '2020-05-30 14:41:36'),
(8, 'Apple iPhone 11 è uno degli smartphone iOS più avanzati e completi che ci siano in circolazione. Dispone di un grande display da 6.1 pollici con una risoluzione di 1792x828 pixel. Le funzionalità offerte da questo Apple iPhone 11 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente. Fotocamera da 12 megapixel ma che permette ugualmente al Apple iPhone 11 di scattare foto di buona qualità con una risoluzione di 4000x3000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 8.3mm è contenuto e rende questo Apple iPhone 11 molto interessante.', 'Apple', 'iPhone 11', 829, 'https://amzn.to/2M9awDD', '2019-09-19 22:00:00', 'iphone11.jpg', '2020-05-27 12:14:22', '2020-05-29 13:43:37'),
(9, 'Samsung Galaxy Note 10 è uno smartphone Android avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un grande display da 6.3 pollici con una risoluzione di 2280x1080 pixel. Le funzionalità offerte da questo Samsung Galaxy Note 10 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nDi tutto rispetto la fotocamera da 12 megapixel che permette al Samsung Galaxy Note 10 di scattare foto con una risoluzione di 4619x3464 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.9mm è veramente contenuto e rende questo Samsung Galaxy Note 10 ancora più spettacolare.', 'Samsung', 'Galaxy Note 10', 979, 'https://amzn.to/2ZT0MFE', '2019-08-21 22:00:00', 'note10.jpg', '2020-05-27 12:14:45', '2020-05-30 16:50:17'),
(10, 'Apple iPhone SE è uno smartphone iOS avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un display da 4.7 pollici con una (ottima) risoluzione di 1334x750 pixel. Le funzionalità offerte da questo Apple iPhone SE sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nDi tutto rispetto la fotocamera da 12 megapixel che permette al Apple iPhone SE di scattare foto con una risoluzione di 4608x2592 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.3mm è veramente contenuto e rende questo Apple iPhone SE ancora più spettacolare.', 'Apple', 'iPhone SE', 499, 'https://amzn.to/2TVWObD', '2020-04-23 22:00:00', 'iphonese.jpg', '2020-05-27 12:17:21', '2020-05-30 15:24:03'),
(11, 'Xiaomi Mi A3 è un smartphone Android di buon livello, fortemente votato all\'imaging, in grado di soddisfare anche l\'utente più esigente. Sorprende il display Touchscreen da 6.08 pollici che pone questo Xiaomi al vertice della categoria. Risoluzione di 1560x720 pixel. Sul versante delle funzionalità a questo Xiaomi Mi A3 non manca davvero nulla. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente, passando per la connettività Wi-fi e il GPS.\r\nQuesto Xiaomi Mi A3 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Xiaomi Mi A3 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 8.5mm è contenuto e rende questo Xiaomi Mi A3 molto interessante.', 'Xiaomi', 'Mi A3', 249, 'https://amzn.to/2yLPh7K', '2019-07-16 22:00:00', 'mia3.jpg', '2020-05-27 12:18:21', '2020-05-30 17:06:42'),
(12, 'Asus ZenFone 6 è indubbiamente uno degli smartphone Android più avanzati e completi disponibili sul mercato, grazie alla ricca dotazione e all\'elevata multimedialità. Dispone di un grande display da 6.4 pollici con una risoluzione di 2340x1080 pixel. Le funzionalità offerte da questo Asus ZenFone 6 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Asus ZenFone 6 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Asus ZenFone 6 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel', 'Asus', 'ZenFone 6', 499, 'https://amzn.to/2Xih9tS', '2019-05-24 22:00:00', 'zenfone6.jpg', '2020-05-27 12:18:51', '2020-05-30 17:17:41'),
(13, 'Huawei P40 Pro è uno smartphone Android con caratteristiche all\'avanguardia che lo rendono una scelta eccellente per ogni tipo di utilizzo. Dispone di un grande display da 6.58 pollici e di una risoluzione da 2640x1200 pixel, fra le più elevate attualmente in circolazione. Le funzionalità offerte da questo Huawei P40 Pro sono innumerevoli e al top di gamma. A cominciare dal modulo 5G che permette un trasferimento dati e una navigazione in internet eccellente, passando per la connettività Wi-fi e il GPS.\r\nQuesto Huawei P40 Pro è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 50 megapixel che permette di scattare foto di alta qualità con una risoluzione di 8060x6200 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 9mm è contenuto e rende questo Huawei P40 Pro molto interessante.', 'Huawei', 'P40 Pro', 1049.9, 'https://amzn.to/2ZSTnpY', '2020-04-06 22:00:00', 'p40pro.jpg', '2020-05-27 12:20:01', '2020-05-30 14:56:43'),
(14, 'Samsung Galaxy A51 è uno smartphone Android avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un grande display da 6.5 pollici con una risoluzione di 2400x1080 pixel. Le funzionalità offerte da questo Samsung Galaxy A51 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Samsung Galaxy A51 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Samsung Galaxy A51 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.9mm è veramente contenuto e rende questo Samsung Galaxy A51 ancora più spettacolare.', 'Samsung', 'Galaxy A71', 379.9, 'https://amzn.to/3ex88Tm', '2019-12-11 23:00:00', 'galaxya51.jpg', '2020-05-27 12:20:01', '2020-05-30 17:36:26');

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
-- Dump dei dati per la tabella `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `updated_at`, `user_id`, `article_id`) VALUES
(27, 'prova', '2020-05-29 16:03:56', '2020-05-29 16:03:56', 17, 8);

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
(21, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', '2020-05-28 10:01:46', '2020-05-28 10:02:02', 1);

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
  `avatar_url` varchar(1000) NOT NULL DEFAULT 'default.png' COMMENT 'url immagine profilo dell''utente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di creazione dell''utente',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'data di ultimo aggiornamento dell''utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('tester', 'tester', 17, 'fdsf@sdfmc.com', 'default.png', '2020-05-27 11:05:02', '2020-05-29 20:00:33'),
('admin', 'admin', 21, 'admin@gmail.com', 'default.png', '2020-05-28 10:01:46', '2020-05-29 22:29:09');

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
(22, 17, 8, '2020-05-29 16:38:13', '2020-05-29 16:38:13', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco del commento', AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco';

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco dell''utente', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo del voto', AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
