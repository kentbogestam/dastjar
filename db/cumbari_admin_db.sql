-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2010 at 02:44 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cumbari_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE IF NOT EXISTS `campaign` (
  `campaign_id` char(36) NOT NULL,
  `company_id` char(36) DEFAULT NULL,
  `u_id` char(36) DEFAULT NULL,
  `limit_period_list` varchar(255) DEFAULT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `required_card` varchar(255) DEFAULT NULL,
  `supported_cards` varchar(255) DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `spons` tinyint(1) NOT NULL,
  `start_of_publishing` date NOT NULL,
  `end_of_publishing` date NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `infopage` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaign_id`, `company_id`, `u_id`, `limit_period_list`, `small_image`, `large_image`, `required_card`, `supported_cards`, `discount`, `keywords`, `category`, `spons`, `start_of_publishing`, `end_of_publishing`, `campaign_name`, `infopage`, `link`) VALUES
('4cf34958c8ede', '4cf33a12a6d5f', '4cf339c5c6c5e', NULL, 'cat_icon_0f08b925b10dacd59cde8fb0059c5e0f.png', 'cpn_0f08b925b10dacd59cde8fb0059c5e0f.jpg', NULL, NULL, NULL, 'test kword', '40e1b612-fb7a-11df-bdea-a09c2c07a00d', 1, '2010-11-30', '2010-12-05', 'Test CAmp', 'Additional info', 'ww.google.com'),
('4cf3950197d0f', '4cf38d710c782', '4cf387d65ca75', NULL, 'cat_icon_9a6a31a588b0645689012da79e88a168.png', 'cpn_9a6a31a588b0645689012da79e88a168.jpg', NULL, NULL, NULL, 'dfgertret', 'YES', 0, '2010-11-30', '2010-11-30', 'rtytrytyr', '', 'eterterte'),
('4cf3965a06f7a', '4cf38d710c782', '4cf387d65ca75', NULL, 'cat_icon_3a07590222cc8b0ed8ea453a8fc86a8b.png', 'cpn_3a07590222cc8b0ed8ea453a8fc86a8b.jpg', NULL, NULL, NULL, 'dfgertret', 'YES', 0, '2010-11-30', '2010-11-30', 'rtytrytyr', '', 'eterterte'),
('4cf3a2f1431d1', '4cf3a21dad4a4', '4cf3a2021b045', NULL, 'cat_icon_5546e53f01da9aa34bc6c4821a34e7a9.png', 'cpn_5546e53f01da9aa34bc6c4821a34e7a9.jpg', NULL, NULL, NULL, 'asdfasd', '40e1b612-fb7a-11df-bdea-a09c2c07a00d', 0, '2010-11-29', '2010-11-29', 'fsadfsda', 'sadfsa', 'fdsdfasd'),
('4cf3a8ec4f75c', '4cf3a659a7eb4', '4cf3a5edd10f8', NULL, 'cat_icon_65650ac6240224bbf4b6d16b0b2d1031.png', 'cpn_65650ac6240224bbf4b6d16b0b2d1031.jpg', NULL, NULL, NULL, 'my camp', 'b1c22017-fb7a-11df-bdea-a09c2c07a00d', 0, '2010-11-30', '2010-12-05', 'camp name', 'test info', 'xyz.com'),
('4cf4c47fb72d5', '4cf4c3ada71c9', '4cf4c3904c26d', NULL, 'cat_icon_2b4efd183aeccee8e38d86b6fc799b9e.png', 'cpn_2b4efd183aeccee8e38d86b6fc799b9e.jpg', NULL, NULL, NULL, 'chgj', 'YES', 0, '2010-11-30', '2010-12-01', 'fdcgfxd', 'hj', 'chj'),
('4cf5feb90dc8d', '', '', NULL, 'cat_icon_aed527fdd5d6fc2a6abe0b4366ac2014.png', 'cpn_aed527fdd5d6fc2a6abe0b4366ac2014.jpg', NULL, NULL, NULL, 'qwe', 'YES', 0, '2010-12-01', '2010-12-01', 'qwe', 'qwe', 'qwe'),
('4cf605dc9b458', '', '', NULL, 'cat_icon_403b365882f96d6fbbde53d0bb789c7c.png', 'cpn_403b365882f96d6fbbde53d0bb789c7c.jpg', NULL, NULL, NULL, 'ewqe', 'YES', 0, '2010-12-03', '2010-12-01', 'wewq', 'eqwe', 'ewqe'),
('4cff2bf73d3c6', '', '', NULL, 'cat_icon_e12bb1b326eee35c659fc94497637d53.png', 'cpn_eecc3d0ea1bc8ec72aaeac02d8b13848.jpg', NULL, NULL, NULL, 'Test CAmp', 'YES', 0, '2010-12-09', '2010-12-30', 'Test CAmp', '', 'http://google.com'),
('4cff83d5e6fea', '', '', NULL, 'cat_icon_96da47ade00bbae734f2630ef65791ca.png', 'cpn_96da47ade00bbae734f2630ef65791ca.jpg', NULL, NULL, NULL, 'Test Camp', 'YES', 0, '2010-12-08', '2010-12-31', 'Test Camp', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_offer_description_lang_list`
--

CREATE TABLE IF NOT EXISTS `campaign_offer_description_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_description_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_description_lang_list`),
  KEY `offer_description_lang_list` (`offer_description_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_offer_description_lang_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `campaign_offer_infopage_lang_list`
--

CREATE TABLE IF NOT EXISTS `campaign_offer_infopage_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_infopage_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_infopage_lang_list`),
  KEY `offer_infopage_lang_list` (`offer_infopage_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_offer_infopage_lang_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `campaign_offer_slogan_lang_list`
--

CREATE TABLE IF NOT EXISTS `campaign_offer_slogan_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_slogan_lang_list`),
  KEY `offer_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_offer_slogan_lang_list`
