-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2018 at 12:20 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cdmis`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_name`, `password`, `access_type`) VALUES
(1, 'igcanafuego', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'kshear', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `ingredient_quantity` int(50) NOT NULL,
  `measurement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_name`, `ingredient_quantity`, `measurement_id`) VALUES
(1, 'Hotdog', 2, 1),
(2, 'Rice', 9, 2),
(3, 'Egg', 3, 1),
(4, 'Burger Patty', 2, 1),
(5, 'Iced Tea', 31, 3),
(6, 'Tapa', 1, 2),
(7, 'Blueberries', 3, 2),
(8, 'Pancake', 8, 1),
(9, 'Syrup', 25, 4),
(10, 'Potato', 8, 1),
(11, 'Mozzarella', 3, 2),
(12, 'Parmesan', 3, 2),
(13, 'Cheddar', 3, 2),
(14, 'Tomato Sauce', 11, 2),
(15, 'Pizza Crust', 7, 1),
(16, 'Cucumber Juice', 12, 2),
(17, 'Lemon Juice', 28, 2),
(18, 'Sugar', 69, 4),
(19, 'Water', 20, 2),
(20, 'Chocolate Cake', 5, 5),
(21, 'Whipped Cream', 6, 6),
(22, 'Vanilla Ice Cream', 5, 6),
(23, 'Waffles', 2, 1),
(24, 'Ground beef', 2, 2),
(25, 'Pepperoni', 1, 2),
(26, 'Cheese', 8, 2),
(27, 'Ham', 2, 2),
(28, 'Hungarian Sausage', 3, 2),
(29, 'Cheese Sauce', 15, 4),
(30, 'Oreos', 14, 1),
(31, 'Batter', 40, 4),
(32, 'Pork Sisig', 2, 2),
(33, 'Porkchop', 1, 1),
(34, 'Corned Beef', 0, 2),
(35, 'Fried Chicken', 1, 1),
(36, 'Pasta', 7, 2),
(37, 'Sausage', 7, 2),
(38, 'Peanuts', 3, 2),
(39, 'Banana', 3, 2),
(40, 'Milk', 3, 2),
(41, 'Ice', 3, 2),
(42, 'Pineapples', 1, 2),
(43, 'Chocolate Chips', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `log_msg` varchar(100) NOT NULL,
  `account_id` int(11) NOT NULL,
  `log_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `log_msg`, `account_id`, `log_date`) VALUES
(1, 'added menu: Hotsilog.', 1, '2018-09-23'),
(2, 'added menu: Tapsilog.', 1, '2018-09-23'),
(3, 'added ingredient: Tapa.', 1, '2018-09-23'),
(4, 'added menu: Blueberry Pancake.', 1, '2018-09-23'),
(5, 'added measurement: tbsp.', 1, '2018-09-23'),
(6, 'added ingredient: Blueberries.', 1, '2018-09-23'),
(7, 'added ingredient: Pancake.', 1, '2018-09-23'),
(8, 'added ingredient: Syrup.', 1, '2018-09-23'),
(9, 'added menu: Hashbrown.', 1, '2018-09-23'),
(10, 'added ingredient: Potato.', 1, '2018-09-23'),
(11, 'added the account of: zguanzon.', 1, '2018-09-23'),
(12, 'edited the account of: zguanzon.', 1, '2018-09-23'),
(13, 'edited the account of: zguanzon.', 1, '2018-09-23'),
(14, 'deleted account of: zguanzon.', 1, '2018-09-26'),
(15, 'deleted menu: Hashbrown.', 1, '2018-09-26'),
(16, 'added menu: Three Blind Mice Pizza.', 1, '2018-09-26'),
(17, 'added ingredient: Mozzarella.', 1, '2018-09-26'),
(18, 'added ingredient: Parmesan.', 1, '2018-09-26'),
(19, 'added ingredient: Cheddar.', 1, '2018-09-26'),
(20, 'added ingredient: Tomato Sauce.', 1, '2018-09-26'),
(21, 'added ingredient: Pizza Crust.', 1, '2018-09-26'),
(22, 'added menu: Cucumbernade.', 1, '2018-09-26'),
(23, 'added ingredient: Cucumber Juice.', 1, '2018-09-26'),
(24, 'added ingredient: Lemon Juice.', 1, '2018-09-26'),
(25, 'added ingredient: Sugar.', 1, '2018-09-26'),
(26, 'added menu: Lemonade.', 1, '2018-09-26'),
(27, 'added ingredient: Water.', 1, '2018-09-26'),
(28, 'added menu: Mug Cake.', 1, '2018-09-27'),
(29, 'added measurement: slice.', 1, '2018-09-27'),
(30, 'added measurement: scoop.', 1, '2018-09-27'),
(31, 'added ingredient: Chocolate Cake.', 1, '2018-09-27'),
(32, 'added ingredient: Whipped Cream.', 1, '2018-09-27'),
(33, 'added ingredient: Vanilla Ice Cream.', 1, '2018-09-27'),
(34, 'added menu: Hashbrown.', 1, '2018-09-27'),
(35, 'added order of table: 1.', 1, '2018-09-28'),
(36, 'updated bill status of table number 1 as Paid.', 1, '2018-09-28'),
(37, 'added order of table: 2.', 1, '2018-09-28'),
(38, 'updated bill status of table number 2 as Paid.', 1, '2018-09-28'),
(39, 'added order of table: 3.', 1, '2018-09-28'),
(40, 'updated bill status of table number 3 as Paid.', 1, '2018-09-28'),
(41, 'added order of table: 4.', 1, '2018-09-28'),
(42, 'updated bill status of table number 4 as Paid.', 1, '2018-09-28'),
(43, 'added order of table: 5.', 1, '2018-09-28'),
(44, 'updated bill status of table number 5 as Paid.', 1, '2018-09-28'),
(45, 'added menu: Blueberry Waffles.', 1, '2018-09-29'),
(46, 'added ingredient: Waffles.', 1, '2018-09-29'),
(47, 'added menu: Meat Overload Pizza.', 1, '2018-09-29'),
(48, 'added ingredient: Ground beef.', 1, '2018-09-29'),
(49, 'added ingredient: Pepperoni.', 1, '2018-09-29'),
(50, 'added ingredient: Cheese.', 1, '2018-09-29'),
(51, 'added ingredient: Ham.', 1, '2018-09-29'),
(52, 'added menu: Spicy Hungarian Pizza.', 1, '2018-09-29'),
(53, 'added ingredient: Hungarian Sausage.', 1, '2018-09-29'),
(54, 'added ingredient: Cheese Sauce.', 1, '2018-09-29'),
(55, 'added menu: Fried Oreos.', 1, '2018-09-29'),
(56, 'added measurement: pcs.', 1, '2018-09-29'),
(57, 'added ingredient: Oreos.', 1, '2018-09-29'),
(58, 'added ingredient: Batter.', 1, '2018-09-29'),
(59, 'added menu: Burger Steak Meal.', 1, '2018-09-29'),
(60, 'added menu: Sisig Meal.', 1, '2018-09-29'),
(61, 'added ingredient: Sisig.', 1, '2018-09-29'),
(62, 'added menu: Porkchop Meal.', 1, '2018-09-29'),
(63, 'added ingredient: Porkchop.', 1, '2018-09-29'),
(64, 'added menu: Cornsilog.', 1, '2018-09-29'),
(65, 'added ingredient: Corned Beef.', 1, '2018-09-29'),
(66, 'added menu: Fried Chicken Meal.', 1, '2018-09-29'),
(67, 'added ingredient: Fried Chicken.', 1, '2018-09-29'),
(68, 'added menu: Spaghetti.', 1, '2018-09-29'),
(69, 'added ingredient: Pasta.', 1, '2018-09-29'),
(70, 'added ingredient: Sausage.', 1, '2018-09-29'),
(71, 'added order of table: 1.', 1, '2018-09-29'),
(72, 'updated bill status of table number 1 as Paid.', 1, '2018-09-29'),
(73, 'added order of table: 2.', 1, '2018-09-29'),
(74, 'updated bill status of table number 2 as Paid.', 1, '2018-09-29'),
(75, 'added order of table: 3.', 1, '2018-09-29'),
(76, 'updated bill status of table number 3 as Paid.', 1, '2018-09-29'),
(77, 'added order of table: 4.', 1, '2018-09-29'),
(78, 'updated bill status of table number 4 as Paid.', 1, '2018-09-29'),
(79, 'added order of table: 5.', 1, '2018-09-29'),
(80, 'updated bill status of table number 5 as Paid.', 1, '2018-09-29'),
(81, 'added order of table: 6.', 1, '2018-09-29'),
(82, 'cancelled order of table .', 1, '2018-09-29'),
(83, 'added order of table: 8.', 1, '2018-09-29'),
(84, 'added order of table: 9.', 1, '2018-09-29'),
(85, 'added order of table: 6.', 1, '2018-09-29'),
(86, 'updated bill status of table number 6 as Paid.', 1, '2018-09-29'),
(87, 'added order of table: 7.', 2, '2018-09-29'),
(88, 'added order of table: 8.', 2, '2018-09-29'),
(89, 'added order of table: 9.', 2, '2018-09-29'),
(90, 'added order of table: 10.', 2, '2018-09-29'),
(91, 'updated bill status of table number 7 as Paid.', 2, '2018-09-29'),
(92, 'updated bill status of table number 8 as Paid.', 2, '2018-09-29'),
(93, 'updated bill status of table number 9 as Paid.', 2, '2018-09-29'),
(94, 'updated bill status of table number 10 as Paid.', 2, '2018-09-29'),
(95, 'added order of table: 1.', 2, '2018-09-29'),
(96, 'added order of table: 2.', 2, '2018-09-29'),
(97, 'added order of table: 3.', 2, '2018-09-29'),
(98, 'added order of table: 4.', 2, '2018-09-29'),
(99, 'cancelled order of table .', 2, '2018-09-29'),
(100, 'added order of table: 1.', 2, '2018-09-30'),
(101, 'added order of table: 2.', 2, '2018-09-30'),
(102, 'added order of table: 3.', 2, '2018-09-30'),
(103, 'added order of table: 4.', 2, '2018-09-30'),
(104, 'added order of table: 5.', 2, '2018-09-30'),
(105, 'updated bill status of table number 1 as Paid.', 2, '2018-09-30'),
(106, 'updated bill status of table number 2 as Paid.', 2, '2018-09-30'),
(107, 'updated bill status of table number 3 as Paid.', 2, '2018-09-30'),
(108, 'updated bill status of table number 4 as Paid.', 2, '2018-09-30'),
(109, 'updated bill status of table number 5 as Paid.', 2, '2018-09-30'),
(110, 'added menu: Peanut Banana Smoothie.', 1, '2018-09-30'),
(111, 'added ingredient: Peanuts.', 1, '2018-09-30'),
(112, 'added ingredient: Banana.', 1, '2018-09-30'),
(113, 'added ingredient: Milk.', 1, '2018-09-30'),
(114, 'added ingredient: Ice.', 1, '2018-09-30'),
(115, 'added menu: Iced Tea Pitcher.', 1, '2018-09-30'),
(116, 'added menu: Tater Tots.', 1, '2018-09-30'),
(117, 'added menu: Oreo Pancakes.', 1, '2018-09-30'),
(118, 'added menu: Oreo Waffles.', 1, '2018-09-30'),
(119, 'added menu: Hawaiian Pizza.', 1, '2018-09-30'),
(120, 'added ingredient: Pineapples.', 1, '2018-09-30'),
(121, 'added menu: Chocolate Chip Pancakes.', 1, '2018-09-30'),
(122, 'added ingredient: Chocolate Chips.', 1, '2018-09-30'),
(123, 'added menu: Chocolate Chip Waffles.', 1, '2018-09-30'),
(124, 'added order of table: 6.', 2, '2018-09-30'),
(125, 'added order of table: 7.', 2, '2018-09-30'),
(126, 'added order of table: 8.', 2, '2018-09-30'),
(127, 'added order of table: 9.', 2, '2018-09-30'),
(128, 'added order of table: 10.', 2, '2018-09-30'),
(129, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(130, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(131, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(132, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(133, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(134, 'added order of table: 11.', 2, '2018-09-30'),
(135, 'added order of table: 12.', 2, '2018-09-30'),
(136, 'added order of table: 13.', 2, '2018-09-30'),
(137, 'added order of table: 14.', 2, '2018-09-30'),
(138, 'added order of table: 15.', 2, '2018-09-30'),
(139, 'added order of table: 16.', 2, '2018-09-30'),
(140, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(141, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(142, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(143, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(144, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(145, 'updated bill status of table number  as Paid.', 2, '2018-09-30'),
(146, 'added order of table: 20.', 2, '2018-09-30'),
(147, 'added order of table: 20.', 2, '2018-09-30'),
(148, 'added order of table: 20.', 2, '2018-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `measurement_id` int(11) NOT NULL,
  `measurement_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`measurement_id`, `measurement_name`) VALUES
