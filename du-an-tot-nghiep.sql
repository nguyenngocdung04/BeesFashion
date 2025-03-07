-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2025 at 07:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du-an-tot-nghiep`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên thuộc tính',
  `attribute_type_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Loại thuộc tính (color, button,...)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `attribute_type_id`, `created_at`, `updated_at`) VALUES
(1, 'Color', 1, '2024-11-14 23:15:49', '2024-11-15 00:39:46'),
(2, 'Size', 2, '2024-11-14 23:15:49', '2024-11-15 00:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_types`
--

CREATE TABLE `attribute_types` (
  `id` bigint UNSIGNED NOT NULL,
  `type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_types`
--

INSERT INTO `attribute_types` (`id`, `type_name`, `created_at`, `updated_at`) VALUES
(1, 'color', '2024-11-15 00:39:32', '2024-11-15 00:39:32'),
(2, 'button', '2024-11-15 00:39:37', '2024-11-15 00:39:37'),
(4, 'radio', '2024-12-02 03:53:08', '2024-12-02 03:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên giá trị thuộc tính',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định giá trị thuộc tính này thuộc về thuộc tính nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `name`, `value`, `attribute_id`, `created_at`, `updated_at`) VALUES
(1, 'White', '#ffffff', 1, '2024-11-14 23:15:49', '2024-12-02 03:59:45'),
(2, 'S', NULL, 2, '2024-11-14 23:15:49', '2024-11-14 23:15:49'),
(3, 'M', NULL, 2, '2024-11-14 23:15:49', '2024-11-14 23:15:49'),
(4, 'L', NULL, 2, '2024-11-14 23:15:49', '2024-11-14 23:15:49'),
(5, 'XL', NULL, 2, '2024-11-14 23:15:49', '2024-11-14 23:15:49'),
(6, 'Light Gray', '#D3D3D3', 1, '2024-11-14 23:15:49', '2024-12-02 04:00:31'),
(7, 'Dark Gray', '#808080', 1, '2024-11-14 23:15:49', '2024-12-02 04:00:38'),
(8, 'Brown', '#964B00', 1, '2024-11-14 23:15:49', '2024-12-02 04:00:48'),
(9, 'Black', '#000000', 1, '2024-12-02 03:58:49', '2024-12-02 03:59:54'),
(10, 'Beige', '#F5F5DC', 1, '2024-12-02 11:02:53', '2024-12-02 11:02:53'),
(11, 'Olive Green', '#556B2F', 1, '2024-12-02 11:02:53', '2024-12-02 11:02:53'),
(12, 'Light Pink', '#FFC0CB', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(13, 'Light Blue', '#ADD8E6', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(14, 'Light Yellow', '#FAFAD2', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(15, 'Lavender', '#E6E6FA', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(16, 'Bright Red', '#FF0000', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(17, 'Burnt Orange', '#FF4500', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(18, 'Burgundy', '#800020', 1, '2024-12-02 11:04:28', '2024-12-02 11:04:28'),
(21, 'Dark Green', '#006400', 1, '2024-12-02 11:17:23', '2024-12-02 11:17:23'),
(22, 'Golden Yellow', '#FFD700', 1, '2024-12-02 11:17:23', '2024-12-02 11:17:23'),
(30, '26', NULL, 2, '2024-12-03 12:07:03', '2024-12-03 12:07:03'),
(31, '27', NULL, 2, '2024-12-03 12:07:03', '2024-12-03 12:07:03'),
(32, '28', NULL, 2, '2024-12-03 12:07:35', '2024-12-03 12:07:35'),
(33, '29', NULL, 2, '2024-12-03 12:07:35', '2024-12-03 12:07:35'),
(34, '30', NULL, 2, '2024-12-03 12:07:35', '2024-12-03 12:07:35'),
(35, '31', NULL, 2, '2024-12-03 12:07:35', '2024-12-03 12:07:35'),
(36, '32', NULL, 2, '2024-12-03 12:08:28', '2024-12-03 12:08:28'),
(37, 'Dark Blue', '#05045d', 1, '2024-12-03 05:14:05', '2024-12-03 05:14:05'),
(38, 'Dark Beige', '#b7ac76', 1, '2024-12-03 05:22:40', '2024-12-03 05:22:40'),
(39, 'XXL', NULL, 2, '2024-12-03 12:35:13', '2024-12-03 12:35:13'),
(40, '35', NULL, 2, '2024-12-05 10:27:27', '2024-12-05 10:27:27'),
(41, '36', NULL, 2, '2024-12-05 10:27:27', '2024-12-05 10:27:27'),
(42, '37', NULL, 2, '2024-12-05 10:27:58', '2024-12-05 10:27:58'),
(43, '38', NULL, 2, '2024-12-05 10:27:58', '2024-12-05 10:27:58'),
(44, '39', NULL, 2, '2024-12-05 10:27:58', '2024-12-05 10:27:58'),
(45, '40', NULL, 2, '2024-12-05 10:27:58', '2024-12-05 10:27:58'),
(46, '41', NULL, 2, '2024-12-05 10:27:58', '2024-12-05 10:27:58'),
(47, '42', NULL, 2, '2024-12-05 10:29:01', '2024-12-05 10:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên banner',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động, mặc định là 1(đã kích hoạt)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'Shop', 1, '2024-12-04 10:36:08', '2024-12-04 10:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `banner_images`
--

CREATE TABLE `banner_images` (
  `id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên file',
  `banner_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định những ảnh này thuộc banner nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_images`
--

INSERT INTO `banner_images` (`id`, `file_name`, `banner_id`, `created_at`, `updated_at`) VALUES
(10, 'oFcQ1DaZocH5t1knfrKWMcBOv1C9Pd1NNkxALB5e.png', 4, '2024-12-04 10:36:08', '2024-12-04 10:36:08'),
(11, 'eovHXRwp1n6lQFSuSZ8JCkQ57s2iZ3ri7m4hDrBY.png', 4, '2024-12-04 10:36:08', '2024-12-04 10:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên thương hiệu',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ảnh thương hiệu',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động thương hiệu, (mặc định là 1)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Nike', 'hxIoiWmUdBMrOk4vmYuVCdDSk4BFS5Cum9rmALIU.jpg', 1, '2024-11-14 23:09:15', '2024-12-04 11:20:55'),
(6, 'Louis Vuitton', '02bevOQBrhms83rvsvk7mfYlyPxrMFWS9NOLA6FA.jpg', 1, '2024-11-14 23:09:42', '2024-12-04 11:21:22'),
(7, 'Gucci', 'i9N118rhmbVoSs8sGFqVCoRuOLIq0EKiJfJUtvA9.png', 1, '2024-11-14 23:10:00', '2024-12-04 12:08:00'),
(8, 'Adidas', 'K2wbzSSEF5GoKS3glkrfgnpuJgwahnu4WfGzlkn9.jpg', 1, '2024-11-27 23:40:42', '2024-12-04 11:21:13'),
(9, 'Versace', '67509ea1b7df6.jpg', 1, '2024-12-04 11:25:37', '2024-12-04 11:25:37'),
(10, 'D&G', '67509ecc07973.jpg', 1, '2024-12-04 11:26:20', '2024-12-04 11:26:20'),
(11, 'Puma', '67509ee3aa0fc.jpg', 1, '2024-12-04 11:26:43', '2024-12-04 11:26:43'),
(12, 'Prada', '67509efb0ebb2.jpg', 1, '2024-12-04 11:27:07', '2024-12-04 11:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL COMMENT 'Số lượng sản phẩm trong giỏ hàng',
  `product_variant_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định biến thể được thêm vào giỏ hàng',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào đã thêm sản phẩm vào giỏ hàng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `quantity`, `product_variant_id`, `user_id`, `created_at`, `updated_at`) VALUES
(17, 1, 119, 5, '2024-12-05 19:33:14', '2024-12-05 19:33:14'),
(45, 1, 21, 11, '2024-12-12 09:21:38', '2024-12-12 09:21:38'),
(46, 1, 37, 11, '2024-12-12 09:21:58', '2024-12-12 09:21:58'),
(47, 2, 34, 11, '2024-12-12 09:22:15', '2024-12-12 09:22:21'),
(50, 100, 96, 11, '2024-12-12 10:59:30', '2024-12-12 10:59:30'),
(51, 100, 93, 11, '2024-12-12 10:59:58', '2024-12-12 10:59:58'),
(52, 100, 94, 11, '2024-12-12 11:00:11', '2024-12-12 11:00:18'),
(62, 1, 37, 3, '2024-12-15 08:53:30', '2024-12-16 03:45:50'),
(63, 1, 50, 3, '2024-12-16 02:56:24', '2024-12-16 03:45:49'),
(64, 1, 21, 3, '2024-12-16 02:56:29', '2024-12-16 02:56:29'),
(65, 1, 69, 3, '2024-12-16 02:56:34', '2024-12-16 02:56:34'),
(66, 1, 96, 3, '2024-12-16 02:56:40', '2024-12-16 02:56:40'),
(67, 1, 125, 3, '2024-12-16 02:56:58', '2024-12-16 03:45:47'),
(68, 1, 119, 3, '2024-12-16 02:57:13', '2024-12-16 03:45:45'),
(69, 1, 93, 3, '2024-12-16 03:02:25', '2024-12-16 03:45:43'),
(70, 10, 34, 33, '2024-12-16 10:47:59', '2024-12-16 10:49:13'),
(71, 1, 38, 1, '2025-01-20 01:25:12', '2025-01-20 01:25:12'),
(72, 1, 39, 1, '2025-01-20 01:26:06', '2025-01-20 01:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên danh mục',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ảnh danh mục',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Mô tả danh mục',
  `fixed` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Phân loại danh mục',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động danh mục, mặc định là 1(đã kích hoạt)',
  `parent_category_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Xác định danh mục cha',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `fixed`, `is_active`, `parent_category_id`, `created_at`, `updated_at`) VALUES
(1, 'Áo thun', '674ddf948de9c.png', 'Áo thun nữ', 1, 1, 2, '2024-11-15 05:56:08', '2024-12-02 10:18:07'),
(2, 'Áo Nữ', 'NZwdCWXYAvVPCeDb6hoh42XewXx91QwPZJJvgWwT.jpg', 'Áo nữ', 1, 1, NULL, '2024-11-15 05:56:12', '2024-12-05 09:17:27'),
(3, 'Quần Jeans', '674ddf61d2879.png', 'quần jean nữ', 1, 1, 6, '2024-11-15 05:56:18', '2024-12-02 10:15:46'),
(5, 'Sản phẩm bán chạy', '1tiq0wyDp4L1BPDSqPT0szNMgFSNqBPqCxc7L0Sg.png', 'Spbc', 0, 1, NULL, '2024-11-15 07:02:49', '2024-12-04 12:24:06'),
(6, 'Quần Nữ', '4zW0rv6cTNKpuPxHyxCsCsvAhwAb3tdDp1P6Fy1t.jpg', 'Quần Nữ', 1, 1, NULL, '2024-12-02 09:17:05', '2024-12-05 09:14:27'),
(7, 'Quần dài', '674de26234bfa.png', 'quần dài nữ', 1, 1, 6, '2024-12-02 09:37:54', '2024-12-02 10:16:32'),
(11, 'Áo Nam', '0xJy7qU1CFZwFvUvZ8bzZSzGoeNJIeYtQh3n94RU.jpg', 'Áo nam', 1, 1, NULL, '2024-12-02 10:03:40', '2024-12-05 09:14:06'),
(12, 'Quần Nam', 'JAETKPJNZ7wxxf63k0irmvoU3DR6E6i9Y9oiFqnE.jpg', 'quần nam', 1, 1, NULL, '2024-12-02 10:04:32', '2024-12-05 09:13:49'),
(13, 'Quần Shorts', '674de94ddb806.png', 'Quần shorts nam', 1, 1, 12, '2024-12-02 10:07:25', '2024-12-02 10:07:25'),
(14, 'Quần dài', '674de992331ab.png', 'Quần dài nam', 1, 1, 12, '2024-12-02 10:08:34', '2024-12-02 10:08:34'),
(15, 'Quần Jeans', '674dea056d842.png', 'Quần jeans nam', 1, 1, 12, '2024-12-02 10:10:29', '2024-12-02 10:10:29'),
(16, 'Áo polo', '674dea5034ce1.png', 'Áo polo nam', 1, 1, 11, '2024-12-02 10:11:44', '2024-12-02 10:11:44'),
(17, 'Áo thun', '674dea7b081c3.png', 'áo thun nam', 1, 1, 11, '2024-12-02 10:12:27', '2024-12-02 10:12:27'),
(18, 'Áo thu đông', '674dec2f41e58.png', 'Áo thu đông nam', 1, 1, 11, '2024-12-02 10:19:43', '2024-12-02 10:19:43'),
(19, 'Áo sơ mi', '674dec5b4c6be.png', 'Áo sơ mi nam', 1, 1, 11, '2024-12-02 10:20:27', '2024-12-02 10:20:27'),
(20, 'Quần Shorts', '674dece092aac.png', 'quần shorts nữ', 1, 1, 6, '2024-12-02 10:22:40', '2024-12-02 10:22:40'),
(21, 'Áo thu đông', '674ded16904ab.png', 'Áo thu đông nữ', 1, 1, 2, '2024-12-02 10:23:34', '2024-12-02 10:23:34'),
(22, 'Áo sơ mi', '674ded348e4e4.png', 'áo sơ mi nữ', 1, 1, 2, '2024-12-02 10:24:04', '2024-12-02 10:24:04'),
(23, 'Áo polo', '674dedc174b91.png', 'áo polo nữ', 1, 1, 2, '2024-12-02 10:26:25', '2024-12-02 10:26:25'),
(29, 'Sản phẩm Trending', 'KoJXtB01nS69RcBF25ZnxwCWSgrid7WlspLRKIwE.png', 'Danh mục trending', 0, 1, NULL, '2024-12-04 08:53:42', '2024-12-04 08:53:42'),
(30, 'Giày', 'm2HqLE7sGQvCl3g5J6QRFxWlVlMfWohHpfwYxqpw.jpg', 'Giày', 1, 1, NULL, '2024-12-05 03:23:35', '2024-12-05 09:13:29'),
(31, 'Giày thể thao', '5BbdVJtSc4seIWEjgIktqZ9c69LQ6ZQfDfuNi7KL.png', 'giày thể thao', 1, 1, 30, '2024-12-05 03:23:57', '2024-12-05 03:24:22'),
(32, 'Giày thời trang', 'gHHCDGa7y77gOfP3TRpPh1Nw0VkqK0AOSXdYqnnV.png', 'giày thời trang', 1, 1, 30, '2024-12-05 03:25:12', '2024-12-05 03:25:12'),
(33, 'Phụ kiện', 'RLPPT7v2Io7nqbXigcozDZwAqJ1mtZJz33VdshXd.jpg', 'phụ kiện', 1, 1, NULL, '2024-12-05 09:13:02', '2024-12-05 09:13:02'),
(34, 'Trang sức', '4R5BzTnLRR53atJgIYWpTHBtj6gCbigwNDlnCZAv.jpg', 'Trang sức', 1, 1, NULL, '2024-12-05 09:16:36', '2024-12-05 09:16:36'),
(35, 'Dép', 'F3JoZTroSLwOUq0FsKhDuDoSbpovLLePXlTsSbhL.jpg', 'Dép', 1, 1, NULL, '2024-12-05 09:17:04', '2024-12-05 09:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Họ và tên',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email của người dùng',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số điện thoại',
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(2, 'Trương Đắc Sơn', 'dacson47@gmail.com', '0367750153', 'Xin chào', 'Tôi muốn hợp tác', '2024-12-13 07:51:33', '2024-12-13 07:51:33'),
(3, 'Hợp  Văn Tác', 'son273@gmail.com', '0367750343', 'Xin chào BeesFashion', 'Nay công ty chúng tôi chân trọng gửi đến quý công ty thư ngỏ này với mong muốn quý công ty có thêm sự lựa chọn và chúng tôi có thêm khách hàng thân thiết mới.', '2024-12-13 08:36:31', '2024-12-13 08:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

CREATE TABLE `favorite_products` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào yêu thích sản phẩm',
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định sản phẩm nào được người dùng yêu thích',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorite_products`
--

INSERT INTO `favorite_products` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2024-12-15 01:44:12', '2024-12-15 01:44:12'),
(2, 25, 3, '2024-12-15 08:37:35', '2024-12-15 08:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `import_histories`
--

CREATE TABLE `import_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL COMMENT 'Số lượng nhập vào',
  `import_price` bigint NOT NULL COMMENT 'Giá nhập thực tế của sản phẩm mà bạn đã mua từ nhà cung cấp. Đây là giá gốc của sản phẩm.',
  `product_variant_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định lịch sử nhập này thuộc biến thể nào',
  `user_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Người nhập hàng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `import_histories`
--

INSERT INTO `import_histories` (`id`, `quantity`, `import_price`, `product_variant_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 100, 80000, 1, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(2, 100, 80000, 2, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(3, 100, 80000, 3, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(4, 100, 80000, 4, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(5, 100, 80000, 5, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(6, 100, 80000, 6, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(7, 100, 80000, 7, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(8, 100, 80000, 8, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(9, 100, 80000, 9, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(10, 100, 80000, 10, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(11, 100, 80000, 11, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(12, 100, 80000, 12, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(13, 100, 80000, 13, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(14, 100, 80000, 14, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(15, 100, 80000, 15, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(16, 100, 80000, 16, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(17, 100, 400000, 17, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(18, 100, 400000, 18, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(19, 100, 400000, 19, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(20, 100, 400000, 20, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(21, 100, 400000, 21, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(22, 100, 400000, 22, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(23, 100, 400000, 23, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(24, 100, 400000, 24, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(25, 100, 400000, 25, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(26, 100, 400000, 26, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(27, 100, 400000, 27, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(28, 100, 400000, 28, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(29, 100, 400000, 29, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(30, 100, 400000, 30, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(31, 100, 400000, 31, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(32, 100, 400000, 32, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(33, 100, 170000, 33, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(34, 100, 170000, 34, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(35, 100, 170000, 35, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(36, 100, 170000, 36, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(37, 100, 170000, 37, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(38, 100, 170000, 38, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(39, 100, 170000, 39, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(40, 100, 170000, 40, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(41, 100, 300000, 41, 1, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(42, 100, 300000, 42, 1, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(43, 100, 300000, 43, 1, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(44, 100, 300000, 44, 1, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(45, 100, 150000, 45, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(46, 100, 150000, 46, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(47, 100, 150000, 47, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(48, 100, 150000, 48, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(49, 100, 150000, 49, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(50, 100, 150000, 50, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(51, 100, 150000, 51, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(52, 100, 150000, 52, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(53, 100, 150000, 53, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(54, 100, 250000, 54, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(55, 100, 250000, 55, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(56, 100, 250000, 56, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(57, 100, 250000, 57, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(58, 100, 250000, 58, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(59, 100, 250000, 59, 1, '2024-12-03 05:58:28', '2024-12-03 05:58:28'),
(60, 100, 250000, 60, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(61, 100, 250000, 61, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(62, 100, 250000, 62, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(63, 100, 250000, 63, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(64, 100, 250000, 64, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(65, 100, 250000, 65, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(66, 100, 250000, 66, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(67, 100, 250000, 67, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(68, 100, 250000, 68, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(69, 100, 250000, 69, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(70, 100, 250000, 70, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(71, 100, 250000, 71, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(72, 100, 250000, 72, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(73, 100, 250000, 73, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(74, 120, 200000, 74, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(75, 120, 200000, 75, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(76, 120, 200000, 76, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(77, 120, 200000, 77, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(78, 120, 200000, 78, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(79, 120, 200000, 79, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(80, 120, 200000, 80, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(81, 120, 200000, 81, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(82, 120, 200000, 82, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(83, 120, 200000, 83, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(84, 120, 200000, 84, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(85, 120, 200000, 85, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(86, 100, 1000000, 86, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(87, 100, 1000000, 87, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(88, 100, 1000000, 88, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(89, 100, 1000000, 89, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(90, 100, 1000000, 90, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(91, 100, 1000000, 91, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(92, 100, 100000, 92, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(93, 100, 100000, 93, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(94, 100, 100000, 94, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(95, 100, 100000, 95, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(96, 100, 100000, 96, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(97, 100, 100000, 97, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(98, 100, 100000, 98, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(99, 100, 100000, 99, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(100, 100, 80000, 100, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(101, 100, 80000, 101, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(102, 100, 80000, 102, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(103, 100, 80000, 103, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(104, 100, 80000, 104, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(105, 100, 80000, 105, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(106, 100, 80000, 106, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(107, 100, 80000, 107, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(108, 100, 80000, 108, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(109, 100, 80000, 109, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(110, 100, 80000, 110, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(111, 100, 80000, 111, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(112, 100, 80000, 112, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(113, 100, 80000, 113, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(114, 100, 80000, 114, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(115, 100, 80000, 115, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(116, 100, 80000, 116, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(117, 100, 80000, 117, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(118, 100, 300000, 118, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(119, 100, 300000, 119, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(120, 100, 300000, 120, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(121, 100, 300000, 121, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(122, 100, 300000, 122, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(123, 100, 300000, 123, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(124, 100, 100000, 124, 1, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(125, 100, 100000, 125, 1, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(126, 100, 350000, 126, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(127, 100, 350000, 127, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(128, 100, 350000, 128, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(129, 100, 350000, 129, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(130, 100, 350000, 130, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(131, 100, 350000, 131, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `manager_settings`
--

CREATE TABLE `manager_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `manager_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên chức năng quản lý',
  `parent_manager_setting_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Xác định chức năng quản trị cha',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manager_settings`
--

INSERT INTO `manager_settings` (`id`, `manager_name`, `parent_manager_setting_id`, `created_at`, `updated_at`) VALUES
(2, 'Quản lý danh mục', NULL, '2024-12-03 08:11:49', '2024-12-03 08:11:49'),
(3, 'Quản lý sản phẩm', NULL, '2024-12-03 08:12:00', '2024-12-03 08:12:00'),
(4, 'Quản lý thuộc tính', NULL, '2024-12-03 08:12:09', '2024-12-03 08:12:09'),
(5, 'Lịch sử nhập hàng', NULL, '2024-12-03 08:12:19', '2024-12-08 03:57:02'),
(6, 'Quản lý thương hiệu', NULL, '2024-12-03 08:12:29', '2024-12-03 08:12:29'),
(7, 'Quản lý khách hàng', NULL, '2024-12-03 08:12:50', '2024-12-03 08:12:50'),
(8, 'Quản lý vouchers', NULL, '2024-12-03 08:13:14', '2024-12-03 08:13:14'),
(9, 'Quản lý banner', NULL, '2024-12-03 08:13:30', '2024-12-08 03:53:00'),
(10, 'Quản lý đơn hàng', NULL, '2024-12-03 08:13:41', '2024-12-03 08:13:41'),
(11, 'Quản lý đánh giá', NULL, '2024-12-04 03:55:34', '2024-12-04 03:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_08_035420_create_brands_table', 1),
(6, '2024_10_09_133121_create_products_table', 1),
(7, '2024_10_09_133238_create_product_variants_table', 1),
(8, '2024_10_09_133343_create_attributes_table', 1),
(9, '2024_10_09_133359_create_attribute_values_table', 1),
(10, '2024_10_09_133360_create_product_variant_attribute_values_table', 1),
(11, '2024_10_09_133435_create_categories_table', 1),
(12, '2024_10_09_133437_create_product_categories_table', 1),
(13, '2024_10_09_133507_create_product_files_table', 1),
(14, '2024_10_09_133528_create_import_histories_table', 1),
(15, '2024_10_09_133540_create_product_likes_table', 1),
(16, '2024_10_09_133549_create_banners_table', 1),
(17, '2024_10_09_133558_create_banner_images_table', 1),
(18, '2024_10_09_133636_create_carts_table', 1),
(19, '2024_10_09_133729_create_user_shipping_addresses_table', 1),
(20, '2024_10_09_133737_create_vouchers_table', 1),
(21, '2024_10_09_133749_create_product_vouchers_table', 1),
(22, '2024_10_09_133758_create_orders_table', 1),
(23, '2024_10_09_133807_create_order_details_table', 1),
(24, '2024_10_09_133833_create_product_votes_table', 1),
(25, '2024_10_09_134120_create_favorite_products_table', 1),
(26, '2024_10_09_134139_create_product_view_histories_table', 1),
(27, '2024_10_09_134150_create_statuses_table', 1),
(28, '2024_10_09_134154_create_status_orders_table', 1),
(29, '2024_10_09_134250_create_manager_settings_table', 1),
(30, '2024_10_09_134252_create_user_manager_settings_table', 1),
(31, '2024_10_09_134306_create_product_vote_files_table', 1),
(32, '2024_10_10_075232_create_user_bans_table', 1),
(33, '2024_10_12_160823_create_attribute_types_table', 1),
(34, '2024_11_17_101127_create_user_vouchers_table', 1),
(35, '2024_11_26_063537_create_payments_table', 1),
(36, '2024_11_27_104450_add_payment_id_to_orders_table', 1),
(37, '2024_12_13_135600_create_contacts_table', 2),
(38, '2024_12_15_130326_add_google_fields_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `total_cost` int NOT NULL COMMENT 'Tổng số tiền khi chưa áp dụng mã giảm',
  `shipping_price` int NOT NULL COMMENT 'Số tiền vận chuyển',
  `shipping_voucher` int NOT NULL DEFAULT '0' COMMENT 'Số tiền vận chuyện được giảm',
  `voucher` int NOT NULL DEFAULT '0' COMMENT 'Số tiền được giảm từ voucher',
  `tax` double(8,2) NOT NULL COMMENT 'Thuế',
  `total_payment` int NOT NULL COMMENT 'Tổng tiền thanh toán cuối cùng',
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address',
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nếu người dùng chọn địa chỉ thanh toán mặc định ở bảng user thì không thể lấy thông tin địa chỉ giao hàng qua id của bảng user_shipping_address',
  `payment_method` enum('cod','vnpay','momo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod' COMMENT 'Thanh toán bằng hình thức nào',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào đã đặt hàng',
  `payment_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Xác định giao dịch thanh toán nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_cost`, `shipping_price`, `shipping_voucher`, `voucher`, `tax`, `total_payment`, `full_name`, `phone_number`, `address`, `payment_method`, `user_id`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 1837900, 30000, 30000, 50000, 9439.50, 1847340, 'Trương Đắc Sơn', '0367750153', 'Mỹ đình, NAm từ liêm, hà nội', 'cod', 3, NULL, '2024-12-03 09:26:09', '2024-12-03 09:26:09'),
(2, 3081600, 30000, 30000, 50000, 15658.00, 3097258, 'Khách hàng 2', '03677512345', 'Mỹ đình, Hà nội', 'vnpay', 5, NULL, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(3, 4834400, 30000, 30000, 200000, 25172.00, 4859572, 'Khách hàng 2', '03677512345', 'Mỹ đình, Hà nội', 'cod', 5, NULL, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(4, 688000, 30000, 30000, 50000, 3690.00, 691690, 'Khách hàng 2', '03677512345', 'Mỹ đình, Hà nội', 'cod', 5, NULL, '2024-12-05 18:21:05', '2024-12-05 18:21:05'),
(5, 2947000, 30000, 30000, 50000, 14985.00, 2961985, 'Trương Đắc Sơn', '01335465645', 'hih', 'cod', 3, NULL, '2024-12-10 08:30:19', '2024-12-10 08:30:19'),
(6, 7270000, 30000, 30000, 500000, 38850.00, 7308850, 'Khách Văn Hàng', '03677512345', 'Mỹ đình, Hà nội', 'cod', 5, NULL, '2024-12-10 09:03:14', '2024-12-10 09:03:14'),
(7, 569000, 30000, 30000, 0, 2845.00, 571845, 'Khách Văn Hàng', '03677512345', 'Mỹ đình, Hà nội', 'vnpay', 5, NULL, '2024-12-10 09:27:22', '2024-12-10 09:27:22'),
(8, 569000, 30000, 30000, 0, 2845.00, 571845, 'Khách Văn Hàng', '03677512345', 'Mỹ đình, Hà nội', 'vnpay', 5, NULL, '2024-12-10 09:27:54', '2024-12-10 09:27:54'),
(9, 1898000, 30000, 30000, 0, 9490.00, 1907490, 'Khách hàng 3', '0123456789', 'Đơn nguyên 5, Mỹ đình, Hà nội', 'cod', 11, NULL, '2024-12-11 10:02:02', '2024-12-11 10:02:02'),
(10, 2072000, 30000, 30000, 0, 10360.00, 2082360, 'Khách hàng 3', '0123456789', 'Đơn nguyên 5, Mỹ đình, Hà nội', 'cod', 11, NULL, '2024-12-12 10:53:12', '2024-12-12 10:53:12'),
(11, 1295000, 30000, 30000, 0, 6475.00, 1301475, 'Khách hàng 3', '0123456789', 'Đơn nguyên 5, Mỹ đình, Hà nội', 'cod', 11, NULL, '2024-12-12 11:00:59', '2024-12-12 11:00:59'),
(12, 2261000, 30000, 30000, 0, 11305.00, 2272305, 'Khách hàng test', '0367751234', 'Nam từ liêm, Hà Nội', 'cod', 19, NULL, '2024-12-13 07:57:47', '2024-12-13 07:57:47'),
(13, 2135600, 30000, 30000, 0, 10678.00, 2146278, 'Trương Đắc Sơn', '01335465645', 'hih', 'cod', 3, NULL, '2024-12-13 09:02:27', '2024-12-13 09:02:27'),
(14, 7854000, 30000, 30000, 50000, 39520.00, 7893520, 'Khách Hàng abcd', '0367750153', 'Hà Nội, Việt Nam', 'cod', 15, NULL, '2024-12-15 00:35:02', '2024-12-15 00:35:02'),
(15, 2029000, 30000, 30000, 50000, 10395.00, 2039395, 'Trương Đắc Sơn', '0367750546', NULL, 'vnpay', 25, NULL, '2024-12-15 08:38:34', '2024-12-15 08:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `value_variants` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Giá trị biến thể ví dụ (Xanh-XL)',
  `original_price` int NOT NULL COMMENT 'Giá gốc',
  `amount_reduced` int DEFAULT NULL COMMENT 'Giá đã được giảm',
  `quantity` int NOT NULL COMMENT 'Số lượng sản phẩm',
  `order_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định thuộc đơn hàng nào',
  `product_variant_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định biến thể nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `value_variants`, `original_price`, `amount_reduced`, `quantity`, `order_id`, `product_variant_id`, `created_at`, `updated_at`) VALUES
(1, 'Light Blue-M', 629300, 50000, 3, 1, 30, '2024-12-03 09:26:09', '2024-12-03 09:26:09'),
(2, 'Black-M', 269000, 12500, 2, 2, 38, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(3, 'Light Blue-L', 349300, 12500, 2, 2, 66, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(4, 'White-XL', 299000, 12500, 3, 2, 36, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(5, 'Dark Blue-29', 499000, 12500, 2, 2, 44, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(6, 'Beige-S', 629300, 50000, 2, 3, 21, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(7, 'Beige-L', 629300, 50000, 2, 3, 23, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(8, 'Light Blue-L', 629300, 50000, 2, 3, 31, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(9, 'Light Pink-M', 629300, 50000, 2, 3, 26, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(10, 'Beige-XL', 169000, 25000, 1, 4, 116, '2024-12-05 18:21:05', '2024-12-05 18:21:05'),
(11, 'Black-L', 569000, 25000, 1, 4, 122, '2024-12-05 18:21:05', '2024-12-05 18:21:05'),
(12, 'Black-XL', 269000, 16667, 3, 5, 40, '2024-12-10 08:30:19', '2024-12-10 08:30:19'),
(13, 'Black-XL', 169000, 16667, 5, 5, 113, '2024-12-10 08:30:19', '2024-12-10 08:30:19'),
(14, 'Black-M', 269000, 16667, 5, 5, 38, '2024-12-10 08:30:19', '2024-12-10 08:30:19'),
(15, '37', 2590000, 500000, 3, 6, 86, '2024-12-10 09:03:14', '2024-12-10 09:03:14'),
(16, 'Black-L', 569000, 0, 1, 7, 122, '2024-12-10 09:27:22', '2024-12-10 09:27:22'),
(17, 'Black-L', 569000, 0, 1, 8, 122, '2024-12-10 09:27:54', '2024-12-10 09:27:54'),
(18, 'Dark Beige-M', 245000, 0, 2, 9, 52, '2024-12-11 10:02:02', '2024-12-11 10:02:02'),
(19, 'Dark Beige-L', 245000, 0, 2, 9, 53, '2024-12-11 10:02:02', '2024-12-11 10:02:02'),
(20, 'Dark Blue-27', 459000, 0, 2, 9, 42, '2024-12-11 10:02:02', '2024-12-11 10:02:02'),
(21, 'Black-35', 259000, 0, 3, 10, 92, '2024-12-12 10:53:12', '2024-12-12 10:53:12'),
(22, 'Beige-35', 259000, 0, 5, 10, 96, '2024-12-12 10:53:12', '2024-12-12 10:53:12'),
(23, 'Beige-38', 259000, 0, 5, 11, 99, '2024-12-12 11:00:59', '2024-12-12 11:00:59'),
(24, 'Black-37', 259000, 0, 4, 12, 94, '2024-12-13 07:57:47', '2024-12-13 07:57:47'),
(25, 'Dark Blue-S', 245000, 0, 5, 12, 48, '2024-12-13 07:57:47', '2024-12-13 07:57:47'),
(26, 'White-M', 299000, 0, 1, 13, 34, '2024-12-13 09:02:27', '2024-12-13 09:02:27'),
(27, 'White-S', 349300, 0, 2, 13, 59, '2024-12-13 09:02:27', '2024-12-13 09:02:27'),
(28, 'Black-XL', 569000, 0, 2, 13, 123, '2024-12-13 09:02:27', '2024-12-13 09:02:27'),
(29, 'White-38', 449000, 16667, 3, 14, 77, '2024-12-15 00:35:02', '2024-12-15 00:35:02'),
(30, 'Black-L', 459000, 16667, 3, 14, 130, '2024-12-15 00:35:02', '2024-12-15 00:35:02'),
(31, '37', 2590000, 16667, 2, 14, 86, '2024-12-15 00:35:02', '2024-12-15 00:35:02'),
(32, 'Light Blue-M', 196000, 25000, 4, 15, 125, '2024-12-15 08:38:34', '2024-12-15 08:38:34'),
(33, 'Beige-36', 259000, 25000, 5, 15, 97, '2024-12-15 08:38:34', '2024-12-15 08:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định đơn hàng nào!',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào!',
  `amount` decimal(15,2) NOT NULL COMMENT 'Số tiền thanh toán (VND)',
  `payment_method` enum('vnpay','momo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Phương thức thanh toán',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nội dung thanh toán!',
  `response_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã phản hồi!',
  `bank_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã ngân hàng',
  `transaction_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã giao dịch',
  `pay_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Loại thanh toán (vd: qr_code, app)',
  `partner_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã đối tác của momo',
  `request_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Request ID của giao dịch từ MoMo',
  `pay_date` date NOT NULL COMMENT 'Thời gian thanh toán',
  `status` enum('pending','success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_method`, `note`, `response_code`, `bank_code`, `transaction_code`, `pay_type`, `partner_code`, `request_id`, `pay_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 5, '3097258.00', 'vnpay', 'Thanh toan GD:2', '00', 'NCB', '14722724', 'ATM', NULL, NULL, '2024-12-05', 'success', '2024-12-05 03:17:35', '2024-12-05 03:17:35'),
(2, 8, 5, '571845.00', 'vnpay', 'Thanh toan GD:8', '24', 'VNPAY', '0', 'QRCODE', NULL, NULL, '2024-12-10', 'failed', '2024-12-10 09:27:59', '2024-12-10 09:27:59'),
(3, 15, 25, '2039395.00', 'vnpay', 'Thanh toan GD:15', '00', 'NCB', '14746772', 'ATM', NULL, NULL, '2024-12-15', 'success', '2024-12-15 08:40:32', '2024-12-15 08:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `SKU` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mã sản phẩm',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên sản phẩm',
  `view` int NOT NULL DEFAULT '0' COMMENT 'Số lượt xem sản phẩm',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mô tả sản phẩm',
  `fake_sales` int DEFAULT NULL COMMENT 'Tạo đơn ảo cho sản phẩm)',
  `brand_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Sản phẩm này thuộc thương hiệu nào',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động, mặc định là 1(đã kích hoạt)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `SKU`, `name`, `view`, `description`, `fake_sales`, `brand_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AMNDGS', 'Áo thun Nữ tay dài dáng ôm cổ leo thời trang', 10, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 273, 5, 1, '2024-12-03 04:27:03', '2024-12-06 09:02:13'),
(2, 'AMNDGN', 'Áo khoác lông vũ siêu nhẹ giữ ấm, giữ nhiệt bảo vệ sức khỏe mùa lạnh', 107, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 34, 8, 1, '2024-12-03 04:43:01', '2024-12-09 11:40:33'),
(3, 'AHCSJD', 'Áo Polo nam dáng suông cố Đức họa tiết kẻ ngang trẻ trung', 54, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 63, 7, 1, '2024-12-03 05:00:16', '2025-01-20 01:25:54'),
(4, 'AGDBDF', 'Quần bò Nữ dáng rộng thời trang', 14, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 63, 6, 1, '2024-12-03 05:15:35', '2024-12-11 10:00:41'),
(5, 'AMNDGC', 'Quần shorts nữ dáng suông khóa sườn', 21, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 64, 8, 1, '2024-12-03 05:26:22', '2024-12-16 03:00:13'),
(6, 'AMKTDX', 'Quần dài dáng suông gấu quần chun có khóa điều chỉnh', 33, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 241, 8, 1, '2024-12-03 05:41:41', '2024-12-06 08:28:39'),
(7, 'RJDADA', 'Áo sơ mi BAMBOO chống nhăn ngắn tay', 26, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 47, 6, 1, '2024-12-03 05:58:28', '2024-12-12 10:51:41'),
(8, 'AMDCSA', 'Giày thể thao êm chân thoáng khí', 3, '<p>The GEL-ROCKET&trade; 11 style is a multi-purpose indoor court shoe that offers good stability and easy movement for a range of court athletes. ​</p>\r\n<p>This shoe is designed with a flexible upper construction that\'s breathable and more comfortable.​</p>\r\n<p>A TPU TRUSSTIC&trade; application in the midsole is designed to help resist over-twisting and improve stability during quick transitions. ​</p>\r\n<p>Its wrap-up outsole and outrigger are functional support components that are helpful during side-to-side movements. Meanwhile, the outsole\'s flexion grooves provide better flexibility to help you move more freely on the court.</p>', NULL, 7, 1, '2024-12-05 03:45:32', '2024-12-05 06:27:53'),
(9, 'AMGSVD', 'Giày Nike Air Force 1 Low Triple White', 5, '<p>Ra đời năm 1982, cho đến thời điểm hiện tại thiết kế Nike Air Force 1 l&agrave; một trong những form d&aacute;ng gi&agrave;y thể thao được giới trẻ quan t&acirc;m v&agrave; y&ecirc;u th&iacute;ch. D&ograve;ng Nike Air Force 1 được thiết kế bởi Bruce Kilgore, v&agrave; đặc biệt được lấy cảm hứng từ Air Force One &ndash; loại m&aacute;y bay chuy&ecirc;n dụng để chuy&ecirc;n trở tổng thống Mỹ.</p>\r\n<p>Kho&aacute;c l&ecirc;n m&igrave;nh chiếc &aacute;o da cao cấp, mềm mịn tone m&agrave;u trắng bao phủ to&agrave;n bộ đ&ocirc;i gi&agrave;y. Tuy sở hữu phối m&agrave;u đơn giản, nhưng ch&uacute;ng chắc chắn v&ocirc; c&ugrave;ng &ldquo;đa di năng&rdquo; c&oacute; thể gi&uacute;p chủ sở hữu mix c&ugrave;ng bất cứ set đồ n&agrave;o. Đặc biệt kh&ocirc;ng thể thiếu đi c&ocirc;ng nghệ Air ti&ecirc;n tiến c&oacute; cấu tr&uacute;c t&uacute;i kh&iacute; b&ecirc;n trong, nhằm giảm thiểu chấn thương trong qu&aacute; tr&igrave;nh hoạt động hay thể thao.</p>\r\n<p>Nếu c&ograve;n lo lắng về cảm gi&aacute;c m&agrave; Air Force One mang lại, th&igrave; h&atilde;y y&ecirc;n t&acirc;m nh&eacute;! Bởi phần đế đặc được chế t&aacute;c từ cao su chống trượt, tăng độ đ&agrave;n hồ v&agrave; đem lại cảm gi&aacute;c dễ chịu, &ecirc;m ch&acirc;n ngay cả khi đi bộ li&ecirc;n tục.</p>\r\n<p>Nếu bạn vẫn đang t&igrave;m kiếm một thứ g&igrave; đ&oacute; độc đ&aacute;o nhưng kh&ocirc;ng k&eacute;m phần nổi bật trong bất kỳ loại thời tiết n&agrave;o, th&igrave; kh&ocirc;ng đ&acirc;u kh&aacute;c ngo&agrave;i phi&ecirc;n bản m&agrave;u trắng tinh tế n&agrave;y của AF1! Cổ điển h&ograve;a lẫn hiện đại, Sneaker Daily khuy&ecirc;n bạn n&ecirc;n đi đ&uacute;ng k&iacute;ch thước (True Size) để c&oacute; sự vừa vặn ho&agrave;n hảo nhất!</p>\r\n<p>Một kiệt t&aacute;c theo phong c&aacute;ch tối thiểu, Nike Air Force 1 Trắng hiện đ&atilde; c&oacute; sẵn tr&ecirc;n trang sản phẩm gi&agrave;y online của Sneaker Daily, đừng bỏ lỡ cơ hội để sở hữu ngay cho m&igrave;nh một đ&ocirc;i nh&eacute;!</p>', NULL, 5, 1, '2024-12-05 04:21:14', '2024-12-10 09:02:34'),
(10, 'AGDBBD', 'Giày thể thao siêu nhẹ đế cao', 55, '<p>Ra đời năm 1982, cho đến thời điểm hiện tại thiết kế Nike Air Force 1 l&agrave; một trong những form d&aacute;ng gi&agrave;y thể thao được giới trẻ quan t&acirc;m v&agrave; y&ecirc;u th&iacute;ch. D&ograve;ng Nike Air Force 1 được thiết kế bởi Bruce Kilgore, v&agrave; đặc biệt được lấy cảm hứng từ Air Force One &ndash; loại m&aacute;y bay chuy&ecirc;n dụng để chuy&ecirc;n trở tổng thống Mỹ.</p>\r\n<p>Kho&aacute;c l&ecirc;n m&igrave;nh chiếc &aacute;o da cao cấp, mềm mịn tone m&agrave;u trắng bao phủ to&agrave;n bộ đ&ocirc;i gi&agrave;y. Tuy sở hữu phối m&agrave;u đơn giản, nhưng ch&uacute;ng chắc chắn v&ocirc; c&ugrave;ng &ldquo;đa di năng&rdquo; c&oacute; thể gi&uacute;p chủ sở hữu mix c&ugrave;ng bất cứ set đồ n&agrave;o. Đặc biệt kh&ocirc;ng thể thiếu đi c&ocirc;ng nghệ Air ti&ecirc;n tiến c&oacute; cấu tr&uacute;c t&uacute;i kh&iacute; b&ecirc;n trong, nhằm giảm thiểu chấn thương trong qu&aacute; tr&igrave;nh hoạt động hay thể thao.</p>\r\n<p>Nếu c&ograve;n lo lắng về cảm gi&aacute;c m&agrave; Air Force One mang lại, th&igrave; h&atilde;y y&ecirc;n t&acirc;m nh&eacute;! Bởi phần đế đặc được chế t&aacute;c từ cao su chống trượt, tăng độ đ&agrave;n hồ v&agrave; đem lại cảm gi&aacute;c dễ chịu, &ecirc;m ch&acirc;n ngay cả khi đi bộ li&ecirc;n tục.</p>\r\n<p>Nếu bạn vẫn đang t&igrave;m kiếm một thứ g&igrave; đ&oacute; độc đ&aacute;o nhưng kh&ocirc;ng k&eacute;m phần nổi bật trong bất kỳ loại thời tiết n&agrave;o, th&igrave; kh&ocirc;ng đ&acirc;u kh&aacute;c ngo&agrave;i phi&ecirc;n bản m&agrave;u trắng tinh tế n&agrave;y của AF1! Cổ điển h&ograve;a lẫn hiện đại, Sneaker Daily khuy&ecirc;n bạn n&ecirc;n đi đ&uacute;ng k&iacute;ch thước (True Size) để c&oacute; sự vừa vặn ho&agrave;n hảo nhất!</p>\r\n<p>Một kiệt t&aacute;c theo phong c&aacute;ch tối thiểu, Nike Air Force 1 Trắng hiện đ&atilde; c&oacute; sẵn tr&ecirc;n trang sản phẩm gi&agrave;y online của Sneaker Daily, đừng bỏ lỡ cơ hội để sở hữu ngay cho m&igrave;nh một đ&ocirc;i nh&eacute;!</p>', NULL, 8, 1, '2024-12-05 04:28:15', '2024-12-16 03:02:21'),
(11, 'JT0102', 'Áo giữ nhiệt nam vải UMI thu đông 2024 co giãn 4 chiều', 52, '<p class=\"QN2lPu\"><strong>BeesFashion ra mắt d&ograve;ng sản phẩm: &Aacute;o giữ nhiệt cao cấp cho m&ugrave;a đ&ocirc;ng 2024.</strong></p>\r\n<p class=\"QN2lPu\">Mặc nhiều lớp &aacute;o sẽ giữ ấm tốt cho anh em hơn trong m&ugrave;a đ&ocirc;ng, tuy vậy sẽ g&acirc;y cảm gi&aacute; b&iacute; b&aacute;ch kh&oacute; chịu. Chiếc &aacute;o giữ nhiệt mẫu mới nh&agrave; BeesFashion sẽ đảm bảo giữ ấm tối đa v&agrave; vẫn đem lại cảm gi&aacute;c thoải m&aacute;i khi mặc, c&ugrave;ng trải nghiệm ngay mẫu &aacute;o n&agrave;y cho m&ugrave;a thu đ&ocirc;ng bạn nh&eacute;.</p>\r\n<p class=\"QN2lPu\"><strong>Th&ocirc;ng tin sản phẩm:</strong></p>\r\n<p class=\"QN2lPu\">Form d&aacute;ng: Form d&aacute;ng regular , độ rộng vừa phải.</p>\r\n<p class=\"QN2lPu\">Vải: UMI H&agrave;n Quốc</p>\r\n<p class=\"QN2lPu\">Co gi&atilde;n 4 chiều /</p>\r\n<p class=\"QN2lPu\">Bề mặt ngo&agrave;i: Mềm mịn, chống b&aacute;m bụi kh&ocirc;ng cho cảm gi&aacute;c kh&ocirc; gi&aacute;p như những d&ograve;ng vải Polyester.</p>\r\n<p class=\"QN2lPu\">Độ d&agrave;y vừa phải, kh&ocirc;ng qu&aacute; mỏng như đa phần &aacute;o giữ nhiệt tr&ecirc;n thị trường, v&igrave; vậy cậu c&oacute; thể phối trơn với quần t&acirc;y hoặc jean đi chơi, đi l&agrave;m.</p>\r\n<p class=\"QN2lPu\">Thời tiết lạnh cậu c&oacute; thể phối th&ecirc;m 1 chiếc &aacute;o kho&aacute;c l&agrave; đảm bảo giữ ấm.</p>\r\n<p class=\"QN2lPu\">Mặt trong: B&ocirc;ng mịn th&acirc;n thiện, giữ ấm</p>\r\n<p class=\"QN2lPu\">-----------------------------</p>\r\n<p class=\"QN2lPu\">Mong muốn mang tới những sản phẩm tốt nhất trong tầm gi&aacute;, hy vọng đ&acirc;y sẽ l&agrave; 1 Items nữa l&agrave;m bạn h&agrave;i l&ograve;ng tại BeesFashion!</p>', NULL, 10, 1, '2024-12-05 07:00:47', '2024-12-12 11:35:21'),
(12, 'AMN153', 'Áo Sweater Richky Premium Nỉ Gucci Made In Italy Lông Cáo', 68, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, 7, 1, '2024-12-05 07:47:05', '2024-12-16 10:35:41'),
(13, 'LNE24126', 'Áo sơ nữ kiểu mi kẻ sọc cài cúc phía trước thường ngày cho nữ', 16, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, NULL, 1, '2024-12-05 08:00:35', '2024-12-15 08:43:35'),
(14, 'CROPEA', 'Áo Sweater Richky Premium Nỉ Versace Logo Cropped Lông Cáo', 9, '<div class=\"col-12\">\r\n<p class=\"paragraphs\">Experience the perfect blend of comfort and style with our Summer Breeze Cotton Dress. Crafted from 100% premium cotton, this dress offers a soft and breathable feel, making it ideal for warm weather. The lightweight fabric ensures you stay cool and comfortable throughout the day.</p>\r\n<p class=\"paragraphs\">Perfect for casual outings, beach trips, or summer parties. Pair it with sandals for a relaxed look or dress it up with heels and accessories for a more polished ensemble.</p>\r\n</div>\r\n<div class=\"col-12\">\r\n<div class=\"row gy-4\">\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Product Specifications</h5>\r\n<ul>\r\n<li>100% Premium Cotton</li>\r\n<li>A-line silhouette with a flattering fit</li>\r\n<li>Knee-length for versatile styling</li>\r\n<li>V-neck for a touch of elegance</li>\r\n<li>Short sleeves for a casual look</li>\r\n<li>Available in solid colors and floral prints</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Washing Instructions</h5>\r\n<ul>\r\n<li>Use cold water for washing</li>\r\n<li>Use a low heat setting for drying.</li>\r\n<li>Avoid using bleach on this fabric.</li>\r\n<li>Use a low heat setting when ironing.</li>\r\n<li>Do not take this item to a dry cleaner.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-xxl-3 col-lg-4 col-sm-6\">\r\n<div class=\"general-summery\">\r\n<h5>Size &amp; Fit</h5>\r\n<ul>\r\n<li>The model (height 5\'8) is wearing a size S</li>\r\n<li>Measurements taken from size Small</li>\r\n<li>Chest: 30\"</li>\r\n<li>Length: 20\"</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, 9, 1, '2024-12-05 08:04:52', '2024-12-15 00:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định có những sản phẩm nào thuộc danh mục này',
  `category_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định danh mục nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(2, 1, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(3, 2, 2, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(4, 2, 21, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(5, 3, 11, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(6, 3, 16, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(7, 4, 6, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(8, 4, 3, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(9, 5, 6, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(10, 5, 20, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(11, 6, 12, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(12, 6, 14, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(13, 7, 11, '2024-12-03 05:58:28', '2024-12-03 05:58:28'),
(14, 7, 19, '2024-12-03 05:58:28', '2024-12-03 05:58:28'),
(16, 2, 5, '2024-12-04 09:01:54', '2024-12-04 09:01:54'),
(17, 3, 5, '2024-12-04 09:01:54', '2024-12-04 09:01:54'),
(19, 5, 5, '2024-12-04 09:01:54', '2024-12-04 09:01:54'),
(21, 7, 5, '2024-12-04 09:01:54', '2024-12-04 09:01:54'),
(23, 2, 29, '2024-12-04 09:09:17', '2024-12-04 09:09:17'),
(24, 3, 29, '2024-12-04 09:09:17', '2024-12-04 09:09:17'),
(26, 5, 29, '2024-12-04 09:09:17', '2024-12-04 09:09:17'),
(28, 7, 29, '2024-12-04 09:09:17', '2024-12-04 09:09:17'),
(29, 8, 30, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(30, 8, 31, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(33, 10, 30, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(34, 10, 31, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(35, 11, 11, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(36, 11, 18, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(37, 9, 30, '2024-12-05 07:17:29', '2024-12-05 07:17:29'),
(38, 9, 31, '2024-12-05 07:17:29', '2024-12-05 07:17:29'),
(39, 12, 2, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(40, 12, 21, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(41, 12, 11, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(42, 12, 18, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(43, 13, 2, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(44, 13, 22, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(45, 14, 2, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(46, 14, 21, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(47, 14, 11, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(48, 14, 18, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(49, 11, 5, '2024-12-05 18:39:35', '2024-12-05 18:39:35'),
(50, 12, 5, '2024-12-05 18:39:35', '2024-12-05 18:39:35'),
(51, 13, 5, '2024-12-05 18:39:35', '2024-12-05 18:39:35'),
(52, 10, 5, '2024-12-05 18:39:41', '2024-12-05 18:39:41'),
(53, 12, 29, '2024-12-05 18:44:06', '2024-12-05 18:44:06'),
(54, 13, 29, '2024-12-05 18:44:06', '2024-12-05 18:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_files`
--

CREATE TABLE `product_files` (
  `id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên file',
  `file_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại tệp là gì(image/video)',
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định file này thuộc về sản phẩm nào',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Tệp mặc định để đại diện sản phẩm',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_files`
--

INSERT INTO `product_files` (`id`, `file_name`, `file_type`, `product_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'DkKk2hsMjQya7qXuCFUZutBTowdH0ADM9uZUJzCE.webp', 'image', 1, 1, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(2, 'qU0bYZH3UoZLGZ7PyirYidh9PGLN0S9V0ZNOOQxJ.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(3, 'sfJzVEsZG4p1tQyWv8tM0TCPf33EyP7BbWstO4XK.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(4, 'CyyOS9MjCDuAA7kBks09qFBIC3m8ZwEcqydM4umG.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(5, 'SnfLOnrjgYxyLcw78HDxKOViMsnSPJd2FTuJxttv.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(6, 'TT5KJcHhcaYrMKLkzGAXLwrlFGnTOyfngdczJS9E.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(7, 'EcBUZEA7SMVBmFW94QZnHWuF5cdSRcFVdlord8ak.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(8, 'Ve2YFmz7qjog8HGCI01RK590J3ULrcgdKmdcW6Lu.webp', 'image', 1, 0, '2024-12-03 04:27:38', '2024-12-03 04:27:38'),
(9, 'e1evvkRvuFaowYtPahIM7Y7mhdZR7m4cstkGhhoA.webp', 'image', 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(10, 'NpgtzSQzL6hPrY3jZe1KCVF3thTxH4IrhxWw0fqj.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(11, 'zATyEhbveqXqwmvGdlYrCMtbScCIv4K03RXXZDQk.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(12, 'b02jdEqPulWcbTtIxMlXk0H8Xq1SXyIh5zB2p5YM.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(13, 'Udle49w3nSqZjeQ7wYtaLdHQtTnju3v94D5WFfEM.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(14, '9Eyhdz9WEYsyytm7cIwL6dxZkAxlS2truYrOZI08.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(15, 'MxWjmVrd6ogJtItyGCSosfuPMEo4b6uuww6tCZZc.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(16, 'sWOekAj62OeppHgtvXIvVGfVcVdagRv3icj3WfZJ.webp', 'image', 2, 0, '2024-12-03 04:46:37', '2024-12-03 04:46:37'),
(17, 'Lyw8OyzNntLnWKjQusI23TgJIJtvjVlt9Pe7znUb.webp', 'image', 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(18, 'tb0L0Ba3GFYCyZgevcY6QM6T2DKTlAFSpuNlda8w.webp', 'image', 3, 0, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(19, 'xVTYOuKwARq6HAxcm7u0CyUVx4BnAFw0058OwlFw.webp', 'image', 3, 0, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(20, '6bQ1sRMsFYCTA2wK80xx5rYquHZGMelivzxHIk6g.webp', 'image', 3, 0, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(21, 'SWXmjvZ2oepNqenDygs89eumgVM2fdscJ7Q8aoHE.webp', 'image', 3, 0, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(22, 'GDOWyxUuVtJ68YbILXEL0GvLI27wFDlGhwUg77h1.webp', 'image', 3, 0, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(23, 'hUGzoEmmyHCsMGIk355XWz7MVTiZqB0z2rFkiEWV.webp', 'image', 4, 1, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(24, 'FkF9EE4dFxHLwqtno7xisvAY5jbalkX20Ql5rQ8l.webp', 'image', 4, 0, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(25, 'qQo5KuIrLZJMgM0jpPedxs2WsIg7C0L09WH93qPS.webp', 'image', 4, 0, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(26, 'oGuAA3tMpbrz9fPY5FcpGTDER8rDXtMlqFx4hUya.webp', 'image', 4, 0, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(27, '2CnRdm67mN7g6rIcb6bcRH2wbsrW75xwFDvSXVlc.webp', 'image', 4, 0, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(28, 'jakVD0lcbPTV2k4ympoVAvYMGCoiWoO7btsIxiC4.webp', 'image', 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(29, '2sdz2FL52XUOxBlvmyLaylggFfus2hVxTgApjVgh.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(30, 'G9G7ls6dPa3pizHoOyy3ti9LXISGMCf7vksOPgR4.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(31, 'jMr6EWdz68jbhMpraXs0CobGNR9frLwBGPX3zaRy.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(32, '2lmiFCBDND9B2Gkp6OekNoytyLUzmzpga4m33J93.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(33, 'kn0asC3Lp2SZd8QcrDqyk4e1OLXocO5jaPoBqMfl.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(34, 'MuatqFpfBI9ugaGIOO92UXiADRLb8t6VVatuLa8b.webp', 'image', 5, 0, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(35, 'j111s2QgE9lj72EpWp8aElhwRP9awIOMx4rEEydl.webp', 'image', 6, 1, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(36, 'M1LAmQ9JcOc9DFuceDW15o2XJlP8z16iw7lppdg3.webp', 'image', 6, 0, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(37, 'PzCZ1DpJR8IvVZuWg6V9nQobTsUQ7AXGD93v9hez.webp', 'image', 6, 0, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(38, 'ZkJPZBHELggANN828th3dHWkGYKckxN3mNI0MZBG.webp', 'image', 6, 0, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(39, 'gjHGjd5UqLP4CFu8veB3MuR4yDvajc4994c9vzAW.webp', 'image', 6, 0, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(40, 'jHZD9J1ewALZEogL2BvJjr0CfiLXzjsOwDMXUpii.webp', 'image', 6, 0, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(41, '2qB9Sq3XNaKqD62V8VKW8WRPRzFBZhLdTGozgRbM.webp', 'image', 7, 1, '2024-12-03 05:58:28', '2024-12-03 05:58:28'),
(42, 'r7UEy2452zD4kUo11KaYUZH470E0ibqJ3CV51Z22.webp', 'image', 7, 0, '2024-12-03 05:58:46', '2024-12-03 05:58:46'),
(43, 'R8yZRtbZj4umHIyPrvpMaoHf4gg9CE8rA15sWrln.webp', 'image', 7, 0, '2024-12-03 05:58:46', '2024-12-03 05:58:46'),
(44, 'AVvSPZHjfprgtYgDD90Rix5K3FkMwVBExLPyKMtb.webp', 'image', 7, 0, '2024-12-03 05:58:46', '2024-12-03 05:58:46'),
(45, 'IrJaRVztD2icRLTNlieU16bWVgW0FjBFyuC7lJib.webp', 'image', 7, 0, '2024-12-03 05:58:46', '2024-12-03 05:58:46'),
(46, 'gJUhEot3xdlj9rVum109rUa4mQzL7W7T8JXO1xZ1.webp', 'image', 7, 0, '2024-12-03 05:58:46', '2024-12-03 05:58:46'),
(47, 'GwqHDPyVCFk1PKQTat3jJjkIfQiyLr6mruPTvZFJ.webp', 'image', 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(48, '6S3QiwBaXoQIGIGsIUf5uM9A4IDJTPYtzCA8oUrl.webp', 'image', 8, 0, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(49, '2OMgXX3IBFtV9LNfiT5ORtDjNBBPxyT2EP9YSvz0.webp', 'image', 8, 0, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(50, 'CSRouFmvYjcE4YJVZfT9pV47v5H86OtGz8Y35n3G.webp', 'image', 8, 0, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(51, 'sK3UEuMU7T7whEgAQJdyzR9IyQKzmS23UvhcwhKp.webp', 'image', 8, 0, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(52, 'GfWWptEVWIlIOISdGwjlxUdWIm2pVqBUYFZQnDhO.webp', 'image', 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(53, 'hZztXpacYi74oXVYYKHyGMX1ZDDGmnOLjPZ86Xii.webp', 'image', 9, 0, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(54, 'utg2u57vfSycSJxkXkwxL3NfQDmYXg9M4T5aupJa.webp', 'image', 9, 0, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(55, 'Y0xnmN8ICLIS6jnAcA8tacbt3DiA363V11frjlcX.webp', 'image', 9, 0, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(56, 'h5w9Y8jyvFsE6rous33wsKLr1QtvdQL5SXwyhAGY.webp', 'image', 9, 0, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(57, 'pKIw0ZJwBl6C5pTbCocgwaC0ySF36ahcMm3peFoB.webp', 'image', 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(58, 's2FkuQI3tRHg1EaqXkJzJQBCeL4kTsa2z6X5vv9H.webp', 'image', 10, 0, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(59, '6j7lmHQ4z0ntAoC3d0yne214yCiNMI9U4gfBwxcd.webp', 'image', 10, 0, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(60, '1gRMpXBItCS8uas9L94TzKTCRQrEdFiyFMUrTyya.webp', 'image', 10, 0, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(62, 'rYHPfhbt827K0Qkvk8qoOKfdLD3s8qkWftyagW1f.webp', 'image', 11, 0, '2024-12-05 07:08:49', '2024-12-05 07:08:49'),
(63, '3RVS4Neccz554VPV4SIcSVrmTEsBrmm8OAW5lfHo.webp', 'image', 11, 0, '2024-12-05 07:08:49', '2024-12-05 07:08:49'),
(64, 'qQk3wexQASHUgT8BWeGmlkQUh6u1Sc77HCVNv7bl.webp', 'image', 11, 0, '2024-12-05 07:08:49', '2024-12-05 07:08:49'),
(65, 'X9DlNTeVekSFdGGlkH2k78L8oPqNEoBsoFaLhAm4.webp', 'image', 11, 0, '2024-12-05 07:08:49', '2024-12-05 07:08:49'),
(66, 'H8b9hTcXh9tSPFuW8Re9FfcABGmfZO8hD6jALhVY.webp', 'image', 11, 0, '2024-12-05 07:08:49', '2024-12-05 07:08:49'),
(67, 'qF5nfn2cKeJZkANcq38GmcXLXL6406xSEACr02wj.png', 'image', 11, 1, '2024-12-05 07:22:23', '2024-12-05 07:22:23'),
(68, '7kADMseDCKsMGaz9eVksiMKGuHLSxQAhdjIUMbAK.webp', 'image', 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(69, 'GZNTcyKIEbLE5y3MxnVam7zOdfHVQRGKxceRqB12.webp', 'image', 12, 0, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(70, 'gkV1htD6U0Xd5pxHmKv43Uc5p3lAKMc6kOGKt0If.webp', 'image', 12, 0, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(71, 'OBq0b1vGzOxrI68uTZbUNcgMbEqbyCOlQaXr3p4f.webp', 'image', 12, 0, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(72, '71fhPSHnZMqF0LE1FNU1g4vUo3gxg6pBJFysmQcj.webp', 'image', 12, 0, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(73, '546Ikj180AqyrFQr0xuYCiVGkc7yygbhUcvO8NGi.webp', 'image', 12, 0, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(74, 'WYnTrqtipl8evn5abCS9v4dLdwvOvuNgMewjfACP.webp', 'image', 13, 1, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(75, 'j6SKsg8PBz3wcSP4OLW6QDmXJ9fYCCzjd1uZa7aJ.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(76, 'F6Ytb7e41OmOceJ3fSTtyGZgQNnVt5gjdlv6hEbL.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(77, 'HupyCWT4CxwBwXDx9qg1sqnJ17anS3P5aPqwJtKF.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(78, 'QrSw4BoYEwecFS6g124ZS946Xw2DQSlnDhMyVvx0.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(79, 'W2MGCN8xp71R1VAeAWQeR2MeGmNltuXfRy3Zl0Xl.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(80, 'NzRrMf8U1llnGjbfx9bwXeSj4f9WHabmbaVJmCcv.webp', 'image', 13, 0, '2024-12-05 08:00:35', '2024-12-05 08:00:35'),
(81, 'JQ1CVhb23ZKysg3IQZSJBojfLpqpY83dLC3j8Any.webp', 'image', 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(82, 'Xa2PWBOMD6NrExhMkWhldmOm72xHbEduV1tV2Xnz.webp', 'image', 14, 0, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(83, '4174eUeTe55BemfSditdTp7jUpTqJQzdCv4acywM.webp', 'image', 14, 0, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(84, 'wep3Bo4EzGvQ5vIZKuBAt7MgD0n1zZB1OAl5my2F.webp', 'image', 14, 0, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(85, 'dBFxqmWFVdUb24jcyA81ompVJ6FVrjAQX04Sze9c.webp', 'image', 14, 0, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(86, 'vCk9SC90jnZb2ZKlygXMYSihyUYoYvkItyvXDs64.webp', 'image', 14, 0, '2024-12-05 08:04:52', '2024-12-05 08:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_likes`
--

CREATE TABLE `product_likes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Thuộc người dùng nào (người dùng nào like)',
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định sản phẩm được like',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `SKU` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mã sản phẩm biến thể',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên sản phẩm biến thể',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ảnh sản phẩm biến thể',
  `regular_price` bigint NOT NULL COMMENT 'Đây là giá thông thường của sp',
  `sale_price` bigint DEFAULT NULL COMMENT 'Giá bán đã được giảm của sản phẩm',
  `stock` int NOT NULL COMMENT 'Tồn kho',
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định biến thể thuộc sản phẩm nào',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động, mặc định là 1(đã kích hoạt)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `SKU`, `name`, `image`, `regular_price`, `sale_price`, `stock`, `product_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AMNDGS-Brown-S', 'Brown-S', 'P68zXMFN0uvBGmKg64OzPYgELunqtWnv3P9uhU1n.webp', 149000, 129000, 1, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(2, 'AMNDGS-Brown-M', 'Brown-M', 'GCRXm7rF8Cf1gOUSDsy186XvNQXhjJm8Cd8Mw52b.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(3, 'AMNDGS-Brown-L', 'Brown-L', 'exUfbJvXoqMP293OtNpymkOWpMl1wuu7W9noMs92.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(4, 'AMNDGS-Brown-XL', 'Brown-XL', '8GlvF0vkjMwI0bYbZt5eY8Ep7ZbFC8zaHybUgsB8.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(5, 'AMNDGS-Black-S', 'Black-S', 'RJQ88K9BpXmeLy4o6R4FsPv4KAApEkos2ImjN9o8.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(6, 'AMNDGS-Black-M', 'Black-M', 'j7pUy4K4773IbtgCUrapG2dIYCqo1bgTs3LTQY3w.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(7, 'AMNDGS-Black-L', 'Black-L', 'j9UiMG6b8bjJWp0WioFt8c1X54daBBvjkzCZYJcw.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(8, 'AMNDGS-Black-XL', 'Black-XL', 'XJFSulK8mERwv5q8GJQErxgEAKZ7m2yqWTa5phCt.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(9, 'AMNDGS-Olive Green-S', 'Olive Green-S', 'UWTXZMxE0sINO4Af1E8qdLHU1UWe2UzCkNgFK0tK.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(10, 'AMNDGS-Olive Green-M', 'Olive Green-M', 'GukMSrUHPyYtxByMGZKQnSFehfJnSH4gSeBnt6QT.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(11, 'AMNDGS-Olive Green-L', 'Olive Green-L', 'PAWznpaoGDACPe6f5ipSdnPnPpfHhYiHOQBYoRoe.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(12, 'AMNDGS-Olive Green-XL', 'Olive Green-XL', '9ah9C8OTnPBlykhzypgReByl0hxGSeNFHZNtkxwU.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(13, 'AMNDGS-Light Pink-S', 'Light Pink-S', 'iHhBnoCa5E2Lz238mNwRpcP1ZRdIGMi9XPIOE8cV.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(14, 'AMNDGS-Light Pink-M', 'Light Pink-M', 'Dj5VTJqGLwVTAHD12Zj2ZOik0uakwMR4FxoK2xG2.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(15, 'AMNDGS-Light Pink-L', 'Light Pink-L', 'kHSobEcbEweW2hbqC3GcMbZn8n1lUBMPs66HxegF.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(16, 'AMNDGS-Light Pink-XL', 'Light Pink-XL', 'bjYkZNg1Uab1PkblQoJCyzQL2DFE1mWhgRt1VZlX.webp', 149000, 129000, 100, 1, 1, '2024-12-03 04:27:04', '2024-12-05 18:29:21'),
(17, 'AMNDGN-Black-S', 'Black-S', 'tDgc8it4VRS4AKHn8sZGWjow28qR6zzjsUp24RQT.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(18, 'AMNDGN-Black-M', 'Black-M', 'onysBFyxisbhGh3UzYd1PtJ2WCYqMGjHysFflRiY.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(19, 'AMNDGN-Black-L', 'Black-L', 'GZ2YHsIbPGwBwN2VetK4uyvNZbvYIcN0i6KLGYFd.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(20, 'AMNDGN-Black-XL', 'Black-XL', 'NGsw5Mh01r7wpjlzqWfUT98IJXFvvlS1JzU2R030.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(21, 'AMNDGN-Beige-S', 'Beige-S', 'wOZYlSZvJP49tAALqisfQqiDZzXF2wIKDtHvbFTA.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(22, 'AMNDGN-Beige-M', 'Beige-M', 'FHywZYdoEZ0IALC0PBVPSMt1ylWPivP3BPAx87EK.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(23, 'AMNDGN-Beige-L', 'Beige-L', 'BhdxThRlfKw4A3tbLua9npPvRWhigWFW1UwwYVbb.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(24, 'AMNDGN-Beige-XL', 'Beige-XL', 'qJFICrBmpqdiHxo2eKEN8dXUbXUJbTkBCRsNun2L.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(25, 'AMNDGN-Light Pink-S', 'Light Pink-S', 'QnIOro14NvHyganJ6Rh5AvXc1uHnegnfONjP1dnh.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(26, 'AMNDGN-Light Pink-M', 'Light Pink-M', 'Sw9wh411guKniuv5gGRTA6Nk075mnKISDyV2ik8P.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(27, 'AMNDGN-Light Pink-L', 'Light Pink-L', '3hTZqcK00xIWkfBciuhlyz3nKVIIO5U54FENi45q.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(28, 'AMNDGN-Light Pink-XL', 'Light Pink-XL', 'rKkxz076LSupZ8ItSbhkTJVuGzjA9ndOnl1UxD72.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(29, 'AMNDGN-Light Blue-S', 'Light Blue-S', 'sfoKJVSji4TsimozoZAJ6yx5PUzdZndqUdaQeVJs.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(30, 'AMNDGN-Light Blue-M', 'Light Blue-M', 'hACmvLldVGu483QqGv1Nowy5AAIWKxPYRN8axgUz.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(31, 'AMNDGN-Light Blue-L', 'Light Blue-L', 'XhBapCJyW2R07EbK1vobMBGw5LwiSssR3w79waQW.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(32, 'AMNDGN-Light Blue-XL', 'Light Blue-XL', 'm7NTxkyJkkKfUMZ3FeJydWsxBgFOZ66eSOxvoYGy.webp', 800000, 629300, 100, 2, 1, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(33, 'AHCSJD-White-S', 'White-S', '83KdWui1GcyCCabtW2rEUzfBViRroEW2XfoHAEnT.webp', 340000, 299000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(34, 'AHCSJD-White-M', 'White-M', '2GkSReCbGd8d8iK9FwfF3X5kHFb5NYrq8TaK0yrv.webp', 340000, 299000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(35, 'AHCSJD-White-L', 'White-L', 'ZY86cw86w9Wt9RaPnfDzLci5dPhl810mmsTWMnwb.webp', 340000, 299000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(36, 'AHCSJD-White-XL', 'White-XL', 'yD6DcKJqpNbgCk2wApmMPAdipSQyyUC5rQESQTDm.webp', 340000, 299000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(37, 'AHCSJD-Black-S', 'Black-S', 'nvYq7vyhEUVBMCaAgIiM8uMH0YWNMQUvVlwvtrGX.webp', 340000, 269000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(38, 'AHCSJD-Black-M', 'Black-M', '4VfqaaOQtIqMzZwK1GSxIvrCJruJLyuq9JZCnziy.webp', 340000, 269000, 95, 3, 1, '2024-12-03 05:00:16', '2024-12-10 08:32:40'),
(39, 'AHCSJD-Black-L', 'Black-L', 'mB91lSGO1uPTlgKmat3w3NbYR37yFcY4ZqhdLyI9.webp', 340000, 269000, 100, 3, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(40, 'AHCSJD-Black-XL', 'Black-XL', 'JnxOV7K875TdJQeFiK4Kx76XGGueZVGBuc9rxhZf.webp', 340000, 269000, 97, 3, 1, '2024-12-03 05:00:16', '2024-12-10 08:32:40'),
(41, 'AGDBDF-Dark Blue-26', 'Dark Blue-26', 'oGcxmxrrMQ1wSsg4a3pIuoQrTsorRQXptKq6p8dG.webp', 499000, 459000, 100, 4, 1, '2024-12-03 05:15:35', '2024-12-05 18:30:53'),
(42, 'AGDBDF-Dark Blue-27', 'Dark Blue-27', 'Ne8OdB4VQe6Yrgy5z7bUNcof9Ynx5MQ1zib15AdU.webp', 499000, 459000, 98, 4, 1, '2024-12-03 05:15:35', '2024-12-11 10:02:57'),
(43, 'AGDBDF-Dark Blue-28', 'Dark Blue-28', 'JIwufe8Xe6BXgsql9LwUD56B7msb1hChqqACOMFF.webp', 499000, 399000, 100, 4, 1, '2024-12-03 05:15:35', '2024-12-05 18:30:53'),
(44, 'AGDBDF-Dark Blue-29', 'Dark Blue-29', 'T6URcJquIBW5csXgrkNvTKR3cMTXxz9hweAtpVm0.webp', 499000, 399000, 100, 4, 1, '2024-12-03 05:15:35', '2024-12-05 18:30:53'),
(45, 'AMNDGC-Light Gray-S', 'Light Gray-S', 'wSTS8ZtpvK3DfTReAXwhgdaZ3BZ9j5AEbLOHJfF4.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(46, 'AMNDGC-Light Gray-M', 'Light Gray-M', 'wWSXRKEMhFEOrkg0ewNpLANiplAr2R8zegtvX6Qm.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(47, 'AMNDGC-Light Gray-L', 'Light Gray-L', 'dRlfHjBEFm99cemy8XqCFHtZ4FRg7e9I4wsGueTU.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(48, 'AMNDGC-Dark Blue-S', 'Dark Blue-S', '5s9MpOXZjcNjHckzwfhTw6J2DaTHW6A2EnhdV77J.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(49, 'AMNDGC-Dark Blue-M', 'Dark Blue-M', 'pP6AKgTUd7oJGUhioOb1FvkLFy5KH3AD2VtlZNWi.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(50, 'AMNDGC-Dark Blue-L', 'Dark Blue-L', 'CnyEdJa78HzjfgUlwRe4NhJs6opuam1bibNwbH9c.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(51, 'AMNDGC-Dark Beige-S', 'Dark Beige-S', 'u8Y9SIhNYGlmDd7FwyrYBUjOfofsEW6wYzMs6uqr.webp', 350000, 245000, 100, 5, 1, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(52, 'AMNDGC-Dark Beige-M', 'Dark Beige-M', 'VMDldM0PLXTkiINUmPSpskEO7QfwMJiQn634chLZ.webp', 350000, 245000, 98, 5, 1, '2024-12-03 05:26:22', '2024-12-11 10:02:57'),
(53, 'AMNDGC-Dark Beige-L', 'Dark Beige-L', '5kxJQfXETIFfNCcMz3LPK3EMK2wHCEFhwdEsy9bn.webp', 350000, 245000, 98, 5, 1, '2024-12-03 05:26:22', '2024-12-11 10:02:57'),
(54, 'AMKTDX-Black-S', 'Black-S', 'ZtrMJxz8E0XxqrmbV80HoFKjsvvtcszoY72gZ9d2.webp', 399000, 359000, 100, 6, 1, '2024-12-03 05:41:41', '2024-12-05 18:32:55'),
(55, 'AMKTDX-Black-M', 'Black-M', 'fTdkzn9NkkisUHEvuyC0Y5Bd96xATNyz0pkQ08mA.webp', 399000, 359000, 100, 6, 1, '2024-12-03 05:41:41', '2024-12-05 18:32:55'),
(56, 'AMKTDX-Black-L', 'Black-L', 'G4SZWOWLk9dWbNeqK2VSFRNeoKtcxvEZmqszakyu.webp', 399000, 359000, 100, 6, 1, '2024-12-03 05:41:41', '2024-12-05 18:32:55'),
(57, 'AMKTDX-Black-XL', 'Black-XL', 'cnA8j5T0ir9c2SzzaEOxZ23joAf14mR1RUTi9BDR.webp', 399000, 369000, 100, 6, 1, '2024-12-03 05:41:41', '2024-12-05 18:32:55'),
(58, 'AMKTDX-Black-2XL', 'Black-2XL', 'CuzEihZ7lJrLkL1tKnAPhw5cGhcZ0B76T9i2DurH.webp', 399000, 369000, 100, 6, 1, '2024-12-03 05:41:41', '2024-12-05 18:32:55'),
(59, 'RJDADA-White-S', 'White-S', '63P3ee3f0psumb0VjoTxfQjeLa4vya8H2LCG6MhH.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:28', '2024-12-03 05:58:28'),
(60, 'RJDADA-White-M', 'White-M', '9VNr5iWqbmRTtqbZyWEXmCzzE4Mp7s8nmUn5bTPS.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(61, 'RJDADA-White-L', 'White-L', 'I8I1HSot4in4GY44z9bBmBGgUJOKgSzBfkh75QaR.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(62, 'RJDADA-White-XL', 'White-XL', 'MsCsjnDcgdVwnkjEruU0eOH6Rff56gcU4uhCqTJ6.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(63, 'RJDADA-White-2XL', 'White-2XL', 'idKoxEqnUczxKnnI3PhItmoooGLQFXv7co9EbHUO.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(64, 'RJDADA-Light Blue-S', 'Light Blue-S', 'ykJRQvpJILEGfplo6ZKz4zhlr2DqB7teYdcn3s7N.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(65, 'RJDADA-Light Blue-M', 'Light Blue-M', 'yh58dTsmU096b0EANwZkQtWzT8fPod1uvr4lh5bK.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(66, 'RJDADA-Light Blue-L', 'Light Blue-L', 'dAtOgvvUzmDrktIqOGYCWtoWAwGSqcmrYi8DweHF.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(67, 'RJDADA-Light Blue-XL', 'Light Blue-XL', 'eixsALr0z5nO3jRsBXaZoOzWiwgzOhmP7cGf7rnh.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(68, 'RJDADA-Light Blue-2XL', 'Light Blue-2XL', '1i7v8i8JUxetATbXH8FDbgqalDLHk7NwkHja8HmU.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(69, 'RJDADA-Dark Blue-S', 'Dark Blue-S', 'MIi794QKvOg91nY3pxZbOaPU9TQh1YnPN63qzEpP.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(70, 'RJDADA-Dark Blue-M', 'Dark Blue-M', '0YTfTL8OFvyDdvWRVJQ6415lfBPVfliJD6NVzWbG.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(71, 'RJDADA-Dark Blue-L', 'Dark Blue-L', 't0OjKPb9LvxVmb4UmN0MlwfNYoe3Qa5r4dLVHgqr.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(72, 'RJDADA-Dark Blue-XL', 'Dark Blue-XL', 'EFQUz5QhxZmd7GIARcOgBkTHuRQ7YzPfm85Gxs9D.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(73, 'RJDADA-Dark Blue-2XL', 'Dark Blue-2XL', '5koqYMNg4qg5MSZ4wSUni4mhhaAKeRGeFKY9ocMT.webp', 499000, 349300, 100, 7, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(74, 'AMDCSA-White-35', 'White-35', 'qepo0DPfMmfbsz2YkM0OXZfbpwrtDAY66nIq3kac.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(75, 'AMDCSA-White-36', 'White-36', 'qOiUNY0pynEsWLvaSumHKIGp0t8lvKSXo9rOXs7E.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(76, 'AMDCSA-White-37', 'White-37', 'VanxLTwKwonjke3CsksW2xik5Cfk6UXnKRFNOLeU.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(77, 'AMDCSA-White-38', 'White-38', '7jPmJIlJN2qFjoq40Dx4znMWpj3M0pxtVHdi0dRB.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(78, 'AMDCSA-White-39', 'White-39', 'nIRjDGo0OVWMJ4ZwHEoS7JU424r9grnbCUQf4c5W.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(79, 'AMDCSA-White-40', 'White-40', 'p0UJNUkg7Of9M1C9t8x7CWMLGb0MWJtKEHUjdQQa.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(80, 'AMDCSA-Black-35', 'Black-35', '6E8ijh6vfVXe9blcyW0yhqMFM9ZJ0rLOK9zEb5a8.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(81, 'AMDCSA-Black-36', 'Black-36', 'k8DzoChvu29oXtlp2FTMvtBrQ2JDt4gmHL0tTPU8.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(82, 'AMDCSA-Black-37', 'Black-37', '1eqDjxJvBZzE2TCBsCpuz4tsLPwFBQYGawoTQWcs.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(83, 'AMDCSA-Black-38', 'Black-38', 'bJNAA5l7hvTBIsbgn6YHwy471YgOQZUPFZwH80O5.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(84, 'AMDCSA-Black-39', 'Black-39', 'O5IkFbPlZm3nscQG7aZYv6jLIIVW4cYVvZJA5wbz.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(85, 'AMDCSA-Black-40', 'Black-40', 'qIcARDENb28eUnlCCbFpR8IFokZeW6lpW4HtAWgV.webp', 898000, 449000, 120, 8, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(86, 'AMGSVD-37', '37', '1B99LNFweUJO5nssrhFFwuSnCE80rOz2l7HtV8tz.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(87, 'AMGSVD-38', '38', 'iiqNY2DjT6WEABJpgU1Bb1hBVdzK7NZhAzyIJMxT.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(88, 'AMGSVD-39', '39', 'NwHrV4hpQehxUbzBRWK8SMS5ykJ4aRq7815JaKOo.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(89, 'AMGSVD-40', '40', 'LF4Nty4jaGhY1HextfXHlPi3dx3dLlFnIvSozGQZ.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(90, 'AMGSVD-41', '41', 'sgyM5I6CIjvuE7jSydw00uXWNNqsxbyay0hU3gJP.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(91, 'AMGSVD-42', '42', 'uVimmbseqvd350nJasTqMSrhrPUzKbzp3fpEWyHt.webp', 3590000, 2590000, 100, 9, 1, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(92, 'AGDBBD-Black-35', 'Black-35', 'eQm2lR9Z0LzgEqRdP7Khknqw173PbYE7hxp2fo2t.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(93, 'AGDBBD-Black-36', 'Black-36', 'RKFxIvbr8FFWIOSl90owd2LIymNYSGUvpZlYRZKE.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(94, 'AGDBBD-Black-37', 'Black-37', 'farE2GIeyF8t8bSyiQMUlPAk65V2v1D1hzV11xQu.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(95, 'AGDBBD-Black-38', 'Black-38', 'CEe97HfpijFU5vOcPm0YEkeemsXQH5rYjN8xndHP.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(96, 'AGDBBD-Beige-35', 'Beige-35', 'OXAh6Iqh33ATGaTFIH5fpVblqCzxcZCTHZZoh63r.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(97, 'AGDBBD-Beige-36', 'Beige-36', 'uvt3Ae3xOF8GV2l6V3B8W4H4MgFPqWCSHbXN0cHa.webp', 359000, 259000, 95, 10, 1, '2024-12-05 04:28:15', '2024-12-15 08:41:04'),
(98, 'AGDBBD-Beige-37', 'Beige-37', 'cxzDkLxno9RYjrnaFBBL1KsXE6FEfgs7QwHC05Lp.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(99, 'AGDBBD-Beige-38', 'Beige-38', 'fUMzwjNgVTN1EU1x8FwT4X5QDfZ1IELb3NCTgFfF.webp', 359000, 259000, 100, 10, 1, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(100, 'JT0102-White-L', 'White-L', 's7lr4uHzu6sWz4ja1OiEIggRjIZ5KufzNzwbxRqR.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(101, 'JT0102-White-XL', 'White-XL', 'k8apN7K40875W0514fc2DyLGhxolKvod557XUpfu.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(102, 'JT0102-White-XXL', 'White-XXL', '2q2tZgJJiY8rPvJUiSQi6gEWCJGgQ8CyuORnLOIe.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(103, 'JT0102-Light Gray-M', 'Light Gray-M', '79C3DfZt1UdS204JNgF1FUqVLzwC4bTSOtrIvRHV.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(104, 'JT0102-Light Gray-L', 'Light Gray-L', 'xMrCacOiUfVFtpPUNmzuPLoUquvmP8Ws4SyGfOk3.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(105, 'JT0102-Light Gray-XL', 'Light Gray-XL', 'aSlqS59PjHfvBD8i3Zp6tzuw8vx36LMM8tVH9hJk.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(106, 'JT0102-Light Gray-XXL', 'Light Gray-XXL', 'aZFfnrQ9kxoNcJ74tnon4EItgyzROIoPu1r0hUx4.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(107, 'JT0102-Brown-M', 'Brown-M', 'iiKfWSeCohKWq8rYBwHSzB9WQ1vrHViAIIGFbiBT.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(108, 'JT0102-Brown-L', 'Brown-L', 'N0F8BDPyCCscuSObfvXLNs5dv3NZT0jl7lzOXbIK.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(109, 'JT0102-Brown-XL', 'Brown-XL', 'A7IcOWj97mBKZjj2VD07mIJGCwjkWSis0xTzB29v.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(110, 'JT0102-Brown-XXL', 'Brown-XXL', 'sRzRmaSUqjUx4eFdtwc7HUx59yG6PPXRgtTg8KZl.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(111, 'JT0102-Black-M', 'Black-M', 'tkc4ONV5Td6rBuGJOgqqrAJmWZm5dli8opN2YhAg.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(112, 'JT0102-Black-L', 'Black-L', 'rs2xVZVOl2vrJxOOdJkNIj22cOuJpuxlygsIgCsj.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(113, 'JT0102-Black-XL', 'Black-XL', 'woZJvpEyIomoi3SXqV0krCda0eVTlIMlGXBnJU52.webp', 200000, 169000, 95, 11, 1, '2024-12-05 07:00:48', '2024-12-10 08:32:40'),
(114, 'JT0102-Black-XXL', 'Black-XXL', 'TUT12BSkVd7FR9Fac5N0z8G3JPQIlzheeWNNnIc2.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(115, 'JT0102-Beige-L', 'Beige-L', 'BNejc2CLMKNMDADqXPgIYip9WciHe2IAziAN9sBf.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(116, 'JT0102-Beige-XL', 'Beige-XL', 'YpF58rdBmuLWjsFHhXUzQILU1LD6YF5Cgigi0Xcl.webp', 200000, 169000, 99, 11, 1, '2024-12-05 07:00:48', '2024-12-05 18:52:14'),
(117, 'JT0102-Beige-XXL', 'Beige-XXL', 'Z6P2cWiBVeZKHx0rsAAdLILRfrOplA7ha1Du6Rbg.webp', 200000, 169000, 100, 11, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(118, 'AMN153-White-M', 'White-M', 'EHj7BHsNeZvtiynGXhjtfqS6n0zdcFUdSWhfiA4a.webp', 620000, 569000, 100, 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(119, 'AMN153-White-L', 'White-L', 'dGYY3AQcIsVsdoodwNAfCqpeaMOuUYWPPUSTkpUL.webp', 620000, 569000, 100, 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(120, 'AMN153-White-XL', 'White-XL', 'nXxvy8bWzOvphCJCo8Qamh7kvmoln5NEsftYomlz.webp', 620000, 569000, 100, 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(121, 'AMN153-Black-M', 'Black-M', '71ylFgarQMMKMqmM11RDnbKsBBE0iySbnQkC8XMj.webp', 620000, 569000, 100, 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(122, 'AMN153-Black-L', 'Black-L', 'Dn1bLSLfEWCEmrcbk0i0NzkraqhXhZzQDev9GIdJ.webp', 620000, 569000, 99, 12, 1, '2024-12-05 07:47:06', '2024-12-05 18:52:14'),
(123, 'AMN153-Black-XL', 'Black-XL', '9q6GZixJXCs3VqGKYu8yjacVOUnGrC1PLz39VlBL.webp', 620000, 569000, 100, 12, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(124, 'LNE24126-Light Blue-S', 'Light Blue-S', 'nRHE3OWUMl3CQl4jkkyUmv2WLwI4KtymSotjaKLi.webp', 222000, 196000, 100, 13, 1, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(125, 'LNE24126-Light Blue-M', 'Light Blue-M', 'CeKue0glPG5E26shyE0DW3HrMZ4IP1gRdLclYgHX.webp', 222000, 196000, 96, 13, 1, '2024-12-05 08:00:36', '2024-12-15 08:41:04'),
(126, 'CROPEA-White-M', 'White-M', 'g0AI6yzBKeSL87NNmA8dkLSE24Pv2YQNtQ07XsIK.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(127, 'CROPEA-White-L', 'White-L', 'yhFmxr8WzVIOJQkML3fjqm2Du6p2PHrzQrgcvs02.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(128, 'CROPEA-White-XL', 'White-XL', '3EMbBWcwz8rWbvA12YcpeMu6Uskve6bkGySag1sD.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(129, 'CROPEA-Black-M', 'Black-M', 'KnfQtqLS2Q6iCrclM0bndwfAkgjYsn3SZbvtOyna.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(130, 'CROPEA-Black-L', 'Black-L', 'hMsUbEHeI9Z6llnRO9V4x6RnjHPNg7dMbQ05eJtF.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(131, 'CROPEA-Black-XL', 'Black-XL', '9roUbsOLr6ro1clJD3RpJOjh4pfPBMWjS8zDR5DQ.webp', 599000, 459000, 100, 14, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_attribute_values`
--

CREATE TABLE `product_variant_attribute_values` (
  `id` bigint UNSIGNED NOT NULL,
  `product_variant_id` bigint UNSIGNED NOT NULL COMMENT 'Khóa ngoại, thuộc về biến thể nào',
  `attribute_value_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định biến thể này có những thuộc tính nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variant_attribute_values`
--

INSERT INTO `product_variant_attribute_values` (`id`, `product_variant_id`, `attribute_value_id`, `created_at`, `updated_at`) VALUES
(1, 1, 8, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(2, 1, 2, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(3, 2, 8, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(4, 2, 3, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(5, 3, 8, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(6, 3, 4, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(7, 4, 8, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(8, 4, 5, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(9, 5, 9, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(10, 5, 2, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(11, 6, 9, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(12, 6, 3, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(13, 7, 9, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(14, 7, 4, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(15, 8, 9, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(16, 8, 5, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(17, 9, 11, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(18, 9, 2, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(19, 10, 11, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(20, 10, 3, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(21, 11, 11, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(22, 11, 4, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(23, 12, 11, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(24, 12, 5, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(25, 13, 12, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(26, 13, 2, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(27, 14, 12, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(28, 14, 3, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(29, 15, 12, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(30, 15, 4, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(31, 16, 12, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(32, 16, 5, '2024-12-03 04:27:04', '2024-12-03 04:27:04'),
(33, 17, 9, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(34, 17, 2, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(35, 18, 9, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(36, 18, 3, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(37, 19, 9, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(38, 19, 4, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(39, 20, 9, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(40, 20, 5, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(41, 21, 10, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(42, 21, 2, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(43, 22, 10, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(44, 22, 3, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(45, 23, 10, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(46, 23, 4, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(47, 24, 10, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(48, 24, 5, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(49, 25, 12, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(50, 25, 2, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(51, 26, 12, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(52, 26, 3, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(53, 27, 12, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(54, 27, 4, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(55, 28, 12, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(56, 28, 5, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(57, 29, 13, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(58, 29, 2, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(59, 30, 13, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(60, 30, 3, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(61, 31, 13, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(62, 31, 4, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(63, 32, 13, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(64, 32, 5, '2024-12-03 04:43:01', '2024-12-03 04:43:01'),
(65, 33, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(66, 33, 2, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(67, 34, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(68, 34, 3, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(69, 35, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(70, 35, 4, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(71, 36, 1, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(72, 36, 5, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(73, 37, 9, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(74, 37, 2, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(75, 38, 9, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(76, 38, 3, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(77, 39, 9, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(78, 39, 4, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(79, 40, 9, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(80, 40, 5, '2024-12-03 05:00:16', '2024-12-03 05:00:16'),
(81, 41, 37, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(82, 41, 30, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(83, 42, 37, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(84, 42, 31, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(85, 43, 37, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(86, 43, 32, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(87, 44, 37, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(88, 44, 33, '2024-12-03 05:15:35', '2024-12-03 05:15:35'),
(89, 45, 6, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(90, 45, 2, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(91, 46, 6, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(92, 46, 3, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(93, 47, 6, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(94, 47, 4, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(95, 48, 37, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(96, 48, 2, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(97, 49, 37, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(98, 49, 3, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(99, 50, 37, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(100, 50, 4, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(101, 51, 38, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(102, 51, 2, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(103, 52, 38, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(104, 52, 3, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(105, 53, 38, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(106, 53, 4, '2024-12-03 05:26:22', '2024-12-03 05:26:22'),
(107, 54, 9, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(108, 54, 2, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(109, 55, 9, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(110, 55, 3, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(111, 56, 9, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(112, 56, 4, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(113, 57, 9, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(114, 57, 5, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(115, 58, 9, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(116, 58, 39, '2024-12-03 05:41:41', '2024-12-03 05:41:41'),
(117, 59, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(118, 59, 2, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(119, 60, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(120, 60, 3, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(121, 61, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(122, 61, 4, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(123, 62, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(124, 62, 5, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(125, 63, 1, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(126, 63, 39, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(127, 64, 13, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(128, 64, 2, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(129, 65, 13, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(130, 65, 3, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(131, 66, 13, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(132, 66, 4, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(133, 67, 13, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(134, 67, 5, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(135, 68, 13, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(136, 68, 39, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(137, 69, 37, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(138, 69, 2, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(139, 70, 37, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(140, 70, 3, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(141, 71, 37, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(142, 71, 4, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(143, 72, 37, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(144, 72, 5, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(145, 73, 37, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(146, 73, 39, '2024-12-03 05:58:29', '2024-12-03 05:58:29'),
(147, 74, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(148, 74, 40, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(149, 75, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(150, 75, 41, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(151, 76, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(152, 76, 42, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(153, 77, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(154, 77, 43, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(155, 78, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(156, 78, 44, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(157, 79, 1, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(158, 79, 45, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(159, 80, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(160, 80, 40, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(161, 81, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(162, 81, 41, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(163, 82, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(164, 82, 42, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(165, 83, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(166, 83, 43, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(167, 84, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(168, 84, 44, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(169, 85, 9, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(170, 85, 45, '2024-12-05 03:45:33', '2024-12-05 03:45:33'),
(171, 86, 42, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(172, 87, 43, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(173, 88, 44, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(174, 89, 45, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(175, 90, 46, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(176, 91, 47, '2024-12-05 04:21:14', '2024-12-05 04:21:14'),
(177, 92, 9, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(178, 92, 40, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(179, 93, 9, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(180, 93, 41, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(181, 94, 9, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(182, 94, 42, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(183, 95, 9, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(184, 95, 43, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(185, 96, 10, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(186, 96, 40, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(187, 97, 10, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(188, 97, 41, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(189, 98, 10, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(190, 98, 42, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(191, 99, 10, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(192, 99, 43, '2024-12-05 04:28:15', '2024-12-05 04:28:15'),
(193, 100, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(194, 100, 4, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(195, 101, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(196, 101, 5, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(197, 102, 1, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(198, 102, 39, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(199, 103, 6, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(200, 103, 3, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(201, 104, 6, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(202, 104, 4, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(203, 105, 6, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(204, 105, 5, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(205, 106, 6, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(206, 106, 39, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(207, 107, 8, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(208, 107, 3, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(209, 108, 8, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(210, 108, 4, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(211, 109, 8, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(212, 109, 5, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(213, 110, 8, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(214, 110, 39, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(215, 111, 9, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(216, 111, 3, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(217, 112, 9, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(218, 112, 4, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(219, 113, 9, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(220, 113, 5, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(221, 114, 9, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(222, 114, 39, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(223, 115, 10, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(224, 115, 4, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(225, 116, 10, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(226, 116, 5, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(227, 117, 10, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(228, 117, 39, '2024-12-05 07:00:48', '2024-12-05 07:00:48'),
(229, 118, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(230, 118, 3, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(231, 119, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(232, 119, 4, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(233, 120, 1, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(234, 120, 5, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(235, 121, 9, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(236, 121, 3, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(237, 122, 9, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(238, 122, 4, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(239, 123, 9, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(240, 123, 5, '2024-12-05 07:47:06', '2024-12-05 07:47:06'),
(241, 124, 13, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(242, 124, 2, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(243, 125, 13, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(244, 125, 3, '2024-12-05 08:00:36', '2024-12-05 08:00:36'),
(245, 126, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(246, 126, 3, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(247, 127, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(248, 127, 4, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(249, 128, 1, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(250, 128, 5, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(251, 129, 9, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(252, 129, 3, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(253, 130, 9, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(254, 130, 4, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(255, 131, 9, '2024-12-05 08:04:52', '2024-12-05 08:04:52'),
(256, 131, 5, '2024-12-05 08:04:52', '2024-12-05 08:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_view_histories`
--

CREATE TABLE `product_view_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `click` int NOT NULL COMMENT 'Số lượt click vào xem sản phẩm của người dùng',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào click',
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định sản phẩm nào được người dùng click',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_votes`
--

CREATE TABLE `product_votes` (
  `id` bigint UNSIGNED NOT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nội dung đánh giá',
  `star` double(8,2) NOT NULL COMMENT 'Số sao',
  `edit` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Trạng thái chỉnh sửa đánh giá, mặc định là chưa, khi nào người dùng sửa đánh giá thì chuyển thành true , nếu là true thì không cho sửa nữa',
  `product_variant_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định biến thể sản phẩm nào đang được đánh giá',
  `order_detail_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định đơn hàng chi tiết nào đang được đánh giá',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào đang đánh giá',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT '1: hiện đánh giá, 0: ẩn đánh giá',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_votes`
--

INSERT INTO `product_votes` (`id`, `content`, `star`, `edit`, `product_variant_id`, `order_detail_id`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tuyệt vời', 5.00, 0, 30, 1, 3, 1, '2024-12-03 09:26:57', '2024-12-04 08:46:26'),
(2, 'Sản phẩm đẹp, xứng đáng giá tiền.', 5.00, 0, 38, 2, 5, 1, '2024-12-05 03:19:51', '2024-12-05 03:19:51'),
(3, 'Sản phẩm đẹp, xứng đáng giá tiền.', 5.00, 0, 44, 5, 5, 1, '2024-12-05 03:20:11', '2024-12-05 03:20:11'),
(4, 'Sản phẩm đẹp, xứng đáng giá tiền.', 5.00, 0, 66, 3, 5, 1, '2024-12-05 03:20:21', '2024-12-05 03:20:21'),
(5, 'Sản phẩm đẹp, xứng đáng giá tiền.', 4.00, 0, 36, 4, 5, 1, '2024-12-05 03:20:33', '2024-12-05 03:20:33'),
(6, 'Sản phẩm ok', 5.00, 0, 122, 11, 5, 1, '2024-12-05 19:31:27', '2024-12-08 04:13:41'),
(7, 'Sản phẩm đáng tiền', 5.00, 0, 40, 12, 3, 1, '2024-12-10 08:33:08', '2024-12-10 08:33:08'),
(8, 'Sản phẩm đáng tiền', 5.00, 0, 113, 13, 3, 1, '2024-12-10 08:33:12', '2024-12-10 08:33:12'),
(9, 'Sản phẩm đáng tiền', 5.00, 0, 38, 14, 3, 1, '2024-12-10 08:33:15', '2024-12-10 08:33:15'),
(10, 'Tôi thích sản phẩm này.', 5.00, 0, 125, 32, 25, 1, '2024-12-15 08:43:00', '2024-12-15 08:43:00'),
(11, 'Tôi thích sản phẩm này. Giao hơi muộn', 4.00, 0, 97, 33, 25, 1, '2024-12-15 08:43:16', '2024-12-15 08:43:16'),
(12, 'Oki la❤️', 5.00, 0, 123, 28, 3, 1, '2024-12-15 08:51:45', '2024-12-15 08:51:45'),
(13, 'Oki la❤️', 5.00, 0, 59, 27, 3, 1, '2024-12-15 08:51:50', '2024-12-15 08:51:50'),
(14, 'Oki la❤️', 5.00, 0, 34, 26, 3, 1, '2024-12-15 08:51:54', '2024-12-15 08:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_vote_files`
--

CREATE TABLE `product_vote_files` (
  `id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên file',
  `file_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại file (có 2 loại là ảnh và video)',
  `product_vote_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định đánh giá nào',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_vouchers`
--

CREATE TABLE `product_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định sản phẩm nào được áp dụng voucher này',
  `voucher_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định voucher nào được sản phẩm áp dụng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` enum('Processing','Pending','Shipping','Completed','Cancelled','Returned') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên trạng thái',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Processing', '2024-12-03 16:22:04', '2024-12-03 16:22:04'),
(2, 'Pending', '2024-12-03 16:22:04', '2024-12-03 16:22:04'),
(3, 'Shipping', '2024-12-03 16:22:30', '2024-12-03 16:22:30'),
(4, 'Completed', '2024-12-03 16:22:30', '2024-12-03 16:22:30'),
(5, 'Cancelled', '2024-12-03 16:22:30', '2024-12-03 16:22:30'),
(6, 'Returned', '2024-12-03 16:23:08', '2024-12-03 16:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `status_orders`
--

CREATE TABLE `status_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định trạng thái nào',
  `order_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định đơn hàng nào có trạng thái này',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_orders`
--

INSERT INTO `status_orders` (`id`, `status_id`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-12-03 09:26:09', '2024-12-03 09:26:09'),
(2, 3, 1, '2024-12-03 09:26:24', '2024-12-03 09:26:24'),
(3, 4, 1, '2024-12-03 09:26:31', '2024-12-03 09:26:31'),
(4, 1, 2, '2024-12-05 03:16:39', '2024-12-05 03:16:39'),
(5, 2, 2, '2024-12-05 03:17:35', '2024-12-05 03:17:35'),
(6, 3, 2, '2024-12-05 03:18:40', '2024-12-05 03:18:40'),
(7, 4, 2, '2024-12-05 03:18:48', '2024-12-05 03:18:48'),
(8, 2, 3, '2024-12-05 18:09:07', '2024-12-05 18:09:07'),
(9, 3, 3, '2024-12-05 18:14:07', '2024-12-05 18:14:07'),
(10, 4, 3, '2024-12-05 18:15:10', '2024-12-05 18:15:10'),
(11, 2, 4, '2024-12-05 18:21:05', '2024-12-05 18:21:05'),
(12, 3, 4, '2024-12-05 18:21:17', '2024-12-05 18:21:17'),
(13, 4, 4, '2024-12-05 18:52:14', '2024-12-05 18:52:14'),
(14, 2, 5, '2024-12-10 08:30:19', '2024-12-10 08:30:19'),
(15, 3, 5, '2024-12-10 08:32:06', '2024-12-10 08:32:06'),
(16, 4, 5, '2024-12-10 08:32:40', '2024-12-10 08:32:40'),
(17, 2, 6, '2024-12-10 09:03:14', '2024-12-10 09:03:14'),
(18, 1, 7, '2024-12-10 09:27:22', '2024-12-10 09:27:22'),
(19, 1, 8, '2024-12-10 09:27:54', '2024-12-10 09:27:54'),
(20, 5, 7, '2024-12-10 10:04:10', '2024-12-10 10:04:10'),
(21, 5, 8, '2024-12-10 10:11:29', '2024-12-10 10:11:29'),
(22, 2, 9, '2024-12-11 10:02:02', '2024-12-11 10:02:02'),
(23, 3, 9, '2024-12-11 10:02:35', '2024-12-11 10:02:35'),
(24, 4, 9, '2024-12-11 10:02:57', '2024-12-11 10:02:57'),
(26, 2, 10, '2024-12-12 10:53:12', '2024-12-12 10:53:12'),
(27, 5, 10, '2024-12-12 10:54:22', '2024-12-12 10:54:22'),
(28, 2, 11, '2024-12-12 11:00:59', '2024-12-12 11:00:59'),
(29, 5, 11, '2024-12-12 11:01:31', '2024-12-12 11:01:31'),
(30, 2, 12, '2024-12-13 07:57:47', '2024-12-13 07:57:47'),
(31, 3, 12, '2024-12-13 07:58:19', '2024-12-13 07:58:19'),
(32, 3, 6, '2024-12-13 07:58:21', '2024-12-13 07:58:21'),
(33, 4, 12, '2024-12-13 07:58:25', '2024-12-13 07:58:25'),
(34, 4, 6, '2024-12-13 07:58:29', '2024-12-13 07:58:29'),
(35, 2, 13, '2024-12-13 09:02:27', '2024-12-13 09:02:27'),
(36, 3, 13, '2024-12-13 09:02:36', '2024-12-13 09:02:36'),
(37, 4, 13, '2024-12-13 09:02:39', '2024-12-13 09:02:39'),
(38, 2, 14, '2024-12-15 00:35:02', '2024-12-15 00:35:02'),
(39, 3, 14, '2024-12-15 00:36:19', '2024-12-15 00:36:19'),
(40, 4, 14, '2024-12-15 00:36:23', '2024-12-15 00:36:23'),
(41, 1, 15, '2024-12-15 08:38:34', '2024-12-15 08:38:34'),
(42, 2, 15, '2024-12-15 08:40:32', '2024-12-15 08:40:32'),
(43, 3, 15, '2024-12-15 08:40:51', '2024-12-15 08:40:51'),
(44, 4, 15, '2024-12-15 08:41:04', '2024-12-15 08:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Họ và tên',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tên đăng nhập',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email của người dùng',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Số điện thoại',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Địa chỉ',
  `email_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Email đã được xác minh lúc nào',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mật khẩu',
  `role` enum('member','staff','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member' COMMENT 'Vai trò của người dùng, ở đây có 3 vai trò: người dùng, nhân viên và admin, admin lớn nhất',
  `status` enum('active','banned') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'Trạng thái của tài khoản',
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID tài khoản Google',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone`, `address`, `email_verified_at`, `password`, `role`, `status`, `google_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'admin@gmail.com', NULL, NULL, NULL, '$2y$12$K.Jh3.os3oP2J7U6h3Pzruk/jGqxUr4fbKaJ3fi.fHqaM/zvbSnLK', 'admin', 'active', NULL, 'OiMqOI6fNYX8DeanPT4gKzYorVO6MIMGv9AfIxmc8QKT0lSoYetJ2msxqRK0', '2024-12-02 11:56:02', '2024-12-16 02:45:39'),
(3, 'Tôi là khách', 'khachhang1', 'khachhang1@gmail.com', '0367750154', 'Mỹ đình, NAm từ liêm, hà nội', NULL, '$2y$12$AbpPPWdApcb6SQOkU4PvrufiIxGYiNEeb3Y5WZTsnka4QmYgyLWKG', 'member', 'active', NULL, 'BUKPBIGlZTjfOJnMTvRKFX8dQ0jOaEZIvBaABNIwOh00YiXkjU5JF5kzUc9h', '2024-12-03 09:24:57', '2025-01-20 01:21:07'),
(5, 'Khách Văn Hàng', 'khachhang2', 'khachhang2@gmail.com', '03677512345', 'Mỹ đình, Hà nội', NULL, '$2y$12$8jPTMFKbqH5myZ4m1FcaHOxDBMOMasDNtBMhge7pztU2q61.pmpYW', 'member', 'active', NULL, NULL, '2024-12-05 03:10:53', '2024-12-11 08:38:16'),
(7, 'Nhân viên 2', 'nhanvien2', 'nhanvien2@gmail.com', '0367759123', NULL, NULL, '$2y$12$2UdtbTRbebWJFXRehdUypOvTJPSaKLB3vgohqhjqfPKNuLEW8S3Z.', 'staff', 'active', NULL, 'MJWvF10Sv3T9CcDddqg79X3GaZYgHV5rQYRu183dwsiNRqwz3k5TQgKgQYpI', '2024-12-11 08:10:45', '2024-12-11 09:35:05'),
(11, 'Khách hàng 3', 'khachhang3', 'khachhang3@fpt.edu.vn', '0123456789', 'Đơn nguyên 5, Mỹ đình, Hà nội', NULL, '$2y$12$VaaYGj.9PdhbsEZOUt3bhuzd/zmSGKul45CRZSbKgPApSOwPWdVju', 'member', 'active', NULL, NULL, '2024-12-11 08:51:44', '2024-12-11 10:01:51'),
(14, 'Nhân viên 3', 'nhanvien3', 'nhanvien3@gmail.com', '01234567897', NULL, '2024-12-11 09:05:41', '$2y$12$ox2t8OSRHt5WatXhqg0.mO.govODdN2.bRFT3lzDS/5IL.UF.sZNq', 'staff', 'active', '108919494538805274198', 'pt5qn4tEBQHbzs5OUVK47ShUZeSi9PE8nmgdJzQDnu02fnprmXqbSDwJCtQ4', '2024-12-11 09:05:24', '2024-12-15 07:33:58'),
(15, 'Khách Hàng abcd', 'abcd', 'dacsonrew54@gmail.com', '0367750153', 'Hà Nội, Việt Nam', NULL, '$2y$12$Y/4TL.MC4poCxpUYffpE5.53PRuz6hx.uXKGykTRVBbCd6ewrufn.', 'member', 'active', NULL, NULL, '2024-12-11 09:14:39', '2024-12-15 00:38:48'),
(16, 'Nhân viên 1', 'nhanvien1', 'nhanvien1@gmail.com', '0367759123', NULL, NULL, '$2y$12$3P9FLhjGRX8iDhfPRKTdNOk0.DF6L1w/xqbAFhE4Pv6UmHAvS20..', 'staff', 'active', NULL, NULL, '2024-12-11 09:36:33', '2024-12-11 09:36:33'),
(19, 'Khách hàng test', 'test', 'test@fpt.edu.vn', '0367751234', 'Nam từ liêm, Hà Nội', '2024-12-13 04:22:26', '$2y$12$wJTeb.TzST1TqLC4iLgPaOilnT2uUDJGUpAEd0HbQrfP3tPeHTqIu', 'member', 'active', NULL, NULL, '2024-12-13 04:22:26', '2024-12-13 07:57:42'),
(24, 'Sơn Đắc', NULL, 'dacson273@gmail.com', NULL, NULL, '2024-12-15 08:04:49', '$2y$12$LFZZnF8CHGjpm73lwdQwLuP0yTckIIgWcUQbMfFxRF2wbr.R5dHIe', 'member', 'active', '106681699343027116176', 'XaBygDQ8CcKFWcxudD1cFDyXMGQGoV9xUqAV3r1Y9CpTb1Psgg4CqxigQK2x', '2024-12-15 08:04:49', '2024-12-15 08:04:49'),
(25, 'Trương Đắc Sơn', NULL, 'sontdph37788@fpt.edu.vn', '0367750546', NULL, '2024-12-15 08:16:57', '$2y$12$hJ8G8qLJqEHbRaraiY8gZuxzUmS6BAp3awLnVOjs1ACHUbOl1RAFW', 'member', 'active', '101780229626317745977', '8GZdChXTPMqAHf3dqajfOYRN1h6WV6iongJmb8rWrOZnVYBHBfsNaDszrXTb', '2024-12-15 08:15:48', '2024-12-15 08:31:35'),
(33, 'Dũng nguyen', NULL, 'dungtoi2074@gmail.com', NULL, NULL, '2024-12-16 10:46:50', '$2y$12$ICArncbk1SM2PYx9eD/lGe2lG71CDvkyoBLacOOMqbBlV3AVt7RvC', 'member', 'active', '112453489673225625394', 'IaWlQwiKNJCIWUzpyR8txm4ipzOprCyzDVgYoV4lTExQLvdp99w62MIQGwQF', '2024-12-16 10:46:50', '2024-12-16 10:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_bans`
--

CREATE TABLE `user_bans` (
  `id` bigint UNSIGNED NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Lý do thay đổi trạng thái',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào được thay đổi trạng thái',
  `status` tinyint(1) NOT NULL COMMENT 'Loại trạng thái, có 2 loại là active và inactive',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái hiệu lực, mặc định là 1 (có hiệu lực, 0 là không có hiệu lực)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_bans`
--

INSERT INTO `user_bans` (`id`, `reason`, `user_id`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bạn đã bị ban', 3, 0, 0, '2024-12-06 03:59:18', '2024-12-06 04:00:51'),
(2, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 04:00:51', '2024-12-06 04:01:02'),
(3, 'Khoá', 3, 0, 0, '2024-12-06 04:01:02', '2024-12-06 04:01:38'),
(4, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 04:01:38', '2024-12-06 04:39:03'),
(5, 'bạn đã bị khoá.', 3, 0, 0, '2024-12-06 04:39:04', '2024-12-06 04:39:43'),
(6, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 04:39:43', '2024-12-06 04:39:58'),
(7, 'khff', 3, 0, 0, '2024-12-06 04:39:58', '2024-12-06 04:40:17'),
(8, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 04:40:17', '2024-12-06 05:27:52'),
(9, 'nghf', 3, 0, 0, '2024-12-06 05:27:52', '2024-12-06 05:28:29'),
(10, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 05:28:29', '2024-12-06 05:45:24'),
(11, 'htg', 3, 0, 0, '2024-12-06 05:45:24', '2024-12-06 05:45:44'),
(12, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 05:45:44', '2024-12-06 06:00:19'),
(13, 'hbdfbfd', 3, 0, 0, '2024-12-06 06:00:19', '2024-12-06 06:07:32'),
(14, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:07:32', '2024-12-06 06:07:43'),
(15, 'thích thì khoá', 3, 0, 0, '2024-12-06 06:07:43', '2024-12-06 06:13:41'),
(16, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:13:41', '2024-12-06 06:14:23'),
(17, 'hihihi', 3, 0, 0, '2024-12-06 06:14:23', '2024-12-06 06:32:12'),
(18, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:32:12', '2024-12-06 06:32:44'),
(19, 'nfsgd', 3, 0, 0, '2024-12-06 06:32:44', '2024-12-06 06:33:19'),
(20, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:33:19', '2024-12-06 06:42:47'),
(21, 'hdbs', 3, 0, 0, '2024-12-06 06:42:47', '2024-12-06 06:43:32'),
(22, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:43:32', '2024-12-06 06:43:50'),
(23, 'gsxdvfs', 3, 0, 0, '2024-12-06 06:43:50', '2024-12-06 06:49:04'),
(24, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:49:04', '2024-12-06 06:49:11'),
(25, 'hhihih', 3, 0, 0, '2024-12-06 06:49:11', '2024-12-06 06:51:24'),
(26, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:51:24', '2024-12-06 06:51:32'),
(27, 'HAHAH', 3, 0, 0, '2024-12-06 06:51:32', '2024-12-06 06:57:22'),
(28, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:57:22', '2024-12-06 06:57:41'),
(29, 'haha', 3, 0, 0, '2024-12-06 06:57:41', '2024-12-06 06:58:05'),
(30, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:58:05', '2024-12-06 06:58:11'),
(31, 'hiihih', 3, 0, 0, '2024-12-06 06:58:11', '2024-12-06 06:58:27'),
(32, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 06:58:27', '2024-12-06 06:59:30'),
(33, 'Bạn đã bị khoá', 3, 0, 0, '2024-12-06 06:59:30', '2024-12-06 07:02:44'),
(34, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 07:02:44', '2024-12-06 07:39:09'),
(35, 'Bạn đã bị khoá tài khoản', 5, 0, 0, '2024-12-06 07:03:26', '2024-12-06 07:09:29'),
(36, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:09:29', '2024-12-06 07:10:09'),
(37, 'ban', 5, 0, 0, '2024-12-06 07:10:09', '2024-12-06 07:11:06'),
(38, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:11:06', '2024-12-06 07:12:52'),
(39, 'khoá', 5, 0, 0, '2024-12-06 07:12:52', '2024-12-06 07:13:36'),
(40, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:13:36', '2024-12-06 07:15:25'),
(41, 'Phát hiện dấu hiệu gian lận', 5, 0, 0, '2024-12-06 07:15:25', '2024-12-06 07:18:42'),
(42, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:18:42', '2024-12-06 07:19:54'),
(43, 'Khoá tk', 5, 0, 0, '2024-12-06 07:19:54', '2024-12-06 07:20:46'),
(44, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:20:46', '2024-12-06 07:35:55'),
(45, 'bạn đã bị khoá', 5, 0, 0, '2024-12-06 07:35:55', '2024-12-06 07:35:59'),
(46, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:35:59', '2024-12-06 07:38:17'),
(47, 'hhihi', 5, 0, 0, '2024-12-06 07:38:17', '2024-12-06 07:38:21'),
(48, 'Mở khóa tài khoản', 5, 1, 0, '2024-12-06 07:38:21', '2024-12-10 10:35:55'),
(49, 'haah', 3, 0, 0, '2024-12-06 07:39:09', '2024-12-06 07:39:13'),
(50, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 07:39:13', '2024-12-06 07:45:39'),
(51, 'hêhhh', 3, 0, 0, '2024-12-06 07:45:39', '2024-12-06 07:45:43'),
(52, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 07:45:43', '2024-12-06 07:50:14'),
(53, 'Ban', 3, 0, 0, '2024-12-06 07:50:14', '2024-12-06 08:07:15'),
(54, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-06 08:07:15', '2024-12-11 08:16:38'),
(55, 'hshaah', 5, 0, 0, '2024-12-10 10:35:55', '2024-12-11 08:38:16'),
(56, 'ngu', 7, 0, 0, '2024-12-11 08:10:59', '2024-12-11 09:33:39'),
(57, 'ngu', 3, 0, 0, '2024-12-11 08:16:38', '2024-12-11 08:38:20'),
(58, 'Mở khóa tài khoản', 5, 1, 1, '2024-12-11 08:38:16', '2024-12-11 08:38:16'),
(59, 'Mở khóa tài khoản', 3, 1, 0, '2024-12-11 08:38:20', '2025-01-20 01:20:51'),
(60, 'khg', 15, 0, 0, '2024-12-11 09:31:35', '2024-12-15 00:32:01'),
(61, 'Mở khóa tài khoản', 7, 1, 0, '2024-12-11 09:33:40', '2024-12-11 09:34:52'),
(62, 'haha', 7, 0, 0, '2024-12-11 09:34:52', '2024-12-11 09:35:05'),
(63, 'Mở khóa tài khoản', 7, 1, 1, '2024-12-11 09:35:05', '2024-12-11 09:35:05'),
(64, 'Mở khóa tài khoản', 15, 1, 0, '2024-12-15 00:32:01', '2024-12-15 00:38:31'),
(65, 'nguuuuu', 15, 0, 0, '2024-12-15 00:38:31', '2024-12-15 00:38:48'),
(66, 'Mở khóa tài khoản', 15, 1, 1, '2024-12-15 00:38:48', '2024-12-15 00:38:48'),
(67, 'nguuu', 25, 0, 0, '2024-12-15 08:16:32', '2024-12-15 08:16:39'),
(68, 'Mở khóa tài khoản', 25, 1, 0, '2024-12-15 08:16:39', '2024-12-15 08:16:52'),
(69, 'nguuu', 25, 0, 0, '2024-12-15 08:16:52', '2024-12-15 08:22:23'),
(70, 'Mở khóa tài khoản', 25, 1, 1, '2024-12-15 08:22:23', '2024-12-15 08:22:23'),
(71, 'câm mồm', 3, 0, 0, '2025-01-20 01:20:51', '2025-01-20 01:20:55'),
(72, 'câm mồm', 3, 0, 0, '2025-01-20 01:20:55', '2025-01-20 01:21:07'),
(73, 'Mở khóa tài khoản', 3, 1, 1, '2025-01-20 01:21:07', '2025-01-20 01:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_manager_settings`
--

CREATE TABLE `user_manager_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào được quyền quản lý chức năng này',
  `manager_setting_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định chức năng nào',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái kích hoạt, mặc định là 1 (đã được kích hoạt)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_manager_settings`
--

INSERT INTO `user_manager_settings` (`id`, `user_id`, `manager_setting_id`, `is_active`, `created_at`, `updated_at`) VALUES
(11, 7, 2, 1, '2024-12-11 09:34:22', '2024-12-11 09:34:22'),
(12, 7, 3, 1, '2024-12-11 09:34:23', '2024-12-11 09:34:23'),
(13, 16, 10, 1, '2024-12-15 00:29:12', '2024-12-15 00:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_shipping_addresses`
--

CREATE TABLE `user_shipping_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên đầy đủ của người dùng ví dụ: Phạm Văn A',
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Số điện thoại',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Địa chỉ',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định thông tin này thuộc người dùng nào',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái kích hoạt thông tin này, mặc định là 1(đã kích hoạt)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_shipping_addresses`
--

INSERT INTO `user_shipping_addresses` (`id`, `full_name`, `phone_number`, `address`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tôi là khách hàng', '0124364584', 'hà nội', 3, 0, '2024-12-04 00:34:18', '2024-12-08 03:32:48'),
(2, 'Trương Đắc Sơn', '01335465645', 'hih', 3, 1, '2024-12-08 03:29:31', '2024-12-08 03:32:48'),
(3, 'Trương Đắc Sơn', '01234567890', 'hhihi', 5, 1, '2024-12-10 09:41:37', '2024-12-10 09:51:42'),
(4, 'ăd', '0234567881', '1232', 3, 0, '2024-12-16 03:03:23', '2024-12-16 03:03:23'),
(5, 'scas', '0412512512', 'vfav', 1, 1, '2024-12-16 10:34:04', '2024-12-16 10:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_vouchers`
--

CREATE TABLE `user_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định người dùng nào lưu voucher này',
  `voucher_id` bigint UNSIGNED NOT NULL COMMENT 'Xác định voucher nào được người dùng này lưu',
  `is_used` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Lưu trạng thái đã sử dụng voucher hay chưa, mặc định là chưa == 0!',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_vouchers`
--

INSERT INTO `user_vouchers` (`id`, `user_id`, `voucher_id`, `is_used`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 1, '2024-12-05 18:05:09', '2024-12-05 18:09:07'),
(2, 15, 2, 0, '2024-12-15 00:37:30', '2024-12-15 00:37:30'),
(3, 1, 2, 0, '2024-12-16 02:36:44', '2024-12-16 02:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên voucher',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mã voucher',
  `amount` int NOT NULL COMMENT 'Giá trị giảm',
  `quantity` int NOT NULL COMMENT 'Số lượng voucher',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ảnh voucher',
  `type` enum('fixed','percent','free_ship') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại voucher, ở đây có 3 loại là cố định ví dụ 100k, phần trăm và miễn phí vận chuyển',
  `start_date` date DEFAULT NULL COMMENT 'Thời gian bắt đầu có thể sử dụng được voucher',
  `end_date` date DEFAULT NULL COMMENT 'Thời gian voucher hết hiệu lực',
  `minimum_order_value` int DEFAULT NULL COMMENT 'Giá tiền tối thiểu của đơn hàng',
  `maximum_reduction` int DEFAULT NULL COMMENT 'Giá tiền được giảm tối đa của đơn hàng/sản phẩm (khi loại voucher này là phần trăm)',
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT 'Trạng thái kích hoạt voucher, mặc định là 1(đã kích hoạt)',
  `is_public` tinyint NOT NULL DEFAULT '1' COMMENT 'Xác định voucher này cho phép tất cả tài sử dụng được hay chỉ những tài khoản nào sở hữu voucher này mới có!',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `name`, `code`, `amount`, `quantity`, `image`, `type`, `start_date`, `end_date`, `minimum_order_value`, `maximum_reduction`, `is_active`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'Black Friday', 'BLACK10', 10, 94, 'beesFashion.jpg', 'percent', '2024-12-03', '2024-12-31', 299000, 50000, 1, 1, '2024-12-03 06:30:10', '2024-12-15 08:38:34'),
(2, 'Khuyến mãi 200k', 'KM200', 200000, 199, 'dnxESLbOvYfEFuYKgKff91FkKzS78hDTDOMxllqI.jpg', 'fixed', '2024-12-06', '2024-12-20', 1000000, 200000, 1, 0, '2024-12-05 18:02:11', '2024-12-16 03:08:55'),
(3, 'Giảm 500k cho đơn từ 2tr', 'GIAM500K', 500000, 99, 'f0Ir1l5w088gw2oL6tbuEimqdQpSudaBhoMEYwq5.jpg', 'fixed', '2024-12-10', '2024-12-25', 2000000, 500000, 1, 1, '2024-12-10 08:37:56', '2024-12-16 03:18:11'),
(4, 'Giảm 20% tối đa 100k', 'KM20', 20, 100, 'lm5PBenoZRRggzMhB8jv2STafwzOhxVEpteCb46c.jpg', 'percent', '2024-12-10', '2024-12-22', 300000, 50000, 1, 1, '2024-12-10 08:39:42', '2024-12-10 08:39:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_types`
--
ALTER TABLE `attribute_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_images`
--
ALTER TABLE `banner_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banner_images_banner_id_foreign` (`banner_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_variant_id_foreign` (`product_variant_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contacts_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorite_products_user_id_foreign` (`user_id`),
  ADD KEY `favorite_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `import_histories`
--
ALTER TABLE `import_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_histories_product_variant_id_foreign` (`product_variant_id`),
  ADD KEY `import_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `manager_settings`
--
ALTER TABLE `manager_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_settings_parent_manager_setting_id_foreign` (`parent_manager_setting_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`SKU`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_product_id_foreign` (`product_id`),
  ADD KEY `product_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_files`
--
ALTER TABLE `product_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_files_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_likes`
--
ALTER TABLE `product_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_likes_user_id_foreign` (`user_id`),
  ADD KEY `product_likes_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`SKU`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variant_attribute_values`
--
ALTER TABLE `product_variant_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variant_attribute_values_product_variant_id_foreign` (`product_variant_id`),
  ADD KEY `product_variant_attribute_values_attribute_value_id_foreign` (`attribute_value_id`);

--
-- Indexes for table `product_view_histories`
--
ALTER TABLE `product_view_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_view_histories_user_id_foreign` (`user_id`),
  ADD KEY `product_view_histories_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_votes`
--
ALTER TABLE `product_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_votes_product_variant_id_foreign` (`product_variant_id`),
  ADD KEY `product_votes_order_detail_id_foreign` (`order_detail_id`),
  ADD KEY `product_votes_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_vote_files`
--
ALTER TABLE `product_vote_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_vouchers`
--
ALTER TABLE `product_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_vouchers_product_id_foreign` (`product_id`),
  ADD KEY `product_vouchers_voucher_id_foreign` (`voucher_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_orders`
--
ALTER TABLE `status_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_orders_status_id_foreign` (`status_id`),
  ADD KEY `status_orders_order_id_foreign` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_bans`
--
ALTER TABLE `user_bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_bans_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_manager_settings`
--
ALTER TABLE `user_manager_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_manager_settings_user_id_foreign` (`user_id`),
  ADD KEY `user_manager_settings_manager_setting_id_foreign` (`manager_setting_id`);

--
-- Indexes for table `user_shipping_addresses`
--
ALTER TABLE `user_shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_shipping_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_vouchers_user_id_foreign` (`user_id`),
  ADD KEY `user_vouchers_voucher_id_foreign` (`voucher_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attribute_types`
--
ALTER TABLE `attribute_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banner_images`
--
ALTER TABLE `banner_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_products`
--
ALTER TABLE `favorite_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `import_histories`
--
ALTER TABLE `import_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `manager_settings`
--
ALTER TABLE `manager_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_files`
--
ALTER TABLE `product_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `product_likes`
--
ALTER TABLE `product_likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `product_variant_attribute_values`
--
ALTER TABLE `product_variant_attribute_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `product_view_histories`
--
ALTER TABLE `product_view_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_votes`
--
ALTER TABLE `product_votes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_vote_files`
--
ALTER TABLE `product_vote_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_vouchers`
--
ALTER TABLE `product_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status_orders`
--
ALTER TABLE `status_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_bans`
--
ALTER TABLE `user_bans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user_manager_settings`
--
ALTER TABLE `user_manager_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_shipping_addresses`
--
ALTER TABLE `user_shipping_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`);

--
-- Constraints for table `banner_images`
--
ALTER TABLE `banner_images`
  ADD CONSTRAINT `banner_images_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD CONSTRAINT `favorite_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `favorite_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `import_histories`
--
ALTER TABLE `import_histories`
  ADD CONSTRAINT `import_histories_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `import_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `manager_settings`
--
ALTER TABLE `manager_settings`
  ADD CONSTRAINT `manager_settings_parent_manager_setting_id_foreign` FOREIGN KEY (`parent_manager_setting_id`) REFERENCES `manager_settings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_categories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_files`
--
ALTER TABLE `product_files`
  ADD CONSTRAINT `product_files_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_likes`
--
ALTER TABLE `product_likes`
  ADD CONSTRAINT `product_likes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_variant_attribute_values`
--
ALTER TABLE `product_variant_attribute_values`
  ADD CONSTRAINT `product_variant_attribute_values_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`),
  ADD CONSTRAINT `product_variant_attribute_values_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Constraints for table `product_view_histories`
--
ALTER TABLE `product_view_histories`
  ADD CONSTRAINT `product_view_histories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_view_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_votes`
--
ALTER TABLE `product_votes`
  ADD CONSTRAINT `product_votes_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`id`),
  ADD CONSTRAINT `product_votes_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `product_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_vouchers`
--
ALTER TABLE `product_vouchers`
  ADD CONSTRAINT `product_vouchers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_vouchers_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`);

--
-- Constraints for table `status_orders`
--
ALTER TABLE `status_orders`
  ADD CONSTRAINT `status_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `status_orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

--
-- Constraints for table `user_bans`
--
ALTER TABLE `user_bans`
  ADD CONSTRAINT `user_bans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_manager_settings`
--
ALTER TABLE `user_manager_settings`
  ADD CONSTRAINT `user_manager_settings_manager_setting_id_foreign` FOREIGN KEY (`manager_setting_id`) REFERENCES `manager_settings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_manager_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_shipping_addresses`
--
ALTER TABLE `user_shipping_addresses`
  ADD CONSTRAINT `user_shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD CONSTRAINT `user_vouchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_vouchers_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
