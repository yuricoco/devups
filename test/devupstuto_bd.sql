-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2018 at 07:22 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devupstuto_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'book'),
(2, 'informatique'),
(3, 'electromenager');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_admin`
--

CREATE TABLE `dvups_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_admin`
--

INSERT INTO `dvups_admin` (`id`, `name`, `login`, `password`) VALUES
(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_entity`
--

CREATE TABLE `dvups_entity` (
  `id` int(11) NOT NULL,
  `dvups_module_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_entity`
--

INSERT INTO `dvups_entity` (`id`, `dvups_module_id`, `name`) VALUES
(1, 1, 'dvups_admin'),
(2, 1, 'dvups_role'),
(3, 1, 'dvups_entity'),
(4, 1, 'dvups_module'),
(5, 1, 'dvups_right'),
(6, 2, 'category'),
(7, 2, 'image'),
(8, 2, 'product'),
(9, 2, 'subcategory'),
(10, 3, 'storage');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_module`
--

CREATE TABLE `dvups_module` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_module`
--

INSERT INTO `dvups_module` (`id`, `name`, `project`) VALUES
(1, 'ModuleAdmin', 'devups'),
(2, 'ModuleProduct', 'devupstuto'),
(3, 'ModuleStock', 'devupstuto');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_right`
--

CREATE TABLE `dvups_right` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_right`
--

INSERT INTO `dvups_right` (`id`, `name`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_right_dvups_entity`
--

CREATE TABLE `dvups_right_dvups_entity` (
  `id` int(11) NOT NULL,
  `dvups_entity_id` int(11) DEFAULT NULL,
  `dvups_right_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dvups_right_dvups_role`
--

CREATE TABLE `dvups_right_dvups_role` (
  `id` int(11) NOT NULL,
  `dvups_role_id` int(11) DEFAULT NULL,
  `dvups_right_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_right_dvups_role`
--

INSERT INTO `dvups_right_dvups_role` (`id`, `dvups_role_id`, `dvups_right_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `dvups_role`
--

CREATE TABLE `dvups_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_role`
--

INSERT INTO `dvups_role` (`id`, `name`, `alias`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `dvups_role_dvups_admin`
--

CREATE TABLE `dvups_role_dvups_admin` (
  `id` int(11) NOT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_role_dvups_admin`
--

INSERT INTO `dvups_role_dvups_admin` (`id`, `dvups_admin_id`, `dvups_role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dvups_role_dvups_entity`
--

CREATE TABLE `dvups_role_dvups_entity` (
  `id` int(11) NOT NULL,
  `dvups_entity_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_role_dvups_entity`
--

INSERT INTO `dvups_role_dvups_entity` (`id`, `dvups_entity_id`, `dvups_role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dvups_role_dvups_module`
--

CREATE TABLE `dvups_role_dvups_module` (
  `id` int(11) NOT NULL,
  `dvups_module_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dvups_role_dvups_module`
--

INSERT INTO `dvups_role_dvups_module` (`id`, `dvups_module_id`, `dvups_role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `image`) VALUES
(1, 'c2399ac555f606ea827c45bcbbbc13f2d4828e22.jpg'),
(2, '8c17e7e62e1be87c2314c97dc3a9708ed17fddb4.jpg'),
(3, '8268f1569d14a10a6ea24b544a3683b2248d2a84.jpg'),
(4, '5f23a95dba6293f94716142666888d01eced75bd.jpg'),
(5, '857b5ff686a29680764cd5aa39e1291b6b62b242.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `image_id`, `category_id`, `subcategory_id`, `name`, `description`) VALUES
(1, 2, 1, 1, 'tew', 'the element warriors'),
(2, 3, 1, 1, 'gjkgjh', 'gfgj'),
(3, 5, 1, 1, 'qsdfgds', 'sdfgsd');

-- --------------------------------------------------------

--
-- Table structure for table `product_storage`
--

CREATE TABLE `product_storage` (
  `id` int(11) NOT NULL,
  `storage_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_storage`
--

INSERT INTO `product_storage` (`id`, `storage_id`, `product_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(5, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `town` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `town`) VALUES
(1, 'douala'),
(2, 'yaounde'),
(3, 'bamenda'),
(4, 'edea');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(22) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `category_id`, `name`) VALUES
(1, 1, 'mangas'),
(2, 2, 'laptop'),
(3, 2, 'desktop'),
(4, 3, 'refrigerateur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvups_admin`
--
ALTER TABLE `dvups_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvups_entity`
--
ALTER TABLE `dvups_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EE7D6E47E8B9DDFF` (`dvups_module_id`);

--
-- Indexes for table `dvups_module`
--
ALTER TABLE `dvups_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvups_right`
--
ALTER TABLE `dvups_right`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvups_right_dvups_entity`
--
ALTER TABLE `dvups_right_dvups_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D3F736CCC65E1533` (`dvups_entity_id`),
  ADD KEY `IDX_D3F736CC9D3079DB` (`dvups_right_id`);

--
-- Indexes for table `dvups_right_dvups_role`
--
ALTER TABLE `dvups_right_dvups_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5481184C7D324ADF` (`dvups_role_id`),
  ADD KEY `IDX_5481184C9D3079DB` (`dvups_right_id`);

--
-- Indexes for table `dvups_role`
--
ALTER TABLE `dvups_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvups_role_dvups_admin`
--
ALTER TABLE `dvups_role_dvups_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D756F20AD8C93FE` (`dvups_admin_id`),
  ADD KEY `IDX_8D756F207D324ADF` (`dvups_role_id`);

--
-- Indexes for table `dvups_role_dvups_entity`
--
ALTER TABLE `dvups_role_dvups_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C25CBCBC65E1533` (`dvups_entity_id`),
  ADD KEY `IDX_8C25CBCB7D324ADF` (`dvups_role_id`);

--
-- Indexes for table `dvups_role_dvups_module`
--
ALTER TABLE `dvups_role_dvups_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8E29A98BE8B9DDFF` (`dvups_module_id`),
  ADD KEY `IDX_8E29A98B7D324ADF` (`dvups_role_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D34A04AD3DA5256D` (`image_id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04AD5DC6FE57` (`subcategory_id`);

--
-- Indexes for table `product_storage`
--
ALTER TABLE `product_storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_85A300845CC5DB90` (`storage_id`),
  ADD KEY `IDX_85A300844584665A` (`product_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DDCA44812469DE2` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `dvups_admin`
--
ALTER TABLE `dvups_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dvups_entity`
--
ALTER TABLE `dvups_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dvups_module`
--
ALTER TABLE `dvups_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `dvups_right`
--
ALTER TABLE `dvups_right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dvups_right_dvups_entity`
--
ALTER TABLE `dvups_right_dvups_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dvups_right_dvups_role`
--
ALTER TABLE `dvups_right_dvups_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dvups_role`
--
ALTER TABLE `dvups_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dvups_role_dvups_admin`
--
ALTER TABLE `dvups_role_dvups_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dvups_role_dvups_entity`
--
ALTER TABLE `dvups_role_dvups_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dvups_role_dvups_module`
--
ALTER TABLE `dvups_role_dvups_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product_storage`
--
ALTER TABLE `product_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dvups_entity`
--
ALTER TABLE `dvups_entity`
  ADD CONSTRAINT `FK_EE7D6E47E8B9DDFF` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`);

--
-- Constraints for table `dvups_right_dvups_entity`
--
ALTER TABLE `dvups_right_dvups_entity`
  ADD CONSTRAINT `FK_D3F736CC9D3079DB` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`),
  ADD CONSTRAINT `FK_D3F736CCC65E1533` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`);

--
-- Constraints for table `dvups_right_dvups_role`
--
ALTER TABLE `dvups_right_dvups_role`
  ADD CONSTRAINT `FK_5481184C7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  ADD CONSTRAINT `FK_5481184C9D3079DB` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`);

--
-- Constraints for table `dvups_role_dvups_admin`
--
ALTER TABLE `dvups_role_dvups_admin`
  ADD CONSTRAINT `FK_8D756F207D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  ADD CONSTRAINT `FK_8D756F20AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`);

--
-- Constraints for table `dvups_role_dvups_entity`
--
ALTER TABLE `dvups_role_dvups_entity`
  ADD CONSTRAINT `FK_8C25CBCB7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  ADD CONSTRAINT `FK_8C25CBCBC65E1533` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`);

--
-- Constraints for table `dvups_role_dvups_module`
--
ALTER TABLE `dvups_role_dvups_module`
  ADD CONSTRAINT `FK_8E29A98B7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  ADD CONSTRAINT `FK_8E29A98BE8B9DDFF` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `FK_D34A04AD5DC6FE57` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `product_storage`
--
ALTER TABLE `product_storage`
  ADD CONSTRAINT `FK_85A300844584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_85A300845CC5DB90` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `FK_DDCA44812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
