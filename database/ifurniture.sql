-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2021 at 03:43 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ifurniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` varchar(12) CHARACTER SET latin1 NOT NULL,
  `tgl_booking` date NOT NULL,
  `batas_bayar` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `tgl_booking`, `batas_bayar`, `id_user`) VALUES
('27062021001', '2021-06-27', '2021-06-29', 17);

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `id` int(11) NOT NULL,
  `id_booking` varchar(12) CHARACTER SET latin1 NOT NULL,
  `id_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_detail`
--

INSERT INTO `booking_detail` (`id`, `id_booking`, `id_produk`) VALUES
(29, '27062021001', 5),
(30, '27062021001', 2);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `no_transaksi` varchar(12) NOT NULL,
  `id_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`no_transaksi`, `id_produk`) VALUES
('07062021002', 2),
('07062021003', 2),
('07062021004', 2),
('07062021005', 2),
('07062021006', 2),
('07062021007', 2),
('07062021008', 2),
('07062021009', 2),
('07062021010', 2),
('07062021011', 2),
('07062021012', 2),
('07062021013', 2),
('07062021014', 2),
('07062021015', 2),
('07062021016', 2),
('07062021017', 2),
('10062021006', 5),
('10062021007', 20),
('21062021008', 15),
('27062021009', 15),
('27062021009', 16),
('27062021009', 21);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'Ranjang tempat tidur'),
(2, 'Kursi dan Sofa'),
(3, 'Lemari'),
(4, 'Kabinet dan rak penyimpanan'),
(5, 'Meja'),
(6, 'Perlengkapan dapur dan ruang makan'),
(7, 'Dekorasi rumah'),
(8, 'Pintu dan Jendela');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Utility'),
(5, 'Produk'),
(6, 'Anggota'),
(7, 'Laporan');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(128) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `deskripsi` varchar(128) NOT NULL,
  `harga` int(11) NOT NULL,
  `ditransaksi` int(11) NOT NULL,
  `dibooking` int(11) NOT NULL,
  `image` varchar(256) DEFAULT 'book-default-cover.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `id_kategori`, `deskripsi`, `harga`, `ditransaksi`, `dibooking`, `image`) VALUES
(1, 'Fcenter Chair Set Grey Brown\r\n', 2, 'Tipe : Fcenter; Bahan : Kayu Jati; Warna : Coklat abu-abu;', 1149999, 1, 2, 'kursi2.png'),
(2, 'Fcenter Chair Dark Lilac', 2, 'Tipe : Fcenter; Bahan : Kayu Jati; Warna : Dark Lilac', 765008, -4, 0, 'kursi4.jpg'),
(5, 'Indachi Brown Table', 5, 'Tipe : Indachi;\r\nBahan : Kayu Jati;\r\nWarna : Coklat', 375003, -1, 0, 'meja3.jpg'),
(10, 'Diamond Silver Table Drawers', 5, 'Warna : Putih;\r\nFitur : \r\nMeja dan 8 Laci', 649992, 0, 8, 'meja4.jpg'),
(14, 'Diamond Eight Drawer Dresser', 4, 'Warna : Putih; Fitur : 8 Laci', 744999, 0, 1, 'laci1.jpg'),
(15, 'MALM Chest of 6 Drawers', 4, 'Tipe : MALM; \r\nBahan : Kayu Mahoni;\r\nWarna : Abu-abu; ', 500003, -4, 1, 'laci2.jpg'),
(16, 'Half Square Mirror Sliding Wardrobe', 3, 'Tipe : MALM;\r\nBahan : Kayu Jati;\r\nWarna : Rosey Brown', 4174998, 0, 2, 'lemari1.jpg'),
(17, 'White 3 Doors Wardrobe', 3, 'Tipe : MALM; Bahan : Kayu Jati; Warna : Putih', 3500000, 0, 0, 'lemari5.jpg'),
(18, ' Shelving Cupboard Storage', 4, 'Bahan : Kayu Mahoni\r\nWarna : Peach', 520000, 0, 0, 'kabinet1.webp'),
(19, 'Storage Shelf', 4, 'Bahan : Kayu Mahoni\r\nWarna : Peach', 450000, 0, 0, 'kabinet2.webp'),
(20, 'King Wooden Bed', 1, 'Bahan : Kayu Jati; Warna : Cokelat\r\nUkuran : King Size', 6200005, -3, -2, 'ranjang3.jpg'),
(21, 'Single Drawer Bed', 1, 'Bahan : Kayu Jati; Warna : Coffee\r\nFitur : Bed + Laci\r\n', 4800000, 0, 0, 'ranjang4.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id` int(11) NOT NULL,
  `tgl_booking` date DEFAULT NULL,
  `id_user` varchar(12) CHARACTER SET latin1 NOT NULL,
  `email_user` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET latin1 NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `deskripsi` varchar(128) CHARACTER SET latin1 NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`id`, `tgl_booking`, `id_user`, `email_user`, `id_produk`, `nama_produk`, `image`, `deskripsi`, `harga`) VALUES