--

INSERT INTO `campaign_offer_slogan_lang_list` (`campaign_id`, `offer_slogan_lang_list`) VALUES
('4cff83d5e6fea', '4cff83d63c3f2');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_offer_sub_slogan_lang_list`
--

CREATE TABLE IF NOT EXISTS `campaign_offer_sub_slogan_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_sub_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_sub_slogan_lang_list`),
  KEY `offer_sub_slogan_lang_list` (`offer_sub_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_offer_sub_slogan_lang_list`
--

INSERT INTO `campaign_offer_sub_slogan_lang_list` (`campaign_id`, `offer_sub_slogan_lang_list`) VALUES
('4cff83d5e6fea', '4cff83d658eca');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` char(36) NOT NULL,
  `small_image` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `small_image`) VALUES
('40e1b612-fb7a-11df-bdea-a09c2c07a00d', 'FoodSnacks.png'),
('985d5878-fb7a-11df-bdea-a09c2c07a00d', 'HealthBeauty.png'),
('b1c22017-fb7a-11df-bdea-a09c2c07a00d', 'Shopping.png');

-- --------------------------------------------------------

--
-- Table structure for table `category_names_lang_list`
--

CREATE TABLE IF NOT EXISTS `category_names_lang_list` (
  `category_id` char(36) NOT NULL,
  `names_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`category_id`,`names_lang_list`),
  KEY `names_lang_list` (`names_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_names_lang_list`
--

INSERT INTO `category_names_lang_list` (`category_id`, `names_lang_list`) VALUES
('985d5878-fb7a-11df-bdea-a09c2c07a00d', '19a80db9-fb7a-11df-bdea-a09c2c07a00d'),
('b1c22017-fb7a-11df-bdea-a09c2c07a00d', '19a80f6e-fb7a-11df-bdea-a09c2c07a00d'),
('40e1b612-fb7a-11df-bdea-a09c2c07a00d', 'c10fd5d8-fb7a-11df-bdea-a09c2c07a00d');

-- --------------------------------------------------------

--
-- Table structure for table `ccode`
--

CREATE TABLE IF NOT EXISTS `ccode` (
  `ccode` bigint(20) NOT NULL DEFAULT '0',
  `start_of_validity` date NOT NULL,
  `end_of_validity` date NOT NULL,
  `activ` tinyint(1) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`ccode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ccode`
--


-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` char(36) NOT NULL,
  `u_id` char(36) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `orgnr` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `tzcountries` varchar(255) DEFAULT NULL,
  `timezones` varchar(255) DEFAULT NULL,
  `currencies` varchar(255) DEFAULT NULL,
  `pre_loaded_value` int(11) DEFAULT NULL,
  `budget` int(11) DEFAULT NULL,
  `c_activ` tinyint(4) DEFAULT NULL,
  `seller_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`company_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `u_id`, `company_name`, `orgnr`, `street`, `zip`, `city`, `country`, `tzcountries`, `timezones`, `currencies`, `pre_loaded_value`, `budget`, `c_activ`, `seller_id`) VALUES
