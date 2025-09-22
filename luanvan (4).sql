-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 17, 2025 lúc 06:10 AM
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
-- Cơ sở dữ liệu: `luanvan`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchProperties` (IN `p_transaction_type` VARCHAR(10), IN `p_property_type` INT, IN `p_location_id` INT, IN `p_min_price` DECIMAL(15,2), IN `p_max_price` DECIMAL(15,2), IN `p_min_area` DECIMAL(10,2), IN `p_max_area` DECIMAL(10,2), IN `p_bedrooms` INT, IN `p_sort_by` VARCHAR(20), IN `p_limit` INT, IN `p_offset` INT)   BEGIN
    SET @sql = 'SELECT * FROM property_list_view WHERE 1=1';

    IF p_transaction_type IS NOT NULL AND p_transaction_type != '' THEN
        SET @sql = CONCAT(@sql, ' AND transactionType = "', p_transaction_type, '"');
    END IF;
    
    IF p_property_type IS NOT NULL AND p_property_type > 0 THEN
        SET @sql = CONCAT(@sql, ' AND typeId = ', p_property_type);
    END IF;
    
    IF p_location_id IS NOT NULL AND p_location_id > 0 THEN
        SET @sql = CONCAT(@sql, ' AND locationId = ', p_location_id);
    END IF;
    
    IF p_min_price IS NOT NULL AND p_min_price > 0 THEN
        SET @sql = CONCAT(@sql, ' AND price >= ', p_min_price);
    END IF;
    
    IF p_max_price IS NOT NULL AND p_max_price > 0 THEN
        SET @sql = CONCAT(@sql, ' AND price <= ', p_max_price);
    END IF;
    
    IF p_min_area IS NOT NULL AND p_min_area > 0 THEN
        SET @sql = CONCAT(@sql, ' AND area >= ', p_min_area);
    END IF;
    
    IF p_max_area IS NOT NULL AND p_max_area > 0 THEN
        SET @sql = CONCAT(@sql, ' AND area <= ', p_max_area);
    END IF;
    IF p_bedrooms IS NOT NULL AND p_bedrooms > 0 THEN
        SET @sql = CONCAT(@sql, ' AND bedrooms = ', p_bedrooms);
    END IF;
    IF p_sort_by = 'price_low' THEN
        SET @sql = CONCAT(@sql, ' ORDER BY price ASC');
    ELSEIF p_sort_by = 'price_high' THEN
        SET @sql = CONCAT(@sql, ' ORDER BY price DESC');
    ELSEIF p_sort_by = 'area_small' THEN
        SET @sql = CONCAT(@sql, ' ORDER BY area ASC');
    ELSEIF p_sort_by = 'area_large' THEN
        SET @sql = CONCAT(@sql, ' ORDER BY area DESC');
    ELSE
        SET @sql = CONCAT(@sql, ' ORDER BY createdAt DESC');
    END IF;
    
    IF p_limit IS NOT NULL AND p_limit > 0 THEN
        SET @sql = CONCAT(@sql, ' LIMIT ', p_limit);
        IF p_offset IS NOT NULL AND p_offset > 0 THEN
            SET @sql = CONCAT(@sql, ' OFFSET ', p_offset);
        END IF;
    END IF;
    
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('1','2','3') NOT NULL COMMENT '1=Admin, 2=Broker, 3=User',
  `status` enum('active','inactive') DEFAULT 'active',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `fullName`, `email`, `phoneNumber`, `password`, `avatar`, `address`, `role`, `status`, `createdAt`, `updatedAt`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(2, 'Trần Thị B', 'tranthib@email.com', '0907654321', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(3, 'Lê Văn C', 'levanc@email.com', '0903456789', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(4, 'Phạm Thị D', 'phamthid@email.com', '0909876543', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(5, 'Hoàng Văn E', 'hoangvane@email.com', '0906789012', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(6, 'Ngô Thị F', 'ngothif@email.com', '0902345678', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, '2', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(7, 'Admin User', 'admin@ehome.com', '0900000000', '0192023a7bbd73250516f069df18b500', NULL, NULL, '1', 'active', '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(8, 'Nguyễn Văn An', 'nguyenvana@gmail.com', '0912345671', 'pass123', 'uploads/avatar/avatar_1.jpg', 'Số 1, P. Bến Nghé, Quận 1', '2', 'active', '2024-01-10 01:00:00', '2025-09-12 15:48:40'),
(9, 'Trần Thị Bình', 'tranthibinh@gmail.com', '0912345672', 'pass123', 'uploads/avatar/avatar_2.jpg', 'Số 2, P. Bến Thành, Quận 1', '1', 'active', '2024-01-12 02:30:00', '2025-09-12 15:48:40'),
(10, 'Lê Văn Cường', 'levancuong@gmail.com', '0912345673', 'pass123', 'uploads/avatar/avatar_3.jpg', 'Số 3, P. Tân Phong, Quận 7', '2', 'inactive', '2024-01-15 03:45:00', '2025-09-14 02:43:53'),
(11, 'Phạm Thị Dung', 'phamthidung@gmail.com', '0912345674', 'pass123', 'uploads/avatar/avatar_4.jpg', 'Số 4, P. Thảo Điền, Quận 2', '1', 'active', '2024-01-18 04:00:00', '2025-09-12 15:48:40'),
(12, 'Hoàng Văn Em', 'hoangvanem@gmail.com', '0912345675', 'pass123', 'uploads/avatar/avatar_5.jpg', 'Số 5, P. Phước Long B, Quận 9', '2', 'active', '2024-01-20 06:20:00', '2025-09-12 15:48:40'),
(13, 'Vũ Thị Giang', 'vuthigiang@gmail.com', '0912345676', 'pass123', 'uploads/avatar/avatar_6.jpg', 'Số 6, P. An Phú, Quận 2', '1', 'inactive', '2024-01-22 07:00:00', '2025-09-14 02:43:32'),
(14, 'Đặng Văn Hùng', 'dangvanhung@gmail.com', '0912345677', 'pass123', 'uploads/avatar/avatar_7.jpg', 'Số 7, P. Hiệp Bình Chánh, Thủ Đức', '2', 'active', '2024-01-25 08:30:00', '2025-09-12 15:48:40'),
(15, 'Bùi Thị Hương', 'buithihuong@gmail.com', '0912345678', 'pass123', 'uploads/avatar/avatar_8.jpg', 'Số 8, P. 11, Quận 3', '1', 'active', '2024-01-28 09:00:00', '2025-09-12 15:48:40'),
(16, 'Lý Văn Khang', 'lyvankhang@gmail.com', '0912345679', 'pass123', 'uploads/avatar/avatar_9.jpg', 'Số 9, P. 12, Quận 10', '2', 'active', '2024-02-01 10:15:00', '2025-09-12 15:48:40'),
(17, 'Ngô Thị Lan', 'ngothilan@gmail.com', '0912345680', 'pass123', 'uploads/avatar/avatar_10.jpg', 'Số 10, P. 15, Quận 10', '1', 'active', '2024-02-03 11:00:00', '2025-09-12 15:48:40'),
(18, 'Trần Văn Minh', 'tranvanminh@gmail.com', '0912345681', 'pass123', 'uploads/avatar/avatar_11.jpg', 'Số 11, P. 13, Quận 10', '2', 'active', '2024-02-05 02:00:00', '2025-09-12 15:48:40'),
(19, 'Lý Thị Na', 'lythina@gmail.com', '0912345682', 'pass123', 'uploads/avatar/avatar_12.jpg', 'Số 12, P. 14, Quận 10', '1', 'active', '2024-02-07 03:30:00', '2025-09-12 15:48:40'),
(20, 'Phan Văn Nam', 'phanvannam@gmail.com', '0912345683', 'pass123', 'uploads/avatar/avatar_13.jpg', 'Số 13, P. 15, Quận 10', '2', 'active', '2024-02-09 04:45:00', '2025-09-12 15:48:40'),
(21, 'Trương Thị Oanh', 'truongthioanh@gmail.com', '0912345684', 'pass123', 'uploads/avatar/avatar_14.jpg', 'Số 14, P. 16, Quận 10', '1', 'active', '2024-02-11 06:00:00', '2025-09-12 15:48:40'),
(22, 'Đỗ Văn Phước', 'dovanphuoc@gmail.com', '0912345685', 'pass123', 'uploads/avatar/avatar_15.jpg', 'Số 15, P. 17, Quận 10', '2', 'active', '2024-02-13 07:30:00', '2025-09-12 15:48:40'),
(23, 'Ngô Thị Quyên', 'ngothiquyen@gmail.com', '0912345686', 'pass123', 'uploads/avatar/avatar_16.jpg', 'Số 16, P. 18, Quận 10', '1', 'active', '2024-02-15 08:45:00', '2025-09-12 15:48:40'),
(24, 'Lê Văn Quang', 'levanquang@gmail.com', '0912345687', 'pass123', 'uploads/avatar/avatar_17.jpg', 'Số 17, P. 19, Quận 10', '2', 'active', '2024-02-17 10:00:00', '2025-09-12 15:48:40'),
(25, 'Mai Thị Sương', 'maithisuong@gmail.com', '0912345688', 'pass123', 'uploads/avatar/avatar_18.jpg', 'Số 18, P. 20, Quận 10', '1', 'active', '2024-02-19 11:00:00', '2025-09-12 15:48:40'),
(26, 'Cao Văn Thái', 'caovanthai@gmail.com', '0912345689', 'pass123', 'uploads/avatar/avatar_19.jpg', 'Số 19, P. 21, Quận 10', '2', 'active', '2024-02-21 02:00:00', '2025-09-12 15:48:40'),
(27, 'Bùi Thị Uyên', 'buithiuyen@gmail.com', '0912345690', 'pass123', 'uploads/avatar/avatar_20.jpg', 'Số 20, P. 22, Quận 10', '1', 'active', '2024-02-23 03:30:00', '2025-09-12 15:48:40'),
(28, 'Võ Văn Vị', 'vovanduy@gmail.com', '0912345691', 'pass123', 'uploads/avatar/avatar_21.jpg', 'Số 21, P. 23, Quận 10', '2', 'active', '2024-02-25 04:45:00', '2025-09-12 15:48:40'),
(29, 'Trần Văn Xuân', 'tranvanxuan@gmail.com', '0912345692', 'pass123', 'uploads/avatar/avatar_22.jpg', 'Số 22, P. 24, Quận 10', '1', 'active', '2024-02-27 06:00:00', '2025-09-12 15:48:40'),
(30, 'Lê Thị Yến', 'lethiyen@gmail.com', '0912345693', 'pass123', 'uploads/avatar/avatar_23.jpg', 'Số 23, P. 25, Quận 10', '2', 'active', '2024-02-29 07:30:00', '2025-09-12 15:48:40'),
(31, 'Nguyễn Văn Zung', 'nguyenzung@gmail.com', '0912345694', 'pass123', 'uploads/avatar/avatar_24.jpg', 'Số 24, P. 26, Quận 10', '1', 'active', '2024-03-01 08:45:00', '2025-09-12 15:48:40'),
(32, 'Phạm Văn Trọng', 'phamvantrong@gmail.com', '0912345695', 'pass123', 'uploads/avatar/avatar_25.jpg', 'Số 25, P. 27, Quận 10', '2', 'active', '2024-03-03 10:00:00', '2025-09-12 15:48:40'),
(33, 'Hoàng Thị Thu', 'hoangthithu@gmail.com', '0912345696', 'pass123', 'uploads/avatar/avatar_26.jpg', 'Số 26, P. 28, Quận 10', '1', 'active', '2024-03-05 11:00:00', '2025-09-12 15:48:40'),
(34, 'Đặng Văn Phúc', 'dangvanphuc@gmail.com', '0912345697', 'pass123', 'uploads/avatar/avatar_27.jpg', 'Số 27, P. 29, Quận 10', '2', 'active', '2024-03-07 02:00:00', '2025-09-12 15:48:40'),
(35, 'Bùi Văn Khôi', 'buivankhoi@gmail.com', '0912345698', 'pass123', 'uploads/avatar/avatar_28.jpg', 'Số 28, P. 30, Quận 10', '1', 'active', '2024-03-09 03:30:00', '2025-09-12 15:48:40'),
(36, 'Lê Thị Hằng', 'lethihang@gmail.com', '0912345699', 'pass123', 'uploads/avatar/avatar_29.jpg', 'Số 29, P. 31, Quận 10', '2', 'active', '2024-03-11 04:45:00', '2025-09-12 15:48:40'),
(37, 'Nguyễn Văn Nam', 'nguyenvannam@gmail.com', '0912345700', 'pass123', 'uploads/avatar/avatar_30.jpg', 'Số 30, P. 32, Quận 10', '1', 'active', '2024-03-13 06:00:00', '2025-09-12 15:48:40'),
(38, 'Đỗ Thị Mai', 'dothimai@gmail.com', '0912345701', 'pass123', 'uploads/avatar/avatar_31.jpg', 'Số 31, P. 33, Quận 10', '2', 'active', '2024-03-15 07:30:00', '2025-09-12 15:48:40'),
(39, 'Hoàng Văn Tuấn', 'hoangvantuan@gmail.com', '0912345702', 'pass123', 'uploads/avatar/avatar_32.jpg', 'Số 32, P. 34, Quận 10', '1', 'active', '2024-03-17 08:45:00', '2025-09-12 15:48:40'),
(40, 'Ngô Văn Quý', 'ngovanquy@gmail.com', '0912345703', 'pass123', 'uploads/avatar/avatar_33.jpg', 'Số 33, P. 35, Quận 10', '2', 'active', '2024-03-19 10:00:00', '2025-09-12 15:48:40'),
(41, 'Trương Thị Thảo', 'truongthithao@gmail.com', '0912345704', 'pass123', 'uploads/avatar/avatar_34.jpg', 'Số 34, P. 36, Quận 10', '1', 'active', '2024-03-21 11:00:00', '2025-09-12 15:48:40'),
(42, 'Bùi Văn Quang', 'buivanquang@gmail.com', '0912345705', 'pass123', 'uploads/avatar/avatar_35.jpg', 'Số 35, P. 37, Quận 10', '2', 'active', '2024-03-23 02:00:00', '2025-09-12 15:48:40'),
(43, 'Phạm Thị Lan', 'phamthilan@gmail.com', '0912345706', 'pass123', 'uploads/avatar/avatar_36.jpg', 'Số 36, P. 38, Quận 10', '1', 'active', '2024-03-25 03:30:00', '2025-09-12 15:48:40'),
(44, 'Lê Văn Hùng', 'levanhung@gmail.com', '0912345707', 'pass123', 'uploads/avatar/avatar_37.jpg', 'Số 37, P. 39, Quận 10', '2', 'active', '2024-03-27 04:45:00', '2025-09-12 15:48:40'),
(45, 'Nguyễn Thị Dung', 'nguyenthidung@gmail.com', '0912345708', 'pass123', 'uploads/avatar/avatar_38.jpg', 'Số 38, P. 40, Quận 10', '1', 'active', '2024-03-29 06:00:00', '2025-09-12 15:48:40'),
(46, 'Vũ Văn Duy', 'vovanduy2@gmail.com', '0912345709', 'pass123', 'uploads/avatar/avatar_39.jpg', 'Số 39, P. 41, Quận 10', '2', 'active', '2024-03-31 07:30:00', '2025-09-12 15:48:40'),
(47, 'Trần Thị Thảo', 'tranthithao2@gmail.com', '0912345710', 'pass123', 'uploads/avatar/avatar_40.jpg', 'Số 40, P. 42, Quận 10', '1', 'active', '2024-04-02 08:45:00', '2025-09-12 15:48:40'),
(48, 'Lý Văn Đạt', 'lyvandat@gmail.com', '0912345711', 'pass123', 'uploads/avatar/avatar_41.jpg', 'Số 41, P. 43, Quận 10', '2', 'active', '2024-04-04 10:00:00', '2025-09-12 15:48:40'),
(49, 'Nguyễn Thị Nga', 'nguyenthinga@gmail.com', '0912345712', 'pass123', 'uploads/avatar/avatar_42.jpg', 'Số 42, P. 44, Quận 10', '1', 'active', '2024-04-06 11:00:00', '2025-09-12 15:48:40'),
(50, 'Phạm Văn Tuấn', 'phamvantuan@gmail.com', '0912345713', 'pass123', 'uploads/avatar/avatar_43.jpg', 'Số 43, P. 45, Quận 10', '2', 'active', '2024-04-08 02:00:00', '2025-09-12 15:48:40'),
(51, 'Hoàng Thị Hạnh', 'hoangthihanh@gmail.com', '0912345714', 'pass123', 'uploads/avatar/avatar_44.jpg', 'Số 44, P. 46, Quận 10', '1', 'active', '2024-04-10 03:30:00', '2025-09-12 15:48:40'),
(52, 'Đặng Văn Kiên', 'dangvankien@gmail.com', '0912345715', 'pass123', 'uploads/avatar/avatar_45.jpg', 'Số 45, P. 47, Quận 10', '2', 'active', '2024-04-12 04:45:00', '2025-09-12 15:48:40'),
(53, 'Bùi Thị Ngọc', 'buithingoc@gmail.com', '0912345716', 'pass123', 'uploads/avatar/avatar_46.jpg', 'Số 46, P. 48, Quận 10', '1', 'active', '2024-04-14 06:00:00', '2025-09-12 15:48:40'),
(54, 'Lê Văn Hưng', 'levanhung2@gmail.com', '0912345717', 'pass123', 'uploads/avatar/avatar_47.jpg', 'Số 47, P. 49, Quận 10', '2', 'active', '2024-04-16 07:30:00', '2025-09-12 15:48:40'),
(55, 'Nguyễn Thị Cúc', 'nguyenthicuc@gmail.com', '0912345718', 'pass123', 'uploads/avatar/avatar_48.jpg', 'Số 48, P. 50, Quận 10', '1', 'active', '2024-04-18 08:45:00', '2025-09-12 15:48:40'),
(56, 'Vũ Thị Loan', 'vuthiloan@gmail.com', '0912345719', 'pass123', 'uploads/avatar/avatar_49.jpg', 'Số 49, P. 51, Quận 10', '2', 'active', '2024-04-20 10:00:00', '2025-09-12 15:48:40'),
(57, 'Trần Văn Thắng', 'tranvanthang@gmail.com', '0912345720', 'pass123', 'uploads/avatar/avatar_50.jpg', 'Số 50, P. 52, Quận 10', '1', 'active', '2024-04-22 11:00:00', '2025-09-12 15:48:40'),
(58, 'wrưq', 'fvncvn@xn--sgds-zua.com', '2222222222', '$2y$10$U5gEONHVVXG/tizdWk2MYuIv.A6o2ClD0iD/NBVRN2idorgLhtwsO', '68c63116aacf8.jpg', NULL, '2', 'active', '2025-09-14 03:05:58', '2025-09-14 03:05:58'),
(59, 'wrưq', 'fv23ncvn@xn--sgds-zua.com', '2222222224', '$2y$10$nHmrg8KDJC0TxKBcus2FLu9GknMltCOVsLGQfR9rruGn1LMduBx1C', '68c6d7aca847c.jpg', NULL, '2', 'active', '2025-09-14 03:06:55', '2025-09-14 14:56:44'),
(60, 'hoa', 'fdhdfhdf@fdfhdfd.com', '1111111112', '$2y$10$yRpL/R5PDMvgEK/0BJYO4OscnEErOX423FlyV4GYq7sLsAwuVMnWi', NULL, NULL, '1', 'active', '2025-09-14 15:52:09', '2025-09-14 15:52:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `broker`
--

CREATE TABLE `broker` (
  `id` int(11) NOT NULL,
  `accountId` int(11) NOT NULL,
  `shortIntro` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `mainArea` varchar(255) DEFAULT NULL,
  `expertise` text DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `workingHours` varchar(255) DEFAULT NULL,
  `linkFacebook` text DEFAULT NULL,
  `linkYoutube` varchar(500) DEFAULT NULL,
  `linkWebsite` varchar(500) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `broker`
--

INSERT INTO `broker` (`id`, `accountId`, `shortIntro`, `note`, `mainArea`, `expertise`, `language`, `workingHours`, `linkFacebook`, `linkYoutube`, `linkWebsite`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'Chuyên viên tư vấn BĐS cao cấp', NULL, 'Quận 1, Quận 3', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(2, 2, 'Chuyên gia nhà phố và đất nền', NULL, 'Quận 7, Quận 9', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(3, 3, 'Tư vấn văn phòng và thương mại', NULL, 'Quận 1, Bình Thạnh', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(4, 4, 'Chuyên phòng trọ và căn hộ mini', NULL, 'Bình Thạnh, Quận 2', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(5, 5, 'Chuyên gia đất nền và đầu tư', NULL, 'Quận 9, Quận 7', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(6, 6, 'Tư vấn penthouse và luxury', NULL, 'Quận 1, Quận 2', NULL, NULL, NULL, '5.0', NULL, NULL, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(7, 1, 'Chuyên gia bất động sản cao cấp, am hiểu thị trường TP. HCM.', NULL, 'Quận 1, Quận 7', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '9h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-14 02:32:49'),
(8, 3, 'Kinh nghiệm 5 năm tư vấn đầu tư đất nền và biệt thự nghỉ dưỡng.', NULL, 'Quận 2, Quận 9', 'Đất nền, Biệt thự', 'Tiếng Việt, Chinese', '8h30 - 17h30', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-14 02:32:49'),
(9, 5, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 3, Quận 10', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(10, 7, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(11, 9, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(12, 10, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-14 02:56:32'),
(13, 13, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 1, Quận 3', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(14, 15, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(15, 17, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(16, 19, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(17, 21, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 1, Quận 3', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(18, 23, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(19, 25, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(20, 27, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(21, 29, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 1, Quận 3', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(22, 31, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(23, 33, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(24, 35, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(25, 37, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 1, Quận 3', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(26, 39, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(27, 41, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(28, 43, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(29, 45, 'Tư vấn chuyên sâu về các giải pháp văn phòng và mặt bằng kinh doanh.', NULL, 'Quận 1, Quận 3', 'Văn phòng cho thuê, Shophouse', 'Tiếng Việt', '9h - 19h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(30, 47, 'Nắm rõ thị trường nhà cho thuê khu vực Thủ Đức, phù hợp cho sinh viên.', NULL, 'Thủ Đức, Quận 9', 'Nhà trọ, Nhà phố', 'Tiếng Việt', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(31, 49, 'Tư vấn mua bán căn hộ và nhà phố trung tâm thành phố.', NULL, 'Quận 1, Quận 5', 'Căn hộ chung cư, Nhà phố', 'Tiếng Việt, English', '8h - 18h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(32, 50, 'Chuyên gia đầu tư đất nền và biệt thự tại các khu vực đang phát triển.', NULL, 'Quận 10, Quận 11', 'Đất nền, Biệt thự', 'Tiếng Việt', '9h - 17h', NULL, NULL, NULL, '2025-09-12 15:50:21', '2025-09-12 15:50:21'),
(33, 58, 'ửqư', NULL, 'Quận 1, Quận 2, Quận 8, Quận 9', 'Nhà ở, Chung cư, Đất nền', 'Tiếng Việt, Tiếng Trung', 'qửqư', 'qửqử', 'qửqử', 'ưqrưq', '2025-09-14 03:05:58', '2025-09-14 03:05:58'),
(34, 59, 'ửqư', NULL, 'Quận 1', 'Nhà ở', 'Tiếng Việt', '2223232', '23232', '23232', '2323', '2025-09-14 03:06:55', '2025-09-14 14:56:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `broker_ratings`
--

CREATE TABLE `broker_ratings` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `brokerId` int(11) NOT NULL,
  `rating` float(1,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `brokerId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','contacted','closed') DEFAULT 'pending',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expertises`