(1, '2021-06-27', '27', 'rizqiamalia@gmail.com', 1, 'Fcenter Chair Set Grey Brown\r\n', 'kursi2.png', '', 1149999);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `no_transaksi` varchar(12) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `id_booking` varchar(12) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `ongkir` int(20) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `status` enum('Lunas','DP','','') NOT NULL,
  `total_bayar` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`no_transaksi`, `tgl_transaksi`, `id_booking`, `id_user`, `jumlah`, `harga`, `ongkir`, `tgl_kirim`, `status`, `total_bayar`) VALUES
('08062021001', '2021-06-08', '07062021005', 18, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('08062021002', '2021-06-08', '07062021007', 18, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('10062021003', '2021-06-10', '07062021006', 18, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('10062021004', '2021-06-10', '07062021008', 18, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('10062021005', '2021-06-10', '07062021009', 19, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('10062021006', '2021-06-10', '08062021010', 21, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('10062021007', '2021-06-10', '10062021001', 17, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('21062021008', '2021-06-21', '20062021001', 23, 0, 0, 0, '1970-01-01', 'Lunas', 0),
('27062021009', '2021-06-27', '27062021003', 26, 0, 0, 0, '1970-01-01', 'Lunas', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `tanggal_input` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `alamat`, `email`, `image`, `password`, `role_id`, `is_active`, `tanggal_input`) VALUES
(17, 'Amalia', '', 'amalia1@gmail.com', 'default.jpg', '$2y$10$Oi4VVrn7vO6Cu2NGpJ9nHebcDAQDdHYocvpsV615NoLrtlSx3YVfC', 2, 1, 1622907296),
(18, 'Ria', '', 'ria123@gmail.com', 'default.jpg', '$2y$10$LohzYq9D9J74IBgfgvDI9OqjDRCksF0xFVmNtVFS4HXIAVbbfT2Xy', 1, 1, 1622952730),
(20, 'Aria', 'tegal', 'aria@gmail.com', 'default.jpg', '$2y$10$fFfdMriUJu0qJ98T7cecIO16ZOtPtcbk4EbTv2NTlDZOnolJec4NS', 2, 1, 1623074570),
(21, 'Bella', 'tegal', 'bella@gmail.com', 'default.jpg', '$2y$10$2DFxtzcoMFSleZDr0HU78eY5Z7NZeNJojaWALFXKIRqWUvzVCiR.6', 2, 1, 1623165324),
(22, 'Ria Rizqi Amalia', 'Tarub Tegal', 'ria.gmail.com', 'default.jpg', '$2y$10$fmPJFPVmWeO9agVJizLjh.ILGXxXahgvL0Mftx01QbWIYPlAEL9D2', 2, 1, 1623339014),
(23, 'Ria', 'Tegal', 'ria@gmail.com', 'default.jpg', '$2y$10$O/vH7mMjY7nmlfnlBI925Owd.Ztp5sdabgvsoMJb4n3rH6RvCsVEW', 2, 1, 1624175976),
(24, 'Ria Rizqi', '', 'riarizqi@gmail.com', 'default.jpg', '$2y$10$UgEHMVk.V6mZa.kP5dAuN.4T7Q8u7dbyNhZE2sMRawiyGNHtoJ50K', 1, 1, 1624176353),
(25, 'Rizqi', 'Tegal', 'rizqi@gmail.com', 'default.jpg', '$2y$10$MYHcPBJw3QpO11y5/9BGZu8cg4perzG3CKnX2RMCGu9wFu3EdX/Y2', 2, 1, 1624288219),
(26, 'Ria Rizqi Amalia', 'Tegal', 'ria1234@gmail.com', 'default.jpg', '$2y$10$P29HljXMgxJTIGUoIKMyaO.KgBjVH2X86TIpLSNC.656CEs.ZuTdi', 2, 1, 1624797953),
(27, 'Rizqi Amalia', '', 'rizqiamalia@gmail.com', 'default.jpg', '$2y$10$AsnDUFBnfHHYzl95EtguqOJB8Yj.NJAR/JjAF0rk.kpnOfr7Hwb0S', 2, 1, 1624798250);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD KEY `id_booking` (`id_booking`);

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`no_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_detail`
--
ALTER TABLE `booking_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
