-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 09:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ekskul`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `anggota_ekskul`
--

CREATE TABLE `anggota_ekskul` (
  `id_anggota` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_detail` int(11) NOT NULL,
  `visi misi` varchar(100) NOT NULL,
  `ketua` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_detail`, `visi misi`, `ketua`, `keterangan`) VALUES
(1, 'Mengembangkan potensi siswa secara optimal', 'Rezky Awalya', 'OSIS untuk kepemimpinan dan organisasi'),
(2, 'Peduli kesehatan, kemanusiaan, dan lingkungan', 'Andi Ashadelah Maharani Anil', 'PMR fokus pada kesehatan dan bantuan'),
(3, 'Pasukan disiplin menghormati bendera', 'Siti Nur Hasiza', 'Bertugas mengibarkan bendera'),
(4, 'Membentuk generasi muda berkarakter', 'Nur Inayah Athaillah', 'Pramuka untuk karakter dan keterampilan');

-- --------------------------------------------------------

--
-- Table structure for table `detail_ekskul`
--

CREATE TABLE `detail_ekskul` (
  `id_detail` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_ekskul`
--

INSERT INTO `detail_ekskul` (`id_detail`, `id_siswa`, `id_ekskul`) VALUES
(2, 12, 1),
(3, 14, 1),
(4, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembina`
--

CREATE TABLE `detail_pembina` (
  `id_detail` int(11) NOT NULL,
  `id_ekskul` int(11) DEFAULT NULL,
  `id_pembina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekskul`
--

CREATE TABLE `ekskul` (
  `id_ekskul` int(11) NOT NULL,
  `nama_ekskul` varchar(255) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `desk_umum` varchar(100) NOT NULL,
  `singkatan` varchar(50) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `id_detail` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekskul`
--

INSERT INTO `ekskul` (`id_ekskul`, `nama_ekskul`, `nama_siswa`, `desk_umum`, `singkatan`, `gambar`, `id_detail`, `id_siswa`, `nama`) VALUES
(1, 'Organisasi Siswa Intra Sekolah ', '', 'osis itu keren skli', 'OSIS', 'logoosis.png\r\n', 1, NULL, '0'),
(2, 'Palang Merah Remaja', '', 'PMR KEREN BANGETT', 'PMR', 'logopmr.png', 2, NULL, '0'),
(3, 'Pasukan Pengibar Bendera', '', 'kerennn bgtt wejhhhh', 'Paskibra', 'logopaskib.jpeg', 3, NULL, '0'),
(4, 'Praja Muda Karana', '', 'KERENN ABIESSSS', 'Pramuka', 'logopramuka.jpeg', 4, NULL, '0'),
(5, 'rohani siswa', '', 'pecinta musholla', 'ROHIS', 'logorohis.jpeg', 0, NULL, '0'),
(10, 'basket BALL', '', 'basket ball', 'basket', 'logobasket.jpg', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `pembina`
--

CREATE TABLE `pembina` (
  `id_pembina` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kompetensi` varchar(100) DEFAULT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembina`
--

INSERT INTO `pembina` (`id_pembina`, `nama`, `kompetensi`, `id_ekskul`) VALUES
(14, 'Pak ibrahim', 'rpl', 1),
(15, 'ibu anty', 'rpl', 2),
(16, 'ibu fatimah', 'ak', 4),
(25, 'pak ebby', 'ps', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembina_ekskul`
--

CREATE TABLE `pembina_ekskul` (
  `id_pembina` int(11) NOT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembina_ekskul`
--

INSERT INTO `pembina_ekskul` (`id_pembina`, `id_ekskul`) VALUES
(14, 1),
(15, 2),
(16, 2),
(22, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 10);

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `nama_kegiatan` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id_prestasi`, `nama_kegiatan`, `deskripsi`, `id_ekskul`) VALUES
(1, 'PILKADA', 'debat politik pilkada', 1),
(2, 'KARAENG', 'memenangkan perlombaan', 2),
(3, 'LKBB', 'menang anu', 3),
(4, 'LKBB', 'menang guys', 4);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `ekskul` varchar(100) NOT NULL,
  `NIS` int(15) NOT NULL,
  `kelas` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama`, `ekskul`, `NIS`, `kelas`) VALUES
(10, 'cica', 'Praja Muda Karana', 381824240, 'XII'),
(11, 'pina', 'Organisasi Siswa Intra Se', 94724024, 'X'),
(12, 'Rezky Awalya', 'Organisasi Siswa Intra Se', 343, 'XI'),
(14, 'alya', 'Organisasi Siswa Intra Sekolah ', 92709373, 'XII'),
(18, 'nayah', 'Pasukan Pengibar Bendera', 98575564, 'X');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_ekskul`
--

CREATE TABLE `siswa_ekskul` (
  `id_siswa_ekskul` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_ekskul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anggota_ekskul`
--
ALTER TABLE `anggota_ekskul`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_ekskul` (`id_ekskul`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `detail_ekskul`
--
ALTER TABLE `detail_ekskul`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_ekskul` (`id_ekskul`);

--
-- Indexes for table `detail_pembina`
--
ALTER TABLE `detail_pembina`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_ekskul` (`id_ekskul`),
  ADD KEY `id_pembina` (`id_pembina`);

--
-- Indexes for table `ekskul`
--
ALTER TABLE `ekskul`
  ADD PRIMARY KEY (`id_ekskul`),
  ADD UNIQUE KEY `id_detail` (`id_detail`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `pembina`
--
ALTER TABLE `pembina`
  ADD PRIMARY KEY (`id_pembina`);

--
-- Indexes for table `pembina_ekskul`
--
ALTER TABLE `pembina_ekskul`
  ADD PRIMARY KEY (`id_pembina`,`id_ekskul`),
  ADD KEY `id_ekskul` (`id_ekskul`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`),
  ADD UNIQUE KEY `id_ekskul` (`id_ekskul`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `NIS` (`NIS`);

--
-- Indexes for table `siswa_ekskul`
--
ALTER TABLE `siswa_ekskul`
  ADD PRIMARY KEY (`id_siswa_ekskul`),
  ADD KEY `fk_siswa` (`id_siswa`),
  ADD KEY `fk_ekskul` (`id_ekskul`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota_ekskul`
--
ALTER TABLE `anggota_ekskul`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detail_ekskul`
--
ALTER TABLE `detail_ekskul`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_pembina`
--
ALTER TABLE `detail_pembina`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekskul`
--
ALTER TABLE `ekskul`
  MODIFY `id_ekskul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembina`
--
ALTER TABLE `pembina`
  MODIFY `id_pembina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota_ekskul`
--
ALTER TABLE `anggota_ekskul`
  ADD CONSTRAINT `anggota_ekskul_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `anggota_ekskul_ibfk_2` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE;

--
-- Constraints for table `detail_ekskul`
--
ALTER TABLE `detail_ekskul`
  ADD CONSTRAINT `detail_ekskul_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_ekskul_ibfk_2` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE;

--
-- Constraints for table `detail_pembina`
--
ALTER TABLE `detail_pembina`
  ADD CONSTRAINT `detail_pembina_ibfk_1` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`),
  ADD CONSTRAINT `detail_pembina_ibfk_2` FOREIGN KEY (`id_pembina`) REFERENCES `pembina` (`id_pembina`);

--
-- Constraints for table `pembina`
--
ALTER TABLE `pembina`
  ADD CONSTRAINT `fk_pembina` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`);

--
-- Constraints for table `pembina_ekskul`
--
ALTER TABLE `pembina_ekskul`
  ADD CONSTRAINT `pembina_ekskul_ibfk_2` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `fk_ekskul2` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa_ekskul`
--
ALTER TABLE `siswa_ekskul`
  ADD CONSTRAINT `fk_ekskul` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
