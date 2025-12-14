-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 14, 2025 lúc 07:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` enum('select','create','update','delete') NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `field_name` text NOT NULL,
  `value` text NOT NULL,
  `description` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `table_name`, `field_name`, `value`, `description`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'update', 'users', '[\"last_login\",\"updated_at\",\"deleted\",\"id\"]', '[\"2025-12-14 12:07:08\",\"2025-12-14 12:08:07\",0,2]', 'UPDATE users SET last_login = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 05:07:08', '2025-12-14 05:07:08'),
(2, 2, 'create', 'rental_posts', '[\"owner_id, rental_category_id, house_id, rental_post_title, contact, phone, description, price, price_discount, rental_deposit, area, electric_fee, water_fee, max_number_of_people, stay_start_date, rental_amenities, rental_open_time, rental_close_time, province, ward, address, status, created_at, updated_at\"]', '[{\"owner_id\":2,\"rental_category_id\":\"3\",\"house_id\":\"2\",\"rental_post_title\":\"Cho thu\\u00ea ph\\u00f2ng tr\\u1ecd 18m2 gi\\u00e1 r\\u1ebb t\\u1ea1i B\\u00ecnh Th\\u1ea1nh\",\"contact\":\"Nguy\\u1ec5n Quang Huy\",\"phone\":\"0366465273\",\"description\":\"dad\\u0111\",\"price\":\"2000000\",\"price_discount\":\"\",\"rental_deposit\":\"\",\"area\":\"50\",\"electric_fee\":\"3500.00\",\"water_fee\":\"4000\",\"max_number_of_people\":\"2\",\"stay_start_date\":\"2025-12-20\",\"rental_amenities\":\"[\\\"2\\\",\\\"12\\\",\\\"20\\\"]\",\"rental_open_time\":\"all\",\"rental_close_time\":\"all\",\"province\":\"Th\\u00e0nh ph\\u1ed1 H\\u1ed3 Ch\\u00ed Minh\",\"ward\":\"X\\u00e3 B\\u00e0u B\\u00e0ng\",\"address\":\"451 \\u0110\\u01b0\\u1eddng 3 Th\\u00e1ng 2\",\"status\":\"active\",\"created_at\":\"2025-12-14 13:13:41\",\"updated_at\":\"2025-12-14 13:13:41\"}]', 'INSERT INTO rental_posts (owner_id, rental_category_id, house_id, rental_post_title, contact, phone, description, price, price_discount, rental_deposit, area, electric_fee, water_fee, max_number_of_people, stay_start_date, rental_amenities, rental_open_time, rental_close_time, province, ward, address, status, created_at, updated_at) VALUES (:owner_id, :rental_category_id, :house_id, :rental_post_title, :contact, :phone, :description, :price, :price_discount, :rental_deposit, :area, :electric_fee, :water_fee, :max_number_of_people, :stay_start_date, :rental_amenities, :rental_open_time, :rental_close_time, :province, :ward, :address, :status, :created_at, :updated_at)', 0, '2025-12-14 06:13:41', '2025-12-14 06:13:41'),
(3, 1, 'update', 'users', '[\"last_login\",\"updated_at\",\"deleted\",\"id\"]', '[\"2025-12-14 18:05:28\",\"2025-12-14 18:05:28\",0,1]', 'UPDATE users SET last_login = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:28:05', '2025-12-14 11:28:05'),
(4, 1, 'update', 'rental_posts', '[\"approval_status\",\"updated_at\",\"deleted\",\"id\"]', '[\"approved\",\"2025-12-14 18:11:28\",0,\"101\"]', 'UPDATE rental_posts SET approval_status = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:28:11', '2025-12-14 11:28:11'),
(5, 1, 'update', 'rental_posts', '[\"approval_reason\",\"updated_at\",\"deleted\",\"id\"]', '[\"-\",\"2025-12-14 18:11:28\",0,\"101\"]', 'UPDATE rental_posts SET approval_reason = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:28:11', '2025-12-14 11:28:11'),
(6, 1, 'update', 'rental_posts', '[\"approval_status\",\"updated_at\",\"deleted\",\"id\"]', '[\"approved\",\"2025-12-14 18:41:34\",0,\"2\"]', 'UPDATE rental_posts SET approval_status = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:34:41', '2025-12-14 11:34:41'),
(7, 1, 'update', 'rental_posts', '[\"approval_reason\",\"updated_at\",\"deleted\",\"id\"]', '[\"-\",\"2025-12-14 18:41:34\",0,\"2\"]', 'UPDATE rental_posts SET approval_reason = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:34:41', '2025-12-14 11:34:41'),
(8, 1, 'create', 'rental_posts', '[\"owner_id, rental_category_id, house_id, rental_post_title, contact, phone, description, price, price_discount, rental_deposit, area, electric_fee, water_fee, max_number_of_people, stay_start_date, rental_amenities, rental_open_time, rental_close_time, province, ward, address, status, created_at, updated_at\"]', '[{\"owner_id\":1,\"rental_category_id\":\"1\",\"house_id\":\"0\",\"rental_post_title\":\"Cho thu\\u00ea ph\\u00f2ng tr\\u1ecd 18m2 gi\\u00e1 r\\u1ebb t\\u1ea1i B\\u00ecnh Th\\u1ea1nh 1\",\"contact\":\"Nguy\\u1ec5n V\\u0103n A\",\"phone\":\"0366465273\",\"description\":\"d\\u00e2d\",\"price\":\"2000000\",\"price_discount\":\"\",\"rental_deposit\":\"\",\"area\":\"40\",\"electric_fee\":\"3500\",\"water_fee\":\"4000\",\"max_number_of_people\":\"2\",\"stay_start_date\":\"2025-12-20\",\"rental_amenities\":\"[\\\"6\\\",\\\"11\\\"]\",\"rental_open_time\":\"all\",\"rental_close_time\":\"all\",\"province\":\"Qu\\u1ea3ng Ninh\",\"ward\":\"Ph\\u01b0\\u1eddng M\\u00f3ng C\\u00e1i 1\",\"address\":\"122 - \\u0110\\u01b0\\u1eddng Nguy\\u1ec5n Duy Trinh\",\"status\":\"active\",\"created_at\":\"2025-12-14 18:37:49\",\"updated_at\":\"2025-12-14 18:37:49\"}]', 'INSERT INTO rental_posts (owner_id, rental_category_id, house_id, rental_post_title, contact, phone, description, price, price_discount, rental_deposit, area, electric_fee, water_fee, max_number_of_people, stay_start_date, rental_amenities, rental_open_time, rental_close_time, province, ward, address, status, created_at, updated_at) VALUES (:owner_id, :rental_category_id, :house_id, :rental_post_title, :contact, :phone, :description, :price, :price_discount, :rental_deposit, :area, :electric_fee, :water_fee, :max_number_of_people, :stay_start_date, :rental_amenities, :rental_open_time, :rental_close_time, :province, :ward, :address, :status, :created_at, :updated_at)', 0, '2025-12-14 11:37:49', '2025-12-14 11:37:49'),
(9, 1, 'update', 'rental_posts', '[\"approval_status\",\"updated_at\",\"deleted\",\"id\"]', '[\"approved\",\"2025-12-14 18:49:37\",0,\"102\"]', 'UPDATE rental_posts SET approval_status = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 11:37:49', '2025-12-14 11:37:49'),
(10, 2, 'update', 'rental_posts', '[\"status\",\"updated_at\",\"id\",\"owner_id\"]', '[\"active\",\"2025-12-14 18:57:51\",\"11\",2]', 'UPDATE rental_posts SET status = ?, updated_at = ? WHERE id = ? AND owner_id = ?', 0, '2025-12-14 11:57:51', '2025-12-14 11:57:51'),
(11, 11, 'update', 'users', '[\"last_login\",\"updated_at\",\"deleted\",\"id\"]', '[\"2025-12-14 19:02:28\",\"2025-12-14 19:28:02\",0,11]', 'UPDATE users SET last_login = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 12:02:28', '2025-12-14 12:02:28'),
(12, 11, 'create', 'report_violations', '[\"target_id, title, rental_post_id, target_type, violattion_type, description, created_at\"]', '[{\"target_id\":11,\"title\":\"L\\u1ea5y b\\u00e0i ng\\u01b0\\u1eddi kh\\u00e1c \\u0111\\u1ec3 \\u0111\\u0103ng\",\"rental_post_id\":\"101\",\"target_type\":\"post\",\"violattion_type\":\"spam\",\"description\":\"dad\\u0111\",\"created_at\":\"2025-12-14 19:41:02\"}]', 'INSERT INTO report_violations (target_id, title, rental_post_id, target_type, violattion_type, description, created_at) VALUES (:target_id, :title, :rental_post_id, :target_type, :violattion_type, :description, :created_at)', 0, '2025-12-14 12:02:41', '2025-12-14 12:02:41'),
(13, 11, 'create', 'customer_supports', '[\"customer_name, customer_email, customer_phone, support_type, description_problem, created_at, updated_at\"]', '[{\"customer_name\":\"Nguy\\u1ec5n Quang Huy\",\"customer_email\":\"huynguyenharu3108@gmail.com\",\"customer_phone\":\"0366465273\",\"support_type\":\"T\\u00e0i kho\\u1ea3n\",\"description_problem\":\"ffsfsd\",\"created_at\":\"2025-12-14 19:25:11\",\"updated_at\":\"2025-12-14 19:25:11\"}]', 'INSERT INTO customer_supports (customer_name, customer_email, customer_phone, support_type, description_problem, created_at, updated_at) VALUES (:customer_name, :customer_email, :customer_phone, :support_type, :description_problem, :created_at, :updated_at)', 0, '2025-12-14 12:11:25', '2025-12-14 12:11:25'),
(14, 2, 'update', 'users', '[\"last_login\",\"updated_at\",\"deleted\",\"id\"]', '[\"2025-12-14 19:17:12\",\"2025-12-14 19:12:17\",0,2]', 'UPDATE users SET last_login = ?, updated_at = ? WHERE deleted = ? AND id = ?', 0, '2025-12-14 12:17:12', '2025-12-14 12:17:12'),
(15, 2, 'create', 'rental_amenities', '[\"rental_amenity_name, rental_amenity_status, owner_id, created_at, updated_at\"]', '[{\"rental_amenity_name\":\"Test ti\\u1ec7n \\u00edch\",\"rental_amenity_status\":\"active\",\"owner_id\":2,\"created_at\":\"2025-12-14 19:20:09\",\"updated_at\":\"2025-12-14 19:20:09\"}]', 'INSERT INTO rental_amenities (rental_amenity_name, rental_amenity_status, owner_id, created_at, updated_at) VALUES (:rental_amenity_name, :rental_amenity_status, :owner_id, :created_at, :updated_at)', 0, '2025-12-14 12:20:09', '2025-12-14 12:20:09');

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
(1, 1, 'Tủ bếp', 1200000.00, 1, 'bộ', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(2, 1, 'Tủ lạnh', 5000000.00, 3, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(3, 1, 'Giường ngủ', 1500000.00, 5, 'chiếc', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(4, 1, 'Tivi', 6000000.00, 2, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(5, 1, 'Điều hòa', 8000000.00, 2, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(6, 1, 'Bếp gas', 800000.00, 3, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(7, 2, 'Ghế ngồi', 500000.00, 1, 'chiếc', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(8, 2, 'Tủ lạnh', 5000000.00, 2, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(9, 2, 'Bếp gas', 800000.00, 3, 'cái', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(10, 2, 'Tủ bếp', 1200000.00, 2, 'bộ', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(11, 2, 'Máy nước nóng', 3000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(12, 2, 'Máy giặt', 4000000.00, 2, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(13, 2, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(14, 3, 'Ghế ngồi', 500000.00, 1, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(15, 3, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(16, 3, 'Tủ bếp', 1200000.00, 4, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(17, 3, 'Tủ quần áo', 2000000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(18, 3, 'Tủ lạnh', 5000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(19, 4, 'Tủ bếp', 1200000.00, 5, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(20, 4, 'Bếp gas', 800000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(21, 4, 'Giường ngủ', 1500000.00, 3, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(22, 4, 'Ghế ngồi', 500000.00, 3, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(23, 4, 'Máy nước nóng', 3000000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(24, 4, 'Tủ lạnh', 5000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(25, 4, 'Tivi', 6000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(26, 4, 'Bàn học', 800000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(27, 5, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(28, 5, 'Tủ quần áo', 2000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(29, 5, 'Tủ lạnh', 5000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(30, 5, 'Tivi', 6000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(31, 5, 'Điều hòa', 8000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(32, 5, 'Tủ bếp', 1200000.00, 2, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(33, 5, 'Giường ngủ', 1500000.00, 4, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(34, 6, 'Ghế ngồi', 500000.00, 1, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(35, 6, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(36, 6, 'Máy giặt', 4000000.00, 2, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(37, 6, 'Tivi', 6000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(38, 6, 'Giường ngủ', 1500000.00, 2, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(39, 6, 'Tủ quần áo', 2000000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(40, 7, 'Bàn học', 800000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(41, 7, 'Máy nước nóng', 3000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(42, 7, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(43, 7, 'Ghế ngồi', 500000.00, 5, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(44, 7, 'Bếp gas', 800000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(45, 7, 'Tivi', 6000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(46, 7, 'Tủ bếp', 1200000.00, 3, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(47, 7, 'Tủ quần áo', 2000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(48, 8, 'Bếp gas', 800000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(49, 8, 'Tủ lạnh', 5000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(50, 8, 'Tủ bếp', 1200000.00, 2, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(51, 8, 'Máy giặt', 4000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(52, 8, 'Bàn học', 800000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(53, 8, 'Điều hòa', 8000000.00, 3, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(54, 8, 'Ghế ngồi', 500000.00, 5, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(55, 9, 'Tủ lạnh', 5000000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(56, 9, 'Điều hòa', 8000000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(57, 9, 'Máy giặt', 4000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(58, 9, 'Giường ngủ', 1500000.00, 1, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(59, 9, 'Bếp gas', 800000.00, 5, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(60, 10, 'Máy giặt', 4000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(61, 10, 'Tivi', 6000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(62, 10, 'Ghế ngồi', 500000.00, 4, 'chiếc', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(63, 10, 'Tủ lạnh', 5000000.00, 4, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(64, 10, 'Tủ bếp', 1200000.00, 1, 'bộ', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(65, 10, 'Điều hòa', 8000000.00, 1, 'cái', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43');

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
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
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
  `customer_phone` varchar(255) DEFAULT NULL,
  `support_type` varchar(255) NOT NULL,
  `description_problem` text NOT NULL,
  `images` text DEFAULT NULL,
  `user_process_id` int(11) DEFAULT NULL,
  `description_process` text DEFAULT NULL,
  `date_process` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_supports`
--

