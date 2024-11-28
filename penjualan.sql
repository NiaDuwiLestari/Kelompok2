-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sistem_pencatatan_penjualan
CREATE DATABASE IF NOT EXISTS `sistem_pencatatan_penjualan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistem_pencatatan_penjualan`;

-- Dumping structure for table sistem_pencatatan_penjualan.sistem_pencatatan_penjualan
CREATE TABLE IF NOT EXISTS `sistem_pencatatan_penjualan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_product` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price_product` float NOT NULL,
  `created_at` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updated_at` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistem_pencatatan_penjualan.sistem_pencatatan_penjualan: ~3 rows (approximately)
INSERT INTO `sistem_pencatatan_penjualan` (`id`, `name_product`, `price_product`, `created_at`, `updated_at`) VALUES
	(38, 'Handphone', 2500000, '2024-11-21 13:46:08', '2024-11-25 05:20:39'),
	(39, 'Laptop', 7000000, '2024-11-25 05:20:16', '2024-11-25 05:20:16'),
	(40, 'Keyboard', 500000, '2024-11-25 05:25:45', '2024-11-25 05:25:45');

-- Dumping structure for table sistem_pencatatan_penjualan.tr_penjualan
CREATE TABLE IF NOT EXISTS `tr_penjualan` (
  `id_transaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tgl_transaction` datetime DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  PRIMARY KEY (`id_transaction`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistem_pencatatan_penjualan.tr_penjualan: ~3 rows (approximately)
INSERT INTO `tr_penjualan` (`id_transaction`, `tgl_transaction`, `product_id`, `amount`, `total_price`) VALUES
	('Tr_BrG-2024-11-25 05:21:17', '2024-11-25 05:21:17', 38, 5, 12500000),
	('Tr_BrG-2024-11-28 03:18:00', '2024-11-28 03:18:00', 39, 5, 35000000);

-- Dumping structure for table sistem_pencatatan_penjualan.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistem_pencatatan_penjualan.user: ~0 rows (approximately)
INSERT INTO `user` (`id`, `username`, `password`) VALUES
	(1, '', '$2y$10$Pl2J2F86D9vKYrcw6qEQ/.v9A1V4QwL5wlV7ks2CfF9VNlyPCEXbC');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