--

CREATE TABLE `expertises` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `expertises`
--

INSERT INTO `expertises` (`id`, `name`, `description`, `icon`, `status`) VALUES
(1, 'Nhà ở', 'Chuyên về mua bán, cho thuê nhà ở các loại', 'fas fa-home', 1),
(2, 'Chung cư', 'Chuyên về căn hộ chung cư, condotel', 'fas fa-building', 1),
(3, 'Đất nền', 'Chuyên về đất nền, đất thổ cư, đất dự án', 'fas fa-map', 1),
(4, 'Văn phòng', 'Chuyên về cho thuê văn phòng, mặt bằng kinh doanh', 'fas fa-briefcase', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `location`
--

INSERT INTO `location` (`id`, `name`, `type`, `status`) VALUES
(1, 'Quận 1', 'Quận', 1),
(2, 'Quận 2', 'Quận', 1),
(3, 'Quận 3', 'Quận', 1),
(4, 'Quận 4', 'Quận', 1),
(5, 'Quận 5', 'Quận', 1),
(6, 'Quận 6', 'Quận', 1),
(7, 'Quận 7', 'Quận', 1),
(8, 'Quận 8', 'Quận', 1),
(9, 'Quận 9', 'Quận', 1),
(10, 'Quận 10', 'Quận', 1),
(11, 'Quận 11', 'Quận', 1),
(12, 'Quận 12', 'Quận', 1),
(13, 'Quận Bình Thạnh', 'Quận', 1),
(14, 'Quận Gò Vấp', 'Quận', 1),
(15, 'Quận Phú Nhuận', 'Quận', 1),
(16, 'Quận Tân Bình', 'Quận', 1),
(17, 'Quận Tân Phú', 'Quận', 1),
(18, 'Quận Bình Tân', 'Quận', 1),
(19, 'Thành phố Thủ Đức', 'Thành phố', 1),
(20, 'Huyện Bình Chánh', 'Huyện', 1),
(21, 'Huyện Cần Giờ', 'Huyện', 1),
(22, 'Huyện Củ Chi', 'Huyện', 1),
(23, 'Huyện Hóc Môn', 'Huyện', 1),
(24, 'Huyện Nhà Bè', 'Huyện', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `image` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `createdAt` date NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `pin` tinyint(1) NOT NULL DEFAULT 1,
  `typeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `content`, `createdAt`, `views`, `pin`, `typeId`) VALUES
(14, 'Thị trường bất động sản TP.HCM: Xu hướng phục hồi mạnh mẽ trong quý 4/2024', '/uploads/news/thi-truong-hcm-q4-2024.jpg', '<div style=\"background:#f8fafc;border:1px solid #e5e7eb;padding:16px;border-radius:8px;margin:12px 0;\">\r\n  <p><strong>Tóm tắt:</strong> Thị trường TP.HCM ghi nhận phục hồi rõ rệt ở quý 4/2024 với giao dịch tăng, giá ổn định, tâm lý nhà đầu tư cải thiện. Các phân khúc dẫn dắt gồm căn hộ trung cấp và cao cấp tại khu trung tâm mở rộng.</p>\r\n  <ul style=\"margin:8px 0 0 18px;\">\r\n    <li>Giao dịch tăng 25% so với cùng kỳ</li>\r\n    <li>Giá bán giữ mức ổn định, một số khu vực tăng nhẹ</li>\r\n    <li>Tỷ lệ hấp thụ cao ở Quận 1, Quận 2, Quận 7, Bình Thạnh</li>\r\n  </ul>\r\n</div>\r\n\r\n<h2>Tình hình thị trường quý 4/2024</h2>\r\n<p>Thanh khoản cải thiện nhờ nguồn cung pháp lý hoàn thiện và chính sách tín dụng linh hoạt. Mở bán tập trung ở dự án hạ tầng tốt, pháp lý rõ ràng, tiện ích đầy đủ.</p>\r\n\r\n<div style=\"display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin:16px 0;\">\r\n  <div style=\"border:1px solid #e5e7eb;border-radius:10px;padding:12px;background:#fff;\">\r\n    <h4>Thanh khoản</h4><p>Tăng đều theo tuần, nhất là dự án bàn giao trong 12–18 tháng.</p>\r\n  </div>\r\n  <div style=\"border:1px solid #e5e7eb;border-radius:10px;padding:12px;background:#fff;\">\r\n    <h4>Giá bán</h4><p>Ổn định, tăng 3–5% ở sản phẩm khan hiếm.</p>\r\n  </div>\r\n  <div style=\"border:1px solid #e5e7eb;border-radius:10px;padding:12px;background:#fff;\">\r\n    <h4>Nhu cầu thuê</h4><p>Phục hồi tại khu trung tâm và dọc tuyến metro.</p>\r\n  </div>\r\n</div>\r\n\r\n<h2>Phân tích theo phân khúc</h2>\r\n<h3>Căn hộ cao cấp</h3>\r\n<p>Quan tâm nổi bật ở trục ven sông, tiện ích khép kín. Giá 50–80 triệu/m², ưu tiên tầm nhìn thoáng, tầng cao, căn 2PN.</p>\r\n\r\n<blockquote style=\"border-left:4px solid #0ea5e9;padding:8px 12px;background:#f0f9ff;border-radius:6px;\">\r\n  <p>“Căn hộ cao cấp thu hút nhóm khách có năng lực tài chính ổn định, pháp lý sạch và tiến độ minh bạch.”</p>\r\n</blockquote>\r\n\r\n<h3>Nhà phố & biệt thự</h3>\r\n<p>Giá thứ cấp khu Đông/Nam tăng nhẹ 5–8% YTD. Sản phẩm pháp lý hoàn thiện, vận hành tốt dễ giao dịch.</p>\r\n\r\n<h3>BĐS thương mại</h3>\r\n<p>Tỷ lệ lấp đầy văn phòng tăng, đặc biệt hạng B ở trung tâm mở rộng. Bán lẻ phục hồi trên các trục lớn.</p>\r\n\r\n<h2>Yếu tố thúc đẩy</h2>\r\n<ul>\r\n  <li>Tín dụng ổn định, gói vay ưu đãi</li>\r\n  <li>Pháp lý dự án cải thiện</li>\r\n  <li>Hạ tầng khu vực (metro, cầu) phát triển</li>\r\n</ul>\r\n\r\n<h2>Số liệu nhanh</h2>\r\n<table style=\"width:100%;border-collapse:collapse;margin:12px 0;\">\r\n  <thead>\r\n    <tr>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Chỉ tiêu</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Q4/2023</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Q4/2024</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Biến động</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Giao dịch</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">100</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">125</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">+25%</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Giá bán TB</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">100</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">103–105</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tăng nhẹ</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Lấp đầy thuê</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">88%</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">92%</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Cải thiện</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n\r\n<h2>Dự báo 2025</h2>\r\n<ol>\r\n  <li>Tăng trưởng giao dịch 10–15%</li>\r\n  <li>Giá tăng 3–5% ở vị trí tốt</li>\r\n  <li>Tiện ích thông minh, quản trị chuẩn quốc tế là điểm cộng</li>\r\n</ol>\r\n\r\n<div style=\"background:#f1f5f9;border:1px dashed #cbd5e1;padding:12px;border-radius:8px;margin-top:12px;\">\r\n  <h4>Lời khuyên cho nhà đầu tư</h4>\r\n  <ul>\r\n    <li>Ưu tiên pháp lý minh bạch, chủ đầu tư uy tín</li>\r\n    <li>Quản trị dòng tiền & lộ trình giải ngân</li>\r\n    <li>Đa dạng hóa danh mục để cân bằng rủi ro</li>\r\n  </ul>\r\n</div>\r\n\r\n<h2>Kết luận</h2>\r\n<p>Xu hướng phục hồi đã rõ. Chọn đúng sản phẩm & chiến lược nắm giữ sẽ quyết định hiệu quả.</p>', '2024-12-15', 2363, 1, 1),
(15, 'Báo cáo nhanh thị trường TP.HCM ngày 22/08/2025', '/uploads/news/bao-cao-nhanh-22082025.jpg', '<div style=\"background:#f8fafc;border:1px solid #e5e7eb;padding:16px;border-radius:8px;margin:12px 0;\">\r\n  <p><strong>Báo cáo nhanh:</strong> Ngày 22/08/2025, giao dịch thứ cấp tăng ở khu Đông; giá giữ ổn định; một số dự án công bố chính sách thanh toán mới.</p>\r\n</div>\r\n\r\n<h2>Điểm nhấn trong ngày</h2>\r\n<ul style=\"margin-left:18px;\">\r\n  <li>Lượng khách tham quan tăng tại các sàn ở TP. Thủ Đức</li>\r\n  <li>Quan tâm tới căn hộ bàn giao trong 12 tháng tới</li>\r\n  <li>Chiết khấu theo tiến độ linh hoạt</li>\r\n</ul>\r\n\r\n<h2>Giao dịch theo khu vực</h2>\r\n<table style=\"width:100%;border-collapse:collapse;margin:12px 0;\">\r\n  <thead>\r\n    <tr>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Khu vực</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Loại hình</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Xu hướng giá</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;text-align:left;\">Ghi chú</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Khu Đông</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Căn hộ trung cấp</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Ổn định</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Ưu tiên gần metro</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Khu Nam</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Nhà phố</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tăng nhẹ</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Hạ tầng nội khu tốt</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Trung tâm mở rộng</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Văn phòng hạng B</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Ổn định</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Nhu cầu thuê cải thiện</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n\r\n<h2>Tin dự án nổi bật</h2>\r\n<div style=\"display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;\">\r\n  <div style=\"border:1px solid #e5e7eb;border-radius:10px;padding:10px;\">\r\n    <h4>Block mới dự án ven sông</h4><p>Thanh toán 30% đến khi nhận nhà, tặng gói nội thất.</p>\r\n  </div>\r\n  <div style=\"border:1px solid #e5e7eb;border-radius:10px;padding:10px;\">\r\n    <h4>Tháp văn phòng hạng B</h4><p>Giá thuê cạnh tranh, hỗ trợ fit-out ban đầu.</p>\r\n  </div>\r\n</div>\r\n\r\n<h2>Rủi ro cần theo dõi</h2>\r\n<ul>\r\n  <li>Tiến độ pháp lý dự án mới</li>\r\n  <li>Biến động chi phí lãi vay</li>\r\n  <li>Thanh khoản thứ cấp giữa các phân khúc</li>\r\n</ul>', '2025-08-22', 420, 0, 1),
(16, 'Thủ tục sang tên sổ hồng 2025: Chi tiết từng bước', '/uploads/news/thu-tuc-sang-ten-2025.jpg', '<div style=\"background:#f8fafc;border:1px solid #e5e7eb;padding:16px;border-radius:8px;margin:12px 0;\">\r\n  <p><strong>Tóm lược:</strong> Hướng dẫn từng bước sang tên sổ hồng năm 2025, kèm danh mục hồ sơ, thời hạn và lệ phí để người mua lần đầu dễ theo dõi.</p>\r\n</div>\r\n\r\n<h2>Các bước thực hiện</h2>\r\n<ol style=\"margin-left:18px;\">\r\n  <li>Kiểm tra pháp lý BĐS & tình trạng quy hoạch</li>\r\n  <li>Ký hợp đồng chuyển nhượng tại tổ chức công chứng</li>\r\n  <li>Nộp hồ sơ tại VP đăng ký đất đai</li>\r\n  <li>Nộp lệ phí trước bạ & nghĩa vụ tài chính</li>\r\n  <li>Nhận kết quả, cập nhật chủ sở hữu mới</li>\r\n</ol>\r\n\r\n<h2>Hồ sơ cần chuẩn bị</h2>\r\n<ul>\r\n  <li>CMND/CCCD, sổ hộ khẩu/cư trú</li>\r\n  <li>Sổ hồng bản gốc & bản sao</li>\r\n  <li>Hợp đồng công chứng</li>\r\n  <li>Tờ khai lệ phí trước bạ, thuế TNCN (nếu có)</li>\r\n</ul>\r\n\r\n<h2>Bảng lệ phí tham khảo</h2>\r\n<table style=\"width:100%;border-collapse:collapse;margin:12px 0;\">\r\n  <thead>\r\n    <tr>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Khoản mục</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Mức thu</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Ghi chú</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Lệ phí trước bạ</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">~1% giá trị chuyển nhượng</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Theo quy định</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Phí công chứng</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Theo bậc thang</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Phụ thuộc giá trị HĐ</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Phí thẩm định</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tùy địa phương</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tra cứu biểu phí</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n\r\n<div style=\"background:#fff7ed;border:1px solid #fed7aa;padding:12px;border-radius:8px;\">\r\n  <strong>Lưu ý:</strong> Giữ toàn bộ biên lai & phiếu hẹn; kiểm tra kỹ thông tin cá nhân trước khi nhận kết quả.\r\n</div>\r\n\r\n<h2>Câu hỏi thường gặp</h2>\r\n<div>\r\n  <h4>Trường hợp ủy quyền có khác biệt gì?</h4>\r\n  <p>Cần giấy ủy quyền được công chứng, trong đó ghi rõ phạm vi và thời hạn.</p>\r\n  <h4>Thời hạn xử lý có thể rút ngắn không?</h4>\r\n  <p>Tùy địa phương có dịch vụ một cửa và lịch hẹn trực tuyến, nên đặt lịch sớm.</p>\r\n</div>', '2025-07-20', 733, 0, 4),
(17, 'Mẹo thương lượng giá khi mua căn hộ lần đầu', '/uploads/news/meo-thuong-luong-gia-can-ho.jpg', '<div style=\"background:#f8fafc;border:1px solid #e5e7eb;padding:16px;border-radius:8px;margin:12px 0;\">\r\n  <p><strong>Mục tiêu:</strong> Bộ khung thương lượng thực tế cho người mua lần đầu: chuẩn bị dữ liệu, hỏi mở, chốt điều kiện thanh toán có lợi.</p>\r\n</div>\r\n\r\n<h2>Chuẩn bị trước khi thương lượng</h2>\r\n<ul style=\"margin-left:18px;\">\r\n  <li>Khảo sát giá theo tầng, hướng, diện tích, nội thất</li>\r\n  <li>Ghi nhận giao dịch gần đây ở dự án tương đồng</li>\r\n  <li>Xác định ngân sách tối đa & phương án vay</li>\r\n</ul>\r\n\r\n<h2>Kịch bản trao đổi</h2>\r\n<div>\r\n  <p style=\"margin:6px 0;\"><strong>Khách hàng:</strong> Tôi quan tâm căn 2PN, xin báo giá & chính sách thanh toán.</p>\r\n  <p style=\"margin:6px 0;\"><strong>Tư vấn:</strong> Đang có tiến độ linh hoạt, chiết khấu theo tỉ lệ giải ngân.</p>\r\n  <p style=\"margin:6px 0;\"><strong>Khách hàng:</strong> Nếu thanh toán nhanh, mức chiết khấu & ưu đãi nội thất điều chỉnh thế nào?</p>\r\n</div>\r\n\r\n<h2>Nguyên tắc</h2>\r\n<ol>\r\n  <li>Bám dữ liệu giá & tiện ích</li>\r\n  <li>Giữ không gian đôi bên cùng có lợi</li>\r\n  <li>Chốt các điều kiện cụ thể: giá, thời hạn, bàn giao, bảo hành</li>\r\n</ol>\r\n\r\n<div style=\"background:#f1f5f9;border:1px dashed #cbd5e1;padding:12px;border-radius:8px;\">\r\n  <h4>Mẹo nhanh</h4>\r\n  <ul>\r\n    <li>Ưu tiên layout vuông vắn, view thoáng</li>\r\n    <li>So sánh tổng chi phí sở hữu, không chỉ giá bán</li>\r\n    <li>Ghi nhận cam kết bằng văn bản</li>\r\n  </ul>\r\n</div>\r\n\r\n<h2>Kết luận</h2>\r\n<p>Khi có dữ liệu tốt và chiến lược trao đổi rõ ràng, cơ hội đạt giá tối ưu & điều kiện bàn giao thuận lợi sẽ cao hơn.</p>', '2025-08-22', 314, 0, 3),
(18, 'Xu hướng vốn FDI vào BĐS công nghiệp nửa đầu 2025', '/uploads/news/xu-huong-fdi-bds-cn-2025.jpg', '<p>Dòng vốn FDI tiếp tục ưu tiên khu công nghiệp phía Nam; diện tích thuê mới tập trung ở các ngành công nghệ, logistics. Quỹ đất sạch, hạ tầng kết nối và chất lượng vận hành là yếu tố quyết định.</p>\r\n<ul style=\"margin-left:18px;\">\r\n  <li>Mặt bằng giá thuê ổn định</li>\r\n  <li>Tỷ lệ lấp đầy cao ở khu trung tâm công nghiệp</li>\r\n  <li>Nhu cầu nhà xưởng xây sẵn tăng</li>\r\n</ul>', '2025-06-30', 926, 0, 5),
(19, 'Giá BĐS Hà Nội tăng 12% trong quý 4', '/uploads/news/gia-bds-ha-noi-q4.jpg', '<p>Giá bán tăng 12% so với cùng kỳ; nguồn cung mới tập trung quanh vành đai. Người mua ở thực quan tâm căn hộ 2PN, tiện ích nội khu đầy đủ.</p>\r\n<table style=\"width:100%;border-collapse:collapse;margin:12px 0;\">\r\n  <thead>\r\n    <tr>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Khu vực</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Xu hướng</th>\r\n      <th style=\"border:1px solid #e5e7eb;padding:8px;\">Ghi chú</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Đông Anh</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tăng</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Hưởng lợi từ hạ tầng</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Hà Đông</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Ổn định</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Nguồn cung dồi dào</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Cầu Giấy</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Tăng nhẹ</td>\r\n      <td style=\"border:1px solid #e5e7eb;padding:8px;\">Văn phòng & dịch vụ phát triển</td>\r\n    </tr>\r\n  </tbody>\r\n</table>', '2024-12-14', 1891, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `property_amenities`
--

CREATE TABLE `property_amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `property_amenities`
--

INSERT INTO `property_amenities` (`id`, `name`, `icon`, `category`) VALUES
(1, 'Điều hòa', 'fas fa-snowflake', 'comfort'),
(2, 'WiFi', 'fas fa-wifi', 'technology'),
(3, 'Thang máy', 'fas fa-elevator', 'building'),
(4, 'Bảo vệ 24/7', 'fas fa-shield-alt', 'security'),
(5, 'Hồ bơi', 'fas fa-swimming-pool', 'recreation'),
(6, 'Phòng gym', 'fas fa-dumbbell', 'recreation'),
(7, 'Siêu thị', 'fas fa-shopping-cart', 'convenience'),
(8, 'Bãi đỗ xe', 'fas fa-car', 'parking'),
(9, 'Ban công', 'fas fa-balcony', 'comfort'),
(10, 'Sân vườn', 'fas fa-tree', 'outdoor');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `imagePath` varchar(500) NOT NULL,
  `altText` varchar(255) DEFAULT NULL,
  `isMain` tinyint(1) DEFAULT 0,
  `sortOrder` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `property_images`
--

INSERT INTO `property_images` (`id`, `propertyId`, `imagePath`, `altText`, `isMain`, `sortOrder`, `createdAt`) VALUES
(1, 1, 'logo.jpg', NULL, 1, 1, '2025-09-11 06:59:16'),
(2, 1, 'logo.jpg', NULL, 0, 2, '2025-09-11 06:59:16'),
(3, 1, 'logo.jpg', NULL, 0, 3, '2025-09-11 06:59:16'),
(4, 3, 'logo.jpg', NULL, 1, 1, '2025-09-11 06:59:16'),
(5, 4, 'logo.jpg', NULL, 1, 1, '2025-09-11 06:59:16'),
(6, 5, 'logo.jpg', NULL, 1, 1, '2025-09-11 06:59:16'),
(7, 6, 'logo.jpg', NULL, 1, 1, '2025-09-11 06:59:16'),
(506, 91, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:22:27'),
(507, 91, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:22:27'),
(508, 91, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:22:27'),
(509, 91, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:22:27'),
(510, 91, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:22:27'),
(511, 91, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:22:27'),
(572, 82, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:22:55'),
(573, 82, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:22:55'),
(574, 82, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:22:55'),
(575, 82, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:22:55'),
(576, 82, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:22:55'),
(577, 82, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:22:55'),
(578, 83, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:07'),
(579, 83, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:07'),
(580, 83, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:07'),
(581, 83, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:07'),
(582, 83, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:07'),
(583, 83, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:07'),
(584, 84, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:15'),
(585, 84, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:15'),
(586, 84, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:15'),
(587, 84, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:15'),
(588, 84, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:15'),
(589, 84, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:15'),
(590, 85, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:26'),
(591, 85, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:26'),
(592, 85, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:26'),
(593, 85, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:26'),
(594, 85, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:26'),
(595, 85, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:26'),
(596, 86, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:34'),
(597, 86, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:34'),
(598, 86, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:34'),
(599, 86, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:34'),
(600, 86, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:34'),
(601, 86, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:34'),
(602, 87, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:43'),
(603, 87, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:43'),
(604, 87, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:43'),
(605, 87, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:43'),
(606, 87, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:43'),
(607, 87, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:43'),
(608, 88, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:23:52'),
(609, 88, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:23:52'),
(610, 88, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:23:52'),
(611, 88, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:23:52'),
(612, 88, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:23:52'),
(613, 88, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:23:52'),
(620, 89, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:24:32'),
(621, 89, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:24:32'),
(622, 89, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:24:32'),
(623, 89, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:24:32'),
(624, 89, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:24:32'),
(625, 89, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:24:32'),
(626, 90, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:24:32'),
(627, 90, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:24:32'),
(628, 90, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:24:32'),
(629, 90, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:24:32'),
(630, 90, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:24:32'),
(631, 90, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:24:32'),
(632, 92, 'logo.jpg', NULL, 1, 1, '2025-09-12 16:24:32'),
(633, 92, 'logo.jpg', NULL, 0, 2, '2025-09-12 16:24:32'),
(634, 92, 'logo.jpg', NULL, 0, 3, '2025-09-12 16:24:32'),
(635, 92, 'logo.jpg', NULL, 0, 4, '2025-09-12 16:24:32'),
(636, 92, 'logo.jpg', NULL, 0, 5, '2025-09-12 16:24:32'),
(637, 92, 'logo.jpg', NULL, 0, 6, '2025-09-12 16:24:32');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `property_list_view`
-- (See below for the actual view)
--
CREATE TABLE `property_list_view` (
`id` int(11)
,`title` varchar(255)
,`address` varchar(500)
,`transactionType` enum('rent','sale')
,`price` decimal(15,2)
,`area` decimal(10,2)
,`bedrooms` int(11)
,`bathrooms` int(11)
,`imageCount` int(11)
,`views` int(11)
,`createdAt` timestamp
,`propertyType` varchar(100)
,`locationName` varchar(100)
,`brokerName` varchar(255)
,`brokerAvatar` varchar(500)
,`mainImage` varchar(500)
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_property`
--

CREATE TABLE `rental_property` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(500) NOT NULL,
  `locationId` int(11) DEFAULT NULL,
  `typeId` int(11) NOT NULL,
  `brokerId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `transactionType` enum('rent','sale') NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `priceUnit` enum('month','total') DEFAULT 'month',
  `area` decimal(10,2) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT 0,
  `bathrooms` int(11) DEFAULT 0,
  `floors` int(11) DEFAULT 1,
  `frontage` decimal(5,2) DEFAULT NULL COMMENT 'Mặt tiền (m)',
  `direction` varchar(50) DEFAULT NULL,
  `legalStatus` varchar(100) DEFAULT NULL COMMENT 'Tình trạng pháp lý',
  `furniture` enum('none','basic','full') DEFAULT 'none',
  `parking` tinyint(1) DEFAULT 0,
  `images` text DEFAULT NULL COMMENT 'JSON array of image URLs',
  `imageCount` int(11) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','rented','sold','pending') DEFAULT 'pending',
  `views` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rental_property`
--

INSERT INTO `rental_property` (`id`, `title`, `description`, `address`, `locationId`, `typeId`, `brokerId`, `userId`, `transactionType`, `price`, `priceUnit`, `area`, `bedrooms`, `bathrooms`, `floors`, `frontage`, `direction`, `legalStatus`, `furniture`, `parking`, `images`, `imageCount`, `featured`, `status`, `views`, `createdAt`, `updatedAt`) VALUES
(1, 'Căn hộ cao cấp Vinhomes Central Park', 'Căn hộ đầy đủ nội thất, view đẹp', 'Đường Nguyễn Hữu Cảnh, Quận 1', 2, 1, 1, NULL, 'rent', 25000000.00, 'month', 80.00, 2, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 12, 0, 'active', 1, '2025-09-11 06:59:16', '2025-09-17 04:02:47'),
(2, 'Nhà phố mặt tiền đường lớn', 'Nhà phố kinh doanh tốt, vị trí đẹp', 'Đường Huỳnh Tấn Phát, Quận 7', 5, 2, 2, NULL, 'sale', 8500000000.00, 'month', 120.00, 4, 3, 1, NULL, NULL, NULL, 'none', 0, NULL, 8, 0, 'active', 0, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(3, 'Văn phòng hạng A tòa nhà Bitexco', 'Văn phòng cao cấp, đầy đủ tiện ích', 'Đường Đồng Khởi, Quận 1', 2, 3, 3, NULL, 'rent', 50000000.00, 'month', 200.00, 0, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 15, 0, 'active', 0, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(4, 'Phòng trọ cao cấp full nội thất', 'Phòng trọ sạch sẽ, an ninh tốt', 'Đường Phan Văn Hân, Bình Thạnh', 7, 4, 4, NULL, 'rent', 6000000.00, 'month', 25.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 6, 0, 'active', 0, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(5, 'Đất nền khu dân cư cao cấp', 'Đất nền sổ hồng riêng, vị trí đẹp', 'Đường Võ Văn Kiệt, Quận 9', 6, 5, 5, NULL, 'sale', 3200000000.00, 'month', 100.00, 0, 0, 1, NULL, NULL, NULL, 'none', 0, NULL, 4, 0, 'active', 0, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(6, 'Penthouse view sông Sài Gòn', 'Penthouse luxury với view tuyệt đẹp', 'Đường Thảo Điền, Quận 2', 3, 1, 6, NULL, 'rent', 80000000.00, 'month', 150.00, 3, 3, 1, NULL, NULL, NULL, 'none', 0, NULL, 20, 0, 'active', 0, '2025-09-11 06:59:16', '2025-09-11 06:59:16'),
(82, 'Căn hộ 2PN view sông Quận 2', 'Nội thất cao cấp, ban công rộng, an ninh 24/7.', '', 3, 1, 1, 2, '', 15000000.00, 'month', 85.00, 2, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-02-29 17:00:00', '2025-09-12 16:04:18'),
(83, 'Nhà phố mặt tiền đường lớn Quận 1', 'Vị trí đắc địa, tiện kinh doanh mọi ngành nghề.', '', 1, 1, 3, 4, '', 25000000000.00, 'month', 150.00, 4, 3, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-04 17:00:00', '2025-09-12 16:04:18'),
(84, 'Biệt thự sân vườn Quận 7', 'Thiết kế hiện đại, không gian xanh mát, hồ bơi riêng.', '', 2, 3, 5, 6, '', 45000000000.00, 'month', 300.00, 5, 4, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-07 17:00:00', '2025-09-12 16:04:18'),
(85, 'Đất nền KDC Thủ Đức', 'Sổ đỏ chính chủ, đường nhựa 12m, gần trường học.', '', 4, 4, 7, 8, '', 7500000000.00, 'month', 100.00, 0, 0, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-09 17:00:00', '2025-09-12 16:04:18'),
(86, 'Văn phòng cho thuê trung tâm Quận 1', 'Đầy đủ tiện ích, diện tích linh hoạt, giá tốt.', '', 1, 5, 9, 10, '', 25000000.00, 'month', 120.00, 0, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-11 17:00:00', '2025-09-12 16:04:18'),
(87, 'Nhà trọ cao cấp gần trường ĐH Bách Khoa', 'Phòng mới, có gác lửng, WC riêng, giờ giấc tự do.', '', 5, 5, 11, 12, '', 3500000.00, 'month', 25.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-14 17:00:00', '2025-09-12 16:04:18'),
(88, 'Căn hộ 3PN The Vista An Phú', 'Nội thất sang trọng, tiện ích đầy đủ, khu dân trí cao.', '', 3, 1, 13, 14, '', 22000000.00, 'month', 110.00, 3, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-17 17:00:00', '2025-09-12 16:04:18'),
(89, 'Nhà phố 1 trệt 2 lầu Quận 9', 'Mặt tiền kinh doanh, cách Vincom 5 phút.', '', 4, 2, 15, 16, '', 15000000000.00, 'month', 90.00, 3, 3, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-19 17:00:00', '2025-09-12 16:04:18'),
(90, 'Biệt thự ven sông Sài Gòn', 'Không gian yên tĩnh, an ninh, view sông lãng mạn.', '', 2, 3, 17, 18, '', 80000000000.00, 'month', 400.00, 6, 5, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 1, '2024-03-21 17:00:00', '2025-09-14 16:47:30'),
(91, 'Đất nền dự án ven biển Vũng Tàu', 'Sổ hồng riêng, xây dựng tự do, tiềm năng du lịch.', '', 6, 4, 19, 20, '', 5000000000.00, 'month', 150.00, 0, 0, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-24 17:00:00', '2025-09-12 16:04:18'),
(92, 'Văn phòng cho thuê Quận 3', 'Gần các tòa nhà lớn, giao thông thuận tiện.', '', 5, 5, 21, 22, '', 18000000.00, 'month', 95.00, 0, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-27 17:00:00', '2025-09-12 16:04:18'),
(93, 'Nhà trọ giá rẻ gần KTX ĐH Quốc Gia', 'Phòng sạch sẽ, an toàn, có nhà bếp chung.', '', 4, 1, 23, 24, '', 2500000.00, 'month', 20.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-29 17:00:00', '2025-09-12 16:04:18'),
(94, 'Căn hộ Penthouse Quận 1', 'Thiết kế độc đáo, view thành phố tuyệt đẹp.', '', 1, 1, 25, 26, '', 30000000000.00, 'month', 200.00, 4, 4, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-03-31 17:00:00', '2025-09-12 16:04:18'),
(95, 'Nhà riêng hẻm lớn Quận 10', 'Yên tĩnh, an ninh, gần chợ, trường học.', '', 5, 2, 27, 28, '', 10000000000.00, 'month', 75.00, 3, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-04 17:00:00', '2025-09-12 16:04:18'),
(96, 'Biệt thự nghỉ dưỡng Đà Lạt', 'Không khí trong lành, view đồi thông, thích hợp nghỉ dưỡng.', '', 7, 3, 29, 30, '', 18000000000.00, 'month', 500.00, 6, 6, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-07 17:00:00', '2025-09-12 16:04:18'),
(97, 'Đất nền mặt tiền KDC mới Quận 9', 'Đã có sổ, xây dựng ngay, giá tốt đầu tư.', '', 4, 4, 31, 32, '', 6500000000.00, 'month', 110.00, 0, 0, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-09 17:00:00', '2025-09-12 16:04:18'),
(98, 'Văn phòng cho thuê Quận 7', 'Tòa nhà văn phòng chuyên nghiệp, dịch vụ đầy đủ.', '', 2, 5, 32, 34, '', 15000000.00, 'month', 80.00, 0, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-11 17:00:00', '2025-09-12 16:04:18'),
(99, 'Nhà trọ sinh viên gần ĐH FPT', 'Phòng có điều hòa, WC riêng, gần bus.', '', 4, 3, 1, 36, '', 2800000.00, 'month', 22.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-14 17:00:00', '2025-09-12 16:04:18'),
(100, 'Căn hộ cho thuê Phú Mỹ Hưng', 'Thiết kế hiện đại, tiện ích 5 sao.', '', 2, 1, 2, 38, '', 20000000.00, 'month', 90.00, 2, 2, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 1, '2024-04-17 17:00:00', '2025-09-14 16:56:20'),
(101, 'Nhà phố hẻm xe hơi Quận 1', 'Khu vực an ninh, dân trí cao, gần trung tâm.', '', 1, 2, 2, 40, '', 18000000000.00, 'month', 85.00, 3, 3, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-19 17:00:00', '2025-09-12 16:04:18'),
(102, 'Biệt thự mini khu Cát Lái, Q.2', 'Thiết kế tinh tế, không gian sống xanh.', '', 3, 3, 3, 42, '', 14000000000.00, 'month', 180.00, 4, 4, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-21 17:00:00', '2025-09-12 16:04:18'),
(103, 'Đất nền ven sông Quận 9', 'Lô góc 2 mặt tiền, view sông thoáng mát.', '', 4, 4, 4, 44, '', 9000000000.00, 'month', 130.00, 0, 0, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-24 17:00:00', '2025-09-12 16:04:18'),
(104, 'Văn phòng cho thuê Quận 10', 'Tòa nhà mới xây, tiện nghi đầy đủ.', '', 5, 5, 5, 46, '', 12000000.00, 'month', 70.00, 0, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-27 17:00:00', '2025-09-12 16:04:18'),
(105, 'Nhà trọ giá tốt Thủ Đức', 'Phòng rộng, sạch sẽ, khu vực yên tĩnh.', '', 4, 2, 7, 48, '', 2000000.00, 'month', 20.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 0, '2024-04-29 17:00:00', '2025-09-12 16:04:18'),
(106, 'Căn hộ 1PN Vinhomes Central Park', 'View công viên, tiện ích 5 sao.', '', 1, 1, 9, 50, '', 10000000.00, 'month', 50.00, 1, 1, 1, NULL, NULL, NULL, 'none', 0, NULL, 0, 0, 'active', 1, '2024-04-30 17:00:00', '2025-09-17 03:16:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `saved_properties`
--

CREATE TABLE `saved_properties` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `saved_properties`
--

INSERT INTO `saved_properties` (`id`, `userId`, `propertyId`, `createdAt`) VALUES
(151, 2, 1, '2025-09-12 16:30:04'),
(152, 2, 3, '2025-09-12 16:30:04'),
(153, 4, 1, '2025-09-12 16:30:04'),
(154, 4, 5, '2025-09-12 16:30:04'),
(155, 6, 2, '2025-09-12 16:30:04'),
(156, 6, 4, '2025-09-12 16:30:04'),
(157, 8, 6, '2025-09-12 16:30:04'),
(158, 8, 88, '2025-09-12 16:30:04'),
(159, 10, 87, '2025-09-12 16:30:04'),
(160, 10, 89, '2025-09-12 16:30:04'),
(161, 12, 88, '2025-09-12 16:30:16'),
(162, 12, 83, '2025-09-12 16:30:16'),
(163, 14, 85, '2025-09-12 16:30:16'),
(164, 14, 87, '2025-09-12 16:30:16'),
(165, 16, 89, '2025-09-12 16:30:16'),
(166, 16, 83, '2025-09-12 16:30:29'),
(167, 18, 83, '2025-09-12 16:30:29'),
(168, 18, 85, '2025-09-12 16:30:29'),
(169, 20, 87, '2025-09-12 16:30:29'),
(170, 20, 89, '2025-09-12 16:30:29'),
(171, 22, 1, '2025-09-12 16:30:29'),
(172, 22, 3, '2025-09-12 16:30:29'),
(173, 24, 5, '2025-09-12 16:30:29'),
(174, 24, 88, '2025-09-12 16:30:29'),
(175, 26, 89, '2025-09-12 16:30:29'),
(176, 26, 1, '2025-09-12 16:30:29'),
(177, 28, 3, '2025-09-12 16:30:29'),
(178, 28, 5, '2025-09-12 16:30:29'),
(179, 30, 87, '2025-09-12 16:30:29'),
(180, 30, 89, '2025-09-12 16:30:29'),
(181, 32, 1, '2025-09-12 16:30:29'),
(182, 32, 3, '2025-09-12 16:30:29'),
(183, 34, 5, '2025-09-12 16:30:43'),
(184, 34, 87, '2025-09-12 16:30:43'),
(185, 36, 89, '2025-09-12 16:30:43'),
(186, 36, 83, '2025-09-12 16:30:43'),
(187, 38, 93, '2025-09-12 16:30:52'),
(188, 38, 95, '2025-09-12 16:30:52'),
(189, 40, 97, '2025-09-12 16:30:52'),
(190, 40, 99, '2025-09-12 16:30:52'),
(191, 42, 91, '2025-09-12 16:30:52'),
(192, 42, 93, '2025-09-12 16:30:52'),
(193, 44, 95, '2025-09-12 16:31:04'),
(194, 44, 2, '2025-09-12 16:31:04'),
(195, 46, 99, '2025-09-12 16:31:04'),
(196, 46, 1, '2025-09-12 16:31:04'),
(197, 48, 3, '2025-09-12 16:31:04'),
(198, 48, 5, '2025-09-12 16:31:04'),
(199, 50, 97, '2025-09-12 16:31:04'),
(200, 50, 99, '2025-09-12 16:31:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `typenews`
--

CREATE TABLE `typenews` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `typenews`
--

INSERT INTO `typenews` (`id`, `name`, `description`) VALUES
(1, 'Thị trường', NULL),
(2, 'Dự án mới', NULL),
(3, 'Tư vấn', NULL),
(4, 'Pháp lý', NULL),
(5, 'Đầu tư', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_rental_property`
--

CREATE TABLE `type_rental_property` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `type_rental_property`
--

INSERT INTO `type_rental_property` (`id`, `name`, `slug`, `description`, `icon`, `status`, `createdAt`) VALUES
(1, 'Căn hộ', 'apartment', 'Căn hộ chung cư, condotel', 'fas fa-building', 'active', '2025-09-11 06:59:16'),
(2, 'Nhà phố', 'house', 'Nhà phố, nhà riêng', 'fas fa-home', 'active', '2025-09-11 06:59:16'),
(3, 'Văn phòng', 'office', 'Văn phòng cho thuê', 'fas fa-briefcase', 'active', '2025-09-11 06:59:16'),
(4, 'Phòng trọ', 'room', 'Phòng trọ, homestay', 'fas fa-bed', 'active', '2025-09-11 06:59:16'),
(5, 'Đất nền', 'land', 'Đất nền, đất thổ cư', 'fas fa-map', 'active', '2025-09-11 06:59:16');

-- --------------------------------------------------------

--
-- Cấu trúc cho view `property_list_view`
--
DROP TABLE IF EXISTS `property_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `property_list_view`  AS SELECT `p`.`id` AS `id`, `p`.`title` AS `title`, `p`.`address` AS `address`, `p`.`transactionType` AS `transactionType`, `p`.`price` AS `price`, `p`.`area` AS `area`, `p`.`bedrooms` AS `bedrooms`, `p`.`bathrooms` AS `bathrooms`, `p`.`imageCount` AS `imageCount`, `p`.`views` AS `views`, `p`.`createdAt` AS `createdAt`, `t`.`name` AS `propertyType`, `l`.`name` AS `locationName`, `a`.`fullName` AS `brokerName`, `a`.`avatar` AS `brokerAvatar`, CASE WHEN `pi`.`imagePath` is not null THEN `pi`.`imagePath` ELSE 'placeholder.svg' END AS `mainImage` FROM (((((`rental_property` `p` left join `type_rental_property` `t` on(`p`.`typeId` = `t`.`id`)) left join `location` `l` on(`p`.`locationId` = `l`.`id`)) left join `broker` `b` on(`p`.`brokerId` = `b`.`id`)) left join `account` `a` on(`b`.`accountId` = `a`.`id`)) left join `property_images` `pi` on(`p`.`id` = `pi`.`propertyId` and `pi`.`isMain` = 1)) WHERE `p`.`status` = 'active' ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `broker`
--
ALTER TABLE `broker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accountId` (`accountId`);

--
-- Chỉ mục cho bảng `broker_ratings`
--
ALTER TABLE `broker_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertyId` (`propertyId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `brokerId` (`brokerId`);

--
-- Chỉ mục cho bảng `expertises`
--
ALTER TABLE `expertises`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news-typeNews` (`typeId`);

--
-- Chỉ mục cho bảng `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertyId` (`propertyId`);

--
-- Chỉ mục cho bảng `rental_property`
--
ALTER TABLE `rental_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `typeId` (`typeId`),
  ADD KEY `brokerId` (`brokerId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `locationId` (`locationId`),
  ADD KEY `transactionType` (`transactionType`),
  ADD KEY `status` (`status`),
  ADD KEY `idx_property_price` (`price`),
  ADD KEY `idx_property_area` (`area`),
  ADD KEY `idx_property_bedrooms` (`bedrooms`),
  ADD KEY `idx_property_transaction` (`transactionType`),
  ADD KEY `idx_property_created` (`createdAt`),
  ADD KEY `idx_property_location_type` (`locationId`,`typeId`);

--
-- Chỉ mục cho bảng `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_property` (`userId`,`propertyId`),
  ADD KEY `propertyId` (`propertyId`);

--
-- Chỉ mục cho bảng `typenews`
--
ALTER TABLE `typenews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `type_rental_property`
--
ALTER TABLE `type_rental_property`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `broker`
--
ALTER TABLE `broker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `broker_ratings`
--
ALTER TABLE `broker_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `expertises`
--
ALTER TABLE `expertises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=638;

--
-- AUTO_INCREMENT cho bảng `rental_property`
--
ALTER TABLE `rental_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT cho bảng `saved_properties`
--
ALTER TABLE `saved_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT cho bảng `typenews`
--
ALTER TABLE `typenews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `type_rental_property`
--
ALTER TABLE `type_rental_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `broker`
--
ALTER TABLE `broker`
  ADD CONSTRAINT `broker_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD CONSTRAINT `contact_requests_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `rental_property` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_requests_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `account` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contact_requests_ibfk_3` FOREIGN KEY (`brokerId`) REFERENCES `broker` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news-typeNews` FOREIGN KEY (`typeId`) REFERENCES `typenews` (`id`);

--
-- Các ràng buộc cho bảng `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `rental_property` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rental_property`
--
ALTER TABLE `rental_property`
  ADD CONSTRAINT `rental_property_ibfk_1` FOREIGN KEY (`typeId`) REFERENCES `type_rental_property` (`id`),
  ADD CONSTRAINT `rental_property_ibfk_2` FOREIGN KEY (`brokerId`) REFERENCES `broker` (`id`),
  ADD CONSTRAINT `rental_property_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `account` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rental_property_ibfk_4` FOREIGN KEY (`locationId`) REFERENCES `location` (`id`);

--
-- Các ràng buộc cho bảng `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD CONSTRAINT `saved_properties_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_properties_ibfk_2` FOREIGN KEY (`propertyId`) REFERENCES `rental_property` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
