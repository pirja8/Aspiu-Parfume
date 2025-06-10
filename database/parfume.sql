-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 08:22 AM
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
-- Database: `parfume`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `created_at`) VALUES
(1, 'Perfume', NULL, '2024-12-05 09:04:21'),
(2, 'Oriental Notes', ' parfum yang memberikan aroma hangat, eksotis, dan mewah. ', '2024-12-08 05:20:28'),
(3, 'Woody Notes', ' Parfume yang memberikan karakter yang unik pada sebuah parfum. Mereka seringkali diasosiasikan dengan kehangatan, kedalaman, dan kesan maskulin. ', '2024-12-08 05:22:07'),
(4, 'Fresh Notes', 'parfum yang memberikan kesan pertama yang cerah, ceria, dan menyegarkan.  ', '2024-12-08 05:23:12'),
(5, 'Floral Notes', ' Aroma bunga memberikan kesan yang lembut, feminin, dan elegan  ', '2024-12-08 05:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `price`, `stock`, `image_url`, `created_at`, `weight`) VALUES
(2, 1, 'Armaf Club De Nuit EDP Set For Women', 'A popular perfume set.', 550000.00, 90, 'Asset/4.jpg', '2024-12-05 09:04:26', NULL),
(4, 1, 'Clinique Happy For Men 100ml EDT', 'A popular aroma set.', 900000.00, 94, 'Asset/5.jpg', '2024-12-05 09:22:20', NULL),
(5, 2, 'Carven Dans Ma Bulle De Fleurs EDT 100 ml', 'A burst of springtime freshness, this floral fragrance is light, airy, and perfect for everyday wear.', 1200000.00, 38, 'Asset/2.jpg', '2024-12-08 05:31:47', 1),
(6, 3, 'Avicenna La Femme (New) EDP 100 ml', 'A warm, woody scent with hints of spice.', 3500000.00, 45, 'Asset/3.jpg', '2024-12-08 06:11:54', 1),
(7, 4, 'Avicenna Starburst EDP 100 ml', 'A sweet, fruity perfume with a musky base', 1400000.00, 27, 'Asset/6.jpg', '2024-12-08 06:13:32', 1),
(8, 5, 'Abercrombie & Fitch Authentic Night For Men 100ml EDP', 'A fragrance for the man who thrives on living life with unapologeti', 770000.00, 50, 'Asset/1.jpg', '2024-12-08 06:29:21', 1),
(9, 2, 'Yves Saint Laurent Black Opium 90ml EDP', 'Perfume with a warm and exotic oriental scent', 799000.00, 30, 'Asset/7.jpg', '2024-12-08 06:50:34', 1),
(10, 3, 'Tom Ford Oud Wood 50ml EDP', 'A woody fragrance with unique depth and masculinity', 610000.00, 20, 'Asset/8.jpg', '2024-12-08 06:50:34', 1),
(11, 4, 'Dolce & Gabbana Light Blue 100ml EDT', 'A fresh, bright, and energetic fragrance', 530000.00, 40, 'Asset/9.jpg', '2024-12-08 06:50:34', 1),
(12, 5, 'Chanel No.5 100ml EDP', 'A floral fragrance embodying elegance and femininity', 545000.00, 25, 'Asset/10.jpg', '2024-12-08 06:50:34', 1),
(13, 2, 'Dior Addict 100ml EDP', 'An oriental scent that radiates warmth and luxury', 1400000.00, 35, 'Asset/11.jpg', '2024-12-08 06:50:34', 1),
(14, 3, 'Gucci Guilty Pour Homme 90ml EDT', 'A woody fragrance with a bold and masculine character', 1100000.00, 45, 'Asset/12.jpg', '2024-12-08 06:50:34', 1),
(15, 4, 'Versace Dylan Blue 100ml EDT', 'A fresh fragrance with citrus and aquatic notes', 980000.00, 50, 'Asset/13.jpg', '2024-12-08 06:50:34', 1),
(16, 5, 'Lanc?me La Vie Est Belle 75ml EDP', 'A floral fragrance representing joy and beauty', 1300000.00, 28, 'Asset/14.jpg', '2024-12-08 06:50:34', 1),
(17, 3, 'Montblanc Explorer 100ml EDP', 'A woody fragrance for the modern adventurer', 890000.00, 60, 'Asset/15.jpg', '2024-12-08 06:50:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status_transaksi` varchar(50) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `product_id`, `user_id`, `tanggal_transaksi`, `total_harga`, `status_transaksi`, `metode_pembayaran`) VALUES
(1, NULL, 5, '2024-12-08 19:07:37', 570000.00, 'Menunggu Pembayaran', 'bca'),
(2, NULL, 5, '2024-12-08 19:17:28', 575000.00, 'Menunggu Pembayaran', 'mandiri');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `created_at`, `Alamat`) VALUES
(1, 'ErikaZahrania', 'erikazahrania2@gmail.com', '$2y$10$UvsyFdEBfVTqLN0k9Rj/LusxASXOLbm6hoM2QnwTzHojh2gggH1cS', '088290416211', '2024-12-05 08:01:58', 'Jl. Kebon Jeruk No. 27, Jakarta Barat'),
(2, 'ErikaZahrania', '2310501059@mahasiswa.upnvj.ac.id', '$2y$10$.OQj04gZaTDkQIQLwGBvrOYT9vGVeR6PFJi3FEeO2mYkT88JvPQR6', '088290416211', '2024-12-05 08:02:16', 'Jl. Kemang Raya No. 15, Jakarta Selatan'),
(4, 'seojun', 'seojun161288@gmail.com', '$2y$10$GAsa6RXifsMJIyxU5E7qVun4TN4uiXYqNSqd1M4qSTj5uGJxz7LtC', '088290416211', '2024-12-08 07:58:32', 'JL.Muktikarya 3, Utan Kayu Utara, Matrman, Jakarta Timur'),
(5, 'firza', 'firzacahya4@gmail.com', '12345', '089510019090', '2024-12-08 14:14:41', 'jl.h.gaim no 32a'),
(6, 'Firza Cahya Desnita', 'firzacahyadesnita@gmail.com', '$2y$10$6PdtI6QSdV/9vUmyWIhFPeI7z1cWr5XEF0AteZ3YyOB3KoX29yr5a', '089510019090', '2025-06-07 12:52:24', 'jl m saidi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