INSERT INTO `customer_supports` (`id`, `customer_name`, `customer_email`, `customer_phone`, `support_type`, `description_problem`, `images`, `user_process_id`, `description_process`, `date_process`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Quang Huy', 'huynguyenharu3108@gmail.com', '0366465273', 'Tài khoản', 'ffsfsd', NULL, NULL, NULL, NULL, 0, '2025-12-14 12:25:11', '2025-12-14 12:25:11');

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
(1, 2, 'Nhà trọ Hạnh Phúc', 'Thành phố Hồ Chí Minh', 'Phường An Đông', '361 Đường Nguyễn Du', 10, 3, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(2, 2, 'Nhà trọ Bình Yên', 'Thành phố Hồ Chí Minh', 'Xã Bàu Bàng', '451 Đường 3 Tháng 2', 17, 4, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(3, 3, 'Nhà trọ Gia Đình', 'Thành phố Hồ Chí Minh', 'Phường Bình Hòa', '641 Đường Đồng Khởi', 11, 4, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(4, 3, 'Nhà trọ Thân Thiện', 'Thành phố Hồ Chí Minh', 'Xã Bàu Bàng', '352 Đường Đồng Khởi', 11, 5, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(5, 4, 'Nhà trọ An Lạc', 'Thành phố Hồ Chí Minh', 'Phường Phú Lâm', '35 Đường Nguyễn Thị Minh Khai', 22, 4, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(6, 4, 'Nhà trọ Hòa Thuận', 'Thành phố Hồ Chí Minh', 'Xã Thái Mỹ', '353 Đường Nguyễn Du', 10, 3, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(7, 5, 'Nhà trọ Tình Thương', 'Thành phố Hồ Chí Minh', 'Phường Tam Bình', '572 Đường Hai Bà Trưng', 25, 4, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(8, 5, 'Nhà trọ Đoàn Kết', 'Thành phố Hồ Chí Minh', 'Phường Tân Khánh', '35 Đường Lê Duẩn', 12, 3, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(9, 6, 'Nhà trọ Hữu Nghị', 'Thành phố Hồ Chí Minh', 'Xã Phước Hải', '745 Đường Hai Bà Trưng', 24, 5, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04'),
(10, 6, 'Nhà trọ Tương Lai', 'Thành phố Hồ Chí Minh', 'Phường Gia Định', '641 Đường Cách Mạng Tháng 8', 21, 5, 0, '2025-12-13 21:46:42', '2025-12-13 21:47:04');

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
  `invoice_day` date NOT NULL DEFAULT '2025-12-14',
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
(1, 7, 30, 'Hóa đơn 03-2025', '03-2025', '2025-03-31', '2025-04-03', '2025-03-10', 3100000.00, 100000.00, 740000.00, 60000.00, 1020000.00, 100000.00, 20000.00, 0.00, 4120000.00, 'paid', 'INV-7-032025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(2, 7, 30, 'Hóa đơn 04-2025', '04-2025', '2025-04-30', '2025-05-03', '2025-04-10', 3100000.00, 100000.00, 520000.00, 60000.00, 800000.00, 100000.00, 20000.00, 0.00, 3900000.00, 'paid', 'INV-7-042025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(3, 7, 30, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-03', '2025-05-10', 3100000.00, 100000.00, 284000.00, 60000.00, 564000.00, 100000.00, 20000.00, 0.00, 3664000.00, 'paid', 'INV-7-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(4, 7, 30, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-03', '2025-06-10', 3100000.00, 100000.00, 364000.00, 60000.00, 644000.00, 100000.00, 20000.00, 0.00, 3744000.00, 'paid', 'INV-7-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(5, 7, 30, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-03', '2025-07-10', 3100000.00, 100000.00, 584000.00, 60000.00, 864000.00, 100000.00, 20000.00, 0.00, 3964000.00, 'paid', 'INV-7-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(6, 7, 30, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-03', '2025-08-10', 3100000.00, 100000.00, 292000.00, 60000.00, 572000.00, 100000.00, 20000.00, 0.00, 3672000.00, 'paid', 'INV-7-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(7, 14, 14, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-17', 3000000.00, 100000.00, 516000.00, 120000.00, 876000.00, 100000.00, 40000.00, 0.00, 3876000.00, 'paid', 'INV-14-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(8, 14, 14, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-17', 3000000.00, 100000.00, 476000.00, 360000.00, 1076000.00, 100000.00, 40000.00, 0.00, 4076000.00, 'paid', 'INV-14-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(9, 14, 14, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-17', 3000000.00, 100000.00, 632000.00, 160000.00, 1032000.00, 100000.00, 40000.00, 0.00, 4032000.00, 'paid', 'INV-14-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(10, 17, 40, 'Hóa đơn 03-2025', '03-2025', '2025-03-31', '2025-04-04', '2025-03-17', 3000000.00, 100000.00, 660000.00, 160000.00, 1060000.00, 100000.00, 40000.00, 0.00, 4060000.00, 'paid', 'INV-17-032025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(11, 17, 40, 'Hóa đơn 04-2025', '04-2025', '2025-04-30', '2025-05-04', '2025-04-17', 3000000.00, 100000.00, 568000.00, 160000.00, 968000.00, 100000.00, 40000.00, 0.00, 3968000.00, 'paid', 'INV-17-042025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(12, 17, 40, 'Hóa đơn 05-2025', '05-2025', '2025-05-31', '2025-06-04', '2025-05-17', 3000000.00, 100000.00, 336000.00, 300000.00, 876000.00, 100000.00, 40000.00, 0.00, 3876000.00, 'paid', 'INV-17-052025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(13, 17, 40, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-17', 3000000.00, 100000.00, 800000.00, 100000.00, 1140000.00, 100000.00, 40000.00, 0.00, 4140000.00, 'paid', 'INV-17-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(14, 17, 40, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-17', 3000000.00, 100000.00, 584000.00, 400000.00, 1224000.00, 100000.00, 40000.00, 0.00, 4224000.00, 'paid', 'INV-17-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(15, 17, 40, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-17', 3000000.00, 100000.00, 252000.00, 100000.00, 592000.00, 100000.00, 40000.00, 0.00, 3592000.00, 'paid', 'INV-17-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(16, 19, 21, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-17', 2800000.00, 100000.00, 580000.00, 200000.00, 1020000.00, 100000.00, 40000.00, 0.00, 3820000.00, 'paid', 'INV-19-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(17, 19, 21, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-17', 2800000.00, 100000.00, 336000.00, 400000.00, 976000.00, 100000.00, 40000.00, 0.00, 3776000.00, 'paid', 'INV-19-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(18, 19, 21, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-17', 2800000.00, 100000.00, 720000.00, 360000.00, 1320000.00, 100000.00, 40000.00, 0.00, 4120000.00, 'paid', 'INV-19-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(19, 30, 36, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-04', '2025-06-11', 4800000.00, 100000.00, 292000.00, 288000.00, 800000.00, 100000.00, 20000.00, 0.00, 5600000.00, 'paid', 'INV-30-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(20, 30, 36, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-04', '2025-07-11', 4800000.00, 100000.00, 712000.00, 162000.00, 1094000.00, 100000.00, 20000.00, 0.00, 5894000.00, 'paid', 'INV-30-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(21, 30, 36, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-04', '2025-08-11', 4800000.00, 100000.00, 376000.00, 180000.00, 776000.00, 100000.00, 20000.00, 0.00, 5576000.00, 'paid', 'INV-30-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(22, 33, 26, 'Hóa đơn 06-2025', '06-2025', '2025-06-30', '2025-07-05', '2025-06-11', 4000000.00, 100000.00, 644000.00, 108000.00, 972000.00, 100000.00, 20000.00, 0.00, 4972000.00, 'paid', 'INV-33-062025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(23, 33, 26, 'Hóa đơn 07-2025', '07-2025', '2025-07-31', '2025-08-05', '2025-07-11', 4000000.00, 100000.00, 633500.00, 180000.00, 1033500.00, 100000.00, 20000.00, 0.00, 5033500.00, 'paid', 'INV-33-072025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(24, 33, 26, 'Hóa đơn 08-2025', '08-2025', '2025-08-31', '2025-09-05', '2025-08-11', 4000000.00, 100000.00, 434000.00, 90000.00, 744000.00, 100000.00, 20000.00, 0.00, 4744000.00, 'paid', 'INV-33-082025', 'Hóa đơn tự động tạo từ dữ liệu sử dụng dịch vụ', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45');

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
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
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
  `payment_date` date NOT NULL DEFAULT '2025-12-14',
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
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `queue_jobs`
--

INSERT INTO `queue_jobs` (`id`, `job_class`, `job_data`, `priority`, `status`, `attempts`, `max_attempts`, `started_at`, `completed_at`, `queue_name`, `error_message`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Queue\\UploadImageOnCloud', '{\"post_id\":\"101\",\"images\":{\"name\":[\"thiet-ke-nha-tro-dep-2020-bandon-28.jpg\",\"thiet-ke-noi-that-phong-tro-16.jpg\"],\"type\":[\"image\\/jpeg\",\"image\\/jpeg\"],\"tmp_name\":[\"C:\\/xampp-v8.2\\/htdocs\\/Rental-management\\/temp_uploads\\/101\\/image_0_1765692821.jpg\",\"C:\\/xampp-v8.2\\/htdocs\\/Rental-management\\/temp_uploads\\/101\\/image_1_1765692821.jpg\"],\"error\":[0,0],\"size\":[185297,87764]}}', 3, 'completed', 0, 3, '2025-12-14 11:35:23', '2025-12-14 11:35:38', 'upload-image-on-cloud', NULL, 0, '2025-12-14 06:13:41', '2025-12-14 11:35:38'),
(2, 'Queue\\UploadImageOnCloud', '{\"post_id\":\"102\",\"images\":{\"name\":[\"can-tho.webp\",\"da-nang.webp\"],\"type\":[\"image\\/webp\",\"image\\/webp\"],\"tmp_name\":[\"C:\\/xampp-v8.2\\/htdocs\\/Rental-management\\/temp_uploads\\/102\\/image_0_1765712269.webp\",\"C:\\/xampp-v8.2\\/htdocs\\/Rental-management\\/temp_uploads\\/102\\/image_1_1765712269.webp\"],\"error\":[0,0],\"size\":[14066,54064]}}', 3, 'completed', 0, 3, '2025-12-14 11:37:58', '2025-12-14 11:38:03', 'upload-image-on-cloud', NULL, 0, '2025-12-14 11:37:49', '2025-12-14 11:38:03');

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
(3, 'Bãi đậu xe', 'active', 5, 0, NULL, NULL),
(4, 'Thang máy', 'active', NULL, 0, NULL, NULL),
(5, 'Camera an ninh', 'active', 3, 0, NULL, NULL),
(6, 'Giường tủ', 'active', NULL, 0, NULL, NULL),
(7, 'Bếp điện', 'active', NULL, 0, NULL, NULL),
(8, 'Ban công', 'active', 9, 0, NULL, NULL),
(9, 'Wifi miễn phí', 'active', 10, 0, NULL, NULL),
(10, 'Truyền hình cáp', 'active', NULL, 0, NULL, NULL),
(11, 'wifi', 'active', 8, 0, NULL, NULL),
(12, 'gara xe', 'active', NULL, 0, NULL, NULL),
(13, 'gác xép', 'active', 10, 0, NULL, NULL),
(14, 'gác lửng', 'active', 3, 0, NULL, NULL),
(15, 'có bảo vệ', 'active', NULL, 0, NULL, NULL),
(16, 'khóa vân tay', 'active', 2, 0, NULL, NULL),
(17, 'có giếng trời', 'active', NULL, 0, NULL, NULL),
(18, 'có sân vườn', 'active', 7, 0, NULL, NULL),
(19, 'có hồ bơi', 'active', 5, 0, NULL, NULL),
(20, 'có tầng thượng', 'active', NULL, 0, NULL, NULL),
(21, 'có tầng trệt', 'active', 4, 0, NULL, NULL),
(22, 'có tầng trên cùng', 'active', NULL, 0, NULL, NULL),
(23, 'có tầng dưới cùng', 'active', NULL, 0, NULL, NULL),
(24, 'có tầng giữa', 'active', NULL, 0, NULL, NULL),
(25, 'gần trung tâm', 'active', NULL, 0, NULL, NULL),
(26, 'gần chợ', 'active', NULL, 0, NULL, NULL),
(27, 'gần siêu thị', 'active', NULL, 0, NULL, NULL),
(28, 'gần trường học', 'active', NULL, 0, NULL, NULL),
(29, 'gần bệnh viện', 'active', NULL, 0, NULL, NULL),
(30, 'gần bến xe', 'active', 6, 0, NULL, NULL),
(31, 'gần bến xe bus', 'active', NULL, 0, NULL, NULL),
(32, 'gần bến xe taxi', 'active', NULL, 0, NULL, NULL),
(33, 'gần bến xe tải', 'active', NULL, 0, NULL, NULL),
(34, 'gần bến xe khách', 'active', 9, 0, NULL, NULL),
(35, 'Test tiện ích', 'active', 2, 0, '2025-12-14 12:20:09', '2025-12-14 12:20:09');

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
(1, 'Phòng trọ', 'active', 5, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(2, 'Căn hộ mini', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(3, 'Nhà nguyên căn', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(4, 'Chung cư', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(5, 'Văn phòng', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(6, 'Mặt bằng kinh doanh', 'active', 5, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(7, 'Nhà nghỉ', 'active', 10, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(8, 'Khách sạn', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(9, 'Homestay', 'active', 5, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(10, 'Ký túc xá', 'active', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_posts`
--

CREATE TABLE `rental_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `rental_category_id` bigint(20) UNSIGNED NOT NULL,
  `house_id` varchar(255) DEFAULT NULL,
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

INSERT INTO `rental_posts` (`id`, `owner_id`, `rental_category_id`, `house_id`, `rental_post_title`, `contact`, `phone`, `description`, `price`, `price_discount`, `rental_deposit`, `area`, `electric_fee`, `water_fee`, `max_number_of_people`, `stay_start_date`, `rental_amenities`, `rental_open_time`, `rental_close_time`, `province`, `ward`, `address`, `image_primary`, `images`, `status`, `approval_status`, `approval_reason`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 6, 2, NULL, 'Cho thuê căn hộ', 'Thôi Uyển', '0953081092', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 3657780.87, 1324691.94, 4182994.04, '21', 2827.86, 16108.70, 3, '2025-12-25', '[20,34,13,19,23]', '4:00', '14:00', 'TP Hồ Chí Minh', 'Phường 2', '3810 Phố Bồ Vân Việt', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(2, 1, 1, NULL, 'Cho thuê phòng trọ', 'Chú. Nghị Ngân', '0999555640', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 6197229.64, 666887.39, 3720552.65, '18', 2521.88, 14201.21, 4, '2025-11-11', '[9,10,31,30]', '16:00', '5:00', 'TP Hồ Chí Minh', 'Phường 7', '7 Phố Uyên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'inactive', 'approved', '-', 0, '2025-12-13 21:47:05', '2025-12-14 11:41:34'),
(3, 2, 1, NULL, 'Cho thuê căn hộ', 'Đường Hoa', '0932383069', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4073646.49, 3532178.05, 1464828.80, '29', 3702.51, 10813.16, 5, '2025-09-05', '[9,33,16]', '21:00', '23:00', 'Cần Thơ', 'Phường 11', '47 Phố Ong Hân Thời', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(4, 8, 1, NULL, 'Cho thuê nhà nguyên căn', 'Chú. Trần Bình', '0944548110', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 2465420.60, 2075718.79, 3893804.04, '44', 2639.63, 10137.04, 2, '2025-09-14', '[23,25,3,8]', '9:00', '22:00', 'Hải Phòng', 'Phường 9', '1817 Phố Trịnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'rejected', 'Velit sit et quis vitae.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(5, 3, 5, NULL, 'Cho thuê căn hộ', 'Bác. Hạ Phượng Hiền', '0957853483', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 4898888.25, 808303.45, 2710401.93, '40', 3182.97, 16416.34, 2, '2025-09-20', '[33,16,6]', '3:00', '21:00', 'Đà Nẵng', 'Phường 12', '35 Phố Bình Hậu Đan', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(6, 8, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chị. Tôn Nguyên Thanh', '0946740668', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1244965.03, 1013054.89, 1830280.40, '45', 3281.07, 11383.15, 1, '2025-11-18', '[24,29,19,27,12]', '22:00', '14:00', 'TP Hồ Chí Minh', 'Phường 12', '5 Phố Doãn Quảng Hoán', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'inactive', 'approved', 'Accusantium molestiae ea vel aut et non molestias.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(7, 7, 5, NULL, 'Cho thuê phòng trọ', 'Đan Oanh', '0987688601', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6537380.14, 6001118.22, 3118306.69, '48', 3662.64, 10791.55, 1, '2025-10-01', '[7,27,21,14]', '12:00', '2:00', 'Hà Nội', 'Phường 5', '54 Phố Mã Quảng Ánh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(8, 4, 4, NULL, 'Cho thuê nhà nguyên căn', 'Ngân Vỹ', '0927964116', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 6572961.19, 6135087.99, 2697960.73, '19', 3214.33, 15170.62, 4, '2025-09-15', '[27,13,12]', '11:00', '13:00', 'TP Hồ Chí Minh', 'Phường 2', '4 Phố Khuất Minh Nương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'approved', 'Ab repudiandae dolore quis fugit illum voluptas et enim.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(9, 9, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Em. Trang Kim Tiền', '0962396140', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8008445.07, 6559169.06, 2551822.61, '45', 3182.36, 10200.50, 6, '2025-10-28', '[24,9,16,17,1]', '19:00', '8:00', 'Hải Phòng', 'Phường 10', '5331 Phố Vinh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'rejected', 'Quos error cum voluptate optio omnis.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(10, 1, 5, NULL, 'Cho thuê mặt bằng kinh doanh', 'Hoa Lương Vương', '0982072713', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 4891459.10, 619856.67, 3214107.19, '17', 2590.27, 19354.26, 6, '2025-12-23', '[34,33,14,6]', '20:00', '7:00', 'Hải Phòng', 'Phường 10', '5852 Phố Doãn Lộ Kiều', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', 'Possimus blanditiis corporis reprehenderit error velit dicta aut.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(11, 2, 4, NULL, 'Cho thuê nhà nguyên căn', 'Em. Đặng Đình', '0999737583', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 7311857.96, 2046677.45, 1996827.70, '47', 3819.21, 10836.39, 6, '2025-12-20', '[34,16,15]', '3:00', '21:00', 'Cần Thơ', 'Phường 1', '31 Phố Lệ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-14 11:57:51'),
(12, 9, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Cô. Trình Sa', '0935537838', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 4717175.11, 1192525.27, 4679653.36, '21', 3324.21, 18357.03, 6, '2025-12-19', '[17,26,7,14,9]', '6:00', '12:00', 'Hải Phòng', 'Phường 4', '7 Phố Xa', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(13, 10, 5, NULL, 'Cho thuê nhà nguyên căn', 'Em. Đái Chế Định', '0977811216', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3247918.65, 849662.17, 1173453.53, '28', 3955.34, 12237.43, 6, '2025-11-22', '[32,16,4,6,2]', '5:00', '23:00', 'TP Hồ Chí Minh', 'Phường 7', '5030 Phố Vương Thoại Thảo', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(14, 10, 3, NULL, 'Cho thuê căn hộ', 'Anh. Sử Hồng', '0964122447', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 7486401.18, 3777050.79, 2861034.96, '15', 3546.30, 10954.85, 2, '2025-09-29', '[16,4,14]', '18:00', '4:00', 'Cần Thơ', 'Phường 5', '276 Phố Thanh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(15, 9, 2, NULL, 'Cho thuê nhà nguyên căn', 'Vũ Phi', '0991541374', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 8682087.71, 6475513.97, 4248890.40, '15', 3976.61, 18143.59, 4, '2025-10-03', '[10,13]', '0:00', '0:00', 'Hà Nội', 'Phường 7', '2599 Phố Nghĩa', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(16, 3, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Đặng Dao', '0932639657', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7648558.04, 3807863.94, 2803426.10, '33', 3306.63, 17751.08, 2, '2025-10-28', '[20,28,23,5]', '15:00', '19:00', 'TP Hồ Chí Minh', 'Phường 5', '633 Phố Phạm Cơ Ngôn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'approved', 'Consequatur qui reprehenderit maxime ut iusto autem veniam.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(17, 1, 2, NULL, 'Cho thuê nhà nguyên căn', 'Doãn Diễm Trinh', '0913507581', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 8197170.59, 6660991.83, 3742273.59, '43', 3995.44, 18586.08, 1, '2025-11-25', '[6,16,11]', '4:00', '6:00', 'TP Hồ Chí Minh', 'Phường 7', '6 Phố Cự Đức Ngân', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(18, 5, 3, NULL, 'Cho thuê căn hộ', 'Đoàn Nguyên Ca', '0985298733', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 7356582.61, 1618013.57, 1010814.17, '31', 2669.38, 16811.69, 6, '2025-12-11', '[22,14]', '23:00', '12:00', 'TP Hồ Chí Minh', 'Phường 4', '2 Phố Sử Chung Cầm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(19, 5, 5, NULL, 'Cho thuê nhà nguyên căn', 'Kiều Phước Hỷ', '0994972323', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 5916493.36, 3944573.68, 3547766.60, '24', 3363.17, 15169.42, 3, '2025-12-02', '[1,29,33]', '6:00', '7:00', 'Hà Nội', 'Phường 3', '4127 Phố Lộc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(20, 1, 2, NULL, 'Cho thuê căn hộ', 'Sử Kiệt Mạnh', '0934583317', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 2251199.00, 1821819.06, 1231160.66, '20', 3740.62, 19982.51, 3, '2025-10-24', '[25,30]', '5:00', '10:00', 'Hà Nội', 'Phường 5', '695 Phố Bùi Thanh Lộ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'rejected', 'Asperiores quia iure ipsum ratione et consectetur.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(21, 1, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chế Huệ', '0984626705', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 8546992.59, 7566952.32, 2626934.51, '18', 3552.92, 15283.70, 4, '2025-10-31', '[33,10,29]', '17:00', '2:00', 'Hải Phòng', 'Phường 11', '28 Phố Hoa', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'approved', 'Sed cumque quas incidunt sint similique omnis qui.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(22, 7, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Bùi Hội', '0941468745', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2118594.98, 1690572.06, 4669800.29, '22', 3167.87, 18791.37, 5, '2025-10-23', '[25,30,17,20,15]', '18:00', '8:00', 'Hải Phòng', 'Phường 5', '40 Phố Đường Định Bảo', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(23, 8, 3, NULL, 'Cho thuê căn hộ', 'Bà. Nông Sương Mỹ', '0979701110', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 7759436.61, 725786.09, 2824484.34, '28', 3888.84, 18817.16, 5, '2025-09-28', '[18,27,23]', '19:00', '8:00', 'Cần Thơ', 'Phường 8', '388 Phố Việt', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(24, 7, 5, NULL, 'Cho thuê căn hộ', 'Cấn Kim', '0966041846', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 1231590.99, 1058444.96, 3854688.27, '24', 3370.83, 13874.17, 5, '2025-12-12', '[17,2,4,25]', '16:00', '14:00', 'Cần Thơ', 'Phường 9', '5905 Phố Đồng Luận Phong', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'rejected', 'Sit harum facere aut impedit esse.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(25, 4, 4, NULL, 'Cho thuê nhà nguyên căn', 'Em. Khưu Khoa Đan', '0916638177', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6385473.30, 6293190.50, 1610119.23, '50', 3621.69, 11772.55, 4, '2025-11-06', '[26,2]', '13:00', '8:00', 'TP Hồ Chí Minh', 'Phường 6', '3 Phố Chu Thảo Thanh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(26, 4, 5, NULL, 'Cho thuê phòng trọ', 'Tông Uyển', '0933698814', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 6962002.03, 5005200.36, 581217.77, '44', 2634.22, 19789.78, 4, '2025-12-04', '[20,18,33]', '11:00', '15:00', 'Hà Nội', 'Phường 1', '63 Phố Ma Khánh Quân', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'approved', 'Deleniti deleniti repellat sint porro.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(27, 10, 3, NULL, 'Cho thuê phòng trọ', 'Cô. Đỗ Chung', '0998306352', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 9581847.85, 4521473.38, 1365204.51, '45', 3928.09, 10222.68, 6, '2025-11-06', '[34,2]', '22:00', '13:00', 'Hải Phòng', 'Phường 8', '8922 Phố Nguyễn Ánh Hợp', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'pending', 'Est aut iusto maxime doloremque.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(28, 6, 2, NULL, 'Cho thuê phòng trọ', 'Em. Thào Hòa', '0931570451', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 2533307.30, 1565289.19, 3176328.32, '47', 3365.29, 14264.82, 2, '2025-10-01', '[23,34,27,21]', '19:00', '11:00', 'Đà Nẵng', 'Phường 10', '435 Phố Hứa Thương Luật', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(29, 9, 5, NULL, 'Cho thuê mặt bằng kinh doanh', 'Em. Lưu Diệp', '0991845218', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4489335.35, 705519.77, 4630372.42, '50', 2987.51, 10305.95, 4, '2025-12-25', '[23,11,7,13]', '2:00', '3:00', 'Cần Thơ', 'Phường 5', '7893 Phố Vương Lân Nhượng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(30, 5, 1, NULL, 'Cho thuê nhà nguyên căn', 'Bác. Thiều Lực', '0934635704', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4386693.14, 959505.36, 841231.23, '16', 3273.84, 13496.25, 4, '2025-11-20', '[9,25,11]', '16:00', '13:00', 'Hải Phòng', 'Phường 8', '251 Phố Cam Hiếu Mẫn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', 'Itaque consequuntur dolor eius unde dignissimos rerum.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(31, 2, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Lỳ Lan', '0975991291', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 2910842.33, 787168.46, 689768.56, '34', 3025.39, 14579.84, 2, '2025-11-29', '[29,26,24]', '4:00', '14:00', 'Hải Phòng', 'Phường 8', '74 Phố Ong Ca Phượng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'active', 'approved', 'Corporis nihil porro odit dolor repellendus.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(32, 10, 4, NULL, 'Cho thuê phòng trọ', 'Phương Ái', '0941878038', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7482308.90, 5050223.90, 3359072.03, '16', 3930.36, 15618.77, 6, '2025-11-27', '[18,27,1,32,14]', '21:00', '15:00', 'TP Hồ Chí Minh', 'Phường 12', '45 Phố Bạc Diệp Uyển', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(33, 4, 4, NULL, 'Cho thuê căn hộ', 'Anh. Cự Quốc Trung', '0995743238', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 2271030.00, 2004786.70, 3452353.83, '18', 3738.11, 16005.01, 2, '2025-11-13', '[3,33,19]', '9:00', '2:00', 'Cần Thơ', 'Phường 8', '5362 Phố Giang Đại Trầm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(34, 2, 1, NULL, 'Cho thuê nhà nguyên căn', 'Khương Mai', '0936205891', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3636399.97, 2016095.75, 4166928.23, '23', 3639.30, 19544.68, 1, '2025-09-30', '[23,6]', '8:00', '2:00', 'Đà Nẵng', 'Phường 8', '7 Phố Lạc Ái Sang', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(35, 6, 2, NULL, 'Cho thuê nhà nguyên căn', 'Cô. Ty Ý Cúc', '0941868861', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2303493.07, 1028420.30, 3463553.63, '16', 3000.73, 13501.45, 3, '2025-11-09', '[3,5]', '5:00', '20:00', 'Đà Nẵng', 'Phường 1', '8 Phố La', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(36, 4, 4, NULL, 'Cho thuê căn hộ', 'Châu Mỹ Trầm', '0925750741', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1402033.66, 1322217.02, 2723465.46, '34', 2545.86, 12634.34, 2, '2025-10-01', '[6,32,13,8]', '5:00', '10:00', 'Cần Thơ', 'Phường 5', '6843 Phố Xuân', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(37, 9, 1, NULL, 'Cho thuê phòng trọ', 'Lạc Ngôn', '0992147915', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8475530.50, 7836308.31, 1902402.04, '38', 3657.36, 14151.62, 5, '2025-12-16', '[7,10,32]', '1:00', '12:00', 'Hà Nội', 'Phường 2', '194 Phố Lỡ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'rejected', 'Voluptas repellendus ut sapiente expedita nostrum quam voluptatem.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(38, 9, 5, NULL, 'Cho thuê căn hộ', 'Ông. Bạch Điệp', '0972090931', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 1680668.48, 809758.98, 2155524.41, '49', 2517.34, 19034.81, 6, '2025-11-10', '[14,27,25,32]', '17:00', '16:00', 'Đà Nẵng', 'Phường 5', '47 Phố Lều', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(39, 9, 4, NULL, 'Cho thuê phòng trọ', 'Anh. Hàng Đinh Khánh', '0969534433', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1501127.21, 713348.46, 526547.01, '25', 3234.57, 15104.04, 4, '2025-11-06', '[6,27,4,7]', '2:00', '7:00', 'Cần Thơ', 'Phường 4', '4 Phố Đỗ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(40, 10, 5, NULL, 'Cho thuê căn hộ', 'Cô. Tôn Hiếu', '0944330197', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 7960892.65, 7640472.28, 1706409.74, '35', 2903.98, 14363.24, 3, '2025-11-07', '[1,30,26,9]', '3:00', '19:00', 'Hải Phòng', 'Phường 1', '7 Phố Lã Nguyên Nhạn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(41, 6, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Em. Khương Linh Hoan', '0954604384', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 2941558.80, 1713696.98, 4615745.87, '28', 3163.40, 15264.74, 1, '2025-11-02', '[20,6,22,1]', '17:00', '1:00', 'Hải Phòng', 'Phường 6', '21 Phố Uông Phúc Hành', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(42, 5, 1, NULL, 'Cho thuê nhà nguyên căn', 'Cụ. Cấn Bằng', '0941099436', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 3638334.64, 2604679.26, 1938571.86, '41', 3054.70, 11574.56, 6, '2025-11-28', '[1,34,10]', '0:00', '7:00', 'Hải Phòng', 'Phường 4', '668 Phố Vũ Thắm Ẩn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(43, 4, 2, NULL, 'Cho thuê phòng trọ', 'Chú. Khổng Sĩ', '0959162334', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4325527.62, 1016887.30, 2007598.54, '30', 2869.16, 10613.63, 6, '2025-12-28', '[30,10,15]', '9:00', '6:00', 'Hà Nội', 'Phường 9', '15 Phố Bùi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(44, 5, 1, NULL, 'Cho thuê phòng trọ', 'Cụ. Trần Tùy Đoan', '0935115499', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7110379.42, 5823944.47, 3728609.86, '36', 2785.14, 10076.81, 1, '2025-11-03', '[25,14,16,21]', '0:00', '21:00', 'Hà Nội', 'Phường 4', '9 Phố Tạ Hoài Hạnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'rejected', 'Voluptatem sunt dolor occaecati natus assumenda.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(45, 4, 5, NULL, 'Cho thuê mặt bằng kinh doanh', 'Em. Chu Diệp', '0985412450', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 1316498.12, 737002.53, 2070999.14, '27', 3146.34, 15818.09, 4, '2025-09-12', '[22,23,19]', '4:00', '4:00', 'Hải Phòng', 'Phường 9', '3 Phố Bảo Thy Thy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(46, 10, 3, NULL, 'Cho thuê nhà nguyên căn', 'Nhữ Kiên', '0989822283', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 8185755.37, 3131921.97, 1624576.37, '39', 3208.81, 19639.28, 3, '2025-10-07', '[13,30,19,4]', '2:00', '6:00', 'Cần Thơ', 'Phường 10', '4979 Phố Bồ Quốc Phi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(47, 5, 5, NULL, 'Cho thuê nhà nguyên căn', 'Cụ. Nhậm Nhất Khải', '0937243129', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 5404780.94, 2324752.24, 3234662.04, '15', 3243.91, 11697.75, 6, '2025-11-15', '[18,13]', '7:00', '0:00', 'TP Hồ Chí Minh', 'Phường 9', '7 Phố Lã Khiêm Dao', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(48, 5, 4, NULL, 'Cho thuê phòng trọ', 'Ong Đại Hiển', '0984479501', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 7470400.61, 652447.14, 4178178.32, '45', 3177.72, 15511.37, 1, '2025-10-03', '[34,16,10,23,30]', '20:00', '3:00', 'Cần Thơ', 'Phường 7', '208 Phố Diệp Kiếm Đài', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(49, 1, 1, NULL, 'Cho thuê phòng trọ', 'Chú. Hạ Chuẩn Vượng', '0962065372', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 7185527.59, 2664402.61, 2094165.63, '45', 2755.79, 17796.83, 6, '2025-11-05', '[14,15,23,31,5]', '5:00', '16:00', 'Cần Thơ', 'Phường 10', '1771 Phố Nhậm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(50, 6, 5, NULL, 'Cho thuê căn hộ', 'Ông. Hàng Châu', '0975456978', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 5421408.44, 1045422.73, 4800789.82, '25', 3266.76, 15812.55, 4, '2025-10-21', '[12,33,18,31,1]', '4:00', '7:00', 'Đà Nẵng', 'Phường 1', '54 Phố Nông Miên Khê', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'pending', 'Libero voluptatem optio temporibus fugiat in ipsum.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(51, 1, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Bà. Phí Ánh', '0952092062', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 6258599.75, 5628552.87, 3711261.35, '43', 2998.63, 11823.07, 3, '2025-09-15', '[23,1,4,24,19]', '19:00', '15:00', 'TP Hồ Chí Minh', 'Phường 10', '2 Phố Lạc Hiên Lâm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(52, 8, 2, NULL, 'Cho thuê nhà nguyên căn', 'Em. Hàng Duyên', '0913949140', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5225540.23, 2324523.20, 4554724.75, '50', 2526.47, 10184.03, 4, '2025-10-15', '[27,2,30,18]', '5:00', '1:00', 'Đà Nẵng', 'Phường 5', '4 Phố Từ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(53, 6, 5, NULL, 'Cho thuê mặt bằng kinh doanh', 'Phan Thanh Hạ', '0914689208', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 5802666.75, 4340173.40, 3725620.84, '49', 3617.78, 14781.02, 2, '2025-09-16', '[7,29,10,24]', '5:00', '22:00', 'TP Hồ Chí Minh', 'Phường 7', '3143 Phố Dương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'pending', 'Saepe necessitatibus perspiciatis iusto odio.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(54, 6, 1, NULL, 'Cho thuê nhà nguyên căn', 'Chú. Lạc Việt', '0943493681', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 2228990.04, 1070036.53, 1244364.86, '50', 3095.23, 12855.98, 5, '2025-12-08', '[7,22,23,2,16]', '22:00', '16:00', 'Hà Nội', 'Phường 12', '16 Phố Lê Lợi Phượng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(55, 3, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chú. Lê Bình Hành', '0956830258', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 3654362.90, 3459940.51, 2871478.50, '33', 3205.08, 13765.90, 6, '2025-10-26', '[13,11,33,26,31]', '10:00', '1:00', 'Đà Nẵng', 'Phường 5', '4 Phố Chiêm Nhân Lam', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(56, 3, 2, NULL, 'Cho thuê căn hộ', 'Anh. Cự Hạnh Thể', '0921332888', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 2129636.49, 1843065.91, 2005989.28, '34', 2755.97, 11733.35, 5, '2025-12-07', '[34,21]', '16:00', '3:00', 'Hải Phòng', 'Phường 6', '4282 Phố Thiều Quế Hải', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(57, 10, 2, NULL, 'Cho thuê phòng trọ', 'Viên Bạch Ngôn', '0950813469', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2849938.91, 2079454.35, 4720569.78, '42', 2691.98, 11349.73, 1, '2025-12-20', '[29,33]', '1:00', '1:00', 'Hải Phòng', 'Phường 9', '7 Phố Mâu Trung Hiển', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(58, 7, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Sơn Lan', '0938351672', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 9827903.07, 661680.18, 4945651.51, '40', 3226.52, 11252.95, 3, '2025-10-25', '[18,3]', '5:00', '22:00', 'TP Hồ Chí Minh', 'Phường 9', '864 Phố Bành Mi Bình', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'active', 'approved', 'Non sit ut eaque qui harum.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(59, 6, 3, NULL, 'Cho thuê phòng trọ', 'Chị. Uông Phi', '0980430191', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 6511250.16, 3141876.34, 4303602.61, '21', 3021.99, 17840.41, 6, '2025-10-19', '[21,22,14]', '14:00', '16:00', 'TP Hồ Chí Minh', 'Phường 9', '11 Phố Nghiêm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', 'Ea officiis sed molestias ea et.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(60, 3, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Tòng Hội', '0991198389', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1529974.54, 738079.82, 3095061.25, '44', 3489.97, 13810.35, 6, '2025-09-26', '[34,26,5]', '8:00', '22:00', 'Hải Phòng', 'Phường 12', '693 Phố Ông Việt Cát', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(61, 1, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'An San', '0918040692', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 1406875.24, 1331891.16, 2083496.96, '21', 3400.66, 15159.51, 4, '2025-12-26', '[26,7,33,17,23]', '19:00', '20:00', 'Hải Phòng', 'Phường 11', '1 Phố Nhiệm Chiến Đình', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(62, 10, 4, NULL, 'Cho thuê căn hộ', 'An Ý', '0972660833', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 4016314.33, 964514.28, 1808101.48, '28', 3180.95, 14695.50, 6, '2025-11-13', '[14,13,1,17,16]', '1:00', '4:00', 'Đà Nẵng', 'Phường 3', '84 Phố Văn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(63, 5, 5, NULL, 'Cho thuê mặt bằng kinh doanh', 'Nhậm Thực', '0964708133', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 2078107.62, 722160.56, 604541.09, '47', 3648.24, 11326.57, 5, '2025-09-14', '[19,18]', '20:00', '6:00', 'Hải Phòng', 'Phường 5', '9 Phố Dư Hoàn Đan', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'pending', 'Temporibus officia ducimus ut in quo itaque vitae.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(64, 10, 1, NULL, 'Cho thuê phòng trọ', 'Em. Nghiêm Phương', '0967225682', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 8595986.25, 6958295.27, 782571.35, '23', 3494.87, 17655.21, 3, '2025-10-31', '[28,4,3,12]', '5:00', '23:00', 'Hải Phòng', 'Phường 11', '2 Phố Tôn Chiêu Vũ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(65, 5, 2, NULL, 'Cho thuê nhà nguyên căn', 'Em. Lạc Thuận', '0932343867', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 9911205.93, 6100983.67, 1710473.53, '15', 3885.38, 11445.50, 3, '2025-12-18', '[10,5,19,31]', '19:00', '19:00', 'Hà Nội', 'Phường 2', '4610 Phố Quyên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(66, 2, 4, NULL, 'Cho thuê nhà nguyên căn', 'Bà. Khưu Huệ', '0915240328', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1618544.51, 1483681.15, 4917914.95, '40', 3662.75, 17179.27, 5, '2025-09-01', '[9,1,23,20]', '2:00', '17:00', 'Hà Nội', 'Phường 4', '7428 Phố Phí', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\"]', 'inactive', 'pending', 'Est blanditiis ducimus dignissimos praesentium accusantium.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(67, 10, 4, NULL, 'Cho thuê phòng trọ', 'Cụ. Lê Chấn', '0997152703', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1627874.17, 1102945.60, 1221400.42, '42', 3831.47, 11433.58, 1, '2025-10-29', '[19,3,11]', '16:00', '4:00', 'Hà Nội', 'Phường 12', '6387 Phố Đoan', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(68, 8, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chị. Đoàn Thy Tú', '0959388859', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1067015.79, 1050518.58, 1306008.92, '27', 3357.06, 13564.63, 4, '2025-10-08', '[23,25]', '13:00', '11:00', 'Đà Nẵng', 'Phường 6', '280 Phố Kiên', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'rejected', 'Et officia aliquam sit sed hic cupiditate.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(69, 5, 2, NULL, 'Cho thuê căn hộ', 'Trác My', '0982164037', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 7660759.74, 4393620.11, 4711839.46, '28', 2662.75, 14095.06, 1, '2025-11-19', '[11,32,21,16,34]', '22:00', '10:00', 'TP Hồ Chí Minh', 'Phường 11', '27 Phố Trình Nhật Dương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\"]', 'active', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(70, 6, 5, NULL, 'Cho thuê nhà nguyên căn', 'Cụ. Nhậm Liễu', '0998757002', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 9363701.81, 8085171.08, 3121123.13, '16', 3921.87, 15004.90, 2, '2025-11-20', '[19,32]', '5:00', '20:00', 'TP Hồ Chí Minh', 'Phường 7', '6 Phố Võ Minh Tráng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'rejected', 'Reprehenderit provident quasi accusantium quo.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(71, 7, 2, NULL, 'Cho thuê căn hộ', 'Thi Lương Kha', '0975057685', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 3068820.38, 651937.39, 4256094.97, '15', 3133.10, 13211.19, 6, '2025-09-16', '[16,11,12,33]', '21:00', '3:00', 'Hà Nội', 'Phường 6', '8914 Phố Dương Nguyên Thịnh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(72, 5, 2, NULL, 'Cho thuê phòng trọ', 'Cụ. Vi Mai Nguyên', '0955591508', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5561947.17, 2125630.26, 2466287.48, '27', 3727.55, 14909.54, 3, '2025-12-07', '[2,30,10,22]', '14:00', '15:00', 'Hải Phòng', 'Phường 5', '49 Phố Đoàn Dao Thúc', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'inactive', 'pending', 'Sunt molestiae aut est asperiores et ipsa deleniti.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(73, 6, 3, NULL, 'Cho thuê mặt bằng kinh doanh', 'Thiều Tráng', '0970431669', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 7007145.70, 2660889.53, 4216166.74, '25', 3730.14, 11893.86, 4, '2025-11-02', '[18,4,21,22]', '22:00', '10:00', 'Hà Nội', 'Phường 4', '2 Phố Đồng Lập Đồng', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(74, 9, 2, NULL, 'Cho thuê căn hộ', 'Cái Hợp', '0953238656', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5738496.60, 4368903.37, 1175788.89, '39', 2993.05, 16593.88, 2, '2025-09-19', '[33,13,20,21,24]', '23:00', '7:00', 'TP Hồ Chí Minh', 'Phường 3', '2 Phố Phương Trinh Cơ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'rejected', 'Vero magnam rerum qui recusandae.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05');
INSERT INTO `rental_posts` (`id`, `owner_id`, `rental_category_id`, `house_id`, `rental_post_title`, `contact`, `phone`, `description`, `price`, `price_discount`, `rental_deposit`, `area`, `electric_fee`, `water_fee`, `max_number_of_people`, `stay_start_date`, `rental_amenities`, `rental_open_time`, `rental_close_time`, `province`, `ward`, `address`, `image_primary`, `images`, `status`, `approval_status`, `approval_reason`, `deleted`, `created_at`, `updated_at`) VALUES
(75, 4, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Khâu Trang', '0989055319', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2666908.95, 1802958.72, 4646207.27, '37', 3743.51, 14873.63, 6, '2025-10-25', '[7,11]', '7:00', '23:00', 'Đà Nẵng', 'Phường 8', '617 Phố Nữ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\"]', 'active', 'pending', 'Quaerat illum debitis incidunt aut nostrum.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(76, 10, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chị. Lư Uyên Linh', '0924849593', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7833662.29, 6757411.44, 1308417.10, '26', 2546.99, 19821.28, 4, '2025-09-23', '[22,8,15,18]', '0:00', '22:00', 'Hải Phòng', 'Phường 2', '7 Phố Trình Hoa Trinh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'active', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(77, 2, 1, NULL, 'Cho thuê nhà nguyên căn', 'Em. Lò Duệ', '0991724982', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 3916600.51, 2067719.20, 2808706.60, '30', 3643.25, 18088.41, 5, '2025-11-10', '[20,17,24]', '14:00', '20:00', 'Hà Nội', 'Phường 7', '1151 Phố Nhữ Liên Thu', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'pending', 'Ad dolores officia maiores culpa dolorum nisi.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(78, 4, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chị. Tiếp Hoa', '0951192058', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6423648.57, 1080682.42, 1643981.75, '27', 2812.03, 18389.29, 6, '2025-09-08', '[16,33,8,29]', '10:00', '4:00', 'Hà Nội', 'Phường 8', '631 Phố Chiêm Sinh Hành', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(79, 10, 1, NULL, 'Cho thuê phòng trọ', 'Cô. Khâu Hạ', '0920311042', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 4923570.21, 1220436.65, 4611855.83, '27', 3562.00, 14975.64, 2, '2025-12-10', '[16,4,33]', '5:00', '13:00', 'Hà Nội', 'Phường 1', '1298 Phố Mẫn Diễm Vy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'approved', 'Architecto velit fugiat facilis blanditiis dolorem.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(80, 6, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chị. Chiêm Hoài', '0987302575', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4439519.92, 541809.79, 2951254.61, '46', 3123.53, 15337.77, 1, '2025-12-17', '[1,32,14,6,27]', '20:00', '22:00', 'Hải Phòng', 'Phường 7', '967 Phố Ông Hợp Vỹ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/tbgn4z5akwfioas2ot1x.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'active', 'approved', 'Labore laborum aut ut molestiae.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(81, 1, 1, NULL, 'Cho thuê nhà nguyên căn', 'Khoa Thiện Sinh', '0935395157', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2951405.46, 774364.40, 2445533.35, '18', 3768.06, 18817.60, 4, '2025-09-16', '[12,34,31,6,20]', '6:00', '14:00', 'Hà Nội', 'Phường 4', '907 Phố Hàn Ái Cơ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'approved', 'Non in praesentium qui rerum rerum quidem.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(82, 8, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Ngụy Hiền', '0987190399', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 7538942.00, 6895017.52, 2065658.21, '25', 2732.21, 18626.57, 2, '2025-10-16', '[5,33,29]', '20:00', '15:00', 'Đà Nẵng', 'Phường 4', '909 Phố Khuất Đoàn Chi', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(83, 7, 1, NULL, 'Cho thuê mặt bằng kinh doanh', 'Cô. Thi Sa', '0916139677', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 6254709.96, 2246190.43, 2936753.81, '41', 3107.66, 12823.74, 6, '2025-09-24', '[34,24,1]', '13:00', '4:00', 'TP Hồ Chí Minh', 'Phường 7', '816 Phố Phong', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\"]', 'inactive', 'pending', 'Sapiente illum autem non minus laborum dolores reiciendis.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(84, 4, 3, NULL, 'Cho thuê căn hộ', 'Bác. Chương Đan', '0995487269', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 1913430.43, 1623986.04, 4170056.39, '48', 3096.42, 10440.72, 4, '2025-09-29', '[3,26,8,15]', '17:00', '16:00', 'TP Hồ Chí Minh', 'Phường 9', '493 Phố Chế', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/td9q8yxmselfsljn2qfv.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'rejected', 'Iste nemo blanditiis unde ipsum corrupti eius.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(85, 2, 3, NULL, 'Cho thuê phòng trọ', 'Giả Huân Tuệ', '0936621287', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5145747.32, 4180597.25, 2977425.54, '35', 2680.27, 12529.31, 6, '2025-09-30', '[11,16,27,28]', '8:00', '3:00', 'TP Hồ Chí Minh', 'Phường 10', '8 Phố Doãn Phúc Ái', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/a0h7eqcery81j8rzvbfh.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/tbgn4z5akwfioas2ot1x.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(86, 10, 3, NULL, 'Cho thuê nhà nguyên căn', 'Chị. An Thảo', '0975917559', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 5228685.93, 4880650.07, 4991973.17, '41', 3973.42, 12141.12, 2, '2025-09-06', '[5,17,7,15]', '20:00', '5:00', 'Hải Phòng', 'Phường 1', '28 Phố Đinh Vỹ Dao', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/iawliwtcby0d7ur5xlkf.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(87, 3, 1, NULL, 'Cho thuê nhà nguyên căn', 'Đào Quang', '0910130701', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 1661034.02, 1524772.09, 3208704.46, '46', 2978.16, 16926.15, 3, '2025-11-27', '[33,23,28,5,27]', '13:00', '23:00', 'TP Hồ Chí Minh', 'Phường 3', '830 Phố Nương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/fozg3kiqaicdupbrvtfe.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'inactive', 'rejected', 'Harum molestiae quibusdam ea ut minus voluptates vitae molestiae.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(88, 3, 2, NULL, 'Cho thuê căn hộ', 'Bác. Khưu Dã Chiêu', '0923500328', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 5655207.28, 3246455.81, 3867799.92, '19', 2806.13, 11149.65, 2, '2025-09-19', '[22,33]', '7:00', '5:00', 'Hải Phòng', 'Phường 7', '369 Phố Bàng Thuận Hà', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/vusxz6nqycqhpvl4cyou.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(89, 6, 5, NULL, 'Cho thuê căn hộ', 'Bà. Ung Nga', '0960148324', 'Phòng sạch sẽ, thoáng mát, gần chợ và siêu thị.', 1230627.37, 1164169.92, 1328763.00, '28', 3905.25, 15858.87, 2, '2025-11-28', '[19,4,26,2,7]', '23:00', '0:00', 'Hà Nội', 'Phường 1', '96 Phố Trác Nhuận Đình', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(90, 4, 5, NULL, 'Cho thuê phòng trọ', 'Mã Quỳnh Dương', '0975183083', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 6750905.73, 4112618.20, 4824243.58, '43', 3620.79, 17925.75, 5, '2025-11-23', '[1,23,12,15]', '8:00', '10:00', 'Hải Phòng', 'Phường 5', '59 Phố Trạch', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/a0h7eqcery81j8rzvbfh.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/td9q8yxmselfsljn2qfv.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(91, 10, 2, NULL, 'Cho thuê phòng trọ', 'Hoàng Hoàn Khánh', '0952082240', 'Phòng trọ có ban công, view đẹp, an ninh tốt.', 6376126.75, 2514264.34, 4496753.35, '42', 3879.80, 19154.31, 4, '2025-12-07', '[28,29,6]', '20:00', '20:00', 'Hà Nội', 'Phường 9', '186 Phố Cao Hậu Linh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/fozg3kiqaicdupbrvtfe.jpg\"]', 'inactive', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(92, 2, 3, NULL, 'Cho thuê phòng trọ', 'Cô. Phi Ý', '0963602870', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 2590127.33, 2282875.18, 2806488.05, '21', 3975.13, 11916.95, 6, '2025-10-20', '[34,10,3]', '12:00', '8:00', 'Hà Nội', 'Phường 11', '6 Phố Lều', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'approved', 'Voluptas voluptas nostrum qui.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(93, 8, 3, NULL, 'Cho thuê căn hộ', 'Cụ. Ngụy Lục Lâm', '0938782157', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 7161621.16, 1197645.29, 1835713.41, '34', 3876.56, 15222.94, 3, '2025-11-13', '[19,14,28,17,18]', '14:00', '8:00', 'TP Hồ Chí Minh', 'Phường 9', '802 Phố Tạ', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bjlm5br8kvnl2dw2e9nn.jpg\"]', 'active', 'pending', 'Et totam voluptatem perspiciatis.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(94, 9, 5, NULL, 'Cho thuê nhà nguyên căn', 'Cụ. Quản Chính', '0959021114', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8474346.83, 1261825.83, 4534950.60, '39', 2773.15, 14858.74, 5, '2025-10-07', '[26,8]', '2:00', '9:00', 'Cần Thơ', 'Phường 7', '8176 Phố Hán Hoa Khánh', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/qm8jncopsasdgqndyk16.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/vusxz6nqycqhpvl4cyou.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(95, 6, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Bà. Giao Nhan Băng', '0952917401', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 4336798.71, 3689332.96, 1349177.84, '35', 3166.02, 18128.36, 2, '2025-10-11', '[24,2,33]', '20:00', '5:00', 'Hải Phòng', 'Phường 2', '149 Phố Thủy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bpwndpmnzfupqoixkgje.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'inactive', 'approved', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(96, 2, 3, NULL, 'Cho thuê căn hộ', 'Em. Kha Như Điệp', '0990391190', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4580013.93, 3471676.01, 4413821.35, '46', 2636.12, 17577.95, 6, '2025-12-24', '[21,11,2,32]', '10:00', '3:00', 'Đà Nẵng', 'Phường 8', '87 Phố Bảo Ngạn Toàn', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/iawliwtcby0d7ur5xlkf.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/ol1nrtvguwmot9q93hoa.jpg\"]', 'active', 'approved', 'Dolore repudiandae distinctio deleniti doloribus dolorem.', 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(97, 4, 2, NULL, 'Cho thuê mặt bằng kinh doanh', 'Chú. Khoa An Thúc', '0952963260', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 8817558.35, 4019429.31, 3490007.60, '39', 3779.06, 13064.56, 6, '2025-10-21', '[27,31,19,32,10]', '22:00', '0:00', 'Cần Thơ', 'Phường 12', '68 Phố Thịnh Cương Kim', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/bjlm5br8kvnl2dw2e9nn.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'inactive', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(98, 1, 1, NULL, 'Cho thuê căn hộ', 'Bác. Cự Tú', '0929163865', 'Nhà nguyên căn rộng rãi, thích hợp gia đình ở.', 9307595.05, 2557130.33, 3714520.71, '22', 3587.92, 12531.19, 6, '2025-11-15', '[10,30]', '16:00', '23:00', 'TP Hồ Chí Minh', 'Phường 9', '168 Phố Nghiêm', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996636/rm7awseuugyrxzwf18gz.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/rm7awseuugyrxzwf18gz.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/qm8jncopsasdgqndyk16.jpg\"]', 'active', 'pending', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(99, 2, 2, NULL, 'Cho thuê căn hộ', 'Chị. Bì Lam', '0981601745', 'Mặt bằng ngay mặt tiền đường lớn, thuận tiện kinh doanh.', 5648549.32, 5178899.13, 787171.44, '50', 3501.90, 16962.22, 4, '2025-10-17', '[27,17,31,32,14]', '15:00', '23:00', 'Cần Thơ', 'Phường 8', '7 Phố Tào Quyên Sương', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/ol1nrtvguwmot9q93hoa.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996637\\/lqt98m22axzsv95so6g4.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(100, 6, 4, NULL, 'Cho thuê mặt bằng kinh doanh', 'Lâm Diệu Dân', '0953137259', 'Căn hộ đầy đủ nội thất, có thang máy và hầm để xe.', 4614777.73, 711591.73, 4676902.71, '23', 3208.21, 19876.07, 1, '2025-09-09', '[9,20,27,4]', '10:00', '7:00', 'Đà Nẵng', 'Phường 9', '8 Phố Lạc Khanh Huy', 'https://res.cloudinary.com/whr-clound/image/upload/v1757996637/lqt98m22axzsv95so6g4.jpg', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1757996636\\/bpwndpmnzfupqoixkgje.jpg\"]', 'active', 'rejected', NULL, 0, '2025-12-13 21:47:05', '2025-12-13 21:47:05'),
(101, 2, 3, '2', 'Cho thuê phòng trọ 18m2 giá rẻ tại Bình Thạnh', 'Nguyễn Quang Huy', '0366465273', 'dadđ', 2000000.00, 0.00, 0.00, '50', 3500.00, 4000.00, 2, '2025-12-20', '[\"2\",\"12\",\"20\"]', 'all', 'all', 'Thành phố Hồ Chí Minh', 'Xã Bàu Bàng', '451 Đường 3 Tháng 2', '', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1765712134\\/rental_management\\/rental_post_images\\/post_101_1765712123_0_bd2811aaa78fb9d1386faa42021b58bb92cccb5b.jpg\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1765712137\\/rental_management\\/rental_post_images\\/post_101_1765712135_1_63dfaf8c8a15b554452d43d0e99f6bf21e0687af.jpg\"]', 'active', 'approved', '-', 0, '2025-12-14 06:13:41', '2025-12-14 11:35:38'),
(102, 1, 1, '0', 'Cho thuê phòng trọ 18m2 giá rẻ tại Bình Thạnh 1', 'Nguyễn Văn A', '0366465273', 'dâd', 2000000.00, 0.00, 0.00, '40', 3500.00, 4000.00, 2, '2025-12-20', '[\"6\",\"11\"]', 'all', 'all', 'Quảng Ninh', 'Phường Móng Cái 1', '122 - Đường Nguyễn Duy Trinh', '', '[\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1765712280\\/rental_management\\/rental_post_images\\/post_102_1765712278_0_d0b9e2b12dd301ee0f596a29204347dc4a625d88.webp\",\"https:\\/\\/res.cloudinary.com\\/whr-clound\\/image\\/upload\\/v1765712283\\/rental_management\\/rental_post_images\\/post_102_1765712280_1_842bcbc26e3b0ba00c9fbcc277951f3539ca75d7.webp\"]', 'active', 'approved', NULL, 0, '2025-12-14 11:37:49', '2025-12-14 11:38:03');

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
(1, 11, NULL, 'Lấy bài người khác để đăng', 101, NULL, NULL, 'post', 'spam', 'dadđ', 'pending', NULL, NULL, NULL, NULL, '0000-00-00', 0, '2025-12-14 12:41:02', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `vn_name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_status`, `vn_name`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'active', 'Quản trị viên', 0, '2025-12-13 21:46:19', '2025-12-13 21:46:19'),
(2, 'landlord', 'active', 'Chủ nhà', 0, '2025-12-13 21:46:19', '2025-12-13 21:46:19'),
(3, 'customer', 'active', 'Người tìm nhà', 0, '2025-12-13 21:46:19', '2025-12-13 21:46:19');

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
(1, 1, 'Phòng 01', 3500000.00, 3500000.00, '30', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(2, 1, 'Phòng 02', 4700000.00, 5700000.00, '39', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(3, 1, 'Phòng 03', 3300000.00, 3300000.00, '24', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(4, 1, 'Phòng 04', 2700000.00, 3700000.00, '31', '1', 'occupied', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(5, 1, 'Phòng 05', 4200000.00, 4200000.00, '33', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(6, 1, 'Phòng 06', 2400000.00, 3400000.00, '24', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(7, 1, 'Phòng 07', 3100000.00, 3100000.00, '25', '2', 'occupied', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(8, 1, 'Phòng 08', 5000000.00, 5500000.00, '37', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(9, 1, 'Phòng 09', 1400000.00, 2400000.00, '22', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(10, 1, 'Phòng 10', 4000000.00, 4500000.00, '31', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(11, 2, 'Phòng 01', 3400000.00, 4400000.00, '35', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(12, 2, 'Phòng 02', 1900000.00, 2400000.00, '23', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(13, 2, 'Phòng 03', 3200000.00, 3700000.00, '26', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(14, 2, 'Phòng 04', 3000000.00, 3000000.00, '24', '1', 'occupied', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(15, 2, 'Phòng 05', 5000000.00, 5000000.00, '40', '1', 'occupied', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(16, 2, 'Phòng 06', 3800000.00, 3800000.00, '33', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(17, 2, 'Phòng 07', 3000000.00, 3000000.00, '24', '2', 'occupied', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(18, 2, 'Phòng 08', 4000000.00, 4500000.00, '40', '2', 'occupied', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(19, 2, 'Phòng 09', 1800000.00, 2800000.00, '28', '2', 'occupied', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(20, 2, 'Phòng 10', 2700000.00, 3700000.00, '33', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(21, 3, 'Phòng 01', 3000000.00, 3500000.00, '34', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(22, 3, 'Phòng 02', 4000000.00, 5000000.00, '36', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(23, 3, 'Phòng 03', 2500000.00, 3000000.00, '27', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(24, 3, 'Phòng 04', 2800000.00, 3800000.00, '26', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(25, 3, 'Phòng 05', 4200000.00, 4700000.00, '39', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(26, 3, 'Phòng 06', 4100000.00, 4100000.00, '31', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(27, 3, 'Phòng 07', 1900000.00, 2900000.00, '24', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(28, 3, 'Phòng 08', 3500000.00, 4000000.00, '40', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(29, 3, 'Phòng 09', 2800000.00, 2800000.00, '23', '2', 'occupied', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(30, 3, 'Phòng 10', 4800000.00, 4800000.00, '37', '2', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(31, 4, 'Phòng 01', 1500000.00, 2500000.00, '25', '1', 'occupied', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(32, 4, 'Phòng 02', 2700000.00, 3200000.00, '24', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(33, 4, 'Phòng 03', 4000000.00, 4000000.00, '29', '1', 'occupied', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(34, 4, 'Phòng 04', 2400000.00, 3400000.00, '24', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(35, 4, 'Phòng 05', 3600000.00, 3600000.00, '35', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(36, 4, 'Phòng 06', 4700000.00, 5700000.00, '39', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(37, 4, 'Phòng 07', 2500000.00, 3500000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(38, 4, 'Phòng 08', 3400000.00, 3400000.00, '25', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(39, 4, 'Phòng 09', 3100000.00, 4100000.00, '31', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(40, 4, 'Phòng 10', 4800000.00, 4800000.00, '40', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(41, 5, 'Phòng 01', 4000000.00, 4500000.00, '38', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(42, 5, 'Phòng 02', 2900000.00, 3400000.00, '33', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(43, 5, 'Phòng 03', 1600000.00, 2600000.00, '23', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(44, 5, 'Phòng 04', 3700000.00, 3700000.00, '34', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(45, 5, 'Phòng 05', 2300000.00, 3300000.00, '32', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(46, 5, 'Phòng 06', 3500000.00, 3500000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(47, 5, 'Phòng 07', 3900000.00, 4900000.00, '38', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(48, 5, 'Phòng 08', 3000000.00, 3000000.00, '21', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(49, 5, 'Phòng 09', 2700000.00, 2700000.00, '24', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(50, 5, 'Phòng 10', 2600000.00, 2600000.00, '21', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(51, 6, 'Phòng 01', 2300000.00, 3300000.00, '31', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(52, 6, 'Phòng 02', 3200000.00, 3200000.00, '27', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(53, 6, 'Phòng 03', 1200000.00, 2200000.00, '21', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(54, 6, 'Phòng 04', 4300000.00, 4300000.00, '38', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(55, 6, 'Phòng 05', 3800000.00, 4800000.00, '37', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(56, 6, 'Phòng 06', 2300000.00, 3300000.00, '24', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(57, 6, 'Phòng 07', 4700000.00, 4700000.00, '40', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(58, 6, 'Phòng 08', 3700000.00, 4200000.00, '37', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(59, 6, 'Phòng 09', 4200000.00, 4200000.00, '36', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(60, 6, 'Phòng 10', 4600000.00, 4600000.00, '34', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(61, 7, 'Phòng 01', 2300000.00, 3300000.00, '28', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(62, 7, 'Phòng 02', 2700000.00, 3200000.00, '30', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(63, 7, 'Phòng 03', 3900000.00, 3900000.00, '29', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(64, 7, 'Phòng 04', 4700000.00, 4700000.00, '37', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(65, 7, 'Phòng 05', 1400000.00, 2400000.00, '23', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(66, 7, 'Phòng 06', 3800000.00, 3800000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(67, 7, 'Phòng 07', 3400000.00, 3400000.00, '26', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(68, 7, 'Phòng 08', 2400000.00, 2900000.00, '27', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(69, 7, 'Phòng 09', 3600000.00, 4100000.00, '35', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(70, 7, 'Phòng 10', 4600000.00, 4600000.00, '34', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(71, 8, 'Phòng 01', 4000000.00, 4500000.00, '40', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(72, 8, 'Phòng 02', 2100000.00, 3100000.00, '25', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(73, 8, 'Phòng 03', 4300000.00, 4800000.00, '36', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(74, 8, 'Phòng 04', 4700000.00, 5200000.00, '38', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(75, 8, 'Phòng 05', 2400000.00, 2900000.00, '21', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(76, 8, 'Phòng 06', 4000000.00, 4500000.00, '34', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(77, 8, 'Phòng 07', 2600000.00, 3100000.00, '28', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(78, 8, 'Phòng 08', 2700000.00, 3700000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(79, 8, 'Phòng 09', 3100000.00, 3100000.00, '21', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(80, 8, 'Phòng 10', 3200000.00, 4200000.00, '33', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(81, 9, 'Phòng 01', 3400000.00, 3400000.00, '25', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(82, 9, 'Phòng 02', 2200000.00, 3200000.00, '30', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(83, 9, 'Phòng 03', 3100000.00, 4100000.00, '39', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(84, 9, 'Phòng 04', 2800000.00, 2800000.00, '23', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(85, 9, 'Phòng 05', 4200000.00, 4700000.00, '37', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(86, 9, 'Phòng 06', 3400000.00, 3400000.00, '27', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(87, 9, 'Phòng 07', 2200000.00, 3200000.00, '25', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(88, 9, 'Phòng 08', 2700000.00, 3200000.00, '32', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(89, 9, 'Phòng 09', 2900000.00, 3900000.00, '33', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(90, 9, 'Phòng 10', 4000000.00, 4500000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(91, 10, 'Phòng 01', 2800000.00, 3800000.00, '32', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(92, 10, 'Phòng 02', 3800000.00, 4300000.00, '34', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(93, 10, 'Phòng 03', 5500000.00, 5500000.00, '39', '1', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(94, 10, 'Phòng 04', 4600000.00, 5600000.00, '40', '1', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(95, 10, 'Phòng 05', 2300000.00, 2800000.00, '23', '1', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(96, 10, 'Phòng 06', 2600000.00, 3600000.00, '31', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(97, 10, 'Phòng 07', 3600000.00, 3600000.00, '30', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(98, 10, 'Phòng 08', 5400000.00, 5400000.00, '37', '2', 'available', 4, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(99, 10, 'Phòng 09', 2500000.00, 2500000.00, '23', '2', 'available', 2, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(100, 10, 'Phòng 10', 2400000.00, 3400000.00, '28', '2', 'available', 3, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_amenities`
--

CREATE TABLE `room_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_amenities`
--

INSERT INTO `room_amenities` (`id`, `room_id`, `amenity_id`, `quantity`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(2, 1, 5, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(3, 1, 1, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(4, 1, 4, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(5, 1, 6, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(6, 1, 2, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(7, 2, 3, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(8, 2, 6, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(9, 2, 5, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(10, 2, 2, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(11, 3, 3, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(12, 3, 2, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(13, 3, 4, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(14, 4, 3, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(15, 4, 6, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(16, 5, 3, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(17, 11, 13, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(18, 11, 7, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(19, 11, 8, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(20, 11, 11, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(21, 12, 12, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(22, 12, 9, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(23, 12, 10, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(24, 13, 12, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(25, 13, 8, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(26, 13, 10, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(27, 14, 9, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(28, 16, 9, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(29, 21, 17, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(30, 21, 14, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(31, 21, 16, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(32, 22, 17, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(33, 22, 18, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(34, 22, 16, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(35, 23, 17, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(36, 23, 16, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(37, 24, 17, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(38, 24, 15, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(39, 25, 17, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(40, 25, 16, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(41, 25, 18, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(42, 28, 18, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(43, 29, 18, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(44, 31, 21, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(45, 31, 26, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(46, 31, 22, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(47, 31, 23, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(48, 31, 25, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(49, 31, 24, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(50, 31, 20, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(51, 32, 21, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(52, 32, 22, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(53, 32, 19, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(54, 33, 21, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(55, 33, 22, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(56, 33, 24, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(57, 33, 19, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(58, 33, 25, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(59, 34, 19, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(60, 34, 24, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(61, 34, 23, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(62, 34, 25, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(63, 35, 19, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(64, 35, 23, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(65, 36, 24, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(66, 37, 23, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(67, 37, 19, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(68, 38, 23, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(69, 41, 33, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(70, 41, 28, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(71, 41, 27, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(72, 41, 30, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(73, 42, 33, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(74, 42, 28, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(75, 42, 27, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(76, 42, 31, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(77, 42, 29, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(78, 42, 32, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(79, 43, 33, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(80, 43, 28, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(81, 43, 27, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(82, 43, 32, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(83, 43, 31, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(84, 44, 33, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(85, 44, 28, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(86, 44, 27, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(87, 44, 31, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(88, 45, 27, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(89, 45, 31, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(90, 51, 38, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(91, 51, 39, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(92, 51, 34, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(93, 51, 36, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(94, 52, 38, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(95, 52, 39, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(96, 52, 36, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(97, 52, 37, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(98, 52, 35, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(99, 53, 39, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(100, 53, 37, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(101, 54, 39, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(102, 55, 39, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(103, 57, 37, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(104, 61, 47, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(105, 61, 40, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(106, 61, 43, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(107, 61, 41, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(108, 61, 44, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(109, 62, 47, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(110, 62, 43, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(111, 62, 44, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(112, 62, 41, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(113, 62, 46, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(114, 62, 45, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(115, 62, 42, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(116, 63, 47, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(117, 63, 43, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(118, 63, 41, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(119, 63, 44, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(120, 63, 46, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(121, 64, 43, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(122, 64, 46, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(123, 65, 43, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(124, 71, 52, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(125, 71, 54, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(126, 71, 53, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(127, 71, 50, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(128, 71, 49, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(129, 71, 51, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(130, 71, 48, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(131, 72, 52, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(132, 72, 54, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(133, 72, 50, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(134, 72, 53, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(135, 73, 52, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(136, 73, 54, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(137, 73, 49, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(138, 74, 52, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(139, 74, 54, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(140, 74, 53, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(141, 74, 49, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(142, 75, 52, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(143, 75, 54, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(144, 81, 58, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(145, 81, 57, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(146, 81, 55, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(147, 81, 59, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(148, 81, 56, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(149, 82, 56, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(150, 83, 59, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(151, 83, 56, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(152, 83, 55, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(153, 84, 56, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(154, 85, 55, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(155, 85, 59, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(156, 85, 56, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(157, 86, 55, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(158, 86, 59, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(159, 87, 59, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(160, 87, 55, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(161, 91, 62, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(162, 91, 65, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(163, 92, 62, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(164, 92, 60, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(165, 92, 63, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(166, 92, 64, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(167, 92, 61, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(168, 93, 62, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(169, 93, 61, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(170, 93, 63, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(171, 93, 60, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(172, 94, 62, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(173, 94, 63, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(174, 96, 60, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(175, 96, 61, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(176, 97, 60, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(177, 98, 61, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(178, 98, 63, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_services`
--

CREATE TABLE `room_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_services`
--

INSERT INTO `room_services` (`id`, `room_id`, `service_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(2, 1, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(3, 2, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(4, 2, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(5, 3, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(6, 3, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(7, 4, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(8, 4, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(9, 5, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(10, 5, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(11, 5, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(12, 6, 2, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(13, 6, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(14, 7, 2, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(15, 7, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(16, 7, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(17, 7, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(18, 8, 1, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(19, 8, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(20, 8, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(21, 8, 2, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(22, 9, 2, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(23, 9, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(24, 9, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(25, 9, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(26, 10, 4, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(27, 10, 5, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(28, 10, 3, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(29, 10, 2, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(30, 11, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(31, 11, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(32, 11, 7, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(33, 12, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(34, 12, 7, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(35, 12, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(36, 13, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(37, 13, 10, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(38, 14, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(39, 14, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(40, 15, 8, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(41, 15, 7, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(42, 16, 8, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(43, 16, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(44, 17, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(45, 17, 8, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(46, 17, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(47, 18, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(48, 18, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(49, 19, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(50, 19, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(51, 20, 8, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(52, 20, 9, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(53, 20, 7, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(54, 20, 6, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(55, 21, 14, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(56, 21, 13, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(57, 21, 12, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(58, 22, 11, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(59, 22, 13, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(60, 23, 14, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(61, 23, 13, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(62, 24, 12, 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(63, 24, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(64, 25, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(65, 25, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(66, 25, 13, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(67, 25, 12, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(68, 26, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(69, 26, 12, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(70, 26, 13, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(71, 26, 11, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(72, 27, 11, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(73, 27, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(74, 27, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(75, 27, 12, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(76, 28, 11, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(77, 28, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(78, 28, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(79, 29, 13, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(80, 29, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(81, 29, 12, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(82, 29, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(83, 30, 12, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(84, 30, 15, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(85, 30, 14, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(86, 30, 13, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(87, 31, 19, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(88, 31, 20, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(89, 31, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(90, 31, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(91, 32, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(92, 32, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(93, 32, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(94, 33, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(95, 33, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(96, 33, 20, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(97, 33, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(98, 34, 19, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(99, 34, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(100, 34, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(101, 35, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(102, 35, 20, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(103, 35, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(104, 35, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(105, 36, 20, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(106, 36, 19, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(107, 36, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(108, 37, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(109, 37, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(110, 37, 19, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(111, 38, 20, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(112, 38, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(113, 39, 18, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(114, 39, 19, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(115, 39, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(116, 40, 17, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(117, 40, 16, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(118, 41, 21, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(119, 41, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(120, 41, 25, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(121, 41, 23, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(122, 42, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(123, 42, 21, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(124, 42, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(125, 42, 23, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(126, 43, 23, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(127, 43, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(128, 44, 23, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(129, 44, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(130, 44, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(131, 45, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(132, 45, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(133, 46, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(134, 46, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(135, 47, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(136, 47, 21, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(137, 48, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(138, 48, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(139, 48, 21, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(140, 49, 21, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(141, 49, 23, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(142, 49, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(143, 49, 25, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(144, 50, 25, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(145, 50, 24, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(146, 50, 22, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(147, 51, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(148, 51, 29, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(149, 51, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(150, 51, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(151, 52, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(152, 52, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(153, 52, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(154, 52, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(155, 53, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(156, 53, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(157, 53, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(158, 54, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(159, 54, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(160, 55, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(161, 55, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(162, 55, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(163, 56, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(164, 56, 29, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(165, 56, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(166, 56, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(167, 57, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(168, 57, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(169, 57, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(170, 58, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(171, 58, 29, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(172, 58, 26, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(173, 58, 27, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(174, 59, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(175, 59, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(176, 59, 29, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(177, 60, 30, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(178, 60, 28, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(179, 61, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(180, 61, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(181, 61, 34, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(182, 62, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(183, 62, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(184, 63, 34, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(185, 63, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(186, 64, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(187, 64, 35, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(188, 64, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(189, 64, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(190, 65, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(191, 65, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(192, 65, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(193, 65, 35, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(194, 66, 34, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(195, 66, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(196, 66, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(197, 67, 35, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(198, 67, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(199, 67, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(200, 68, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(201, 68, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(202, 69, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(203, 69, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(204, 69, 31, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(205, 70, 35, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(206, 70, 32, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(207, 70, 33, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(208, 70, 34, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(209, 71, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(210, 71, 39, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(211, 71, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(212, 72, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(213, 72, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(214, 72, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(215, 72, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(216, 73, 39, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(217, 73, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(218, 74, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(219, 74, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(220, 74, 39, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(221, 74, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(222, 75, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(223, 75, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(224, 76, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(225, 76, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(226, 77, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(227, 77, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(228, 77, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(229, 77, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(230, 78, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(231, 78, 39, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(232, 78, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(233, 78, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(234, 79, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(235, 79, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(236, 79, 39, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(237, 79, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(238, 80, 40, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(239, 80, 36, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(240, 80, 37, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(241, 80, 38, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(242, 81, 45, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(243, 81, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(244, 81, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(245, 81, 41, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(246, 82, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(247, 82, 41, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(248, 82, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(249, 83, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(250, 83, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(251, 83, 41, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(252, 84, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(253, 84, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(254, 84, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(255, 84, 41, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(256, 85, 45, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(257, 85, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(258, 85, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(259, 86, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(260, 86, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(261, 87, 41, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(262, 87, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(263, 87, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(264, 88, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(265, 88, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(266, 88, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(267, 89, 42, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(268, 89, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(269, 89, 44, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(270, 89, 45, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(271, 90, 43, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(272, 90, 45, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(273, 91, 47, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(274, 91, 49, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(275, 91, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(276, 91, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(277, 92, 47, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(278, 92, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(279, 92, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(280, 92, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(281, 93, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(282, 93, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(283, 93, 47, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(284, 93, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(285, 94, 49, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(286, 94, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(287, 94, 47, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(288, 95, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(289, 95, 49, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(290, 96, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(291, 96, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(292, 97, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(293, 97, 49, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(294, 97, 47, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(295, 98, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(296, 98, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(297, 98, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(298, 99, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(299, 99, 49, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(300, 99, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(301, 99, 50, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(302, 100, 46, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(303, 100, 48, 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44');

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
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_tenants`
--

INSERT INTO `room_tenants` (`id`, `room_id`, `user_id`, `join_date`, `expected_leave_date`, `left_date`, `is_primary`, `note`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 55, '2025-11-14', '2026-08-14', NULL, 1, 'Deposit: 3,500,000 VND, Monthly rent: 3,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(2, 1, 57, '2024-09-14', '2025-03-14', '2025-03-14', 0, 'Deposit: 3,500,000 VND, Monthly rent: 3,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(3, 4, 51, '2024-09-14', '2025-04-14', '2025-04-14', 1, 'Deposit: 2,700,000 VND, Monthly rent: 3,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(4, 4, 52, '2025-12-14', '2026-06-14', NULL, 0, 'Deposit: 2,700,000 VND, Monthly rent: 3,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(5, 5, 37, '2025-09-14', '2026-09-14', NULL, 1, 'Deposit: 4,200,000 VND, Monthly rent: 4,200,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(6, 5, 23, '2025-11-14', '2026-08-14', NULL, 0, 'Deposit: 4,200,000 VND, Monthly rent: 4,200,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(7, 6, 27, '2025-12-14', '2026-10-14', NULL, 1, 'Deposit: 2,400,000 VND, Monthly rent: 3,400,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(8, 7, 30, '2025-03-14', '2026-02-14', NULL, 1, 'Deposit: 3,100,000 VND, Monthly rent: 3,100,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(9, 7, 17, '2024-06-14', '2025-02-14', '2025-02-14', 0, 'Deposit: 3,100,000 VND, Monthly rent: 3,100,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(10, 9, 53, '2024-09-14', '2025-07-14', '2025-07-14', 1, 'Deposit: 1,400,000 VND, Monthly rent: 2,400,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(11, 9, 13, '2025-12-14', '2026-09-14', NULL, 0, 'Deposit: 1,400,000 VND, Monthly rent: 2,400,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(12, 10, 38, '2024-09-14', '2025-09-14', '2025-09-14', 1, 'Deposit: 4,000,000 VND, Monthly rent: 4,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(13, 10, 22, '2025-09-14', '2026-04-14', NULL, 0, 'Deposit: 4,000,000 VND, Monthly rent: 4,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(14, 11, 33, '2024-06-14', '2025-03-14', '2025-03-14', 1, 'Deposit: 3,400,000 VND, Monthly rent: 4,400,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(15, 12, 49, '2024-06-14', '2024-12-14', '2024-12-14', 1, 'Deposit: 1,900,000 VND, Monthly rent: 2,400,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(16, 13, 19, '2024-12-14', '2025-06-14', '2025-06-14', 1, 'Deposit: 3,200,000 VND, Monthly rent: 3,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(17, 13, 24, '2024-06-14', '2025-03-14', '2025-03-14', 0, 'Deposit: 3,200,000 VND, Monthly rent: 3,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(18, 14, 14, '2025-06-14', '2026-06-14', NULL, 1, 'Deposit: 3,000,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(19, 14, 39, '2025-06-14', '2026-04-14', NULL, 0, 'Deposit: 3,000,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(20, 15, 45, '2024-12-14', '2025-09-14', '2025-09-14', 1, 'Deposit: 5,000,000 VND, Monthly rent: 5,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(21, 15, 28, '2025-09-14', '2026-04-14', NULL, 0, 'Deposit: 5,000,000 VND, Monthly rent: 5,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(22, 16, 35, '2024-12-14', '2025-09-14', '2025-09-14', 1, 'Deposit: 3,800,000 VND, Monthly rent: 3,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(23, 16, 25, '2025-09-14', '2026-09-14', NULL, 0, 'Deposit: 3,800,000 VND, Monthly rent: 3,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(24, 17, 40, '2025-03-14', '2026-01-14', NULL, 1, 'Deposit: 3,000,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(25, 17, 56, '2025-06-14', '2026-01-14', NULL, 0, 'Deposit: 3,000,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(26, 18, 47, '2025-12-14', '2026-06-14', NULL, 1, 'Deposit: 4,000,000 VND, Monthly rent: 4,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(27, 19, 21, '2025-06-14', '2026-05-14', NULL, 1, 'Deposit: 1,800,000 VND, Monthly rent: 2,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(28, 19, 20, '2025-06-14', '2026-06-14', NULL, 0, 'Deposit: 1,800,000 VND, Monthly rent: 2,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(29, 20, 12, '2025-09-14', '2026-08-14', NULL, 1, 'Deposit: 2,700,000 VND, Monthly rent: 3,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(30, 21, 31, '2025-09-14', '2026-06-14', NULL, 1, 'Deposit: 3,000,000 VND, Monthly rent: 3,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(31, 21, 44, '2025-03-14', '2025-12-14', '2025-12-14', 0, 'Deposit: 3,000,000 VND, Monthly rent: 3,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(32, 22, 48, '2024-06-14', '2024-12-14', '2024-12-14', 1, 'Deposit: 4,000,000 VND, Monthly rent: 5,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(33, 23, 46, '2024-09-14', '2025-07-14', '2025-07-14', 1, 'Deposit: 2,500,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(34, 23, 29, '2025-03-14', '2026-01-14', NULL, 0, 'Deposit: 2,500,000 VND, Monthly rent: 3,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(35, 24, 11, '2025-12-14', '2026-12-14', NULL, 1, 'Deposit: 2,800,000 VND, Monthly rent: 3,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(36, 24, 9, '2025-09-14', '2026-08-14', NULL, 0, 'Deposit: 2,800,000 VND, Monthly rent: 3,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(37, 25, 43, '2024-09-14', '2025-04-14', '2025-04-14', 1, 'Deposit: 4,200,000 VND, Monthly rent: 4,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(38, 25, 42, '2024-12-14', '2025-07-14', '2025-07-14', 0, 'Deposit: 4,200,000 VND, Monthly rent: 4,700,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(39, 26, 10, '2024-09-14', '2025-07-14', '2025-07-14', 1, 'Deposit: 4,100,000 VND, Monthly rent: 4,100,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(40, 26, 32, '2025-06-14', '2026-03-14', NULL, 0, 'Deposit: 4,100,000 VND, Monthly rent: 4,100,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(41, 27, 34, '2024-06-14', '2025-04-14', '2025-04-14', 1, 'Deposit: 1,900,000 VND, Monthly rent: 2,900,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(42, 28, 15, '2024-09-14', '2025-08-14', '2025-08-14', 1, 'Deposit: 3,500,000 VND, Monthly rent: 4,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(43, 28, 50, '2024-09-14', '2025-09-14', '2025-09-14', 0, 'Deposit: 3,500,000 VND, Monthly rent: 4,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(44, 29, 18, '2025-12-14', '2026-09-14', NULL, 1, 'Deposit: 2,800,000 VND, Monthly rent: 2,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(45, 30, 36, '2025-06-14', '2026-06-14', NULL, 1, 'Deposit: 4,800,000 VND, Monthly rent: 4,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(46, 30, 41, '2024-09-14', '2025-09-14', '2025-09-14', 0, 'Deposit: 4,800,000 VND, Monthly rent: 4,800,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(47, 31, 16, '2025-12-14', '2026-12-14', NULL, 1, 'Deposit: 1,500,000 VND, Monthly rent: 2,500,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(48, 32, 54, '2025-06-14', '2025-12-14', '2025-12-14', 1, 'Deposit: 2,700,000 VND, Monthly rent: 3,200,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(49, 33, 26, '2025-06-14', '2026-03-14', NULL, 1, 'Deposit: 4,000,000 VND, Monthly rent: 4,000,000 VND', 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42');

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
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `house_id`, `service_name`, `service_type`, `service_price`, `unit`, `unit_vi`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(2, 1, 'Nước theo người', 'water', 60000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(3, 1, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(4, 1, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(5, 1, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(6, 2, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(7, 2, 'Nước', 'water', 20000.00, 'm3', 'm³', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(8, 2, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(9, 2, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(10, 2, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(11, 3, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(12, 3, 'Nước', 'water', 18000.00, 'm3', 'm³', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(13, 3, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(14, 3, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(15, 3, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(16, 4, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(17, 4, 'Nước', 'water', 18000.00, 'm3', 'm³', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(18, 4, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(19, 4, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(20, 4, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(21, 5, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(22, 5, 'Nước theo người', 'water', 60000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(23, 5, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(24, 5, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(25, 5, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(26, 6, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(27, 6, 'Nước', 'water', 20000.00, 'm3', 'm³', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(28, 6, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(29, 6, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(30, 6, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(31, 7, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(32, 7, 'Nước theo người', 'water', 60000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(33, 7, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(34, 7, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(35, 7, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(36, 8, 'Điện', 'electric', 4000.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(37, 8, 'Nước theo người', 'water', 80000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(38, 8, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(39, 8, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(40, 8, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(41, 9, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(42, 9, 'Nước', 'water', 15000.00, 'm3', 'm³', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(43, 9, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(44, 9, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(45, 9, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(46, 10, 'Điện', 'electric', 3500.00, 'KWH', 'kWh', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(47, 10, 'Nước theo người', 'water', 80000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(48, 10, 'Internet', 'internet', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(49, 10, 'Rác thải', 'garbage', 20000.00, 'person', 'người', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43'),
(50, 10, 'Gửi xe', 'parking', 100000.00, 'month', 'tháng', 0, '2025-12-13 21:46:43', '2025-12-13 21:46:43');

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
  `month_year` varchar(255) NOT NULL DEFAULT '12-2025',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_usages`
--

INSERT INTO `service_usages` (`id`, `room_id`, `service_id`, `old_value`, `new_value`, `usage_amount`, `unit_price`, `total_amount`, `month_year`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1962, 2147, 185, 4000, 740000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(2, 7, 2, NULL, NULL, 1, 60000, 60000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(3, 7, 3, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(4, 7, 4, NULL, NULL, 1, 20000, 20000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(5, 7, 5, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(6, 7, 1, 1952, 2082, 130, 4000, 520000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(7, 7, 2, NULL, NULL, 1, 60000, 60000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(8, 7, 3, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(9, 7, 4, NULL, NULL, 1, 20000, 20000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(10, 7, 5, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(11, 7, 1, 2108, 2179, 71, 4000, 284000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(12, 7, 2, NULL, NULL, 1, 60000, 60000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(13, 7, 3, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(14, 7, 4, NULL, NULL, 1, 20000, 20000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(15, 7, 5, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(16, 7, 1, 2370, 2461, 91, 4000, 364000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(17, 7, 2, NULL, NULL, 1, 60000, 60000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(18, 7, 3, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(19, 7, 4, NULL, NULL, 1, 20000, 20000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(20, 7, 5, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(21, 7, 1, 2312, 2458, 146, 4000, 584000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(22, 7, 2, NULL, NULL, 1, 60000, 60000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(23, 7, 3, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(24, 7, 4, NULL, NULL, 1, 20000, 20000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(25, 7, 5, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(26, 7, 1, 2519, 2592, 73, 4000, 292000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(27, 7, 2, NULL, NULL, 1, 60000, 60000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(28, 7, 3, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(29, 7, 4, NULL, NULL, 1, 20000, 20000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(30, 7, 5, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(31, 14, 6, 3020, 3149, 129, 4000, 516000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(32, 14, 7, 265, 271, 6, 20000, 120000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(33, 14, 8, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(34, 14, 9, NULL, NULL, 2, 20000, 40000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(35, 14, 10, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(36, 14, 6, 3042, 3161, 119, 4000, 476000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(37, 14, 7, 244, 262, 18, 20000, 360000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(38, 14, 8, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(39, 14, 9, NULL, NULL, 2, 20000, 40000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(40, 14, 10, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(41, 14, 6, 3219, 3377, 158, 4000, 632000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(42, 14, 7, 246, 254, 8, 20000, 160000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(43, 14, 8, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(44, 14, 9, NULL, NULL, 2, 20000, 40000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(45, 14, 10, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(46, 17, 6, 2948, 3113, 165, 4000, 660000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(47, 17, 7, 240, 248, 8, 20000, 160000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(48, 17, 8, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(49, 17, 9, NULL, NULL, 2, 20000, 40000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(50, 17, 10, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(51, 17, 6, 3003, 3145, 142, 4000, 568000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(52, 17, 7, 244, 252, 8, 20000, 160000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(53, 17, 8, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(54, 17, 9, NULL, NULL, 2, 20000, 40000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(55, 17, 10, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(56, 17, 6, 3300, 3384, 84, 4000, 336000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(57, 17, 7, 268, 283, 15, 20000, 300000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(58, 17, 8, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(59, 17, 9, NULL, NULL, 2, 20000, 40000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(60, 17, 10, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(61, 17, 6, 3305, 3505, 200, 4000, 800000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(62, 17, 7, 290, 295, 5, 20000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(63, 17, 8, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(64, 17, 9, NULL, NULL, 2, 20000, 40000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(65, 17, 10, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(66, 17, 6, 3240, 3386, 146, 4000, 584000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(67, 17, 7, 274, 294, 20, 20000, 400000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(68, 17, 8, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(69, 17, 9, NULL, NULL, 2, 20000, 40000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(70, 17, 10, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(71, 17, 6, 3610, 3673, 63, 4000, 252000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(72, 17, 7, 290, 295, 5, 20000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(73, 17, 8, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(74, 17, 9, NULL, NULL, 2, 20000, 40000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(75, 17, 10, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(76, 19, 6, 3445, 3590, 145, 4000, 580000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(77, 19, 7, 295, 305, 10, 20000, 200000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(78, 19, 8, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(79, 19, 9, NULL, NULL, 2, 20000, 40000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(80, 19, 10, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(81, 19, 6, 3536, 3620, 84, 4000, 336000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(82, 19, 7, 300, 320, 20, 20000, 400000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(83, 19, 8, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(84, 19, 9, NULL, NULL, 2, 20000, 40000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(85, 19, 10, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(86, 19, 6, 3775, 3955, 180, 4000, 720000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(87, 19, 7, 317, 335, 18, 20000, 360000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(88, 19, 8, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(89, 19, 9, NULL, NULL, 2, 20000, 40000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(90, 19, 10, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(91, 23, 11, 3470, 3607, 137, 4000, 548000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(92, 23, 12, 302, 308, 6, 18000, 108000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(93, 23, 13, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(94, 23, 14, NULL, NULL, 1, 20000, 20000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(95, 23, 15, NULL, NULL, 1, 100000, 100000, '03-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(96, 23, 11, 3714, 3791, 77, 4000, 308000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(97, 23, 12, 325, 335, 10, 18000, 180000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(98, 23, 13, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(99, 23, 14, NULL, NULL, 1, 20000, 20000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(100, 23, 15, NULL, NULL, 1, 100000, 100000, '04-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(101, 23, 11, 3652, 3852, 200, 4000, 800000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(102, 23, 12, 316, 332, 16, 18000, 288000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(103, 23, 13, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(104, 23, 14, NULL, NULL, 1, 20000, 20000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(105, 23, 15, NULL, NULL, 1, 100000, 100000, '05-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(106, 23, 11, 4020, 4103, 83, 4000, 332000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(107, 23, 12, 330, 341, 11, 18000, 198000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(108, 23, 13, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(109, 23, 14, NULL, NULL, 1, 20000, 20000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(110, 23, 15, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(111, 23, 11, 3882, 4064, 182, 4000, 728000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(112, 23, 12, 370, 389, 19, 18000, 342000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(113, 23, 13, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(114, 23, 14, NULL, NULL, 1, 20000, 20000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(115, 23, 15, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(116, 23, 11, 4273, 4427, 154, 4000, 616000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(117, 23, 12, 385, 393, 8, 18000, 144000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(118, 23, 13, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(119, 23, 14, NULL, NULL, 1, 20000, 20000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(120, 23, 15, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(121, 26, 11, 4105, 4200, 95, 4000, 380000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(122, 26, 12, 350, 369, 19, 18000, 342000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(123, 26, 13, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(124, 26, 14, NULL, NULL, 1, 20000, 20000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(125, 26, 15, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(126, 26, 11, 4278, 4437, 159, 4000, 636000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(127, 26, 12, 364, 377, 13, 18000, 234000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(128, 26, 13, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(129, 26, 14, NULL, NULL, 1, 20000, 20000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(130, 26, 15, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(131, 26, 11, 4475, 4583, 108, 4000, 432000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(132, 26, 12, 366, 373, 7, 18000, 126000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(133, 26, 13, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(134, 26, 14, NULL, NULL, 1, 20000, 20000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(135, 26, 15, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(136, 30, 11, 4515, 4588, 73, 4000, 292000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(137, 30, 12, 415, 431, 16, 18000, 288000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(138, 30, 13, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(139, 30, 14, NULL, NULL, 1, 20000, 20000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(140, 30, 15, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(141, 30, 11, 4498, 4676, 178, 4000, 712000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(142, 30, 12, 416, 425, 9, 18000, 162000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(143, 30, 13, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(144, 30, 14, NULL, NULL, 1, 20000, 20000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(145, 30, 15, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(146, 30, 11, 4798, 4892, 94, 4000, 376000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(147, 30, 12, 448, 458, 10, 18000, 180000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(148, 30, 13, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(149, 30, 14, NULL, NULL, 1, 20000, 20000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(150, 30, 15, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(151, 33, 16, 4735, 4919, 184, 3500, 644000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(152, 33, 17, 445, 451, 6, 18000, 108000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(153, 33, 18, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(154, 33, 19, NULL, NULL, 1, 20000, 20000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(155, 33, 20, NULL, NULL, 1, 100000, 100000, '06-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(156, 33, 16, 5122, 5303, 181, 3500, 633500, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(157, 33, 17, 452, 462, 10, 18000, 180000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(158, 33, 18, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(159, 33, 19, NULL, NULL, 1, 20000, 20000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(160, 33, 20, NULL, NULL, 1, 100000, 100000, '07-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(161, 33, 16, 5308, 5432, 124, 3500, 434000, '08-2025', 0, '2025-12-13 21:46:44', '2025-12-13 21:46:44'),
(162, 33, 17, 478, 483, 5, 18000, 90000, '08-2025', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(163, 33, 18, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(164, 33, 19, NULL, NULL, 1, 20000, 20000, '08-2025', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45'),
(165, 33, 20, NULL, NULL, 1, 100000, 100000, '08-2025', 0, '2025-12-13 21:46:45', '2025-12-13 21:46:45');

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
(1, 'admin', 'admin@example.com', '$2y$10$fO0JmL90ewXtwzc7plPxjO8dsuc7RqJOIiGPEVfebpUfKjregk1.u', '0321234568', 'male', '1990-01-01', 'Quản trị viên', 'Thành phố Hồ Chí Minh', 'Phường Hòa Bình', '123 Đường Nguyễn Huệ', '079090628217', 1, 'active', NULL, NULL, '2025-12-14', 0, '2025-12-13 21:46:38', '2025-12-14 11:05:28'),
(2, 'landlord1', 'landlord1@example.com', '$2y$10$R7dgBCV0p0sQ5hVbpALoGO0rkTqLAJeCTwSCXq6IdD0KN0RncCcYW', '0980000001', 'male', '1981-01-05', 'Chủ nhà trọ', 'Thành phố Hồ Chí Minh', 'Phường Hiệp Bình', '100 Đường XYZ', '079081732502', 2, 'active', NULL, NULL, '2025-12-14', 0, '2025-12-13 21:46:38', '2025-12-14 12:12:17'),
(3, 'landlord2', 'landlord2@example.com', '$2y$10$Nn66lGDwyNnO3Pkh1QgnnOXzUt0.sjAIhaA2ScoLlGaFmwGke9l.2', '0970000002', 'female', '1982-02-10', 'Quản lý bất động sản', 'Thành phố Hồ Chí Minh', 'Phường Bình Cơ', '200 Đường XYZ', '079182366577', 2, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(4, 'landlord3', 'landlord3@example.com', '$2y$10$cKequpxnZ25yPRODHDdBDudpRiNRKBrsSvGp68ULeCSktCrqpIVG2', '0960000003', 'male', '1983-03-15', 'Đầu tư bất động sản', 'Thành phố Hồ Chí Minh', 'Phường Tân Khánh', '300 Đường XYZ', '079083984917', 2, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(5, 'landlord4', 'landlord4@example.com', '$2y$10$Zzk1mZdiezdITYJxku5gzOsSLTdYTnJdIq9Kt1WGN.J5NojBeqAge', '0950000004', 'female', '1984-04-20', 'Chủ khu trọ', 'Thành phố Hồ Chí Minh', 'Phường An Phú', '400 Đường XYZ', '079184131420', 2, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(6, 'landlord5', 'landlord5@example.com', '$2y$10$ny/zDRbV/B6KlLO6FFDqhO1XwE0BvcJgaWT23wyZBwnv5NNUlvGQS', '0940000005', 'male', '1985-05-25', 'Quản lý ký túc xá', 'Thành phố Hồ Chí Minh', 'Phường Phú Lợi', '500 Đường XYZ', '079085997148', 2, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(7, 'landlord_empty', 'landlord_empty@example.com', '$2y$10$x6a/FyZqqu0Yke3FXS1Glec0/5x.MQT9UVct2z9KhI9co5p5Sj1Fy', '0931234567', 'male', '1985-06-15', 'Chủ nhà trọ độc lập', 'Thành phố Hồ Chí Minh', 'Phường Tân Hòa', '456 Đường Võ Oanh', '079085718753', 2, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(8, 'khachhangtest', 'khachhangtest@example.com', '$2y$10$G1S/9BFoK.HfuKO7LJW/A.m9/wl0rDNouITqJYs0x3U1bGE8LFgHO', '0321234567', 'male', '1995-08-15', 'Sinh viên', 'Thành phố Hồ Chí Minh', 'Xã Phú Giáo', '789 Đường Lê Lợi', '079095242823', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(9, 'customer1', 'customer1@example.com', '$2y$10$WFN.Fd6BlI5e9h9H5pmNruLwGOuu58Fux3SQ1J7r5tBlAUqQ5TI9a', '0330000001', 'male', '1991-02-02', 'Sinh viên', 'Lâm Đồng', 'Phường Mũi Né', '100 Đường DEF', '068091051340', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(10, 'customer2', 'customer2@example.com', '$2y$10$UfgNbqvTeSzPGvoCt.wwEuif5wS32qRW5LcCxFrDux6E0M.l2Tjk.', '0340000002', 'female', '1992-03-03', 'Nhân viên văn phòng', 'Thành phố Hồ Chí Minh', 'Phường Trung Mỹ Tây', '200 Đường DEF', '079192845455', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:38', '2025-12-13 21:46:38'),
(11, 'customer3', 'customer3@example.com', '$2y$10$Z7nbFLLLtUM.VoywmoJ94uIL5k0veCWOK.jyub4IXxIcqj9gFX0Vu', '0350000003', 'male', '1993-04-04', 'Công nhân', 'Thành phố Hải Phòng', 'Phường Thành Đông', '300 Đường DEF', '031093022759', 3, 'active', NULL, NULL, '2025-12-14', 0, '2025-12-13 21:46:38', '2025-12-14 12:28:02'),
(12, 'customer4', 'customer4@example.com', '$2y$10$okwoh9.PUchz6.kTq0eHke0/7nwiMA..60nBwkPWDp1BKkJEJPHxq', '0360000004', 'female', '1994-05-05', 'Giáo viên', 'Thành phố Đà Nẵng', 'Xã Tây Giang', '400 Đường DEF', '048194293820', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(13, 'customer5', 'customer5@example.com', '$2y$10$a7Y0Q2nuKbDuKyzRilNBfuTt6HlMcrX8e.BwTf0GbmOKLQuBvyof6', '0370000005', 'male', '1995-06-06', 'Bác sĩ', 'Đắk Lắk', 'Xã Krông Ana', '500 Đường DEF', '066095015573', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(14, 'customer6', 'customer6@example.com', '$2y$10$pFli1OJa6SZQeMV3rRxq2OGtI58ozwaeB9gUYRsBeag2ZZLm.xiAi', '0380000006', 'female', '1996-07-07', 'Kỹ sư', 'Khánh Hòa', 'Xã Cam Hiệp', '600 Đường DEF', '056196244559', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(15, 'customer7', 'customer7@example.com', '$2y$10$4Izg7yTb2f.Kjhpaj8KlrOQ1QaIT2Kja.SgcUf7NJz98zo/u4/kfu', '0390000007', 'male', '1997-08-08', 'Thợ điện', 'Ninh Bình', 'Xã  Xuân Giang', '700 Đường DEF', '037097967246', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(16, 'customer8', 'customer8@example.com', '$2y$10$B7OW861Znqa0wgl.a4/3n.bJNrbzfndZRp8ONV73fsigLoaFkGFMi', '0700000008', 'female', '1998-09-09', 'Thợ nước', 'Nghệ An', 'Xã Hạnh Lâm', '800 Đường DEF', '040198288608', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(17, 'customer9', 'customer9@example.com', '$2y$10$9GjVBWtrgn.WaqfI0cJEmu0sypN0bL1hdxNBNrlK/v9T521xQ4P0S', '0760000009', 'male', '1999-10-10', 'Lái xe', 'Quảng Trị', 'Xã Hiếu Giang', '900 Đường DEF', '044099422543', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(18, 'customer10', 'customer10@example.com', '$2y$10$qW5VfMOaY7U1.gX7xAKGFe4cv833ttGOBoDgClomL.79WgA1hhwSS', '0770000010', 'female', '1990-11-11', 'Nhân viên bán hàng', 'Cao Bằng', 'Xã Hạ Lang', '1000 Đường DEF', '004190168044', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(19, 'customer11', 'customer11@example.com', '$2y$10$C0PUrgMQO2CO6/sq721wiOx/BwJawELorjEIbiU2bUb3AVHtsYNMq', '0780000011', 'male', '1991-12-12', 'Sinh viên', 'Cà Mau', 'Phường An Xuyên', '1100 Đường DEF', '096091158704', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(20, 'customer12', 'customer12@example.com', '$2y$10$S6M0g4ZqTFZZP06Ow5WVEunAAkgxeJ5ueMS/oQmH5vwAkoSlq0CxK', '0790000012', 'female', '1992-01-13', 'Nhân viên văn phòng', 'Lai Châu', 'Xã Sìn Hồ', '1200 Đường DEF', '012192714698', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(21, 'customer13', 'customer13@example.com', '$2y$10$E06wXwtwae91F7vtvKRSReL7gw0am8UhuQpu1xoAkNLoDmIZnNtHC', '0810000013', 'male', '1993-02-14', 'Công nhân', 'Khánh Hòa', 'Xã Tây Ninh Hòa', '1300 Đường DEF', '056093813939', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(22, 'customer14', 'customer14@example.com', '$2y$10$NkYutgU4XblnWPm8W/OekujiBCyWJqYVjsd.DoCJn8fVurZ150kIa', '0820000014', 'female', '1994-03-15', 'Giáo viên', 'Thái Nguyên', 'Xã Hiệp Lực', '1400 Đường DEF', '019194145527', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(23, 'customer15', 'customer15@example.com', '$2y$10$j2mXch5CIH9/r9Ec5gDaYO/.hcadAo/syAgU9E8chL02HLWtZ.42K', '0830000015', 'male', '1995-04-16', 'Bác sĩ', 'Sơn La', 'Xã Xuân Nha', '1500 Đường DEF', '014095752153', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(24, 'customer16', 'customer16@example.com', '$2y$10$ZFVyIL1sX6ta5TmIN6Ai.u2M4Pg/DwuaRnGZTJbTi4./31szQPZu6', '0840000016', 'female', '1996-05-17', 'Kỹ sư', 'Đồng Tháp', 'Xã Tân Hòa', '1600 Đường DEF', '082196974769', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(25, 'customer17', 'customer17@example.com', '$2y$10$8vdujVAu1zpKJtj.rha6hOHVeEA/PCPHuUGoeusRUQwqOyBlLQIU2', '0850000017', 'male', '1997-06-18', 'Thợ điện', 'Tuyên Quang', 'Xã Thắng Mố', '1700 Đường DEF', '008097075691', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:39', '2025-12-13 21:46:39'),
(26, 'customer18', 'customer18@example.com', '$2y$10$LcWiQrsXMyj4u04o3n5vGeNyO2ycD.cfjJ3dxiXMJwu7Mae5dK5.i', '0560000018', 'female', '1998-07-19', 'Thợ nước', 'Quảng Ninh', 'Xã Lương Minh', '1800 Đường DEF', '022198067967', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(27, 'customer19', 'customer19@example.com', '$2y$10$pBC9blSa6YE6.uXGzpKEke6jCc7C0t74IdIT5xes5tk8GkmFPDrTG', '0580000019', 'male', '1999-08-20', 'Lái xe', 'Hà Tĩnh', 'Phường Sông Trí', '1900 Đường DEF', '042099672250', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(28, 'customer20', 'customer20@example.com', '$2y$10$/WPQO4DpTayAUdwB6mo.de6M9ApItcX3LOKuRrz2MxYY9ZtMpPjmu', '0590000020', 'female', '1990-09-21', 'Nhân viên bán hàng', 'Thành phố Huế', 'Phường Thuận Hóa', '2000 Đường DEF', '046190890979', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(29, 'customer21', 'customer21@example.com', '$2y$10$2lv2ShNtS6RbeIm68PmdCOCKoxS..wPJlW99bfFW2tPLOqJJAcQ.S', '0120000021', 'male', '1991-10-22', 'Sinh viên', 'Điện Biên', 'Phường Mường Thanh', '2100 Đường DEF', '011091128604', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(30, 'customer22', 'customer22@example.com', '$2y$10$Gr5ZSEhzA9Z/1ThsfNcG3.MMI0.4W95Phrw5dulXOY3zhjVkQXE0C', '0130000022', 'female', '1992-11-23', 'Nhân viên văn phòng', 'Quảng Ngãi', 'Xã Nghĩa Hành', '2200 Đường DEF', '051192047148', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(31, 'customer23', 'customer23@example.com', '$2y$10$PZQG8.pVNo/o.NOKnVH4OunLHVrj8DHyruZA.//mYZU0BylQemEnO', '0140000023', 'male', '1993-12-24', 'Công nhân', 'Nghệ An', 'Xã Thành Bình Thọ', '2300 Đường DEF', '040093751108', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(32, 'customer24', 'customer24@example.com', '$2y$10$r9Jx6zW7nYmkwLZA/SUaDuLD3P8szALOHMSXvEaqLbbj4brMIea1.', '0150000024', 'female', '1994-01-25', 'Giáo viên', 'Hà Tĩnh', 'Xã Hương Khê', '2400 Đường DEF', '042194971299', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(33, 'customer25', 'customer25@example.com', '$2y$10$bYLZiHV8EazT0yhelEfCjOinQnVtjPBjxJhBSoMPLuYWocqyMWdqi', '0160000025', 'male', '1995-02-26', 'Bác sĩ', 'Thanh Hóa', 'Xã Hậu Lộc', '2500 Đường DEF', '038095463004', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(34, 'customer26', 'customer26@example.com', '$2y$10$R22np/z9BeTKvrmOZ7DhIuiOfSYoO1jSxaztCkniFYOHzB0ZZJDm6', '0170000026', 'female', '1996-03-27', 'Kỹ sư', 'Cao Bằng', 'Phường Nùng Trí Cao', '2600 Đường DEF', '004196888519', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(35, 'customer27', 'customer27@example.com', '$2y$10$8BhZPsy5q1I.KJU2XJ7Brex0bIZ//PRKRogldk2ry7KHrPhBpCmve', '0180000027', 'male', '1997-04-28', 'Thợ điện', 'Ninh Bình', 'Xã Yên Cường', '2700 Đường DEF', '037097518118', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(36, 'customer28', 'customer28@example.com', '$2y$10$IsdyCN3A.VVqo3L/LZdSvu99Tcm6tI4aYy03BJZdOhHg7rDE6gHya', '0190000028', 'female', '1998-05-01', 'Thợ nước', 'Quảng Trị', 'Xã Dân Hóa', '2800 Đường DEF', '044198091048', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(37, 'customer29', 'customer29@example.com', '$2y$10$UkzfQqePGct01I3FX95kB.n6HnTob.fE/TluYoHKh4zHW1jbSz3DC', '0200000029', 'male', '1999-06-02', 'Lái xe', 'Thành phố Huế', 'Phường An Cựu', '2900 Đường DEF', '046099757252', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(38, 'customer30', 'customer30@example.com', '$2y$10$E647lf9gbId4cBkzy/xvtuHajSXjeNx3Xk1iEjSLXxHDIUNJN46ka', '0210000030', 'female', '1990-07-03', 'Nhân viên bán hàng', 'Thành phố Huế', 'Phường Hóa Châu', '3000 Đường DEF', '046190649725', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(39, 'customer31', 'customer31@example.com', '$2y$10$X4teMImzYJbM2e2hAp2cNuDE/r8VvE2OdTuvd.rwIiTqSzEDgzL.S', '0220000031', 'male', '1991-08-04', 'Sinh viên', 'Thành phố Huế', 'Phường Hóa Châu', '3100 Đường DEF', '046091715779', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:40', '2025-12-13 21:46:40'),
(40, 'customer32', 'customer32@example.com', '$2y$10$WKd56XpSLRYJhIrVkS6PFe6IJoMBva9dSIHxyQFFGpWDutWbAO08C', '0230000032', 'female', '1992-09-05', 'Nhân viên văn phòng', 'Thanh Hóa', 'Xã Yên Thắng', '3200 Đường DEF', '038192761871', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(41, 'customer33', 'customer33@example.com', '$2y$10$dV.fhqpn94C/UoKdNPXRfOsyMaUQtKi7dropkQwZ/YIzTEwG8ySNW', '0240000033', 'male', '1993-10-06', 'Công nhân', 'Hưng Yên', 'Xã Tân Thuận', '3300 Đường DEF', '033093684390', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(42, 'customer34', 'customer34@example.com', '$2y$10$I8JU8JOe.7eugUYq3eoEVO2snJW9IYIqqwrXg1CadEubtWzgbjIsq', '0250000034', 'female', '1994-11-07', 'Giáo viên', 'Quảng Ngãi', 'Xã Sơn Kỳ', '3400 Đường DEF', '051194864319', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(43, 'customer35', 'customer35@example.com', '$2y$10$eT.C27tkWnR0jXU2B5QJKeVMdImBO.T1ipKtZNaDkCSaLzV24at6m', '0260000035', 'male', '1995-12-08', 'Bác sĩ', 'Lạng Sơn', 'Xã Điềm He', '3500 Đường DEF', '020095089386', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(44, 'customer36', 'customer36@example.com', '$2y$10$NpMDdLruI7nVnG1s1ITcYepm/cAwywXBqyjHXLUNH5uXHR3ke29sa', '0270000036', 'female', '1996-01-09', 'Kỹ sư', 'Ninh Bình', 'Xã Yên Mạc', '3600 Đường DEF', '037196620147', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(45, 'customer37', 'customer37@example.com', '$2y$10$ujYeiJDdaNFVSlT/hFPRpu.3TfqTphqxfSiSJC1sWpKgaysqmtRLW', '0280000037', 'male', '1997-02-10', 'Thợ điện', 'Lâm Đồng', 'Xã Tuy Phong', '3700 Đường DEF', '068097817535', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(46, 'customer38', 'customer38@example.com', '$2y$10$KBIC2.A5JiL9gfz0kt4oueXPL6hHst1Ad2hwkdZuRWB1q9aMVzb4W', '0290000038', 'female', '1998-03-11', 'Thợ nước', 'Lâm Đồng', 'Xã Bảo Lâm 2', '3800 Đường DEF', '068198383509', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(47, 'customer39', 'customer39@example.com', '$2y$10$yfzwyw50gEe3eyr7WE2on.vH70yIYgEK3nJ/Zu6iLiE.StAM8Y3rm', '0300000039', 'male', '1999-04-12', 'Lái xe', 'Quảng Ninh', 'Xã Hải Ninh', '3900 Đường DEF', '022099290556', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(48, 'customer40', 'customer40@example.com', '$2y$10$bEldVgDA0pb7ysM83EkhpewPk2a/G62M/OXITdWY2uqBkKjfwGVCG', '0310000040', 'female', '1990-05-13', 'Nhân viên bán hàng', 'Thành phố Hải Phòng', 'Phường Thạch Khôi', '4000 Đường DEF', '031190054625', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(49, 'customer41', 'customer41@example.com', '$2y$10$MbiZx8TcSqMZlPXghF6iw.SAg9fiqf5vy2WGFCfNdQeGYMLxpcXsy', '0800000041', 'male', '1991-06-14', 'Sinh viên', 'Điện Biên', 'Xã Thanh Nưa', '4100 Đường DEF', '011091147238', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(50, 'customer42', 'customer42@example.com', '$2y$10$NR0JDYmwwE7cECxDd/El4.d6Ma0oDvILGHLgMuJfW8owgLxkLG0r.', '0860000042', 'female', '1992-07-15', 'Nhân viên văn phòng', 'Gia Lai', 'Xã Chư Krey', '4200 Đường DEF', '052192255737', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(51, 'customer43', 'customer43@example.com', '$2y$10$ZM0qfls.2JWiM2we3g5XIuxuOiKfsNkDnKNtnrkvH3HTkCIdYUPtC', '0870000043', 'male', '1993-08-16', 'Công nhân', 'Quảng Trị', 'Xã Khe Sanh', '4300 Đường DEF', '044093451283', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(52, 'customer44', 'customer44@example.com', '$2y$10$W0ZWRIXHkgNEOX7TUdllGuP1AhULkJ6uZwCrYsB8KjINANbd.NoRm', '0880000044', 'female', '1994-09-17', 'Giáo viên', 'Điện Biên', 'Xã Pu Nhi', '4400 Đường DEF', '011194274587', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:41', '2025-12-13 21:46:41'),
(53, 'customer45', 'customer45@example.com', '$2y$10$lxLi9W7x9noOPHnpMqNK.Ofn.9J8SFyIVFrm.EZ4xLqOHSI7snW/m', '0890000045', 'male', '1995-10-18', 'Bác sĩ', 'Thanh Hóa', 'Phường Tĩnh Gia', '4500 Đường DEF', '038095254475', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(54, 'customer46', 'customer46@example.com', '$2y$10$iiYUrK/X6Wro.Q34k5rNy.b5UxFEFoSNFd/aME66vcjq/wfKu3VEG', '0900000046', 'female', '1996-11-19', 'Kỹ sư', 'Ninh Bình', 'Xã Yên Từ', '4600 Đường DEF', '037196661410', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(55, 'customer47', 'customer47@example.com', '$2y$10$PsWSHGjyo3QNY6FpoftdVO0dlFNzSqCEgCiTtPOJWYH7nXEd3LVwq', '0910000047', 'male', '1997-12-20', 'Thợ điện', 'Thành phố Cần Thơ', 'Phường Ngã Bảy', '4700 Đường DEF', '092097795284', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(56, 'customer48', 'customer48@example.com', '$2y$10$kkS5w2wKH7sW9CGpjGeXn.e/eLIu50D3KvEHk2Vo8tOuoh5R8Z3VS', '0920000048', 'female', '1998-01-21', 'Thợ nước', 'Thành phố Hải Phòng', 'Phường Hồng An', '4800 Đường DEF', '031198863819', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42'),
(57, 'customer49', 'customer49@example.com', '$2y$10$NdstvAYXsJbw8E6pp/OS0Ob1Pq8py.TK2FIgDeUrs7x8xqemFDIIm', '0930000049', 'male', '1999-02-22', 'Lái xe', 'Cao Bằng', 'Xã Nguyễn Huệ', '4900 Đường DEF', '004099051280', 3, 'active', NULL, NULL, NULL, 0, '2025-12-13 21:46:42', '2025-12-13 21:46:42');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `houses`
--
ALTER TABLE `houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `rental_amenities`
--
ALTER TABLE `rental_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `rental_categories`
--
ALTER TABLE `rental_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `rental_posts`
--
ALTER TABLE `rental_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT cho bảng `room_services`
--
ALTER TABLE `room_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

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
