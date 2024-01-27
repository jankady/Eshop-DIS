-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 27. led 2024, 17:50
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
  `house_number` int(11) NOT NULL,
  `ID_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

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
(2, 'Laptop');

-- --------------------------------------------------------

--
-- Struktura tabulky `country`
--

CREATE TABLE `country` (
  `ID` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `password` varchar(4096) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ID_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

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
(2, 'Asus');

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
(1, 'Iphone 12', 'img/products/Iphone12.jpg', 'super fotak pro iphone 12', 15000, 5, '2024-01-31', 1, 1, 1),
(2, 'Asus vivo', 'img/products/ASUSVivoBook.jpg', 'super nadupaný nootebook', 17000, 1, '2024-01-31', 2, 2, 2);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `country`
--
ALTER TABLE `country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `manafacturer`
--
ALTER TABLE `manafacturer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `sale`
--
ALTER TABLE `sale`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

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
