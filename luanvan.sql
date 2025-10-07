-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 07, 2025 lúc 04:50 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
  `role` enum('1','2','3') NOT NULL COMMENT '1=User, 2=Broker, 3=Admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `fullName`, `email`, `phoneNumber`, `password`, `avatar`, `address`, `role`, `status`, `createdAt`, `updatedAt`) VALUES
(68, 'Quản trị viên', 'admin@gmail.com', '0835672970', '$2y$10$FTcB.sYiBP6HBo8AWqh0AOA.vRtR723NYpHJ86VwQhuvTv7mbbKGm', 'null', 'Cần Thơ', '3', 'active', '2025-10-01 14:08:52', '2025-10-01 14:34:28'),
(69, 'Võ Thị Ngọc An', 'thuyanvo@gmail.com', '0836752971', '$2y$10$xwNR1FkXM8mtwmm4gc5vAeGStchQV0xllpZoM6CIhUGTsQBmnxUou', '123456788.webp', '1A Nguyễn Văn Đậu, P.5, Q. Bình Thạnh, TP.HCM', '1', 'active', '2025-10-01 14:31:54', '2025-10-05 09:18:23'),
(70, 'Võ Văn Tuấn', 'vovantuan@gmail.com', '0836752981', '$2y$10$369Mld5Ji6i0iPJS.hn6/.iuKQRLVZb1o4y9BIOvGvWQu8L.UEV3q', 'null', '1A Nguyễn Văn Đậu, P.7, Q.9, TP.HCM', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:34:59'),
(71, 'Đỗ Trung Hiếu', 'hieudo@gmail.com', '0836752972', '$2y$10$JNYihRBaXY/g6YntOqE0/eTHFRVB2lhjlRbCRIT3ZwumjaoM1xK3e', 'null', 'Cổng A, KCN Tân Bình, Tân Phú, TP.HCM', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:35:11'),
(72, 'Bùi Tấn Tài', 'taibui@gmail.com', '0836752973', '$2y$10$qre2NPAm0rSpuvxCGc44KO3XQpDA/nu.oOiSxd0kaTreuNy.tgCJO', '123456780.webp', 'Khu phố 6, P. Linh Trung, TP. Thủ Đức', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 03:26:59'),
(73, 'Phạm Hữu Minh', 'minhpham@gmail.com', '0836752983', '$2y$10$pzz3UHUsuRXIaxAimHH9buZlBdzD.Rj06Jm2UYYG6yBK7tZQjmCJG', '123456781.webp', 'Khu phố 6, P. Linh Trung, Q.Gò Vấp', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:02:18'),
(74, 'Trịnh Hoài Nam', 'namtrinh@gmail.com', '0836752974', '$2y$10$4xDsVopyCkMfAIzvQF5s4ufh2q3aNErMRSjHcFjv2ieCmu2DhpctG', 'null', '210 Lạc Long Quân, P.10, Q.11, TP.HCM', '1', 'inactive', '2025-10-01 14:31:54', '2025-10-04 02:45:33'),
(75, 'Mai Thị Diệu Linh', 'linhmai@gmail.com', '0836752975', '$2y$10$1CGQD4TmJNBAbBQyqqOgiufDxkBVhYlv6KExCuoBS7in94YT8jAXa', 'null', 'Thị trấn Đông Anh, Huyện Đông Anh, Hà Nội', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:36:43'),
(76, 'Ngô Quang Minh', 'minhngo@gmail.com', '0836752976', '$2y$10$VyonR9YHWdmQsJ0I4aJDLeS89YqRNwmZybahUYRe8h9iEcTUdNDwq', '123456782.webp', '24/2 Quang Trung, P.12, Q. Gò Vấp, TP.HCM', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:02:34'),
(77, 'Lý Hoàng Phúc', 'phucly@gmail.com', '0836752977', '$2y$10$M.GCfIxR7.ECp6pONZbUkOKtXqUUUpcIkX4pCJ4a3a/wVXCBry.8y', 'null', '88 Trần Phú, Quận Hải Châu, Đà Nẵng', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:36:43'),
(78, 'Phan Kim Yến', 'yenphan@gmail.com', '0836752978', '$2y$10$dNGXz4No1qrwgtQwOuxeN.mDJmURPtkwJNljJD3bVnX/a6TIn8EnS', 'null', 'Phố Hàng Ngang, Quận Hoàn Kiếm, Hà Nội', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:36:43'),
(79, 'Nguyễn Thanh Tùng', 'tungnguyen@gmail.com', '0836752979', '$2y$10$0WKwlONjC.YBU4118BSS3esnVyztMCS4PPOFjN.6PBs4ffnva8gA6', '123456783.webp', '25B Hùng Vương, P.2, TP. Sóc Trăng', '2', 'inactive', '2025-10-01 14:31:54', '2025-10-04 04:02:49'),
(80, 'Đặng Việt Khoa', 'khoadang@gmail.com', '0836752980', '$2y$10$eSWOsy6FV4EocPIZOozn6uEBo4zN9DQ9I5yQMrvYbpZp.qCVl8yIi', 'null', 'Tổ 3, P. Bình Thủy, TP. Cần Thơ', '1', 'active', '2025-10-01 14:31:54', '2025-10-01 14:36:43'),
(81, 'Phạm Minh Hào', 'haopham@gmail.com', '0836752989', '$2y$10$c0MPGp.ZiTgtGctXiMv8S.kVsj8/8eVA3Gk.dbHN6PZlevYXanEJq', '123456784.webp', 'Q. Bình Thạnh, TP.Hồ Chí Minh', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:03:14'),
(82, 'Phạm Minh Phong', 'phongpham@gmail.com', '0836752988', '$2y$10$c0MPGp.ZiTgtGctXiMv8S.kVsj8/8eVA3Gk.dbHN6PZlevYXanEJq', '123456785.jpg', 'Q.Thủ Đức, TP.Hồ Chí Minh', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:03:33'),
(83, 'Ngô Quốc Tuấn', 'tuanngo@gmail.com', '0836752987', '$2y$10$c0MPGp.ZiTgtGctXiMv8S.kVsj8/8eVA3Gk.dbHN6PZlevYXanEJq', '123456786.jpg', 'Q.1, TP.Hồ Chí Minh', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:03:50'),
(84, 'Đào Khải Minh', 'minhdao@gmail.com', '0836752986', '$2y$10$c0MPGp.ZiTgtGctXiMv8S.kVsj8/8eVA3Gk.dbHN6PZlevYXanEJq', '123456787.jpg', 'Q.3, TP.Hồ Chí Minh', '2', 'active', '2025-10-01 14:31:54', '2025-10-04 04:04:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `broker`
--

CREATE TABLE `broker` (
  `id` int(11) NOT NULL,
  `accountId` int(11) NOT NULL,
  `shortIntro` text DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `expertise` text DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `workingHours` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `broker`
--

INSERT INTO `broker` (`id`, `accountId`, `shortIntro`, `location`, `expertise`, `language`, `workingHours`, `createdAt`, `updatedAt`) VALUES
(37, 72, 'Hơn 8 năm kinh nghiệm tư vấn nhà đất thổ cư và dự án cao cấp tại khu vực Quận 2 và Quận 7. Đảm bảo pháp lý rõ ràng.', 19, 'Nhà ở, Chung cư', 'Tiếng Anh, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(38, 73, 'Phân tích thị trường chứng khoán Phái sinh và Cơ sở. Hỗ trợ xây dựng danh mục đầu tư linh hoạt, quản trị rủi ro tối ưu.', 14, 'Nhà ở, Đất nền', 'Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(39, 76, 'Tư vấn giải pháp phần mềm, hệ thống mạng và chuyển đổi số cho doanh nghiệp vừa và nhỏ.', 14, 'Đất nền', 'Tiếng Trung', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(40, 79, 'Chuyên tư vấn hồ sơ du học và định cư Canada, Úc. Tỷ lệ visa thành công cao.', 14, 'Văn phòng', 'Tiếng Trung, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(41, 81, 'Hỗ trợ lập kế hoạch tài chính cá nhân và bảo hiểm trọn đời, đảm bảo an toàn cho tương lai.', 13, 'Nhà ở, Văn phòng', 'Tiếng Trung, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(42, 82, 'Hơn 8 năm kinh nghiệm tư vấn nhà đất thổ cư và dự án cao cấp tại khu vực Quận 2 và Quận 7. Đảm bảo pháp lý rõ ràng.', 19, 'Nhà ở', 'Tiếng Trung, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(43, 83, 'Phân tích thị trường chứng khoán Phái sinh và Cơ sở. Hỗ trợ xây dựng danh mục đầu tư linh hoạt, quản trị rủi ro tối ưu.', 1, 'Nhà ở', 'Tiếng Trung, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41'),
(44, 84, 'Phân tích thị trường chứng khoán Phái sinh và Cơ sở. Hỗ trợ xây dựng danh mục đầu tư linh hoạt, quản trị rủi ro tối ưu.', 3, 'Nhà ở', 'Tiếng Trung, Tiếng Việt', '8h-12h 14h-18h', '2025-10-01 15:01:41', '2025-10-01 15:01:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `broker_ratings`
--

CREATE TABLE `broker_ratings` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `brokerId` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `brokerId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `location` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `status` enum('pending','inProgress','completed','canceled') DEFAULT 'pending',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `userId`, `brokerId`, `name`, `phone`, `message`, `location`, `subject`, `price`, `note`, `status`, `createdAt`, `updatedAt`) VALUES
(17, 0, 0, 'Bùi Minh Quân', '0836752991', 'Tìm trọ gần trường Đại học Bách Khoa', 5, 'Tư vấn mua bán', '5 - 8 triệu', '', 'pending', '2025-10-04 03:08:55', '2025-10-04 03:08:55'),
(18, 0, 0, 'Nguyễn Thị Kiều', '0836752992', 'Tìm căn hộ cao cấp', 23, 'Tư vấn cho thuê', 'Trên 8 triệu', '', 'pending', '2025-10-04 03:12:56', '2025-10-04 03:12:56'),
(19, 0, 0, 'Nguyễn Thị Hà', '0836752993', 'Xử lý lâu', 23, 'Khiếu nại', '0', '', 'pending', '2025-10-04 03:13:42', '2025-10-04 03:13:42'),
(20, 0, 0, 'Trần Minh Long', '0836752994', 'Tìm phòng trọ', 7, 'Tư vấn mua bán', '3 - 5 triệu', '', 'pending', '2025-10-04 03:14:16', '2025-10-04 03:14:16'),
(21, 0, 0, 'Nguyễn Quốc Đạt', '0836752995', 'Tìm nhà trọ rẻ', 20, 'Tư vấn cho thuê', 'Dưới 3 triệu', '', 'pending', '2025-10-04 03:15:00', '2025-10-04 03:15:00'),
(22, 69, 0, 'Võ Thị Ngọc An', '0836752971', 'Cần tìm nhà trọ giá rẻ', 24, 'Tư vấn cho thuê', '3 - 5 triệu', '', 'pending', '2025-10-05 09:26:25', '2025-10-05 09:26:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expertises`
--

CREATE TABLE `expertises` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `expertises`
--

INSERT INTO `expertises` (`id`, `name`, `description`, `icon`) VALUES
(1, 'Nhà ở', 'Chuyên về mua bán, cho thuê nhà ở các loại', 'fas fa-home'),
(2, 'Chung cư', 'Chuyên về căn hộ chung cư, condotel', 'fas fa-building'),
(3, 'Đất nền', 'Chuyên về đất nền, đất thổ cư, đất dự án', 'fas fa-map'),
(4, 'Văn phòng', 'Chuyên về cho thuê văn phòng, mặt bằng kinh doanh', 'fas fa-briefcase');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follow_broker`
--

CREATE TABLE `follow_broker` (
  `id` int(11) NOT NULL,
  `idBroker` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `follow_broker`
--

INSERT INTO `follow_broker` (`id`, `idBroker`, `idUser`, `createdAt`) VALUES
(42, 37, 69, '2025-10-05'),
(43, 38, 69, '2025-10-05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `location`
--

INSERT INTO `location` (`id`, `name`) VALUES
(1, 'Quận 1'),
(2, 'Quận 2'),
(3, 'Quận 3'),
(4, 'Quận 4'),
(5, 'Quận 5'),
(6, 'Quận 6'),
(7, 'Quận 7'),
(8, 'Quận 8'),
(9, 'Quận 9'),
(10, 'Quận 10'),
(11, 'Quận 11'),
(12, 'Quận 12'),
(13, 'Quận Bình Thạnh'),
(14, 'Quận Gò Vấp'),
(15, 'Quận Phú Nhuận'),
(16, 'Quận Tân Bình'),
(17, 'Quận Tân Phú'),
(18, 'Quận Bình Tân'),
(19, 'Thành phố Thủ Đức'),
(20, 'Huyện Bình Chánh'),
(21, 'Huyện Cần Giờ'),
(22, 'Huyện Củ Chi'),
(23, 'Huyện Hóc Môn'),
(24, 'Huyện Nhà Bè');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `image` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `pin` tinyint(1) NOT NULL DEFAULT 0,
  `typeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `content`, `createdAt`, `views`, `pin`, `typeId`) VALUES
(23, 'Chưa đầy 1 tuần nữa, \"siêu cầu\' hơn 7.300 tỷ bắc qua sông Hồng, rộng 8 làn xe, cách cầu Thăng Long chỉ 6km sẽ được khởi công', '68e082cd2aaf2.jpg', '<p><br>&nbsp;</p><p>&nbsp;</p><h2><strong>Vào ngày 10/10 sắp tới, dự án đầu tư xây dựng cầu Thượng Cát và đường hai đầu cầu sẽ chính thức được khởi công.</strong></h2><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-bac-qu-1759534258646254949591-1759542286312-17595422877471731238826.jpg\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-bac-qu-1759534258646254949591-1759542286312-17595422877471731238826.jpg\" alt=\"Chưa đầy 1 tuần nữa, \"></a></p><p>Vị trí cầu Thượng Cát dự kiến cách cầu Thăng Long khoảng 5-6 km.</p><p>Dự án đầu tư xây dựng cầu Thượng Cát và đường hai đầu cầu sẽ được thành phố Hà Nội khởi công vào ngày 10/10 sắp tới, đúng dịp kỷ niệm 71 năm Ngày Giải phóng Thủ đô (10-10-1954 – 10-10-2025).</p><p>Theo đó, dự án cầu Thượng Cát có tổng chiều dài cầu và đường hai đầu cầu là 5,226km, trong đó chiều dài cầu chính là 780m; cầu dẫn dài 3,125km; đường hai đầu cầu dài 1,321km; tổng mức đầu tư 7.303 tỷ đồng, sử dụng nguồn vốn ngân sách thành phố.</p><p>Tổng mức đầu tư 7.303 tỷ đồng, sử dụng nguồn vốn ngân sách thành phố. Cầu được thiết kế với 8 làn xe (6 làn xe cơ giới và 2 làn thô sơ), bề rộng cầu chính 35m.</p><p>&nbsp;</p><p>ADVERTISING</p><p>&nbsp;</p><p>iTVC from Admicro</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-bac-2-1759534243770183240741-1759542286312-17595422877442026971938.jpg\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-bac-2-1759534243770183240741-1759542286312-17595422877442026971938.jpg\" alt=\"Chưa đầy 1 tuần nữa, \"></a></p><p>Cầu sẽ nối Bắc Từ Liêm với huyện Đông Anh cũ - nay là xã Thiên Lộc.</p><p>Theo phương án được TP Hà Nội phê duyệt, điểm đầu dự án nằm tại nút giao với đường Kỳ Vũ, phường Thượng Cát (quận Bắc Từ Liêm cũ) - nay là phường Thượng Cát. Điểm cuối nằm tại nút giao với đường 23B, thuộc xã Đại Mạch, huyện Đông Anh (cũ) - nay là xã Thiên Lộc.</p><p>Việc đầu tư xây dựng cầu Thượng Cát sẽ góp phần đảm bảo tính đồng bộ, thông suốt, nối thông toàn tuyến đường Vành đai 3,5 từ phía Nam lên phía Bắc Sông Hồng; mở thêm đường kết nối phía Tây, Tây Nam Thủ đô giữa các quận, huyện phía Bắc và Nam Sông Hồng; góp phần kết nối liên thông với các tuyến đường khung quan trọng của Thủ đô.</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-1-17595342546361372187678-1759542286312-17595422877391541013499.jpg\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/cau-thuong-cat-1-17595342546361372187678-1759542286312-17595422877391541013499.jpg\" alt=\"Chưa đầy 1 tuần nữa, \"></a></p><p>Đường Vành đai 3,5 đi đến cầu Thượng Cát sẽ giao với đường Tây Thăng Long và chạy song song với đường 70.</p><p>Bên cạnh đó, cây cầu tạo tiềm lực kinh tế và nâng cao giá trị bất động sản cho những khu vực mà Tuyến đường đi qua, góp phần thúc đẩy phát triển kinh tế xã hội và tăng cường củng cố an ninh, quốc phòng các quận, huyện: Bắc Từ Liêm, Đông Anh, Mê Linh, Thanh Trì, Hà Đông, Hoài Đức và các địa phương khu vực phía Bắc sông Hồng nói riêng và Thủ đô Hà Nội nói chung.</p><p>Cầu Thượng Cát là một trong 10 cầu bắc qua sông Hồng nằm trong Quy hoạch Giao thông vận tải Hà Nội, được thực hiện trong giai đoạn 2015-2030.</p><p>9 cầu còn lại gồm: Hồng Hà, Mễ Sở (vành đai 4), Thăng Long mới (vành đai 3), Tứ Liên, Vĩnh Tuy (giai đoạn 2), Ngọc Hồi (vành đai 3,5), cầu/hầm Trần Hưng Đạo, cầu Phú Xuyên, Vân Phúc (đường trục Bắc - Nam nối với tỉnh Vĩnh Phúc).</p>', '2025-10-04', 1, 0, 2),
(24, 'Phương án mới nhất về khai thác chuyến bay quốc tế ở Tân Sơn Nhất và Long Thành', '68e085cdd0a82.png', '<h2><strong>Bộ Xây dựng vừa báo cáo Chính phủ về phương án khai thác Cảng Hàng không quốc tế Tân Sơn Nhất và Long Thành giai đoạn 1. Theo đó, từ năm 2026, Long Thành sẽ đảm nhận tới 80% các chuyến bay quốc tế, trở thành cửa ngõ trung chuyển hàng không của Việt Nam.</strong></h2><p>Theo báo cáo của Bộ Xây dựng , Cảng Hàng không quốc tế (HKQT) Long Thành giai đoạn 1 (công suất 25 triệu hành khách/năm) được xác định khai thác song song với Cảng HKQT Tân Sơn Nhất theo mô hình “cặp cảng quốc tế”, trong đó Nhà nước chủ động điều phối, phân định tỷ lệ chuyến bay quốc tế - quốc nội theo từng thời kỳ.</p><p>Từ năm 2026, Long Thành sẽ đảm nhận 80% chuyến bay quốc tế và 10% chuyến bay nội địa, trong khi Tân Sơn Nhất khai thác 20% chuyến bay quốc tế và 90% chuyến bay nội địa.</p><p><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/san-bay-long-thanh-1759540516899-1759540517269554436119.png\" alt=\"Phương án mới nhất về khai thác chuyến bay quốc tế ở Tân Sơn Nhất và Long Thành- Ảnh 1.\"></p><p>Nhà ga sân bay Long Thành giai đoạn 1 hiện tại. Ảnh: NAG Nguyễn Minh Tú.</p><p>Cụ thể, Long Thành phụ trách toàn bộ đường bay quốc tế từ 1.000 km trở lên, cùng với một số đường bay khác do các hãng hàng không lựa chọn. Dự kiến, vận chuyển 10-12% sản lượng trên trục Hà Nội - TPHCM và Đà Nẵng - TPHCM.</p><p>Tân Sơn Nhất tập trung khai thác các đường bay quốc tế dưới 1.000 km, chủ yếu với thị trường Thái Lan, Campuchia và Lào (chiếm 15-17% tổng khai thác quốc tế đến TPHCM). Phần lớn khai thác nội địa vẫn do sân bay này đảm nhận. Việc phân định này sẽ được đánh giá, điều chỉnh sau 5 năm khai thác thực tế , bảo đảm phù hợp với nhu cầu và năng lực hạ tầng từng thời kỳ.</p><p>Bộ Xây dựng nhấn mạnh, dự án đầu tư Cảng HKQT Long Thành là công trình trọng điểm quốc gia, với quy mô lớn, kết cấu phức tạp, hiện đang được các chủ đầu tư gấp rút thi công để sớm đưa vào vận hành theo tiến độ.</p><p>Việc chuẩn bị tốt cho giai đoạn khai thác, đặc biệt là sự phối hợp giữa Long Thành và Tân Sơn Nhất , sẽ quyết định hiệu quả đầu tư và vị thế trung chuyển quốc tế của ngành hàng không Việt Nam trong tương lai.</p><p>&nbsp;</p><p><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/nha-ga-t3-san-bay-tan-son-nhat-anh-huu-huy-5062-726-1759540516899-1759540517266513120781.jpeg\" alt=\"Phương án mới nhất về khai thác chuyến bay quốc tế ở Tân Sơn Nhất và Long Thành- Ảnh 2.\"></p><p>Nhà ga T3 sân bay Tân Sơn Nhất. Ảnh: ACV.</p><p>“Bộ Xây dựng sẽ tiếp tục tổ chức đánh giá, chủ động điều phối và phân định tỷ lệ khai thác quốc tế - nội địa tại từng cảng hàng không theo từng thời kỳ, nhằm bảo đảm tổ chức khai thác hiệu quả Cảng HKQT Long Thành và Cảng HKQT Tân Sơn Nhất”, văn bản của Bộ nêu rõ.</p><p>Được biết, để bảo đảm mục tiêu, Thủ tướng đã giao Bộ Xây dựng thành lập Tổ công tác chuẩn bị khai thác Long Thành. Trong thời gian qua, Tổng Công ty Cảng hàng không Việt Nam ( ACV ) đã thuê Liên danh Incheon Airport (IAC) tư vấn, xây dựng bộ tài liệu Khái niệm khai thác (CONOPS) và Kế hoạch tổng thể vận hành.</p><p>Tư vấn IAC đã nghiên cứu 2 phương án, trong đó kiến nghị chuyển toàn bộ các chuyến bay quốc tế thường lệ từ Tân Sơn Nhất sang Long Thành để thuận lợi quản lý, tối ưu hóa nguồn lực, đồng thời tạo tiền đề để Long Thành trở thành trung tâm trung chuyển hàng không của khu vực, cạnh tranh với các sân bay lớn trên thế giới.</p><p>Trên cơ sở đó, Cục Hàng không Việt Nam và ACV đã thống nhất phương án phân chia khai thác, báo cáo Bộ Xây dựng để trình cấp có thẩm quyền xem xét. Lộ trình chuyển giao được xác định chi tiết, nhằm đảm bảo khai thác an toàn, phát huy hiệu quả đầu tư ngay từ những ngày đầu vận hành.</p><p>Dự án Cảng HKQT Long Thành xây trên diện tích 5.000 ha, tổng vốn gần 336.630 tỷ đồng, là công trình trọng điểm quốc gia. Khi hoàn thành cả ba giai đoạn, công trình có công suất phục vụ 100 triệu lượt khách, 5 triệu tấn hàng hóa mỗi năm.</p><p>Ngày 26/9, chuyến bay kiểm tra hiệu chuẩn đầu tiên đã bay vào vùng trời Long Thành. Hoạt động này diễn ra trong 1 tháng, nhằm đánh giá toàn diện hệ thống dẫn đường và giám sát hàng không, đánh dấu cột mốc quan trọng chuẩn bị cho ngày cất cánh 19/12 tới.</p>', '2025-10-04', 1, 0, 3),
(25, 'Ít ai ngờ, \"bà trùm\" bất động sản đặt mục tiêu xây 40.000 căn nhà ở xã hội từng là người bán quán nước ven đường tại Bình Dương', '68e086306b1ee.png', '<h2><strong>Từ khởi đầu giản dị với quán nước nhỏ, bà Đặng Thị Kim Oanh đã gây dựng nên Kim Oanh Group, nay đặt cược lớn vào phân khúc nhà ở xã hội, hướng tới mục tiêu hoàn thành 40.000 căn nhà ở xã hội trong 5 năm tới.</strong></h2><h2>Trong bối cảnh nhu cầu về nhà ở xã hội (NOXH) ngày càng trở nên cấp bách tại các đô thị vệ tinh quanh TP.HCM, Kim Oanh Group nổi lên như một trong những tập đoàn bất động sản phía Nam tích cực đặt cược vào phân khúc này. Với kế hoạch triển khai hàng chục dự án NOXH trong giai đoạn 2023-2028, tập đoàn đặt mục tiêu trở thành tên tuổi dẫn dắt, chỉ xếp sau Địa ốc Hoàng Quân – doanh nghiệp lâu năm trong lĩnh vực này.</h2><p>Người đứng sau Kim Oanh Group là bà Đặng Thị Kim Oanh (sinh năm 1970, quê Thừa Thiên Huế) – Chủ tịch HĐQT kiêm Tổng Gíam đốc.</p><p>Ít ai ngờ rằng, trước khi bước chân vào bất động sản, bà từng chỉ là người bán quán nước ven đường tại Bình Dương. Ngày đó, Bình Dương rất hoang vắng, chỉ có các chủ đầu tư đến xem và ghé vào quán nước của bà để trao đổi thêm trong vấn đề đầu tư bất động sản. Nghe bàn về bất động sản \"quen tai\", mối lương duyên của bà Oanh với nghề môi giới bất động sản cũng bắt đầu từ đó.</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/ba-dang-thi-kim-oanh-chu-421673520076-17594749790371863903631-1759540240126-17595402406251039762140.jpg\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/ba-dang-thi-kim-oanh-chu-421673520076-17594749790371863903631-1759540240126-17595402406251039762140.jpg\" alt=\"Ít ai ngờ, \"></a></p><p>Bà Đặng Thị Kim Oanh - người sáng lập Kim Oanh Group.</p><p><strong>Từ cơn sốt đất Bình Dương đến khát vọng “bà trùm” nhà ở xã hội</strong></p><p>Cơn sốt đất Bình Dương những năm trước 2008 đã mở ra cơ hội để bà thành lập văn phòng tư vấn và chính thức đặt nền móng cho Kim Oanh Real Estate.</p><p>Tháng 4/2009, bà Oanh thành lập CTCP Dịch vụ Thương mại và Xây dựng Địa ốc Kim Oanh với vốn điều lệ ban đầu 48 tỷ đồng. Khi ấy, công ty tập trung vào phân khúc đất nền và nhà giá rẻ. Nhờ nắm bắt được thị hiếu, công ty nhanh chóng mở rộng ra Đồng Nai và TP.HCM chỉ sau một năm. Đến năm 2014, doanh nghiệp chuyển đổi mô hình từ đơn vị môi giới sang nhà phát triển dự án.</p><p>Bước ngoặt lớn nhất của Kim Oanh Group là vào năm 2023, khi công bố kế hoạch xây dựng 26 dự án nhà ở giai đoạn 2023-2028, trong đó 23 dự án NOXH và 3 dự án nhà ở thu nhập thấp, tổng cộng khoảng 40.000 sản phẩm với mức đầu tư 31.000 tỷ đồng. Riêng giai đoạn 1, tập đoàn dự kiến đưa ra thị trường 25.000 sản phẩm đến năm 2026.</p><p><strong>Nếu Kim Oanh Group làm đúng kế hoạch này, họ sẽ trở thành \"bà trùm\" NOXH chỉ đứng sau CTCP Tư Vấn - Thương Mại – Dịch Vụ - Địa ốc Hoàng Quân (HQC).</strong></p><p>Gần đây, tập đoàn đã bắt đầu khởi động nhiều dự án nhà ở xã hội. Gần nhất ngày 23/9, Kim Oanh Land động thổ dự án K-Home Cityview tại Đồng Nai trên địa bàn tỉnh Đồng Nai. Trước đó, ngày 21/8/2025, tập đoàn cùng lúc động thổ các dự án K-Home Avenue, K-Home Midtown, K-Home Skyview tại Nhơn Trạch và Trảng Bom với tổng cộng khoảng 5.500 căn hộ.</p><p>Vào đầu năm 2025, doanh nghiệp đã công bố dự án nhà ở xã hội chuẩn Singapore đầu tiên tại Việt Nam mang tên K-Home New City, tọa lạc tại thành phố mới Bình Dương với quy mô gần 27 ha, cung cấp cho thị trường 3.310 sản phẩm căn hộ và nhà phố.</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/screenshot-2025-10-03-142813-1759476508067487991393-1759540240126-1759540240627342128809.png\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/screenshot-2025-10-03-142813-1759476508067487991393-1759540240126-1759540240627342128809.png\" alt=\"Ít ai ngờ, \"></a></p><p>Dự án nhà ở xã hội K-Home New City bắt đầu bước vào giai đoạn hoàn thiện.</p><p>&nbsp;</p><p>Sau gần 2 thập kỷ, Kim Oanh Group đã trở thành một trong những nhà phát triển bất động sản lớn tại khu vực phía Nam. Tập đoàn hiện sở hữu danh mục hơn 50 dự án trải dài từ Đồng Nai, TP HCM (Bình Dương và Bà Rịa – Vũng Tàu cũ), một số dự án nổi bật có thể kể đến như Golden Center City, Richland Residence, Mega City 1 &amp; 2, Century City, The EastGate, Legacy Central…</p><p>Không chỉ dừng lại ở các dự án quy mô trung bình, Kim Oanh Group còn ghi dấu ấn bằng loạt dự án tỷ USD. Tiêu biểu là The One World (Bình Dương) với quy mô gần 50 ha và tổng vốn đầu tư hơn 1 tỷ USD. Gần đây, ngày 27/9, tập đoàn tiếp tục khởi công dự án One Era tại phường Thuận Giao, TP.HCM, có tổng mức đầu tư trên 1 tỷ USD, được phát triển cùng các đối tác Nhật Bản.</p><p>Theo công bố trên website, Kim Oanh Group hiện nắm giữ khoảng 500 ha quỹ đất, mỗi năm đưa ra thị trường khoảng 6.000 sản phẩm và duy trì lực lượng gần 1.200 nhân sự.</p><p><strong>Những rào cản trên hành trình thành “bà trùm”</strong></p><p>&nbsp;</p><p>Dù tham vọng lớn, hành trình để trở thành \"bà trùm\" NOXH của Kim Oanh Group không hề bằng phẳng. Doanh nghiệp đang đối diện nhiều vướng mắc pháp lý trong quá trình triển khai, đặc biệt là trong việc ghi nhận chi phí đất.</p><p>Bà Kim Oanh cho biết, có những dự án mà doanh nghiệp đã chi hơn 780 tỷ đồng từ năm 2018 để mua lại quỹ đất, nhưng khi chuyển đổi sang NOXH, cơ quan quản lý chỉ ghi nhận giá trị khoảng 100 tỷ đồng theo khung giá của tỉnh, khiến tập đoàn lỗ kế toán khoảng 600 tỷ đồng.</p><p>\"Từ một quỹ đất trị giá 1.000 tỷ đồng, khi làm NOXH, giá trị chỉ còn 100 tỷ đồng. Đây là điều bất cập, chưa hợp lý\", bà Oanh từng nhấn mạnh.</p><p>Không chỉ dừng ở vấn đề chi phí, Kim Oanh Group còn đề xuất Nhà nước cần rút ngắn thủ tục, giảm lãi suất vay, kéo dài thời hạn cho vay và nới trần lợi nhuận đối với NOXH để khuyến khích doanh nghiệp tham gia.</p><p>Song hành với tốc độ mở rộng, tập đoàn này cũng không tránh khỏi những lùm xùm. Việc phát triển quá nhanh từng khiến Kim Oanh Group vướng vào một số lùm xùm, như “xé rào” chuyển nhượng dự án Mega City 2 khi chưa đủ điều kiện pháp lý, hay tranh chấp đất đai liên quan đến Khu công nghiệp Phú Tân (Bình Dương).</p><p>Đáng chú ý, năm 2023, Chủ tịch HĐQT Đặng Thị Kim Oanh còn&nbsp;vướng vào vụ kiện tụng với gia đình ông Trần Quí Thanh (Tân Hiệp Phát), thu hút sự quan tâm lớn từ dư luận.</p><p><br>&nbsp;</p>', '2025-10-04', 6, 1, 1),
(26, 'Nóng: Nhà hát Ngọc Trai gần 13.000 tỷ đồng do Sun Group làm chủ đầu tư sẽ chính thức khởi công vào ngày mai', '68e0868222f6b.png', '<p><br>&nbsp;</p><p>&nbsp;</p><h2><strong>Nhà hát Ngọc Trai là một trong những dự án trọng điểm nhân dịp kỷ niệm 71 năm Giải phóng Thủ đô (10/10/1954 – 10/10/2025).</strong></h2><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/enscape-2020-12-09-11-23-59-1757564590766-17575645909091406320216-1759482584603468481690-1759540338545-17595403387991777062240.png\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/enscape-2020-12-09-11-23-59-1757564590766-17575645909091406320216-1759482584603468481690-1759540338545-17595403387991777062240.png\" alt=\"Nóng: Nhà hát Ngọc Trai gần 13.000 tỷ đồng do Sun Group làm chủ đầu tư sẽ chính thức khởi công vào  ngày mai- Ảnh 1.\"></a></p><p>Ngày mai (5/10), Hà Nội sẽ chính thức khởi công Dự án Nhà hát Ngọc Trai và Công viên văn hóa nghệ thuật chuyên đề tại phường Tây Hồ. Đây là một trong những dự án trọng điểm nhân dịp kỷ niệm 71 năm Giải phóng Thủ đô (10/10/1954 – 10/10/2025).</p><p>Dự án có tổng vốn đầu tư gần 13.000 tỷ đồng (gần 500 triệu USD) do Công ty TNHH Thành phố Mặt trời (đơn vị thuộc hệ sinh thái Sun Group) làm chủ đầu tư và được kỳ vọng trở thành công trình biểu tượng mới của Hà Nội trong tương lai.</p><p>Nhà hát Ngọc Trai (Nhà hát Opera Hà Nội), sẽ được xây dựng tại bán đảo Quảng An, TP Hà Nội - vị trí được coi là \"viên ngọc\" của Thủ đô. Dự án có quy mô hơn 19 ha, trong đó diện tích dành cho nhà hát và công viên văn hóa nghệ thuật chiếm tới hơn 18 ha. Thời hạn hoạt động dự án là 50 năm kể từ khi được thành phố cho thuê đất.</p><p>Nhà hát Opera Hà Nội là một phần của dự án Sun Grand City Tây Hồ View, do Sun Group đầu tư. Phía đông và đông nam khu đất giáp đường Đặng Thai Mai, phía tây giáp Hồ Tây. Dự án có phía tây bắc giáp khu dân cư hiện hữu và phía bắc là đường quy hoạch nối Đặng Thai Mai với Quảng Bá.</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/2-quy-hoach-ho-tay-nha-hat-ngoc-1757564589824-1757564589999927949499-17594825845961117302389-1759540338546-17595403387881491671364.png\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/2-quy-hoach-ho-tay-nha-hat-ngoc-1757564589824-1757564589999927949499-17594825845961117302389-1759540338546-17595403387881491671364.png\" alt=\"Nóng: Nhà hát Ngọc Trai gần 13.000 tỷ đồng do Sun Group làm chủ đầu tư sẽ chính thức khởi công vào  ngày mai- Ảnh 2.\"></a></p><p>Nhà hát Ngọc Trai sẽ được xây dựng tại bán đảo Quảng An, TP Hà Nội</p><p>Theo kế hoạch, tiến độ triển khai được chia thành ba giai đoạn: giai đoạn chuẩn bị từ quý I - III/2025; giai đoạn xây dựng từ quý IV/2025 - I/2029; và giai đoạn hoàn thiện từ quý II - III/2029.</p><p>&nbsp;</p><p>ADVERTISING</p><p>&nbsp;</p><p>iTVC from Admicro</p><p>Điểm nhấn của Nhà hát Ngọc Trai nằm ở thiết kế kiến trúc độc đáo với hình ảnh mái vòm lấy cảm hứng từ những gợn sóng Hồ Tây, được phủ ceramic tạo hiệu ứng óng ánh, phản chiếu sắc màu thay đổi theo ánh sáng tự nhiên. Đặc biệt, nhà hát sử dụng kết cấu vỏ mái siêu mỏng với độ dày chỉ từ 200 – 600 mm.</p><p>Tác giả của công trình là kiến trúc sư Renzo Piano – người đứng sau nhiều biểu tượng kiến trúc thế giới như Trung tâm Georges Pompidou (Paris) hay tòa tháp The Shard (London).</p><p>Không gian khán phòng bên trong cũng được đầu tư công nghệ hiện đại, với hệ thống tường acoustic cơ động giúp điều chỉnh phản xạ âm, hút âm và thời gian âm vang theo từng loại hình nghệ thuật biểu diễn.</p><p>Dự kiến, nhà hát có sức chứa hơn 2.000 chỗ ngồi, trở thành một trong những nhà hát lớn nhất châu Á.</p><p><a href=\"https://cafefcdn.com/203337114487263232/2025/10/4/nha-hat-opera-ha-noi-1-17474499667421942980541-400-512-952-1566-crop-1747454308940258740533-17594832848301913416748-1759540338546-17595403388201955554707.png\"><img src=\"https://cafefcdn.com/203337114487263232/2025/10/4/nha-hat-opera-ha-noi-1-17474499667421942980541-400-512-952-1566-crop-1747454308940258740533-17594832848301913416748-1759540338546-17595403388201955554707.png\" alt=\"Nóng: Nhà hát Ngọc Trai gần 13.000 tỷ đồng do Sun Group làm chủ đầu tư sẽ chính thức khởi công vào  ngày mai- Ảnh 3.\"></a></p><p>Dự kiến, nhà hát có sức chứa hơn 2.000 chỗ ngồi, trở thành một trong những nhà hát lớn nhất châu Á.</p><p>Theo quy hoạch bán đảo Quảng An, Nhà hát Ngọc Trai sẽ là trung tâm văn hóa – nghệ thuật gắn liền với trục không gian Hồ Tây – sông Hồng – thành Cổ Loa. Khu vực này hướng tới việc bảo tồn cảnh quan, di tích lịch sử, đồng thời phát triển dịch vụ du lịch, nghệ thuật, khai thác hiệu quả quỹ đất ven hồ.</p><p>Hồ Tây hiện có khoảng 400 ha mặt nước và bao quanh là nhiều di tích lịch sử, văn hóa lâu đời. Sự xuất hiện của Nhà hát Ngọc Trai được kỳ vọng mở ra hướng đi mới cho không gian văn hóa, du lịch của Thủ đô.</p><p>Không chỉ có dự án nhà hát Ngọc trai, 7 dự án khác được khởi công dịp kỷ niệm 71 năm Ngày Giải phóng Thủ đô 10/10 bao gồm:</p><p>Dự án đầu tư xây dựng Trường đào tạo cán bộ Lê Hồng Phong.</p><p>Dự án đầu tư xây dựng Bệnh viện Thận Hà Nội (cơ sở 2).</p><p>Dự án đầu tư xây dựng tuyến đường sắt đô thị thành phố Hà Nội số 2, đoạn Nam Thăng Long - Trần Hưng Đạo và lễ công bố quy hoạch chi tiết ga C9, phương án tuyến, vị trí công trình trên tuyến đoạn tuyến từ ga C8 đến ga C10, tỷ lệ 1/500, đồng thời gắn với khởi công Dự án bồi thường, hỗ trợ, tái định cư, giải phóng mặt bằng thuộc nhóm Dự án đầu tư xây dựng quảng trường - công viên phía Đông hồ Hoàn Kiếm.</p><p>Dự án thành phần 2 - Đầu tư xây dựng cầu Trần Hưng Đạo.</p><p>Dự án đầu tư xây dựng hầm chui tại nút giao Cổ Linh, phường Long Biên.</p><p>Dự án đầu tư xây dựng cầu Thượng Cát và đường hai đầu cầu.</p><p>Dự án đầu tư xây dựng công viên tuyến hai bên sông Tô Lịch.</p>', '2025-10-04', 2, 0, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `imagePath` varchar(500) NOT NULL,
  `isMain` tinyint(1) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `property_images`
--

INSERT INTO `property_images` (`id`, `propertyId`, `imagePath`, `isMain`, `createdAt`) VALUES
(684, 113, '637a63d6870be801507b62f8090de699.jpg', 1, '2025-10-04 06:29:15'),
(685, 113, '741e630dbd588e6b89d111626d8dcada.jpg', 0, '2025-10-04 06:29:15'),
(686, 113, 'bd4b72038f4546aa9e9bb805653347e5.jpg', 0, '2025-10-04 06:29:15'),
(687, 113, '86a9dfd86bf356b124bcdb9cb9ab9569.jpg', 0, '2025-10-04 06:29:15'),
(688, 113, '1a6863c8ead2f2ba25c487449053be89.jpg', 0, '2025-10-04 06:29:15'),
(689, 113, '7fc66c0bc40aa1e418bf4d179f7ccb3c.jpg', 0, '2025-10-04 06:29:15'),
(690, 113, 'a71e55a0df9cc3d07cea897ee57388e5.jpg', 0, '2025-10-04 06:29:15'),
(691, 113, '5b1cbcc369abbe5118deed0f5df0f726.jpg', 0, '2025-10-04 06:29:15'),
(692, 114, 'da0d79b4846e8d0f6380c314fa29b04b.jpg', 1, '2025-10-04 06:35:35'),
(693, 114, '0210b5b6d265e664a810a44bde70d783.jpg', 0, '2025-10-04 06:35:35'),
(694, 114, 'a106ab40bbc97da67b9bca35c113f90c.jpg', 0, '2025-10-04 06:35:35'),
(695, 114, '8474357befca40d8ba8b8ae6c7f659e5.jpg', 0, '2025-10-04 06:35:35'),
(696, 114, 'eb3e53935d65403f6b5c6895678dcc64.jpg', 0, '2025-10-04 06:35:35'),
(697, 114, '7ca29b50dfa663abd4f779538cc7580b.jpg', 0, '2025-10-04 06:35:35'),
(698, 114, 'fccf4abaeef614bbac5dd3244572aaeb.jpg', 0, '2025-10-04 06:35:35'),
(699, 114, 'ed5cba7e3e94c424ccfc3f7e68929608.jpg', 0, '2025-10-04 06:35:35');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `property_list_view`
-- (See below for the actual view)
--
CREATE TABLE `property_list_view` (
`id` int(11)
,`title` varchar(255)
,`address` varchar(500)
,`locationId` int(11)
,`typeId` int(11)
,`transactionType` enum('rent','sale')
,`price` int(15)
,`area` decimal(10,2)
,`bedrooms` int(11)
,`bathrooms` int(11)
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
  `transactionType` enum('rent','sale') NOT NULL,
  `price` int(15) NOT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT 0,
  `bathrooms` int(11) DEFAULT 0,
  `floors` int(11) DEFAULT 1,
  `frontage` int(1) DEFAULT 0 COMMENT 'Mặt tiền (m)',
  `direction` varchar(50) DEFAULT NULL,
  `furniture` enum('none','basic','full') DEFAULT 'none',
  `parking` tinyint(1) DEFAULT 0,
  `status` enum('active','rented','sold') DEFAULT 'active',
  `views` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rental_property`
--

INSERT INTO `rental_property` (`id`, `title`, `description`, `address`, `locationId`, `typeId`, `brokerId`, `transactionType`, `price`, `area`, `bedrooms`, `bathrooms`, `floors`, `frontage`, `direction`, `furniture`, `parking`, `status`, `views`, `createdAt`, `updatedAt`) VALUES
(113, 'NHÀ CÓ DÒNG TIỀN 15TR/TH', 'Nhà hẻm xe tải Lê Đình Cẩn, gần đường Tên Lửa, siêu thị Aeon 3p đi xe, nhà có dòng tiền đều hằng tháng 15tr\r\n----\r\n+ Diện tích: 128m2 (công nhận đủ)\r\n+ Ngang 5 x 25,6m\r\n+ Nhà gồm 1 nhà 2 tầng 2pn 2wc, và dãy trọ 5 căn phía sau, có lối đi riêng. Thu nhập 15tr/tháng\r\n+ Hẻm xe tải\r\n+ Pháp lý chuẩn, hoàn công đủ, sẵn sàng giao dịch\r\n+ Hướng: Đông Tứ Trạch\r\nGiá bán: 6,5 tỷ', 'Đường Lê Đình Cẩn, Phường Tân Tạo, Quận Bình Tân, Tp Hồ Chí Minh', 18, 4, 37, 'sale', 2147483647, 128.00, 5, 5, 2, 0, 'Nam', 'full', 1, 'active', 1, '2025-10-04 06:29:15', '2025-10-04 06:29:20'),
(114, 'CHO THUÊ BIỆT THỰ VIP 5PN- FULL NỘI THẤT XỊN', 'Cho thuê biệt thự vip Quận 7\r\nDt:10 x 25\r\nKc: trệt, 3 lầu, 5PN\r\nFULL NỘI THẤT XỊN\r\nGiá thuê : 70 triệu', 'BIỆT THỰ VIP QUẬN 7, Phường Tân Phú, Quận 7, Tp Hồ Chí Minh', 7, 2, 37, 'rent', 700000000, 250.00, 4, 4, 3, 20, 'Bắc', 'full', 1, 'active', 10, '2025-10-04 06:35:35', '2025-10-05 15:30:40');

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
(216, 69, 114, '2025-10-05 09:25:08'),
(217, 69, 113, '2025-10-05 09:25:09');

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
(4, 'Pháp lý', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_rental_property`
--

CREATE TABLE `type_rental_property` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `type_rental_property`
--

INSERT INTO `type_rental_property` (`id`, `name`) VALUES
(1, 'Căn hộ'),
(2, 'Nhà phố'),
(3, 'Văn phòng'),
(4, 'Phòng trọ'),
(5, 'Đất nền');

-- --------------------------------------------------------

--
-- Cấu trúc cho view `property_list_view`
--
DROP TABLE IF EXISTS `property_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `property_list_view`  AS SELECT `p`.`id` AS `id`, `p`.`title` AS `title`, `p`.`address` AS `address`, `p`.`locationId` AS `locationId`, `p`.`typeId` AS `typeId`, `p`.`transactionType` AS `transactionType`, `p`.`price` AS `price`, `p`.`area` AS `area`, `p`.`bedrooms` AS `bedrooms`, `p`.`bathrooms` AS `bathrooms`, `p`.`views` AS `views`, `p`.`createdAt` AS `createdAt`, `t`.`name` AS `propertyType`, `l`.`name` AS `locationName`, `a`.`fullName` AS `brokerName`, `a`.`avatar` AS `brokerAvatar`, CASE WHEN `pi`.`imagePath` is not null THEN `pi`.`imagePath` ELSE 'placeholder.svg' END AS `mainImage` FROM (((((`rental_property` `p` left join `type_rental_property` `t` on(`p`.`typeId` = `t`.`id`)) left join `location` `l` on(`p`.`locationId` = `l`.`id`)) left join `broker` `b` on(`p`.`brokerId` = `b`.`id`)) left join `account` `a` on(`b`.`accountId` = `a`.`id`)) left join `property_images` `pi` on(`p`.`id` = `pi`.`propertyId` and `pi`.`isMain` = 1)) WHERE `p`.`status` = 'active' ;

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
  ADD KEY `accountId` (`accountId`),
  ADD KEY `broker_ibfk_2` (`location`);

--
-- Chỉ mục cho bảng `broker_ratings`
--
ALTER TABLE `broker_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `broker_rating_fk1` (`brokerId`),
  ADD KEY `broker_rating_fk2` (`userId`);

--
-- Chỉ mục cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `brokerId` (`brokerId`),
  ADD KEY `contact_requests_fk1` (`location`);

--
-- Chỉ mục cho bảng `expertises`
--
ALTER TABLE `expertises`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `follow_broker`
--
ALTER TABLE `follow_broker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follow_broker_fk1` (`idBroker`),
  ADD KEY `follow_broker_fk2` (`idUser`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `broker`
--
ALTER TABLE `broker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `broker_ratings`
--
ALTER TABLE `broker_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `expertises`
--
ALTER TABLE `expertises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `follow_broker`
--
ALTER TABLE `follow_broker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=700;

--
-- AUTO_INCREMENT cho bảng `rental_property`
--
ALTER TABLE `rental_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `saved_properties`
--
ALTER TABLE `saved_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT cho bảng `typenews`
--
ALTER TABLE `typenews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `broker_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `broker_ibfk_2` FOREIGN KEY (`location`) REFERENCES `location` (`id`);

--
-- Các ràng buộc cho bảng `broker_ratings`
--
ALTER TABLE `broker_ratings`
  ADD CONSTRAINT `broker_rating_fk1` FOREIGN KEY (`brokerId`) REFERENCES `broker` (`id`),
  ADD CONSTRAINT `broker_rating_fk2` FOREIGN KEY (`userId`) REFERENCES `account` (`id`);

--
-- Các ràng buộc cho bảng `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD CONSTRAINT `contact_requests_fk1` FOREIGN KEY (`location`) REFERENCES `location` (`id`);

--
-- Các ràng buộc cho bảng `follow_broker`
--
ALTER TABLE `follow_broker`
  ADD CONSTRAINT `follow_broker_fk1` FOREIGN KEY (`idBroker`) REFERENCES `broker` (`id`),
  ADD CONSTRAINT `follow_broker_fk2` FOREIGN KEY (`idUser`) REFERENCES `account` (`id`);

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
