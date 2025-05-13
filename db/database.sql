SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `ankete`
--

CREATE TABLE `ankete` (
  `idAnketa` int(11) NOT NULL,
  `pitanjeAnketa` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `aktivnaAnketa` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ankete`
--

INSERT INTO `ankete` (`idAnketa`, `pitanjeAnketa`, `aktivnaAnketa`) VALUES
(1, 'Survey question 1?', 0),
(2, 'Survey question 2?', 1),
(3, 'Survey question 3?', 0);

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `idFooter` int(11) NOT NULL,
  `nazivFooter` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `linkFooter` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`idFooter`, `nazivFooter`, `linkFooter`) VALUES
(1, 'Contact Us', 'kontakt.php');

-- --------------------------------------------------------

--
-- Table structure for table `kontakt`
--

CREATE TABLE `kontakt` (
  `idKontakt` int(11) NOT NULL,
  `naslovKontakt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mailKontakt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `textKontakt` text COLLATE utf8_unicode_ci NOT NULL,
  `datumKontakt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `idKorisnik` int(11) NOT NULL,
  `userKorisnik` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mailKorisnik` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `passKorisnik` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `roleKorisnik` int(11) NOT NULL,
  `datumRegKorisnik` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`idKorisnik`, `userKorisnik`, `mailKorisnik`, `passKorisnik`, `roleKorisnik`, `datumRegKorisnik`) VALUES
