-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 10, 2020 at 06:22 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `specialtop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `added_by_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_at` datetime DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `parentid_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `keywords`, `description`, `status`, `created_at`, `updated_at`, `image_id`, `parentid_id`) VALUES
(1, 'Hot Drinks', 'Hot Drinks, Coffee, Milk, Chocolate ,Hot Chocolate, Cappuccino', 'Hot drink that will make warn.', 'Published', '2019-11-11 00:00:00', NULL, 38, 4),
(2, 'Cool Drink', 'Cool Drink, coca cola, pepsi, Seven-Up, Fanta', 'Awesome Cool Drinks', 'Published', NULL, NULL, NULL, 4),
(4, 'Drink', 'Drink, Hot Drink, Cold Drink, coca cola, pepsi', 'All the hot and cold drink, sugar and sugarless drinks for all.', 'Published', '2019-12-02 00:00:00', NULL, NULL, NULL),
(5, 'Dessert', 'Sweet, Dessert, Sugar', 'Served as the last course of a meal, a dessert is often sweet, like cake or pie. If you have a sweet tooth, you may wish it were the only course of the meal', 'Published', '2019-12-15 00:00:00', NULL, NULL, NULL),
(6, 'Biscuits or Cookies', 'Aachener Printen, Abernethy, Acıbadem kurabiyesi, Afghan biscuits, ANZAC biscuit, biscuits, cookies', 'A baked or cooked food that is typically small, flat and sweet. It usually contains flour, sugar and some type of oil or fat. It may include other ingredients such as raisins, oats, chocolate chips, nuts, etc.', 'Published', '2019-12-20 00:00:00', NULL, 35, 5),
(7, 'Fast Food', 'quality fresh food, fresh food, wendys, wendys fast food', '\"fast food\" is a commercial term limited to food sold in a restaurant or store with frozen, preheated or precooked ingredients, and served to the customer in a packaged form for take-out/take-away.', 'Published', '2019-12-15 00:00:00', NULL, 35, NULL),
(8, 'Hamburger', 'Burger, Hamburger, Chess hamburger, Chess burger', 'A hamburger (short: burger) is a sandwich consisting of one or more cooked patties of ground meat, usually beef, placed inside a sliced bread roll or bun. The patty may be pan fried, grilled, smoked or flame broiled. ... There are many international and regional variations of the hamburger.', 'Published', '2019-12-26 00:00:00', NULL, 35, 7),
(9, 'Cake', 'Pound Cake, Sponge Cake, Genoise Cake, Biscuit Cake, Angel Food Cake,Chiffon Cake, Baked Flourless Cake.', 'Some varieties of cake are widely available in the form of cake mixes, wherein some of the ingredients (usually flour, sugar, flavoring, baking powder, and sometimes some form of fat) are premixed, and the cook needs add only a few extra ingredients, usually eggs, water, and sometimes vegetable oil or butter.', 'Published', '2019-12-10 00:00:00', NULL, 35, 5),
(10, 'Home Meal', 'Home meal, meal, rice, chicken', 'Eating homemade foods is usually much cheaper than eating at a restaurant or buying processed foods from the market. Ben’s advice: “When we eat at a restaurant, we pay for not only the food, but also the costs of running that business.', 'Published', '2019-12-11 09:16:08', NULL, 38, NULL),
(11, 'Home Meal Pasta', 'home, home meal, pasta, home meal pasta', 'this is home meal pasta description', 'Published', '2020-01-09 13:24:52', NULL, 59, 10);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `commented_by_id` int(11) DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `commented_at` datetime NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `commented_by_id`, `comment`, `commented_at`, `product_id`, `status`, `updated_at`, `rate`, `ip`) VALUES
(1, 10, '<p>One of the greatest coffee that I ever have in my life. &lt;3</p>', '2019-12-10 00:00:00', 3, 1, NULL, 5, NULL),
(2, 1, '<p>jdfkadklfajkld;fjkd</p>', '2020-01-04 03:30:44', 7, 1, '2020-01-04 03:30:44', 5, '127.0.0.1'),
(3, 1, '<p>Hello testing.</p>', '2020-01-04 03:46:35', 7, 1, '2020-01-04 03:46:35', 3, '127.0.0.1'),
(5, 1, '<p>Test comment for birthday cake</p>', '2020-01-09 13:43:38', 14, 1, '2020-01-09 13:43:38', 5, '127.0.0.1'),
(6, 1, '<p>Not bad, not good</p>', '2020-01-09 13:44:06', 9, 1, '2020-01-09 13:44:06', 3, '127.0.0.1'),
(7, 1, '<p>oooh, so good</p>', '2020-01-09 13:44:21', 12, 1, '2020-01-09 13:44:21', 5, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `image_id`, `name`, `price`, `keywords`, `description`, `created_at`, `updated_at`, `category_id`, `status`) VALUES
(3, 46, 'Coffee', 2, 'coffee shops, coffee shops near me, espresso, mocha, cappuccino, coffee near me, green coffee', 'Coffee is a brewed drink prepared from roasted coffee beans, the seeds of berries from certain Coffea species. ... Roasted beans are ground and then brewed with near-boiling water to produce the beverage known as coffee.', '2019-12-09 00:00:00', '2019-12-09 00:00:00', 2, NULL),
(5, 47, 'Chess Burger', 7, 'Burger, Chess Burger', 'A cheeseburger is a hamburger topped with cheese. ... As with other hamburgers, a cheeseburger may include toppings, such as lettuce, tomato, onion, pickles, bacon, mayonnaise, ketchup, mustard or other toppings.', '2019-12-19 00:00:00', '2019-12-19 00:00:00', 8, NULL),
(6, 48, 'Pound Cake', 5, 'pound cakes, pound cake, poundcakes, poundcake', 'Pound cake is a type of cake traditionally made with a pound of each of four ingredients: flour, butter, eggs, and sugar. Pound cakes are generally baked in either a loaf pan or a Bundt mold, and served either dusted with powdered sugar, lightly glazed, or sometimes with a coat of icing.', '2019-12-11 00:00:00', '2019-12-10 00:00:00', 9, NULL),
(7, 49, 'Coca Cola', 3, 'Coca-Cola, Cool Drink, Drink, Sugar', 'oca‑Cola, the best-known and biggest-selling soft drink in history. Coca‑Cola HBC is one of the world’s largest bottlers of products of The Coca‑Cola Company.', '2019-12-10 00:00:00', '2019-12-16 00:00:00', 2, NULL),
(9, 59, 'Pasta', 10, 'pasta', 'this is pasta description', '2020-01-09 13:21:17', NULL, 11, NULL),
(10, 64, 'Meat Burger', 5, 'meat burger, meat, burger', 'This is meat burger description', '2020-01-09 13:27:22', NULL, 8, NULL),
(11, 68, 'Lemon Drink', 5, 'lemon, drink, lemon drink', 'this is description of lemon drink', '2020-01-09 13:31:23', NULL, 2, NULL),
(12, 72, 'Coco Drink', 5, 'coco, coco drink, hot, sweet', 'This is coco drink description', '2020-01-09 13:35:17', NULL, 1, NULL),
(13, 75, 'Chocolate Chip Cookies', 7, 'cookies, chocolate, chip, chocolate chip cookies', 'this is description of chocolate chip cookies', '2020-01-09 13:37:58', NULL, 6, NULL),
(14, 78, 'Birthday Cake', 20, 'cake, birthday, birthday cake', 'this is birthday cake description', '2020-01-09 13:41:58', NULL, 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_image`
--

CREATE TABLE `food_image` (
  `food_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_image`
--

INSERT INTO `food_image` (`food_id`, `image_id`) VALUES
(3, 35),
(3, 38),
(3, 43),
(3, 45),
(9, 59),
(9, 60),
(9, 61),
(10, 62),
(10, 63),
(10, 64),
(11, 65),
(11, 67),
(11, 68),
(12, 69),
(12, 70),
(12, 71),
(12, 72),
(13, 73),
(13, 74),
(13, 75),
(14, 76),
(14, 77),
(14, 78);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `location`, `uploaded_by_id`, `title`) VALUES
(35, 'amirali-mirhashemian-pucP6jZSyV4-unsplash-5dd99b59785ab.jpeg', 10, 'Amirali'),
(38, 'olayinka-babalola-r01ZopTiEV8-unsplash-5ddbe92166d32.jpeg', 10, 'Olyinka'),
(43, 'toa-heftiba-2eylVMKAr1A-unsplash-5ddf0c747b7a5.jpeg', 10, 'Toa heftiba'),
(45, 'toa-heftiba-PH_szZ4BmN8-unsplash-5ddf0f02a40e7.jpeg', 10, 'Toa Heftiba'),
(46, 'coffee-5dea5e613fad0.jpeg', 10, 'Coffee Photo'),
(47, 'Normal Burger-5dea6182dd796.jpeg', 10, 'Burger Photo - 1'),
(48, 'Pound Cake-5dea65d8148f0.jpeg', 10, 'Pound Cake Photo'),
(49, 'coca cola can - png-5def51c2beaa3.png', 10, 'Coca Cola Can - 1'),
(53, 'profile image - 2-5df0d105b84bc.jpeg', NULL, 'Profile Image - 2'),
(57, 'profile image - 3-5df1698515a35.jpeg', 10, 'Profile Image - 1'),
(58, 'profile -1-5df3acf2b1781.jpeg', 10, 'profile 2'),
(59, 'past--5e16fec2d4a79.jpeg', 1, 'Pasta-1'),
(60, 'pasta-1-5e16fedf63260.jpeg', 1, 'Pasta-2'),
(61, 'pasta-3-5e16feeb4bd1d.jpeg', 1, 'Pasta-3'),
(62, 'meat burger - 1-5e170062d3c57.jpeg', 1, 'meat burger - 1'),
(63, 'meat burger - 2-5e17006c71c32.jpeg', 1, 'meat burger - 2'),
(64, 'meat-burger-3-5e17007655f33.png', 1, 'meat burger - 3'),
(65, 'lemon - 1-5e17010f4c89d.jpeg', 1, 'Lemon Drink - 1'),
(66, 'lemon - 1-5e1701142a019.jpeg', 1, 'Lemon Drink - 2'),
(67, 'lemon drink - 3-5e170121baf79.jpeg', 1, 'Lemon Drink - 2'),
(68, 'lemon drink - 2-5e170129cefa4.jpeg', 1, 'Lemon Drink - 3'),
(69, 'coca drink-1-5e1701f5ef052.jpeg', 1, 'Coco - 1'),
(70, 'coco - 2-5e1701fd068a3.jpeg', 1, 'Coco - 2'),
(71, 'coco-3-5e1702061c69d.jpeg', 1, 'Coco - 3'),
(72, 'coco 4-5e17020f0ac21.jpeg', 1, 'Coco - 4'),
(73, 'chocolate chip cookies - 1-5e1702c57110b.jpeg', 1, 'chocolate chip cookies - 1'),
(74, 'chocolate chip cookies - 2-5e1702d029b93.jpeg', 1, 'chocolate chip cookies - 2'),
(75, 'chocolate chip cookies - 3-5e1702d921763.jpeg', 1, 'chocolate chip cookies - 3'),
(76, 'birthday cake - 1-5e170388e9914.jpeg', 1, 'Birthday cake - 1'),
(77, 'birthday cake - 2-5e170391d60f4.jpeg', 1, 'Birthday cake - 2'),
(78, 'birthday cake - 3-5e17039a7bd1e.jpeg', 1, 'Birthday cake - 3');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `email`, `phone`, `subject`, `ip`, `status`, `created_at`, `updated_at`, `message`) VALUES
(1, 'Name', 'email@email.com', '+901234567989', 'Testing', '127.0.0.1', 'New', '2020-01-04 04:34:33', '2020-01-04 04:34:33', NULL),
(2, 'Name', 'minlwinkyaw307@gmail.com', '1234', 'Testing', '127.0.0.1', 'New', '2020-01-09 16:46:07', '2020-01-09 16:46:07', NULL),
(3, 'Name', 'minlwinkyaw307@gmail.com', '1234', 'Testing', '127.0.0.1', 'New', '2020-01-09 16:50:57', '2020-01-09 16:50:57', NULL),
(4, 'Name', 'minlwinkyaw307@gmail.com', '1234', 'Testing', '127.0.0.1', 'New', '2020-01-09 16:52:20', '2020-01-09 16:52:20', NULL),
(5, 'Name', 'minlwinkyaw307@gmail.com', '1234', 'Testing', '127.0.0.1', 'New', '2020-01-09 16:53:02', '2020-01-09 16:53:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191210103525', '2019-12-10 10:35:27'),
('20191210103815', '2019-12-10 10:38:18'),
('20191210103839', '2019-12-10 10:38:43'),
('20191210104016', '2019-12-10 10:40:19'),
('20191211220146', '2019-12-11 22:01:49'),
('20200103130403', '2020-01-03 13:04:18'),
('20200103232732', '2020-01-03 23:27:35'),
('20200104012053', '2020-01-04 01:20:56'),
('20200104012918', '2020-01-04 01:29:21'),
('20200104015556', '2020-01-04 01:55:59'),
('20200104020110', '2020-01-04 02:01:13'),
('20200105224246', '2020-01-05 22:42:49'),
('20200109101818', '2020-01-09 10:18:21'),
('20200109101908', '2020-01-09 10:19:11'),
('20200109132008', '2020-01-09 13:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `odr`
--

CREATE TABLE `odr` (
  `id` int(11) NOT NULL,
  `ordered_by_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `odr`
--

INSERT INTO `odr` (`id`, `ordered_by_id`, `product_id`, `amount`, `status`, `ordered_at`) VALUES
(43, 10, 3, 3, 'On Way', '2019-12-11 00:00:00'),
(46, 10, 7, 5, 'On Way Orders', '2019-12-11 09:20:53'),
(47, 10, 3, 1, 'On Way Orders', '2019-12-11 14:25:14'),
(48, 10, 6, 1, 'Pending', '2019-12-11 14:25:14'),
(49, 1, 9, 3, 'Pending', '2020-01-09 16:55:48'),
(50, 1, 3, 1, 'Pending', '2020-01-09 17:10:14'),
(51, 1, 5, 1, 'On Way Orders', '2020-01-09 17:10:14'),
(52, 1, 3, 1, 'On Way Orders', '2020-01-09 17:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firmname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpserver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpemail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtppasw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtpport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aboutus` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referances` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `keywords`, `firmname`, `address`, `fax`, `tel`, `email`, `facebook`, `twitter`, `instagram`, `linkedin`, `smtpserver`, `smtpemail`, `smtppasw`, `smtpport`, `aboutus`, `contact`, `referances`, `create_at`, `updated_at`) VALUES
(1, 'Test', 'description', 'Keywords', 'Company Name 1', 'address', '+90512345678', '+90512345678', NULL, NULL, NULL, NULL, NULL, NULL, 'testing@gmail.com', '123456', '587', '<!-- banner -->\r\n<div class=\"innerpage-banner\" id=\"home\">\r\n<div class=\"inner-page-layer\">&nbsp;</div>\r\n</div>\r\n<!-- //banner --><!-- about -->\r\n\r\n<div class=\"container py-md-3\">\r\n<h2>About Us</h2>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-lg-8\">\r\n<h4>Enjoy the greatest Pleasure in our hotel!</h4>\r\n\r\n<p>Suspendisse id felis sed felis tincidunt finibus. Nulla sed justo tellus. Donec ut felis ante. Quisque ac sapien quis orci pulvinar finibus quis eu urna. onec consequat sapien ut leo cursus rhoncus. Nullam dui mi, vulputate ac metus semper Nullam dui mi. Vestibulum ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur quis.</p>\r\n\r\n<div class=\"mt-4 row\">\r\n<div class=\"col-6 col-md-3\">\r\n<div class=\"about-box\">\r\n<h4>Healthy</h4>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-6 col-md-3\">\r\n<div class=\"about-box\">\r\n<h4>Spicy &amp; Hot</h4>\r\n</div>\r\n</div>\r\n<!-- .about-box ends here -->\r\n\r\n<div class=\"col-6 col-md-3 mt-4 mt-md-0\">\r\n<div class=\"about-box\">\r\n<h4>Crunchy</h4>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-6 col-md-3 mt-4 mt-md-0\">\r\n<div class=\"about-box\">\r\n<h4>Reciepe</h4>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-8 dental\"><img alt=\"\" class=\"img-fluid\" src=\"assets/front/images/banner1.jpg\" /></div>\r\n</div>\r\n</div>\r\n<!-- //about --><!-- about bottom -->\r\n\r\n<div class=\"container pb-lg-3\">\r\n<div class=\"bottom-grids row\">\r\n<div class=\"col-lg-6\"><img alt=\"\" class=\"img-fluid\" src=\"assets/front/images/bg.jpg\" /></div>\r\n\r\n<div class=\"col-lg-6 mt-5 mt-lg-0\">\r\n<h4>A tasty and healthy Crispy that we serve for you.</h4>\r\n\r\n<p>Suspendisse id felis sed felis tincidunt finibus. Nulla sed in justo inter tellus. Donec ut felis ante. Quisque acin sapien quis orci pulvinar finibus quis urna. onec consequat sapien ut leo cursus rhoncus. Nullam dui mi, vulputate ac quis eu urna Quisque quis eu urna lorem elit.</p>\r\n\r\n<p>Quisque ac sapien quis orci pulvinar finibus quis eu urna Quisque Suspendisse id felis sed felis tincidunt finibus. Nulla sed justo tellus. Donec ut felis ante ipsum.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- //about bottom --><!-- Chefs -->\r\n\r\n<div class=\"container py-md-3\">\r\n<h3>Our Chefs</h3>\r\n\r\n<div class=\"mt-5 row team_grids\">\r\n<div class=\"col-lg-3 col-sm-6\">\r\n<div class=\"team-member\">\r\n<div class=\"team-img\"><img alt=\"team member\" class=\"img-fluid\" src=\"assets/front/images/t1.jpg\" /></div>\r\n\r\n<div class=\"team-hover\">\r\n<div class=\"desk\">\r\n<h4>Cook Master</h4>\r\n\r\n<p>estibulum ac diam sit amet quam.</p>\r\n</div>\r\n\r\n<div class=\"s-link\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"team-title\">\r\n<h5>Charlotte Olivia</h5>\r\nCook Master</div>\r\n</div>\r\n\r\n<div class=\"col-lg-3 col-sm-6 mt-5 my-sm-0\">\r\n<div class=\"team-member\">\r\n<div class=\"team-img\"><img alt=\"team member\" class=\"img-fluid\" src=\"assets/front/images/t2.jpg\" /></div>\r\n\r\n<div class=\"team-hover\">\r\n<div class=\"desk\">\r\n<h4>Cook Master</h4>\r\n\r\n<p>estibulum ac diam sit amet quam.</p>\r\n</div>\r\n\r\n<div class=\"s-link\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"team-title\">\r\n<h5>Mathew Elijah</h5>\r\nCook Master</div>\r\n</div>\r\n\r\n<div class=\"col-lg-3 col-sm-6 mt-5 mx-auto my-lg-0\">\r\n<div class=\"team-member\">\r\n<div class=\"team-img\"><img alt=\"team member\" class=\"img-fluid\" src=\"assets/front/images/t3.jpg\" /></div>\r\n\r\n<div class=\"team-hover\">\r\n<div class=\"desk\">\r\n<h4>Cook Master</h4>\r\n\r\n<p>estibulum ac diam sit amet quam.</p>\r\n</div>\r\n\r\n<div class=\"s-link\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"team-title\">\r\n<h5>Alexander Lucas</h5>\r\nCook Master</div>\r\n</div>\r\n\r\n<div class=\"col-lg-3 col-sm-6 mt-5 mx-auto my-lg-0\">\r\n<div class=\"team-member\">\r\n<div class=\"team-img\"><img alt=\"team member\" class=\"img-fluid\" src=\"assets/front/images/t4.jpg\" /></div>\r\n\r\n<div class=\"team-hover\">\r\n<div class=\"desk\">\r\n<h4>Cook Master</h4>\r\n\r\n<p>estibulum ac diam sit amet quam.</p>\r\n</div>\r\n\r\n<div class=\"s-link\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"team-title\">\r\n<h5>Linda Anderson</h5>\r\nCook Master</div>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- //Chefs -->', '<div class=\"col-lg-12 col-md-12 contact-info mt-4 mt-lg-0\">\r\n<h4>Address Information</h4>\r\n\r\n<p>64d canal street TT 3356 Newyork, NY</p>\r\n\r\n<p>Phone : +1 123 456 789</p>\r\n\r\n<p>Email : <a href=\"mailto:info@example.com\">info@example.com</a></p>\r\n\r\n<h4>Book Your Table</h4>\r\n\r\n<p>Call us at +1 123 456 789</p>\r\n</div>\r\n</div>', '<!-- banner -->\r\n<div class=\"innerpage-banner\" id=\"home\">\r\n<div class=\"inner-page-layer\">&nbsp;</div>\r\n</div>\r\n<!-- //banner --><!-- Services -->\r\n\r\n<div class=\"container py-md-3\">\r\n<h2>Services</h2>\r\n\r\n<div class=\"row service-grids\">\r\n<div class=\"col-lg-6 mb-5 padder-none row\">\r\n<div class=\"col-sm-3 ser_icon\">&nbsp;</div>\r\n\r\n<div class=\"col-sm-9 mt-3 mt-sm-0\">\r\n<h4>Online Order</h4>\r\n\r\n<p>Quisque ac sapien quis orci pulvinar finibus quisn eu urna Quisque Suspendisse id felisut sed felise tincidunt finibus. Nulla sed justo tellus. Donec et felis ante ipsum urna Quisque sed felis dolor.</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-6 mb-sm-5 padder-none row\">\r\n<div class=\"col-sm-3 mb-4 mb-sm-0 ser-right ser_icon\">&nbsp;</div>\r\n\r\n<div class=\"col-sm-9\">\r\n<h4>Home Delivery</h4>\r\n\r\n<p>Quisque ac sapien quis orci pulvinar finibus quisn eu urna Quisque Suspendisse id felisut sed felise tincidunt finibus. Nulla sed justo tellus. Donec et felis ante ipsum urna Quisque sed felis dolor.</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-6 mb-5 mb-lg-0 mt-5 mt-sm-0 padder-none row\">\r\n<div class=\"col-sm-3 mb-4 mb-sm-0 ser_icon\">&nbsp;</div>\r\n\r\n<div class=\"col-sm-9\">\r\n<h4>Low Prices</h4>\r\n\r\n<p>Quisque ac sapien quis orci pulvinar finibus quisn eu urna Quisque Suspendisse id felisut sed felise tincidunt finibus. Nulla sed justo tellus. Donec et felis ante ipsum urna Quisque sed felis dolor.</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-6 padder-none row\">\r\n<div class=\"col-sm-3 mb-4 mb-sm-0 ser-right ser_icon\">&nbsp;</div>\r\n\r\n<div class=\"col-sm-9\">\r\n<h4>Always Fresh</h4>\r\n\r\n<p>Quisque ac sapien quis orci pulvinar finibus quisn eu urna Quisque Suspendisse id felisut sed felise tincidunt finibus. Nulla sed justo tellus. Donec et felis ante ipsum urna Quisque sed felis dolor.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- //Services --><!-- services -->\r\n\r\n<div class=\"container py-lg-5\">\r\n<h3>What we do</h3>\r\n\r\n<div class=\"offer-grids row\">\r\n<div class=\"col-lg-4 col-md-6\">\r\n<div class=\"ser1\">\r\n<div class=\"bg-layer\">\r\n<h4>Service1</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-6 mt-4 mt-md-0\">\r\n<div class=\"ser2\">\r\n<div class=\"bg-layer\">\r\n<h4>Service2</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-6 mt-4 mt-lg-0\">\r\n<div class=\"ser3\">\r\n<div class=\"bg-layer\">\r\n<h4>Service3</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-6 mt-4\">\r\n<div class=\"ser4\">\r\n<div class=\"bg-layer\">\r\n<h4>Service4</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-6 mt-4\">\r\n<div class=\"ser5\">\r\n<div class=\"bg-layer\">\r\n<h4>Service5</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-lg-4 col-md-6 mt-4\">\r\n<div class=\"ser6\">\r\n<div class=\"bg-layer\">\r\n<h4>Service6</h4>\r\n\r\n<p>Vestibulum ante ipsum primiss sed inorc faucibus orcit luctus ipsum et ultrices sede edt posuere cubiliater Curae nisl, Curabit ur quis luctu.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- //services --><!-- join -->\r\n\r\n<div class=\"container py-lg-5 py-sm-3\">\r\n<div class=\"join_grids row\">\r\n<div class=\"col-lg-6\"><img alt=\"\" class=\"img-fluid\" src=\"assets/front/images/bg.jpg\" /></div>\r\n\r\n<div class=\"col-lg-6\">\r\n<h4>Book Your Table Today</h4>\r\n\r\n<p>Suspendisse id felis sed felis tincidunt finibus. Nulla sed justo tellus. Donec ut felis ante. Quisque ac sapien quis orci pulvinar finibus quis eu urna. onec consequat sapien ut leo cursus rhoncus. Nullam dui mi, vulputate ac metus semper Nullam dui mi.</p>\r\n\r\n<p>Suspendisse id felis sed felis tincidunt finibus. Nulla sed justo tellus. Donec ut felis ante. Quisque ac sapien quis orci.</p>\r\n<a class=\"btn btn-banner text-capitalize\" href=\"#\">Call Now</a></div>\r\n</div>\r\n</div>\r\n<!-- //join -->', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_at` date DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image_id`, `title`, `content`, `status`, `create_at`, `food_id`) VALUES
(1, 35, 'First Sliders Title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pharetra eget leo vel dignissim. Proin tincidunt magna lacus, mollis suscipit ipsum mollis non. Nullam ac diam feugiat, cursus lectus vitae, ornare risus. Proin bibendum porta fringilla. Phasellus euismod justo ipsum, vel iaculis felis pellentesque eu. Mauris id rhoncus nibh, vel rutrum odio. Duis sit amet orci in leo cursus volutpat eu et erat. Aenean id ligula tellus. Mauris id lacus pretium, cursus sem non, vestibulum libero. Fusce dui lacus, sagittis ac elementum', 1, '2016-02-14', 5),
(2, 38, 'This is Title of slider 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pharetra eget leo vel dignissim. Proin tincidunt magna lacus, mollis suscipit ipsum mollis non. Nullam ac diam feugiat, cursus lectus vitae, ornare risus. Proin bibendum porta fringilla. Phasellus euismod justo ipsum, vel iaculis felis pellentesque eu. Mauris id rho', 1, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_img_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `roles`, `username`, `profile_img_id`, `status`, `created_at`, `updated_at`, `surname`) VALUES
(1, 'admin1@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Zle2TkgN6edM79uT7GbF3g$ALwgT6Yu8aWQoyXX5Hnd3xmc12PxDnIS5Bd6POX/cXU', 'ROLE_ADMIN', 'Admin - 1', 58, NULL, '2020-01-07 00:00:00', '2020-01-05 00:00:00', 'Kyaw'),
(8, 'test1@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Zle2TkgN6edM79uT7GbF3g$ALwgT6Yu8aWQoyXX5Hnd3xmc12PxDnIS5Bd6POX/cXU', 'ROLE_USER', 'User - 1', 58, NULL, '2020-01-06 00:00:00', '2020-01-05 00:00:00', 'User - 1'),
(10, 'test2@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Zle2TkgN6edM79uT7GbF3g$ALwgT6Yu8aWQoyXX5Hnd3xmc12PxDnIS5Bd6POX/cXU', 'ROLE_USER', 'User - 2', 58, NULL, '2020-01-06 00:00:00', '2020-01-05 00:00:00', NULL),
(11, 'test3@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Zle2TkgN6edM79uT7GbF3g$ALwgT6Yu8aWQoyXX5Hnd3xmc12PxDnIS5Bd6POX/cXU', 'ROLE_ADMIN', 'User - 2', NULL, NULL, NULL, NULL, NULL),
(12, 'admin2@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$jluMnvppbqgSzOrMaezaIw$me39AzkKT8iHJGgMkgW6UtHf8e7uTnJJzbeCuzfC8FM', 'ROLE_ADMIN', 'Admin - 2', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA388B755B127A4` (`added_by_id`),
  ADD KEY `IDX_BA388B74584665A` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64C19C13DA5256D` (`image_id`),
  ADD KEY `IDX_64C19C11F82D8F8` (`parentid_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C94F6F716` (`commented_by_id`),
  ADD KEY `IDX_9474526C4584665A` (`product_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D43829F73DA5256D` (`image_id`),
  ADD KEY `IDX_D43829F712469DE2` (`category_id`);

--
-- Indexes for table `food_image`
--
ALTER TABLE `food_image`
  ADD PRIMARY KEY (`food_id`,`image_id`),
  ADD KEY `IDX_345CC1B5BA8E87C4` (`food_id`),
  ADD KEY `IDX_345CC1B53DA5256D` (`image_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045FA2B28FE8` (`uploaded_by_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `odr`
--
ALTER TABLE `odr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_350EBBC91FF3C4D` (`ordered_by_id`),
  ADD KEY `IDX_350EBBC4584665A` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CFC710073DA5256D` (`image_id`),
  ADD KEY `IDX_CFC71007BA8E87C4` (`food_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D649A840F832` (`profile_img_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `odr`
--
ALTER TABLE `odr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B74584665A` FOREIGN KEY (`product_id`) REFERENCES `food` (`id`),
  ADD CONSTRAINT `FK_BA388B755B127A4` FOREIGN KEY (`added_by_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_64C19C11F82D8F8` FOREIGN KEY (`parentid_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_64C19C13DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4584665A` FOREIGN KEY (`product_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9474526C94F6F716` FOREIGN KEY (`commented_by_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `FK_D43829F712469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D43829F73DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `food_image`
--
ALTER TABLE `food_image`
  ADD CONSTRAINT `FK_345CC1B53DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_345CC1B5BA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FA2B28FE8` FOREIGN KEY (`uploaded_by_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `odr`
--
ALTER TABLE `odr`
  ADD CONSTRAINT `FK_350EBBC4584665A` FOREIGN KEY (`product_id`) REFERENCES `food` (`id`),
  ADD CONSTRAINT `FK_350EBBC91FF3C4D` FOREIGN KEY (`ordered_by_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `FK_CFC710073DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CFC71007BA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649A840F832` FOREIGN KEY (`profile_img_id`) REFERENCES `image` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
