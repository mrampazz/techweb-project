-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Giu 07, 2020 alle 16:54
-- Versione del server: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- Versione PHP: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gciulei`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Article`
--

CREATE TABLE `Article` (
  `id` int(11) NOT NULL COMMENT 'identificativo univoco',
  `content` text COMMENT 'contentuo testuale',
  `brand` text COMMENT 'marca',
  `model` text COMMENT 'modello',
  `initial_price` float DEFAULT NULL COMMENT 'prezzo iniziale',
  `buy_link` text COMMENT 'link acquisto',
  `launch_date` timestamp NULL DEFAULT NULL COMMENT 'data di lancio',
  `main_image` varchar(1000) NOT NULL DEFAULT 'default.png' COMMENT 'url immagine principale',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime creazione',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Article`
--

INSERT INTO `Article` (`id`, `content`, `brand`, `model`, `initial_price`, `buy_link`, `launch_date`, `main_image`, `created_at`, `updated_at`) VALUES
(7, 'Xiaomi Mi 10 è indubbiamente uno degli smartphone Android più avanzati e completi disponibili sul mercato, grazie alla ricca dotazione e all&#039;elevata multimedialità. Dispone di un grande display da 6.67 pollici con una risoluzione di 2340x1080 pixel. Le funzionalità offerte da questo Xiaomi Mi 10 sono veramente tante e all&#039;avanguardia. A cominciare dal modulo 5G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Xiaomi Mi 10 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 108 megapixel che permette al Xiaomi Mi 10 di scattare foto di alta qualità con una risoluzione di 12000x9000 pixel e di registrare video in 8K alla risoluzione di 7680x4320 pixel. Lo spessore di 9mm è contenuto e rende questo Xiaomi Mi 10 molto interessante.', 'Xiaomi', 'Mi 10', 799.9, 'https://amzn.to/303biKL', '2020-04-06 00:00:00', 'xiaomimi10.jpg', '2020-05-27 12:13:13', '2020-06-07 16:49:04'),
(8, 'Apple iPhone 11 è uno degli smartphone iOS più avanzati e completi che ci siano in circolazione. Dispone di un grande display da 6.1 pollici con una risoluzione di 1792x828 pixel. Le funzionalità offerte da questo Apple iPhone 11 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente. Fotocamera da 12 megapixel ma che permette ugualmente al Apple iPhone 11 di scattare foto di buona qualità con una risoluzione di 4000x3000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 8.3mm è contenuto e rende questo Apple iPhone 11 molto interessante.', 'Apple', 'iPhone 11', 829, 'https://amzn.to/2M9awDD', '2019-09-19 22:00:00', 'iphone11.jpg', '2020-05-27 12:14:22', '2020-05-29 13:43:37'),
(9, 'Samsung Galaxy Note 10 è uno smartphone Android avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un grande display da 6.3 pollici con una risoluzione di 2280x1080 pixel. Le funzionalità offerte da questo Samsung Galaxy Note 10 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nDi tutto rispetto la fotocamera da 12 megapixel che permette al Samsung Galaxy Note 10 di scattare foto con una risoluzione di 4619x3464 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.9mm è veramente contenuto e rende questo Samsung Galaxy Note 10 ancora più spettacolare.', 'Samsung', 'Galaxy Note 10', 979, 'https://amzn.to/2ZT0MFE', '2019-08-21 22:00:00', 'note10.jpg', '2020-05-27 12:14:45', '2020-05-30 16:50:17'),
(10, 'Apple iPhone SE è uno smartphone iOS avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un display da 4.7 pollici con una (ottima) risoluzione di 1334x750 pixel. Le funzionalità offerte da questo Apple iPhone SE sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nDi tutto rispetto la fotocamera da 12 megapixel che permette al Apple iPhone SE di scattare foto con una risoluzione di 4608x2592 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.3mm è veramente contenuto e rende questo Apple iPhone SE ancora più spettacolare.', 'Apple', 'iPhone SE', 499, 'https://amzn.to/2TVWObD', '2020-04-23 22:00:00', 'iphonese.jpg', '2020-05-27 12:17:21', '2020-05-30 15:24:03'),
(11, 'Xiaomi Mi A3 è un smartphone Android di buon livello, fortemente votato all\'imaging, in grado di soddisfare anche l\'utente più esigente. Sorprende il display Touchscreen da 6.08 pollici che pone questo Xiaomi al vertice della categoria. Risoluzione di 1560x720 pixel. Sul versante delle funzionalità a questo Xiaomi Mi A3 non manca davvero nulla. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente, passando per la connettività Wi-fi e il GPS.\r\nQuesto Xiaomi Mi A3 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Xiaomi Mi A3 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 8.5mm è contenuto e rende questo Xiaomi Mi A3 molto interessante.', 'Xiaomi', 'Mi A3', 249, 'https://amzn.to/2yLPh7K', '2019-07-16 22:00:00', 'mia3.jpg', '2020-05-27 12:18:21', '2020-05-30 17:06:42'),
(12, 'Asus ZenFone 6 è indubbiamente uno degli smartphone Android più avanzati e completi disponibili sul mercato, grazie alla ricca dotazione e all\'elevata multimedialità. Dispone di un grande display da 6.4 pollici con una risoluzione di 2340x1080 pixel. Le funzionalità offerte da questo Asus ZenFone 6 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Asus ZenFone 6 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Asus ZenFone 6 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel', 'Asus', 'ZenFone 6', 499, 'https://amzn.to/2Xih9tS', '2019-05-24 22:00:00', 'zenfone6.jpg', '2020-05-27 12:18:51', '2020-05-30 17:17:41'),
(13, 'Huawei P40 Pro è uno smartphone Android con caratteristiche all&#039;avanguardia che lo rendono una scelta eccellente per ogni tipo di utilizzo. Dispone di un grande display da 6.58 pollici e di una risoluzione da 2640x1200 pixel, fra le più elevate attualmente in circolazione. Le funzionalità offerte da questo Huawei P40 Pro sono innumerevoli e al top di gamma. A cominciare dal modulo 5G che permette un trasferimento dati e una navigazione in internet eccellente, passando per la connettività Wi-fi e il GPS.\r\nQuesto Huawei P40 Pro è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 50 megapixel che permette di scattare foto di alta qualità con una risoluzione di 8060x6200 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 9mm è contenuto e rende questo Huawei P40 Pro molto interessante.', 'Huawei', 'P40 Pro', 1049.9, 'https://amzn.to/2ZSTnpY', '2020-04-06 00:00:00', 'p40pro.jpg', '2020-05-27 12:20:01', '2020-06-07 16:40:49'),
(14, 'Samsung Galaxy A51 è uno smartphone Android avanzato e completo sotto tutti i punti di vista con alcune eccellenze. Dispone di un grande display da 6.5 pollici con una risoluzione di 2400x1080 pixel. Le funzionalità offerte da questo Samsung Galaxy A51 sono veramente tante e all\'avanguardia. A cominciare dal modulo LTE 4G che permette un trasferimento dati e una navigazione in internet eccellente.\r\nQuesto Samsung Galaxy A51 è un prodotto con pochi competitor per ciò che riguarda la multimedialità grazie alla fotocamera da ben 48 megapixel che permette al Samsung Galaxy A51 di scattare foto di alta qualità con una risoluzione di 8000x6000 pixel e di registrare video in 4K alla risoluzione di 3840x2160 pixel. Lo spessore di 7.9mm è veramente contenuto e rende questo Samsung Galaxy A51 ancora più spettacolare.', 'Samsung', 'Galaxy A71', 379.9, 'https://amzn.to/3ex88Tm', '2019-12-11 23:00:00', 'galaxya51.jpg', '2020-05-27 12:20:01', '2020-05-30 17:36:26');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime di creazione del commento',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime di ultimo aggiornamento del commento',
  `user_id` int(11) NOT NULL COMMENT 'idenficativo del autore del commento',
  `article_id` int(11) NOT NULL COMMENT 'identificativo dell''articolo del commento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Comment`
--

INSERT INTO `Comment` (`id`, `content`, `created_at`, `updated_at`, `user_id`, `article_id`) VALUES
(1, 'Seppur valido, la mancanza dei servizi google si fa sentire...', '2020-06-07 16:35:51', '2020-06-07 16:35:51', 23, 13);

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data ultimo aggiornamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `FAQ`
--

INSERT INTO `FAQ` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'È possibile eliminare il mio profilo?', 'Attualmente l’unico modo per far si che il tuo profilo venga completamente eliminato dal sito è contattare un amministratore (vedi riferimento a piè pagina). Ma non esitare, sono disponibili e molto veloci nella risposta!', '2020-06-05 08:55:19', '2020-06-05 08:55:19'),
(2, 'Quante recensioni posso lasciare?', 'Non vi è alcun limite in vigore se non quello dettato dal buon senso, aiuta gli altri utenti a sapere di più del telefono con quante recensioni ritieni necessario! Ricorda: non esagerare.', '2020-06-05 08:55:19', '2020-06-05 08:55:19'),
(3, 'È possibile modificare le informazioni relative al mio profilo?', 'Semplicemente recandoti nella pagina \"Il mio profilo\", hai a disposizioni alcune informazioni modificabili quali: nome, cognome e foto. Queste corrispondo anche alle informazioni pubbliche visibili a tutti gli altri utenti.', '2020-06-05 08:55:19', '2020-06-05 08:55:19'),
(4, 'Chi può vedere le mie recensioni?', 'Essendo l’obbiettivo del sito quello di fornire chiarezza e consigli da parte degli utenti che hanno realmente maneggiato il cellulare in questione, le recensioni lasciate da qualsiasi utente sono visibili a tutti.', '2020-06-05 08:55:19', '2020-06-05 08:55:19'),
(5, 'È possibile modificare un voto che ho lasciato?', 'Il nostro sito ha preso in considerazione la possibilità che un telefono possa non suscitare lo stesso effetto a distanza di qualche giorno. Per questo motivo ti è concesso non solo di cambiare il voto che hai lasciato ma anche eliminare un tuo commento.', '2020-06-05 08:55:19', '2020-06-05 08:55:19'),
(6, 'Chi si occupa dell’inserimento dei telefoni e dei dettagli?', 'Per poter garantire affidabilità nelle informazioni fornite, l’inserimento di un dispositivo mobile e i dettagli ad esso associati vengono inseriti da un team di amministratori preparati in materia. Nel caso in cui volessi farne parte o ritieni manchi qualche telefono puoi contattarci! Prenderemo in seria considerazione la tua proposta.', '2020-06-05 08:55:19', '2020-06-05 08:55:19');

