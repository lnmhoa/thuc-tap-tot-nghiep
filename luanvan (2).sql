-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 27, 2025 lúc 03:44 PM
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `broker_ratings`
--

CREATE TABLE `broker_ratings` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `brokerId` int(11) NOT NULL,
  `rating` float(1,1) NOT NULL,
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
-- Cấu trúc bảng cho bảng `follow_broker`
--

CREATE TABLE `follow_broker` (
  `id` int(11) NOT NULL,
  `idBroker` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `createdAt` date NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `pin` tinyint(1) NOT NULL DEFAULT 1,
  `typeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `property_list_view`
-- (See below for the actual view)
--
CREATE TABLE `property_list_view` (
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
  `price` decimal(15,2) NOT NULL,
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
  ADD KEY `accountId` (`accountId`),
  ADD KEY `broker_ibfk_2` (`location`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `expertises`
--
ALTER TABLE `expertises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `follow_broker`
--
ALTER TABLE `follow_broker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

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
  ADD CONSTRAINT `broker_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `broker_ibfk_2` FOREIGN KEY (`location`) REFERENCES `location` (`id`);

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
