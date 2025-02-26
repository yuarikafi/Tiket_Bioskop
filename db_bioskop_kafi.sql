-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 02:45 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bioskop_kafi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `name`, `password`, `created_at`) VALUES
(4, 'yuarichoirulkafikafi@gmail.com', 'kafi', '$2y$10$xO0yq7TBIZanKoWimchqhu7dLJpJGYwMfjrh.neLODzTKvqXe9P/6', '2025-02-17 04:46:46'),
(5, 'eghanvidia@gmail.com', 'SUMANTO', '$2y$10$ux4lsv844Yh1g9SpNkEeFeXeP0I91waXLXqP29hELp70uPc9qGZEa', '2025-02-17 05:20:09');

-- --------------------------------------------------------

--
-- Table structure for table `akun_mall`
--

CREATE TABLE `akun_mall` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(231) NOT NULL,
  `nama_mall` varchar(231) NOT NULL,
  `nik` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun_mall`
--

INSERT INTO `akun_mall` (`id`, `email`, `password`, `nama_mall`, `nik`) VALUES
(1, 'vitojulian38@gmail.com', '$2y$10$zhUhn4ns/xmqo4KYIW7PPOCR5sinG0DOwjcn5Af3xOXNgIJvPISM6', 'kafi cibubur', '333'),
(2, 'nurrishqi@gmail.com', '$2y$10$VrFhFaoEqUnQZyFLNtxDCeWq42YllmMuhjymUdPXuc6E2zTEV/0Ey', 'Rishqi Cibubur', '280507');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(231) NOT NULL,
  `trailer` varchar(231) NOT NULL,
  `nama_film` varchar(231) NOT NULL,
  `judul` longtext NOT NULL,
  `total_menit` varchar(231) NOT NULL,
  `usia` varchar(231) NOT NULL,
  `genre` varchar(231) NOT NULL,
  `dimensi` varchar(231) NOT NULL,
  `Producer` varchar(231) NOT NULL,
  `Director` varchar(231) NOT NULL,
  `Writer` varchar(231) NOT NULL,
  `Cast` varchar(231) NOT NULL,
  `Distributor` varchar(231) NOT NULL,
  `harga` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `poster`, `banner`, `trailer`, `nama_film`, `judul`, `total_menit`, `usia`, `genre`, `dimensi`, `Producer`, `Director`, `Writer`, `Cast`, `Distributor`, `harga`) VALUES
(1, 'uploads/poster/poster ds.jpg', 'uploads/banner/banner ds.jpg', 'uploads/trailer/trailer ds.mp4', 'Doctor Stranger', 'While on a journey of physical and spiritual healing, a brilliant neurosurgeon is drawn into the world of the mystic arts.', '115', '13', '', '3D', 'Victoria Alonso', 'Scott Derrickson', 'Jon Spaihts', 'Benedict Cumberbatch', 'kapi', '20000'),
(6, 'uploads/poster/atar nyari web.jpg', 'uploads/banner/webcam-toy-photo15.jpg', 'uploads/trailer/trailer ds.mp4', 'WEB DEVELOPER', 'While on a journey of physical and spiritual healing, a brilliant neurosurgeon is drawn into the world of the mystic arts.', '20', '17', 'Crime,Epic', '2D', 'kafi', 'kafi', 'kafi', 'kafi', 'kapi', '10000'),
(7, 'uploads/poster/poster sepongebob movie.jpeg', 'uploads/banner/banner sepongebob movie.jpeg', 'uploads/trailer/trailer ds.mp4', 'spongebob movie sponge out of water ', 'ndwfaa', '92', '13', 'Adventure', '3D', 'kapi punya', 'kapi punya', 'kapi punya', 'kapi punya', 'kapi punya', '20000');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_film`
--

