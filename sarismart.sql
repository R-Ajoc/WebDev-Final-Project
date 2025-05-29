-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 09:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarismart`
--

DELIMITER $$

--
-- Procedures
--

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddProduct` (IN `p_product_name` VARCHAR(100), IN `p_category` ENUM('Drinks','Snacks','Canned Goods','Others'), IN `p_price` DECIMAL(10,2), IN `p_quantity` INT)   BEGIN
    INSERT INTO products (product_name, category, price, quantity)
    VALUES (p_product_name, p_category, p_price, p_quantity);
END$$

-- Fixed createTransaction procedure to use correct column names
DROP PROCEDURE IF EXISTS createTransaction $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createTransaction` (IN `p_items` JSON, OUT `p_transaction_id` INT)
BEGIN
    DECLARE v_total DECIMAL(10,2) DEFAULT 0;
    DECLARE v_now DATETIME;
    DECLARE idx INT DEFAULT 0;
    DECLARE total_items INT;

    DECLARE v_product_id INT;
    DECLARE v_quantity INT;
    DECLARE v_price DECIMAL(10,2);
    DECLARE v_subtotal DECIMAL(10,2);

    SET v_now = NOW();
    SET total_items = JSON_LENGTH(p_items);

    -- Insert the main transaction
    INSERT INTO transactions (transaction_date, total_amount)
    VALUES (v_now, 0);

    SET p_transaction_id = LAST_INSERT_ID();

    -- Loop through each item in the JSON array
    WHILE idx < total_items DO
        SET v_product_id = JSON_UNQUOTE(JSON_EXTRACT(p_items, CONCAT('$[', idx, '].product_id')));
        SET v_quantity = JSON_UNQUOTE(JSON_EXTRACT(p_items, CONCAT('$[', idx, '].quantity')));

        -- Get product price
        SELECT price INTO v_price FROM products WHERE product_id = v_product_id LIMIT 1;

        -- Calculate subtotal
        SET v_subtotal = v_price * v_quantity;
        SET v_total = v_total + v_subtotal;

        -- Insert transaction item with subtotal
        INSERT INTO transaction_items (transaction_id, product_id, quantity, subtotal)
        VALUES (p_transaction_id, v_product_id, v_quantity, v_subtotal);

        -- Deduct stock (your column is `quantity`, not `quantity_in_stock`)
        UPDATE products SET quantity = quantity - v_quantity
        WHERE product_id = v_product_id;

        SET idx = idx + 1;
    END WHILE;

    -- Update total in transaction
    UPDATE transactions SET total_amount = v_total
    WHERE transaction_id = p_transaction_id;
END $$
-- End Copilot fix

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteProduct` (IN `p_product_id` INT)   BEGIN
    DELETE FROM products WHERE product_id = p_product_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteTransactionItems` (IN `p_transaction_id` INT)   BEGIN
    DELETE FROM transaction_items
    WHERE transaction_id = p_transaction_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAdminPassword` ()   BEGIN
    SELECT password_hash FROM admin_security WHERE id = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllTransactions` ()   BEGIN
    SELECT 
        t.transaction_id, 
        p.product_name, 
        ti.quantity, 
        ti.total_amount, 
        t.transaction_date
    FROM transactions t
    JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
    JOIN products p ON ti.product_id = p.product_id
    ORDER BY t.transaction_date DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTransactionItems` (IN `p_transaction_id` INT)   BEGIN
    SELECT ti.transaction_item_id, ti.transaction_id, ti.product_id, p.product_name, ti.quantity, ti.total_price
    FROM transaction_items ti
    JOIN products p ON ti.product_id = p.product_id
    WHERE ti.transaction_id = p_transaction_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TopSelling` (IN `target_month` VARCHAR(7))   BEGIN
    SELECT 
        p.product_id,
        p.product_name,
        SUM(ti.quantity) AS total_sold
    FROM transaction_items ti
    JOIN transactions t ON ti.transaction_id = t.transaction_id
    JOIN products p ON ti.product_id = p.product_id
    WHERE DATE_FORMAT(t.transaction_date, '%Y-%m') = target_month
    GROUP BY p.product_id
    ORDER BY total_sold DESC
    LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateAdminPassword` (IN `p_new_password_hash` VARCHAR(255))   BEGIN
    UPDATE admin_security SET password_hash = p_new_password_hash WHERE id = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProduct` (IN `p_product_id` INT, IN `p_product_name` VARCHAR(255), IN `p_category` VARCHAR(100), IN `p_price` DECIMAL(10,2), IN `p_quantity` INT)   BEGIN
    UPDATE products
    SET product_name = p_product_name,
        category = p_category,
        price = p_price,
        quantity = p_quantity
    WHERE product_id = p_product_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_security`
--

CREATE TABLE `admin_security` (
  `id` int(11) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_security`
--

INSERT INTO `admin_security` (`id`, `password_hash`) VALUES
(1, '$2y$10$5kNiIwkZ0AwB2SvGI9KZY.ReYkS11FgurFrUL4HKVdxFOBIFhm0vO');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` enum('Drinks','Snacks','Canned Goods','Others') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `quantity`, `category`) VALUES
(1, 'Coca-Cola', 18.00, 24, 'Drinks'),
(2, 'Royal', 18.00, 12, 'Drinks'),
(3, 'Piattos', 12.00, 6, 'Snacks'),
(4, 'Rebisco', 8.00, 24, 'Snacks'),
(6, 'Sprite', 15.00, 12, 'Drinks'),
(7, 'Nova', 16.00, 6, 'Snacks'),
(9, 'Beef Loaf', 29.00, 24, 'Canned Goods');

-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_summary`
-- (See below for the actual view)
--
CREATE TABLE `sales_summary` (
`sale_month` varchar(7)
,`total_transactions` bigint(21)
,`total_sales` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `transaction_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------


--
-- Structure for view `sales_summary`
--
DROP TABLE IF EXISTS `sales_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sales_summary`  AS SELECT date_format(`t`.`transaction_date`,'%Y-%m') AS `sale_month`, count(`t`.`transaction_id`) AS `total_transactions`, sum(`t`.`total_amount`) AS `total_sales` FROM `transactions` AS `t` GROUP BY date_format(`t`.`transaction_date`,'%Y-%m') ORDER BY date_format(`t`.`transaction_date`,'%Y-%m') DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_security`
--
ALTER TABLE `admin_security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_security`
--
ALTER TABLE `admin_security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
