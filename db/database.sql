-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 04:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_sqli`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `role`) VALUES
(1, 'admin', 'admin', 'Quản trị viên', 'admin'),
(2, 'ductai', 'tai123456', 'Nguyễn Đức Tài', 'user'),
(4, 'hoang_admin', 'passAdmin1', 'Lê Huy Hoàng', 'admin'),
(5, 'phuong_admin', 'passAdmin2', 'Trần Thu Phương', 'admin'),
(6, 'minh_user', 'passUser1', 'Nguyễn Quang Minh', 'user'),
(7, 'lan_user', 'passUser2', 'Phạm Thị Lan', 'user'),
(8, 'tuan_user', 'passUser3', 'Lê Anh Tuấn', 'user'),
(9, 'huong_user', 'passUser4', 'Vũ Thu Hương', 'user'),
(10, 'dung_user', 'passUser5', 'Hoàng Văn Dũng', 'user'),
(11, 'thuy_user', 'passUser6', 'Nguyễn Thanh Thủy', 'user'),
(12, 'nam_user', 'passUser7', 'Đặng Thành Nam', 'user'),
(13, 'linh_user', 'passUser8', 'Trần Diệu Linh', 'user'),
(14, 'khanh_user', 'passUser9', 'Bùi Quốc Khánh', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