(1, 'pc'),
(2, 'cup'),
(3, 'glass'),
(4, 'tbsp'),
(5, 'slice'),
(6, 'scoop');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `menu_status` int(11) NOT NULL,
  `frequency` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `category`, `price`, `menu_status`, `frequency`) VALUES
(1, 'Hotsilog', 'all-day-breakfast', 60, 1, 3),
(3, 'Tapsilog', 'all-day-breakfast', 60, 1, 1),
(4, 'Blueberry Pancake', 'waffles-pancakes', 55, 1, 2),
(6, 'Three Blind Mice Pizza', 'pizza-quesadillas', 240, 1, 3),
(8, 'Cucumbernade', 'drinks', 40, 1, 12),
(9, 'Lemonade', 'drinks', 35, 1, 8),
(10, 'Mug Cake', 'others', 80, 1, 6),
(11, 'Hashbrown', 'others', 30, 1, 8),
(12, 'Blueberry Waffles', 'waffles-pancakes', 55, 1, 1),
(13, 'Meat Overload Pizza', 'pizza-quesadillas', 260, 1, 1),
(14, 'Spicy Hungarian Pizza', 'pizza-quesadillas', 260, 1, 3),
(15, 'Fried Oreos', 'others', 40, 1, 5),
(16, 'Burger Steak Meal', 'all-day-breakfast', 60, 1, 2),
(17, 'Sisig Meal', 'all-day-breakfast', 65, 1, 4),
(18, 'Porkchop Meal', 'all-day-breakfast', 75, 1, 3),
(19, 'Cornsilog', 'all-day-breakfast', 60, 1, 0),
(20, 'Fried Chicken Meal', 'all-day-breakfast', 65, 1, 2),
(21, 'Spaghetti', 'others', 65, 1, 7),
(22, 'Peanut Banana Smoothie', 'drinks', 40, 1, 4),
(23, 'Iced Tea Pitcher', 'drinks', 30, 1, 7),
(24, 'Tater Tots', 'others', 60, 0, 0),
(25, 'Oreo Pancakes', 'waffles-pancakes', 55, 1, 1),
(26, 'Oreo Waffles', 'waffles-pancakes', 85, 1, 1),
(27, 'Hawaiian Pizza', 'pizza-quesadillas', 240, 1, 1),
(28, 'Chocolate Chip Pancakes', 'waffles-pancakes', 85, 1, 2),
(29, 'Chocolate Chip Waffles', 'waffles-pancakes', 85, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `table_number` int(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `bill` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `table_number`, `status`, `bill`, `discount`) VALUES
(1, '2018-09-29', 1, 'Paid', 180, 20),
(2, '2018-09-29', 2, 'Paid', 145, 0),
(3, '2018-09-29', 3, 'Paid', 275, 20),
(4, '2018-09-29', 4, 'Paid', 325, 0),
(5, '2018-09-29', 5, 'Paid', 135, 0),
(6, '2018-09-29', 6, 'Paid', 60, 20),
(7, '2018-09-29', 7, 'Paid', 170, 0),
(8, '2018-09-29', 8, 'Paid', 70, 0),
(9, '2018-09-29', 9, 'Paid', 95, 0),
(10, '2018-09-29', 10, 'Paid', 105, 0),
(11, '2018-09-29', 1, 'Paid', 100, 0),
(12, '2018-09-29', 2, 'Paid', 100, 0),
(13, '2018-09-29', 3, 'Paid', 165, 0),
(14, '2018-09-30', 1, 'Paid', 100, 0),
(15, '2018-09-30', 2, 'Paid', 400, 20),
(16, '2018-09-30', 3, 'Paid', 485, 0),
(17, '2018-09-30', 4, 'Paid', 360, 0),
(18, '2018-09-30', 5, 'Paid', 210, 0),
(19, '2018-09-30', 6, 'Paid', 270, 20),
(20, '2018-09-30', 7, 'Paid', 210, 0),
(21, '2018-09-30', 8, 'Paid', 340, 0),
(22, '2018-09-30', 9, 'Paid', 560, 0),
(23, '2018-09-30', 10, 'Paid', 135, 0),
(24, '2018-09-30', 11, 'Paid', 200, 0),
(25, '2018-09-30', 12, 'Paid', 120, 0),
(26, '2018-09-30', 13, 'Paid', 235, 20),
(27, '2018-09-30', 14, 'Paid', 200, 0),
(28, '2018-09-30', 15, 'Paid', 125, 0),
(29, '2018-09-30', 16, 'Paid', 300, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `item_id` int(50) NOT NULL,
  `order_id` int(50) NOT NULL,
  `menu_id` int(50) NOT NULL,
  `order_quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`item_id`, `order_id`, `menu_id`, `order_quantity`) VALUES
(1, 1, 21, '1'),
(2, 1, 8, '1'),
(3, 1, 10, '1'),
(4, 2, 8, '1'),
(5, 2, 10, '1'),
(6, 2, 11, '1'),
(7, 3, 6, '1'),
(8, 3, 9, '1'),
(9, 4, 17, '1'),
(10, 4, 14, '1'),
(11, 5, 21, '1'),
(12, 5, 15, '1'),
(13, 5, 11, '1'),
(14, 6, 3, '1'),
(18, 7, 4, '1'),
(19, 7, 12, '1'),
(20, 8, 11, '1'),
(21, 8, 15, '1'),
(22, 9, 11, '1'),
(23, 9, 21, '1'),
(24, 10, 15, '1'),
(25, 10, 8, '1'),
(26, 10, 11, '1'),
(27, 11, 20, '1'),
(28, 11, 8, '1'),
(29, 12, 9, '1'),
(30, 12, 21, '1'),
(31, 13, 4, '1'),
(32, 13, 10, '1'),
(33, 14, 11, '2'),
(34, 14, 15, '1'),
(35, 15, 14, '1'),
(36, 15, 8, '2'),
(37, 15, 9, '2'),
(38, 16, 6, '1'),
(39, 16, 8, '4'),
(40, 17, 21, '2'),
(41, 17, 8, '2'),
(42, 17, 10, '2'),
(43, 18, 17, '1'),
(44, 18, 18, '1'),
(45, 18, 9, '2'),
(46, 19, 27, '1'),
(47, 19, 23, '1'),
(48, 20, 25, '1'),
(49, 20, 28, '1'),
(50, 20, 9, '2'),
(51, 21, 22, '2'),
(52, 21, 14, '1'),
(53, 22, 13, '1'),
(54, 22, 6, '1'),
(55, 22, 23, '2'),
(56, 23, 11, '1'),
(57, 23, 21, '1'),
(58, 23, 22, '1'),
(59, 24, 26, '1'),
(60, 24, 29, '1'),
(61, 24, 23, '1'),
(62, 25, 15, '1'),
(63, 25, 10, '1'),
(64, 26, 18, '1'),
(65, 26, 23, '1'),
(66, 26, 17, '2'),
(67, 27, 20, '1'),
(68, 27, 18, '1'),
(69, 27, 1, '1'),
(70, 28, 28, '1'),
(71, 28, 22, '1'),
(72, 29, 16, '2'),
(73, 29, 23, '2'),
(74, 29, 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `recipe_id` int(11) NOT NULL,
  `menu_id` int(50) NOT NULL,
  `ingredient_id` int(50) NOT NULL,
  `recipe_quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `menu_id`, `ingredient_id`, `recipe_quantity`) VALUES
(1, 1, 1, '1'),
(2, 1, 2, '1'),
(3, 1, 3, '1'),
(4, 3, 6, '1'),
(5, 3, 2, '1'),
(6, 3, 3, '1'),
(11, 6, 11, '1'),
(12, 6, 12, '1'),
(13, 6, 13, '1'),
(14, 6, 14, '1'),
(15, 6, 15, '1'),
(20, 9, 17, '2'),
(21, 9, 19, '1'),
(22, 9, 18, '3'),
(27, 10, 20, '1'),
(28, 10, 21, '1'),
(29, 10, 22, '1'),
(30, 11, 10, '1'),
(38, 13, 24, '1'),
(39, 13, 25, '1'),
(40, 13, 26, '1'),
(41, 13, 27, '1'),
(42, 14, 28, '1'),
(43, 14, 15, '1'),
(44, 14, 29, '5'),
(45, 15, 30, '3'),
(46, 15, 31, '10'),
(47, 16, 4, '1'),
(48, 16, 2, '1'),
(49, 16, 5, '1'),
(50, 17, 32, '1'),
(51, 17, 2, '1'),
(52, 17, 5, '1'),
(53, 18, 33, '1'),
(54, 18, 2, '1'),
(55, 18, 5, '1'),
(56, 19, 34, '1'),
(57, 19, 2, '1'),
(58, 19, 3, '1'),
(59, 20, 35, '1'),
(60, 20, 2, '1'),
(61, 20, 5, '1'),
(62, 21, 36, '1'),
(63, 21, 14, '1'),
(64, 21, 26, '1'),
(65, 21, 37, '1'),
(97, 12, 7, '1'),
(98, 12, 23, '2'),
(99, 12, 9, '5'),
(100, 12, 21, '1'),
(104, 27, 27, '1'),
(105, 27, 15, '1'),
(106, 27, 14, '1'),
(107, 27, 42, '1'),
(108, 27, 24, '1'),
(109, 24, 10, '2'),
(110, 8, 16, '1'),
(111, 8, 17, '1'),
(112, 8, 18, '3'),
(113, 8, 19, '1'),
(114, 22, 38, '1'),
(115, 22, 39, '1'),
(116, 22, 18, '3'),
(117, 22, 40, '1'),
(118, 22, 41, '1'),
(119, 29, 43, '1'),
(120, 29, 23, '2'),
(121, 29, 9, '5'),
(122, 23, 5, '5'),
(123, 4, 7, '1'),
(124, 4, 8, '1'),
(125, 4, 9, '5'),
(126, 25, 30, '2'),
(127, 25, 8, '3'),
(128, 25, 9, '5'),
(129, 26, 30, '2'),
(130, 26, 23, '2'),
(131, 26, 9, '5'),
(132, 28, 43, '1'),
(133, 28, 8, '3'),
(134, 28, 9, '5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD KEY `measurement_id` (`measurement_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`measurement_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `measurement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `item_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD CONSTRAINT `orders_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `orders_item_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`);

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
