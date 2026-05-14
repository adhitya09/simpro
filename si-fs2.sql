-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 03:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si-fs2`
--

-- --------------------------------------------------------

--
-- Table structure for table `bastp`
--

CREATE TABLE `bastp` (
  `id` int(100) NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `tanggal` varchar(10) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `kasus` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `uraian_pekerjaan` text DEFAULT NULL,
  `permasalahan_upload` text DEFAULT NULL,
  `proses_perbaikan` text DEFAULT NULL,
  `sesudah_perbaikan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bastp`
--

INSERT INTO `bastp` (`id`, `hari`, `tanggal`, `bulan`, `tahun`, `kasus`, `lokasi`, `uraian_pekerjaan`, `permasalahan_upload`, `proses_perbaikan`, `sesudah_perbaikan`) VALUES
(1, 'senin', 'sepuluh', 'Januari', 'Dua ', 'Maintance', 'Kilang', '<p>aaaaaaaaaaaaaaa</p>', '67a9691f5df45.pdf', '67a9691f5e3df.pdf', '67a9691f5e5ee.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `cip`
--

CREATE TABLE `cip` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` longtext NOT NULL,
  `upload_treatise` varchar(255) DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `result` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cyber`
--

CREATE TABLE `cyber` (
  `id_cyber` int(11) NOT NULL,
  `date` date NOT NULL,
  `event` longtext NOT NULL,
  `risk` longtext NOT NULL,
  `mitigation` longtext NOT NULL,
  `prg` longtext NOT NULL,
  `status` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyber`
--