(1, 'admin', 'admin@admin.com', 'admin12345', 1, '2025-04-26 21:48:29'),
(2, 'user123', 'user@user.com', 'user12345', 2, '2025-05-07 14:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboards`
--

CREATE TABLE `leaderboards` (
  `idLead` int(11) NOT NULL,
  `idRunner` int(11) NOT NULL,
  `vremeLead` time NOT NULL,
  `linkLead` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meni`
--

CREATE TABLE `meni` (
  `idMeni` int(11) NOT NULL,
  `nazivMeni` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `linkMeni` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `loggedMeni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meni`
--

INSERT INTO `meni` (`idMeni`, `nazivMeni`, `linkMeni`, `loggedMeni`) VALUES
(1, 'Leaderboards', 'leaderboards.php', 0),
(2, 'Trkaci', 'trkaci.php', 0),
(3, 'Prijavi Vreme', 'prijava.php', 1),
(4, 'Anketa', 'anketa.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `odgovori`
--

CREATE TABLE `odgovori` (
  `idOdgovor` int(11) NOT NULL,
  `idAnketa` int(11) NOT NULL,
  `odgovorAnketa` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `odgovori`
--

INSERT INTO `odgovori` (`idOdgovor`, `idAnketa`, `odgovorAnketa`) VALUES
(1, 1, 'Response 1 for Survey 1!'),
(2, 1, 'Response 2 for Survey 1!'),
(3, 2, 'Response 1 for Survey 2!'),
(4, 2, 'Response 2 for Survey 2!'),
(5, 3, 'Response 1 for Survey 3!'),
(6, 3, 'Response 2 for Survey 3!');

-- --------------------------------------------------------

--
-- Table structure for table `prijave`
--

CREATE TABLE `prijave` (
  `idPrijava` int(11) NOT NULL,
  `idKorisnik` int(11) NOT NULL,
  `vreme` time NOT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `komentar` text COLLATE utf8_unicode_ci NOT NULL,
  `odobreno` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rezultati`
--

CREATE TABLE `rezultati` (
  `idRezultat` int(11) NOT NULL,
  `idAnketa` int(11) NOT NULL,
  `idOdgovor` int(11) NOT NULL,
  `idKorisnik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `idRole` int(11) NOT NULL,
  `nazivRole` varchar(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`idRole`, `nazivRole`) VALUES
(1, 'admin'),
(2, 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `trkaci`
--

CREATE TABLE `trkaci` (
  `idTrkac` int(11) NOT NULL,
  `imeTrkac` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `slikaTrkac` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `altSlikaTrkac` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `velicinaSlikaTrkac` int(15) NOT NULL,
  `tipSlikaTrkac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `opisTrkac` text COLLATE utf8_unicode_ci NOT NULL,
  `link1Trkac` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `trkaci`
--

INSERT INTO `trkaci` (`idTrkac`, `imeTrkac`, `slikaTrkac`, `altSlikaTrkac`, `velicinaSlikaTrkac`, `tipSlikaTrkac`, `opisTrkac`, `link1Trkac`) VALUES
(1, 'Dummy Runner 1', 'slike/1615127672_dist.JPG', 'imgalt1', 22143, 'image/jpeg', 'Short description about runner 1!', '#'),
(2, 'Dummy Runner 2', 'slike/1615127672_dist.JPG', 'imgalt2', 22143, 'image/jpeg', 'Short description about runner 2!', '#'),
(3, 'Dummy Runner 3', 'slike/1615127672_dist.JPG', 'imgalt3', 22143, 'image/jpeg', 'Short description about runner 3!', '#'),
(4, 'Dummy Runner 4', 'slike/1615127672_dist.JPG', 'imgalt4', 22143, 'image/jpeg', 'Short description about runner 4!', '#');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ankete`
--
ALTER TABLE `ankete`
  ADD PRIMARY KEY (`idAnketa`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`idFooter`);

--
-- Indexes for table `kontakt`
--
ALTER TABLE `kontakt`
  ADD PRIMARY KEY (`idKontakt`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`idKorisnik`),
  ADD UNIQUE KEY `userKorisnik` (`userKorisnik`),
  ADD UNIQUE KEY `mailKorisnik` (`mailKorisnik`),
  ADD KEY `roleKorisnik` (`roleKorisnik`);

--
-- Indexes for table `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD PRIMARY KEY (`idLead`),
  ADD KEY `idRunner` (`idRunner`);

--
-- Indexes for table `meni`
--
ALTER TABLE `meni`
  ADD PRIMARY KEY (`idMeni`);

--
-- Indexes for table `odgovori`
--
ALTER TABLE `odgovori`
  ADD PRIMARY KEY (`idOdgovor`),
  ADD KEY `idAnketa` (`idAnketa`);

--
-- Indexes for table `prijave`
--
ALTER TABLE `prijave`
  ADD PRIMARY KEY (`idPrijava`),
  ADD KEY `idKorisnik` (`idKorisnik`);

--
-- Indexes for table `rezultati`
--
ALTER TABLE `rezultati`
  ADD PRIMARY KEY (`idRezultat`),
  ADD KEY `idAnketa` (`idAnketa`),
  ADD KEY `idOdgovor` (`idOdgovor`),
  ADD KEY `idKorisnik` (`idKorisnik`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `trkaci`
--
ALTER TABLE `trkaci`
  ADD PRIMARY KEY (`idTrkac`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ankete`
--
ALTER TABLE `ankete`
  MODIFY `idAnketa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `idFooter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kontakt`
--
ALTER TABLE `kontakt`
  MODIFY `idKontakt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `idKorisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaderboards`
--
ALTER TABLE `leaderboards`
  MODIFY `idLead` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `meni`
--
ALTER TABLE `meni`
  MODIFY `idMeni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `odgovori`
--
ALTER TABLE `odgovori`
  MODIFY `idOdgovor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prijave`
--
ALTER TABLE `prijave`
  MODIFY `idPrijava` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `rezultati`
--
ALTER TABLE `rezultati`
  MODIFY `idRezultat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trkaci`
--
ALTER TABLE `trkaci`
  MODIFY `idTrkac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`roleKorisnik`) REFERENCES `roles` (`idRole`);

--
-- Constraints for table `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD CONSTRAINT `leaderboards_ibfk_1` FOREIGN KEY (`idRunner`) REFERENCES `korisnici` (`idKorisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovori`
--
ALTER TABLE `odgovori`
  ADD CONSTRAINT `odgovori_ibfk_1` FOREIGN KEY (`idAnketa`) REFERENCES `ankete` (`idAnketa`);

--
-- Constraints for table `prijave`
--
ALTER TABLE `prijave`
  ADD CONSTRAINT `prijave_ibfk_1` FOREIGN KEY (`idKorisnik`) REFERENCES `korisnici` (`idKorisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rezultati`
--
ALTER TABLE `rezultati`
  ADD CONSTRAINT `rezultati_ibfk_1` FOREIGN KEY (`idOdgovor`) REFERENCES `odgovori` (`idOdgovor`),
  ADD CONSTRAINT `rezultati_ibfk_2` FOREIGN KEY (`idAnketa`) REFERENCES `ankete` (`idAnketa`);
COMMIT;