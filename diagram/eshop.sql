-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 02. kvě 2024, 22:26
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `eshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `address`
--

CREATE TABLE `address` (
  `ID` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `house_number` varchar(255) NOT NULL,
  `ID_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `address`
--

INSERT INTO `address` (`ID`, `city`, `street`, `postal_code`, `house_number`, `ID_country`) VALUES
(21, 'Záto', 'Loučky', '793 16', 'Loučky', 1),
(22, 'Zátor', 'Lou', '793 16', 'Lou', 1),
(23, 'Zátor', 'Lou', '793 16', 'Lou', 5),
(24, 'Zátor', 'Loučky', '793 16', 'Loučky', 1),
(25, '', '', '', '', 1),
(26, 'Zátor', 'Loučky', '793 16', '8', 1),
(27, 'Zátor', 'Loučky', '793 16', '7', 1),
(28, 'Zátor', 'Loučky', '793 16', '845gdfg', 1),
(29, 'Zátordsgf', 'Loučky', '793 16', '8', 1),
(30, 'test_town', 'test_street', '97801', 'test_house-number', 1),
(31, 'test', 'test', '87940', 'test', 1),
(32, 'test', 'test', '', 'test', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `category`
--

INSERT INTO `category` (`ID`, `name`) VALUES
(1, 'Telefony'),
(2, 'Notebooky'),
(3, 'Tablet'),
(4, 'Monitory'),
(5, 'Konzole'),
(6, 'Klávesnice'),
(7, 'Myši'),
(8, 'Grafické karty'),
(9, 'Procesory'),
(10, 'RAM '),
(11, 'SSD'),
(12, 'HDD'),
(13, 'Virtuální Realita');

-- --------------------------------------------------------

--
-- Struktura tabulky `country`
--

CREATE TABLE `country` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `country`
--

INSERT INTO `country` (`ID`, `name`) VALUES
(1, 'Česko'),
(2, 'Polsko'),
(3, 'Rakousko'),
(4, 'Německo'),
(5, 'USA');

-- --------------------------------------------------------

--
-- Struktura tabulky `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `tel_num` int(11) NOT NULL,
  `password` varchar(4096) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ID_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `customer`
--

INSERT INTO `customer` (`ID`, `name`, `surname`, `e_mail`, `tel_num`, `password`, `username`, `ID_address`) VALUES
(11, 'test', 'test', 'test@test.cz', 0, '$2y$10$e177dMB7L1Iemjp9YBX7guCYhfDvkrXH/dMCGlZXHBYqvKfewsXza', 'test', 32),
(12, 'test', 'test', 'testtest@test.cz', 15644, '$2y$10$pxjbcGtVatoD1C720665fO6aXcsVjCq89I2RoJcCsxZrL1.tIZUCK', 'test_username', 32);

-- --------------------------------------------------------

--
-- Struktura tabulky `manafacturer`
--

CREATE TABLE `manafacturer` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `manafacturer`
--

INSERT INTO `manafacturer` (`ID`, `name`) VALUES
(1, 'Apple'),
(2, 'Asus'),
(3, 'Huawei'),
(4, 'Lenovo'),
(5, 'Samsung'),
(6, 'Xiaomi'),
(7, 'GIGABYTE'),
(8, 'ASUS'),
(11, 'Dell'),
(12, 'MSI'),
(14, 'BenQ'),
(16, 'HP'),
(17, 'Philips'),
(18, 'Corsair'),
(19, 'AOC'),
(20, 'AMD'),
(21, 'Intel'),
(22, 'SONY'),
(23, 'Microsoft'),
(24, 'Meta'),
(25, 'HTC');

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `price` int(11) NOT NULL,
  `number_of_products` int(11) NOT NULL,
  `availability` date NOT NULL,
  `ID_sale` int(11) NOT NULL,
  `ID_category` int(11) NOT NULL,
  `ID_manafacturer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `product`
--

INSERT INTO `product` (`ID`, `title`, `picture`, `description`, `price`, `number_of_products`, `availability`, `ID_sale`, `ID_category`, `ID_manafacturer`) VALUES
(1, 'iPhone 14 128GB modrá', 'img/products/Iphone12.png', 'Mobilní telefon - 6,1\" OLED 2532 × 1170, vnitřní paměť 128 GB, single SIM + eSIM, procesor Apple A15 Bionic, fotoaparát: 12Mpx (f/1,5) hlavní + 12Mpx širokoúhlý, přední kamera 12Mpx, GPS, NFC, LTE, 5G, Lightning port, voděodolný dle IP68, rychlé nabíjení 15W, bezdrátové nabíjení, model 2022, iOS', 17246, 5, '2025-01-09', 1, 1, 1),
(2, 'ASUS Vivobook Pro 16 OLED K6602VU-OLED006W Quiet Blue kovový + 3 měsíce Adobe Creative Cloud', 'img/products/ASUSVivoBook.png', 'Notebook - Intel Core i9 13900H Raptor Lake, 16\" OLED lesklý 3200 × 2000 120Hz, RAM 16GB DDR5, NVIDIA GeForce RTX 4050 6GB 65 W (MUX Switch), SSD 1000GB, numerická klávesnice, podsvícená klávesnice, webkamera, USB 3.2 Gen 1, USB-C, čtečka otisků prstů, WiFi 6E, Hmotnost 1,9 kg, Windows 11 Home', 47999, 2, '2026-01-14', 2, 2, 2),
(3, 'Huawei P50 Pocket bílá', 'img/products/HuaweiP50.jpg', 'Mobilní telefon - 6,9\" OLED 2790 × 1188, 120Hz, procesor Qualcomm Snapdragon 888 8jádrový, RAM 8 GB, interní paměť 256 GB, zadní fotoaparát 40 Mpx (f/1,8) + 13 Mpx (f/2,2) + 32 Mpx (f/1,8), přední fotoaparát 10,7 Mpx, elektronická stabilizace, GPS, Glonass, NFC, LTE, USB-C, čtečka otisků, hybridní slot, neblokovaný, rychlé nabíjení 40W, baterie 4000 mAh, Android 11', 18460, 0, '2026-01-22', 1, 1, 3),
(4, 'Lenovo Tab M11 4GB + 128GB Luna Grey + aktivní stylus Lenovo', 'img/products/LenovoTabP12.png', 'Tablet - displej 11\" 1920 × 1200 IPS, MediaTek Helio G88 2 GHz, RAM 4 GB, kapacita úložiště 128 GB, paměťová karta až 1024 GB, WiFi, Bluetooth, GPS, zadní fotoaparát 8 Mpx, přední fotoaparát 8 Mpx, USB-C, 15W rychlé nabíjení, baterie 7040 mAh, Android 13', 4893, 15, '2024-01-19', 1, 3, 4),
(5, 'MacBook Air 13\" M1 CZ Vesmírně Šedý 2020', 'img/products/MacBook.png', 'MacBook - Apple M1, 13,3\" IPS lesklý 2560 × 1600 px, RAM 8GB, Apple M1 7jádrová GPU, SSD 256GB, podsvícená klávesnice, webkamera, USB-C, čtečka otisků prstů, WiFi 6, hmotnost 1,25 kg, macOS', 24599, 3, '2028-03-10', 2, 2, 1),
(6, 'Samsung A30 ', 'img/products/SamsungGalaxyA5.jpg', 'Mobilní telefon - 6,7\" PLS 2400 × 1080 (90Hz), operační paměť 4 GB, vnitřní paměť 128 GB, dual SIM + paměťová karta, procesor Qualcomm Snapdragon 680 4G, fotoaparát: 50Mpx (f/1,8) hlavní + 2Mpx makro, přední kamera 13Mpx, čtečka otisků prstů, GPS, LTE, Jack (3,5mm) a USB-C, rychlé nabíjení 25W, baterie 5000 mAh, model 2023, Android', 4269, 12, '2026-01-16', 1, 1, 5),
(7, 'Xiaomi Redmi Note 9 LTE 64GB zelená', 'img/products/XiaomiRedmiNote9.png', 'Mobilní telefon - 6,53\" IPS 2340 × 1080, procesor MediaTek Helio G85 8jádrový, RAM 3 GB, interní paměť 64 GB, Micro SD až 512 GB, zadní fotoaparát 48 Mpx (f/1,79) + 8 Mpx (f/2,2) + 2 Mpx (f/2,4) + 2 Mpx (f/2,4), přední fotoaparát 13 Mpx, elektronická stabilizace, GPS, Glonass, IrDA, NFC, LTE, Jack (3,5mm) a USB-C, čtečka otisků, dual SIM, neblokovaný, rychlé nabíjení 18W, baterie 5020 mAh, Android 10', 7899, 4, '2026-03-19', 2, 1, 6),
(8, 'Samsung Galaxy Tab S7+ 5G modrý', 'img/products/SamsungGalaxyTabS7.png', 'Tablet - displej 12,4\" QHD 2800 × 1752 Super AMOLED, Qualcomm Snapdragon 865+ 3,09 GHz, RAM 6 GB, interní paměť 128 GB, paměťová karta až 1000 GB, WiFi, Bluetooth, GPS, 5G, zadní fotoaparát 13 Mpx (f/2), přední fotoaparát 8 Mpx (f/2), USB-C, výdrž až 15 h, rychlé nabíjení 45W, baterie 10090 mAh, Android 10', 28490, 99, '2026-04-09', 1, 3, 5),
(9, 'Samsung Galaxy Tab A9+ Wifi 4GB/64GB grafitová', 'img/products/SamsungGalaxyTabA9.png', 'Tablet - displej 11\" Full HD 1920 × 1200 TFT, Qualcomm SM6375 2,2 GHz, RAM 4 GB, kapacita úložiště 64 GB, paměťová karta až 1000 GB, WiFi, Bluetooth, GPS, zadní fotoaparát 8 Mpx (f/2), přední fotoaparát 5 Mpx (f/2,2), USB-C, 15W rychlé nabíjení, baterie 7040 mAh, Android 13', 18000, 8, '2026-05-14', 1, 3, 5),
(10, 'iPad 10.9\" 256GB WiFi Cellular Žlutý 2022', 'img/products/IPad256.jpg', 'Tablet - displej 11\" QHD 2360 × 1640 IPS, Apple A14 Bionic, kapacita úložiště 256 GB, WiFi, Bluetooth, NFC, 5G, 4G/LTE a 3G, zadní fotoaparát 12 Mpx (f/1,8) (f/2,4), USB-C, 20W rychlé nabíjení, iPadOS\r\n', 22000, 3, '2025-07-08', 1, 3, 1),
(12, '27\" GIGABYTE M27Q', 'img/products/GigabyteMonitor27.jpg', 'LCD monitor Quad HD 2560 × 1440, IPS, 16:9 širokoúhlý, 0,5 ms, 170Hz, 8bit, 350 cd/m2, kontrast 1000:1, HDMI, USB-C a DisplayPort, USB, sluchátkový výstup, nastavitelná výška, antireflexní povrch displeje, VESA', 8960, 3, '2027-08-19', 1, 4, 7),
(13, '34\" GIGABYTE G34WQC A', 'img/products/GigabyteMonitor34.jpg', 'LCD monitor prohnutý, Ultra Wide QHD 3440 × 1440, VA, 21:9 širokoúhlý, 1 ms, 144Hz, FreeSync, 8bit, 350 cd/m2, kontrast 4000:1, HDMI a DisplayPort, sluchátkový výstup, nastavitelná výška, repro, VESA', 9610, 5, '2030-08-16', 1, 4, 7),
(14, '32\" GIGABYTE AORUS FI32Q X', 'img/products/GigabyteMonitor32.jpg', 'LCD monitor Quad HD 2560 × 1440, IPS, 16:9 širokoúhlý, 1 ms, 240Hz, FreeSync, 8bit, 400 cd/m2, kontrast 1000:1, HDMI, USB-C a DisplayPort, USB, sluchátkový výstup, nastavitelná výška, pivot, VESA', 23726, 1, '2026-09-16', 1, 4, 7),
(15, 'MSI GeForce RTX 4070 Ti SUPER GAMING X SLIM 16G', 'img/products/MSIrtx4070Ti.jpg', 'Grafická karta - 16 GB GDDR6X (21000 MHz ), NVIDIA GeForce, Ada Lovelace (, 2340 MHz), Boost 2685 MHz, PCI Express x16 4.0, 256Bit, DisplayPort 1.4a a HDMI 2.1, DLSS 3.0', 24477, 6, '2024-07-18', 1, 8, 12),
(16, 'ASUS TUF GeForce RTX 4070 Ti SUPER O16G GAMING', 'img/products/ASUS4070.jpg', 'Grafická karta - 16 GB GDDR6X (21000 MHz ), NVIDIA GeForce, Ada Lovelace (AD103, 2340 MHz), Boost 2670 MHz, PCI Express x16 4.0, 256Bit, DisplayPort 1.4a a HDMI 2.1, DLSS 3.0', 25990, 8, '2031-05-02', 1, 8, 8),
(17, 'MSI GeForce RTX 4060 Ti VENTUS 2X BLACK 16G OC', 'img/products/MSI4060.jpg', 'Grafická karta - 16 GB GDDR6 (18000 MHz ), NVIDIA GeForce, Ada Lovelace (AD106, 2310 MHz), Boost 2625 MHz, PCI Express x16 4.0, 128Bit, DisplayPort 1.4a a HDMI 2.1a', 12590, 10, '2028-07-13', 1, 8, 12),
(18, 'ASUS ProArt GeForce RTX 4060 Ti O16G', 'img/products/ASUS4060TI.jpg', 'Grafická karta - 16 GB GDDR6 (18000 MHz ), NVIDIA GeForce, Ada Lovelace (AD106, 2310 MHz), Boost 2685 MHz, PCI Express x16 4.0, 128Bit, DisplayPort 1.4a a HDMI 2.1a', 15000, 15, '2026-05-14', 2, 8, 8),
(19, 'SAPPHIRE PULSE Radeon RX 6600 8GB', 'img/products/RX6600.jpg', 'Grafická karta - 8 GB GDDR6 (14000 MHz ), AMD Radeon, RDNA 2.0 (Navi 23, 1626 MHz), Boost 2491 MHz, PCI Express x16 4.0, 128Bit, DisplayPort 1.4a a HDMI 2.1', 5600, 2, '2026-05-14', 1, 8, 20),
(20, 'SAPPHIRE TOXIC Radeon RX 6900 XT Air Cooled 16G', 'img/products/RX6900XT.jpg', 'Grafická karta - 16 GB GDDR6 (16000 MHz ), AMD Radeon, RDNA 2.0 (Navi 21, 1825 MHz), Boost 2425 MHz, PCI Express x16 4.0, 256Bit, DisplayPort 1.4a a HDMI 2.1', 36190, 7, '2026-05-14', 1, 8, 20),
(21, 'ASROCK Radeon RX 7900 XTX Phantom Gaming 24GB OC', 'img/products/RX7900XTX.jpg', 'Grafická karta - 24 GB GDDR6 (20000 MHz ), AMD Radeon, RDNA 3.0 (Navi 31, 1900 MHz), Boost 2615 MHz, PCI Express x16 4.0, 384Bit, HDMI 2.1 a DisplayPort 2.1', 26387, 4, '2024-07-18', 1, 8, 20),
(22, 'PlayStation 5 (Slim) + Marvels Spider-Man 2', 'img/products/PS5Spiderman.jpg', 'Herní konzole - k TV, SSD 1024 GB, Blu-ray (4K), možnost hraní ve 4K, menu v češtině, 1x herní ovladač, hra v balení (fyzický nosič) - Marvels Spider-Man 2 - Vertikální stojan není součástí balení a je prodáván samostatně.', 15549, 8, '2030-08-16', 1, 5, 22),
(23, 'PlayStation 5 (Slim) s rozšiřeným uložištěm (+2TB SSD)', 'img/products/PS52TB.jpg', 'Herní konzole - k TV, SSD 3024 GB, Blu-ray (4K), možnost hraní ve 4K, menu v češtině, 1x herní ovladač', 16460, 10, '2025-07-08', 1, 5, 22),
(24, 'PlayStation VR2', 'img/products/PSVR.jpg', 'VR brýle k herní konzoli - OLED displej, celkové rozlišení 4K 4000 × 4080 px, obnovovací frekvence 120 Hz, s mikrofonem, včetně otvoru pro sluchátka, připojení skrze USB-C, zorné pole 110°, akcelerometr, gyroskop a proximity senzor, bílá a černá barva, ovladač součástí balení', 14725, 7, '2030-08-16', 2, 13, 22),
(25, 'Meta Quest 2 (128GB)', 'img/products/QUEST2.jpg', 'VR brýle - samostatně fungující, celkové rozlišení 4K 3664 × 1920 px, obnovovací frekvence 90 Hz, s mikrofonem, připojení skrze Bluetooth, Wi-Fi a USB-C, bílá barva, ovladač součástí balení', 8999, 14, '2026-05-14', 1, 13, 24),
(26, 'Meta Quest 3 (128 GB)', 'img/products/QUEST3.jpg', 'VR brýle - samostatně fungující, LCD displej, obnovovací frekvence 120 Hz, s mikrofonem, připojení skrze Wi-Fi a USB-C, zorné pole 110°, Snapdragon XR2 Gen 2, úložiště 128 GB, RAM 8 GB, hmotnost 515 g, bílá barva, ovladač součástí balení', 15990, 8, '2026-05-14', 1, 13, 24),
(27, 'Meta Quest Pro (256GB)', 'img/products/QUESTPro.jpg', 'VR brýle - samostatně fungující, s mikrofonem, připojení skrze Bluetooth, Wi-Fi a USB-C, ovladač a nabíječka součástí balení', 29000, 3, '2026-05-14', 2, 13, 24),
(28, 'HTC Vive Pro 2 Full Kit', 'img/products/HTCPro.jpg', 'VR brýle k počítači - celkové rozlišení 4K 4896 × 2448 px, obnovovací frekvence 120 Hz, s mikrofonem, připojení skrze Bluetooth, USB-C a DisplayPort, zorné pole 120°, ovladač součástí balení', 33990, 2, '2026-05-14', 1, 13, 25),
(29, 'HTC Vive XR Elite', 'img/products/HTCXR.jpg', 'VR brýle - obnovovací frekvence 90 Hz, připojení skrze Wi-Fi a USB-C, zorné pole 110°, černá barva', 34990, 10, '2026-05-14', 1, 13, 25),
(30, 'HTC Vive Focus 3 Business Edition', 'img/products/HTCBusiness.jpg', 'VR brýle - samostatně fungující, LCD displej, celkové rozlišení 4K 4896 × 2448 px, obnovovací frekvence 90 Hz, s mikrofonem, připojení skrze Bluetooth, Wi-Fi a USB-C, zorné pole 120°, gyroskop, g-senzor a proximity senzor, Snapdragon XR2 Gen 1, úložiště 128 GB, RAM 8 GB, černá barva, ovladač součástí balení', 35900, 4, '2025-07-08', 1, 13, 25),
(31, 'MacBook Air 13\" M1 CZ Zlatý 2020', 'img/products/Macbook13', 'MacBook - Apple M1, 13,3\" IPS lesklý 2560 × 1600 px, RAM 8GB, Apple M1 7jádrová GPU, SSD 256GB, podsvícená klávesnice, webkamera, USB-C, čtečka otisků prstů, WiFi 6, hmotnost 1,25 kg, macOS', 19990, 10, '2026-05-14', 1, 2, 1),
(32, 'MacBook Pro 16\" M3 MAX CZ 2023 Vesmírně černý', 'img/products/MacPro.jpg', 'MacBook - Apple M3 Max (16jádrový), 16,2\" Liquid Retina XDR lesklý 3456 × 2234 px, 120 Hz, RAM 128GB, Apple M3 MAX 40jádrová GPU, SSD 8000GB, podsvícená klávesnice, webkamera, WiFi 6E, Bluetooth, hmotnost 2,16 kg, macOS', 215990, 2, '2026-05-14', 1, 2, 1),
(33, 'MacBook Pro 16\" M1 MAX CZ 2021 Stříbrný', 'img/products/MacProM1.jpg', 'MacBook - Apple M1 MAX, 16,2\" Liquid Retina XDR lesklý 3456 × 2234 px, 120 Hz, RAM 64GB, Apple M1 MAX 32jádrová GPU, SSD 1000GB, podsvícená klávesnice, webkamera, čtečka otisků prstů, WiFi 6, hmotnost 2,2 kg, macOS', 97690, 2, '2026-05-14', 1, 2, 1),
(34, 'ASUS ROG Strix G17 G713PI-LL044W Eclipse Gray kovový', 'img/products/ASUSROG.jpg', 'Herní notebook - AMD Ryzen 9 7845HX, 17.3\" IPS antireflexní 2560 × 1440 240Hz, RAM 32GB DDR5, NVIDIA GeForce RTX 4070 8GB 140 W (MUX Switch), SSD 1000GB, numerická klávesnice, podsvícení, podsvícená RGB klávesnice, webkamera, USB 3.2 Gen 1, USB-C, WiFi 6E, WiFi, Bluetooth, Hmotnost 2,8 kg, Windows 11 Home', 51990, 3, '2026-05-14', 1, 2, 2),
(35, 'MSI Katana 17 B12VFK-458CZ', 'img/products/MSIKatana17.jpg', 'Herní notebook - Intel Core i7 12650H Alder Lake, 17.3\" IPS matný 1920 × 1080 144Hz, RAM 16GB DDR5, NVIDIA GeForce RTX 4060 8GB 105 W (MUX Switch), SSD 1000GB, numerická klávesnice, podsvícení, podsvícená RGB klávesnice, webkamera, USB 3.2 Gen 1, USB-C, WiFi 6, Hmotnost 2,6 kg, Windows 11 Home', 31490, 8, '2026-05-14', 1, 2, 12),
(36, 'Lenovo Legion 5 16IRX9 Luna Grey kovový + podložka pod myš', 'img/products/LenovoLegion5.jpg', 'Herní notebook - Intel Core i7 14650HX Raptor Lake Refresh, 16\" IPS antireflexní 2560 × 1600 240Hz, RAM 32GB DDR5, NVIDIA GeForce RTX 4060 8GB 140 W, SSD 1000GB, numerická klávesnice, podsvícení, podsvícená RGB klávesnice, webkamera, USB 3.2 Gen 1, USB-C, WiFi 6E, WiFi, Bluetooth, Hmotnost 2,3 kg, bez operačního systému', 38490, 3, '2026-05-14', 1, 2, 4),
(37, 'Lenovo IdeaPad 5 Pro 16ARH7 Cloud Grey celokovový', 'img/products/LenovoIdeaPad5.jpg', 'Notebook - AMD Ryzen 5 6600HS, 16\" IPS antireflexní 2560 × 1600 120Hz, RAM 16GB LPDDR5, NVIDIA GeForce RTX 3050 4GB, SSD 1000GB, numerická klávesnice, webkamera, USB 3.2 Gen 1, USB-C, WiFi 6, Bluetooth, Hmotnost 1,95 kg, bez operačního systému', 20570, 3, '2026-05-14', 1, 2, 4),
(38, '31.5\" MSI G32C4X', 'img/products/MSIMonitor1.jpg', 'LCD monitor prohnutý, Full HD 1920 × 1080, VA, 16:9 širokoúhlý, 1 ms, 250Hz, FreeSync Premium, 10bit, 300 cd/m2, kontrast 3000:1, HDMI a DisplayPort, sluchátkový výstup, antireflexní povrch displeje, VESA', 5990, 5, '2026-05-14', 1, 4, 12),
(39, '23.8\" Dell P2422H Professional', 'img/products/DellMonitor1.jpg', 'LCD monitor Full HD 1920 × 1080, IPS, 16:9 širokoúhlý, 5 ms, 60Hz, 250 cd/m2, kontrast 1000:1, HDMI, DisplayPort a VGA, nastavitelná výška, pivot, VESA', 3669, 6, '2025-07-08', 1, 4, 11),
(40, '24\" Samsung S40UA', 'img/products/SamsungMonitor1.jpg', 'LCD monitor Full HD 1920 × 1080, IPS, 16:9 širokoúhlý, 5 ms, 75Hz, 250 cd/m2, kontrast 1000:1, HDMI, USB-C a DisplayPort, USB, sluchátkový výstup, nastavitelná výška, pivot, VESA, Power Delivery', 3490, 6, '0000-00-00', 1, 4, 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `sale`
--

CREATE TABLE `sale` (
  `ID` int(11) NOT NULL,
  `discount_percent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `sale`
--

INSERT INTO `sale` (`ID`, `discount_percent`) VALUES
(1, 0),
(2, 25);

-- --------------------------------------------------------

--
-- Struktura tabulky `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `ID` int(11) NOT NULL,
  `ID_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `shopping_cart`
--

INSERT INTO `shopping_cart` (`ID`, `ID_customer`) VALUES
(3, 11),
(4, 12),
(5, 12);

-- --------------------------------------------------------

--
-- Struktura tabulky `shopping_cart_item`
--

CREATE TABLE `shopping_cart_item` (
  `ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `ID_cart` int(11) NOT NULL,
  `ID_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `shopping_cart_item`
--

INSERT INTO `shopping_cart_item` (`ID`, `quantity`, `ID_cart`, `ID_product`) VALUES
(32, 1, 4, 7),
(33, 1, 4, 8);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_country` (`ID_country`);

--
-- Indexy pro tabulku `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_address` (`ID_address`);

--
-- Indexy pro tabulku `manafacturer`
--
ALTER TABLE `manafacturer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_sale` (`ID_sale`),
  ADD KEY `ID_category` (`ID_category`),
  ADD KEY `ID_manafacturer` (`ID_manafacturer`);

--
-- Indexy pro tabulku `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_customer` (`ID_customer`);

--
-- Indexy pro tabulku `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_cart` (`ID_cart`),
  ADD KEY `ID_product` (`ID_product`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `address`
--
ALTER TABLE `address`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pro tabulku `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pro tabulku `country`
--
ALTER TABLE `country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pro tabulku `manafacturer`
--
ALTER TABLE `manafacturer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pro tabulku `sale`
--
ALTER TABLE `sale`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`ID_country`) REFERENCES `country` (`ID`);

--
-- Omezení pro tabulku `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`ID_address`) REFERENCES `address` (`ID`);

--
-- Omezení pro tabulku `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`ID_sale`) REFERENCES `sale` (`ID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`ID_category`) REFERENCES `category` (`ID`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`ID_manafacturer`) REFERENCES `manafacturer` (`ID`);

--
-- Omezení pro tabulku `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`ID_customer`) REFERENCES `customer` (`ID`);

--
-- Omezení pro tabulku `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD CONSTRAINT `shopping_cart_item_ibfk_1` FOREIGN KEY (`ID_cart`) REFERENCES `shopping_cart` (`ID`),
  ADD CONSTRAINT `shopping_cart_item_ibfk_2` FOREIGN KEY (`ID_product`) REFERENCES `product` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