('4cf33a12a6d5f', '4cf339c5c6c5e', 'Shwephertz', 'XYZ', 'Sec 43', '12121', 'Gurgaon', 'India', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf38d710c782', '4cf387d65ca75', 'erterter', 'erwe', 'ewrwer', '34535', 'ewrwere', 'yretye', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf38da49cfd0', '4cf387d65ca75', 'pepsi', '123', '123', '456546', 'erew', 'fdg', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf38de753b37', '4cf387d65ca75', 'fkjgfdjg', '123', '123', '456546', 'erew', 'fdg', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf3a21dad4a4', '4cf3a2021b045', 'Shephertz Technologies Pvt. Ltd.', '12', '4136, B-5 & 6, Gate No. 1', '110070', 'New Delhi', 'IN', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf3a659a7eb4', '4cf3a5edd10f8', 'shepherz', '123', 'sec24', '12345', 'Gurgan', 'India', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf3bd7c9e31f', '4cf3bd6df2c8a', 'fg', 'zfdg', 'zdfg', '435', 'zdsfg', 'dasfg', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c27a244d3', '4cf49e32dcb19', 'Coca Cola', 'zg', 'fgz', '456', 'fdg', 'fg', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c2c10ce07', '4cf49e32dcb19', 'Coca Cola', 'gdf', 'fsg', '45', 'ttgf', 'trgsd', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c3ada71c9', '4cf4c3904c26d', 'Coca Cola', '123org', 'street', '212121', 'city', 'India', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c3f9476fa', '4cf4c3904c26d', 'fvd', 'dfs', 'sfa', '342', 'dsf', 'dfs', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c45f1ce9a', '4cf4c3904c26d', 'ugh', 'hgjhg', 'j', '78', 'fgh87', 'ghj', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf4c4ce2b671', '4cf4c3904c26d', 'Coca Cola', 'zg', 'fsg', '45', 'fdg', 'gch', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf5f5ac28836', '4cf5f33cb09d3', 'Coca Cola', 'zg', 'fsg', '45', 'fdg', 'gch', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cf5f5eaa3365', '4cf5f33cb09d3', 'Coca Cola', 'zg', 'fsg', '45', 'fdg', 'gch', 'SE', '', 'SEK', NULL, NULL, NULL, NULL),
('4cff58e2cb30e', '4cff552a7f1c6', 'Shephertz', '234wew', 'Sect 43', '12345', 'Gurgaon', 'India', 'SE', '', 'SEK', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

CREATE TABLE IF NOT EXISTS `cost` (
  `country` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `mfee` int(11) NOT NULL,
  `minfee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cost`
--


-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `coupon_id` char(36) NOT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  `store_id` char(36) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `small_image` varchar(100) NOT NULL,
  `large_image` varchar(100) NOT NULL,
  `category_id` char(36) NOT NULL,
  `is_sponsored` tinyint(1) NOT NULL,
  `startValidity` datetime DEFAULT NULL,
  `endOfPublishing` datetime DEFAULT NULL,
  `coupon_delivery_type` varchar(255) NOT NULL,
  `offer_type` tinyint(3) NOT NULL,
  PRIMARY KEY (`coupon_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `campaign_id`, `product_id`, `store_id`, `brand_name`, `small_image`, `large_image`, `category_id`, `is_sponsored`, `startValidity`, `endOfPublishing`, `coupon_delivery_type`, `offer_type`) VALUES
('', NULL, NULL, '', 'rtyry', 'trie.png', '', 'YES', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf34959146a7', '4cf34958c8ede', NULL, '4cf33a12adcea', 'Mcd', 'cat_icon_0f08b925b10dacd59cde8fb0059c5e0f.png', 'cpn_0f08b925b10dacd59cde8fb0059c5e0f.jpg', '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf39501cadba', '4cf3950197d0f', NULL, '4cf38d71185d9', 'tyyrt', 'cat_icon_9a6a31a588b0645689012da79e88a168.png', 'cpn_9a6a31a588b0645689012da79e88a168.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf3965a2f182', '4cf3965a06f7a', NULL, '4cf38d71185d9', 'tyyrt', 'cat_icon_3a07590222cc8b0ed8ea453a8fc86a8b.png', 'cpn_3a07590222cc8b0ed8ea453a8fc86a8b.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf3a2f16a756', '4cf3a2f1431d1', NULL, '4cf3a21db554c', 'sadfadsf', 'cat_icon_5546e53f01da9aa34bc6c4821a34e7a9.png', 'cpn_5546e53f01da9aa34bc6c4821a34e7a9.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf3a86b0113c', NULL, '4cf3a86aaa5e7', '', 'rtete', 'cat_icon_78590c80b43523b44c2f9ee82e6b3263.png', 'cpn_78590c80b43523b44c2f9ee82e6b3263.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf3a8ec6e903', '4cf3a8ec4f75c', NULL, '4cf3a659aed81', 'Mcd', 'cat_icon_65650ac6240224bbf4b6d16b0b2d1031.png', 'cpn_65650ac6240224bbf4b6d16b0b2d1031.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf4c4802f74b', '4cf4c47fb72d5', NULL, '4cf4c3adaede0', 'cghj', 'cat_icon_2b4efd183aeccee8e38d86b6fc799b9e.png', 'cpn_2b4efd183aeccee8e38d86b6fc799b9e.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf5fe1f57952', NULL, '4cf5fe1f2c1b5', '', 'qwe', 'cat_icon_f187abc127ba64783beee9cabf3e6c37.png', 'cpn_f187abc127ba64783beee9cabf3e6c37.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf5feb92c180', '4cf5feb90dc8d', NULL, '', 'qwe', 'cat_icon_aed527fdd5d6fc2a6abe0b4366ac2014.png', 'cpn_aed527fdd5d6fc2a6abe0b4366ac2014.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cf605dcbec61', '4cf605dc9b458', NULL, '', 'weq', 'cat_icon_403b365882f96d6fbbde53d0bb789c7c.png', 'cpn_403b365882f96d6fbbde53d0bb789c7c.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cff2bf7ac195', '4cff2bf73d3c6', NULL, '', 'Mcd', 'cat_icon_e12bb1b326eee35c659fc94497637d53.png', 'cpn_eecc3d0ea1bc8ec72aaeac02d8b13848.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0),
('4cff83d666b2d', '4cff83d5e6fea', NULL, '', 'Mcd', 'cat_icon_96da47ade00bbae734f2630ef65791ca.png', 'cpn_96da47ade00bbae734f2630ef65791ca.jpg', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_limit_period_list`
--

CREATE TABLE IF NOT EXISTS `coupon_limit_period_list` (
  `campaign_id` char(36) NOT NULL,
  `limit_period_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`limit_period_list`),
  KEY `limit_period_list` (`limit_period_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon_limit_period_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `coupon_usage_statistics`
--

CREATE TABLE IF NOT EXISTS `coupon_usage_statistics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `coupon_id` char(36) NOT NULL,
  `num_consumes` int(11) NOT NULL,
  `num_loads` int(11) NOT NULL,
  `num_views` int(11) NOT NULL,
  `store_id` char(36) NOT NULL,
  `sum_consume_dist_to_store` int(11) NOT NULL,
  `sum_load_dist_to_store` int(11) NOT NULL,
  `sum_view_dist_to_store` int(11) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `coupon_usage_statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `c_s_rel`
--

CREATE TABLE IF NOT EXISTS `c_s_rel` (
  `campaign_id` char(36) NOT NULL,
  `store_id` char(36) NOT NULL,
  `start_of_publishing` date NOT NULL,
  `end_of_publishing` date NOT NULL,
  `activ` tinyint(4) DEFAULT NULL,
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c_s_rel`
--


-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE IF NOT EXISTS `employer` (
  `company_id` char(36) NOT NULL,
  `u_id` char(36) NOT NULL,
  PRIMARY KEY (`company_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--


-- --------------------------------------------------------

--
-- Table structure for table `lang_text`
--

CREATE TABLE IF NOT EXISTS `lang_text` (
  `id` char(36) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `text` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lang_text`
--

INSERT INTO `lang_text` (`id`, `lang`, `text`) VALUES
('19a80db9-fb7a-11df-bdea-a09c2c07a00d', 'ENG', 'Health & Beauty'),
('19a80f6e-fb7a-11df-bdea-a09c2c07a00d', 'ENG', 'Shopping'),
('4cf3a86abad5a', 'ENG', 'ertertg'),
('4cf3a86ac5ecb', 'ENG', 'ertretret'),
('4cf5fe1f3b69f', 'ENG', 'qwe'),
('4cf5fe1f4bda7', 'ENG', 'qwe'),
('4cff83d63c3f2', 'ENG', 'My Campaign new'),
('4cff83d658eca', 'ENG', 'My Sub Campaign'),
('c10fd5d8-fb7a-11df-bdea-a09c2c07a00d', 'ENG', 'Mat & Snacks');

-- --------------------------------------------------------

--
-- Table structure for table `limit_period`
--

CREATE TABLE IF NOT EXISTS `limit_period` (
  `limit_id` char(36) NOT NULL,
  `end_time` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `valid_day` varchar(255) NOT NULL,
  PRIMARY KEY (`limit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `limit_period`
--


-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` char(36) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand_name` varchar(100) NOT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `category` char(36) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `is_sponsored` tinyint(1) NOT NULL,
  `coupon_delivery_type` varchar(255) NOT NULL,
  `offer_type` varchar(255) NOT NULL,
  `infopage` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `brand_name`, `small_image`, `large_image`, `category`, `keywords`, `is_sponsored`, `coupon_delivery_type`, `offer_type`, `infopage`, `link`) VALUES
('4cf3a86aaa5e7', NULL, 'rtete', 'cat_icon_78590c80b43523b44c2f9ee82e6b3263.png', 'cpn_78590c80b43523b44c2f9ee82e6b3263.jpg', 'No', 'tretret', 0, '', '', 'retertre', 'retertert'),
('4cf5fe1f2c1b5', NULL, 'qwe', 'cat_icon_f187abc127ba64783beee9cabf3e6c37.png', 'cpn_f187abc127ba64783beee9cabf3e6c37.jpg', 'No', 'qwe', 0, '', '', 'qwe', 'qwe');

-- --------------------------------------------------------

--
-- Table structure for table `product_offer_description_lang_list`
--

CREATE TABLE IF NOT EXISTS `product_offer_description_lang_list` (
  `product_id` char(36) NOT NULL,
  `offer_description_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`product_id`,`offer_description_lang_list`),
  KEY `offer_description_lang_list` (`offer_description_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_offer_description_lang_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_offer_infopage_lang_list`
--

CREATE TABLE IF NOT EXISTS `product_offer_infopage_lang_list` (
  `product_id` char(36) NOT NULL,
  `offer_infopage_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`product_id`,`offer_infopage_lang_list`),
  KEY `offer_infopage_lang_list` (`offer_infopage_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_offer_infopage_lang_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_offer_slogan_lang_list`
--

CREATE TABLE IF NOT EXISTS `product_offer_slogan_lang_list` (
  `product_id` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`product_id`,`offer_slogan_lang_list`),
  KEY `offer_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_offer_slogan_lang_list`
--

INSERT INTO `product_offer_slogan_lang_list` (`product_id`, `offer_slogan_lang_list`) VALUES
('4cf3a86aaa5e7', '4cf3a86abad5a'),
('4cf5fe1f2c1b5', '4cf5fe1f3b69f');

-- --------------------------------------------------------

--
-- Table structure for table `product_offer_sub_slogan_lang_list`
--

CREATE TABLE IF NOT EXISTS `product_offer_sub_slogan_lang_list` (
  `product_id` char(36) NOT NULL,
  `offer_sub_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`product_id`,`offer_sub_slogan_lang_list`),
  KEY `offer_sub_slogan_lang_list` (`offer_sub_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_offer_sub_slogan_lang_list`
--

INSERT INTO `product_offer_sub_slogan_lang_list` (`product_id`, `offer_sub_slogan_lang_list`) VALUES
('4cf3a86aaa5e7', '4cf3a86ac5ecb'),
('4cf5fe1f2c1b5', '4cf5fe1f4bda7');

-- --------------------------------------------------------

--
-- Table structure for table `reselleragrement`
--

CREATE TABLE IF NOT EXISTS `reselleragrement` (
  `u_id` char(36) NOT NULL,
  `store_email` varchar(255) NOT NULL,
  `store_mphone` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `raddr` varchar(255) DEFAULT NULL,
  `auth_metode` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reselleragrement`
--


-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_id` char(36) NOT NULL,
  `u_id` char(36) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `coupon_delivery_type` varchar(255) DEFAULT NULL,
  `s_activ` tinyint(1) DEFAULT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`store_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `u_id`, `latitude`, `longitude`, `store_name`, `street`, `city`, `country`, `coupon_delivery_type`, `s_activ`, `phone`, `email`, `link`) VALUES
('', '4cee6d714011a', 0, 0, 'XYZ', 'abvc', 'Gurgaon', 'India', 'Bar Code', NULL, 0, '', ''),
('4cf33a12adcea', '4cf339c5c6c5e', 62.5123179383869, 8.54736328125, 'Shwephertz ACC', 'Sec 431', 'Gurgaon1', 'India1', 'Manually', NULL, 0, '', ''),
('4cf38d71185d9', '4cf387d65ca75', 34, 12, 'qw', 'er', 'ty', 'ui', 'NFC', NULL, 0, '', ''),
('4cf38da4a3ad3', '4cf387d65ca75', 34, 12, 'qw', 'er', 'ty', 'ui', 'NFC', NULL, 0, '', ''),
('4cf38de75c9d5', '4cf387d65ca75', 34, 12, 'qw', 'er', 'ty', 'ui', 'NFC', NULL, 0, '', ''),
('4cf3a21db554c', '4cf3a2021b045', 13341234, 1213123, 'Shephertz Technologies Pvt. Ltd.', '4136, B-5 & 6, Gate No. 1', 'New Delhi', 'IN', 'Manually', NULL, 0, '', ''),
('4cf3a659aed81', '4cf3a5edd10f8', 59.3449881475202, 18.0657075047111, 'shepherz', 'africa avenue, 23', 'Delhi', 'India', 'Manually', NULL, 0, '', ''),
('4cf4c3adaede0', '4cf4c3904c26d', 0, 0, 'Coca Cola', 'street', 'city', 'India', NULL, NULL, 0, '', ''),
('4cf4c3f94d926', '4cf4c3904c26d', 0, 0, 'fvd', 'sfa', 'dsf', 'dfs', NULL, NULL, 0, '', ''),
('4cf4c45f27ef9', '4cf4c3904c26d', 0, 0, 'ugh', 'j', 'fgh87', 'ghj', NULL, NULL, 0, '', ''),
('4cf4c4ce3ca24', '4cf4c3904c26d', 0, 0, 'Coca Cola', 'fsg', 'fdg', 'gch', NULL, NULL, 0, '', ''),
('4cf5f5ac312bd', '4cf5f33cb09d3', 0, 0, 'Coca Cola', 'fsg', 'fdg', 'gch', NULL, NULL, 0, '', ''),
('4cf5f5eaac706', '4cf5f33cb09d3', 0, 0, 'Coca Cola', 'fsg', 'fdg', 'gch', NULL, NULL, 0, '', ''),
('4cff58e2dc192', '4cff552a7f1c6', 0, 0, 'Shephertz', 'Sect 43', 'Gurgaon', 'India', NULL, NULL, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_receipt`
--

CREATE TABLE IF NOT EXISTS `transaction_receipt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) NOT NULL,
  `coupon_id` char(36) NOT NULL,
  `purchase_time` datetime NOT NULL,
  `store_id` char(36) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transaction_receipt`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `u_id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` char(40) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `role` varchar(16) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `mobile_phone` int(11) DEFAULT NULL,
  `saddr` varchar(255) DEFAULT NULL,
  `city_addr` varchar(255) DEFAULT NULL,
  `home_zip` varchar(255) DEFAULT NULL,
  `caddr` varchar(255) DEFAULT NULL,
  `resellers_bank` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email_varify_code` varchar(255) NOT NULL,
  `company_id` char(36) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `email`, `passwd`, `fname`, `lname`, `role`, `phone`, `mobile_phone`, `saddr`, `city_addr`, `home_zip`, `caddr`, `resellers_bank`, `Date`, `email_varify_code`, `company_id`, `active`) VALUES
('4cee6d714011a', 'sushil.bhadouria@gmail.com', 'sushil123', 'Sushil', 'Singh', '', 2147483647, 2147483647, NULL, NULL, NULL, NULL, NULL, '2010-11-25 19:36:41', 'f71efefac0895b42263dbf0bbeee002d', '', 0),
('4cf339c5c6c5e', 'sushil@gmail.com', 'sushil123', 'Sushil', 'Singh', '', 2147483647, 2147483647, NULL, NULL, NULL, NULL, NULL, '2010-11-29 10:57:33', '1b623e80c3725f252810d93748668b09', '', 0),
('4cf387d65ca75', 'deo.tripathi@shephertz.co.in', '123456', 'De', 'Tripathi', '', 2147483647, 46365464, NULL, NULL, NULL, NULL, NULL, '2010-11-29 16:30:38', '3cef70b404486401b6f4d8521cca4898', '', 0),
('4cf3a2021b045', 'siddharthachandurkar@gmail.com', 'Sid123', 'Jack', 'Daniel', 'Store Admin', 2147483647, 2147483647, NULL, NULL, NULL, NULL, NULL, '2010-11-29 18:22:18', '1cdaf7cd42a9ba4ab714e5d4a9e83ac4', '', 0),
('4cf3a5edd10f8', 'kent@bogestam.com', 'Kent1kent', 'Kent', 'Bogestam', 'Store Admin', 2147483647, 2147483647, NULL, NULL, NULL, NULL, NULL, '2010-11-29 18:39:01', 'a771ac3de86cfa03410dd5e492b33f28', '', 0),
('4cf3bd6df2c8a', 'amit1@gmail.com', 'open123', 'asdad', 'Kumar', 'Store Admin', 4612344, 46124345, NULL, NULL, NULL, NULL, NULL, '2010-11-29 20:19:17', '994b63c385d19bcfa0e8e747619d0fcf', '', 0),
('4cf49e32dcb19', 'himanshusingh1187@gmail.com', 'open123', 'Himanshu', 'Singh', 'Store Admin', 597123456, 597987654, NULL, NULL, NULL, NULL, NULL, '2010-11-30 12:18:18', '31129c40fe44916c4ad95078c1eae7ce', '', 0),
('4cf4c3904c26d', 'him123@gmail.com', 'open123', 'Himanshu', 'Singh', 'Store Admin', 46123456, 46, NULL, NULL, NULL, NULL, NULL, '2010-11-30 14:57:44', 'ebe838ca7e5405d0d0256613dcab2acf', '', 0),
('4cf5f33cb09d3', 'dty@g.com', '123456', 'dfgdg', 'fdsgdfg', 'Store Admin', 4612344, 46123456, NULL, NULL, NULL, NULL, NULL, '2010-12-01 12:33:24', 'd8113654c0381eb291e17c861c8fb34a', '', 0),
('4cff552a7f1c6', 'ftest@gmail.com', 'sushil123', 'Sushil', 'Singh', 'Store Admin', 461234565, 2147483647, NULL, NULL, NULL, NULL, NULL, '2010-12-08 15:21:38', '88caffa08552515fdbfcc3e1c6a13014', '', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign_offer_description_lang_list`
--
ALTER TABLE `campaign_offer_description_lang_list`
  ADD CONSTRAINT `campaign_offer_description_lang_list_ibfk_1` FOREIGN KEY (`offer_description_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `campaign_offer_description_lang_list_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);

--
-- Constraints for table `campaign_offer_infopage_lang_list`
--
ALTER TABLE `campaign_offer_infopage_lang_list`
  ADD CONSTRAINT `campaign_offer_infopage_lang_list_ibfk_1` FOREIGN KEY (`offer_infopage_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `campaign_offer_infopage_lang_list_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);

--
-- Constraints for table `campaign_offer_slogan_lang_list`
--
ALTER TABLE `campaign_offer_slogan_lang_list`
  ADD CONSTRAINT `campaign_offer_slogan_lang_list_ibfk_1` FOREIGN KEY (`offer_slogan_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `campaign_offer_slogan_lang_list_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);

--
-- Constraints for table `campaign_offer_sub_slogan_lang_list`
--
ALTER TABLE `campaign_offer_sub_slogan_lang_list`
  ADD CONSTRAINT `campaign_offer_sub_slogan_lang_list_ibfk_1` FOREIGN KEY (`offer_sub_slogan_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `campaign_offer_sub_slogan_lang_list_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);

--
-- Constraints for table `category_names_lang_list`
--
ALTER TABLE `category_names_lang_list`
  ADD CONSTRAINT `category_names_lang_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `category_names_lang_list_ibfk_2` FOREIGN KEY (`names_lang_list`) REFERENCES `lang_text` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `coupon`
--
ALTER TABLE `coupon`
  ADD CONSTRAINT `coupon_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`),
  ADD CONSTRAINT `coupon_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `coupon_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `coupon_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `coupon_limit_period_list`
--
ALTER TABLE `coupon_limit_period_list`
  ADD CONSTRAINT `coupon_limit_period_list_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`),
  ADD CONSTRAINT `coupon_limit_period_list_ibfk_2` FOREIGN KEY (`limit_period_list`) REFERENCES `limit_period` (`limit_id`);

--
-- Constraints for table `c_s_rel`
--
ALTER TABLE `c_s_rel`
  ADD CONSTRAINT `c_s_rel_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);

--
-- Constraints for table `employer`
--
ALTER TABLE `employer`
  ADD CONSTRAINT `employer_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`),
  ADD CONSTRAINT `employer_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `product_offer_description_lang_list`
--
ALTER TABLE `product_offer_description_lang_list`
  ADD CONSTRAINT `product_offer_description_lang_list_ibfk_1` FOREIGN KEY (`offer_description_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `product_offer_description_lang_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_offer_infopage_lang_list`
--
ALTER TABLE `product_offer_infopage_lang_list`
  ADD CONSTRAINT `product_offer_infopage_lang_list_ibfk_1` FOREIGN KEY (`offer_infopage_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `product_offer_infopage_lang_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_offer_slogan_lang_list`
--
ALTER TABLE `product_offer_slogan_lang_list`
  ADD CONSTRAINT `product_offer_slogan_lang_list_ibfk_1` FOREIGN KEY (`offer_slogan_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `product_offer_slogan_lang_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_offer_sub_slogan_lang_list`
--
ALTER TABLE `product_offer_sub_slogan_lang_list`
  ADD CONSTRAINT `product_offer_sub_slogan_lang_list_ibfk_1` FOREIGN KEY (`offer_sub_slogan_lang_list`) REFERENCES `lang_text` (`id`),
  ADD CONSTRAINT `product_offer_sub_slogan_lang_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `reselleragrement`
--
ALTER TABLE `reselleragrement`
  ADD CONSTRAINT `reselleragrement_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
