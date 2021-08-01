-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 11 avr. 2021 à 12:27
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP :  7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `aggregator_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

--
-- Déchargement des données de la table `country`
--

INSERT INTO `country` (`id`, `name`, `iso`, `iso3`, `nicename`, `numcode`, `phonecode`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AFGHANISTAN', 'AF', 'AFG', 'Afghanistan', '4', 93, 0, NULL, NULL, NULL),
(2, 'ALBANIA', 'AL', 'ALB', 'Albania', '8', 355, 0, NULL, NULL, NULL),
(3, 'ALGERIA', 'DZ', 'DZA', 'Algeria', '12', 213, 0, NULL, NULL, NULL),
(4, 'AMERICAN SAMOA', 'AS', 'ASM', 'American Samoa', '16', 1684, 0, NULL, NULL, NULL),
(5, 'ANDORRA', 'AD', 'AND', 'Andorra', '20', 376, 0, NULL, NULL, NULL),
(6, 'ANGOLA', 'AO', 'AGO', 'Angola', '24', 244, 0, NULL, NULL, NULL),
(7, 'ANGUILLA', 'AI', 'AIA', 'Anguilla', '660', 1264, 0, NULL, NULL, NULL),
(8, 'ANTARCTICA', 'AQ', '', 'Antarctica', '', 0, 0, NULL, NULL, NULL),
(9, 'ANTIGUA AND BARBUDA', 'AG', 'ATG', 'Antigua and Barbuda', '28', 1268, 0, NULL, NULL, NULL),
(10, 'ARGENTINA', 'AR', 'ARG', 'Argentina', '32', 54, 0, NULL, NULL, NULL),
(11, 'ARMENIA', 'AM', 'ARM', 'Armenia', '51', 374, 0, NULL, NULL, NULL),
(12, 'ARUBA', 'AW', 'ABW', 'Aruba', '533', 297, 0, NULL, NULL, NULL),
(13, 'AUSTRALIA', 'AU', 'AUS', 'Australia', '36', 61, 0, NULL, NULL, NULL),
(14, 'AUSTRIA', 'AT', 'AUT', 'Austria', '40', 43, 0, NULL, NULL, NULL),
(15, 'AZERBAIJAN', 'AZ', 'AZE', 'Azerbaijan', '31', 994, 0, NULL, NULL, NULL),
(16, 'BAHAMAS', 'BS', 'BHS', 'Bahamas', '44', 1242, 0, NULL, NULL, NULL),
(17, 'BAHRAIN', 'BH', 'BHR', 'Bahrain', '48', 973, 0, NULL, NULL, NULL),
(18, 'BANGLADESH', 'BD', 'BGD', 'Bangladesh', '50', 880, 0, NULL, NULL, NULL),
(19, 'BARBADOS', 'BB', 'BRB', 'Barbados', '52', 1246, 0, NULL, NULL, NULL),
(20, 'BELARUS', 'BY', 'BLR', 'Belarus', '112', 375, 0, NULL, NULL, NULL),
(21, 'BELGIUM', 'BE', 'BEL', 'Belgium', '56', 32, 0, NULL, NULL, NULL),
(22, 'BELIZE', 'BZ', 'BLZ', 'Belize', '84', 501, 0, NULL, NULL, NULL),
(23, 'BENIN', 'BJ', 'BEN', 'Benin', '204', 229, 0, NULL, NULL, NULL),
(24, 'BERMUDA', 'BM', 'BMU', 'Bermuda', '60', 1441, 0, NULL, NULL, NULL),
(25, 'BHUTAN', 'BT', 'BTN', 'Bhutan', '64', 975, 0, NULL, NULL, NULL),
(26, 'BOLIVIA', 'BO', 'BOL', 'Bolivia', '68', 591, 0, NULL, NULL, NULL),
(27, 'BOSNIA AND HERZEGOVINA', 'BA', 'BIH', 'Bosnia and Herzegovina', '70', 387, 0, NULL, NULL, NULL),
(28, 'BOTSWANA', 'BW', 'BWA', 'Botswana', '72', 267, 0, NULL, NULL, NULL),
(29, 'BOUVET ISLAND', 'BV', '', 'Bouvet Island', '', 0, 0, NULL, NULL, NULL),
(30, 'BRAZIL', 'BR', 'BRA', 'Brazil', '76', 55, 0, NULL, NULL, NULL),
(31, 'BRITISH INDIAN OCEAN TERRITORY', 'IO', '', 'British Indian Ocean Territory', '', 246, 0, NULL, NULL, NULL),
(32, 'BRUNEI DARUSSALAM', 'BN', 'BRN', 'Brunei Darussalam', '96', 673, 0, NULL, NULL, NULL),
(33, 'BULGARIA', 'BG', 'BGR', 'Bulgaria', '100', 359, 0, NULL, NULL, NULL),
(34, 'BURKINA FASO', 'BF', 'BFA', 'Burkina Faso', '854', 226, 0, NULL, NULL, NULL),
(35, 'BURUNDI', 'BI', 'BDI', 'Burundi', '108', 257, 0, NULL, NULL, NULL),
(36, 'CAMBODIA', 'KH', 'KHM', 'Cambodia', '116', 855, 0, NULL, NULL, NULL),
(37, 'CAMEROON', 'CM', 'CMR', 'Cameroon', '120', 237, 0, NULL, NULL, NULL),
(38, 'CANADA', 'CA', 'CAN', 'Canada', '124', 1, 0, NULL, NULL, NULL),
(39, 'CAPE VERDE', 'CV', 'CPV', 'Cape Verde', '132', 238, 0, NULL, NULL, NULL),
(40, 'CAYMAN ISLANDS', 'KY', 'CYM', 'Cayman Islands', '136', 1345, 0, NULL, NULL, NULL),
(41, 'CENTRAL AFRICAN REPUBLIC', 'CF', 'CAF', 'Central African Republic', '140', 236, 0, NULL, NULL, NULL),
(42, 'CHAD', 'TD', 'TCD', 'Chad', '148', 235, 0, NULL, NULL, NULL),
(43, 'CHILE', 'CL', 'CHL', 'Chile', '152', 56, 0, NULL, NULL, NULL),
(44, 'CHINA', 'CN', 'CHN', 'China', '156', 86, 0, NULL, NULL, NULL),
(45, 'CHRISTMAS ISLAND', 'CX', '', 'Christmas Island', '', 61, 0, NULL, NULL, NULL),
(46, 'COCOS (KEELING) ISLANDS', 'CC', '', 'Cocos (Keeling) Islands', '', 672, 0, NULL, NULL, NULL),
(47, 'COLOMBIA', 'CO', 'COL', 'Colombia', '170', 57, 0, NULL, NULL, NULL),
(48, 'COMOROS', 'KM', 'COM', 'Comoros', '174', 269, 0, NULL, NULL, NULL),
(49, 'CONGO', 'CG', 'COG', 'Congo', '178', 242, 0, NULL, NULL, NULL),
(50, 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CD', 'COD', 'Congo, the Democratic Republic of the', '180', 242, 0, NULL, NULL, NULL),
(51, 'COOK ISLANDS', 'CK', 'COK', 'Cook Islands', '184', 682, 0, NULL, NULL, NULL),
(52, 'COSTA RICA', 'CR', 'CRI', 'Costa Rica', '188', 506, 0, NULL, NULL, NULL),
(53, 'COTE D\'IVOIRE', 'CI', 'CIV', 'Cote D\'Ivoire', '384', 225, 0, NULL, NULL, NULL),
(54, 'CROATIA', 'HR', 'HRV', 'Croatia', '191', 385, 0, NULL, NULL, NULL),
(55, 'CUBA', 'CU', 'CUB', 'Cuba', '192', 53, 0, NULL, NULL, NULL),
(56, 'CYPRUS', 'CY', 'CYP', 'Cyprus', '196', 357, 0, NULL, NULL, NULL),
(57, 'CZECH REPUBLIC', 'CZ', 'CZE', 'Czech Republic', '203', 420, 0, NULL, NULL, NULL),
(58, 'DENMARK', 'DK', 'DNK', 'Denmark', '208', 45, 0, NULL, NULL, NULL),
(59, 'DJIBOUTI', 'DJ', 'DJI', 'Djibouti', '262', 253, 0, NULL, NULL, NULL),
(60, 'DOMINICA', 'DM', 'DMA', 'Dominica', '212', 1767, 0, NULL, NULL, NULL),
(61, 'DOMINICAN REPUBLIC', 'DO', 'DOM', 'Dominican Republic', '214', 1809, 0, NULL, NULL, NULL),
(62, 'ECUADOR', 'EC', 'ECU', 'Ecuador', '218', 593, 0, NULL, NULL, NULL),
(63, 'EGYPT', 'EG', 'EGY', 'Egypt', '818', 20, 0, NULL, NULL, NULL),
(64, 'EL SALVADOR', 'SV', 'SLV', 'El Salvador', '222', 503, 0, NULL, NULL, NULL),
(65, 'EQUATORIAL GUINEA', 'GQ', 'GNQ', 'Equatorial Guinea', '226', 240, 0, NULL, NULL, NULL),
(66, 'ERITREA', 'ER', 'ERI', 'Eritrea', '232', 291, 0, NULL, NULL, NULL),
(67, 'ESTONIA', 'EE', 'EST', 'Estonia', '233', 372, 0, NULL, NULL, NULL),
(68, 'ETHIOPIA', 'ET', 'ETH', 'Ethiopia', '231', 251, 0, NULL, NULL, NULL),
(69, 'FALKLAND ISLANDS (MALVINAS)', 'FK', 'FLK', 'Falkland Islands (Malvinas)', '238', 500, 0, NULL, NULL, NULL),
(70, 'FAROE ISLANDS', 'FO', 'FRO', 'Faroe Islands', '234', 298, 0, NULL, NULL, NULL),
(71, 'FIJI', 'FJ', 'FJI', 'Fiji', '242', 679, 0, NULL, NULL, NULL),
(72, 'FINLAND', 'FI', 'FIN', 'Finland', '246', 358, 0, NULL, NULL, NULL),
(73, 'FRANCE', 'FR', 'FRA', 'France', '250', 33, 0, NULL, NULL, NULL),
(74, 'FRENCH GUIANA', 'GF', 'GUF', 'French Guiana', '254', 594, 0, NULL, NULL, NULL),
(75, 'FRENCH POLYNESIA', 'PF', 'PYF', 'French Polynesia', '258', 689, 0, NULL, NULL, NULL),
(76, 'FRENCH SOUTHERN TERRITORIES', 'TF', '', 'French Southern Territories', '', 0, 0, NULL, NULL, NULL),
(77, 'GABON', 'GA', 'GAB', 'Gabon', '266', 241, 0, NULL, NULL, NULL),
(78, 'GAMBIA', 'GM', 'GMB', 'Gambia', '270', 220, 0, NULL, NULL, NULL),
(79, 'GEORGIA', 'GE', 'GEO', 'Georgia', '268', 995, 0, NULL, NULL, NULL),
(80, 'GERMANY', 'DE', 'DEU', 'Germany', '276', 49, 0, NULL, NULL, NULL),
(81, 'GHANA', 'GH', 'GHA', 'Ghana', '288', 233, 0, NULL, NULL, NULL),
(82, 'GIBRALTAR', 'GI', 'GIB', 'Gibraltar', '292', 350, 0, NULL, NULL, NULL),
(83, 'GREECE', 'GR', 'GRC', 'Greece', '300', 30, 0, NULL, NULL, NULL),
(84, 'GREENLAND', 'GL', 'GRL', 'Greenland', '304', 299, 0, NULL, NULL, NULL),
(85, 'GRENADA', 'GD', 'GRD', 'Grenada', '308', 1473, 0, NULL, NULL, NULL),
(86, 'GUADELOUPE', 'GP', 'GLP', 'Guadeloupe', '312', 590, 0, NULL, NULL, NULL),
(87, 'GUAM', 'GU', 'GUM', 'Guam', '316', 1671, 0, NULL, NULL, NULL),
(88, 'GUATEMALA', 'GT', 'GTM', 'Guatemala', '320', 502, 0, NULL, NULL, NULL),
(89, 'GUINEA', 'GN', 'GIN', 'Guinea', '324', 224, 0, NULL, NULL, NULL),
(90, 'GUINEA-BISSAU', 'GW', 'GNB', 'Guinea-Bissau', '624', 245, 0, NULL, NULL, NULL),
(91, 'GUYANA', 'GY', 'GUY', 'Guyana', '328', 592, 0, NULL, NULL, NULL),
(92, 'HAITI', 'HT', 'HTI', 'Haiti', '332', 509, 0, NULL, NULL, NULL),
(93, 'HEARD ISLAND AND MCDONALD ISLANDS', 'HM', '', 'Heard Island and Mcdonald Islands', '', 0, 0, NULL, NULL, NULL),
(94, 'HOLY SEE (VATICAN CITY STATE)', 'VA', 'VAT', 'Holy See (Vatican City State)', '336', 39, 0, NULL, NULL, NULL),
(95, 'HONDURAS', 'HN', 'HND', 'Honduras', '340', 504, 0, NULL, NULL, NULL),
(96, 'HONG KONG', 'HK', 'HKG', 'Hong Kong', '344', 852, 0, NULL, NULL, NULL),
(97, 'HUNGARY', 'HU', 'HUN', 'Hungary', '348', 36, 0, NULL, NULL, NULL),
(98, 'ICELAND', 'IS', 'ISL', 'Iceland', '352', 354, 0, NULL, NULL, NULL),
(99, 'INDIA', 'IN', 'IND', 'India', '356', 91, 0, NULL, NULL, NULL),
(100, 'INDONESIA', 'ID', 'IDN', 'Indonesia', '360', 62, 0, NULL, NULL, NULL),
(101, 'IRAN, ISLAMIC REPUBLIC OF', 'IR', 'IRN', 'Iran, Islamic Republic of', '364', 98, 0, NULL, NULL, NULL),
(102, 'IRAQ', 'IQ', 'IRQ', 'Iraq', '368', 964, 0, NULL, NULL, NULL),
(103, 'IRELAND', 'IE', 'IRL', 'Ireland', '372', 353, 0, NULL, NULL, NULL),
(104, 'ISRAEL', 'IL', 'ISR', 'Israel', '376', 972, 0, NULL, NULL, NULL),
(105, 'ITALY', 'IT', 'ITA', 'Italy', '380', 39, 0, NULL, NULL, NULL),
(106, 'JAMAICA', 'JM', 'JAM', 'Jamaica', '388', 1876, 0, NULL, NULL, NULL),
(107, 'JAPAN', 'JP', 'JPN', 'Japan', '392', 81, 0, NULL, NULL, NULL),
(108, 'JORDAN', 'JO', 'JOR', 'Jordan', '400', 962, 0, NULL, NULL, NULL),
(109, 'KAZAKHSTAN', 'KZ', 'KAZ', 'Kazakhstan', '398', 7, 0, NULL, NULL, NULL),
(110, 'KENYA', 'KE', 'KEN', 'Kenya', '404', 254, 0, NULL, NULL, NULL),
(111, 'KIRIBATI', 'KI', 'KIR', 'Kiribati', '296', 686, 0, NULL, NULL, NULL),
(112, 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'KP', 'PRK', 'Korea, Democratic People\'s Republic of', '408', 850, 0, NULL, NULL, NULL),
(113, 'KOREA, REPUBLIC OF', 'KR', 'KOR', 'Korea, Republic of', '410', 82, 0, NULL, NULL, NULL),
(114, 'KUWAIT', 'KW', 'KWT', 'Kuwait', '414', 965, 0, NULL, NULL, NULL),
(115, 'KYRGYZSTAN', 'KG', 'KGZ', 'Kyrgyzstan', '417', 996, 0, NULL, NULL, NULL),
(116, 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'LA', 'LAO', 'Lao People\'s Democratic Republic', '418', 856, 0, NULL, NULL, NULL),
(117, 'LATVIA', 'LV', 'LVA', 'Latvia', '428', 371, 0, NULL, NULL, NULL),
(118, 'LEBANON', 'LB', 'LBN', 'Lebanon', '422', 961, 0, NULL, NULL, NULL),
(119, 'LESOTHO', 'LS', 'LSO', 'Lesotho', '426', 266, 0, NULL, NULL, NULL),
(120, 'LIBERIA', 'LR', 'LBR', 'Liberia', '430', 231, 0, NULL, NULL, NULL),
(121, 'LIBYAN ARAB JAMAHIRIYA', 'LY', 'LBY', 'Libyan Arab Jamahiriya', '434', 218, 0, NULL, NULL, NULL),
(122, 'LIECHTENSTEIN', 'LI', 'LIE', 'Liechtenstein', '438', 423, 0, NULL, NULL, NULL),
(123, 'LITHUANIA', 'LT', 'LTU', 'Lithuania', '440', 370, 0, NULL, NULL, NULL),
(124, 'LUXEMBOURG', 'LU', 'LUX', 'Luxembourg', '442', 352, 0, NULL, NULL, NULL),
(125, 'MACAO', 'MO', 'MAC', 'Macao', '446', 853, 0, NULL, NULL, NULL),
(126, 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MK', 'MKD', 'Macedonia, the Former Yugoslav Republic of', '807', 389, 0, NULL, NULL, NULL),
(127, 'MADAGASCAR', 'MG', 'MDG', 'Madagascar', '450', 261, 0, NULL, NULL, NULL),
(128, 'MALAWI', 'MW', 'MWI', 'Malawi', '454', 265, 0, NULL, NULL, NULL),
(129, 'MALAYSIA', 'MY', 'MYS', 'Malaysia', '458', 60, 0, NULL, NULL, NULL),
(130, 'MALDIVES', 'MV', 'MDV', 'Maldives', '462', 960, 0, NULL, NULL, NULL),
(131, 'MALI', 'ML', 'MLI', 'Mali', '466', 223, 0, NULL, NULL, NULL),
(132, 'MALTA', 'MT', 'MLT', 'Malta', '470', 356, 0, NULL, NULL, NULL),
(133, 'MARSHALL ISLANDS', 'MH', 'MHL', 'Marshall Islands', '584', 692, 0, NULL, NULL, NULL),
(134, 'MARTINIQUE', 'MQ', 'MTQ', 'Martinique', '474', 596, 0, NULL, NULL, NULL),
(135, 'MAURITANIA', 'MR', 'MRT', 'Mauritania', '478', 222, 0, NULL, NULL, NULL),
(136, 'MAURITIUS', 'MU', 'MUS', 'Mauritius', '480', 230, 0, NULL, NULL, NULL),
(137, 'MAYOTTE', 'YT', '', 'Mayotte', '', 269, 0, NULL, NULL, NULL),
(138, 'MEXICO', 'MX', 'MEX', 'Mexico', '484', 52, 0, NULL, NULL, NULL),
(139, 'MICRONESIA, FEDERATED STATES OF', 'FM', 'FSM', 'Micronesia, Federated States of', '583', 691, 0, NULL, NULL, NULL),
(140, 'MOLDOVA, REPUBLIC OF', 'MD', 'MDA', 'Moldova, Republic of', '498', 373, 0, NULL, NULL, NULL),
(141, 'MONACO', 'MC', 'MCO', 'Monaco', '492', 377, 0, NULL, NULL, NULL),
(142, 'MONGOLIA', 'MN', 'MNG', 'Mongolia', '496', 976, 0, NULL, NULL, NULL),
(143, 'MONTSERRAT', 'MS', 'MSR', 'Montserrat', '500', 1664, 0, NULL, NULL, NULL),
(144, 'MOROCCO', 'MA', 'MAR', 'Morocco', '504', 212, 0, NULL, NULL, NULL),
(145, 'MOZAMBIQUE', 'MZ', 'MOZ', 'Mozambique', '508', 258, 0, NULL, NULL, NULL),
(146, 'MYANMAR', 'MM', 'MMR', 'Myanmar', '104', 95, 0, NULL, NULL, NULL),
(147, 'NAMIBIA', 'NA', 'NAM', 'Namibia', '516', 264, 0, NULL, NULL, NULL),
(148, 'NAURU', 'NR', 'NRU', 'Nauru', '520', 674, 0, NULL, NULL, NULL),
(149, 'NEPAL', 'NP', 'NPL', 'Nepal', '524', 977, 0, NULL, NULL, NULL),
(150, 'NETHERLANDS', 'NL', 'NLD', 'Netherlands', '528', 31, 0, NULL, NULL, NULL),
(151, 'NETHERLANDS ANTILLES', 'AN', 'ANT', 'Netherlands Antilles', '530', 599, 0, NULL, NULL, NULL),
(152, 'NEW CALEDONIA', 'NC', 'NCL', 'New Caledonia', '540', 687, 0, NULL, NULL, NULL),
(153, 'NEW ZEALAND', 'NZ', 'NZL', 'New Zealand', '554', 64, 0, NULL, NULL, NULL),
(154, 'NICARAGUA', 'NI', 'NIC', 'Nicaragua', '558', 505, 0, NULL, NULL, NULL),
(155, 'NIGER', 'NE', 'NER', 'Niger', '562', 227, 0, NULL, NULL, NULL),
(156, 'NIGERIA', 'NG', 'NGA', 'Nigeria', '566', 234, 0, NULL, NULL, NULL),
(157, 'NIUE', 'NU', 'NIU', 'Niue', '570', 683, 0, NULL, NULL, NULL),
(158, 'NORFOLK ISLAND', 'NF', 'NFK', 'Norfolk Island', '574', 672, 0, NULL, NULL, NULL),
(159, 'NORTHERN MARIANA ISLANDS', 'MP', 'MNP', 'Northern Mariana Islands', '580', 1670, 0, NULL, NULL, NULL),
(160, 'NORWAY', 'NO', 'NOR', 'Norway', '578', 47, 0, NULL, NULL, NULL),
(161, 'OMAN', 'OM', 'OMN', 'Oman', '512', 968, 0, NULL, NULL, NULL),
(162, 'PAKISTAN', 'PK', 'PAK', 'Pakistan', '586', 92, 0, NULL, NULL, NULL),
(163, 'PALAU', 'PW', 'PLW', 'Palau', '585', 680, 0, NULL, NULL, NULL),
(164, 'PALESTINIAN TERRITORY, OCCUPIED', 'PS', '', 'Palestinian Territory, Occupied', '', 970, 0, NULL, NULL, NULL),
(165, 'PANAMA', 'PA', 'PAN', 'Panama', '591', 507, 0, NULL, NULL, NULL),
(166, 'PAPUA NEW GUINEA', 'PG', 'PNG', 'Papua New Guinea', '598', 675, 0, NULL, NULL, NULL),
(167, 'PARAGUAY', 'PY', 'PRY', 'Paraguay', '600', 595, 0, NULL, NULL, NULL),
(168, 'PERU', 'PE', 'PER', 'Peru', '604', 51, 0, NULL, NULL, NULL),
(169, 'PHILIPPINES', 'PH', 'PHL', 'Philippines', '608', 63, 0, NULL, NULL, NULL),
(170, 'PITCAIRN', 'PN', 'PCN', 'Pitcairn', '612', 0, 0, NULL, NULL, NULL),
(171, 'POLAND', 'PL', 'POL', 'Poland', '616', 48, 0, NULL, NULL, NULL),
(172, 'PORTUGAL', 'PT', 'PRT', 'Portugal', '620', 351, 0, NULL, NULL, NULL),
(173, 'PUERTO RICO', 'PR', 'PRI', 'Puerto Rico', '630', 1787, 0, NULL, NULL, NULL),
(174, 'QATAR', 'QA', 'QAT', 'Qatar', '634', 974, 0, NULL, NULL, NULL),
(175, 'REUNION', 'RE', 'REU', 'Reunion', '638', 262, 0, NULL, NULL, NULL),
(176, 'ROMANIA', 'RO', 'ROM', 'Romania', '642', 40, 0, NULL, NULL, NULL),
(177, 'RUSSIAN FEDERATION', 'RU', 'RUS', 'Russian Federation', '643', 70, 0, NULL, NULL, NULL),
(178, 'RWANDA', 'RW', 'RWA', 'Rwanda', '646', 250, 0, NULL, NULL, NULL),
(179, 'SAINT HELENA', 'SH', 'SHN', 'Saint Helena', '654', 290, 0, NULL, NULL, NULL),
(180, 'SAINT KITTS AND NEVIS', 'KN', 'KNA', 'Saint Kitts and Nevis', '659', 1869, 0, NULL, NULL, NULL),
(181, 'SAINT LUCIA', 'LC', 'LCA', 'Saint Lucia', '662', 1758, 0, NULL, NULL, NULL),
(182, 'SAINT PIERRE AND MIQUELON', 'PM', 'SPM', 'Saint Pierre and Miquelon', '666', 508, 0, NULL, NULL, NULL),
(183, 'SAINT VINCENT AND THE GRENADINES', 'VC', 'VCT', 'Saint Vincent and the Grenadines', '670', 1784, 0, NULL, NULL, NULL),
(184, 'SAMOA', 'WS', 'WSM', 'Samoa', '882', 684, 0, NULL, NULL, NULL),
(185, 'SAN MARINO', 'SM', 'SMR', 'San Marino', '674', 378, 0, NULL, NULL, NULL),
(186, 'SAO TOME AND PRINCIPE', 'ST', 'STP', 'Sao Tome and Principe', '678', 239, 0, NULL, NULL, NULL),
(187, 'SAUDI ARABIA', 'SA', 'SAU', 'Saudi Arabia', '682', 966, 0, NULL, NULL, NULL),
(188, 'SENEGAL', 'SN', 'SEN', 'Senegal', '686', 221, 0, NULL, NULL, NULL),
(189, 'SERBIA AND MONTENEGRO', 'CS', '', 'Serbia and Montenegro', '', 381, 0, NULL, NULL, NULL),
(190, 'SEYCHELLES', 'SC', 'SYC', 'Seychelles', '690', 248, 0, NULL, NULL, NULL),
(191, 'SIERRA LEONE', 'SL', 'SLE', 'Sierra Leone', '694', 232, 0, NULL, NULL, NULL),
(192, 'SINGAPORE', 'SG', 'SGP', 'Singapore', '702', 65, 0, NULL, NULL, NULL),
(193, 'SLOVAKIA', 'SK', 'SVK', 'Slovakia', '703', 421, 0, NULL, NULL, NULL),
(194, 'SLOVENIA', 'SI', 'SVN', 'Slovenia', '705', 386, 0, NULL, NULL, NULL),
(195, 'SOLOMON ISLANDS', 'SB', 'SLB', 'Solomon Islands', '90', 677, 0, NULL, NULL, NULL),
(196, 'SOMALIA', 'SO', 'SOM', 'Somalia', '706', 252, 0, NULL, NULL, NULL),
(197, 'SOUTH AFRICA', 'ZA', 'ZAF', 'South Africa', '710', 27, 0, NULL, NULL, NULL),
(198, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'GS', '', 'South Georgia and the South Sandwich Islands', '', 0, 0, NULL, NULL, NULL),
(199, 'SPAIN', 'ES', 'ESP', 'Spain', '724', 34, 0, NULL, NULL, NULL),
(200, 'SRI LANKA', 'LK', 'LKA', 'Sri Lanka', '144', 94, 0, NULL, NULL, NULL),
(201, 'SUDAN', 'SD', 'SDN', 'Sudan', '736', 249, 0, NULL, NULL, NULL),
(202, 'SURINAME', 'SR', 'SUR', 'Suriname', '740', 597, 0, NULL, NULL, NULL),
(203, 'SVALBARD AND JAN MAYEN', 'SJ', 'SJM', 'Svalbard and Jan Mayen', '744', 47, 0, NULL, NULL, NULL),
(204, 'SWAZILAND', 'SZ', 'SWZ', 'Swaziland', '748', 268, 0, NULL, NULL, NULL),
(205, 'SWEDEN', 'SE', 'SWE', 'Sweden', '752', 46, 0, NULL, NULL, NULL),
(206, 'SWITZERLAND', 'CH', 'CHE', 'Switzerland', '756', 41, 0, NULL, NULL, NULL),
(207, 'SYRIAN ARAB REPUBLIC', 'SY', 'SYR', 'Syrian Arab Republic', '760', 963, 0, NULL, NULL, NULL),
(208, 'TAIWAN, PROVINCE OF CHINA', 'TW', 'TWN', 'Taiwan, Province of China', '158', 886, 0, NULL, NULL, NULL),
(209, 'TAJIKISTAN', 'TJ', 'TJK', 'Tajikistan', '762', 992, 0, NULL, NULL, NULL),
(210, 'TANZANIA, UNITED REPUBLIC OF', 'TZ', 'TZA', 'Tanzania, United Republic of', '834', 255, 0, NULL, NULL, NULL),
(211, 'THAILAND', 'TH', 'THA', 'Thailand', '764', 66, 0, NULL, NULL, NULL),
(212, 'TIMOR-LESTE', 'TL', '', 'Timor-Leste', '', 670, 0, NULL, NULL, NULL),
(213, 'TOGO', 'TG', 'TGO', 'Togo', '768', 228, 0, NULL, NULL, NULL),
(214, 'TOKELAU', 'TK', 'TKL', 'Tokelau', '772', 690, 0, NULL, NULL, NULL),
(215, 'TONGA', 'TO', 'TON', 'Tonga', '776', 676, 0, NULL, NULL, NULL),
(216, 'TRINIDAD AND TOBAGO', 'TT', 'TTO', 'Trinidad and Tobago', '780', 1868, 0, NULL, NULL, NULL),
(217, 'TUNISIA', 'TN', 'TUN', 'Tunisia', '788', 216, 0, NULL, NULL, NULL),
(218, 'TURKEY', 'TR', 'TUR', 'Turkey', '792', 90, 0, NULL, NULL, NULL),
(219, 'TURKMENISTAN', 'TM', 'TKM', 'Turkmenistan', '795', 7370, 0, NULL, NULL, NULL),
(220, 'TURKS AND CAICOS ISLANDS', 'TC', 'TCA', 'Turks and Caicos Islands', '796', 1649, 0, NULL, NULL, NULL),
(221, 'TUVALU', 'TV', 'TUV', 'Tuvalu', '798', 688, 0, NULL, NULL, NULL),
(222, 'UGANDA', 'UG', 'UGA', 'Uganda', '800', 256, 0, NULL, NULL, NULL),
(223, 'UKRAINE', 'UA', 'UKR', 'Ukraine', '804', 380, 0, NULL, NULL, NULL),
(224, 'UNITED ARAB EMIRATES', 'AE', 'ARE', 'United Arab Emirates', '784', 971, 0, NULL, NULL, NULL),
(225, 'UNITED KINGDOM', 'GB', 'GBR', 'United Kingdom', '826', 44, 0, NULL, NULL, NULL),
(226, 'UNITED STATES', 'US', 'USA', 'United States', '840', 1, 0, NULL, NULL, NULL),
(227, 'UNITED STATES MINOR OUTLYING ISLANDS', 'UM', '', 'United States Minor Outlying Islands', '', 1, 0, NULL, NULL, NULL),
(228, 'URUGUAY', 'UY', 'URY', 'Uruguay', '858', 598, 0, NULL, NULL, NULL),
(229, 'UZBEKISTAN', 'UZ', 'UZB', 'Uzbekistan', '860', 998, 0, NULL, NULL, NULL),
(230, 'VANUATU', 'VU', 'VUT', 'Vanuatu', '548', 678, 0, NULL, NULL, NULL),
(231, 'VENEZUELA', 'VE', 'VEN', 'Venezuela', '862', 58, 0, NULL, NULL, NULL),
(232, 'VIET NAM', 'VN', 'VNM', 'Viet Nam', '704', 84, 0, NULL, NULL, NULL),
(233, 'VIRGIN ISLANDS, BRITISH', 'VG', 'VGB', 'Virgin Islands, British', '92', 1284, 0, NULL, NULL, NULL),
(234, 'VIRGIN ISLANDS, U.S.', 'VI', 'VIR', 'Virgin Islands, U.s.', '850', 1340, 0, NULL, NULL, NULL),
(235, 'WALLIS AND FUTUNA', 'WF', 'WLF', 'Wallis and Futuna', '876', 681, 0, NULL, NULL, NULL),
(236, 'WESTERN SAHARA', 'EH', 'ESH', 'Western Sahara', '732', 212, 0, NULL, NULL, NULL),
(237, 'YEMEN', 'YE', 'YEM', 'Yemen', '887', 967, 0, NULL, NULL, NULL),
(238, 'ZAMBIA', 'ZM', 'ZMB', 'Zambia', '894', 260, 0, NULL, NULL, NULL),
(239, 'ZIMBABWE', 'ZW', 'ZWE', 'Zimbabwe', '716', 263, 0, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
