-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Ott 24, 2023 alle 09:39
-- Versione del server: 5.7.42-0ubuntu0.18.04.1
-- Versione PHP: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvcmy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accessi`
--

CREATE TABLE `accessi` (
  `id_accesso` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` char(20) NOT NULL,
  `data` char(10) NOT NULL,
  `ora` char(8) NOT NULL,
  `id_utente` int(10) UNSIGNED NOT NULL,
  `user_agent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Struttura della tabella `impostazioni`
--

CREATE TABLE `impostazioni` (
  `id_imp` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `smtp_host` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `smtp_port` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `smtp_user` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `smtp_psw` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `smtp_from` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `smtp_nome` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bcc` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `impostazioni`
--

INSERT INTO `impostazioni` (`id_imp`, `data_creazione`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_psw`, `smtp_from`, `smtp_nome`, `bcc`) VALUES
(1, '2017-11-05 16:27:09', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `log_email`
--

CREATE TABLE `log_email` (
  `id_log_mail` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_azienda` int(10) UNSIGNED NOT NULL,
  `inviata_a` varchar(200) CHARACTER SET utf8 NOT NULL,
  `inviata_a_nome` varchar(200) CHARACTER SET utf8 NOT NULL,
  `titolo` varchar(200) CHARACTER SET utf8 NOT NULL,
  `oggetto` varchar(200) CHARACTER SET utf8 NOT NULL,
  `testo` text CHARACTER SET utf8 NOT NULL,
  `inviata` enum('Y','N') NOT NULL DEFAULT 'N',
  `tipo` varchar(50) NOT NULL DEFAULT 'ACCOUNT',
  `id_tabella` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `permessi`
--

CREATE TABLE `permessi` (
  `id_permesso` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titolo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ordine` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `permessi`
--

INSERT INTO `permessi` (`id_permesso`, `data_creazione`, `titolo`, `ordine`) VALUES
(1, '2020-10-26 10:14:16', 'Admin', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `revisioni`
--

CREATE TABLE `revisioni` (
  `id_revisione` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_modifica` date NOT NULL,
  `descrizione` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `titolo` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `azione` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `tabella` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `id_tabella` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_utente` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nome_utente` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ruolo_utente` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `json` text CHARACTER SET utf8 NOT NULL,
  `model` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `visibile` char(1) NOT NULL DEFAULT '',
  `id_azienda` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_anagrafica` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tipo` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `revisioni_utenti`
--

CREATE TABLE `revisioni_utenti` (
  `id_revisione_utente` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_revisione` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_utente` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sessioni`
--

CREATE TABLE `sessioni` (
  `uid` char(32) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` char(32) NOT NULL,
  `id_utente` int(10) UNSIGNED NOT NULL,
  `creation_date` int(10) UNSIGNED NOT NULL,
  `user_agent` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `traduzioni`
--

CREATE TABLE `traduzioni` (
  `id_t` int(10) UNSIGNED NOT NULL,
  `chiave` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `valore` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `lingua` char(2) NOT NULL DEFAULT 'it'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(10) UNSIGNED NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(80) NOT NULL,
  `password` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_failure` int(10) UNSIGNED NOT NULL,
  `attivo` enum('Y','N') NOT NULL DEFAULT 'Y',
  `nome` varchar(255) NOT NULL DEFAULT '',
  `cognome` varchar(255) NOT NULL DEFAULT '',
  `ordine` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_azienda` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `data_creazione`, `email`, `password`, `last_failure`, `attivo`, `nome`, `cognome`, `ordine`, `id_azienda`) VALUES
(1, '2017-11-02 16:15:50', 'admin@admin.it', '$2y$10$dEOLKxagtDr65EkbpDpeye3CEfk/OAeWQJKIr5ssaI6qvh6vLdSbO', 1698133711, 'Y', 'Admin', 'Admin', 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_permessi`
--

CREATE TABLE `utenti_permessi` (
  `id_utente_permesso` int(10) UNSIGNED NOT NULL,
  `id_utente` int(10) UNSIGNED NOT NULL,
  `id_permesso` int(10) UNSIGNED NOT NULL,
  `modifica` enum('Y','N') NOT NULL DEFAULT 'N',
  `ordine` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti_permessi`
--

INSERT INTO `utenti_permessi` (`id_utente_permesso`, `id_utente`, `id_permesso`, `modifica`, `ordine`) VALUES
(1, 1, 1, 'Y', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accessi`
--
ALTER TABLE `accessi`
  ADD PRIMARY KEY (`id_accesso`);

--
-- Indici per le tabelle `impostazioni`
--
ALTER TABLE `impostazioni`
  ADD PRIMARY KEY (`id_imp`);

--
-- Indici per le tabelle `log_email`
--
ALTER TABLE `log_email`
  ADD PRIMARY KEY (`id_log_mail`);

--
-- Indici per le tabelle `permessi`
--
ALTER TABLE `permessi`
  ADD PRIMARY KEY (`id_permesso`);

--
-- Indici per le tabelle `revisioni`
--
ALTER TABLE `revisioni`
  ADD PRIMARY KEY (`id_revisione`);

--
-- Indici per le tabelle `revisioni_utenti`
--
ALTER TABLE `revisioni_utenti`
  ADD PRIMARY KEY (`id_revisione_utente`),
  ADD UNIQUE KEY `id_revisione` (`id_revisione`,`id_utente`);

--
-- Indici per le tabelle `sessioni`
--
ALTER TABLE `sessioni`
  ADD KEY `uid` (`uid`);

--
-- Indici per le tabelle `traduzioni`
--
ALTER TABLE `traduzioni`
  ADD PRIMARY KEY (`id_t`),
  ADD UNIQUE KEY `chiave` (`chiave`,`lingua`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`,`password`);

--
-- Indici per le tabelle `utenti_permessi`
--
ALTER TABLE `utenti_permessi`
  ADD PRIMARY KEY (`id_utente_permesso`),
  ADD UNIQUE KEY `id_permesso` (`id_permesso`,`id_utente`),
  ADD KEY `utenti_fky` (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accessi`
--
ALTER TABLE `accessi`
  MODIFY `id_accesso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `impostazioni`
--
ALTER TABLE `impostazioni`
  MODIFY `id_imp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `log_email`
--
ALTER TABLE `log_email`
  MODIFY `id_log_mail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `permessi`
--
ALTER TABLE `permessi`
  MODIFY `id_permesso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `revisioni`
--
ALTER TABLE `revisioni`
  MODIFY `id_revisione` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `revisioni_utenti`
--
ALTER TABLE `revisioni_utenti`
  MODIFY `id_revisione_utente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `traduzioni`
--
ALTER TABLE `traduzioni`
  MODIFY `id_t` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `utenti_permessi`
--
ALTER TABLE `utenti_permessi`
  MODIFY `id_utente_permesso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `utenti_permessi`
--
ALTER TABLE `utenti_permessi`
  ADD CONSTRAINT `utenti_permessi_ibfk_1` FOREIGN KEY (`id_permesso`) REFERENCES `permessi` (`id_permesso`),
  ADD CONSTRAINT `utenti_permessi_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
