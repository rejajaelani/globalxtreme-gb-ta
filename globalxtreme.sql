-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 04:25 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globalxtreme`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `Id` int(11) NOT NULL,
  `Nama_jenis` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`Id`, `Nama_jenis`) VALUES
(3, 'Donat'),
(5, 'Mie Ayam'),
(6, 'Bakso Edit');

-- --------------------------------------------------------

--
-- Table structure for table `new_lead`
--

CREATE TABLE `new_lead` (
  `Id` varchar(250) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `Fullname` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Phonenumber` text DEFAULT NULL,
  `Email` text DEFAULT NULL,
  `Companyname` text DEFAULT NULL,
  `Companyaddress` text DEFAULT NULL,
  `Companyphonenumber` text DEFAULT NULL,
  `Companyemail` text DEFAULT NULL,
  `Status` text DEFAULT NULL,
  `Probability` text DEFAULT NULL,
  `source` varchar(250) NOT NULL,
  `media` varchar(250) NOT NULL,
  `asigned_to` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_lead`
--

INSERT INTO `new_lead` (`Id`, `id_pengguna`, `Fullname`, `Address`, `Phonenumber`, `Email`, `Companyname`, `Companyaddress`, `Companyphonenumber`, `Companyemail`, `Status`, `Probability`, `source`, `media`, `asigned_to`, `created_at`, `last_update`) VALUES
('LD0001', 1, 'Cora Lindsey', 'In aperiam nisi ad u', '+1 (457) 392-8826', 'vorejyna@mailinator.com', 'Riddle Yang LLC', 'Cote Odom LLC', 'Pearson Justice Trading', 'lunari@mailinator.com', 'Pending', 'Cancel', 'Inbound-Call', 'Call', 0, '2023-09-29', '2023-09-29 00:00:00'),
('LD0002', 6, 'Colby Bailey', 'Enim modi quod offic', '+1 (294) 374-8204', 'moqodeter@mailinator.com', 'Cook Mcmillan Co', 'Mcfadden and Nieves Inc', 'Gregory and Berry LLC', 'voco@mailinator.com', 'NI - Not Interested', 'Pending', 'Other', 'Email', 0, '2023-09-30', '2023-09-29 00:00:00'),
('LD0003', 6, 'Macy Rasmussen', 'Quia totam id conse', '+1 (738) 942-2002', 'hicefyly@mailinator.com', 'Dillon Nixon LLC', 'Campos and Figueroa LLC', 'Chen and Clayton Plc', 'cimazahu@mailinator.com', 'NI - Not Interested', 'Pending', 'Customer Support', 'WA Center', 0, '2023-09-30', '2023-09-29 00:00:00'),
('LD0004', 6, 'Beverly Kirby', 'Adipisicing ullam eo', '+1 (835) 663-5439', 'mele@mailinator.com', 'Snyder and Avila Inc', 'Sawyer Walter Associates', 'Hartman and Goodman Traders', 'reqawifef@mailinator.com', 'FCB - Future Call Back', 'Converted', 'Customer Support', 'Email', 0, '2023-09-30', '2023-09-29 00:00:00'),
('LD0005', 1, 'Kato Cameron', 'Et illum rerum volu', '+1 (377) 897-6491', 'piducuqac@mailinator.com', 'Vincent Newton Trading', 'Curry Osborn LLC', 'Erickson Weaver Inc', 'fose@mailinator.com', 'Scheduled', 'Converted', 'Outbound', 'Call', 0, '2023-10-01', '2023-10-01 06:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `Id` int(11) NOT NULL,
  `Id_jenis` int(11) DEFAULT NULL,
  `Nama_Packages` varchar(250) DEFAULT NULL,
  `Deskripsi` varchar(250) DEFAULT NULL,
  `Harga_jual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`Id`, `Id_jenis`, `Nama_Packages`, `Deskripsi`, `Harga_jual`) VALUES
