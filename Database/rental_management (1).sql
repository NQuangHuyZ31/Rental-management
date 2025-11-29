-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 11, 2025 lúc 10:46 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `rental_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activity_logs`
--

CREATE TABLE activity_logs (
  id bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('select','create','update','delete') NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `field_name` text NOT NULL,
  `value` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `table_name`, `field_name`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 11, 'create', 'report_violations', '[\"target_id, title, rental_post_id, target_type, violattion_type, description, created_at\"]', '[{\"target_id\":11,\"title\":\"L\\u1ea5y b\\u00e0i ng\\u01b0\\u1eddi kh\\u00e1c \\u0111\\u1ec3 \\u0111\\u0103ng\",\"rental_post_id\":\"33\",\"target_type\":\"post\",\"violattion_type\":\"fake\",\"description\":\"L\\u1ea5y b\\u00e0i ng\\u01b0\\u1eddi kh\\u00e1c \\u0111\\u0103ng l\\u00e0m b\\u00e0i c\\u1ee7a m\\u00ecnh\",\"created_at\":\"2025-11-07 18:26:54\"}]', 'INSERT INTO report_violations (target_id, title, rental_post_id, target_type, violattion_type, description, created_at) VALUES (:target_id, :title, :rental_post_id, :target_type, :violattion_type, :description, :created_at)', '2025-11-07 11:54:26', '2025-11-07 11:54:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_name` varchar(255) NOT NULL,
  `amenity_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` enum('cái','bộ','chiếc','cặp') NOT NULL DEFAULT 'cái',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `amenities`
--

INSERT INTO `amenities` (`id`, `house_id`, `amenity_name`, `amenity_price`, `quantity`, `unit`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ghế ngồi', 500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 1, 'Điều hòa', 8000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 1, 'Tủ quần áo', 2000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 1, 'Bếp gas', 800000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 1, 'Máy nước nóng', 3000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 1, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 1, 'Tivi', 6000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 1, 'Tủ lạnh', 5000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 2, 'Tủ lạnh', 5000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 2, 'Tivi', 6000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 2, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 2, 'Bếp gas', 800000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 2, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 3, 'Tủ lạnh', 5000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 3, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 3, 'Bếp gas', 800000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 3, 'Điều hòa', 8000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 3, 'Tivi', 6000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 3, 'Máy giặt', 4000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 3, 'Tủ bếp', 1200000.00, 1, 'bộ', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 3, 'Tủ quần áo', 2000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 4, 'Máy nước nóng', 3000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 4, 'Tủ quần áo', 2000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 4, 'Ghế ngồi', 500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 4, 'Điều hòa', 8000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 4, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 4, 'Tivi', 6000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 4, 'Máy giặt', 4000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 4, 'Bếp gas', 800000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 5, 'Giường ngủ', 1500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 5, 'Máy giặt', 4000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 5, 'Tủ quần áo', 2000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 5, 'Tivi', 6000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 5, 'Bàn học', 800000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 6, 'Ghế ngồi', 500000.00, 4, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 6, 'Tủ bếp', 1200000.00, 3, 'bộ', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 6, 'Tủ lạnh', 5000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 6, 'Giường ngủ', 1500000.00, 4, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 6, 'Tivi', 6000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 6, 'Máy giặt', 4000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 6, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 7, 'Tủ quần áo', 2000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 7, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 7, 'Máy nước nóng', 3000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 7, 'Bếp gas', 800000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 7, 'Tủ lạnh', 5000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 7, 'Giường ngủ', 1500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 7, 'Bàn học', 800000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 8, 'Điều hòa', 8000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(50, 8, 'Ghế ngồi', 500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(51, 8, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(52, 8, 'Tủ quần áo', 2000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(53, 8, 'Bàn học', 800000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(54, 9, 'Tủ lạnh', 5000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(55, 9, 'Ghế ngồi', 500000.00, 2, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(56, 9, 'Tủ bếp', 1200000.00, 5, 'bộ', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(57, 9, 'Tủ quần áo', 2000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(58, 9, 'Điều hòa', 8000000.00, 2, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(59, 9, 'Máy giặt', 4000000.00, 1, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(60, 10, 'Điều hòa', 8000000.00, 4, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(61, 10, 'Máy giặt', 4000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(62, 10, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(63, 10, 'Tivi', 6000000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(64, 10, 'Tủ quần áo', 2000000.00, 3, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(65, 10, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banned`
--

CREATE TABLE `banned` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `banner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `revoker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `banned_status` enum('active','expired','revoked') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_supports`
--

CREATE TABLE `customer_supports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `support_type` varchar(255) NOT NULL,
  `description_problem` text NOT NULL,
  `images` text DEFAULT NULL,
  `user_process_id` int(11) DEFAULT NULL,
  `description_process` text DEFAULT NULL,
  `date_process` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `houses`
--

CREATE TABLE `houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `house_name` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_date` tinyint(4) NOT NULL,
  `due_date` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `houses`
--

INSERT INTO `houses` (`id`, `owner_id`, `house_name`, `province`, `ward`, `address`, `payment_date`, `due_date`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Nhà trọ Hạnh Phúc', 'Thành phố Hồ Chí Minh', 'Phường Diên Hồng', '849 Đường Lý Thường Kiệt', 18, 5, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(2, 2, 'Nhà trọ Bình Yên', 'Thành phố Hồ Chí Minh', 'Xã Châu Pha', '747 Đường Lê Lợi', 27, 4, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(3, 3, 'Nhà trọ Gia Đình', 'Thành phố Hồ Chí Minh', 'Xã Bà Điểm', '666 Đường Lê Lợi', 13, 4, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(4, 3, 'Nhà trọ Thân Thiện', 'Thành phố Hồ Chí Minh', 'Phường Phú Thạnh', '316 Đường 3 Tháng 2', 23, 3, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(5, 4, 'Nhà trọ An Lạc', 'Thành phố Hồ Chí Minh', 'Xã Phước Thành', '599 Đường Hai Bà Trưng', 17, 5, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(6, 4, 'Nhà trọ Hòa Thuận', 'Thành phố Hồ Chí Minh', 'Phường Tam Bình', '168 Đường Pasteur', 10, 3, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(7, 5, 'Nhà trọ Tình Thương', 'Thành phố Hồ Chí Minh', 'Phường Tây Thạnh', '694 Đường Lê Lợi', 18, 3, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(8, 5, 'Nhà trọ Đoàn Kết', 'Thành phố Hồ Chí Minh', 'Xã Xuân Thới Sơn', '784 Đường Trần Hưng Đạo', 10, 5, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(9, 6, 'Nhà trọ Hữu Nghị', 'Thành phố Hồ Chí Minh', 'Phường Vũng Tàu', '656 Đường Đồng Khởi', 10, 3, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15'),
(10, 6, 'Nhà trọ Tương Lai', 'Thành phố Hồ Chí Minh', 'Phường Diên Hồng', '37 Đường Cách Mạng Tháng 8', 24, 3, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_name` varchar(255) NOT NULL,
  `invoice_month` varchar(255) NOT NULL,
  `invoice_day` date NOT NULL DEFAULT '2025-11-07',
  `due_date` date DEFAULT NULL,
  `pay_at` date DEFAULT NULL,
  `rental_amount` decimal(10,2) NOT NULL,
  `internet_amount` decimal(10,2) NOT NULL,
  `electric_amount` decimal(10,2) NOT NULL,
  `water_amount` decimal(10,2) NOT NULL,
  `service_amount` decimal(10,2) NOT NULL,
  `parking_amount` decimal(10,2) NOT NULL,
  `garbage_amount` decimal(10,2) NOT NULL,
  `other_amount` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `invoice_status` enum('pending','paid','overdue') NOT NULL DEFAULT 'pending',
  `ref_code` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `invoices`
--

INSERT INTO `invoices` (`id`, `room_id`, `user_id`, `invoice_name`, `invoice_month`, `invoice_day`, `due_date`, `pay_at`, `rental_amount`, `internet_amount`, `electric_amount`, `water_amount`, `service_amount`, `parking_amount`, `garbage_amount`, `other_amount`, `total`, `invoice_status`, `ref_code`, `note`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 9, 46, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-05', '2025-08-18', 3300000.00, 100000.00, 232000.00, 285000.00, 737000.00, 100000.00, 20000.00, 0.00, 4037000.00, 'paid', 'INV-9-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(2, 14, 51, 'Hóa đơn 02-2025', '02-2025', '2025-02-28', '2025-03-04', '2025-02-27', 4200000.00, 100000.00, 200000.00, 280000.00, 700000.00, 100000.00, 20000.00, 0.00, 4900000.00, 'paid', 'INV-14-022025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(3, 14, 51, 'Hóa đơn 03-2025', '03-2025', '2025-03-31', '2025-04-04', '2025-03-27', 4200000.00, 100000.00, 580000.00, 180000.00, 980000.00, 100000.00, 20000.00, 0.00, 5180000.00, 'paid', 'INV-14-032025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(4, 14, 51, 'Hóa đơn 04-2025', '04-2025', '2025-04-30', '2025-05-04', '2025-04-27', 4200000.00, 100000.00, 444000.00, 140000.00, 804000.00, 100000.00, 20000.00, 0.00, 5004000.00, 'paid', 'INV-14-042025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(5, 14, 51, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-04', '2025-05-27', 4200000.00, 100000.00, 532000.00, 400000.00, 1152000.00, 100000.00, 20000.00, 0.00, 5352000.00, 'paid', 'INV-14-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(6, 14, 51, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-27', 4200000.00, 100000.00, 240000.00, 200000.00, 660000.00, 100000.00, 20000.00, 0.00, 4860000.00, 'paid', 'INV-14-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(7, 14, 51, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-27', 4200000.00, 100000.00, 652000.00, 320000.00, 1192000.00, 100000.00, 20000.00, 0.00, 5392000.00, 'paid', 'INV-14-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(8, 14, 51, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-27', 4200000.00, 100000.00, 324000.00, 220000.00, 764000.00, 100000.00, 20000.00, 0.00, 4964000.00, 'paid', 'INV-14-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(9, 17, 53, 'Hóa đơn 02-2025', '02-2025', '2025-02-28', '2025-03-04', '2025-02-27', 4700000.00, 100000.00, 752000.00, 140000.00, 1112000.00, 100000.00, 20000.00, 0.00, 5812000.00, 'paid', 'INV-17-022025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(10, 17, 53, 'Hóa đơn 03-2025', '03-2025', '2025-03-31', '2025-04-04', '2025-03-27', 4700000.00, 100000.00, 540000.00, 280000.00, 1040000.00, 100000.00, 20000.00, 0.00, 5740000.00, 'paid', 'INV-17-032025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(11, 17, 53, 'Hóa đơn 04-2025', '04-2025', '2025-04-30', '2025-05-04', '2025-04-27', 4700000.00, 100000.00, 504000.00, 300000.00, 1024000.00, 100000.00, 20000.00, 0.00, 5724000.00, 'paid', 'INV-17-042025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(12, 17, 53, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-04', '2025-05-27', 4700000.00, 100000.00, 464000.00, 260000.00, 944000.00, 100000.00, 20000.00, 0.00, 5644000.00, 'paid', 'INV-17-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(13, 17, 53, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-27', 4700000.00, 100000.00, 220000.00, 320000.00, 760000.00, 100000.00, 20000.00, 0.00, 5460000.00, 'paid', 'INV-17-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(14, 17, 53, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-27', 4700000.00, 100000.00, 452000.00, 240000.00, 912000.00, 100000.00, 20000.00, 0.00, 5612000.00, 'paid', 'INV-17-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(15, 17, 53, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-27', 4700000.00, 100000.00, 316000.00, 140000.00, 676000.00, 100000.00, 20000.00, 0.00, 5376000.00, 'paid', 'INV-17-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(16, 19, 41, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-04', '2025-05-27', 2400000.00, 100000.00, 592000.00, 360000.00, 1172000.00, 100000.00, 20000.00, 0.00, 3572000.00, 'paid', 'INV-19-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(17, 19, 41, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-27', 2400000.00, 100000.00, 364000.00, 340000.00, 924000.00, 100000.00, 20000.00, 0.00, 3324000.00, 'paid', 'INV-19-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(18, 19, 41, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-27', 2400000.00, 100000.00, 592000.00, 220000.00, 1032000.00, 100000.00, 20000.00, 0.00, 3432000.00, 'paid', 'INV-19-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(19, 19, 41, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-27', 2400000.00, 100000.00, 796000.00, 160000.00, 1176000.00, 100000.00, 20000.00, 0.00, 3576000.00, 'paid', 'INV-19-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(20, 20, 42, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-27', 4400000.00, 100000.00, 800000.00, 340000.00, 1380000.00, 100000.00, 40000.00, 0.00, 5780000.00, 'paid', 'INV-20-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(21, 21, 30, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-13', 2600000.00, 100000.00, 574000.00, 80000.00, 874000.00, 100000.00, 20000.00, 0.00, 3474000.00, 'paid', 'INV-21-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(22, 25, 40, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-13', 2500000.00, 100000.00, 220500.00, 80000.00, 520500.00, 100000.00, 20000.00, 0.00, 3020500.00, 'paid', 'INV-25-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(23, 26, 22, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-04', '2025-05-13', 4300000.00, 100000.00, 441000.00, 80000.00, 741000.00, 100000.00, 20000.00, 0.00, 5041000.00, 'paid', 'INV-26-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(24, 26, 22, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-13', 4300000.00, 100000.00, 325500.00, 80000.00, 625500.00, 100000.00, 20000.00, 0.00, 4925500.00, 'paid', 'INV-26-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(25, 26, 22, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-13', 4300000.00, 100000.00, 539000.00, 80000.00, 839000.00, 100000.00, 20000.00, 0.00, 5139000.00, 'paid', 'INV-26-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(26, 26, 22, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-13', 4300000.00, 100000.00, 472500.00, 80000.00, 772500.00, 100000.00, 20000.00, 0.00, 5072500.00, 'paid', 'INV-26-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(27, 31, 17, 'Hóa đơn 02-2025', '02-2025', '2025-02-28', '2025-03-03', '2025-02-23', 2900000.00, 100000.00, 329000.00, 160000.00, 729000.00, 100000.00, 40000.00, 0.00, 3629000.00, 'paid', 'INV-31-022025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(28, 31, 17, 'Hóa đơn 03-2025', '03-2025', '2025-03-31', '2025-04-03', '2025-03-23', 2900000.00, 100000.00, 665000.00, 160000.00, 1065000.00, 100000.00, 40000.00, 0.00, 3965000.00, 'paid', 'INV-31-032025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(29, 31, 17, 'Hóa đơn 04-2025', '04-2025', '2025-04-30', '2025-05-03', '2025-04-23', 2900000.00, 100000.00, 339500.00, 160000.00, 739500.00, 100000.00, 40000.00, 0.00, 3639500.00, 'paid', 'INV-31-042025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(30, 31, 17, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-03', '2025-05-23', 2900000.00, 100000.00, 406000.00, 160000.00, 806000.00, 100000.00, 40000.00, 0.00, 3706000.00, 'paid', 'INV-31-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(31, 31, 17, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-03', '2025-06-23', 2900000.00, 100000.00, 311500.00, 160000.00, 711500.00, 100000.00, 40000.00, 0.00, 3611500.00, 'paid', 'INV-31-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(32, 31, 17, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-03', '2025-07-23', 2900000.00, 100000.00, 584500.00, 160000.00, 984500.00, 100000.00, 40000.00, 0.00, 3884500.00, 'paid', 'INV-31-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(33, 31, 17, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-03', '2025-08-23', 2900000.00, 100000.00, 430500.00, 160000.00, 830500.00, 100000.00, 40000.00, 0.00, 3730500.00, 'paid', 'INV-31-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(34, 33, 10, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-03', '2025-08-23', 4600000.00, 100000.00, 661500.00, 80000.00, 961500.00, 100000.00, 20000.00, 0.00, 5561500.00, 'paid', 'INV-33-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(35, 39, 19, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-03', '2025-05-23', 3700000.00, 100000.00, 605500.00, 80000.00, 905500.00, 100000.00, 20000.00, 0.00, 4605500.00, 'paid', 'INV-39-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(36, 39, 19, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-03', '2025-06-23', 3700000.00, 100000.00, 451500.00, 80000.00, 751500.00, 100000.00, 20000.00, 0.00, 4451500.00, 'paid', 'INV-39-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(37, 39, 19, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-03', '2025-07-23', 3700000.00, 100000.00, 213500.00, 80000.00, 513500.00, 100000.00, 20000.00, 0.00, 4213500.00, 'paid', 'INV-39-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(38, 39, 19, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-03', '2025-08-23', 3700000.00, 100000.00, 665000.00, 80000.00, 965000.00, 100000.00, 20000.00, 0.00, 4665000.00, 'paid', 'INV-39-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(39, 40, 13, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-03', '2025-08-23', 4500000.00, 100000.00, 525000.00, 80000.00, 825000.00, 100000.00, 20000.00, 0.00, 5325000.00, 'paid', 'INV-40-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-11-07 04:53:02', '2025-11-07 04:53:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_08_29_065320_create_news_table', 1),
(2, '2025_08_29_065521_create_roles_table', 1),
(3, '2025_08_29_065903_create_users_table', 1),
(4, '2025_08_29_065904_create_rental_amenities_table', 1),
(5, '2025_08_29_070139_create_opt_verifies_table', 1),
(6, '2025_08_29_070458_create_rental_categories_table', 1),
(7, '2025_08_29_071006_create_transaction_categories_table', 1),
(8, '2025_08_30_030642_create_rental_posts_table', 1),
(9, '2025_08_30_032831_create_houses_table', 1),
(10, '2025_08_30_033058_create_rooms_table', 1),
(11, '2025_08_30_033637_create_room_tenants_table', 1),
(12, '2025_08_30_033943_create_amenities_table', 1),
(13, '2025_08_30_034222_create_room_amenities_table', 1),
(14, '2025_08_30_034449_create_services_table', 1),
(15, '2025_08_30_034856_create_room_services_table', 1),
(16, '2025_08_30_035507_create_invoices_table', 1),
(17, '2025_08_30_040100_create_service_usages_table', 1),
(18, '2025_08_30_040502_create_transactions_table', 1),
(19, '2025_08_30_041500_create_payment_histories_table', 1),
(20, '2025_08_30_043139_create_activity_logs_table', 1),
(21, '2025_08_30_055618_queue_jobs', 1),
(22, '2025_09_14_085830_create_user_bankings_table', 1),
(23, '2025_10_18_000000_create_banned_table', 1),
(24, '2025_10_20_080415_create_rental_post_interestes_table', 1),
(25, '2025_10_20_080730_create_report_violations_table', 1),
(26, '2025_10_22_042433_create_customer-supports_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `new_title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `otp_verifies`
--

CREATE TABLE `otp_verifies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `otp_code` varchar(255) NOT NULL,
  `expired` int(11) NOT NULL,
  `type` enum('register','forgot_password','change_email') NOT NULL DEFAULT 'register',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT '2025-11-07',
  `description` varchar(255) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `transferType` varchar(255) DEFAULT NULL,
  `referenceCode` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `invoice_id`, `payer_id`, `receiver_id`, `order_id`, `transaction_id`, `amount`, `payment_date`, `description`, `gateway`, `account_number`, `transferType`, `referenceCode`, `type`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(14, 3, 9, 2, '23619512', '901V602252600422', 2000.00, '2025-09-17', 'BankAPINotify Thanh toan hoa don phong thang 082025 HD3', 'TPBank', '00000393285', 'in', '901V602252600422', 'invoice', 'success-paid', 0, '2025-09-17 05:06:25', '2025-09-17 05:06:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `queue_jobs`
--

CREATE TABLE `queue_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_class` varchar(255) NOT NULL,
  `job_data` text NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 2,
  `status` enum('pending','processing','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `attempts` int(11) NOT NULL DEFAULT 0,
  `max_attempts` int(11) NOT NULL DEFAULT 3,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `queue_name` varchar(255) NOT NULL DEFAULT 'default',
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_amenities`
--

CREATE TABLE `rental_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rental_amenity_name` varchar(255) NOT NULL,
  `rental_amenity_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rental_amenities`
--

INSERT INTO `rental_amenities` (`id`, `rental_amenity_name`, `rental_amenity_status`, `owner_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Máy lạnh', 'active', NULL, 0, NULL, NULL),
(2, 'Máy giặt', 'active', NULL, 0, NULL, NULL),
(3, 'Bãi đậu xe', 'active', NULL, 0, NULL, NULL),
(4, 'Thang máy', 'active', NULL, 0, NULL, NULL),
(5, 'Camera an ninh', 'active', 5, 0, NULL, NULL),
(6, 'Giường tủ', 'active', 3, 0, NULL, NULL),
(7, 'Bếp điện', 'active', 8, 0, NULL, NULL),
(8, 'Ban công', 'active', NULL, 0, NULL, NULL),
(9, 'Wifi miễn phí', 'active', NULL, 0, NULL, NULL),
(10, 'Truyền hình cáp', 'active', 3, 0, NULL, NULL),
(11, 'wifi', 'active', 9, 0, NULL, NULL),
(12, 'gara xe', 'active', NULL, 0, NULL, NULL),
(13, 'gác xép', 'active', NULL, 0, NULL, NULL),
(14, 'gác lửng', 'active', 5, 0, NULL, NULL),
(15, 'có bảo vệ', 'active', NULL, 0, NULL, NULL),
(16, 'khóa vân tay', 'active', 1, 0, NULL, NULL),
(17, 'có giếng trời', 'active', 10, 0, NULL, NULL),
(18, 'có sân vườn', 'active', 8, 0, NULL, NULL),
(19, 'có hồ bơi', 'active', 5, 0, NULL, NULL),
(20, 'có tầng thượng', 'active', 10, 0, NULL, NULL),
(21, 'có tầng trệt', 'active', 4, 0, NULL, NULL),
(22, 'có tầng trên cùng', 'active', 8, 0, NULL, NULL),
(23, 'có tầng dưới cùng', 'active', 9, 0, NULL, NULL),
(24, 'có tầng giữa', 'active', 7, 0, NULL, NULL),
(25, 'gần trung tâm', 'active', NULL, 0, NULL, NULL),
(26, 'gần chợ', 'active', 4, 0, NULL, NULL),
(27, 'gần siêu thị', 'active', 8, 0, NULL, NULL),
(28, 'gần trường học', 'active', 4, 0, NULL, NULL),
(29, 'gần bệnh viện', 'active', 6, 0, NULL, NULL),
(30, 'gần bến xe', 'active', NULL, 0, NULL, NULL),
(31, 'gần bến xe bus', 'active', NULL, 0, NULL, NULL),
(32, 'gần bến xe taxi', 'active', 3, 0, NULL, NULL),
(33, 'gần bến xe tải', 'active', NULL, 0, NULL, NULL),
(34, 'gần bến xe khách', 'active', 6, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_categories`
--

CREATE TABLE `rental_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rental_category_name` varchar(255) NOT NULL,
  `rental_category_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rental_categories`
--

INSERT INTO `rental_categories` (`id`, `rental_category_name`, `rental_category_status`, `owner_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Phòng trọ', 'active', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(2, 'Căn hộ mini', 'active', 1, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(3, 'Nhà nguyên căn', 'active', 5, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(4, 'Chung cư', 'active', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(5, 'Văn phòng', 'active', 3, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(6, 'Mặt bằng kinh doanh', 'active', 4, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(7, 'Nhà nghỉ', 'active', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(8, 'Khách sạn', 'active', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(9, 'Homestay', 'active', 9, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(10, 'Ký túc xá', 'active', 9, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_posts`
--

CREATE TABLE `rental_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `rental_category_id` bigint(20) UNSIGNED NOT NULL,
  `rental_post_title` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_discount` decimal(10,2) NOT NULL,
  `rental_deposit` decimal(10,2) NOT NULL,
  `area` varchar(255) NOT NULL,
  `electric_fee` decimal(10,2) NOT NULL,
  `water_fee` decimal(10,2) NOT NULL,
  `max_number_of_people` int(11) NOT NULL,
  `stay_start_date` date NOT NULL,
  `rental_amenities` text NOT NULL,
  `rental_open_time` varchar(255) NOT NULL,
  `rental_close_time` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image_primary` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approval_reason` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rental_posts`
--

INSERT INTO `rental_posts` (`id`, `owner_id`, `rental_category_id`, `rental_post_title`, `contact`, `phone`, `description`, `price`, `price_discount`, `rental_deposit`, `area`, `electric_fee`, `water_fee`, `max_number_of_people`, `stay_start_date`, `rental_amenities`, `rental_open_time`, `rental_close_time`, `province`, `ward`, `address`, `image_primary`, `images`, `status`, `approval_status`, `approval_reason`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 'Cho thuê nhà nguyên căn', 'Cụ. Hứa Đức', '0938885851', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 6855240.61, 6248323.43, 4562622.34, '50', 3824.48, 13071.95, 5, '2025-12-16', '[14,11,26,19]', '21:00', '0:00', 'Cần Thơ', 'Phường 2', '62 Phố Mẫn Thuần Hội', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'approved', 'Consequatur consequatur rerum nostrum aut.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(2, 3, 2, 'Cho thuê mặt bằng kinh doanh', 'Chị. Thái Băng Như', '0942358195', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4685226.32, 1757236.15, 1392230.63, '38', 2530.11, 10370.04, 6, '2025-10-18', '[12,27,15]', '21:00', '10:00', 'Đà Nẵng', 'Phường 2', '6252 Phố Biện Sâm Nghị', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(3, 6, 1, 'Cho thuê mặt bằng kinh doanh', 'Chị. Lô Cúc', '0950384065', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 3354382.20, 2480252.74, 3605376.16, '15', 3701.03, 12302.46, 3, '2025-09-04', '[28,24,22,34,11]', '2:00', '8:00', 'TP Hồ Chí Minh', 'Phường 9', '238 Phố Cổ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'approved', 'Consequuntur odit vero accusamus consequatur rerum ut nihil commodi.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(4, 2, 5, 'Cho thuê mặt bằng kinh doanh', 'Tòng Vương', '0946686771', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8451580.50, 2046933.32, 4573747.87, '20', 2905.05, 18092.84, 5, '2025-11-06', '[26,31,10,19]', '16:00', '21:00', 'Cần Thơ', 'Phường 10', '8 Phố Hà Tân Đan', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(5, 8, 1, 'Cho thuê phòng trọ', 'Chương Danh', '0963658702', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3172129.77, 819722.65, 686176.91, '46', 3764.43, 16650.43, 1, '2025-09-16', '[11,1,3,4]', '19:00', '18:00', 'Đà Nẵng', 'Phường 6', '59 Phố Trác', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'pending', 'Dolores ducimus ut optio ipsam.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(6, 4, 1, 'Cho thuê phòng trọ', 'Trác Bảo', '0935854901', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1843076.14, 870753.78, 2106761.35, '19', 2546.27, 12285.80, 6, '2025-12-07', '[16,31,34,10]', '22:00', '9:00', 'Cần Thơ', 'Phường 11', '9473 Phố Mộc Hiền Thông', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(7, 4, 4, 'Cho thuê nhà nguyên căn', 'Trịnh Diệu', '0921204571', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4973869.41, 2085052.44, 2702672.15, '36', 3619.43, 10861.56, 1, '2025-09-19', '[27,29,15,30]', '2:00', '4:00', 'Hà Nội', 'Phường 7', '7 Phố Phan Phụng Trang', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'rejected', 'Dolore quo provident molestias consectetur minima omnis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(8, 9, 2, 'Cho thuê nhà nguyên căn', 'Lại Thoại', '0924146410', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8939393.52, 2424866.82, 3111087.98, '46', 3436.61, 17919.09, 1, '2025-11-11', '[21,11,8,1]', '2:00', '21:00', 'Cần Thơ', 'Phường 5', '34 Phố Giả Hỷ Vân', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'pending', 'Rem corrupti maiores alias.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(9, 10, 3, 'Cho thuê phòng trọ', 'Chú. Quản Giáp', '0916863526', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6354629.97, 2390496.60, 1884388.95, '21', 3550.81, 10463.30, 6, '2025-12-29', '[6,21]', '1:00', '3:00', 'Hà Nội', 'Phường 3', '10 Phố Ngụy Thơ Nguyên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'pending', 'Perferendis quae sed est voluptatibus quo voluptatibus voluptates et.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(10, 2, 1, 'Cho thuê mặt bằng kinh doanh', 'Nguyễn Phúc', '0961254806', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1844421.82, 1609907.55, 4619101.51, '42', 3948.05, 10333.50, 6, '2025-11-01', '[22,30,17,15]', '23:00', '8:00', 'Hà Nội', 'Phường 11', '887 Phố Vũ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(11, 1, 5, 'Cho thuê phòng trọ', 'Ông. Kim Mạnh', '0910253798', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 9944445.79, 9691094.73, 3380214.53, '26', 3183.94, 10587.69, 4, '2025-11-18', '[18,15,7,17]', '23:00', '9:00', 'Hải Phòng', 'Phường 10', '59 Phố Đào Xuyến Chinh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(12, 10, 5, 'Cho thuê phòng trọ', 'Em. Ngô Diễm Dao', '0991591366', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4564170.27, 2707873.96, 3331226.84, '33', 3225.74, 12867.90, 3, '2025-09-09', '[27,9,32,15,16]', '8:00', '5:00', 'TP Hồ Chí Minh', 'Phường 7', '60 Phố Lưu Hoa Ánh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'approved', 'Maiores quia a molestiae perspiciatis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(13, 9, 3, 'Cho thuê mặt bằng kinh doanh', 'Lưu Bảo Khánh', '0972663215', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 9152838.21, 3179211.12, 936974.99, '44', 3593.93, 11712.55, 4, '2025-11-03', '[26,1]', '22:00', '5:00', 'Hải Phòng', 'Phường 7', '8 Phố Nông Thực Duyên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(14, 10, 5, 'Cho thuê căn hộ', 'Cô. Lê Lưu Quyên', '0988383054', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5092888.92, 4027688.90, 2008549.50, '28', 2910.23, 17622.19, 6, '2025-10-05', '[28,20,32]', '20:00', '0:00', 'Hà Nội', 'Phường 12', '21 Phố Lâm Xuyến Trầm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(15, 7, 1, 'Cho thuê mặt bằng kinh doanh', 'Cô. Khâu Linh Quân', '0997469245', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 9658619.55, 1044793.33, 4338495.03, '21', 3811.26, 17744.42, 6, '2025-09-21', '[5,34,3,13]', '15:00', '14:00', 'Hà Nội', 'Phường 5', '2 Phố Quỳnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(16, 8, 4, 'Cho thuê mặt bằng kinh doanh', 'Cô. Trình Mẫn', '0939435505', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7878409.88, 3409639.26, 4496755.12, '15', 3668.96, 18285.40, 6, '2025-10-16', '[20,12,4]', '6:00', '12:00', 'Cần Thơ', 'Phường 8', '8 Phố Đới', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(17, 3, 5, 'Cho thuê nhà nguyên căn', 'Chú. Vi Hành', '0965936292', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 4122794.25, 3969721.60, 4453146.98, '19', 3677.09, 11023.46, 4, '2025-09-10', '[17,26]', '13:00', '4:00', 'Cần Thơ', 'Phường 12', '16 Phố Tôn Khuyên Thùy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(18, 10, 5, 'Cho thuê nhà nguyên căn', 'Phó Trụ', '0973146493', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 6619731.74, 4090369.78, 818780.95, '42', 2875.12, 16169.45, 1, '2025-12-05', '[33,2,19]', '19:00', '13:00', 'Hà Nội', 'Phường 11', '548 Phố Bạch Trang Vịnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'pending', 'Sed saepe minima qui rerum doloremque et enim.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(19, 8, 5, 'Cho thuê căn hộ', 'Chú. Lương Tài Hà', '0949471716', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 1904334.49, 682190.50, 1273131.29, '15', 3828.88, 10926.02, 5, '2025-10-20', '[27,8,4]', '6:00', '16:00', 'TP Hồ Chí Minh', 'Phường 11', '420 Phố Nhiệm Phương Thọ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'pending', 'Omnis soluta voluptas rerum architecto autem autem mollitia.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(20, 2, 1, 'Cho thuê nhà nguyên căn', 'Chú. Kim Quyết', '0972907106', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 4458794.63, 1598550.08, 2232355.42, '28', 3653.23, 14010.04, 2, '2025-09-11', '[30,31,7,8,24]', '16:00', '4:00', 'Cần Thơ', 'Phường 7', '76 Phố Lê Diệu Lĩnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(21, 3, 3, 'Cho thuê nhà nguyên căn', 'Cô. Tào Tịnh Phụng', '0934046425', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 3828582.83, 3716158.70, 2615370.84, '38', 2504.14, 13712.31, 4, '2025-10-09', '[18,20,2,27,21]', '17:00', '2:00', 'Hà Nội', 'Phường 3', '8 Phố Sơn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(22, 4, 2, 'Cho thuê mặt bằng kinh doanh', 'Chú. Bành Khởi Hiển', '0941671651', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 5631621.87, 1511088.31, 3638338.20, '41', 3518.85, 16786.12, 5, '2025-12-29', '[3,8,32,10,22]', '16:00', '23:00', 'TP Hồ Chí Minh', 'Phường 10', '94 Phố Linh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'pending', 'Earum maiores asperiores reiciendis odit ratione nulla labore quis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(23, 8, 4, 'Cho thuê nhà nguyên căn', 'Hồng Thảo', '0991288518', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 1567428.17, 1307964.81, 3438204.68, '44', 3456.11, 18472.88, 2, '2025-11-26', '[23,3,21,29]', '13:00', '12:00', 'Hà Nội', 'Phường 4', '7 Phố Đái Tiên Thuần', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(24, 9, 3, 'Cho thuê phòng trọ', 'Bác. Hạ Nghị', '0940585280', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9842240.11, 6536789.97, 4018473.71, '35', 2714.79, 14506.57, 1, '2025-11-03', '[32,22,20,25]', '2:00', '11:00', 'Cần Thơ', 'Phường 9', '1 Phố Trưởng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'rejected', 'Eos reprehenderit molestias reiciendis maxime quia est expedita.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(25, 2, 4, 'Cho thuê mặt bằng kinh doanh', 'Chị. Uông Ban Trang', '0925486325', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 6411878.56, 5645478.57, 4871459.97, '27', 3550.15, 12930.94, 1, '2025-12-25', '[11,27]', '9:00', '0:00', 'Cần Thơ', 'Phường 10', '3 Phố Chử Vân Vũ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'rejected', 'Ea sit sunt nulla impedit consequuntur vel qui natus.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(26, 3, 4, 'Cho thuê phòng trọ', 'Anh. Ngân Nghĩa Trạch', '0932099569', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1165793.26, 1004678.38, 1884914.08, '36', 2924.80, 18213.92, 2, '2025-10-20', '[9,24,25,17,31]', '11:00', '19:00', 'Đà Nẵng', 'Phường 1', '5 Phố Phó', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(27, 2, 4, 'Cho thuê nhà nguyên căn', 'Lữ Nguyết Yên', '0982408889', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 4534894.21, 4343787.58, 2040538.00, '19', 3670.07, 16245.01, 3, '2025-10-04', '[34,8,11]', '1:00', '1:00', 'Đà Nẵng', 'Phường 3', '22 Phố Hậu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(28, 2, 3, 'Cho thuê căn hộ', 'Cụ. Mạch Bảo', '0999117103', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8332442.26, 959521.84, 1228457.77, '42', 2905.88, 17562.06, 5, '2025-10-07', '[33,20]', '17:00', '7:00', 'Hải Phòng', 'Phường 5', '154 Phố Đôn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(29, 3, 3, 'Cho thuê căn hộ', 'Đinh Đinh Hiệp', '0949898670', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4520934.83, 3918343.22, 2218927.98, '47', 3624.92, 17560.84, 4, '2025-12-13', '[7,2,32,1]', '9:00', '15:00', 'Cần Thơ', 'Phường 7', '5 Phố Trinh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'rejected', 'Amet rem maxime libero earum animi cumque aut.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(30, 3, 4, 'Cho thuê mặt bằng kinh doanh', 'Trà Dương', '0982736717', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4901846.28, 3236763.55, 4652174.59, '25', 3205.74, 12165.90, 6, '2025-10-10', '[12,25,20]', '21:00', '10:00', 'Đà Nẵng', 'Phường 11', '348 Phố Mã Tiền Di', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(31, 8, 4, 'Cho thuê mặt bằng kinh doanh', 'Quản Thắm', '0977270767', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8078850.19, 3997006.45, 1686611.96, '23', 3496.03, 11878.74, 3, '2025-12-01', '[31,21,11,4,34]', '14:00', '0:00', 'Cần Thơ', 'Phường 9', '124 Phố Thập Trinh Diệu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(32, 1, 1, 'Cho thuê căn hộ', 'Em. Ty Hồng Ánh', '0974825047', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 8759199.52, 1096198.62, 3647150.50, '38', 2717.81, 10002.51, 4, '2025-12-10', '[32,17,4]', '8:00', '22:00', 'Đà Nẵng', 'Phường 1', '9960 Phố Đái Châu Phúc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(33, 9, 2, 'Cho thuê phòng trọ', 'Cụ. Dương Diên Thu', '0970188039', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 7948976.73, 7829990.91, 4850687.50, '49', 3926.10, 15739.51, 3, '2025-10-12', '[27,4,8,9,25]', '3:00', '6:00', 'Đà Nẵng', 'Phường 1', '1 Phố Thạch Luận Thoa', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(34, 6, 5, 'Cho thuê căn hộ', 'Tiếp Ý', '0914698292', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3977321.17, 1000951.58, 915818.52, '50', 2935.58, 16535.09, 3, '2025-09-30', '[28,6,17,4]', '10:00', '2:00', 'TP Hồ Chí Minh', 'Phường 5', '21 Phố Trà', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(35, 9, 5, 'Cho thuê nhà nguyên căn', 'Bá Phượng', '0923001761', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6580561.69, 3324742.22, 3168295.22, '30', 3237.69, 11637.29, 1, '2025-11-23', '[23,18,2]', '16:00', '20:00', 'TP Hồ Chí Minh', 'Phường 3', '12 Phố Uyển', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(36, 9, 3, 'Cho thuê mặt bằng kinh doanh', 'Bác. Thôi Đồng Khải', '0997917359', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4440247.51, 778707.52, 4109105.70, '44', 3761.52, 10954.45, 6, '2025-10-10', '[21,26,12,10]', '23:00', '0:00', 'TP Hồ Chí Minh', 'Phường 9', '35 Phố Nhiệm Thảo Phước', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(37, 5, 5, 'Cho thuê phòng trọ', 'Chú. Bình Lâm Dương', '0951908004', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3653691.22, 1715766.14, 4732325.06, '47', 3206.03, 10415.42, 2, '2025-09-07', '[9,22]', '13:00', '14:00', 'TP Hồ Chí Minh', 'Phường 4', '7 Phố Thập Tuyết Thy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'pending', 'Est aut veniam voluptas quidem aut magnam architecto.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(38, 2, 3, 'Cho thuê mặt bằng kinh doanh', 'Lương Diệp Khê', '0993938882', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9797720.96, 6405486.70, 2037270.56, '49', 2855.21, 13653.16, 6, '2025-09-21', '[29,25,12]', '18:00', '1:00', 'Cần Thơ', 'Phường 6', '2922 Phố Cường', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(39, 9, 3, 'Cho thuê phòng trọ', 'Bác. Thái Cao Bảo', '0959933868', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 5773460.21, 5550115.65, 1176503.47, '20', 3325.88, 17622.87, 6, '2025-11-22', '[28,32,12,25,23]', '13:00', '2:00', 'Cần Thơ', 'Phường 9', '6248 Phố Nguyễn Hạnh Băng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'pending', 'Vel rerum sapiente deleniti expedita ipsa.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(40, 2, 4, 'Cho thuê mặt bằng kinh doanh', 'Bà. Bàng Đồng Thoa', '0975287980', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 9697105.66, 2398311.25, 2318454.32, '48', 3953.01, 10513.34, 4, '2025-12-14', '[12,3,15,20]', '0:00', '4:00', 'Hải Phòng', 'Phường 1', '31 Phố Nhiên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', 'Itaque sit ea sint labore rem sint eius.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(41, 4, 3, 'Cho thuê phòng trọ', 'Bác. Châu Đan', '0990556219', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4799472.24, 1240131.67, 4126959.06, '25', 3749.23, 17990.71, 1, '2025-10-10', '[22,30,10]', '14:00', '13:00', 'Đà Nẵng', 'Phường 8', '8910 Phố Nhã', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(42, 3, 2, 'Cho thuê căn hộ', 'Giao Khánh', '0940208568', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 8068368.86, 4077438.97, 4257215.49, '41', 3280.84, 10092.00, 6, '2025-09-10', '[26,18,16]', '13:00', '22:00', 'TP Hồ Chí Minh', 'Phường 12', '2032 Phố Hồng Quyền Liên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(43, 8, 2, 'Cho thuê mặt bằng kinh doanh', 'Ông. Ninh Minh', '0948984409', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 7852579.42, 5334347.94, 2606428.22, '44', 2561.04, 13592.95, 2, '2025-10-14', '[22,21]', '19:00', '16:00', 'Cần Thơ', 'Phường 3', '1 Phố Thuận', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(44, 6, 5, 'Cho thuê mặt bằng kinh doanh', 'Em. Chiêm Ngọc Khánh', '0964958796', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9935071.05, 7426387.17, 4753338.43, '26', 3141.39, 13736.53, 2, '2025-10-19', '[29,23,22]', '10:00', '4:00', 'Cần Thơ', 'Phường 1', '6 Phố Phương Di Ngôn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(45, 8, 4, 'Cho thuê mặt bằng kinh doanh', 'Chị. Quách Mai', '0939697287', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 8022279.84, 2149920.72, 1918722.11, '20', 3016.47, 15803.63, 4, '2025-12-07', '[27,14,19,22]', '5:00', '3:00', 'TP Hồ Chí Minh', 'Phường 4', '80 Phố Bình Thành Mi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(46, 5, 1, 'Cho thuê căn hộ', 'Em. Lê Thư Hoàn', '0932203946', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2120922.40, 2044473.57, 3803507.55, '38', 2742.63, 17399.73, 1, '2025-11-11', '[6,30,31,13]', '15:00', '19:00', 'TP Hồ Chí Minh', 'Phường 4', '256 Phố Cầm Ngạn Hoàng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(47, 3, 5, 'Cho thuê nhà nguyên căn', 'Huỳnh Tùng', '0955287128', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8606324.44, 7420244.22, 4030037.85, '43', 3081.31, 15337.20, 6, '2025-12-14', '[19,16,32,7,20]', '18:00', '0:00', 'Hà Nội', 'Phường 8', '443 Phố Khuất Mạnh Toại', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(48, 6, 1, 'Cho thuê mặt bằng kinh doanh', 'Yên Nương', '0994286718', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 4136689.32, 3736279.28, 4497690.43, '20', 2809.46, 15697.83, 5, '2025-09-13', '[34,6,25,9,33]', '0:00', '7:00', 'TP Hồ Chí Minh', 'Phường 3', '4052 Phố Nhậm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(49, 10, 4, 'Cho thuê nhà nguyên căn', 'Em. Đặng Hiếu', '0995801032', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 7375663.34, 1277328.84, 2566775.44, '43', 3760.47, 14034.76, 6, '2025-09-14', '[1,7,21]', '11:00', '15:00', 'Hải Phòng', 'Phường 2', '433 Phố Hàng Giáp Thảo', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(50, 7, 3, 'Cho thuê mặt bằng kinh doanh', 'Bác. La Chiêu Lý', '0967585637', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 5761526.92, 1560443.24, 1978761.33, '47', 3934.50, 13489.88, 2, '2025-10-20', '[18,33,13]', '6:00', '3:00', 'Hà Nội', 'Phường 9', '739 Phố Hồng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'inactive', 'rejected', 'Animi praesentium sed sit unde nemo reiciendis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(51, 2, 5, 'Cho thuê căn hộ', 'Trưng Nhung', '0917794923', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4220616.51, 1541660.34, 4810251.99, '49', 3172.58, 14051.08, 5, '2025-10-03', '[31,16,12]', '4:00', '19:00', 'Hà Nội', 'Phường 7', '4260 Phố Tống', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', 'Iusto autem at amet quidem cumque.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(52, 9, 4, 'Cho thuê mặt bằng kinh doanh', 'Ông. Khoa Hiểu Xuân', '0992539602', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 8662313.53, 1897664.63, 2102306.92, '35', 3269.18, 10766.99, 1, '2025-11-12', '[11,28,9,13,2]', '16:00', '18:00', 'Đà Nẵng', 'Phường 9', '9 Phố La', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(53, 9, 5, 'Cho thuê phòng trọ', 'Điền Dã Cương', '0996424079', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 2991933.59, 1651461.02, 3654429.31, '34', 2625.48, 18089.14, 4, '2025-10-20', '[10,18]', '0:00', '22:00', 'Cần Thơ', 'Phường 10', '169 Phố Hàn Ngạn Công', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(54, 3, 5, 'Cho thuê phòng trọ', 'Bà. Sử Uyển Dương', '0947428756', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9805506.60, 8909354.32, 3974645.71, '18', 3609.26, 13846.46, 1, '2025-09-20', '[8,15,17,9,27]', '17:00', '10:00', 'Hải Phòng', 'Phường 4', '343 Phố Đới Phong Vịnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'approved', 'Fuga eum praesentium cumque voluptatem consequatur quia.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(55, 4, 5, 'Cho thuê nhà nguyên căn', 'Kim Thiên Phượng', '0935448180', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 3644730.69, 2207861.79, 4839437.97, '16', 2939.31, 14844.51, 5, '2025-10-12', '[34,19]', '16:00', '22:00', 'Hà Nội', 'Phường 5', '777 Phố Bế Quỳnh Thy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'approved', 'Et est accusantium sed mollitia qui voluptatem.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(56, 5, 5, 'Cho thuê nhà nguyên căn', 'Cụ. Tống Tịnh Thiên', '0946559254', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1944792.49, 1243288.00, 1613578.33, '33', 3100.32, 17773.85, 3, '2025-11-19', '[22,29,24,27]', '17:00', '13:00', 'Đà Nẵng', 'Phường 3', '3 Phố Nhậm Vọng Trúc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'rejected', 'Officia iure qui placeat provident esse ratione exercitationem.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(57, 1, 1, 'Cho thuê phòng trọ', 'Chú. Dư Tài Duy', '0996884071', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1875361.46, 1854692.27, 4005195.16, '27', 3909.78, 14280.60, 5, '2025-10-22', '[22,2]', '12:00', '13:00', 'Hải Phòng', 'Phường 9', '776 Phố Bì Tú Ngọc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'pending', 'Reiciendis occaecati quaerat velit beatae tempore.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(58, 7, 2, 'Cho thuê nhà nguyên căn', 'Bà. Tôn Tịnh Thùy', '0960393130', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2540481.17, 2060403.31, 2448331.45, '43', 3527.99, 19629.24, 4, '2025-09-18', '[5,14,3]', '1:00', '8:00', 'Cần Thơ', 'Phường 6', '7174 Phố Khúc Ánh Phong', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(59, 1, 4, 'Cho thuê mặt bằng kinh doanh', 'Thi Đinh Khôi', '0960246214', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 1732083.61, 1326647.98, 1948413.30, '20', 3773.27, 10547.12, 5, '2025-12-09', '[21,13,8]', '3:00', '14:00', 'Cần Thơ', 'Phường 8', '85 Phố Hoàng Thúc Đình', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(60, 9, 3, 'Cho thuê nhà nguyên căn', 'Khoa Hội', '0970168011', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2139717.40, 1267319.55, 2364569.51, '45', 3499.28, 10777.60, 5, '2025-11-29', '[1,11,23]', '8:00', '16:00', 'TP Hồ Chí Minh', 'Phường 2', '47 Phố Lữ Cương Án', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(61, 3, 3, 'Cho thuê phòng trọ', 'Ông. Trưng Đồng', '0991758024', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 6897377.47, 5046942.20, 4313240.91, '26', 2862.85, 19875.49, 2, '2025-10-15', '[3,19,18,12,28]', '13:00', '10:00', 'Cần Thơ', 'Phường 8', '4 Phố Khưu Hoài Nhân', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', 'Aspernatur ut suscipit quo sint enim.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(62, 5, 5, 'Cho thuê căn hộ', 'Cô. Đồng Triệu Tiên', '0943367099', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 5006618.46, 869308.79, 1869994.14, '46', 3717.17, 10918.91, 5, '2025-11-07', '[3,24,27,21]', '1:00', '23:00', 'Hà Nội', 'Phường 5', '814 Phố Thôi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(63, 5, 4, 'Cho thuê mặt bằng kinh doanh', 'Lỳ Kiệt Kỳ', '0910339243', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 5122079.76, 1707206.77, 4984473.82, '38', 3001.39, 16167.27, 1, '2025-12-01', '[20,31,9,30]', '2:00', '1:00', 'Cần Thơ', 'Phường 1', '2728 Phố Quang', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'pending', 'Odit quia non rerum sunt eum temporibus deserunt.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(64, 6, 2, 'Cho thuê căn hộ', 'Em. Lâm Tài', '0965324508', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4361735.87, 1305862.33, 3521543.44, '32', 3737.63, 10833.24, 1, '2025-09-09', '[20,18,29,2,26]', '7:00', '9:00', 'Cần Thơ', 'Phường 2', '19 Phố Ngô Nguyệt Diệu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', 'Rem nulla et sed consectetur consequuntur.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(65, 5, 2, 'Cho thuê căn hộ', 'Dã Khởi Chiểu', '0915089834', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 2068287.10, 1312556.86, 4305158.11, '19', 3409.50, 12678.62, 6, '2025-10-04', '[33,30,26]', '11:00', '7:00', 'Hải Phòng', 'Phường 9', '1 Phố Dương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(66, 2, 2, 'Cho thuê mặt bằng kinh doanh', 'Ca Hiểu Hòa', '0920920075', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1453984.65, 818774.68, 1523776.73, '44', 3547.21, 17520.89, 3, '2025-11-24', '[20,13,26]', '22:00', '13:00', 'TP Hồ Chí Minh', 'Phường 1', '61 Phố Mộc Dương Cần', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(67, 5, 1, 'Cho thuê nhà nguyên căn', 'Bà. Xa Diên Kiều', '0998411715', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 5263769.45, 955612.59, 2151732.52, '33', 2979.48, 14409.49, 2, '2025-10-04', '[17,33,19,12,23]', '10:00', '21:00', 'Cần Thơ', 'Phường 5', '60 Phố Cự Oanh Khánh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(68, 8, 2, 'Cho thuê mặt bằng kinh doanh', 'Ông. Phương Thắng', '0913884954', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8873043.64, 5772017.69, 4995335.32, '19', 3940.61, 10979.42, 2, '2025-12-06', '[7,32,12,19]', '21:00', '3:00', 'Hà Nội', 'Phường 5', '931 Phố Bùi Đạt Quỳnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(69, 8, 2, 'Cho thuê nhà nguyên căn', 'Biện Loan', '0982006433', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9608049.20, 9135076.94, 2169395.98, '45', 3415.86, 13187.44, 4, '2025-10-20', '[2,27]', '18:00', '9:00', 'Đà Nẵng', 'Phường 4', '1 Phố Nương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'approved', 'Tenetur voluptatem odio velit facere ab dolorem.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(70, 9, 5, 'Cho thuê nhà nguyên căn', 'Cự Dung', '0950781564', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 1660210.16, 1390062.98, 2939982.61, '43', 2523.80, 13186.50, 4, '2025-12-23', '[14,30,26,12,2]', '7:00', '1:00', 'TP Hồ Chí Minh', 'Phường 2', '74 Phố Hường', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(71, 1, 2, 'Cho thuê mặt bằng kinh doanh', 'Sơn Cát Hạnh', '0980437171', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 2860433.26, 685688.74, 1667626.64, '38', 3321.59, 10472.83, 4, '2025-09-28', '[4,1,20,10,31]', '7:00', '0:00', 'TP Hồ Chí Minh', 'Phường 1', '10 Phố Xa Trúc Nhiên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(72, 3, 5, 'Cho thuê phòng trọ', 'Hình Hoàn Thông', '0941462565', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 3028955.07, 2133322.20, 2665648.72, '35', 3731.63, 19742.72, 1, '2025-12-24', '[12,31]', '21:00', '19:00', 'Cần Thơ', 'Phường 6', '6211 Phố Liễu Lạc Kim', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15');
INSERT INTO `rental_posts` (`id`, `owner_id`, `rental_category_id`, `rental_post_title`, `contact`, `phone`, `description`, `price`, `price_discount`, `rental_deposit`, `area`, `electric_fee`, `water_fee`, `max_number_of_people`, `stay_start_date`, `rental_amenities`, `rental_open_time`, `rental_close_time`, `province`, `ward`, `address`, `image_primary`, `images`, `status`, `approval_status`, `approval_reason`, `deleted`, `created_at`, `updated_at`) VALUES
(73, 3, 5, 'Cho thuê căn hộ', 'Ngân Lam', '0948852715', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 3209124.83, 1724037.90, 980905.71, '27', 2946.71, 13363.29, 4, '2025-12-27', '[30,27,9,2,26]', '13:00', '18:00', 'Cần Thơ', 'Phường 7', '36 Phố Phi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(74, 1, 5, 'Cho thuê nhà nguyên căn', 'Ông. Mã Lam', '0984596814', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3387618.56, 1366141.86, 3998712.40, '50', 3028.82, 10413.45, 5, '2025-10-27', '[18,30]', '9:00', '5:00', 'Đà Nẵng', 'Phường 6', '1959 Phố Ngôn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', 'Quasi dolores magnam illo voluptatem aut odit sed.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(75, 7, 1, 'Cho thuê phòng trọ', 'Chị. Lê Dân', '0984823761', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7914773.13, 2170721.35, 1591624.77, '20', 3960.35, 15069.73, 2, '2025-09-16', '[7,34,18,3,32]', '11:00', '14:00', 'Đà Nẵng', 'Phường 8', '6 Phố Cam Định Thạc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'inactive', 'pending', 'Non et ad totam omnis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(76, 9, 1, 'Cho thuê căn hộ', 'Cụ. Hà Vũ Hoa', '0921045599', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 2105763.17, 850850.91, 2112000.71, '49', 2714.40, 12047.46, 1, '2025-10-26', '[13,23]', '15:00', '2:00', 'Cần Thơ', 'Phường 6', '89 Phố Hằng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(77, 6, 5, 'Cho thuê mặt bằng kinh doanh', 'Chú. Phan Bằng', '0943722161', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3383144.77, 1512792.61, 1941515.45, '34', 2696.27, 18121.46, 3, '2025-12-29', '[22,16,26,24,21]', '19:00', '7:00', 'TP Hồ Chí Minh', 'Phường 6', '901 Phố Mẫn Anh Quỳnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(78, 6, 2, 'Cho thuê phòng trọ', 'Anh. Hình Phương Trang', '0968957549', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2111111.81, 1454350.39, 1887004.59, '15', 3675.22, 17906.46, 4, '2025-12-04', '[13,11]', '2:00', '21:00', 'Hải Phòng', 'Phường 2', '9046 Phố Diệu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(79, 8, 1, 'Cho thuê phòng trọ', 'Tào Bích Khanh', '0943614758', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 6371050.08, 5808508.58, 3900610.52, '26', 3126.45, 14107.56, 4, '2025-09-25', '[12,23,8,30]', '5:00', '6:00', 'TP Hồ Chí Minh', 'Phường 9', '226 Phố Kim', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'approved', 'Molestiae similique ut voluptate voluptatum esse rerum itaque.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(80, 3, 3, 'Cho thuê nhà nguyên căn', 'Bác. Viên Hòa', '0979972728', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3127861.85, 2692423.98, 4086811.04, '26', 3068.25, 19617.08, 1, '2025-12-06', '[6,7,22]', '12:00', '8:00', 'Hải Phòng', 'Phường 6', '8034 Phố Nương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'rejected', 'Autem rerum est vel magnam.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(81, 4, 3, 'Cho thuê mặt bằng kinh doanh', 'Cụ. Thi Nhung', '0914858164', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 8593650.87, 585030.35, 542311.34, '44', 3000.92, 13540.55, 4, '2025-11-03', '[25,12,32]', '4:00', '17:00', 'Đà Nẵng', 'Phường 7', '683 Phố Âu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(82, 7, 5, 'Cho thuê nhà nguyên căn', 'Cô. Quách Nhi', '0943283118', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5461700.82, 4448151.89, 1270121.29, '45', 3429.46, 15413.57, 3, '2025-12-21', '[33,23,29,19,31]', '21:00', '11:00', 'Đà Nẵng', 'Phường 10', '886 Phố Thi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(83, 1, 1, 'Cho thuê nhà nguyên căn', 'Bà. Phạm Oanh', '0940471430', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4619503.91, 2231874.56, 1503110.16, '17', 2932.95, 14856.21, 1, '2025-12-21', '[26,32,12,34]', '2:00', '14:00', 'Hà Nội', 'Phường 8', '17 Phố Đào Nam Huệ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(84, 2, 1, 'Cho thuê phòng trọ', 'Khâu Cơ', '0987905096', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3698239.69, 3109223.06, 513693.34, '16', 2884.89, 19466.48, 3, '2025-10-14', '[34,5,27,19,18]', '22:00', '20:00', 'Đà Nẵng', 'Phường 10', '15 Phố Thùy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(85, 10, 2, 'Cho thuê căn hộ', 'Bác. Lò Triệu Dân', '0961527048', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 6368003.99, 1965897.53, 1724697.48, '28', 2976.66, 16391.60, 4, '2025-11-04', '[26,1,11,6,28]', '0:00', '5:00', 'Hà Nội', 'Phường 5', '60 Phố Ty Linh Hiếu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(86, 7, 5, 'Cho thuê phòng trọ', 'Chị. Ong Khanh', '0981572316', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 8695726.15, 6907968.23, 1190407.78, '48', 3379.25, 11356.54, 4, '2025-09-24', '[11,19,27,3]', '19:00', '2:00', 'Cần Thơ', 'Phường 1', '2124 Phố Đàm Lợi Vu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', 'Sit dolores dolorem voluptatem cumque numquam.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(87, 6, 5, 'Cho thuê mặt bằng kinh doanh', 'Anh. Bá Khương Nhân', '0936186741', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 8795324.54, 4763696.49, 659182.09, '17', 2979.76, 12003.02, 4, '2025-09-03', '[26,9]', '20:00', '15:00', 'Đà Nẵng', 'Phường 12', '46 Phố Dương Mạnh Vượng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(88, 4, 2, 'Cho thuê nhà nguyên căn', 'Thi Tiểu Khánh', '0958296033', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 4483730.41, 1605536.23, 2878840.70, '24', 3136.37, 18937.39, 6, '2025-10-30', '[28,2,18,24,29]', '9:00', '9:00', 'Hà Nội', 'Phường 2', '61 Phố Tiêu Phương Mỹ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(89, 5, 3, 'Cho thuê phòng trọ', 'Anh. Cổ Khuyến Hưng', '0910066231', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3340337.70, 1297210.26, 3933666.24, '36', 3414.49, 18622.35, 5, '2025-12-16', '[4,28]', '13:00', '10:00', 'TP Hồ Chí Minh', 'Phường 2', '2097 Phố Nương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(90, 3, 5, 'Cho thuê mặt bằng kinh doanh', 'Đỗ Chiến Lý', '0995318186', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 4250443.90, 1369119.89, 1967185.71, '42', 3899.89, 17337.76, 2, '2025-12-27', '[27,14,28]', '22:00', '1:00', 'Hải Phòng', 'Phường 5', '73 Phố Nhiệm Từ Hà', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(91, 3, 5, 'Cho thuê phòng trọ', 'Trang Nguyên', '0941853066', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 7528719.01, 4200768.29, 4206777.33, '35', 2595.70, 12838.68, 1, '2025-11-16', '[28,15,11]', '22:00', '15:00', 'Hà Nội', 'Phường 10', '61 Phố Diêm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(92, 4, 2, 'Cho thuê mặt bằng kinh doanh', 'Anh. Khúc Di', '0951592763', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1747896.43, 1032754.28, 2432111.22, '23', 3145.44, 19382.82, 4, '2025-09-08', '[24,27,1,5,33]', '18:00', '19:00', 'Hà Nội', 'Phường 2', '1 Phố Ngôn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(93, 5, 2, 'Cho thuê căn hộ', 'Chú. Bửu Bá Duệ', '0969598656', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 9617410.37, 4519135.87, 1585356.02, '35', 3490.27, 19624.57, 3, '2025-11-21', '[18,7,9,1,3]', '17:00', '22:00', 'Cần Thơ', 'Phường 2', '95 Phố Lạc Quân Đình', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'approved', 'Laborum molestiae quo sit et aut libero laboriosam.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(94, 1, 5, 'Cho thuê căn hộ', 'Trưng Nguyên Yến', '0974342883', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1532714.69, 1331082.55, 1985856.77, '21', 3001.33, 19749.68, 5, '2025-10-18', '[32,28,7,11]', '5:00', '13:00', 'TP Hồ Chí Minh', 'Phường 10', '9 Phố Nhiệm Ngôn Thiện', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'pending', 'Perferendis ipsum expedita voluptatibus facilis.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(95, 6, 5, 'Cho thuê nhà nguyên căn', 'Bác. Bùi Diệp', '0995936121', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 9554459.87, 6286969.65, 4309520.37, '26', 3641.86, 17216.43, 5, '2025-11-28', '[30,14,16,29]', '1:00', '16:00', 'Hà Nội', 'Phường 10', '495 Phố Kiều Khê Nghị', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'pending', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(96, 6, 2, 'Cho thuê căn hộ', 'Em. Dương Sử', '0915068263', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 1450831.60, 1344772.83, 1874070.69, '30', 3100.01, 19820.32, 5, '2025-11-06', '[20,2,19,3,7]', '13:00', '12:00', 'Hải Phòng', 'Phường 9', '8489 Phố Ca', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(97, 8, 1, 'Cho thuê phòng trọ', 'Cụ. Cát Việt', '0995602687', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8580151.27, 7776083.39, 3243376.18, '17', 2853.21, 14201.25, 6, '2025-12-29', '[33,16,21,7]', '14:00', '16:00', 'Hải Phòng', 'Phường 2', '458 Phố Tài', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'rejected', 'Et delectus quasi repellendus cum temporibus.', 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(98, 8, 2, 'Cho thuê mặt bằng kinh doanh', 'Từ Lệ', '0945816049', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2703224.57, 1797258.75, 4948691.97, '17', 2778.90, 16942.79, 4, '2025-12-20', '[2,20,28,14,16]', '14:00', '7:00', 'TP Hồ Chí Minh', 'Phường 6', '749 Phố Đái Diễm Huynh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(99, 5, 4, 'Cho thuê căn hộ', 'Bác. Khổng Xuyến Dương', '0920279100', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 5710576.54, 4742566.00, 1231252.61, '29', 3961.62, 12344.45, 5, '2025-11-27', '[15,17,29]', '13:00', '22:00', 'Hà Nội', 'Phường 11', '81 Phố Giả', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15'),
(100, 8, 2, 'Cho thuê nhà nguyên căn', 'Quách Bách Lam', '0930380219', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1553652.37, 507390.11, 1119418.55, '26', 2917.07, 12166.58, 6, '2025-09-06', '[33,29,5,9,28]', '15:00', '8:00', 'TP Hồ Chí Minh', 'Phường 5', '2 Phố Hán', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'rejected', NULL, 0, '2025-11-07 04:53:15', '2025-11-07 04:53:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_post_interestes`
--

CREATE TABLE `rental_post_interestes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `rental_post_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `report_violations`
--

CREATE TABLE `report_violations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_owner_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `rental_post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `target_type` enum('post','user','comment','review','room') NOT NULL,
  `violattion_type` enum('spam','fake','scam','inappropriate','violence','other') NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','reviewed','resolved','rejected') NOT NULL DEFAULT 'pending',
  `admin_id` int(11) DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `resolved_at` date NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `report_violations`
--

INSERT INTO `report_violations` (`id`, `target_id`, `target_owner_id`, `title`, `rental_post_id`, `user_id`, `room_id`, `target_type`, `violattion_type`, `description`, `status`, `admin_id`, `action_taken`, `note`, `images`, `resolved_at`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 11, NULL, 'Lấy bài người khác để đăng', 33, NULL, NULL, 'post', 'fake', 'Lấy bài người khác đăng làm bài của mình', 'resolved', NULL, NULL, NULL, NULL, '0000-00-00', 0, '2025-11-07 11:26:54', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `vn_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_status`, `vn_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'active', 'Quản trị viên', '2025-11-07 04:52:45', '2025-11-07 04:52:45'),
(2, 'landlord', 'active', 'Chủ nhà', '2025-11-07 04:52:45', '2025-11-07 04:52:45'),
(3, 'customer', 'active', 'Người tìm nhà', '2025-11-07 04:52:45', '2025-11-07 04:52:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_id` bigint(20) UNSIGNED NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `room_status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `max_people` int(11) DEFAULT NULL,
  `stay_in` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `house_id`, `room_name`, `deposit`, `room_price`, `area`, `floor`, `room_status`, `max_people`, `stay_in`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Phòng 01', 2600000.00, 3100000.00, '24', '1', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 1, 'Phòng 02', 3400000.00, 3900000.00, '38', '1', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 1, 'Phòng 03', 3400000.00, 3900000.00, '29', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 1, 'Phòng 04', 3800000.00, 3800000.00, '33', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 1, 'Phòng 05', 2000000.00, 3000000.00, '23', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 1, 'Phòng 06', 3200000.00, 4200000.00, '32', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 1, 'Phòng 07', 4000000.00, 5000000.00, '40', '2', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 1, 'Phòng 08', 2800000.00, 3800000.00, '28', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 1, 'Phòng 09', 3300000.00, 3300000.00, '29', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 1, 'Phòng 10', 2600000.00, 3100000.00, '22', '2', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 2, 'Phòng 01', 4600000.00, 4600000.00, '34', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 2, 'Phòng 02', 2200000.00, 2200000.00, '22', '1', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 2, 'Phòng 03', 2300000.00, 2800000.00, '25', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 2, 'Phòng 04', 4200000.00, 4200000.00, '37', '1', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 2, 'Phòng 05', 2700000.00, 3200000.00, '22', '1', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 2, 'Phòng 06', 4600000.00, 4600000.00, '33', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 2, 'Phòng 07', 4700000.00, 4700000.00, '36', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 2, 'Phòng 08', 3800000.00, 4300000.00, '32', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 2, 'Phòng 09', 1900000.00, 2400000.00, '22', '2', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 2, 'Phòng 10', 3400000.00, 4400000.00, '36', '2', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 3, 'Phòng 01', 2100000.00, 2600000.00, '20', '1', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 3, 'Phòng 02', 3100000.00, 4100000.00, '40', '1', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 3, 'Phòng 03', 5500000.00, 5500000.00, '40', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 3, 'Phòng 04', 4700000.00, 5200000.00, '37', '1', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 3, 'Phòng 05', 1500000.00, 2500000.00, '21', '1', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 3, 'Phòng 06', 3300000.00, 4300000.00, '29', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 3, 'Phòng 07', 2500000.00, 3000000.00, '21', '2', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 3, 'Phòng 08', 2800000.00, 2800000.00, '27', '2', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 3, 'Phòng 09', 3200000.00, 3700000.00, '33', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 3, 'Phòng 10', 3300000.00, 3300000.00, '32', '2', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 4, 'Phòng 01', 2900000.00, 2900000.00, '27', '1', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 4, 'Phòng 02', 3600000.00, 3600000.00, '26', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 4, 'Phòng 03', 4100000.00, 4600000.00, '32', '1', 'occupied', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 4, 'Phòng 04', 3000000.00, 4000000.00, '33', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 4, 'Phòng 05', 4400000.00, 4900000.00, '39', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 4, 'Phòng 06', 1800000.00, 2800000.00, '25', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 4, 'Phòng 07', 2800000.00, 2800000.00, '26', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 4, 'Phòng 08', 2600000.00, 3100000.00, '24', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 4, 'Phòng 09', 2700000.00, 3700000.00, '27', '2', 'occupied', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 4, 'Phòng 10', 4000000.00, 4500000.00, '30', '2', 'occupied', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 5, 'Phòng 01', 3400000.00, 4400000.00, '36', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 5, 'Phòng 02', 2900000.00, 3400000.00, '26', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 5, 'Phòng 03', 3100000.00, 3100000.00, '31', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 5, 'Phòng 04', 3300000.00, 3300000.00, '27', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 5, 'Phòng 05', 4600000.00, 4600000.00, '39', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 5, 'Phòng 06', 4000000.00, 4000000.00, '28', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 5, 'Phòng 07', 2900000.00, 3400000.00, '27', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 5, 'Phòng 08', 3600000.00, 3600000.00, '35', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 5, 'Phòng 09', 3900000.00, 4900000.00, '33', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(50, 5, 'Phòng 10', 3800000.00, 4300000.00, '36', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(51, 6, 'Phòng 01', 2900000.00, 3900000.00, '27', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(52, 6, 'Phòng 02', 2700000.00, 3700000.00, '25', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(53, 6, 'Phòng 03', 2600000.00, 3100000.00, '23', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(54, 6, 'Phòng 04', 3700000.00, 3700000.00, '25', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(55, 6, 'Phòng 05', 2500000.00, 2500000.00, '23', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(56, 6, 'Phòng 06', 4500000.00, 5000000.00, '35', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(57, 6, 'Phòng 07', 4500000.00, 4500000.00, '38', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(58, 6, 'Phòng 08', 3300000.00, 3300000.00, '24', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(59, 6, 'Phòng 09', 3300000.00, 4300000.00, '40', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(60, 6, 'Phòng 10', 2000000.00, 3000000.00, '30', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(61, 7, 'Phòng 01', 3700000.00, 4700000.00, '38', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(62, 7, 'Phòng 02', 4100000.00, 5100000.00, '36', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(63, 7, 'Phòng 03', 4100000.00, 4600000.00, '40', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(64, 7, 'Phòng 04', 3500000.00, 3500000.00, '24', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(65, 7, 'Phòng 05', 4000000.00, 5000000.00, '37', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(66, 7, 'Phòng 06', 5700000.00, 5700000.00, '39', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(67, 7, 'Phòng 07', 4800000.00, 5300000.00, '37', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(68, 7, 'Phòng 08', 3800000.00, 4300000.00, '33', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(69, 7, 'Phòng 09', 3400000.00, 3900000.00, '33', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(70, 7, 'Phòng 10', 3900000.00, 4900000.00, '35', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(71, 8, 'Phòng 01', 4600000.00, 4600000.00, '33', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(72, 8, 'Phòng 02', 5800000.00, 5800000.00, '40', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(73, 8, 'Phòng 03', 1500000.00, 2500000.00, '20', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(74, 8, 'Phòng 04', 4700000.00, 5200000.00, '36', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(75, 8, 'Phòng 05', 3200000.00, 3700000.00, '31', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(76, 8, 'Phòng 06', 5100000.00, 5600000.00, '38', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(77, 8, 'Phòng 07', 4100000.00, 4100000.00, '28', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(78, 8, 'Phòng 08', 3400000.00, 4400000.00, '40', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(79, 8, 'Phòng 09', 4600000.00, 5100000.00, '40', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(80, 8, 'Phòng 10', 2900000.00, 3900000.00, '28', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(81, 9, 'Phòng 01', 2400000.00, 2900000.00, '27', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(82, 9, 'Phòng 02', 3400000.00, 3900000.00, '29', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(83, 9, 'Phòng 03', 4200000.00, 4200000.00, '28', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(84, 9, 'Phòng 04', 2400000.00, 2900000.00, '26', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(85, 9, 'Phòng 05', 4300000.00, 4300000.00, '37', '1', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(86, 9, 'Phòng 06', 2800000.00, 3300000.00, '29', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(87, 9, 'Phòng 07', 2200000.00, 3200000.00, '27', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(88, 9, 'Phòng 08', 2200000.00, 2200000.00, '22', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(89, 9, 'Phòng 09', 2900000.00, 2900000.00, '20', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(90, 9, 'Phòng 10', 3000000.00, 4000000.00, '39', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(91, 10, 'Phòng 01', 2300000.00, 2800000.00, '20', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(92, 10, 'Phòng 02', 3900000.00, 3900000.00, '32', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(93, 10, 'Phòng 03', 3700000.00, 3700000.00, '33', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(94, 10, 'Phòng 04', 2200000.00, 3200000.00, '26', '1', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(95, 10, 'Phòng 05', 2100000.00, 3100000.00, '27', '1', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(96, 10, 'Phòng 06', 3300000.00, 4300000.00, '34', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(97, 10, 'Phòng 07', 3600000.00, 4100000.00, '36', '2', 'available', 4, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(98, 10, 'Phòng 08', 3900000.00, 3900000.00, '27', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(99, 10, 'Phòng 09', 2300000.00, 2800000.00, '20', '2', 'available', 2, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(100, 10, 'Phòng 10', 4100000.00, 4100000.00, '35', '2', 'available', 3, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_amenities`
--

CREATE TABLE `room_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_amenities`
--

INSERT INTO `room_amenities` (`id`, `room_id`, `amenity_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 1, 3, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 1, 1, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 1, 4, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 1, 5, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 1, 7, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 1, 2, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 1, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 2, 3, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 2, 1, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 2, 2, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 2, 5, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 2, 7, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 3, 3, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 3, 4, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 3, 5, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 3, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 4, 3, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 4, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 4, 2, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 4, 4, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 5, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 6, 4, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 6, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 6, 5, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 11, 13, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 11, 11, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 11, 12, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 11, 10, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 11, 9, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 12, 13, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 12, 10, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 12, 12, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 12, 9, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 13, 13, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 13, 12, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 13, 9, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 14, 13, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 14, 12, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 15, 13, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 16, 9, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 21, 21, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 21, 15, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 21, 14, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 21, 18, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 21, 20, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 21, 16, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 21, 19, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 22, 21, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(50, 22, 15, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(51, 22, 18, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(52, 22, 17, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(53, 22, 14, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(54, 23, 15, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(55, 23, 14, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(56, 23, 18, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(57, 23, 16, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(58, 23, 17, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(59, 24, 15, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(60, 24, 16, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(61, 24, 19, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(62, 24, 14, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(63, 25, 15, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(64, 25, 16, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(65, 25, 14, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(66, 26, 16, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(67, 26, 18, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(68, 26, 19, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(69, 28, 18, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(70, 31, 26, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(71, 31, 23, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(72, 31, 24, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(73, 31, 25, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(74, 31, 22, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(75, 31, 29, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(76, 31, 27, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(77, 31, 28, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(78, 32, 24, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(79, 32, 28, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(80, 32, 27, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(81, 32, 29, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(82, 32, 25, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(83, 33, 27, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(84, 34, 25, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(85, 35, 27, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(86, 36, 25, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(87, 41, 30, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(88, 41, 32, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(89, 41, 34, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(90, 41, 33, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(91, 42, 30, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(92, 42, 32, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(93, 42, 34, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(94, 42, 33, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(95, 43, 34, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(96, 43, 31, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(97, 43, 33, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(98, 44, 31, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(99, 49, 31, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(100, 50, 31, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(101, 51, 38, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(102, 51, 41, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(103, 51, 35, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(104, 51, 37, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(105, 51, 36, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(106, 51, 40, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(107, 52, 38, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(108, 52, 41, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(109, 52, 35, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(110, 52, 36, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(111, 52, 37, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(112, 53, 38, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(113, 53, 41, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(114, 53, 35, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(115, 53, 40, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(116, 53, 39, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(117, 54, 38, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(118, 54, 41, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(119, 54, 35, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(120, 54, 40, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(121, 54, 39, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(122, 55, 41, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(123, 55, 36, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(124, 61, 47, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(125, 61, 42, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(126, 61, 48, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(127, 61, 46, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(128, 61, 45, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(129, 61, 44, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(130, 62, 47, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(131, 62, 42, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(132, 62, 48, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(133, 62, 45, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(134, 63, 42, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(135, 63, 48, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(136, 63, 43, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(137, 63, 44, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(138, 65, 44, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(139, 71, 51, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(140, 71, 52, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(141, 71, 53, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(142, 71, 50, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(143, 71, 49, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(144, 72, 52, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(145, 72, 50, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(146, 72, 49, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(147, 81, 57, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(148, 81, 55, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(149, 81, 54, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(150, 81, 56, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(151, 82, 57, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(152, 82, 55, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(153, 82, 56, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(154, 82, 59, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(155, 83, 57, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(156, 84, 57, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(157, 85, 57, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(158, 85, 56, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(159, 86, 56, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(160, 86, 58, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(161, 87, 58, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(162, 87, 56, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(163, 91, 62, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(164, 91, 64, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(165, 91, 65, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(166, 91, 61, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(167, 91, 63, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(168, 92, 64, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(169, 92, 65, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(170, 92, 63, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(171, 92, 61, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(172, 93, 64, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(173, 93, 65, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(174, 93, 61, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(175, 93, 63, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(176, 93, 60, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(177, 94, 65, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(178, 94, 60, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(179, 95, 65, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(180, 95, 60, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(181, 95, 63, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(182, 96, 63, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(183, 96, 60, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_services`
--

CREATE TABLE `room_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_services`
--

INSERT INTO `room_services` (`id`, `room_id`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 1, 2, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 1, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 2, 4, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 2, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 3, 4, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 3, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 3, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 4, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 4, 4, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 4, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 4, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 5, 2, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 5, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 6, 2, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 6, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 7, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 7, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 7, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 8, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 8, 2, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 9, 2, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 9, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 9, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 9, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 10, 5, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 10, 1, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 10, 3, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 10, 4, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 11, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 11, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 12, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 12, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 12, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 13, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 13, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 14, 10, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 14, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 14, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 15, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 15, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 16, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 16, 10, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 16, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 16, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 17, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 17, 10, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 17, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 18, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(50, 18, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(51, 18, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(52, 19, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(53, 19, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(54, 19, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(55, 20, 9, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(56, 20, 6, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(57, 20, 8, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(58, 20, 7, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(59, 21, 12, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(60, 21, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(61, 21, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(62, 22, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(63, 22, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(64, 23, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(65, 23, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(66, 24, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(67, 24, 15, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(68, 24, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(69, 24, 12, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(70, 25, 15, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(71, 25, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(72, 26, 15, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(73, 26, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(74, 26, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(75, 26, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(76, 27, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(77, 27, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(78, 27, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(79, 28, 12, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(80, 28, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(81, 28, 15, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(82, 28, 14, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(83, 29, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(84, 29, 12, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(85, 30, 12, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(86, 30, 13, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(87, 30, 11, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(88, 31, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(89, 31, 17, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(90, 31, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(91, 31, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(92, 32, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(93, 32, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(94, 32, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(95, 32, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(96, 33, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(97, 33, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(98, 33, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(99, 34, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(100, 34, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(101, 35, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(102, 35, 17, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(103, 35, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(104, 35, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(105, 36, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(106, 36, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(107, 36, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(108, 37, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(109, 37, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(110, 37, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(111, 38, 20, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(112, 38, 17, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(113, 38, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(114, 39, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(115, 39, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(116, 39, 17, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(117, 40, 19, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(118, 40, 18, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(119, 40, 16, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(120, 41, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(121, 41, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(122, 42, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(123, 42, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(124, 43, 22, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(125, 43, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(126, 43, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(127, 44, 23, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(128, 44, 22, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(129, 44, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(130, 45, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(131, 45, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(132, 45, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(133, 46, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(134, 46, 23, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(135, 46, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(136, 47, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(137, 47, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(138, 48, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(139, 48, 23, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(140, 49, 22, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(141, 49, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(142, 49, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(143, 49, 23, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(144, 50, 21, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(145, 50, 25, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(146, 50, 23, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(147, 50, 24, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(148, 51, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(149, 51, 29, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(150, 51, 28, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(151, 52, 29, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(152, 52, 27, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(153, 52, 26, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(154, 52, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(155, 53, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(156, 53, 26, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(157, 54, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(158, 54, 28, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(159, 54, 29, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(160, 55, 27, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(161, 55, 26, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(162, 55, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(163, 55, 29, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(164, 56, 28, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(165, 56, 27, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(166, 56, 26, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(167, 56, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(168, 57, 27, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(169, 57, 30, '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(170, 58, 28, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(171, 58, 26, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(172, 58, 30, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(173, 58, 29, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(174, 59, 28, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(175, 59, 26, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(176, 59, 30, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(177, 59, 29, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(178, 60, 27, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(179, 60, 28, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(180, 61, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(181, 61, 35, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(182, 62, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(183, 62, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(184, 62, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(185, 63, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(186, 63, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(187, 63, 35, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(188, 64, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(189, 64, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(190, 64, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(191, 65, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(192, 65, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(193, 65, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(194, 65, 33, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(195, 66, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(196, 66, 33, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(197, 66, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(198, 67, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(199, 67, 33, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(200, 67, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(201, 67, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(202, 68, 33, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(203, 68, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(204, 69, 31, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(205, 69, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(206, 69, 35, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(207, 70, 34, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(208, 70, 35, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(209, 70, 32, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(210, 71, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(211, 71, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(212, 71, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(213, 71, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(214, 72, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(215, 72, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(216, 73, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(217, 73, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(218, 73, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(219, 74, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(220, 74, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(221, 74, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(222, 74, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(223, 75, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(224, 75, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(225, 75, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(226, 75, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(227, 76, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(228, 76, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(229, 76, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(230, 77, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(231, 77, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(232, 77, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(233, 77, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(234, 78, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(235, 78, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(236, 78, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(237, 78, 40, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(238, 79, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(239, 79, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(240, 79, 38, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(241, 80, 36, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(242, 80, 39, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(243, 80, 37, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(244, 81, 45, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(245, 81, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(246, 81, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(247, 82, 41, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(248, 82, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(249, 83, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(250, 83, 41, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(251, 83, 45, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(252, 83, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(253, 84, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(254, 84, 45, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(255, 85, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(256, 85, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(257, 86, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(258, 86, 41, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(259, 86, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(260, 86, 45, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(261, 87, 41, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(262, 87, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(263, 88, 45, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(264, 88, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(265, 88, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(266, 89, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(267, 89, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(268, 89, 41, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(269, 90, 43, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(270, 90, 44, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(271, 90, 42, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(272, 91, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(273, 91, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(274, 91, 46, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(275, 92, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(276, 92, 49, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(277, 92, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(278, 92, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(279, 93, 46, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(280, 93, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(281, 94, 46, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(282, 94, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(283, 95, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(284, 95, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(285, 96, 49, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(286, 96, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(287, 96, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(288, 97, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(289, 97, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(290, 97, 46, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(291, 97, 49, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(292, 98, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(293, 98, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(294, 98, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(295, 99, 46, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(296, 99, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(297, 99, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(298, 99, 49, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(299, 100, 48, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(300, 100, 47, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(301, 100, 50, '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(302, 100, 49, '2025-11-07 04:53:02', '2025-11-07 04:53:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_tenants`
--

CREATE TABLE `room_tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `join_date` date NOT NULL,
  `expected_leave_date` date DEFAULT NULL,
  `left_date` date DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_tenants`
--

INSERT INTO `room_tenants` (`id`, `room_id`, `user_id`, `join_date`, `expected_leave_date`, `left_date`, `is_primary`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 9, '2025-11-07', '2026-06-07', NULL, 1, 'Deposit: 2,600,000 VND, Monthly rent: 3,100,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 2, 33, '2025-10-07', '2026-04-07', NULL, 1, 'Deposit: 3,400,000 VND, Monthly rent: 3,900,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 5, 35, '2024-11-07', '2025-08-07', '2025-08-07', 1, 'Deposit: 2,000,000 VND, Monthly rent: 3,000,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 7, 16, '2025-11-07', '2026-10-07', NULL, 1, 'Deposit: 4,000,000 VND, Monthly rent: 5,000,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 8, 29, '2024-05-07', '2025-04-07', '2025-04-07', 1, 'Deposit: 2,800,000 VND, Monthly rent: 3,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 8, 24, '2025-11-07', '2026-05-07', NULL, 0, 'Deposit: 2,800,000 VND, Monthly rent: 3,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 9, 46, '2025-08-07', '2026-03-07', NULL, 1, 'Deposit: 3,300,000 VND, Monthly rent: 3,300,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 10, 26, '2025-10-07', '2026-09-07', NULL, 1, 'Deposit: 2,600,000 VND, Monthly rent: 3,100,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 11, 44, '2024-08-07', '2025-07-07', '2025-07-07', 1, 'Deposit: 4,600,000 VND, Monthly rent: 4,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 12, 34, '2025-11-07', '2026-11-07', NULL, 1, 'Deposit: 2,200,000 VND, Monthly rent: 2,200,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 13, 32, '2024-11-07', '2025-05-07', '2025-05-07', 1, 'Deposit: 2,300,000 VND, Monthly rent: 2,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 14, 51, '2025-02-07', '2025-12-07', NULL, 1, 'Deposit: 4,200,000 VND, Monthly rent: 4,200,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 15, 36, '2025-11-07', '2026-11-07', NULL, 1, 'Deposit: 2,700,000 VND, Monthly rent: 3,200,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 16, 39, '2024-05-07', '2025-05-07', '2025-05-07', 1, 'Deposit: 4,600,000 VND, Monthly rent: 4,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 16, 50, '2025-02-07', '2025-12-07', NULL, 0, 'Deposit: 4,600,000 VND, Monthly rent: 4,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 17, 53, '2025-02-07', '2025-12-07', NULL, 1, 'Deposit: 4,700,000 VND, Monthly rent: 4,700,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 18, 48, '2024-08-07', '2025-03-07', '2025-03-07', 1, 'Deposit: 3,800,000 VND, Monthly rent: 4,300,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 19, 41, '2025-05-07', '2026-03-07', NULL, 1, 'Deposit: 1,900,000 VND, Monthly rent: 2,400,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 20, 42, '2025-08-07', '2026-04-07', NULL, 1, 'Deposit: 3,400,000 VND, Monthly rent: 4,400,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 20, 47, '2025-08-07', '2026-04-07', NULL, 0, 'Deposit: 3,400,000 VND, Monthly rent: 4,400,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 21, 30, '2025-08-07', '2026-06-07', NULL, 1, 'Deposit: 2,100,000 VND, Monthly rent: 2,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 22, 31, '2024-08-07', '2025-04-07', '2025-04-07', 1, 'Deposit: 3,100,000 VND, Monthly rent: 4,100,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 22, 21, '2025-08-07', '2026-07-07', NULL, 0, 'Deposit: 3,100,000 VND, Monthly rent: 4,100,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 23, 18, '2024-05-07', '2024-11-07', '2024-11-07', 1, 'Deposit: 5,500,000 VND, Monthly rent: 5,500,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 23, 20, '2024-05-07', '2025-05-07', '2025-05-07', 0, 'Deposit: 5,500,000 VND, Monthly rent: 5,500,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 24, 27, '2025-11-07', '2026-09-07', NULL, 1, 'Deposit: 4,700,000 VND, Monthly rent: 5,200,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 24, 15, '2024-11-07', '2025-07-07', '2025-07-07', 0, 'Deposit: 4,700,000 VND, Monthly rent: 5,200,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 25, 40, '2025-08-07', '2026-03-07', NULL, 1, 'Deposit: 1,500,000 VND, Monthly rent: 2,500,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 26, 22, '2025-05-07', '2025-12-07', NULL, 1, 'Deposit: 3,300,000 VND, Monthly rent: 4,300,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 27, 49, '2025-10-07', '2026-06-07', NULL, 1, 'Deposit: 2,500,000 VND, Monthly rent: 3,000,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 27, 28, '2024-11-07', '2025-10-07', '2025-10-07', 0, 'Deposit: 2,500,000 VND, Monthly rent: 3,000,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 28, 45, '2025-11-07', '2026-05-07', NULL, 1, 'Deposit: 2,800,000 VND, Monthly rent: 2,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 29, 37, '2024-08-07', '2025-03-07', '2025-03-07', 1, 'Deposit: 3,200,000 VND, Monthly rent: 3,700,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 29, 11, '2025-10-07', '2026-07-07', NULL, 0, 'Deposit: 3,200,000 VND, Monthly rent: 3,700,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 30, 38, '2025-11-07', '2026-09-07', NULL, 1, 'Deposit: 3,300,000 VND, Monthly rent: 3,300,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 31, 17, '2025-02-07', '2026-01-07', NULL, 1, 'Deposit: 2,900,000 VND, Monthly rent: 2,900,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 31, 14, '2025-11-07', '2026-07-07', NULL, 0, 'Deposit: 2,900,000 VND, Monthly rent: 2,900,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 32, 43, '2025-02-07', '2025-10-07', '2025-10-07', 1, 'Deposit: 3,600,000 VND, Monthly rent: 3,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 32, 57, '2024-05-07', '2025-03-07', '2025-03-07', 0, 'Deposit: 3,600,000 VND, Monthly rent: 3,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 33, 10, '2025-08-07', '2026-02-07', NULL, 1, 'Deposit: 4,100,000 VND, Monthly rent: 4,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 33, 52, '2025-02-07', '2025-10-07', '2025-10-07', 0, 'Deposit: 4,100,000 VND, Monthly rent: 4,600,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 34, 23, '2025-02-07', '2025-10-07', '2025-10-07', 1, 'Deposit: 3,000,000 VND, Monthly rent: 4,000,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 35, 54, '2025-02-07', '2025-08-07', '2025-08-07', 1, 'Deposit: 4,400,000 VND, Monthly rent: 4,900,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 35, 55, '2024-08-07', '2025-08-07', '2025-08-07', 0, 'Deposit: 4,400,000 VND, Monthly rent: 4,900,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 36, 12, '2025-11-07', '2026-07-07', NULL, 1, 'Deposit: 1,800,000 VND, Monthly rent: 2,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 37, 56, '2024-11-07', '2025-11-07', '2025-11-07', 1, 'Deposit: 2,800,000 VND, Monthly rent: 2,800,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 38, 25, '2025-05-07', '2025-11-07', '2025-11-07', 1, 'Deposit: 2,600,000 VND, Monthly rent: 3,100,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 39, 19, '2025-05-07', '2026-01-07', NULL, 1, 'Deposit: 2,700,000 VND, Monthly rent: 3,700,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 40, 13, '2025-08-07', '2026-06-07', NULL, 1, 'Deposit: 4,000,000 VND, Monthly rent: 4,500,000 VND', '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_type` enum('electric','water','internet','parking','garbage','other') NOT NULL DEFAULT 'electric',
  `service_price` decimal(10,2) NOT NULL,
  `unit` enum('KWH','m3','person','month') NOT NULL DEFAULT 'KWH',
  `unit_vi` enum('kWh','m³','người','tháng') NOT NULL DEFAULT 'kWh',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `house_id`, `service_name`, `service_type`, `service_price`, `unit`, `unit_vi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(2, 1, 'Nước', 'water', 15000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(3, 1, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(4, 1, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(5, 1, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(6, 2, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(7, 2, 'Nước', 'water', 20000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(8, 2, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(9, 2, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(10, 2, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(11, 3, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(12, 3, 'Nước theo người', 'water', 80000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(13, 3, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(14, 3, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(15, 3, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(16, 4, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(17, 4, 'Nước theo người', 'water', 80000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(18, 4, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(19, 4, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(20, 4, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(21, 5, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(22, 5, 'Nước theo người', 'water', 60000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(23, 5, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(24, 5, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(25, 5, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(26, 6, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(27, 6, 'Nước theo người', 'water', 60000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(28, 6, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(29, 6, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(30, 6, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(31, 7, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(32, 7, 'Nước', 'water', 20000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(33, 7, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(34, 7, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(35, 7, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(36, 8, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(37, 8, 'Nước', 'water', 18000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(38, 8, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(39, 8, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(40, 8, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(41, 9, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(42, 9, 'Nước', 'water', 15000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(43, 9, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(44, 9, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(45, 9, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(46, 10, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(47, 10, 'Nước', 'water', 18000.00, 'm3', 'm³', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(48, 10, 'Internet', 'internet', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(49, 10, 'Rác thải', 'garbage', 20000.00, 'person', 'người', '2025-11-07 04:53:01', '2025-11-07 04:53:01'),
(50, 10, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_usages`
--

CREATE TABLE `service_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `old_value` double DEFAULT NULL,
  `new_value` double DEFAULT NULL,
  `usage_amount` double DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `month_year` varchar(255) NOT NULL DEFAULT '11-2025',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_usages`
--

INSERT INTO `service_usages` (`id`, `room_id`, `service_id`, `old_value`, `new_value`, `usage_amount`, `unit_price`, `total_amount`, `month_year`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 2733, 2791, 58, 4000, 232000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(2, 9, 2, 238, 257, 19, 15000, 285000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(3, 9, 3, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(4, 9, 4, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(5, 9, 5, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(6, 14, 6, 2539, 2589, 50, 4000, 200000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(7, 14, 7, 199, 213, 14, 20000, 280000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(8, 14, 8, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(9, 14, 9, NULL, NULL, 1, 20000, 20000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(10, 14, 10, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(11, 14, 6, 2616, 2761, 145, 4000, 580000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(12, 14, 7, 212, 221, 9, 20000, 180000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(13, 14, 8, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(14, 14, 9, NULL, NULL, 1, 20000, 20000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(15, 14, 10, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(16, 14, 6, 2739, 2850, 111, 4000, 444000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(17, 14, 7, 223, 230, 7, 20000, 140000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(18, 14, 8, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(19, 14, 9, NULL, NULL, 1, 20000, 20000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(20, 14, 10, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(21, 14, 6, 2884, 3017, 133, 4000, 532000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(22, 14, 7, 242, 262, 20, 20000, 400000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(23, 14, 8, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(24, 14, 9, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(25, 14, 10, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(26, 14, 6, 3040, 3100, 60, 4000, 240000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(27, 14, 7, 265, 275, 10, 20000, 200000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(28, 14, 8, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(29, 14, 9, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(30, 14, 10, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(31, 14, 6, 3006, 3169, 163, 4000, 652000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(32, 14, 7, 244, 260, 16, 20000, 320000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(33, 14, 8, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(34, 14, 9, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(35, 14, 10, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(36, 14, 6, 3345, 3426, 81, 4000, 324000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(37, 14, 7, 295, 306, 11, 20000, 220000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(38, 14, 8, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(39, 14, 9, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(40, 14, 10, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(41, 16, 6, 2720, 2908, 188, 4000, 752000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(42, 16, 7, 220, 232, 12, 20000, 240000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(43, 16, 8, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(44, 16, 9, NULL, NULL, 1, 20000, 20000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(45, 16, 10, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(46, 16, 6, 2898, 3036, 138, 4000, 552000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(47, 16, 7, 228, 248, 20, 20000, 400000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(48, 16, 8, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(49, 16, 9, NULL, NULL, 1, 20000, 20000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(50, 16, 10, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(51, 16, 6, 2981, 3133, 152, 4000, 608000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(52, 16, 7, 252, 266, 14, 20000, 280000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(53, 16, 8, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(54, 16, 9, NULL, NULL, 1, 20000, 20000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(55, 16, 10, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(56, 16, 6, 2964, 3113, 149, 4000, 596000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(57, 16, 7, 250, 267, 17, 20000, 340000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(58, 16, 8, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(59, 16, 9, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(60, 16, 10, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(61, 16, 6, 3070, 3200, 130, 4000, 520000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(62, 16, 7, 265, 280, 15, 20000, 300000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(63, 16, 8, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(64, 16, 9, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(65, 16, 10, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(66, 16, 6, 3374, 3431, 57, 4000, 228000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(67, 16, 7, 300, 306, 6, 20000, 120000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(68, 16, 8, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(69, 16, 9, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(70, 16, 10, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(71, 16, 6, 3209, 3321, 112, 4000, 448000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(72, 16, 7, 308, 320, 12, 20000, 240000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(73, 16, 8, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(74, 16, 9, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(75, 16, 10, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(76, 17, 6, 2818, 3006, 188, 4000, 752000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(77, 17, 7, 234, 241, 7, 20000, 140000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(78, 17, 8, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(79, 17, 9, NULL, NULL, 1, 20000, 20000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(80, 17, 10, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(81, 17, 6, 2988, 3123, 135, 4000, 540000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(82, 17, 7, 238, 252, 14, 20000, 280000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(83, 17, 8, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(84, 17, 9, NULL, NULL, 1, 20000, 20000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(85, 17, 10, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(86, 17, 6, 3054, 3180, 126, 4000, 504000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(87, 17, 7, 265, 280, 15, 20000, 300000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(88, 17, 8, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(89, 17, 9, NULL, NULL, 1, 20000, 20000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(90, 17, 10, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(91, 17, 6, 3248, 3364, 116, 4000, 464000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(92, 17, 7, 252, 265, 13, 20000, 260000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(93, 17, 8, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(94, 17, 9, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(95, 17, 10, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(96, 17, 6, 3315, 3370, 55, 4000, 220000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(97, 17, 7, 260, 276, 16, 20000, 320000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(98, 17, 8, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(99, 17, 9, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(100, 17, 10, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(101, 17, 6, 3306, 3419, 113, 4000, 452000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(102, 17, 7, 292, 304, 12, 20000, 240000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(103, 17, 8, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(104, 17, 9, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(105, 17, 10, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(106, 17, 6, 3722, 3801, 79, 4000, 316000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(107, 17, 7, 297, 304, 7, 20000, 140000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(108, 17, 8, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(109, 17, 9, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(110, 17, 10, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(111, 19, 6, 3432, 3580, 148, 4000, 592000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(112, 19, 7, 276, 294, 18, 20000, 360000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(113, 19, 8, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(114, 19, 9, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(115, 19, 10, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(116, 19, 6, 3485, 3576, 91, 4000, 364000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(117, 19, 7, 285, 302, 17, 20000, 340000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(118, 19, 8, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(119, 19, 9, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(120, 19, 10, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(121, 19, 6, 3476, 3624, 148, 4000, 592000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(122, 19, 7, 324, 335, 11, 20000, 220000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(123, 19, 8, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(124, 19, 9, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(125, 19, 10, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(126, 19, 6, 3852, 4051, 199, 4000, 796000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(127, 19, 7, 296, 304, 8, 20000, 160000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(128, 19, 8, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(129, 19, 9, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(130, 19, 10, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(131, 20, 6, 3889, 4089, 200, 4000, 800000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(132, 20, 7, 327, 344, 17, 20000, 340000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(133, 20, 8, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(134, 20, 9, NULL, NULL, 2, 20000, 40000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(135, 20, 10, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(136, 21, 11, 4003, 4167, 164, 3500, 574000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(137, 21, 12, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(138, 21, 13, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(139, 21, 14, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(140, 21, 15, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(141, 22, 11, 4124, 4174, 50, 3500, 175000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(142, 22, 12, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(143, 22, 13, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(144, 22, 14, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(145, 22, 15, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(146, 25, 11, 4214, 4277, 63, 3500, 220500, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(147, 25, 12, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(148, 25, 13, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(149, 25, 14, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(150, 25, 15, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(151, 26, 11, 3996, 4122, 126, 3500, 441000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(152, 26, 12, NULL, NULL, 1, 80000, 80000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(153, 26, 13, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(154, 26, 14, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(155, 26, 15, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(156, 26, 11, 4030, 4123, 93, 3500, 325500, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(157, 26, 12, NULL, NULL, 1, 80000, 80000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(158, 26, 13, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(159, 26, 14, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(160, 26, 15, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(161, 26, 11, 4362, 4516, 154, 3500, 539000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(162, 26, 12, NULL, NULL, 1, 80000, 80000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(163, 26, 13, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(164, 26, 14, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(165, 26, 15, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(166, 26, 11, 4216, 4351, 135, 3500, 472500, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(167, 26, 12, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(168, 26, 13, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(169, 26, 14, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(170, 26, 15, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(171, 31, 16, 4216, 4310, 94, 3500, 329000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(172, 31, 17, NULL, NULL, 2, 80000, 160000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(173, 31, 18, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(174, 31, 19, NULL, NULL, 2, 20000, 40000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(175, 31, 20, NULL, NULL, 1, 100000, 100000, '02-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(176, 31, 16, 4314, 4504, 190, 3500, 665000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(177, 31, 17, NULL, NULL, 2, 80000, 160000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(178, 31, 18, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(179, 31, 19, NULL, NULL, 2, 20000, 40000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(180, 31, 20, NULL, NULL, 1, 100000, 100000, '03-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(181, 31, 16, 4466, 4563, 97, 3500, 339500, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(182, 31, 17, NULL, NULL, 2, 80000, 160000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(183, 31, 18, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(184, 31, 19, NULL, NULL, 2, 20000, 40000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(185, 31, 20, NULL, NULL, 1, 100000, 100000, '04-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(186, 31, 16, 4440, 4556, 116, 3500, 406000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(187, 31, 17, NULL, NULL, 2, 80000, 160000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(188, 31, 18, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(189, 31, 19, NULL, NULL, 2, 20000, 40000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(190, 31, 20, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(191, 31, 16, 4690, 4779, 89, 3500, 311500, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(192, 31, 17, NULL, NULL, 2, 80000, 160000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(193, 31, 18, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(194, 31, 19, NULL, NULL, 2, 20000, 40000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(195, 31, 20, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(196, 31, 16, 4862, 5029, 167, 3500, 584500, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(197, 31, 17, NULL, NULL, 2, 80000, 160000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(198, 31, 18, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(199, 31, 19, NULL, NULL, 2, 20000, 40000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(200, 31, 20, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(201, 31, 16, 4688, 4811, 123, 3500, 430500, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(202, 31, 17, NULL, NULL, 2, 80000, 160000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(203, 31, 18, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(204, 31, 19, NULL, NULL, 2, 20000, 40000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(205, 31, 20, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(206, 33, 16, 5210, 5399, 189, 3500, 661500, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(207, 33, 17, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(208, 33, 18, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(209, 33, 19, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(210, 33, 20, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(211, 39, 16, 5372, 5545, 173, 3500, 605500, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(212, 39, 17, NULL, NULL, 1, 80000, 80000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(213, 39, 18, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(214, 39, 19, NULL, NULL, 1, 20000, 20000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(215, 39, 20, NULL, NULL, 1, 100000, 100000, '05-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(216, 39, 16, 5370, 5499, 129, 3500, 451500, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(217, 39, 17, NULL, NULL, 1, 80000, 80000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(218, 39, 18, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(219, 39, 19, NULL, NULL, 1, 20000, 20000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(220, 39, 20, NULL, NULL, 1, 100000, 100000, '06-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(221, 39, 16, 5584, 5645, 61, 3500, 213500, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(222, 39, 17, NULL, NULL, 1, 80000, 80000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(223, 39, 18, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(224, 39, 19, NULL, NULL, 1, 20000, 20000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(225, 39, 20, NULL, NULL, 1, 100000, 100000, '07-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(226, 39, 16, 5845, 6035, 190, 3500, 665000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(227, 39, 17, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(228, 39, 18, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(229, 39, 19, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(230, 39, 20, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(231, 40, 16, 5987, 6137, 150, 3500, 525000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(232, 40, 17, NULL, NULL, 1, 80000, 80000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(233, 40, 18, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(234, 40, 19, NULL, NULL, 1, 20000, 20000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02'),
(235, 40, 20, NULL, NULL, 1, 100000, 100000, '08-2025', '2025-11-07 04:53:02', '2025-11-07 04:53:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `related_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_category_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('receipt','expense') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_categories`
--

CREATE TABLE `transaction_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_category_name` varchar(255) NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `citizen_id` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `account_status` enum('active','inactive','banned') NOT NULL DEFAULT 'inactive',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `last_login` date DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `gender`, `birthday`, `job`, `province`, `ward`, `address`, `citizen_id`, `role_id`, `account_status`, `email_verified_at`, `avatar`, `last_login`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$Te6J2PGi9Yxb4/ux/nHaxuU.kLX8a8K67pbVnQ11OS.pCPrwMtlra', '0321234568', 'male', '1990-01-01', 'Quản trị viên', 'Thành phố Hồ Chí Minh', 'Phường  Rạch Dừa', '123 Đường Nguyễn Huệ', '079090976842', 1, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:55', '2025-11-07 04:52:55'),
(2, 'landlord1', 'landlord1@example.com', '$2y$10$2ZHu.xCAlSUiMwqFhBm0J...bUj/Txyxmh66k5w8ELa4XV0GX86xa', '0980000001', 'male', '1981-01-05', 'Chủ nhà trọ', 'Thành phố Hồ Chí Minh', 'Phường Tam Thắng', '100 Đường XYZ', '079081003716', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(3, 'landlord2', 'landlord2@example.com', '$2y$10$PiJCq.1niaGplK9/DuY3pe6y7dmY.0FNGq0Fmdk6BioEBf/ExPpUe', '0970000002', 'female', '1982-02-10', 'Quản lý bất động sản', 'Thành phố Hồ Chí Minh', 'Xã Kim Long', '200 Đường XYZ', '079182566470', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(4, 'landlord3', 'landlord3@example.com', '$2y$10$YkyjigXBAcvUEJCN75TNg.tkzTOPGR9JiD0K5PSdbbXL8NjZfRwt6', '0960000003', 'male', '1983-03-15', 'Đầu tư bất động sản', 'Thành phố Hồ Chí Minh', 'Xã Thường Tân', '300 Đường XYZ', '079083944349', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(5, 'landlord4', 'landlord4@example.com', '$2y$10$HHt1oxXZvPp/DxuH1c9nYeD0YY1uk3qGgnf2jQymdBDMhWl7b705u', '0950000004', 'female', '1984-04-20', 'Chủ khu trọ', 'Thành phố Hồ Chí Minh', 'Phường Phú Mỹ', '400 Đường XYZ', '079184135507', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(6, 'landlord5', 'landlord5@example.com', '$2y$10$xOCITT.SlrwHFsalbkulUu4mmseabirfULitaLlLu23H8cnMA3Rsa', '0940000005', 'male', '1985-05-25', 'Quản lý ký túc xá', 'Thành phố Hồ Chí Minh', 'Phường Bến Cát', '500 Đường XYZ', '079085246317', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(7, 'landlord_empty', 'landlord_empty@example.com', '$2y$10$jYNqxOCzaWjvbw/sUePyHucsPWFjUdsVnFKlmlpsexmitYFQwPi7a', '0931234567', 'male', '1985-06-15', 'Chủ nhà trọ độc lập', 'Thành phố Hồ Chí Minh', 'Xã Thanh An', '456 Đường Võ Oanh', '079085734269', 2, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(8, 'khachhangtest', 'khachhangtest@example.com', '$2y$10$RopTr7./mWcKNnKyFf49IuwwmxbWF5FLNkeUqLchwskf4xCVEU7xW', '0321234567', 'male', '1995-08-15', 'Sinh viên', 'Thành phố Hồ Chí Minh', 'Phường An Phú', '789 Đường Lê Lợi', '079095556020', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(9, 'customer1', 'customer1@example.com', '$2y$10$eVF7hPTwmMKFPM.FuiP7/uc9/EzSuqXTrU78hEzPqEjxiTaAkMKOe', '0330000001', 'male', '1991-02-02', 'Sinh viên', 'Hưng Yên', 'Xã Hồng Quang', '100 Đường DEF', '033091662522', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(10, 'customer2', 'customer2@example.com', '$2y$10$3xSWHEWWXuEc1YqTLWAj8OCYp68g8duFSoX8HjQC6VECcniyrh07S', '0340000002', 'female', '1992-03-03', 'Nhân viên văn phòng', 'Lai Châu', 'Xã Mường Kim', '200 Đường DEF', '012192399063', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(11, 'customer3', 'customer3@example.com', '$2y$10$0gGbkyojmxbb2kNkP5mE9ekppc30JRa2ZZeeAFB/P5Kiry9dNBAtS', '0350000003', 'male', '1993-04-04', 'Công nhân', 'Thanh Hóa', 'Xã Mường Chanh', '300 Đường DEF', '038093971925', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:56', '2025-11-07 04:52:56'),
(12, 'customer4', 'customer4@example.com', '$2y$10$RpKovxRPtP1qdsQ1JFgsj.UfIzL8iEFTB6IuKVwfuuRKL6CoBabvO', '0360000004', 'female', '1994-05-05', 'Giáo viên', 'Nghệ An', 'Xã Châu Lộc', '400 Đường DEF', '040194017297', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(13, 'customer5', 'customer5@example.com', '$2y$10$IsRwQH6r9vq24VHxeIHXxuZ/ctQzUfINqp1XajN9b4SUzgCfIi5f2', '0370000005', 'male', '1995-06-06', 'Bác sĩ', 'Tây Ninh', 'Xã Tân Thạnh', '500 Đường DEF', '080095946596', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(14, 'customer6', 'customer6@example.com', '$2y$10$FHLXnCoTmX8FiJzVw2itGeUnqb/DpRP4FkYOYIxDr6s0G8f6eE4Mi', '0380000006', 'female', '1996-07-07', 'Kỹ sư', 'Lào Cai', 'Xã Trạm Tấu', '600 Đường DEF', '015196062401', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(15, 'customer7', 'customer7@example.com', '$2y$10$ACF.Snl8L5kRHeGK0cf4UudVXv7wTccyQ1jTrjmECkUj3SKEgCI9.', '0390000007', 'male', '1997-08-08', 'Thợ điện', 'Hưng Yên', 'Xã Đông Thái Ninh', '700 Đường DEF', '033097703861', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(16, 'customer8', 'customer8@example.com', '$2y$10$8JZPP0M9qTZZr8ZShGFPC.X0p3.1/woOdosmWbhsbo4rm6AZ6xjg.', '0700000008', 'female', '1998-09-09', 'Thợ nước', 'Gia Lai', 'Phường Hoài Nhơn Đông', '800 Đường DEF', '052198113173', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(17, 'customer9', 'customer9@example.com', '$2y$10$SrKfFxRRGogsZgMlAArZCOQN0/vkCD8ZXPptl3zYilqrVocginl9q', '0760000009', 'male', '1999-10-10', 'Lái xe', 'Phú Thọ', 'Phường Âu Cơ', '900 Đường DEF', '025099852194', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(18, 'customer10', 'customer10@example.com', '$2y$10$r4G2esZrVHebyvQHR4GNAurVHvOlkGY7JYDYHKp86howjcBC4VSt6', '0770000010', 'female', '1990-11-11', 'Nhân viên bán hàng', 'Quảng Ngãi', 'Xã Đình Cương', '1000 Đường DEF', '051190966577', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(19, 'customer11', 'customer11@example.com', '$2y$10$gRPrgbubBhC3IBnZnh.nY.PjZWLEc/besulF1UcszTgJNPG4GYIHW', '0780000011', 'male', '1991-12-12', 'Sinh viên', 'Tây Ninh', 'Xã Tân Thành', '1100 Đường DEF', '080091579416', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(20, 'customer12', 'customer12@example.com', '$2y$10$tUi15fB69ZbkXtFLKFWQSOouOYRhBTjJcu6d2yxG12EjcoRE/qRT.', '0790000012', 'female', '1992-01-13', 'Nhân viên văn phòng', 'Lạng Sơn', 'Xã Hưng Vũ', '1200 Đường DEF', '020192592506', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(21, 'customer13', 'customer13@example.com', '$2y$10$QJC4KG1Mj17px3d6XJ7DFuuRA0Lz9et5ZcMTamdm.vv5KEPr0j2wi', '0810000013', 'male', '1993-02-14', 'Công nhân', 'Bắc Ninh', 'Phường Vân Hà', '1300 Đường DEF', '024093110151', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(22, 'customer14', 'customer14@example.com', '$2y$10$EI2XDNcpUndNNQrjThnTnOADFcgsSYkI9oeyQF.IVMsPE/oJRMYcm', '0820000014', 'female', '1994-03-15', 'Giáo viên', 'Đồng Tháp', 'Phường Nhị Quý', '1400 Đường DEF', '082194170693', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:57', '2025-11-07 04:52:57'),
(23, 'customer15', 'customer15@example.com', '$2y$10$6rRMqtxwWdrCY0phYTwKvO/tuM6smuvL7VS7glZgA33GQ/DxaOHAW', '0830000015', 'male', '1995-04-16', 'Bác sĩ', 'Lạng Sơn', 'Xã Thụy Hùng', '1500 Đường DEF', '020095556711', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(24, 'customer16', 'customer16@example.com', '$2y$10$i0GFh1kG4.XSLU6jBK1mFuVkmlz5k4uB3XZjkftX6p85/ATsUg2Sm', '0840000016', 'female', '1996-05-17', 'Kỹ sư', 'Thành phố Hải Phòng', 'Xã Vĩnh Lại', '1600 Đường DEF', '031196909958', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(25, 'customer17', 'customer17@example.com', '$2y$10$L4enG.Me/.feZcbo.t2C5O4uH1KZBNjhR9lyqOhq2RY9e7fPldR0u', '0850000017', 'male', '1997-06-18', 'Thợ điện', 'Hưng Yên', 'Xã Tây Thụy Anh', '1700 Đường DEF', '033097942837', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(26, 'customer18', 'customer18@example.com', '$2y$10$rXDs6hxq20AphiVQDOu2LO4cp7Ozf/GtX8ClQ9AD8ieK2xPEbmZqa', '0560000018', 'female', '1998-07-19', 'Thợ nước', 'Thanh Hóa', 'Phường Hạc Thành', '1800 Đường DEF', '038198310294', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(27, 'customer19', 'customer19@example.com', '$2y$10$rhJqU9GokTZ1xGXQF4mTEOwuIWW1gNk985FIjFPi62NrevpuON8bm', '0580000019', 'male', '1999-08-20', 'Lái xe', 'Thành phố Hồ Chí Minh', 'Phường Gia Định', '1900 Đường DEF', '079099895394', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(28, 'customer20', 'customer20@example.com', '$2y$10$3sd/3s4TcPit0/MO1sqYBug6ahVJZhOcc2J5BKjpF0jIMW7O3274O', '0590000020', 'female', '1990-09-21', 'Nhân viên bán hàng', 'Đồng Nai', 'Xã Xuân Hòa', '2000 Đường DEF', '075190825628', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(29, 'customer21', 'customer21@example.com', '$2y$10$69WB2lLiHsDTQ/H18fL1BeEoZC7.C/y4kHjSzp8/al0wMMfGiOrXC', '0120000021', 'male', '1991-10-22', 'Sinh viên', 'Lâm Đồng', 'Phường Phú Thuỷ', '2100 Đường DEF', '068091376439', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(30, 'customer22', 'customer22@example.com', '$2y$10$d/ETpBTENAm8fzTjTa8Bl.R.lN8p8/UyL0XOtRFlmi8z2LnRcvVAm', '0130000022', 'female', '1992-11-23', 'Nhân viên văn phòng', 'Quảng Ngãi', 'Xã Rờ Kơi', '2200 Đường DEF', '051192633049', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(31, 'customer23', 'customer23@example.com', '$2y$10$UlPHX2a6K6F0UjtzNfrxJufzX.lWmLPko3TJFGyPDDQRcX3PgzklG', '0140000023', 'male', '1993-12-24', 'Công nhân', 'Hà Tĩnh', 'Xã Kỳ Lạc', '2300 Đường DEF', '042093229463', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(32, 'customer24', 'customer24@example.com', '$2y$10$em.pZF/uITC0oksnvdYNZuMGwqadStUEwH7zy4bwenT6kYn1QDZK.', '0150000024', 'female', '1994-01-25', 'Giáo viên', 'Thanh Hóa', 'Xã Trung Lý', '2400 Đường DEF', '038194325476', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(33, 'customer25', 'customer25@example.com', '$2y$10$WSItxd6/WEIQIRoD97R9gOtqhZGG.6VCFS3UP.O.JOiuUEkgcSaoK', '0160000025', 'male', '1995-02-26', 'Bác sĩ', 'Hà Tĩnh', 'Xã Yên Hòa', '2500 Đường DEF', '042095454674', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:58', '2025-11-07 04:52:58'),
(34, 'customer26', 'customer26@example.com', '$2y$10$hUmQTMYynd.Pjs8rGpxRMOso7tSbDyI/c.DAuQ6m2QVsXnkDBdGf6', '0170000026', 'female', '1996-03-27', 'Kỹ sư', 'Phú Thọ', 'Xã Quy Đức', '2600 Đường DEF', '025196280879', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(35, 'customer27', 'customer27@example.com', '$2y$10$ZYg280Ow9zQ6AjF6JX4oBeV.5sFctXOogq5R/lFRoCLPIjo50KEcu', '0180000027', 'male', '1997-04-28', 'Thợ điện', 'Điện Biên', 'Xã Sam Mứn', '2700 Đường DEF', '011097260998', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(36, 'customer28', 'customer28@example.com', '$2y$10$bG9i3ajms9jy/FS.O4hrJesSHjDfpQpRyPCxLxglEU0HvQY1t1KVK', '0190000028', 'female', '1998-05-01', 'Thợ nước', 'Thành phố Huế', 'Xã A Lưới 4', '2800 Đường DEF', '046198952086', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(37, 'customer29', 'customer29@example.com', '$2y$10$wRCXo7f9Iye3x2JrzqF9O.OSU50pEtcsMPiiiieejC5DYWVF7vpdy', '0200000029', 'male', '1999-06-02', 'Lái xe', 'Thành phố Hải Phòng', 'Phường Trần Liễu', '2900 Đường DEF', '031099748258', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(38, 'customer30', 'customer30@example.com', '$2y$10$Yf2k2pSeFdtweeFR5odzo.MGR0quGdO1Frs1esDHgN8.9LHQVzmiO', '0210000030', 'female', '1990-07-03', 'Nhân viên bán hàng', 'Hà Tĩnh', 'Xã Kỳ Khang', '3000 Đường DEF', '042190803657', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(39, 'customer31', 'customer31@example.com', '$2y$10$GvZncZ9yU/eNncP.snWtsOoQ4b7IgaIpOyXTH3JdPIozV4T69wwJG', '0220000031', 'male', '1991-08-04', 'Sinh viên', 'Quảng Ngãi', 'Xã Ngọk Tụ', '3100 Đường DEF', '051091683301', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(40, 'customer32', 'customer32@example.com', '$2y$10$DlnvZbADfbldM8vbD5TthuJyn334xAD933nQ4qOVAr2BXgBA2Qhx6', '0230000032', 'female', '1992-09-05', 'Nhân viên văn phòng', 'Đồng Tháp', 'Xã Tân Phú Trung', '3200 Đường DEF', '082192470166', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(41, 'customer33', 'customer33@example.com', '$2y$10$rbd7xOTxlO58vtDG6/bjV.SVzGYh9TYoxlTdhSR/Jy6UXpjgtlZRi', '0240000033', 'male', '1993-10-06', 'Công nhân', 'An Giang', 'Xã Nhơn Hội', '3300 Đường DEF', '091093858983', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(42, 'customer34', 'customer34@example.com', '$2y$10$kaA1ustDDNZVSFPD2bfeZetPtFBxla4JCYt1q7UwkAsrdPZExles.', '0250000034', 'female', '1994-11-07', 'Giáo viên', 'Thanh Hóa', 'Xã Tân Thành', '3400 Đường DEF', '038194831825', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(43, 'customer35', 'customer35@example.com', '$2y$10$rz/4Ixs4UjaDSOB28sZ3meh61mn0l3Jw8gRxQFu4.UU1tErumFg/m', '0260000035', 'male', '1995-12-08', 'Bác sĩ', 'Vĩnh Long', 'Xã Tam Ngãi', '3500 Đường DEF', '086095349046', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(44, 'customer36', 'customer36@example.com', '$2y$10$V.Tk4qLbWzWsNBXfZZWTe.6ntqXjRRkEM65i5Bj3.ocQIBFzaIMZu', '0270000036', 'female', '1996-01-09', 'Kỹ sư', 'Đồng Tháp', 'Xã Bình Hàng Trung', '3600 Đường DEF', '082196758554', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:52:59', '2025-11-07 04:52:59'),
(45, 'customer37', 'customer37@example.com', '$2y$10$ZcjAkff7nive0LFnhVj8E.V3/XRRzV8qyZWw9UI4szmpmVqsRpqA.', '0280000037', 'male', '1997-02-10', 'Thợ điện', 'Đồng Tháp', 'Xã Hội Cư', '3700 Đường DEF', '082097571128', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(46, 'customer38', 'customer38@example.com', '$2y$10$K7KA/RlAW2dQc7aronlmnOs9EdVewhgu87jESMhe6TWo2R/DYKr2W', '0290000038', 'female', '1998-03-11', 'Thợ nước', 'Quảng Trị', 'Xã Cồn Tiên', '3800 Đường DEF', '044198522817', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(47, 'customer39', 'customer39@example.com', '$2y$10$jJE.RrVwZvW4DBvccB./JepCpU6oYBY0aJEgAM3Csbys6pbV9hKcS', '0300000039', 'male', '1999-04-12', 'Lái xe', 'Quảng Ninh', 'Xã Tiên Yên', '3900 Đường DEF', '022099466187', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(48, 'customer40', 'customer40@example.com', '$2y$10$L9JiMc5TvIeFCE9iJ5YCruq0TftZlwZoW1mbadC4oDIrNszxQaLCS', '0310000040', 'female', '1990-05-13', 'Nhân viên bán hàng', 'Thành phố Đà Nẵng', 'Xã Trà Đốc', '4000 Đường DEF', '048190169987', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(49, 'customer41', 'customer41@example.com', '$2y$10$pKSFnobmn4Sbygoa3ojgzu0bbk6nLOJo1SDzKEc1svZlOyPqtm/1W', '0800000041', 'male', '1991-06-14', 'Sinh viên', 'Ninh Bình', 'Xã Xuân Hồng', '4100 Đường DEF', '037091840472', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(50, 'customer42', 'customer42@example.com', '$2y$10$lvzHC6jx39dq5zZfgx3DhegkBF3.9Kqpfsu6D2yE0v0Ky.WiGahu.', '0860000042', 'female', '1992-07-15', 'Nhân viên văn phòng', 'Nghệ An', 'Phường Cửa Lò', '4200 Đường DEF', '040192116513', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(51, 'customer43', 'customer43@example.com', '$2y$10$nmvHjDRUPPnuQP6hS265kOtbSKE50NQbIImrhtWP/bBJeL9DIrzZG', '0870000043', 'male', '1993-08-16', 'Công nhân', 'Quảng Ngãi', 'Xã Bình Sơn', '4300 Đường DEF', '051093113734', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(52, 'customer44', 'customer44@example.com', '$2y$10$wXbfFeY8q0nwzbyrrObDM.R54xOQnEc9umImoVJhGF.VOnChg.eQa', '0880000044', 'female', '1994-09-17', 'Giáo viên', 'Thành phố Hồ Chí Minh', 'Phường Tân Thuận', '4400 Đường DEF', '079194081878', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(53, 'customer45', 'customer45@example.com', '$2y$10$cQrgySJc8VtY4xShOCCVJuRXVRVCsr5cxxcA7eU1PuB5rO2k2BzV2', '0890000045', 'male', '1995-10-18', 'Bác sĩ', 'Thái Nguyên', 'Xã Vô Tranh', '4500 Đường DEF', '019095552230', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(54, 'customer46', 'customer46@example.com', '$2y$10$EJlhxdlT2sNlmd8V5Mo/2.tpCZpjKtSA9HuNnGImYl4e8/.Pddn.e', '0900000046', 'female', '1996-11-19', 'Kỹ sư', 'Ninh Bình', 'Xã Tân Thanh', '4600 Đường DEF', '037196958393', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(55, 'customer47', 'customer47@example.com', '$2y$10$KNG6mOfUhcQfmhy6l0DTROpcXLd41IixD6Tk2QN3/vDaFZnhNH0UC', '0910000047', 'male', '1997-12-20', 'Thợ điện', 'Thanh Hóa', 'Xã Tây Đô', '4700 Đường DEF', '038097362453', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(56, 'customer48', 'customer48@example.com', '$2y$10$8S0.fAV.NelOfe5UlM0c1Oz/BXI5OgB9k2N1ry30nWnYMaTONRgp2', '0920000048', 'female', '1998-01-21', 'Thợ nước', 'Đồng Nai', 'Phường Phước Long', '4800 Đường DEF', '075198125787', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:00', '2025-11-07 04:53:00'),
(57, 'customer49', 'customer49@example.com', '$2y$10$YUS3uzNv195rpJJ7TCQcKuJj1bnGJFE5efJkH/09R4iGout038T2S', '0930000049', 'male', '1999-02-22', 'Lái xe', 'Đắk Lắk', 'Xã Krông Á', '4900 Đường DEF', '066099761256', 3, 'active', NULL, NULL, NULL, 0, '2025-11-07 04:53:01', '2025-11-07 04:53:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_bankings`
--

CREATE TABLE `user_bankings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_bank_name` varchar(255) NOT NULL,
  `bank_code` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) NOT NULL,
  `bank_account_name` varchar(255) NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amenities_house_id_foreign` (`house_id`);

--
-- Chỉ mục cho bảng `banned`
--
ALTER TABLE `banned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banned_user_id_foreign` (`user_id`),
  ADD KEY `banned_banner_id_foreign` (`banner_id`),
  ADD KEY `banned_revoker_id_foreign` (`revoker_id`);

--
-- Chỉ mục cho bảng `customer_supports`
--
ALTER TABLE `customer_supports`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `houses_owner_id_foreign` (`owner_id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_room_id_foreign` (`room_id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `otp_verifies`
--
ALTER TABLE `otp_verifies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_verifies_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `queue_jobs`
--
ALTER TABLE `queue_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rental_amenities`
--
ALTER TABLE `rental_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_amenities_owner_id_foreign` (`owner_id`);

--
-- Chỉ mục cho bảng `rental_categories`
--
ALTER TABLE `rental_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_categories_owner_id_foreign` (`owner_id`);

--
-- Chỉ mục cho bảng `rental_posts`
--
ALTER TABLE `rental_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_posts_owner_id_foreign` (`owner_id`),
  ADD KEY `rental_posts_rental_category_id_foreign` (`rental_category_id`);

--
-- Chỉ mục cho bảng `rental_post_interestes`
--
ALTER TABLE `rental_post_interestes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `report_violations`
--
ALTER TABLE `report_violations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_house_id_foreign` (`house_id`);

--
-- Chỉ mục cho bảng `room_amenities`
--
ALTER TABLE `room_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_amenities_room_id_foreign` (`room_id`),
  ADD KEY `room_amenities_amenity_id_foreign` (`amenity_id`);

--
-- Chỉ mục cho bảng `room_services`
--
ALTER TABLE `room_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_services_room_id_foreign` (`room_id`),
  ADD KEY `room_services_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `room_tenants`
--
ALTER TABLE `room_tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_tenants_room_id_foreign` (`room_id`),
  ADD KEY `room_tenants_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_house_id_foreign` (`house_id`);

--
-- Chỉ mục cho bảng `service_usages`
--
ALTER TABLE `service_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_usages_room_id_foreign` (`room_id`),
  ADD KEY `service_usages_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_related_invoice_id_foreign` (`related_invoice_id`),
  ADD KEY `transactions_room_id_foreign` (`room_id`),
  ADD KEY `transactions_transaction_category_id_foreign` (`transaction_category_id`),
  ADD KEY `transactions_owner_id_transaction_type_created_at_index` (`owner_id`,`transaction_type`,`created_at`);

--
-- Chỉ mục cho bảng `transaction_categories`
--
ALTER TABLE `transaction_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_categories_owner_id_foreign` (`owner_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `user_bankings`
--
ALTER TABLE `user_bankings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_bankings_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `banned`
--
ALTER TABLE `banned`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `customer_supports`
--
ALTER TABLE `customer_supports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `houses`
--
ALTER TABLE `houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `otp_verifies`
--
ALTER TABLE `otp_verifies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `queue_jobs`
--
ALTER TABLE `queue_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rental_amenities`
--
ALTER TABLE `rental_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `rental_categories`
--
ALTER TABLE `rental_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `rental_posts`
--
ALTER TABLE `rental_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `rental_post_interestes`
--
ALTER TABLE `rental_post_interestes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `report_violations`
--
ALTER TABLE `report_violations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `room_amenities`
--
ALTER TABLE `room_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT cho bảng `room_services`
--
ALTER TABLE `room_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT cho bảng `room_tenants`
--
ALTER TABLE `room_tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `service_usages`
--
ALTER TABLE `service_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transaction_categories`
--
ALTER TABLE `transaction_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `user_bankings`
--
ALTER TABLE `user_bankings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `amenities_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `banned`
--
ALTER TABLE `banned`
  ADD CONSTRAINT `banned_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banned_revoker_id_foreign` FOREIGN KEY (`revoker_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banned_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `houses`
--
ALTER TABLE `houses`
  ADD CONSTRAINT `houses_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `otp_verifies`
--
ALTER TABLE `otp_verifies`
  ADD CONSTRAINT `otp_verifies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rental_amenities`
--
ALTER TABLE `rental_amenities`
  ADD CONSTRAINT `rental_amenities_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rental_categories`
--
ALTER TABLE `rental_categories`
  ADD CONSTRAINT `rental_categories_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rental_posts`
--
ALTER TABLE `rental_posts`
  ADD CONSTRAINT `rental_posts_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_posts_rental_category_id_foreign` FOREIGN KEY (`rental_category_id`) REFERENCES `rental_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `room_amenities`
--
ALTER TABLE `room_amenities`
  ADD CONSTRAINT `room_amenities_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_amenities_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `room_services`
--
ALTER TABLE `room_services`
  ADD CONSTRAINT `room_services_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `room_tenants`
--
ALTER TABLE `room_tenants`
  ADD CONSTRAINT `room_tenants_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_tenants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_house_id_foreign` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `service_usages`
--
ALTER TABLE `service_usages`
  ADD CONSTRAINT `service_usages_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_usages_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_related_invoice_id_foreign` FOREIGN KEY (`related_invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_transaction_category_id_foreign` FOREIGN KEY (`transaction_category_id`) REFERENCES `transaction_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `transaction_categories`
--
ALTER TABLE `transaction_categories`
  ADD CONSTRAINT `transaction_categories_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_bankings`
--
ALTER TABLE `user_bankings`
  ADD CONSTRAINT `user_bankings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