CREATE TABLE `jadwal_film` (
  `id` int(11) NOT NULL,
  `mall_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `studio` varchar(231) NOT NULL,
  `jam_tayang_1` time NOT NULL,
  `jam_tayang_2` time NOT NULL,
  `jam_tayang_3` time NOT NULL,
  `tanggal_tayang` date NOT NULL,
  `tanggal_akhir_tayang` date NOT NULL,
  `total_menit` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_film`
--

INSERT INTO `jadwal_film` (`id`, `mall_id`, `film_id`, `studio`, `jam_tayang_1`, `jam_tayang_2`, `jam_tayang_3`, `tanggal_tayang`, `tanggal_akhir_tayang`, `total_menit`) VALUES
(4, 1, 1, 'Studio 1', '14:03:00', '19:03:00', '20:09:00', '2025-02-22', '2025-02-28', '115'),
(5, 1, 7, 'Studio 2', '14:21:00', '15:22:00', '16:24:00', '2025-02-22', '2025-02-20', '92'),
(6, 2, 1, 'Studio 1', '12:12:00', '14:14:00', '16:16:00', '2025-02-22', '2025-02-26', '115'),
(7, 1, 7, 'Studio 1', '13:37:00', '17:37:00', '22:37:00', '2025-02-22', '2025-02-28', '92'),
(8, 1, 6, 'Studio 2', '13:56:00', '15:56:00', '18:56:00', '2025-02-22', '2025-02-28', '20'),
(9, 1, 1, 'Studio 1', '14:00:00', '15:00:00', '16:00:00', '2025-02-22', '2025-02-28', '115');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `mall_name` varchar(255) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `status` enum('available','occupied') NOT NULL,
  `film_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `mall_name`, `seat_number`, `status`, `film_name`) VALUES
(1, 'kafi cibubur', 'A3', 'occupied', 'Doctor Stranger'),
(2, 'kafi cibubur', 'C6', 'occupied', 'Doctor Stranger'),
(3, 'kafi cibubur', 'C7', 'occupied', 'Doctor Stranger'),
(4, 'kafi cibubur', 'B6', 'occupied', 'Doctor Stranger'),
(5, 'kafi cibubur', 'B7', 'occupied', 'Doctor Stranger'),
(6, 'kafi cibubur', 'E7', 'occupied', 'Doctor Stranger'),
(7, 'kafi cibubur', 'F6', 'occupied', 'Doctor Stranger'),
(8, 'kafi cibubur', 'G7', 'occupied', 'Doctor Stranger'),
(9, 'kafi cibubur', 'B1', 'occupied', 'Doctor Stranger'),
(10, 'kafi cibubur', 'B2', 'occupied', 'Doctor Stranger'),
(11, 'kafi cibubur', 'B3', 'occupied', 'Doctor Stranger'),
(12, 'kafi cibubur', 'A1', 'occupied', 'WEB DEVELOPER'),
(13, 'kafi cibubur', 'A2', 'occupied', 'WEB DEVELOPER'),
(14, 'kafi cibubur', 'A3', 'occupied', 'WEB DEVELOPER'),
(15, 'kafi cibubur', 'B5', 'occupied', 'Doctor Stranger');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `transaction_time` datetime NOT NULL,
  `username` varchar(250) NOT NULL,
  `seat_number` varchar(250) NOT NULL,
  `nama_film` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `status`, `payment_type`, `amount`, `transaction_time`, `username`, `seat_number`, `nama_film`) VALUES
(1, 'TIX-1740378303', 'settlement', 'qris', 30000, '2025-02-24 13:25:09', 'yuarichoirulkafikafi@gmail.com', 'A1,A2,A3', 'WEB DEVELOPER'),
(2, 'TIX-1740462503', 'settlement', 'qris', 20000, '2025-02-25 12:48:30', 'yuarichoirulkafikafi@gmail.com', 'B5', 'Doctor Stranger');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `created`) VALUES
(2, 'yuarichoirulkafikafi@gmail.com', 'PIKAPI', '$2y$10$UmX7Yy0fJC8gqgxUOQKBo.8FE.LIau61u62Chokk9.z7TyAjhFbFO', '2025-02-13 05:07:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akun_mall`
--
ALTER TABLE `akun_mall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `akun_mall`
--
ALTER TABLE `akun_mall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
