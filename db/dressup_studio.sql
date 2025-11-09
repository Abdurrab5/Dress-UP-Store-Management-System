-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 02:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dressup_studio`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cartitem`
--

INSERT INTO `cartitem` (`id`, `customer_id`, `product_id`, `quantity`, `total_amount`, `created_at`) VALUES
(2, 58, 1, 3, '99.00', '2025-08-15 11:21:07'),
(4, 57, 1, 7, '231.00', '2025-08-15 17:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Kids'),
(2, 'Men'),
(3, 'Women'),
(4, 'perfume'),
(5, 'personal care'),
(6, 'baby essential');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `firstname`, `lastname`, `email`, `password`, `role`, `phone`, `address`) VALUES
(10, 'aree', 'ba', 'aree@gmail.com', '$2y$10$XNM0e2SejUULoTB5AVqDvur3YdT6YdoxiKAcZxy687v6cGK.RV02i', 'customer', NULL, NULL),
(12, 'user', 'default', 'default@gmail.com', '$2y$10$rItWdf26Q9ytrNJNy708tOwXsNUvsZ28kYhWlcUOGSQCJ9tWoCHnK', 'customer', NULL, NULL),
(13, 'sana', 'shah', 'test@gmail.com', '$2y$10$zzs8Up.bkTCdkVQbRj.F/eATUyrg6thtCIhM1Y49k7Hr39s1i1Rwe', 'customer', NULL, NULL),
(14, 'alka', 'alka', 'alka@gmail.com', '$2y$10$tmIJljJDGDbGvyQUWbeZ7ucqQXvfxN7uK1NeOUkWpVLiExPL2Tmuq', 'customer', NULL, NULL),
(15, 'ayesha', 'suleman', 'ayesha@gmail.com', '$2y$10$BDGLvWV9sAl/20crYVuOO.4KotfJsx0oYo.aN0EdmvzpfxyXJ5FDG', 'customer', NULL, NULL),
(17, 'hl', 'll', 'kh@gmail.com', '$2y$10$vs6EESVk9OwE27lJ1dK42uLu.6DvtgcfeGIOz3yggspZrUR0sSuX.', 'customer', NULL, NULL),
(20, 'Admin', NULL, 'alkadarshan08@gmail.com', '$2y$10$b7cE0wmYgR8GVvRHo6UpquV8wvNSn.hx0x.KZ0W0AKOY90pMndn5q', 'admin', NULL, NULL),
(23, 'good', 'bad', 'good@gmail.com', '$2y$10$gszqZfAhfjU8k7VbrqikXezQc0HIR/h4fXzN4H9o3f77fALp3XVWC', 'customer', NULL, NULL),
(31, 'alka', 'darshan', 'a@gmail.com', '$2y$10$6ZlDZYoyGx.r0H0r8L4uy.zHA8/8nBl0Shd7dGNQZWBQVbMvYuCl.', 'customer', NULL, NULL),
(39, 'Alka', 'Darshan', 'default@gmail.com', '$2y$10$oferj5IIfKWhFXxyjUhXL.w31apq0YE7LJL6Cu7FY3Z60nkriIwWa', 'customer', NULL, NULL),
(40, 'Alka', 'Darshan', 'default@gmail.com', '$2y$10$WoXbXqTLzGxPwWlCxmYUiOzT5OPkh6Rn4IbARfIW9.OVNAbkaB9Dy', 'customer', NULL, NULL),
(41, 'root', 'root', 'root@gmail.com', '$2y$10$SqcmuKTtyHGh/iDQpVhjYO6m7RSYd6Q3LTIs5U76TFVABFs645Zme', 'customer', NULL, NULL),
(51, 'cd', 'cdi', 'cd@gmail.com', '$2y$10$/BKd8b3tKvXmT9VOt/vRh.HPKs2XKFAw0aOeB.PWElbPB7N9n3EDO', 'customer', NULL, NULL),
(52, 'cd', 'cdi', 'cd@gmail.com', '$2y$10$EVZQcQIPM8/GeTdL7Cqig.hLJIGHRRzpc6zmx4FbU/U6MAxsIkmOa', 'customer', NULL, NULL),
(57, 'ak', 'aka ', 'aka@gmail.com', '$2y$10$ZrA49IT1X723mBxcVzqLJ.w5m5wBikTf5bsfgGFWFh8ZGphdX3.5u', 'customer', NULL, NULL),
(62, 'a', 'b', 'c@gmail.com', '$2y$10$gUP1s00Qd88jtSSEMyUgT.V8EZZ1sfvGY4dhH.IWMvoRFAYpQ990u', 'customer', NULL, NULL),
(64, 'admin', NULL, 'admin@gmail.com', '$2y$10$.X7Ls/AyS1q3YbQs9SvTGOK1/HoGSHzWCFC0qW4afdQnK3lZiLUoC', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `cart_data` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_name`, `user_email`, `address`, `city`, `phone`, `payment_method`, `cart_data`, `status`, `created_at`) VALUES
(1, 'ayesha', 'ayesha@gmail.com', 'RA Bazar lal kurti', 'Nowshera', '9827943678', 'JazzCash', '[{\"id\":102,\"name\":\"Baby Girl Pink Chicken Fancy Cotton Frock\",\"price\":\"Rs. 2,890\",\"image\":\"coton frock.webp\",\"quantity\":1},{\"id\":2,\"name\":\"Fusion\",\"price\":\"Rs. 3,500\",\"image\":\" perfume 3500.webp\",\"quantity\":2},{\"id\":3,\"name\":\"Bluetooth Headphones\",\"price\":\"Rs 999\",\"image\":\"bluthoth.webp\",\"quantity\":1},{\"id\":1,\"name\":\"Silver Grey Elegant Dress\",\"price\":\"Rs 2499\",\"image\":\"dress.webp\",\"quantity\":1}]', 'Pending', '2025-07-16 13:31:13'),
(2, 'user', 'default@gmail.com', 'igt8iyfouugvljbh ', 'jookihu', '0987085806', 'COD', '[{\"id\":102,\"name\":\"Baby Girl Pink Chicken Fancy Cotton Frock\",\"price\":\"Rs. 2,890\",\"image\":\"coton frock.webp\",\"quantity\":1}]', 'Pending', '2025-07-28 05:26:31'),
(3, '', '', 'biquvd', 'hbqiv', '97698589649', 'COD', '[]', 'Pending', '2025-08-13 23:23:49'),
(4, 'ak aka ', 'aka@gmail.com', 'xxxasx', 'sxs', '121344445555', 'Cash on Delivery', '[{\"product_id\":1,\"quantity\":3,\"name\":\"ww\",\"price\":\"33.00\",\"total_amount\":\"99.00\"}]', 'pending', '2025-08-15 15:10:55'),
(5, 'ak aka ', 'aka@gmail.com', 'xxs', 'sxsx', '12345', 'Cash on Delivery', '[{\"product_id\":1,\"quantity\":3,\"name\":\"ww\",\"price\":\"33.00\",\"total_amount\":\"99.00\"}]', 'pending', '2025-08-15 15:46:58'),
(6, 'ak aka ', 'aka@gmail.com', 'sdasd', 'dasd', '23133', 'COD', '[{\"id\":1,\"name\":\"Silver Grey Elegant Dress\",\"price\":\"Rs 2499\",\"image\":\"dress.webp\",\"quantity\":1}]', 'Pending', '2025-08-15 17:40:25'),
(7, '', '', 'sssc', 'xcxc', '2323323', 'COD', '[]', 'Pending', '2025-08-19 10:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `image`, `category_id`) VALUES
(1, 'women shirt', '33.00', 3, 'images/1755252093_istockphoto-1137620184-2048x2048.jpg', 3),
(2, 'safsads', '2323.00', 233, 'images/1755271142_images__2_.jpg', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`,`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitem`
--
ALTER TABLE `cartitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