-- --------------------------------------------------------

--
-- Struttura della tabella `Keychain`
--

CREATE TABLE `Keychain` (
  `user_id` int(11) NOT NULL COMMENT 'identificatore univoco dell''account',
  `username` text NOT NULL COMMENT 'username dell''account',
  `password` varchar(64) NOT NULL COMMENT 'password dell''account (sha256)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data di creazione dell''account',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data di aggiornamento dell''account',
  `can_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'true se questo account è di tipo "amministratore di contenuti", altrimenti false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Keychain`
--

INSERT INTO `Keychain` (`user_id`, `username`, `password`, `created_at`, `updated_at`, `can_publish`) VALUES
(17, 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', '2020-05-27 11:05:02', '2020-05-31 09:33:37', 0),
(21, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '2020-05-28 10:01:46', '2020-05-31 09:30:32', 1),
(23, 'simobianchi', '83d281989cd5d94daccd32a3a2fb7416c292eb97025349e2474cdce28ec41565', '2020-06-07 16:34:29', '2020-06-07 16:34:29', 0);

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
  `avatar_url` varchar(1000) NOT NULL DEFAULT 'default.png' COMMENT 'url immagine profilo dell''utente',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data di creazione dell''utente',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data di ultimo aggiornamento dell''utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `User`
--

INSERT INTO `User` (`name`, `surname`, `id`, `email`, `avatar_url`, `created_at`, `updated_at`) VALUES
('Mario', 'Rossi', 17, 'user@gmail.com', 'fBYLQIBxgS.png', '2020-05-27 11:05:02', '2020-06-07 15:56:16'),
('admin', 'admin', 21, 'admin@gmail.com', 'admin.png', '2020-05-28 10:01:46', '2020-06-07 10:58:10'),
('Simone', 'Bianchi', 23, 'simonebianchi@gmail.com', 'PRuYsaifSa.png', '2020-06-07 16:34:29', '2020-06-07 16:44:44');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime di creazione',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datetime di ultimo aggiornamento',
  `positive` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'true se il voto è positivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `Vote`
--

INSERT INTO `Vote` (`id`, `user_id`, `article_id`, `created_at`, `updated_at`, `positive`) VALUES
(23, 17, 8, '2020-06-02 14:52:20', '2020-06-02 15:22:36', 1),
(37, 17, 7, '2020-06-06 14:06:09', '2020-06-06 14:06:09', 1),
(39, 21, 49, '2020-06-06 21:36:39', '2020-06-06 21:36:39', 1),
(46, 17, 13, '2020-06-07 09:56:50', '2020-06-07 13:12:43', 1),
(47, 21, 11, '2020-06-07 14:25:22', '2020-06-07 14:25:22', 1),
(52, 17, 9, '2020-06-07 15:01:24', '2020-06-07 15:01:24', 1),
(53, 17, 10, '2020-06-07 15:01:32', '2020-06-07 15:01:32', 0),
(54, 17, 14, '2020-06-07 15:01:34', '2020-06-07 15:01:34', 0),
(55, 48, 9, '2020-06-07 15:02:59', '2020-06-07 15:02:59', 1),
(56, 48, 13, '2020-06-07 15:03:18', '2020-06-07 15:03:18', 0),
(57, 0, 13, '2020-06-07 16:21:10', '2020-06-07 16:21:10', 1),
(58, 23, 13, '2020-06-07 16:34:41', '2020-06-07 16:34:41', 0),
(59, 23, 9, '2020-06-07 16:36:10', '2020-06-07 16:36:10', 1),
(60, 23, 10, '2020-06-07 16:36:39', '2020-06-07 16:36:39', 0),
(61, 23, 12, '2020-06-07 16:36:56', '2020-06-07 16:36:56', 1),
(62, 23, 11, '2020-06-07 16:37:04', '2020-06-07 16:37:04', 1),
(65, 23, 8, '2020-06-07 16:37:43', '2020-06-07 16:37:43', 1);

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
  ADD PRIMARY KEY (`user_id`);

--
-- Indici per le tabelle `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `Vote`
--
ALTER TABLE `Vote`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Article`
--
ALTER TABLE `Article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco', AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT per la tabella `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco del commento', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `FAQ`
--
ALTER TABLE `FAQ`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificatore univoco', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `User`
--
ALTER TABLE `User`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificativo univoco dell''utente', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT per la tabella `Vote`
--
ALTER TABLE `Vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificativo del voto', AUTO_INCREMENT=67;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
