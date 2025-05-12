-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 10:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `Category` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `Category`, `Date`) VALUES
(1, 'Electronics', '2022-12-07 18:04:16'),
(2, 'Furniture', '2022-12-07 18:04:20'),
(3, 'Clothing', '2022-12-07 18:04:24'),
(4, 'Books', '2022-12-07 18:04:27'),
(5, 'Toys', '2022-12-07 18:04:31'),
(6, 'Groceries', '2022-12-07 18:04:36'),
(7, 'Sports', '2022-12-07 18:04:41'),
(8, 'Automotive', '2022-12-07 18:04:45'),
(9, 'Health & Beauty', '2022-12-07 18:04:49'),
(10, 'Home & Garden', '2022-12-07 18:04:53'),
(11, 'Food', '2022-12-07 18:04:53'),
(12, 'Drinks', '2022-12-07 18:04:53'),
(13, 'Other', '2022-12-07 18:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `idDocument` int(11) NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `purchases` int(11) NOT NULL,
  `lastPurchase` datetime NOT NULL,
  `registerDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `idDocument`, `email`, `phone`, `address`, `birthdate`, `purchases`, `lastPurchase`, `registerDate`) VALUES
(1, 'Abebe Bekele', 123456, 'abebe@mail.com', '(251) 911-123456', 'Addis Ababa', '1986-01-05', 15, '2018-12-03 00:01:21', '2022-12-10 13:41:42'),
(2, 'Alemu Tadesse', 121212, 'alemu@mail.com', '(251) 911-789012', 'Bahir Dar', '1983-06-22', 3, '2022-12-08 12:20:28', '2022-12-10 13:41:27'),
(3, 'Kebede Alemayehu', 122458, 'kebede@mail.com', '(251) 911-345678', 'Gondar', '1989-04-12', 0, '2022-12-08 12:18:43', '2022-12-10 13:40:27'),
(4, 'Mulugeta Tesfaye', 103698, 'mulugeta@mail.com', '(251) 911-456789', 'Hawassa', '1989-08-15', 5, '2022-12-10 08:42:36', '2022-12-10 13:42:36'),
(6, 'Tigist Mekonnen', 852100, 'tigist@mail.com', '(251) 911-567890', 'Jimma', '1990-10-16', 36, '2022-12-07 13:17:31', '2022-12-08 18:11:56'),
(7, 'Hana Gebremedhin', 100254, 'hana@mail.com', '(251) 911-678901', 'Mekelle', '1989-12-12', 4, '2022-12-10 08:38:47', '2022-12-10 13:38:47'),
(8, 'Selamawit Fikre', 178500, 'selamawit@mail.com', '(251) 911-789012', 'Dire Dawa', '1990-12-07', 7, '2022-12-10 12:40:02', '2022-12-10 17:40:02'),
(9, 'Yonas Assefa', 178500, 'yonas@mail.com', '(251) 911-890123', 'Adama', '1988-04-16', 18, '2022-12-10 08:43:42', '2022-12-10 13:43:42'),
(10, 'Liya', 101014, 'liya@mail.com', '(251) 911-901234', 'Harar', '1992-02-22', 0, '0000-00-00 00:00:00', '2022-12-10 17:12:55'),
(11, 'Tesfaye Bekele', 100147, 'tesfaye@mail.com', '(251) 911-012345', 'Gambela', '1985-04-19', 13, '2022-12-10 12:35:52', '2022-12-10 17:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `stock` int(11) NOT NULL,
  `buyingPrice` float NOT NULL,
  `sellingPrice` float NOT NULL,
  `sales` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `idCategory`, `code`, `description`, `image`, `stock`, `buyingPrice`, `sellingPrice`, `sales`, `date`) VALUES
(69, 6, '601', 'Teff Flour', 'views/img/products/default/anonymous.png', 100, 50, 70, 0, '2022-12-10 17:40:02'),
(70, 6, '602', 'Injera', 'views/img/products/default/anonymous.png', 200, 2, 3, 0, '2022-12-10 17:40:02'),
(71, 6, '603', 'Berbere Spice', 'views/img/products/default/anonymous.png', 150, 20, 30, 0, '2022-12-10 17:40:02'),
(72, 6, '604', 'Shiro Powder', 'views/img/products/default/anonymous.png', 120, 15, 25, 0, '2022-12-10 17:40:02'),
(73, 6, '605', 'Coffee Beans', 'views/img/products/default/anonymous.png', 80, 100, 150, 0, '2022-12-10 17:40:02'),
(74, 6, '606', 'Honey', 'views/img/products/default/anonymous.png', 60, 50, 75, 0, '2022-12-10 17:40:02'),
(75, 6, '607', 'Ethiopian Butter', 'views/img/products/default/anonymous.png', 70, 40, 60, 0, '2022-12-10 17:40:02'),
(76, 6, '608', 'Kolo', 'views/img/products/default/anonymous.png', 90, 10, 15, 0, '2022-12-10 17:40:02'),
(77, 6, '609', 'Doro Wat', 'views/img/products/default/anonymous.png', 50, 80, 120, 0, '2022-12-10 17:40:02'),
(78, 6, '610', 'Kitfo', 'views/img/products/default/anonymous.png', 40, 100, 150, 0, '2022-12-10 17:40:02'),
(79, 6, '611', 'Tibs', 'views/img/products/default/anonymous.png', 60, 70, 100, 0, '2022-12-10 17:40:02'),
(80, 6, '612', 'Gomen', 'views/img/products/default/anonymous.png', 100, 30, 45, 0, '2022-12-10 17:40:02'),
(81, 6, '613', 'Misir Wat', 'views/img/products/default/anonymous.png', 110, 25, 35, 0, '2022-12-10 17:40:02'),
(82, 6, '614', 'Alicha', 'views/img/products/default/anonymous.png', 90, 20, 30, 0, '2022-12-10 17:40:02'),
(83, 6, '615', 'Awaze', 'views/img/products/default/anonymous.png', 80, 15, 25, 0, '2022-12-10 17:40:02'),
(84, 6, '616', 'Mitmita', 'views/img/products/default/anonymous.png', 70, 10, 20, 0, '2022-12-10 17:40:02'),
(85, 6, '617', 'Kita', 'views/img/products/default/anonymous.png', 100, 5, 8, 0, '2022-12-10 17:40:02'),
(86, 6, '618', 'Genfo', 'views/img/products/default/anonymous.png', 90, 10, 15, 0, '2022-12-10 17:40:02'),
(87, 6, '619', 'Firfir', 'views/img/products/default/anonymous.png', 80, 20, 30, 0, '2022-12-10 17:40:02'),
(88, 6, '620', 'Chechebsa', 'views/img/products/default/anonymous.png', 70, 15, 25, 0, '2022-12-10 17:40:02'),
(89, 6, '621', 'Atayef', 'views/img/products/default/anonymous.png', 60, 25, 35, 0, '2022-12-10 17:40:02'),
(90, 6, '622', 'Baklava', 'views/img/products/default/anonymous.png', 50, 30, 45, 0, '2022-12-10 17:40:02'),
(91, 6, '623', 'Buna', 'views/img/products/default/anonymous.png', 100, 5, 10, 0, '2022-12-10 17:40:02'),
(92, 6, '624', 'Tella', 'views/img/products/default/anonymous.png', 80, 10, 15, 0, '2022-12-10 17:40:02'),
(93, 6, '625', 'Tej', 'views/img/products/default/anonymous.png', 70, 20, 30, 0, '2022-12-10 17:40:02'),
(94, 6, '626', 'Areke', 'views/img/products/default/anonymous.png', 60, 25, 35, 0, '2022-12-10 17:40:02'),
(95, 6, '627', 'Beso', 'views/img/products/default/anonymous.png', 50, 10, 15, 0, '2022-12-10 17:40:02'),
(96, 6, '628', 'Dabo', 'views/img/products/default/anonymous.png', 100, 5, 8, 0, '2022-12-10 17:40:02'),
(97, 6, '629', 'Ambasha', 'views/img/products/default/anonymous.png', 90, 10, 15, 0, '2022-12-10 17:40:02'),
(98, 6, '630', 'Kolo', 'views/img/products/default/anonymous.png', 80, 5, 8, 0, '2022-12-10 17:40:02'),
(99, 6, '631', 'Fossolia', 'views/img/products/default/anonymous.png', 70, 15, 25, 0, '2022-12-10 17:40:02'),
(100, 6, '632', 'Azifa', 'views/img/products/default/anonymous.png', 60, 10, 15, 0, '2022-12-10 17:40:02'),
(101, 6, '633', 'Gomen Kitfo', 'views/img/products/default/anonymous.png', 50, 20, 30, 0, '2022-12-10 17:40:02'),
(102, 6, '634', 'Tihlo', 'views/img/products/default/anonymous.png', 100, 10, 15, 0, '2022-12-10 17:40:02'),
(103, 6, '635', 'Dulet', 'views/img/products/default/anonymous.png', 90, 20, 30, 0, '2022-12-10 17:40:02'),
(104, 6, '636', 'Enkulal Firfir', 'views/img/products/default/anonymous.png', 80, 15, 25, 0, '2022-12-10 17:40:02'),
(105, 6, '637', 'Fetira', 'views/img/products/default/anonymous.png', 70, 10, 15, 0, '2022-12-10 17:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idSeller` int(11) NOT NULL,
  `products` text NOT NULL,
  `tax` int(11) NOT NULL,
  `netPrice` float NOT NULL,
  `totalPrice` float NOT NULL,
  `paymentMethod` text NOT NULL,
  `saledate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `code`, `idCustomer`, `idSeller`, `products`, `tax`, `netPrice`, `totalPrice`, `paymentMethod`, `saledate`) VALUES
(12, 10014, 5, 2, '[{\"id\":\"70\",\"description\":\"Injera\",\"quantity\":\"10\",\"stock\":\"190\",\"price\":\"3\",\"totalPrice\":\"30\"}]', 2, 30, 32, 'cash', '2022-12-11 10:15:00'),
(13, 10015, 1, 3, '[{\"id\":\"73\",\"description\":\"Coffee Beans\",\"quantity\":\"5\",\"stock\":\"75\",\"price\":\"150\",\"totalPrice\":\"750\"}]', 15, 750, 765, 'credit', '2022-12-11 11:20:00'),
(14, 10016, 4, 1, '[{\"id\":\"75\",\"description\":\"Ethiopian Butter\",\"quantity\":\"2\",\"stock\":\"68\",\"price\":\"60\",\"totalPrice\":\"120\"}]', 6, 120, 126, 'debit', '2022-12-11 12:30:00'),
(15, 10017, 7, 2, '[{\"id\":\"77\",\"description\":\"Doro Wat\",\"quantity\":\"3\",\"stock\":\"47\",\"price\":\"120\",\"totalPrice\":\"360\"}]', 18, 360, 378, 'cash', '2022-12-11 13:45:00'),
(16, 10018, 3, 1, '[{\"id\":\"80\",\"description\":\"Gomen\",\"quantity\":\"4\",\"stock\":\"96\",\"price\":\"45\",\"totalPrice\":\"180\"}]', 9, 180, 189, 'credit', '2022-12-11 14:50:00'),
(17, 10019, 6, 3, '[{\"id\":\"82\",\"description\":\"Alicha\",\"quantity\":\"6\",\"stock\":\"84\",\"price\":\"30\",\"totalPrice\":\"180\"}]', 12, 180, 192, 'debit', '2022-12-11 15:55:00'),
(18, 10020, 2, 1, '[{\"id\":\"85\",\"description\":\"Kita\",\"quantity\":\"8\",\"stock\":\"92\",\"price\":\"8\",\"totalPrice\":\"64\"}]', 3, 64, 67, 'cash', '2022-12-11 17:00:00'),
(19, 10021, 8, 2, '[{\"id\":\"88\",\"description\":\"Chechebsa\",\"quantity\":\"7\",\"stock\":\"63\",\"price\":\"25\",\"totalPrice\":\"175\"}]', 7, 175, 182, 'credit', '2022-12-11 18:05:00'),
(20, 10022, 9, 3, '[{\"id\":\"91\",\"description\":\"Buna\",\"quantity\":\"9\",\"stock\":\"91\",\"price\":\"10\",\"totalPrice\":\"90\"}]', 5, 90, 95, 'debit', '2022-12-11 19:10:00'),
(21, 10023, 10, 1, '[{\"id\":\"94\",\"description\":\"Areke\",\"quantity\":\"3\",\"stock\":\"57\",\"price\":\"35\",\"totalPrice\":\"105\"}]', 10, 105, 115, 'cash', '2022-12-11 20:15:00'),
(22, 10024, 11, 2, '[{\"id\":\"97\",\"description\":\"Ambasha\",\"quantity\":\"5\",\"stock\":\"85\",\"price\":\"15\",\"totalPrice\":\"75\"}]', 4, 75, 79, 'credit', '2022-12-11 21:20:00'),
(23, 10025, 0, 1, '', 0, 0, 0, 'cash', '2025-01-12 21:31:28'),
(24, 10026, 2, 3, '[{\"id\":\"70\",\"description\":\"Injera\",\"quantity\":\"10\",\"stock\":\"180\",\"price\":\"3\",\"totalPrice\":\"30\"}]', 2, 30, 32, 'credit', '2022-12-12 08:00:00'),
(25, 10027, 3, 1, '[{\"id\":\"71\",\"description\":\"Berbere Spice\",\"quantity\":\"7\",\"stock\":\"143\",\"price\":\"30\",\"totalPrice\":\"210\"}]', 5, 210, 215, 'debit', '2022-12-12 09:00:00'),
(26, 10028, 4, 2, '[{\"id\":\"72\",\"description\":\"Shiro Powder\",\"quantity\":\"3\",\"stock\":\"117\",\"price\":\"25\",\"totalPrice\":\"75\"}]', 3, 75, 78, 'cash', '2022-12-12 10:00:00'),
(27, 10029, 5, 3, '[{\"id\":\"73\",\"description\":\"Coffee Beans\",\"quantity\":\"2\",\"stock\":\"78\",\"price\":\"150\",\"totalPrice\":\"300\"}]', 15, 300, 315, 'credit', '2022-12-12 11:00:00'),
(28, 10030, 6, 1, '[{\"id\":\"74\",\"description\":\"Honey\",\"quantity\":\"4\",\"stock\":\"56\",\"price\":\"75\",\"totalPrice\":\"300\"}]', 12, 300, 312, 'debit', '2022-12-12 12:00:00'),
(29, 10031, 7, 2, '[{\"id\":\"75\",\"description\":\"Ethiopian Butter\",\"quantity\":\"1\",\"stock\":\"69\",\"price\":\"60\",\"totalPrice\":\"60\"}]', 6, 60, 66, 'cash', '2022-12-12 13:00:00'),
(30, 10032, 8, 3, '[{\"id\":\"76\",\"description\":\"Kolo\",\"quantity\":\"5\",\"stock\":\"85\",\"price\":\"15\",\"totalPrice\":\"75\"}]', 4, 75, 79, 'credit', '2022-12-12 14:00:00'),
(31, 10033, 9, 1, '[{\"id\":\"77\",\"description\":\"Doro Wat\",\"quantity\":\"3\",\"stock\":\"47\",\"price\":\"120\",\"totalPrice\":\"360\"}]', 18, 360, 378, 'debit', '2022-12-12 15:00:00'),
(32, 10034, 10, 2, '[{\"id\":\"78\",\"description\":\"Kitfo\",\"quantity\":\"2\",\"stock\":\"38\",\"price\":\"150\",\"totalPrice\":\"300\"}]', 15, 300, 315, 'cash', '2022-12-12 16:00:00'),
(33, 10035, 11, 3, '[{\"id\":\"79\",\"description\":\"Tibs\",\"quantity\":\"4\",\"stock\":\"56\",\"price\":\"100\",\"totalPrice\":\"400\"}]', 20, 400, 420, 'credit', '2022-12-12 17:00:00'),
(34, 10036, 1, 2, '[{\"id\":\"70\",\"description\":\"Injera\",\"quantity\":\"5\",\"stock\":\"175\",\"price\":\"3\",\"totalPrice\":\"15\"}]', 1, 15, 16, 'cash', '2022-12-13 06:00:00'),
(35, 10037, 2, 3, '[{\"id\":\"73\",\"description\":\"Coffee Beans\",\"quantity\":\"3\",\"stock\":\"72\",\"price\":\"150\",\"totalPrice\":\"450\"}]', 10, 450, 460, 'credit', '2022-12-13 07:00:00'),
(36, 10038, 3, 1, '[{\"id\":\"75\",\"description\":\"Ethiopian Butter\",\"quantity\":\"4\",\"stock\":\"65\",\"price\":\"60\",\"totalPrice\":\"240\"}]', 12, 240, 252, 'debit', '2022-12-13 08:00:00'),
(37, 10039, 4, 2, '[{\"id\":\"77\",\"description\":\"Doro Wat\",\"quantity\":\"2\",\"stock\":\"45\",\"price\":\"120\",\"totalPrice\":\"240\"}]', 5, 240, 245, 'cash', '2022-12-13 09:00:00'),
(38, 10040, 5, 3, '[{\"id\":\"80\",\"description\":\"Gomen\",\"quantity\":\"6\",\"stock\":\"90\",\"price\":\"45\",\"totalPrice\":\"270\"}]', 8, 270, 278, 'credit', '2022-12-13 10:00:00'),
(39, 10041, 6, 1, '[{\"id\":\"82\",\"description\":\"Alicha\",\"quantity\":\"3\",\"stock\":\"81\",\"price\":\"30\",\"totalPrice\":\"90\"}]', 3, 90, 93, 'debit', '2022-12-13 11:00:00'),
(40, 10042, 7, 2, '[{\"id\":\"85\",\"description\":\"Kita\",\"quantity\":\"7\",\"stock\":\"85\",\"price\":\"8\",\"totalPrice\":\"56\"}]', 2, 56, 58, 'cash', '2022-12-13 12:00:00'),
(41, 10043, 8, 3, '[{\"id\":\"88\",\"description\":\"Chechebsa\",\"quantity\":\"4\",\"stock\":\"59\",\"price\":\"25\",\"totalPrice\":\"100\"}]', 4, 100, 104, 'credit', '2022-12-13 13:00:00'),
(42, 10044, 9, 1, '[{\"id\":\"91\",\"description\":\"Buna\",\"quantity\":\"6\",\"stock\":\"85\",\"price\":\"10\",\"totalPrice\":\"60\"}]', 3, 60, 63, 'debit', '2022-12-13 14:00:00'),
(43, 10045, 10, 2, '[{\"id\":\"94\",\"description\":\"Areke\",\"quantity\":\"5\",\"stock\":\"52\",\"price\":\"35\",\"totalPrice\":\"175\"}]', 7, 175, 182, 'cash', '2022-12-13 15:00:00'),
(44, 10046, 11, 3, '[{\"id\":\"97\",\"description\":\"Ambasha\",\"quantity\":\"2\",\"stock\":\"83\",\"price\":\"15\",\"totalPrice\":\"30\"}]', 1, 30, 31, 'credit', '2022-12-13 16:00:00'),
(45, 10047, 1, 2, '[{\"id\":\"69\",\"description\":\"Teff Flour\",\"quantity\":\"6\",\"stock\":\"89\",\"price\":\"70\",\"totalPrice\":\"420\"}]', 14, 420, 434, 'cash', '2022-12-13 17:00:00'),
(46, 10048, 2, 3, '[{\"id\":\"70\",\"description\":\"Injera\",\"quantity\":\"8\",\"stock\":\"172\",\"price\":\"3\",\"totalPrice\":\"24\"}]', 2, 24, 26, 'credit', '2022-12-13 18:00:00'),
(47, 10049, 3, 1, '[{\"id\":\"71\",\"description\":\"Berbere Spice\",\"quantity\":\"5\",\"stock\":\"138\",\"price\":\"30\",\"totalPrice\":\"150\"}]', 5, 150, 155, 'debit', '2022-12-13 19:00:00'),
(48, 10050, 4, 2, '[{\"id\":\"72\",\"description\":\"Shiro Powder\",\"quantity\":\"7\",\"stock\":\"110\",\"price\":\"25\",\"totalPrice\":\"175\"}]', 7, 175, 182, 'cash', '2022-12-13 20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `profile` text NOT NULL,
  `photo` text NOT NULL,
  `status` int(1) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `profile`, `photo`, `status`, `lastLogin`, `date`) VALUES
(1, 'Administrator', 'admin', '$2a$07$asxx54ahjppf45sd87a5auocez6RMakDlpq9ZaGGtz8hvLTuk6j5a', 'Administrator', 'views/img/users/admin/admin-icn.png', 1, '2025-01-13 02:00:24', '2025-01-12 23:00:24'),
(4, 'Nathan Mesfin', 'nunu', '$2a$07$asxx54ahjppf45sd87a5auF2xkMiZ2i3FPuGP4Ot4n/buTWraVb5u', 'seller', 'views/img/users/nunu/796.jpg', 1, '2025-01-13 01:26:58', '2025-01-12 22:26:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
