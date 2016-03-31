-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 31. Mrz 2016 um 15:32
-- Server-Version: 5.5.42
-- PHP-Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `intranet`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `email`
--

CREATE TABLE `email` (
  `user_id` int(255) NOT NULL,
  `mail_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `email`
--

INSERT INTO `email` (`user_id`, `mail_address`) VALUES
(19, 'a@e.com'),
(19, 'b@e.com'),
(713, 'cwright0@evilcorp.com'),
(714, 'pwallace1@evilcorp.com'),
(715, 'cthomas2@evilcorp.com'),
(716, 'jramos3@evilcorp.com'),
(717, 'jedwards4@evilcorp.com'),
(718, 'nhawkins5@evilcorp.com'),
(719, 'vbishop6@evilcorp.com'),
(720, 'drichards7@evilcorp.com'),
(721, 'pburton8@evilcorp.com'),
(722, 'wclark9@evilcorp.com'),
(723, 'awebba@evilcorp.com'),
(724, 'rgibsonb@evilcorp.com'),
(725, 'wlongc@evilcorp.com'),
(726, 'sgreend@evilcorp.com'),
(727, 'mmeyere@evilcorp.com'),
(728, 'rbarnesf@evilcorp.com'),
(729, 'dlongg@evilcorp.com'),
(730, 'asmithh@evilcorp.com'),
(731, 'afernandezi@evilcorp.com'),
(732, 'sharrisj@evilcorp.com'),
(733, 'cramosk@evilcorp.com'),
(734, 'cdavisl@evilcorp.com'),
(735, 'jmontgomerym@evilcorp.com'),
(736, 'bcunninghamn@evilcorp.com'),
(737, 'arichardsono@evilcorp.com'),
(738, 'jwoodp@evilcorp.com'),
(739, 'pruizq@evilcorp.com'),
(740, 'tholmesr@evilcorp.com'),
(741, 'cmedinas@evilcorp.com'),
(742, 'twagnert@evilcorp.com'),
(743, 'kberryu@evilcorp.com'),
(744, 'jnguyenv@evilcorp.com'),
(745, 'lpalmerw@evilcorp.com'),
(746, 'hlanex@evilcorp.com'),
(747, 'dfreemany@evilcorp.com'),
(748, 'ahuntz@evilcorp.com'),
(749, 'jmorgan10@evilcorp.com'),
(750, 'wflores11@evilcorp.com'),
(751, 'jbrooks12@evilcorp.com'),
(752, 'sflores13@evilcorp.com'),
(753, 'jryan14@evilcorp.com'),
(754, 'wking15@evilcorp.com'),
(755, 'dreid16@evilcorp.com'),
(756, 'jweaver17@evilcorp.com'),
(757, 'dhart18@evilcorp.com'),
(758, 'grogers19@evilcorp.com'),
(759, 'sgomez1a@evilcorp.com'),
(760, 'awatkins1b@evilcorp.com'),
(761, 'cday1c@evilcorp.com'),
(762, 'amiller1d@evilcorp.com'),
(763, 'tjohnson1e@evilcorp.com'),
(764, 'spatterson1f@evilcorp.com'),
(765, 'gwatson1g@evilcorp.com'),
(766, 'chenderson1h@evilcorp.com'),
(767, 'jrobertson1i@evilcorp.com'),
(768, 'cmorgan1j@evilcorp.com'),
(769, 'pdavis1k@evilcorp.com'),
(770, 'sking1l@evilcorp.com'),
(771, 'wperry1m@evilcorp.com'),
(772, 'lortiz1n@evilcorp.com'),
(773, 'eford1o@evilcorp.com'),
(774, 'efox1p@evilcorp.com'),
(775, 'nfox1q@evilcorp.com'),
(776, 'eramos1r@evilcorp.com'),
(777, 'fwillis1s@evilcorp.com'),
(778, 'lhanson1t@evilcorp.com'),
(779, 'dharper1u@evilcorp.com'),
(780, 'rcox1v@evilcorp.com'),
(781, 'jcollins1w@evilcorp.com'),
(782, 'dgreene1x@evilcorp.com'),
(783, 'cmorales1y@evilcorp.com'),
(784, 'hperez1z@evilcorp.com'),
(785, 'amatthews20@evilcorp.com'),
(786, 'egriffin21@evilcorp.com'),
(787, 'showell22@evilcorp.com'),
(788, 'lnguyen23@evilcorp.com'),
(789, 'mstone24@evilcorp.com'),
(790, 'cchavez25@evilcorp.com'),
(791, 'mbryant26@evilcorp.com'),
(792, 'afernandez27@evilcorp.com'),
(793, 'achavez28@evilcorp.com'),
(794, 'gfuller29@evilcorp.com'),
(795, 'ssullivan2a@evilcorp.com'),
(796, 'dkennedy2b@evilcorp.com'),
(797, 'ffowler2c@evilcorp.com'),
(798, 'rharvey2d@evilcorp.com'),
(799, 'baustin2e@evilcorp.com'),
(800, 'rhicks2f@evilcorp.com'),
(801, 'hpeters2g@evilcorp.com'),
(802, 'elane2h@evilcorp.com'),
(803, 'lcarter2i@evilcorp.com'),
(804, 'scampbell2j@evilcorp.com'),
(805, 'scarr2k@evilcorp.com'),
(806, 'sharvey2l@evilcorp.com'),
(807, 'rbryant2m@evilcorp.com'),
(808, 'jmartinez2n@evilcorp.com'),
(809, 'ldiaz2o@evilcorp.com'),
(810, 'lday2p@evilcorp.com'),
(811, 'wtucker2q@evilcorp.com'),
(812, 'ngonzalez2r@evilcorp.com');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`user_id`,`mail_address`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