INSERT INTO `cyber` (`id_cyber`, `date`, `event`, `risk`, `mitigation`, `prg`, `status`, `id_user`) VALUES
(13, '2025-02-18', '<p>Kebocoran informasi melalui physical dan non physical infrastruktur</p>', '<p>Kebocoran informasi melalui physical dan non physical infrastruktur</p>', '<p>Data/informasi Password dapat terlindungi dengan baik.</p>', '<p>Data/informasi Password dapat terlindungi dengan baik</p>', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cyb_myssc`
--

CREATE TABLE `cyb_myssc` (
  `id_myssc` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `event` longtext DEFAULT NULL,
  `risk` longtext DEFAULT NULL,
  `mitigation` longtext DEFAULT NULL,
  `progres` longtext DEFAULT NULL,
  `tc` datetime DEFAULT NULL,
  `tr` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyb_myssc`
--

INSERT INTO `cyb_myssc` (`id_myssc`, `date`, `event`, `risk`, `mitigation`, `progres`, `tc`, `tr`, `status`, `id_user`) VALUES
(14, '2025-02-18', '<p>Inappropriate access pada physical dan non physical infrastruktur</p>', '<p>Kebocoran informasi melalui physical dan non physical infrastruktur</p>', '<p>Menyimpan akses secara terbatas</p>', '<p>Inappropriate access pada physical dan non physical infrasturktur dapat dicegah</p>', '2025-02-18 09:30:00', '2025-02-18 09:30:00', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dataprivat`
--

CREATE TABLE `dataprivat` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `ticket_number` text NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_resolved` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `ip_source` text NOT NULL,
  `hostname` mediumtext NOT NULL,
  `description_of_attacks` longtext DEFAULT NULL,
  `action` longtext DEFAULT NULL,
  `progress` longtext DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dataprivat`
--

INSERT INTO `dataprivat` (`id`, `date`, `ticket_number`, `datetime_created`, `datetime_resolved`, `id_user`, `user_id`, `ip_source`, `hostname`, `description_of_attacks`, `action`, `progress`, `status`) VALUES
(15, '2025-02-18', 'INC000000714836', '2025-02-18 08:30:00', '2025-02-20 08:30:00', 1, 'rs.itbjm', '10.106.48.78', 'PPN06CO2220073', '<p>Access to Malicious URL or Domain</p>', '<p>Access url:Cdn.polyfill[.]io legimate dari user, update xdr done, running</p>', '<p>-</p>', 4);

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `id_meeting` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `nr` varchar(255) DEFAULT NULL,
  `abt` longtext DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `place` longtext DEFAULT NULL,
  `ldr` mediumtext DEFAULT NULL,
  `ntl` varchar(255) DEFAULT NULL,
  `problem` longtext DEFAULT NULL,
  `solution` longtext DEFAULT NULL,
  `n1d` longtext NOT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `realized` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`id_meeting`, `date`, `nr`, `abt`, `time`, `place`, `ldr`, `ntl`, `problem`, `solution`, `n1d`, `technician`, `target`, `realized`, `status`, `id_user`) VALUES
(90, '2025-01-14', 'NR-01', 'Pembahasan Meeting 2025', '2025-01-14 08:00:00', 'Kantor Unit', 'Rizky Meiliyani', 'Andi Suhamran Achmad', '<p>Kebutuhan Perangkat Public Addresor di Lokasi Kantor Cabang Banjarmasin</p>', '<p>Melakukan Survey Titik Pemasangan di Area Gedung Kantor dan Halaman Parkir</p>', '<p>Melakukan Draft Kebutuhan Material</p>', '13,16,23', 'W3', '0001-01-01', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ph4`
--

CREATE TABLE `ph4` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `work_item` varchar(255) DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `survey_start_date` date DEFAULT NULL,
  `survey_end_date` date DEFAULT NULL,
  `survey_file` varchar(255) DEFAULT NULL,
  `design_start_date` date DEFAULT NULL,
  `design_end_date` date DEFAULT NULL,
  `design_file` varchar(255) DEFAULT NULL,
  `topologi_start_date` date DEFAULT NULL,
  `topologi_end_date` date DEFAULT NULL,
  `topologi_file` varchar(255) DEFAULT NULL,
  `padi_oe` varchar(255) DEFAULT NULL,
  `padi_start_date` text DEFAULT NULL,
  `padi_end_date` date DEFAULT NULL,
  `padi_tor` varchar(255) DEFAULT NULL,
  `padi_tor_start_date` date DEFAULT NULL,
  `padi_tor_end_date` date DEFAULT NULL,
  `padi_tkdn` varchar(255) DEFAULT NULL,
  `padi_tkdn_start_date` date DEFAULT NULL,
  `padi_tkdn_end_date` date DEFAULT NULL,
  `mr_oe` varchar(255) DEFAULT NULL,
  `mr_start_date` date DEFAULT NULL,
  `mr_end_date` date DEFAULT NULL,
  `mr_tender_file` varchar(255) DEFAULT NULL,
  `tender_file` varchar(255) DEFAULT NULL,
  `tender_start_date` date DEFAULT NULL,
  `tender_end_date` date DEFAULT NULL,
  `rfc` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `implementation_file` varchar(255) DEFAULT NULL,
  `implementation_start_date` date DEFAULT NULL,
  `implementation_end_date` date DEFAULT NULL,
  `monitoring_file` varchar(255) DEFAULT NULL,
  `monitoring_start_date` date DEFAULT NULL,
  `monitoring_end_date` date DEFAULT NULL,
  `implementation_description` longtext DEFAULT NULL,
  `monitoring_description` longtext DEFAULT NULL,
  `uat_file` varchar(255) DEFAULT NULL,
  `uat_start_date` date DEFAULT NULL,
  `uat_end_date` date DEFAULT NULL,
  `bastp_file` varchar(255) DEFAULT NULL,
  `bastp_start_date` date DEFAULT NULL,
  `bastp_end_date` date DEFAULT NULL,
  `bastb_file` varchar(255) DEFAULT NULL,
  `bastb_start_date` date DEFAULT NULL,
  `bastb_end_date` date DEFAULT NULL,
  `picking` text DEFAULT NULL,
  `picking_start_date` date DEFAULT NULL,
  `picking_end_date` date DEFAULT NULL,
  `others` text DEFAULT NULL,
  `others_start_date` date DEFAULT NULL,
  `others_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph4`
--

INSERT INTO `ph4` (`id`, `date`, `work_item`, `technician`, `survey_start_date`, `survey_end_date`, `survey_file`, `design_start_date`, `design_end_date`, `design_file`, `topologi_start_date`, `topologi_end_date`, `topologi_file`, `padi_oe`, `padi_start_date`, `padi_end_date`, `padi_tor`, `padi_tor_start_date`, `padi_tor_end_date`, `padi_tkdn`, `padi_tkdn_start_date`, `padi_tkdn_end_date`, `mr_oe`, `mr_start_date`, `mr_end_date`, `mr_tender_file`, `tender_file`, `tender_start_date`, `tender_end_date`, `rfc`, `status`, `implementation_file`, `implementation_start_date`, `implementation_end_date`, `monitoring_file`, `monitoring_start_date`, `monitoring_end_date`, `implementation_description`, `monitoring_description`, `uat_file`, `uat_start_date`, `uat_end_date`, `bastp_file`, `bastp_start_date`, `bastp_end_date`, `bastb_file`, `bastb_start_date`, `bastb_end_date`, `picking`, `picking_start_date`, `picking_end_date`, `others`, `others_start_date`, `others_end_date`) VALUES
(32, '2025-01-20', 'Pemasangan CCTV Area Parimeter Belakang Gedung Cafetaria', '13,15,17', '2025-01-06', '2025-01-07', 'Survey.docx', '2025-01-08', '2025-01-09', 'Design.docx', '2025-01-10', '2025-01-11', 'Topologi.docx', 'DP3.docx', '2025-01-17', '2025-01-17', 'TOR.docx', '2025-01-18', '2025-01-18', 'TKDN.docx', '2025-01-17', '2025-01-18', '', NULL, NULL, NULL, '', NULL, NULL, 'RF-008', 1, 'Evidance.docx', '2025-01-30', '2025-01-30', 'Evidance.docx', '2025-01-30', '2025-01-30', '						Implementasi.					', '						Monitoring					', 'UAT.docx', '2025-02-03', '2025-02-03', 'BASTP.docx', '2025-02-03', '2025-02-03', 'BASTB.docx', '2025-02-03', '2025-02-03', NULL, NULL, NULL, NULL, NULL, NULL),
(33, '2025-02-24', 'CCTV 6 lokasi', '', '2025-02-24', '2025-02-24', '67bbcc82a7c59.docx', '2025-02-24', '2025-02-24', '67bbcc82a8185.docx', '2025-02-25', '2025-02-25', '67bbcc82a85bc.docx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RF-009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '2025-02-24', 'CCTV 6 lokasi', '22,23', '2025-02-24', '2025-02-24', '67bbce18b2b87.docx', '2025-02-24', '2025-02-24', '67bbce18b316d.docx', '2025-02-24', '2025-02-24', '67bbce18b35ec.docx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RF-010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ph4_pic`
--

CREATE TABLE `ph4_pic` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `date_s2` date DEFAULT NULL,
  `date_s3` date DEFAULT NULL,
  `date_s4` date DEFAULT NULL,
  `work_item` varchar(255) DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `survey_start_date` date DEFAULT NULL,
  `survey_end_date` date DEFAULT NULL,
  `survey_file` varchar(255) DEFAULT NULL,
  `design_start_date` date DEFAULT NULL,
  `design_end_date` date DEFAULT NULL,
  `design_file` varchar(255) DEFAULT NULL,
  `topologi_start_date` date DEFAULT NULL,
  `topologi_end_date` date DEFAULT NULL,
  `topologi_file` varchar(255) DEFAULT NULL,
  `picking` text DEFAULT NULL,
  `picking_start_date` date DEFAULT NULL,
  `picking_end_date` date DEFAULT NULL,
  `others` text DEFAULT NULL,
  `others_start_date` date DEFAULT NULL,
  `others_end_date` date DEFAULT NULL,
  `rfc` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `implementation_file` varchar(255) DEFAULT NULL,
  `implementation_start_date` date DEFAULT NULL,
  `implementation_end_date` date DEFAULT NULL,
  `monitoring_file` varchar(255) DEFAULT NULL,
  `monitoring_start_date` date DEFAULT NULL,
  `monitoring_end_date` date DEFAULT NULL,
  `implementation_description` longtext DEFAULT NULL,
  `monitoring_description` longtext DEFAULT NULL,
  `uat_file` varchar(255) DEFAULT NULL,
  `uat_start_date` date DEFAULT NULL,
  `uat_end_date` date DEFAULT NULL,
  `bastp_file` varchar(255) DEFAULT NULL,
  `bastp_start_date` date DEFAULT NULL,
  `bastp_end_date` date DEFAULT NULL,
  `bastb_file` varchar(255) DEFAULT NULL,
  `bastb_start_date` date DEFAULT NULL,
  `bastb_end_date` date DEFAULT NULL,
  `request` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ph4_pic`
--

INSERT INTO `ph4_pic` (`id`, `date`, `date_s2`, `date_s3`, `date_s4`, `work_item`, `technician`, `survey_start_date`, `survey_end_date`, `survey_file`, `design_start_date`, `design_end_date`, `design_file`, `topologi_start_date`, `topologi_end_date`, `topologi_file`, `picking`, `picking_start_date`, `picking_end_date`, `others`, `others_start_date`, `others_end_date`, `rfc`, `status`, `implementation_file`, `implementation_start_date`, `implementation_end_date`, `monitoring_file`, `monitoring_start_date`, `monitoring_end_date`, `implementation_description`, `monitoring_description`, `uat_file`, `uat_start_date`, `uat_end_date`, `bastp_file`, `bastp_start_date`, `bastp_end_date`, `bastb_file`, `bastb_start_date`, `bastb_end_date`, `request`) VALUES
(8, '2025-02-10', NULL, NULL, NULL, 'Sentralisasi CCTV 10 Lokasi', '15', '2025-02-10', '2025-02-10', '67a93d33ca571.pdf', '2025-02-10', '2025-02-10', '67a93d33ca7f1.pdf', '2025-02-10', '2025-02-10', '67a93d33ca9ff.pdf', '<p>aaaaaaaaaaaaa</p>', '2025-02-10', '2025-02-10', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>aaaaaaaaa</p>');

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` int(11) NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `departement` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` varchar(255) DEFAULT NULL,
  `umur` varchar(255) DEFAULT NULL,
  `edukasi` varchar(255) DEFAULT NULL,
  `work_location` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status_pernikahan` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `alamat_ktp` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teknisi`
--

INSERT INTO `teknisi` (`id_teknisi`, `nik`, `nama`, `nip`, `departement`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `umur`, `edukasi`, `work_location`, `email`, `status_pernikahan`, `type`, `hp`, `alamat_ktp`, `foto`) VALUES
(10, '6471041712720004', 'Abdullah', '-', 'PTC', 'Laki-laki', 'Sinjai', '1972-12-17', '52', 'SMA', 'Kantor Unit - Balikpapan', 'mk.abdullah@mitrakerja.pertamina.com', 'Kawin', 'Outsourcing', '081351778156', 'Jl. Dahor II 2', 'Abdullah.JPG'),
(12, '6471050203860003', 'Sony Eka Priatna', 'M949-230815', 'PTC', 'Laki-laki', 'Surabaya', '1986-03-02', '38', 'D3', 'Kantor Unit - Balikpapan', 'mk.sony.eka@mitrakerja.pertamina.com', 'Kawin', 'Outsourcing', '085254666671', 'Perum Komplek Wika KH 6 No. 2', 'Sony Eka.png'),
(13, '6471053108820005 ', 'Soni Agus Triyono', '-', 'PTC', 'Laki-laki', 'Tulung Agung', '1982-08-31', '42', 'SMA', 'Kantor Unit - Balikpapan', 'mk.sony.triono@mitrakerja.pertamina.com', 'Kawin', 'Outsourcing', '082157316978', 'Jl. Telogorejoi  Rt. 30 No. 17', 'Soni Agus Triyono.JPG'),
(15, '6471031311890000', 'Adi Triyanto', '-', 'PTC', 'Laki-laki', 'Balikpapan', '1989-11-13', '35', 'SMK', 'Kantor Unit - Balikpapan', 'mk.adi.triyanto@mitrakerja.pertamina.com', 'Kawin', 'Outsourcing', '081254647572', 'Jl.flamboyan.rt 15 no 40', 'Adi Triyanto.JPG'),
(16, '9171022804910000', 'Andi Muhammad Syukur Achmad', 'M948-234478', 'PTC', 'Laki-laki', 'Selayar', '1991-04-28', '33', 'S1', 'Kantor Unit - Balikpapan', 'mk.andi.sa@mitrakerja.pertamina.com', 'Kawin', 'Outsourcing', '085244018293', 'Jl. Guntur Damai 1', 'andi muh.png'),
(17, '6471052111990004', 'Gusti Fazari Haikal Ilmam', '-', 'PTC', 'Laki-laki', 'Balikpapan', '1999-11-21', '25', 'S1', 'Kantor Unit - Balikpapan', 'mk.gusti.ilmam@mitrakerja.pertamina.com', 'Belum Kawin', 'Outsourcing', '085141048299', 'Jl. Cendrawasi No, 20 Rt. 40', 'Gusti Fazari Haikal Ilmam.JPG'),
(18, '6471040606920001', 'Daniel Febrian Antoni', 'M948-234459', 'PT. PTC', 'Laki-laki', 'Balikpapan', '1992-06-06', '32', 'SMK', 'Kantor Unit - Balikpapan', 'mk.daniel.antoni@mitrakerja.pertamina.com', 'Belum Kawin', 'Kontrak Volume', '083140250877', 'Jl.Letjen.s.parman no 32 Balikpapan', 'dani.png'),
(19, '6471041810860005', 'Ardiansyah Subjantoro', '8638', 'PT. Berca Hardayaperkasa', 'Laki-laki', 'Jayapura', '1986-10-18', '38', 'D3', 'Kantor Unit - Balikpapan', 'mk.ardiansyah.s@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '08115451180', 'Jl. Panorama No. 118', 'ardiansyah.png'),
(20, '6471041509840002', 'Septianto Yuwono', '-', 'PT. Projectindo Teknowindata', 'Laki-laki', 'Balikpapan', '1984-09-18', '40', 'D3', 'Kantor Unit - Balikpapan', 'septian.y8005@gmail.com', 'Kawin', 'Kontrak Volume', '081284788281', 'Jl. Sumber Rejo I No 15 Rt. 35 ', 'Septian yuwono.png'),
(21, '6471042405920001', 'Hendra Ragil', '067/IDCMK-PND960000/2023-S0', 'PT. Projectindo Teknowindata', 'Laki-laki', 'Balikpapan', '1992-05-24', '32', 'SMK', 'Kantor Unit - Balikpapan', 'mk.hendra.pamuji@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '082255851421', 'Jl. Mayjen DI. Panjaitan gg. Darmo RT. 29 No. 123 Sumber Rejo', 'hendra.png'),
(22, '6471050904000005', 'Achmad Rayhan Fahmi', '-', 'PT. Berca Hardayaperkasa', 'Laki-laki', 'Balikpapan', '2000-04-09', '24', 'S1', 'Kantor Unit - Balikpapan', 'mk.achmad.rayhan@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '081347502256', 'Jl. RE Martadinata RT 17 No.9 Kel.Mekar Sari Balikpapan Tengah', 'Rayhan.png'),
(23, '6371040303000010', 'Muhammad Aji Nugraha', '-', 'PT. Projectindo Teknowindata', 'Laki-laki', 'Banjarmasin', '2000-03-15', '24', 'SMK', 'Banjarmasin', 'mk.muhamma.nugraha2@mitrakerja.pertamina.com', 'Belum Kawin', 'Kontrak Volume', '081251262886', 'Jl. Akasia II RT. 037 No.4  Sungai Miai Banjarmasin', 'Ajie Nugraha.png'),
(24, '6371032801940014', 'Nurmawan', '-', 'PT. Berca Hardayaperkasa', 'Laki-laki', 'Banjarmasin', '1994-01-28', '30', 'SMK', 'Banjarmasin', 'mk.nurmawan@mitrakerja.pertamina.com', 'Belum Kawin', 'Kontrak Volume', '087846376675', 'Jl. Belitung Darat gg. Karya 6B No.29 RT.13 Banjarmasin', 'Nurmawan.png'),
(25, '6171051305940008', 'Surya Muhfi Maulana', '-', 'PT. Berca Hardayaperkasa', 'Laki-laki', 'Pontianak', '1994-05-13', '30', 'SMK', 'Pontianak', 'mk.surya.maulana@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '082150673748', 'Jl. Budi utomo gg. Bersatu No. 16 Pontianak', 'Surya.png'),
(26, '6112090908970004', 'Adry Nori', '-', 'PT. Projectindo Teknowindata', 'Laki-laki', 'Pontianak', '1997-08-09', '27', 'SMK', 'Pontianak', 'mk.adry.nori@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '0882022060494', 'Jl. Selat Panjang gg. Arafah RT. 006  No. 27 Siantan Hulu Pontianak', 'Adry.png'),
(27, '6471032407750003', 'Edwin Yuliandri', '-', 'PT. Sigma Cipta Utama', 'Laki-laki', 'Balikpapan', '1975-07-24', '49', 'S1', 'Kantor Unit - Balikpapan', 'mk.edwin.yuliandri@mitrakerja.pertamina.com', 'Kawin', 'Kontrak Volume', '085247019764', 'Tamansari Bukit Mutiara KH6/33 Balikpapan', 'Edwin.png'),
(28, '9171020307940003', 'Andi Suhamran Achmad', '-', 'PT. Sigma Cipta Utama', 'Laki-laki', 'Benteng Selayar', '1994-07-03', '30', 'S1', 'Kantor Unit - Balikpapan', 'mk.andi.suhamran@mitrakerja.pertamina.com', 'Belum Kawin', 'Kontrak Volume', '081343161454', 'Jl. Guntur Damai 1', 'Andi Suhamran Achmad.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `foto`, `username`, `password`, `role`, `status`) VALUES
(1, 'Administrator', '-@gmail.com', 'Administrator.png', 'Admin_24_#PS1', '62bc184f1ba0ee344325e3a7b06b983f', 1, 1),
(36, 'Administrator', '-@gmail.com', 'Administrator.png', 'Admin_24_#PS2', '7f813db3f97beeba47138348d1391926', 1, 1),
(44, 'Andi Muhammad Syukur Achmad', 'mk.andi.sa@mitrakerja.pertamina.com', 'Andi Muhammad Syukur Achmad.png', 'andi.ma', 'f3f5432bfa90f9edee819c1f8fb04ba5', 2, 1),
(57, 'Rizky Meiliyani', 'rizky@pertamina.com', 'Rizky Meiliyani.png', 'rizky.my', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1),
(58, 'Indri Setyowati', 'indri.setyowati@pertamina.com', 'Indri Setyowati.png', 'indri.sy', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1),
(59, 'Septian Handoko', '.@pertamina.com', 'Septian Handoko.png', 'septian.hk', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1),
(60, 'Puput Setiawan', 'puputs@pertamina.com', 'Puput Setiawan.png', 'puput.sy', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1),
(61, 'I Komang Trisna Jayadi ', '.@pertamina.com', 'I Komang Trisna Jayadi.png', 'komang.tj', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1),
(62, 'Sabar Wicaksana', '.@pertamina.com', 'Sabar Wicaksana.png', 'sabar.ws', 'f3f5432bfa90f9edee819c1f8fb04ba5', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bastp`
--
ALTER TABLE `bastp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cip`
--
ALTER TABLE `cip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cyber`
--
ALTER TABLE `cyber`
  ADD PRIMARY KEY (`id_cyber`);

--
-- Indexes for table `cyb_myssc`
--
ALTER TABLE `cyb_myssc`
  ADD PRIMARY KEY (`id_myssc`);

--
-- Indexes for table `dataprivat`
--
ALTER TABLE `dataprivat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id_meeting`);

--
-- Indexes for table `ph4`
--
ALTER TABLE `ph4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ph4_pic`
--
ALTER TABLE `ph4_pic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bastp`
--
ALTER TABLE `bastp`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cip`
--
ALTER TABLE `cip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cyber`
--
ALTER TABLE `cyber`
  MODIFY `id_cyber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cyb_myssc`
--
ALTER TABLE `cyb_myssc`
  MODIFY `id_myssc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dataprivat`
--
ALTER TABLE `dataprivat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id_meeting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `ph4`
--
ALTER TABLE `ph4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ph4_pic`
--
ALTER TABLE `ph4_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teknisi`
--
ALTER TABLE `teknisi`
  MODIFY `id_teknisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