(4, 5, 'Diskon 50% Edit', '-', 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `Id` int(11) NOT NULL,
  `Nama` varchar(250) DEFAULT NULL,
  `Username` varchar(250) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `Level` varchar(250) DEFAULT NULL,
  `Foto` varchar(250) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `sales_from` varchar(255) DEFAULT NULL,
  `is_login` int(11) DEFAULT NULL,
  `Last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`Id`, `Nama`, `Username`, `Password`, `Level`, `Foto`, `Status`, `Email`, `sales_from`, `is_login`, `Last_login`) VALUES
(1, 'John Doe', 'johndoe', '$2y$10$7RsUjcxn2AaUW2Qov/A4F./IoW/JyP.BVGloPhHSuIqhWNUWeBEry', '2', 'image_6515c5bed8cae.png', 1, 'test@gmail.com', 'Denpasar', 0, '2023-10-07 20:58:58'),
(4, 'Abdul Reja Jaelani', 'admin', '$2y$10$ro59wtJk.cQocT6xiw7/M.K8eYc0SrDXXqX27Yapl4dYQAEfgvOh2', '1', 'image_650d6bbe34ecd.jpg', 1, 'admin@gmail.com', 'Kerobokan', 0, '2023-09-22 18:26:06'),
(6, 'Noel Good', 'mesidez', '$2y$10$MgsK5qf7e4NLv02vL2Ia6.BX2wxHnR6MPb2ISqtm45LwKOAoUbFl.', '3', 'image_651716b86fd49.png', 1, 'test1@gmail.com', NULL, 417, '2023-10-07 21:16:15'),
(7, 'Aphrodite Mcclain', 'qodow', '$2y$10$7WE6BOGGbnAFLLzdnUvV5./LbuxJaMzSC4SFPaHRvCrKvT1aamvZa', '2', 'image_651716e3c768e.png', 1, 'test2@gmail.com', NULL, 0, '2023-09-30 02:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `prospect`
--

CREATE TABLE `prospect` (
  `Id` varchar(250) NOT NULL,
  `Id_newlead` varchar(250) NOT NULL,
  `Prospect_type_cust` text DEFAULT NULL,
  `Note_type_cust` text DEFAULT NULL,
  `Givenname` text DEFAULT NULL,
  `Gender` text DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Surname` text DEFAULT NULL,
  `Religion` text DEFAULT NULL,
  `Hometown` text DEFAULT NULL,
  `Curcity` text DEFAULT NULL,
  `Nationality` text DEFAULT NULL,
  `Curaddress` text DEFAULT NULL,
  `Area` text DEFAULT NULL,
  `Type` text DEFAULT NULL,
  `Mobile` text DEFAULT NULL,
  `home_number` varchar(255) NOT NULL,
  `Id_card_no` int(11) DEFAULT NULL,
  `Passport_no` int(11) DEFAULT NULL,
  `Id_card_foto` text DEFAULT NULL,
  `Passport_foto` text DEFAULT NULL,
  `Streetname` text DEFAULT NULL,
  `Building_type` text DEFAULT NULL,
  `Building_name` text DEFAULT NULL,
  `No` int(11) DEFAULT NULL,
  `Property_ownership_type` text DEFAULT NULL,
  `Location` text DEFAULT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `Id_packages` int(11) DEFAULT NULL,
  `Id_pengguna` int(11) DEFAULT NULL,
  `sales_representativ` int(11) NOT NULL,
  `Lead_telemarketing` int(11) DEFAULT NULL,
  `General_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prospect`
--

INSERT INTO `prospect` (`Id`, `Id_newlead`, `Prospect_type_cust`, `Note_type_cust`, `Givenname`, `Gender`, `Birthday`, `Surname`, `Religion`, `Hometown`, `Curcity`, `Nationality`, `Curaddress`, `Area`, `Type`, `Mobile`, `home_number`, `Id_card_no`, `Passport_no`, `Id_card_foto`, `Passport_foto`, `Streetname`, `Building_type`, `Building_name`, `No`, `Property_ownership_type`, `Location`, `latitude`, `longitude`, `Id_packages`, `Id_pengguna`, `sales_representativ`, `Lead_telemarketing`, `General_note`, `created_at`, `last_update`) VALUES
('PRO0001', 'LD0001', '1', 'Voluptatibus accusan', 'Fatima', 'Female', '2003-10-24', 'Carroll', 'Necessitatibus vel s', 'Quo quia voluptatem', 'Ullamco alias nostru', 'Gibraltar', 'Sit sapiente amet q', 'Eaque sint aspernatu', '3', '+1 (864) 665-6872', '+1 (778) 304-8174', 25, 53, 'e0eb71fb1894f41f.', 'c3aa4ff20f8f526f.', 'Judith Ware', '5', 'Griffin Watts', 562, '5', 'Xanthus Berg', 'Officia dolor blandi', 'Mollitia tempore pa', 4, 1, 4, 4, 'Qui est error sequi ', '2023-09-29 00:00:00', '2023-09-30 02:06:18'),
('PRO0002', 'LD0001', '1', 'Nobis aut repudianda', 'Prescott', 'Female', '1991-04-01', 'Clayton', 'Vitae culpa eius vo', 'Cillum rerum dolorem', 'Placeat numquam non', 'Pakistan', 'Anim ipsa praesenti', 'In reprehenderit be', '4', '+1 (283) 141-2101', '+1 (736) 731-7768', 71, 49, '68966b0782778316.', 'cbec8122d21f3c04.', 'Sean Pearson', '5', 'Jessamine Sargent', 947, '2', 'Ayanna Ferguson', 'Excepturi rerum vel ', 'A impedit et laboru', 4, 1, 1, 1, 'Aut incidunt a omni', '2023-09-29 00:00:00', '2023-09-29 08:04:55'),
('PRO0003', 'LD0002', '1', 'Aut ex voluptatem s', 'Chava', 'Female', '1987-11-07', 'Pitts', 'Repudiandae nostrud ', 'Officia eum magna au', 'Aspernatur illum su', 'Norway', 'Vel tenetur officiis', 'Ut nostrud perspicia', '5', '+1 (513) 883-3483', '+1 (293) 761-1526', 11, 90, 'e0882161bd34ef19.', 'a3a9b98446f1076c.', 'Mercedes Bass', '4', 'Thane Ewing', 871, '2', 'Emery Delgado', 'Nam aut elit quaera', 'Cupidatat magna aut ', 4, 1, 1, 1, 'Ut facilis ad cillum', '2023-01-30 01:57:31', NULL),
('PRO0004', 'LD0001', '2', 'Ullam laborum occaec', 'Octavia', 'Male', '2018-10-13', 'Blackwell', 'Voluptates nihil et ', 'Qui nobis officia en', 'Eligendi quod id ne', 'Cape Verde', 'Id sunt est corrupti', 'Consequatur laborum', '3', '+1 (872) 815-4668', '+1 (926) 474-1327', 43, 66, 'f9ac6c8007af4b34.', '8d7fc4afc666f244.', 'Unity Vang', '2', 'September Mendez', 969, '3', 'Hector Melton', 'Rerum magna aspernat', 'Nobis ab iure provid', 4, 6, 6, 4, 'In non aut velit qui', '2023-08-30 02:30:32', NULL),
('PRO0005', 'LD0003', '2', 'Ipsum excepteur sapi', 'Skyler', 'Male', '2003-06-01', 'Cochran', 'Id sed est recusand', 'Quia at magnam solut', 'Asperiores vel sequi', 'Saint Pierre and Miquelon', 'Rerum expedita itaqu', 'Qui aliqua Dolor te', '5', '+1 (226) 113-4116', '+1 (116) 793-4182', 97, 83, 'fa5c9ba6cd6a6251.', '288be1375f1445f2.', 'Signe England', '4', 'Helen Valencia', 253, '2', 'Arthur Hull', 'Voluptates voluptate', 'Occaecat consequatur', 4, 6, 6, 4, 'Nobis duis ea eos s', '2023-09-30 02:30:44', NULL),
('PRO0006', 'LD0003', '2', 'Labore aliquid enim ', 'Amelia', 'Male', '2007-01-10', 'Martinez', 'Ut ea ut in rem id e', 'Atque amet earum te', 'Aliquip in in aliqua', 'Burkina Faso', 'Voluptatum dicta sit', 'Suscipit irure ut eo', '5', '+1 (459) 334-5167', '+1 (665) 923-9204', 94, 57, 'de446e1738383ece.', '7c6c1da412aafb33.', 'Tobias Perez', '3', 'Tatiana Camacho', 394, '4', 'Rachel Church', 'Officia voluptatem ', 'Quisquam repellendus', 4, 6, 7, 7, 'Minima obcaecati nes', '2023-01-30 03:40:33', NULL),
('PRO0007', 'LD0001', '1', 'Aliquip illum beata', 'Xaviera', 'Female', '2018-03-15', 'Mcfarland', 'Explicabo Saepe tem', 'Voluptatem qui vel l', 'Sed numquam natus di', 'Cape Verde', 'Cillum itaque aut ve', 'Eos saepe sint in i', '3', '+1 (854) 631-7457', '+1 (611) 973-8767', 60, 5, 'f3568d35092dd0d4.', '41f9e5b1c41985b9.', 'Orla Maddox', '4', 'Daquan Dunlap', 779, '2', 'Tyrone Vasquez', 'Et neque aute dolore', 'Non dicta ullamco ne', 4, 6, 4, 4, 'Laborum harum labore', '2023-09-30 03:40:39', NULL),
('PRO0008', 'LD0004', '2', 'Maxime quia aut cumq', 'Aubrey', 'Female', '2019-10-10', 'Todd', 'Qui eiusmod Nam vero', 'Voluptates sunt non ', 'Quaerat delectus re', 'Djibouti', 'Eaque et soluta sed ', 'Ea id officia sunt ', '5', '+1 (726) 161-6316', '+1 (801) 593-5817', 25, 45, 'a81cdf2f757bae5f.', '4d71ba373100e5bb.', 'Harlan Cruz', '4', 'Cade Britt', 966, '3', 'Joseph York', 'Aut quo aut adipisci', 'Molestiae modi dolor', 4, 6, 7, 7, 'Error quod in totam ', '2023-09-30 05:09:43', NULL),
('PRO0009', 'LD0004', '1', 'Sed nulla irure vel ', 'Serina', 'Female', '1993-01-24', 'Wilkerson', 'Aut nihil atque temp', 'Possimus hic verita', 'Ex officiis exercita', 'Faroe Islands', 'Iste architecto veni', 'Lorem et reprehender', '2', '+1 (407) 994-7357', '+1 (138) 382-2631', 73, 58, '0ea814a874f5eb1e.', 'aaf98f9e15b2e628.', 'Ursa Olson', '2', 'Tatum Horton', 777, '3', 'Clinton Sanchez', 'Commodo quod rem qui', 'Autem velit volupta', 4, 6, 6, 4, 'In reiciendis aliqui', '2023-09-30 05:09:51', NULL),
('PRO0010', 'LD0004', '2', 'Nihil expedita conse', 'Danielle', 'Female', '2009-08-10', 'Morse', 'Animi et in ea volu', 'Consectetur eos tem', 'Sit tempore volupt', 'Bahrain', 'Dolores quia velit c', 'Officia quod elit e', '2', '+1 (105) 462-7218', '+1 (896) 983-1361', 9, 50, '5558668b7f377d5b.', '6b5acf6d36d1c7cf.', 'Margaret Massey', '5', 'Jayme Mullen', 864, '5', 'Yoshio Schneider', 'Quasi proident reru', 'Autem explicabo Des', 4, 6, 7, 1, 'Ut temporibus conseq', '2023-09-30 05:10:14', NULL),
('PRO0011', 'LD0004', '2', 'Omnis vero ut veniam', 'Blaine', 'Male', '1975-08-17', 'Mercado', 'Assumenda hic nihil ', 'Dolor fugit suscipi', 'Magnam dolore rem ve', 'Philippines', 'Tenetur Nam laborum ', 'Quaerat soluta sint ', '4', '+1 (929) 686-5505', '+1 (768) 897-7873', 51, 41, '6ae0fe3b99a03763.', 'e9034c83aa29696a.', 'Lionel Wolfe', '4', 'Baker Cole', 8, '4', 'Arsenio Douglas', 'Et debitis ipsa neq', 'Vel nesciunt nulla ', 4, 6, 1, 4, 'Deserunt rerum minim', '2023-09-30 05:10:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_notes_newlead`
--

CREATE TABLE `tb_notes_newlead` (
  `Id` int(11) NOT NULL,
  `id_newlead` varchar(250) NOT NULL,
  `note` text NOT NULL,
  `note_type` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_notes_newlead`
--

INSERT INTO `tb_notes_newlead` (`Id`, `id_newlead`, `note`, `note_type`, `created_at`) VALUES
(1, 'LD0001', 'For faster mobile-friendly development, use responsive display classes for showing and hiding elements by device. Avoid creating entirely different versions of the same site, instead hide element responsively for each screen size.\r\n\r\nTo hide elements simply use the .d-none class or one of the .d-{sm,md,lg,xl}-none classes for any responsive screen variation.', 'Report', '2023-09-29'),
(2, 'LD0001', 'For faster mobile-friendly development, use responsive display classes for showing and hiding elements by device. Avoid creating entirely different versions of the same site, instead hide element responsively for each screen size.\r\n\r\nTo hide elements simply use the .d-none class or one of the .d-{sm,md,lg,xl}-none classes for any responsive screen variation.', 'Survey', '2023-09-29'),
(3, 'LD0001', 'For faster mobile-friendly development, use responsive display classes for showing and hiding elements by device. Avoid creating entirely different versions of the same site, instead hide element responsively for each screen size.\r\n\r\nTo hide elements simply use the .d-none class or one of the .d-{sm,md,lg,xl}-none classes for any responsive screen variation.', 'Survey', '2023-09-29'),
(4, 'LD0001', 'For faster mobile-friendly development, use responsive display classes for showing and hiding elements by device. Avoid creating entirely different versions of the same site, instead hide element responsively for each screen size.\r\n\r\nTo hide elements simply use the .d-none class or one of the .d-{sm,md,lg,xl}-none classes for any responsive screen variation.', 'Survey', '2023-09-29'),
(5, 'LD0001', 'For faster mobile-friendly development, use responsive display classes for showing and hiding elements by device. Avoid creating entirely different versions of the same site, instead hide element responsively for each screen size.\r\n\r\nTo hide elements simply use the .d-none class or one of the .d-{sm,md,lg,xl}-none classes for any responsive screen variation.', 'Report', '2023-09-29'),
(6, 'LD0001', 'reassssssssssd\r\nasfasfasssssssssssssssssssssssss\r\n\r\nasdasdddddddddddddddddddd\r\nasdsaaaaaaa\r\nasd\r\nasddsssssss', 'Report', '2023-09-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `new_lead`
--
ALTER TABLE `new_lead`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_new_lead_pengguna` (`id_pengguna`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_jenis` (`Id_jenis`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `prospect`
--
ALTER TABLE `prospect`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_packages` (`Id_packages`),
  ADD KEY `Id_pengguna` (`Id_pengguna`),
  ADD KEY `fk_prospect_newLead` (`Id_newlead`);

--
-- Indexes for table `tb_notes_newlead`
--
ALTER TABLE `tb_notes_newlead`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_notes_newlead` (`id_newlead`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_notes_newlead`
--
ALTER TABLE `tb_notes_newlead`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `new_lead`
--
ALTER TABLE `new_lead`
  ADD CONSTRAINT `fk_new_lead_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`Id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`Id_jenis`) REFERENCES `jenis` (`Id`);

--
-- Constraints for table `prospect`
--
ALTER TABLE `prospect`
  ADD CONSTRAINT `fk_prospect_newLead` FOREIGN KEY (`Id_newlead`) REFERENCES `new_lead` (`Id`),
  ADD CONSTRAINT `prospect_ibfk_2` FOREIGN KEY (`Id_packages`) REFERENCES `packages` (`Id`),
  ADD CONSTRAINT `prospect_ibfk_3` FOREIGN KEY (`Id_pengguna`) REFERENCES `pengguna` (`Id`);

--
-- Constraints for table `tb_notes_newlead`
--
ALTER TABLE `tb_notes_newlead`
  ADD CONSTRAINT `fk_notes_newlead` FOREIGN KEY (`id_newlead`) REFERENCES `new_lead` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
