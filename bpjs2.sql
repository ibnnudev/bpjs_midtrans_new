-- MySQL dump 10.13  Distrib 5.7.44, for Linux (x86_64)
--
-- Host: localhost    Database: 2bpjs
-- ------------------------------------------------------
-- Server version	5.7.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `faskes`
--

DROP TABLE IF EXISTS `faskes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faskes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_faskes` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11191623 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faskes`
--

LOCK TABLES `faskes` WRITE;
/*!40000 ALTER TABLE `faskes` DISABLE KEYS */;
INSERT INTO `faskes` VALUES (11190101,'Puskesmas Cangkrep','JL WR SUPRATMAN NO 431',NULL),(11190102,'Puskesmas Mranti','JL.MR. WILOPO NO. 203A',NULL),(11190103,'Puskesmas Purworejo','JL.AHMAD DAHLAN NO 73',NULL),(11190204,'Puskesmas Bayan','JL.GAJAH MADA KM9 PURWOREJO',NULL),(11190305,'Puskesmas Banyuurip','DS. SUMBERSARI',NULL),(11190306,'Puskesmas Seborokrapyak','SEBOROKRAPYAK',NULL),(11190407,'Puskesmas Kaligesing','JL. H. SOEPANTO, KALIGONO, KAL',NULL),(11190508,'Puskesmas Loano','JL.MAGELANG KM 8',NULL),(11190523,'Puskesmas Banyuasin','JL.BANYUASIN',NULL),(11190609,'Puskesmas Bener','JL.MAGELANG KM 11',NULL),(11190710,'Puskesmas Gebang','JL.NYAI LOKASARI',NULL),(11190811,'Puskesmas Semawungdaleman','JL. KRAJAN 1, KELURAHAN SEMAWU',NULL),(11190812,'Puskesmas Wirun','DS. WIRUN KUTOARJO',NULL),(11190813,'Puskesmas Kutoarjo','JL.MARDI USADA NO. 22',NULL),(11190913,'Puskesmas Grabag','JL.KETAWANG-KETAWANG KM. 7DS.',NULL),(11191014,'Puskesmas Butuh','JL. KUTOARJO KEBUMEN KM.05',NULL),(11191015,'Puskesmas Sruwohrejo','DSN. SRUWOHREJO',NULL),(11191116,'Puskesmas Kemiri','DSN. KEMIRI KIDUL',NULL),(11191122,'Puskesmas Winong','WINONG',NULL),(11191217,'Puskesmas Bruno','DS. BRUNOREJO',NULL),(11191318,'Puskesmas Pituruh','KEC. PITURUH',NULL),(11191324,'Puskesmas Karanggetas','JL PITURUH BRENGKOL KM 4, KARA',NULL),(11191419,'Puskesmas Bubutan Purwodadi','DSN. BUBUTAN PURWODADI',NULL),(11191420,'Puskesmas Bragolan','JL. PANEMBAHAN SENOPATI NO.17',NULL),(11191520,'Puskesmas Ngombol','ds. Kembangkuning',NULL),(11191621,'Puskesmas Bagelen','JL. YOGYAKARTA KM.11',NULL),(11191622,'Puskesmas Dadirejo','JL. JOGJA KM. 18',NULL);
/*!40000 ALTER TABLE `faskes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas_bpjs`
--

DROP TABLE IF EXISTS `kelas_bpjs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelas_bpjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas_bpjs`
--

LOCK TABLES `kelas_bpjs` WRITE;
/*!40000 ALTER TABLE `kelas_bpjs` DISABLE KEYS */;
INSERT INTO `kelas_bpjs` VALUES (2,'Kelas 1','150000'),(4,'Kelas 2','100000'),(5,'Kelas 3','35000');
/*!40000 ALTER TABLE `kelas_bpjs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kepesertaan_bpjs`
--

DROP TABLE IF EXISTS `kepesertaan_bpjs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kepesertaan_bpjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(20) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `faskes_id` varchar(25) NOT NULL,
  `kelas_id` varchar(25) NOT NULL,
  `status_aktif` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `user_id` varchar(25) NOT NULL,
  `tanggal_daftar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_nonaktif` datetime DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kepesertaan_bpjs`
--

LOCK TABLES `kepesertaan_bpjs` WRITE;
/*!40000 ALTER TABLE `kepesertaan_bpjs` DISABLE KEYS */;
INSERT INTO `kepesertaan_bpjs` VALUES (1,'00000000','11111111','Rizki Romadlon 2','2000-03-01','Perempuan','kedungjati 1','4342','rizkiro2madlon18@gmail.com','4','3','Tidak Aktif','4','2025-03-02 09:34:15',NULL,NULL),(3,'08010000190902','87','Laboriosam architec','2013-02-24','Laki-laki','Debitis pariatur Co','0856563265656','dacuhog@mailinator.com','4','2','Aktif','7','2025-03-02 11:18:46',NULL,NULL),(5,'76','91','Sint dolorem duis do','2002-02-01','Laki-laki','Reprehenderit maiore','43','puhav@mailinator.com','4','2','Aktif','4','2025-03-02 14:26:50',NULL,NULL),(6,'67','80','Irure similique exce','2012-05-04','Perempuan','Tempore modi dolore','71','qyhodila@mailinator.com','3','2','Aktif','6','2025-03-02 14:32:01',NULL,NULL),(8,'123456789456789','456123456789','Asep Sanjaya','2025-03-19','Laki-laki','Jl jansdj','0856454754745','email@gmail.com','4','4','Aktif','9','2025-03-19 09:12:50',NULL,NULL),(9,'12321441','1234567891234568','Babal','1995-06-17','Laki-laki','Padang','081234567890','admin@gmail.com','3','2','Tidak Aktif','10','2025-03-01 11:00:54',NULL,NULL),(11,'76','4324543546456476','Brobro','1990-05-04','Laki-laki','rfdsfds','345432343424','admin@gmail.com','3','4','Tidak Aktif','10','2025-05-18 01:52:25',NULL,NULL),(12,'67','4324343545465657','dfdsfdsfs','1995-05-15','Laki-laki','fdsfdsfsd','543657587687','admin@gmail.com','4','5','Tidak Aktif','10','2025-05-18 01:54:21',NULL,NULL);
/*!40000 ALTER TABLE `kepesertaan_bpjs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_bpjs`
--

DROP TABLE IF EXISTS `pembayaran_bpjs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran_bpjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kepesertaan_id` int(11) NOT NULL,
  `bulan` varchar(10) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `tanggal_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `metode_pembayaran` varchar(255) NOT NULL,
  `tipe_pembayaran` enum('registrasi','iuran') NOT NULL,
  `status` enum('lunas','pending','gagal') DEFAULT 'pending',
  `status_kepesertaan` enum('Aktif','Tidak Aktif') DEFAULT 'Tidak Aktif',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kepesertaan_id` (`kepesertaan_id`),
  CONSTRAINT `pembayaran_bpjs_ibfk_1` FOREIGN KEY (`kepesertaan_id`) REFERENCES `kepesertaan_bpjs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_bpjs`
--

LOCK TABLES `pembayaran_bpjs` WRITE;
/*!40000 ALTER TABLE `pembayaran_bpjs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_bpjs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pengguna') NOT NULL DEFAULT 'pengguna',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('menunggu_aktivasi','aktif') DEFAULT 'menunggu_aktivasi',
  `email_verification_token` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'fulan','fulan','fulan@gmai.com','$2y$10$biW/1t3mb1jTwaeOfHtLxOkC3qlLvoWdHuyG4YeCCKvcbKil12dCi','admin','2025-03-02 06:59:19','aktif',NULL,NULL),(5,'rizki','rizki','rizkiromadlon18@gmail.com','$2y$10$FR3EXeQtjPx6q3dQYDTEeeNtvZw1RKFiP8Nivzwj266T8ToLO1qNi','pengguna','2025-03-02 09:07:38','aktif',NULL,NULL),(6,'dualipa2','dualipa3','topay2724@gmail.com','$2y$10$43d9pFOD3pGzaya1TaSI0./AVnEY0kL4x3Cm/kaDnYpL5E2fhrQnW','pengguna','2025-03-02 09:28:32','aktif',NULL,NULL),(7,'anisa','anisa','anisa123@gmail.com','$2y$10$Qi6.jx00lcfGuqToRtblker5fv3MSCiNJbxMKUZa1oP47E7uuZynO','admin','2025-03-02 09:50:45','aktif',NULL,NULL),(8,'user 123','user123','user@gmail.com','$2y$10$RfMGeEQkPCxkr.6ZCWFswOZ1ud/Q//Kajb1uOexAIiPzoL/zhGfs.','admin','2025-03-12 09:45:05','aktif',NULL,NULL),(9,'tes1','tes1','tes@gmail.com','$2y$10$1BmXNM4Y2J85stuK9RQZ6.hg4Szymx.QbRwVLpOB47asejUilecWq','pengguna','2025-03-19 08:12:00','aktif',NULL,NULL),(10,'admin','admin','admin@gmail.com','$2y$10$nNjDaf6DF0gkfHJSd0p3c.BK4HlDXXKnCrDlTuqiG0XCJmmsZyiNi','admin','2025-05-16 08:59:22','aktif',NULL,NULL),(16,'Moh Ibnu Abdurrohman Sutio','ibnnuas','ibnuabdurrohmansutio@gmail.com','$2y$10$ZBPlidfvfgeRir97xatIr.tn3I44F5cVjXbEcSngFZdVh7ATZwvQa','pengguna','2025-08-01 09:24:36','aktif',NULL,'2025-08-01 09:25:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-01  9:25:40
