-- MySQL dump 10.15  Distrib 10.0.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cumbari_admin
-- ------------------------------------------------------
-- Server version	10.0.22-MariaDB

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
-- Table structure for table `advertise`
--

DROP TABLE IF EXISTS `advertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise` (
  `advertise_id` char(36) NOT NULL,
  `company_id` char(36) DEFAULT NULL,
  `u_id` char(36) DEFAULT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `required_card` varchar(255) DEFAULT NULL,
  `supported_cards` varchar(255) DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `spons` tinyint(1) NOT NULL COMMENT '0=No, 1= Yes',
  `start_of_publishing` datetime NOT NULL,
  `end_of_publishing` datetime NOT NULL,
  `startValidity` datetime NOT NULL,
  `advertise_name` varchar(255) NOT NULL,
  `view_opt` char(3) NOT NULL,
  `infopage` varchar(255) DEFAULT NULL,
  `s_activ` tinyint(4) NOT NULL COMMENT '0=Active, 2=Deleted',
  `reseller_status` char(1) NOT NULL,
  `value` int(11) NOT NULL,
  `partner_id` char(36) NOT NULL,
  PRIMARY KEY (`advertise_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertise_keyword`
--

DROP TABLE IF EXISTS `advertise_keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_keyword` (
  `advertise_id` char(36) NOT NULL,
  `offer_keyword` char(36) NOT NULL,
  `system_key` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertise_offer_slogan_lang_list`
--

DROP TABLE IF EXISTS `advertise_offer_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_offer_slogan_lang_list` (
  `advertise_id` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`advertise_id`,`offer_slogan_lang_list`),
  KEY `offer_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertise_offer_sub_slogan_lang_list`
--

DROP TABLE IF EXISTS `advertise_offer_sub_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_offer_sub_slogan_lang_list` (
  `advertise_id` char(36) NOT NULL,
  `offer_sub_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`advertise_id`,`offer_sub_slogan_lang_list`),
  KEY `offer_sub_slogan_lang_list` (`offer_sub_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` char(36) NOT NULL,
  `company_id` char(36) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL COMMENT '2=deleted, 1=active, 0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `c_s_rel`
--

DROP TABLE IF EXISTS `c_s_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `c_s_rel` (
  `campaign_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  `advertise_id` char(36) DEFAULT NULL,
  `coupon_id` char(36) NOT NULL,
  `store_id` char(36) NOT NULL,
  `start_of_publishing` datetime NOT NULL,
  `end_of_publishing` datetime NOT NULL DEFAULT '2031-03-10 00:00:00',
  `activ` tinyint(4) DEFAULT NULL COMMENT '1=Active, 2=Deleted',
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign` (
  `campaign_id` char(36) NOT NULL,
  `company_id` char(36) DEFAULT NULL,
  `u_id` char(36) DEFAULT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `required_card` varchar(255) DEFAULT NULL,
  `supported_cards` varchar(255) DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `spons` tinyint(1) NOT NULL COMMENT '0=No, 1= Yes',
  `start_of_publishing` datetime NOT NULL,
  `end_of_publishing` datetime NOT NULL,
  `startValidity` datetime NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `view_opt` char(3) NOT NULL,
  `infopage` varchar(255) DEFAULT NULL,
  `s_activ` tinyint(4) NOT NULL COMMENT '0=Active, 2=Deleted',
  `reseller_status` char(1) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `code_type` varchar(200) DEFAULT NULL,
  `value` int(11) NOT NULL,
  `accept_by` char(36) NOT NULL,
  `MaxNrOfCoupons` int(11) NOT NULL,
  `GeneratedCoupons` int(11) NOT NULL,
  `RedeemedCoupons` int(11) NOT NULL,
  `partner_id` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_keyword`
--

DROP TABLE IF EXISTS `campaign_keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_keyword` (
  `campaign_id` char(36) NOT NULL,
  `offer_keyword` char(36) NOT NULL,
  `system_key` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_limit_period_list`
--

DROP TABLE IF EXISTS `campaign_limit_period_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_limit_period_list` (
  `campaign_id` char(36) NOT NULL,
  `limit_period_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`limit_period_list`),
  KEY `limit_period_list` (`limit_period_list`),
  CONSTRAINT `campaign_limit_period_list_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`),
  CONSTRAINT `campaign_limit_period_list_ibfk_2` FOREIGN KEY (`limit_period_list`) REFERENCES `limit_period` (`limit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_offer_slogan_lang_list`
--

DROP TABLE IF EXISTS `campaign_offer_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_offer_slogan_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_slogan_lang_list`),
  KEY `offer_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_offer_sub_slogan_lang_list`
--

DROP TABLE IF EXISTS `campaign_offer_sub_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_offer_sub_slogan_lang_list` (
  `campaign_id` char(36) NOT NULL,
  `offer_sub_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`campaign_id`,`offer_sub_slogan_lang_list`),
  KEY `offer_sub_slogan_lang_list` (`offer_sub_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` varchar(36) NOT NULL,
  `api_version` int(11) NOT NULL,
  `jpa_version` int(11) DEFAULT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_list_of_categories`
--

DROP TABLE IF EXISTS `categories_list_of_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_list_of_categories` (
  `categories` varchar(255) NOT NULL,
  `list_of_categories` char(36) NOT NULL,
  PRIMARY KEY (`categories`,`list_of_categories`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` char(36) NOT NULL,
  `small_image` varchar(255) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_names_lang_list`
--

DROP TABLE IF EXISTS `category_names_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_names_lang_list` (
  `category` char(36) NOT NULL,
  `names_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`category`,`names_lang_list`),
  KEY `names_lang_list` (`names_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ccode`
--

DROP TABLE IF EXISTS `ccode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ccode` (
  `ccode` char(36) NOT NULL DEFAULT '0',
  `start_of_validity` datetime NOT NULL,
  `end_of_validity` datetime NOT NULL,
  `activ` tinyint(1) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`ccode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
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
  `pre_loaded_value` int(10) unsigned DEFAULT NULL,
  `budget` int(11) DEFAULT NULL,
  `c_activ` tinyint(4) DEFAULT NULL,
  `seller_id` char(36) DEFAULT NULL,
  `seller_date` datetime NOT NULL,
  `ccode` char(36) DEFAULT NULL,
  `cc_value` int(11) DEFAULT NULL,
  `low_level` int(11) DEFAULT '100',
  `paid` tinyint(1) unsigned NOT NULL,
  `ba` tinyint(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cost`
--

DROP TABLE IF EXISTS `cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost` (
  `country` varchar(255) NOT NULL,
  `usage_fee` int(11) NOT NULL,
  `spons_fee` int(11) DEFAULT NULL,
  `brand_fee` int(11) DEFAULT NULL,
  `clicks` int(11) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `iso` char(2) CHARACTER SET latin1 NOT NULL,
  `name` varchar(80) CHARACTER SET latin1 NOT NULL,
  `printable_name` varchar(80) CHARACTER SET latin1 NOT NULL,
  `iso3` char(3) CHARACTER SET latin1 DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon` (
  `coupon_id` char(36) NOT NULL,
  `group_id` char(36) NOT NULL,
  `store` char(36) DEFAULT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_icon` varchar(255) DEFAULT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `product_info_link` varchar(255) DEFAULT NULL,
  `category` char(36) NOT NULL,
  `is_sponsored` tinyint(1) NOT NULL COMMENT '0=No, 1= Yes',
  `valid_from` datetime DEFAULT NULL,
  `end_of_publishing` datetime DEFAULT '2031-03-10 00:00:00',
  `coupon_delivery_type` varchar(255) NOT NULL,
  `offer_type` varchar(255) NOT NULL,
  `view_opt` char(3) NOT NULL,
  `version` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `code_type` varchar(200) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`),
  KEY `store` (`store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_delivery_method`
--

DROP TABLE IF EXISTS `coupon_delivery_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_delivery_method` (
  `store` char(36) CHARACTER SET latin1 NOT NULL,
  `delivery_method` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_delivery_type`
--

DROP TABLE IF EXISTS `coupon_delivery_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_delivery_type` (
  `coupon_delivery_type` varchar(20) CHARACTER SET latin1 NOT NULL,
  `priority` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_keywords_lang_list`
--

DROP TABLE IF EXISTS `coupon_keywords_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_keywords_lang_list` (
  `coupon` char(36) NOT NULL,
  `keywords_lang_list` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_limit_period_list`
--

DROP TABLE IF EXISTS `coupon_limit_period_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_limit_period_list` (
  `coupon` char(36) NOT NULL,
  `limit_period_list` char(36) NOT NULL,
  PRIMARY KEY (`coupon`,`limit_period_list`),
  KEY `limit_period_list` (`limit_period_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_offer_slogan_lang_list`
--

DROP TABLE IF EXISTS `coupon_offer_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_offer_slogan_lang_list` (
  `coupon` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`coupon`,`offer_slogan_lang_list`),
  KEY `sub_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_offer_title_lang_list`
--

DROP TABLE IF EXISTS `coupon_offer_title_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_offer_title_lang_list` (
  `coupon` char(36) NOT NULL,
  `offer_title_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`coupon`,`offer_title_lang_list`),
  KEY `offer_title_lang_list` (`offer_title_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_usage_statistics`
--

DROP TABLE IF EXISTS `coupon_usage_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usage_statistics` (
  `coupon_id` char(36) NOT NULL,
  `num_consumes` int(11) NOT NULL,
  `num_loads` int(11) NOT NULL,
  `num_views` int(11) NOT NULL,
  `store_id` char(36) NOT NULL,
  `sum_consume_dist_to_store` int(11) NOT NULL,
  `sum_load_dist_to_store` int(11) NOT NULL,
  `sum_view_dist_to_store` int(11) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupon_usage_statistics_history`
--

DROP TABLE IF EXISTS `coupon_usage_statistics_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usage_statistics_history` (
  `coupon_id` char(36) NOT NULL,
  `num_consumes` int(11) NOT NULL,
  `num_loads` int(11) NOT NULL,
  `num_views` int(11) NOT NULL,
  `store_id` char(36) NOT NULL,
  `sum_consume_dist_to_store` int(11) NOT NULL,
  `sum_load_dist_to_store` int(11) NOT NULL,
  `sum_view_dist_to_store` int(11) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `employer`
--

DROP TABLE IF EXISTS `employer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employer` (
  `company_id` char(36) NOT NULL,
  `u_id` char(36) NOT NULL,
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `financial_exception`
--

DROP TABLE IF EXISTS `financial_exception`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_exception` (
  `partner_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `in_stock`
--

DROP TABLE IF EXISTS `in_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `in_stock` (
  `store_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `product_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `in_stock` int(20) NOT NULL,
  `amount_in_stock` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lang_text`
--

DROP TABLE IF EXISTS `lang_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lang_text` (
  `id` char(36) NOT NULL,
  `lang` varchar(3) NOT NULL,
  `text` varchar(300) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `limit_period`
--

DROP TABLE IF EXISTS `limit_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limit_period` (
  `limit_id` char(36) NOT NULL,
  `end_time` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `valid_day` varchar(255) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`limit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partner`
--

DROP TABLE IF EXISTS `partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner` (
  `partner_id` char(36) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `orgnr` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `product_id` char(36) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `brand_name` varchar(100) NOT NULL,
  `small_image` varchar(255) NOT NULL,
  `large_image` varchar(255) NOT NULL,
  `category` char(36) NOT NULL,
  `start_of_publishing` datetime NOT NULL,
  `is_sponsored` tinyint(1) NOT NULL COMMENT '0=No, 1= Yes',
  `coupon_delivery_type` varchar(255) NOT NULL,
  `offer_type` tinyint(3) NOT NULL,
  `product_info_page` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `is_public` tinyint(1) NOT NULL COMMENT '0=No, 1= Yes',
  `ean_code` int(11) DEFAULT NULL,
  `product_number` varchar(255) DEFAULT NULL,
  `u_id` char(36) NOT NULL,
  `company_id` char(36) NOT NULL,
  `s_activ` tinyint(4) NOT NULL COMMENT '0=Active, 2=Deleted',
  `reseller_status` char(1) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_keyword`
--

DROP TABLE IF EXISTS `product_keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_keyword` (
  `product_id` char(36) NOT NULL,
  `offer_keyword` char(36) NOT NULL,
  `system_key` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_offer_slogan_lang_list`
--

DROP TABLE IF EXISTS `product_offer_slogan_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_offer_slogan_lang_list` (
  `product_id` char(36) NOT NULL,
  `offer_slogan_lang_list` char(36) NOT NULL,
  PRIMARY KEY (`product_id`,`offer_slogan_lang_list`),
  KEY `offer_slogan_lang_list` (`offer_slogan_lang_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_price_list`
--

DROP TABLE IF EXISTS `product_price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_price_list` (
  `product_id` char(36) NOT NULL,
  `store_id` char(36) NOT NULL,
  `text` varchar(300) NOT NULL,
  `lang` char(3) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reselleragrement`
--

DROP TABLE IF EXISTS `reselleragrement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reselleragrement` (
  `u_id` char(36) NOT NULL,
  `store_email` varchar(255) NOT NULL,
  `store_mphone` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `raddr` varchar(255) DEFAULT NULL,
  `auth_metode` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store` (
  `store_id` char(36) NOT NULL,
  `u_id` char(36) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_code` varchar(2) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `store_link` varchar(255) DEFAULT NULL,
  `s_activ` tinyint(1) DEFAULT NULL COMMENT '1=Active, 2=Deleted',
  `version` int(11) DEFAULT NULL,
  `access_type` tinyint(4) NOT NULL COMMENT '0=public, 1=private',
  `chain` varchar(256) NOT NULL,
  `block` varchar(256) NOT NULL,
  `zip` varchar(255) NOT NULL,
  PRIMARY KEY (`store_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transaction_receipt`
--

DROP TABLE IF EXISTS `transaction_receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_receipt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_id` char(36) NOT NULL,
  `coupon_id` char(36) NOT NULL,
  `partner_id` char(36) DEFAULT NULL,
  `partner_ref` char(100) DEFAULT NULL,
  `purchase_time` datetime NOT NULL,
  `store_id` char(36) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transaction_receipt_history`
--

DROP TABLE IF EXISTS `transaction_receipt_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_receipt_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_id` char(40) NOT NULL,
  `coupon_id` char(36) NOT NULL,
  `partner_id` char(36) DEFAULT NULL,
  `partner_ref` char(100) DEFAULT NULL,
  `purchase_time` datetime NOT NULL,
  `store_id` char(36) NOT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `u_id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` char(64) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `role` varchar(16) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile_phone` int(11) DEFAULT NULL,
  `saddr` varchar(255) DEFAULT NULL,
  `street_addr` varchar(255) DEFAULT NULL,
  `city_addr` varchar(255) DEFAULT NULL,
  `home_zip` varchar(255) DEFAULT NULL,
  `country` varchar(5) DEFAULT NULL,
  `caddr` varchar(255) DEFAULT NULL,
  `resellers_bank` varchar(255) DEFAULT NULL,
  `social_number` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company_id` char(36) DEFAULT NULL,
  `activ` tinyint(1) DEFAULT NULL,
  `temp` varchar(255) NOT NULL,
  `email_varify_code` varchar(255) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_activity`
--

DROP TABLE IF EXISTS `user_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_activity` (
  `id` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `support_user_id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT '0' COMMENT '0:Normal User,1:Support User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_support`
--

DROP TABLE IF EXISTS `user_support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_support` (
  `u_id` varchar(36) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `passwd` char(64) CHARACTER SET latin1 NOT NULL,
  `fname` varchar(50) CHARACTER SET latin1 NOT NULL,
  `lname` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-19 16:58:04
