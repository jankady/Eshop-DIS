-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 19. dub 2024, 10:36
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

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
(31, 'test', 'test', '87940', 'test', 1);

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
(1, 'Mobile'),
(2, 'Laptop'),
(3, 'Tablet');

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
(1, 'Czechia'),
(2, 'Poland'),
(3, 'Austria'),
(4, 'Germany'),
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
(3, 'Jan', 'Kaduch', 'Kaduch05@gmail.com', 773007138, '$2y$10$NTkc2XM8E/zaey4uFYMk0.BXwQC8F/mtMMiMIwf1OrbJop3fKVDPW', '', 24),
(4, '', '', '', 0, '$2y$10$ou5AT89vm0Wzon7Y.VaRxuIqH94E.zjIcqvumzOorAeNaHXmsAo0W', '', 25),
(5, 'Jan', 'Kaduch', 'Kaduch05@gmail.com', 773007138, '$2y$10$hLL.tdDjI8BDfYcH8qiFmurzQ1yKaSjIHstJ/4zQy6LlbhqcHXtMy', '', 26),
(6, 'Jan', 'Kaduch', 'Kaduch0@gmail.com', 123, '$2y$10$4dh0CZ0z6eBpMNJ9mKrEJOTEFem45WmZou/0EM8yZe/ZmZ1.LA.Yy', 'j', 27),
(7, 'Jan', 'Kaduch', 'Kasvxcydaduch05@gmail.com', 7730, '$2y$10$Eo4BTLRzn3Ypovlvki3eZOIia0PX27Dy9Qarzag1nWt3mrmmoiDNC', 'dgf', 28),
(8, 'Jan', 'Kaduch', 'Kaduch0xcyvxdycgdfshgdf5@gmail.com', 2147483647, '$2y$10$mt8dnNB86u7hBRs9mT3ZluKcKyoeRby.E1N73xMu7ep03i.dF8Try', '564gftuj', 29),
(9, 'test_firstname', 'test_lastname', 'test@email.com', 321465978, '$2y$10$mZGE9p4BwAPdfKkfu7Xjz.a9gUC860WwE1iuPmm7fSVXwAnso7Ti6', 'test_username', 30),
(10, 'test', 'test', 'test@test.test', 2147483647, '$2y$10$5qLBC5x8SksvngqiGF3gcurCxjeypm3/jCg4X19Ek2TSYkocVlmba', 'test', 31);

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
(6, 'Xiaomi');

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
(1, 'Iphone 12', 'img/products/Iphone12.png', 'super fotak pro iphone 12', 15000, 5, '2025-01-09', 1, 1, 1),
(2, 'Asus vivo', 'img/products/ASUSVivoBook.png', 'super nadupaný nootebook', 17000, 1, '2026-01-14', 2, 2, 2),
(3, 'Huawei P30', 'img/products/HuaweiP30.png', 'modrý mobil Huawei', 8000, 0, '2026-01-22', 1, 1, 3),
(4, 'LenovoTab P12', 'img/products/LenovoTabP12.png', 'super tablet Lenova', 11000, 15, '2024-01-19', 1, 3, 4),
(5, 'MacBook air M1', 'img/products/MacBook.png', 'Skvělý nový nadupaný macbook s M1 čipem a slušným rozlišením', 24599, 3, '2028-03-10', 2, 2, 1),
(6, 'Samsung A30 ', 'img/products/SamsungA30.png', 's touch ID a foťák pro pořízení fotek nejlepší kvality', 12800, 12, '2026-01-16', 1, 1, 5),
(7, 'Xiaomi RedmiNote 9', 'img/products/XiaomiRedmiNote9.png', 'nový produkt od Xiaomi s neuvěřitelnou rychlostí', 7899, 4, '2026-03-19', 2, 1, 6),
(8, 'Samsung Galaxy Tab S7', 'img/products/SamsungGalaxyTabS7.png', 'perfektní pro grafiky a profesionaly v kreslení', 450000, 99, '2026-04-09', 1, 3, 5);

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
(1, 9),
(2, 10);

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
(4, 1, 1, 8),
(5, 4, 1, 7),
(6, 1, 1, 6),
(7, 1, 2, 4),
(8, 2, 2, 5),
(9, 2, 2, 8),
(10, 2, 2, 7),
(11, 1, 2, 6);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pro tabulku `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `country`
--
ALTER TABLE `country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `manafacturer`
--
ALTER TABLE `manafacturer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `sale`
--
ALTER TABLE `sale`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
