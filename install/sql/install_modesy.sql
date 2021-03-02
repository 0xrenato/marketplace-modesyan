-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 28, 2021 at 07:22 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `install_modesy`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuse_reports`
--

CREATE TABLE `abuse_reports` (
  `id` int(11) NOT NULL,
  `item_type` varchar(30) DEFAULT 'product',
  `item_id` int(11) DEFAULT NULL,
  `report_user_id` int(11) DEFAULT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ad_spaces`
--

CREATE TABLE `ad_spaces` (
  `id` tinyint(4) NOT NULL,
  `ad_space` text DEFAULT NULL,
  `ad_code_728` text DEFAULT NULL,
  `ad_code_468` text DEFAULT NULL,
  `ad_code_300` text DEFAULT NULL,
  `ad_code_250` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_spaces`
--

INSERT INTO `ad_spaces` (`id`, `ad_space`, `ad_code_728`, `ad_code_468`, `ad_code_300`, `ad_code_250`) VALUES
(1, 'index_1', NULL, NULL, NULL, ''),
(2, 'index_2', NULL, NULL, NULL, ''),
(3, 'products', NULL, NULL, NULL, ''),
(4, 'products_sidebar', NULL, NULL, NULL, ''),
(5, 'product', NULL, NULL, NULL, ''),
(6, 'product_bottom', NULL, NULL, NULL, ''),
(7, 'profile', NULL, NULL, NULL, ''),
(8, 'profile_sidebar', NULL, NULL, NULL, ''),
(9, 'blog_1', NULL, NULL, NULL, ''),
(10, 'blog_2', NULL, NULL, NULL, ''),
(11, 'blog_post_details', NULL, NULL, NULL, ''),
(12, 'blog_post_details_sidebar', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `bank_transfers`
--

CREATE TABLE `bank_transfers` (
  `id` int(11) NOT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `payment_note` varchar(500) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `category_order` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_images`
--

CREATE TABLE `blog_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_path_thumb` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `image_default` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `parent_tree` varchar(255) DEFAULT NULL,
  `title_meta_tag` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `category_order` mediumint(9) DEFAULT 0,
  `featured_order` mediumint(9) DEFAULT 1,
  `homepage_order` mediumint(9) DEFAULT 1,
  `visibility` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `show_products_on_index` tinyint(1) DEFAULT 0,
  `show_subcategory_products` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local',
  `image` varchar(255) DEFAULT NULL,
  `show_image_on_navigation` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories_lang`
--

CREATE TABLE `categories_lang` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversation_messages`
--

CREATE TABLE `conversation_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` varchar(10000) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `currency_format` varchar(30) DEFAULT 'us',
  `symbol_direction` varchar(30) DEFAULT 'left',
  `space_money_symbol` tinyint(1) DEFAULT 0,
  `exchange_rate` double DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `field_type` varchar(20) DEFAULT NULL,
  `row_width` varchar(20) DEFAULT 'half',
  `is_required` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `field_order` int(11) DEFAULT 1,
  `is_product_filter` tinyint(1) DEFAULT 0,
  `product_filter_key` varchar(255) DEFAULT NULL,
  `sort_options` varchar(30) DEFAULT 'alphabetically'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_category`
--

CREATE TABLE `custom_fields_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_options`
--

CREATE TABLE `custom_fields_options` (
  `id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `option_key` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_options_lang`
--

CREATE TABLE `custom_fields_options_lang` (
  `id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `option_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields_product`
--

CREATE TABLE `custom_fields_product` (
  `id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_filter_key` varchar(255) DEFAULT NULL,
  `field_value` varchar(1000) DEFAULT NULL,
  `selected_option_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `digital_files`
--

CREATE TABLE `digital_files` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `digital_sales`
--

CREATE TABLE `digital_sales` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `license_key` varchar(255) DEFAULT NULL,
  `purchase_code` varchar(100) NOT NULL,
  `currency` varchar(20) NOT NULL DEFAULT 'USD',
  `price` bigint(20) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(11) NOT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `order_product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `commission_rate` tinyint(4) DEFAULT NULL,
  `shipping_cost` bigint(20) DEFAULT NULL,
  `earned_amount` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `exchange_rate` double DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `font_name` varchar(255) DEFAULT NULL,
  `font_url` varchar(2000) DEFAULT NULL,
  `font_family` varchar(500) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `font_url`, `font_family`, `is_default`) VALUES
(1, 'Arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 1),
(2, 'Arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 0),
(3, 'Averia Libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 0),
(4, 'Bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 0),
(5, 'Cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 0),
(6, 'Cherry Swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 0),
(7, 'Encode Sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 0),
(8, 'Helvetica', NULL, 'font-family: Helvetica, sans-serif', 1),
(9, 'Hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 0),
(10, 'Josefin Sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 0),
(11, 'Kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 0),
(12, 'Khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 0),
(13, 'Lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 0),
(14, 'Lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 0),
(15, 'Merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 0),
(16, 'Montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 0),
(17, 'Mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 0),
(18, 'Nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 0),
(19, 'Open Sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 0),
(20, 'Oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 0),
(21, 'Oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 0),
(22, 'Poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Poppins\", Helvetica, sans-serif', 0),
(23, 'PT Sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 0),
(24, 'Raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 0),
(25, 'Roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 0),
(26, 'Roboto Condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 0),
(27, 'Roboto Slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 0),
(28, 'Rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 0),
(29, 'Source Sans Pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 0),
(30, 'Titillium Web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 0),
(31, 'Ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 0),
(32, 'Verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 1),
(33, 'Work Sans', '<link href=\"https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\"> ', 'font-family: \"Work Sans\", Helvetica, sans-serif', 0),
(34, 'Libre Baskerville', '<link href=\"https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i&display=swap&subset=latin-ext\" rel=\"stylesheet\"> ', 'font-family: \"Libre Baskerville\", Helvetica, sans-serif', 0),
(35, 'Signika', '<link href=\"https://fonts.googleapis.com/css2?family=Signika:wght@300;400;600;700&display=swap\" rel=\"stylesheet\">', 'font-family: \'Signika\', sans-serif;', 0),
(36, 'Tajawal', '<link href=\"https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap\" rel=\"stylesheet\">', 'font-family: \'Tajawal\', sans-serif;', 0);

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `physical_products_system` tinyint(1) DEFAULT 1,
  `digital_products_system` tinyint(1) DEFAULT 1,
  `marketplace_system` tinyint(1) DEFAULT 1,
  `classified_ads_system` tinyint(1) DEFAULT 1,
  `bidding_system` tinyint(1) DEFAULT 1,
  `selling_license_keys_system` tinyint(1) DEFAULT 1,
  `multi_vendor_system` tinyint(1) DEFAULT 1,
  `membership_plans_system` tinyint(1) DEFAULT 0,
  `vat_status` tinyint(1) DEFAULT 1,
  `site_lang` tinyint(4) DEFAULT 1,
  `timezone` varchar(100) DEFAULT 'America/New_York',
  `application_name` varchar(255) DEFAULT NULL,
  `selected_navigation` tinyint(4) DEFAULT 1,
  `menu_limit` tinyint(4) DEFAULT 9,
  `recaptcha_site_key` varchar(500) DEFAULT NULL,
  `recaptcha_secret_key` varchar(500) DEFAULT NULL,
  `recaptcha_lang` varchar(30) DEFAULT NULL,
  `custom_css_codes` mediumtext DEFAULT NULL,
  `custom_javascript_codes` mediumtext DEFAULT NULL,
  `mail_library` varchar(50) DEFAULT 'swift',
  `mail_protocol` varchar(20) DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(20) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_title` varchar(255) DEFAULT NULL,
  `email_verification` tinyint(1) DEFAULT 0,
  `facebook_app_id` varchar(500) DEFAULT NULL,
  `facebook_app_secret` varchar(500) DEFAULT NULL,
  `google_client_id` varchar(500) DEFAULT NULL,
  `google_client_secret` varchar(500) DEFAULT NULL,
  `vk_app_id` varchar(500) DEFAULT NULL,
  `vk_secure_key` varchar(500) DEFAULT NULL,
  `google_analytics` text DEFAULT NULL,
  `promoted_products` tinyint(1) DEFAULT 1,
  `multilingual_system` tinyint(1) DEFAULT 1,
  `product_comments` tinyint(1) DEFAULT 1,
  `comment_approval_system` tinyint(1) DEFAULT 0,
  `reviews` tinyint(1) DEFAULT 1,
  `blog_comments` tinyint(1) DEFAULT 1,
  `slider_status` tinyint(4) DEFAULT 1,
  `slider_type` varchar(30) DEFAULT 'full_width',
  `slider_effect` varchar(30) DEFAULT 'fade',
  `featured_categories` tinyint(1) DEFAULT 1,
  `index_promoted_products` tinyint(1) DEFAULT 1,
  `index_promoted_products_count` tinyint(1) DEFAULT 8,
  `index_latest_products` tinyint(1) DEFAULT 1,
  `index_latest_products_count` tinyint(1) DEFAULT 4,
  `index_blog_slider` tinyint(1) DEFAULT 1,
  `product_link_structure` varchar(20) DEFAULT 'slug-id',
  `mds_key` varchar(500) DEFAULT NULL,
  `purchase_code` varchar(500) DEFAULT NULL,
  `site_color` varchar(100) DEFAULT 'default',
  `logo` varchar(255) DEFAULT NULL,
  `logo_email` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `watermark_image_large` varchar(255) DEFAULT NULL,
  `watermark_image_mid` varchar(255) DEFAULT NULL,
  `watermark_image_small` varchar(255) DEFAULT NULL,
  `watermark_vrt_alignment` varchar(20) DEFAULT 'middle',
  `watermark_hor_alignment` varchar(20) DEFAULT 'center',
  `watermark_product_images` tinyint(1) DEFAULT 0,
  `watermark_blog_images` tinyint(1) DEFAULT 0,
  `watermark_thumbnail_images` tinyint(1) DEFAULT 0,
  `facebook_comment` text DEFAULT NULL,
  `facebook_comment_status` tinyint(1) DEFAULT 0,
  `product_cache_system` tinyint(1) DEFAULT 0,
  `static_content_cache_system` tinyint(1) DEFAULT 0,
  `refresh_cache_database_changes` tinyint(1) DEFAULT 0,
  `cache_refresh_time` int(11) DEFAULT 1800,
  `rss_system` tinyint(1) DEFAULT 1,
  `approve_before_publishing` tinyint(1) DEFAULT 1,
  `commission_rate` tinyint(4) DEFAULT 0,
  `send_email_new_product` tinyint(1) DEFAULT 0,
  `send_email_buyer_purchase` tinyint(1) DEFAULT 0,
  `send_email_contact_messages` tinyint(1) DEFAULT 0,
  `send_email_order_shipped` tinyint(1) DEFAULT 0,
  `send_email_shop_opening_request` tinyint(1) DEFAULT 0,
  `send_email_bidding_system` tinyint(1) DEFAULT 0,
  `mail_options_account` varchar(100) DEFAULT NULL,
  `vendor_verification_system` tinyint(1) DEFAULT 1,
  `hide_vendor_contact_information` tinyint(1) DEFAULT 0,
  `guest_checkout` tinyint(1) DEFAULT 0,
  `maintenance_mode_title` varchar(500) DEFAULT NULL,
  `maintenance_mode_description` varchar(2000) DEFAULT NULL,
  `maintenance_mode_status` tinyint(1) DEFAULT 0,
  `max_file_size_image` bigint(20) DEFAULT 10485760,
  `max_file_size_video` bigint(20) DEFAULT 31457280,
  `max_file_size_audio` bigint(20) DEFAULT 10485760,
  `google_adsense_code` varchar(2000) DEFAULT NULL,
  `sort_categories` varchar(30) DEFAULT 'category_order',
  `sort_parent_categories_by_order` tinyint(1) DEFAULT 1,
  `pwa_status` tinyint(1) DEFAULT 0,
  `location_search_header` tinyint(1) DEFAULT 1,
  `vendor_bulk_product_upload` tinyint(1) DEFAULT 1,
  `show_sold_products` tinyint(1) DEFAULT 1,
  `last_cron_update` timestamp NULL DEFAULT NULL,
  `last_cron_update_long` timestamp NULL DEFAULT NULL,
  `version` varchar(30) DEFAULT '1.6.2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `physical_products_system`, `digital_products_system`, `marketplace_system`, `classified_ads_system`, `bidding_system`, `selling_license_keys_system`, `multi_vendor_system`, `membership_plans_system`, `vat_status`, `site_lang`, `timezone`, `application_name`, `selected_navigation`, `menu_limit`, `recaptcha_site_key`, `recaptcha_secret_key`, `recaptcha_lang`, `custom_css_codes`, `custom_javascript_codes`, `mail_library`, `mail_protocol`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_title`, `email_verification`, `facebook_app_id`, `facebook_app_secret`, `google_client_id`, `google_client_secret`, `vk_app_id`, `vk_secure_key`, `google_analytics`, `promoted_products`, `multilingual_system`, `product_comments`, `comment_approval_system`, `reviews`, `blog_comments`, `slider_status`, `slider_type`, `slider_effect`, `featured_categories`, `index_promoted_products`, `index_promoted_products_count`, `index_latest_products`, `index_latest_products_count`, `index_blog_slider`, `product_link_structure`, `mds_key`, `purchase_code`, `site_color`, `logo`, `logo_email`, `favicon`, `watermark_image_large`, `watermark_image_mid`, `watermark_image_small`, `watermark_vrt_alignment`, `watermark_hor_alignment`, `watermark_product_images`, `watermark_blog_images`, `watermark_thumbnail_images`, `facebook_comment`, `facebook_comment_status`, `product_cache_system`, `static_content_cache_system`, `refresh_cache_database_changes`, `cache_refresh_time`, `rss_system`, `approve_before_publishing`, `commission_rate`, `send_email_new_product`, `send_email_buyer_purchase`, `send_email_contact_messages`, `send_email_order_shipped`, `send_email_shop_opening_request`, `send_email_bidding_system`, `mail_options_account`, `vendor_verification_system`, `hide_vendor_contact_information`, `guest_checkout`, `maintenance_mode_title`, `maintenance_mode_description`, `maintenance_mode_status`, `max_file_size_image`, `max_file_size_video`, `max_file_size_audio`, `google_adsense_code`, `sort_categories`, `sort_parent_categories_by_order`, `pwa_status`, `location_search_header`, `vendor_bulk_product_upload`, `show_sold_products`, `last_cron_update`, `last_cron_update_long`, `version`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 'America/New_York', 'Modesy', 1, 7, '', '', 'en', '', '', 'swift', 'smtp', NULL, '587', NULL, NULL, 'Modesy', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 'full_width', 'fade', 1, 1, 10, 1, 10, 1, 'slug-id', NULL, NULL, '#222222', NULL, NULL, NULL, NULL, NULL, NULL, 'middle', 'center', 0, 0, 0, NULL, 0, 0, 0, 0, 1800, 1, 1, 10, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, 'Coming Soon', 'Our website is under construction. We\'ll be here soon with our new awesome site.', 0, 5242880, 31457280, 31457280, '', 'category_order', 1, 0, 1, 1, 1, '2021-02-20 14:16:13', '2021-02-20 11:13:12', '1.8');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_banners`
--

CREATE TABLE `homepage_banners` (
  `id` int(11) NOT NULL,
  `banner_url` varchar(1000) DEFAULT NULL,
  `banner_image_path` varchar(255) DEFAULT NULL,
  `banner_order` int(11) NOT NULL DEFAULT 1,
  `banner_width` double DEFAULT NULL,
  `banner_location` varchar(100) DEFAULT 'featured_products'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_default` varchar(255) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images_file_manager`
--

CREATE TABLE `images_file_manager` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images_variation`
--

CREATE TABLE `images_variation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_option_id` int(11) DEFAULT 0,
  `image_default` varchar(255) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `client_username` varchar(255) DEFAULT NULL,
  `client_first_name` varchar(100) DEFAULT NULL,
  `client_last_name` varchar(100) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_phone_number` varchar(100) DEFAULT NULL,
  `client_address` varchar(500) DEFAULT NULL,
  `client_country` varchar(100) DEFAULT NULL,
  `client_state` varchar(100) DEFAULT NULL,
  `client_city` varchar(100) DEFAULT NULL,
  `invoice_items` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_form` varchar(20) NOT NULL,
  `language_code` varchar(20) NOT NULL,
  `text_direction` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `language_order` tinyint(4) NOT NULL DEFAULT 1,
  `text_editor_lang` varchar(10) DEFAULT 'en',
  `flag_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_form`, `language_code`, `text_direction`, `status`, `language_order`, `text_editor_lang`, `flag_path`) VALUES
(1, 'English', 'en', 'en-US', 'ltr', 1, 1, 'en', 'uploads/blocks/flag_eng.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `language_translations`
--

CREATE TABLE `language_translations` (
  `id` int(11) NOT NULL,
  `lang_id` smallint(6) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `translation` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language_translations`
--

INSERT INTO `language_translations` (`id`, `lang_id`, `label`, `translation`) VALUES
(1, 1, 'digital_exp', 'A digital file that buyers will download'),
(2, 1, 'email_text_new_product', 'A new product has been added'),
(3, 1, 'physical_exp', 'A tangible product that you will ship to buyers'),
(4, 1, 'time_limit_for_plan', 'A time limit for the plan'),
(5, 1, 'accept_quote', 'Accept Quote'),
(6, 1, 'activate_all', 'Activate All'),
(7, 1, 'active', 'Active'),
(8, 1, 'active_orders', 'Active Orders'),
(9, 1, 'active_sales', 'Active Sales'),
(10, 1, 'ad_spaces', 'Ad Spaces'),
(11, 1, 'add_a_comment', 'Add a comment'),
(12, 1, 'demo_url_exp', 'Add a preview URL (i.e. https://demo.com)'),
(13, 1, 'add_product_for_sale', 'Add a Product for Sale'),
(14, 1, 'add_product_services_listing', 'Add a Product or Service as an Ordinary Listing'),
(15, 1, 'add_product_services_listing_exp', 'Add a product or service without buy option'),
(16, 1, 'add_product_get_price_requests', 'Add a Product to Receive Quote (Price) Requests'),
(17, 1, 'add_product_for_sale_exp', 'Add a product to sell on the site'),
(18, 1, 'add_product_get_price_requests_exp', 'Add a product without adding a price to get price requests from customers'),
(19, 1, 'add_administrator', 'Add Administrator'),
(20, 1, 'add_license_keys_exp', 'Add all license keys with comma(,) separator. (i.e. License Key, License Key...)'),
(21, 1, 'variations_exp', 'Add available options, like color or size that buyers can choose during checkout'),
(22, 1, 'add_banner', 'Add Banner'),
(23, 1, 'add_category', 'Add Category'),
(24, 1, 'add_city', 'Add City'),
(25, 1, 'add_country', 'Add Country'),
(26, 1, 'add_currency', 'Add Currency'),
(27, 1, 'add_custom_field', 'Add Custom Field'),
(28, 1, 'add_feature', 'Add Feature'),
(29, 1, 'add_font', 'Add Font'),
(30, 1, 'add_image', 'Add Image'),
(31, 1, 'add_language', 'Add Language'),
(32, 1, 'add_license_keys', 'Add License Keys'),
(33, 1, 'add_option', 'Add Option'),
(34, 1, 'add_page', 'Add Page'),
(35, 1, 'add_payout', 'Add Payout'),
(36, 1, 'add_post', 'Add Post'),
(37, 1, 'add_product', 'Add Product'),
(38, 1, 'add_review', 'Add Review'),
(39, 1, 'add_shipping_option', 'Add Shipping Option'),
(40, 1, 'add_slider_item', 'Add Slider Item'),
(41, 1, 'add_space_between_money_currency', 'Add Space Between Money and Currency'),
(42, 1, 'add_state', 'Add State'),
(43, 1, 'add_to_cart', 'Add to Cart'),
(44, 1, 'add_to_featured', 'Add to Featured'),
(45, 1, 'add_to_product_filters', 'Add to Product Filters'),
(46, 1, 'add_to_special_offers', 'Add to Special Offers'),
(47, 1, 'add_to_wishlist', 'Add to wishlist'),
(48, 1, 'add_variation', 'Add Variation'),
(49, 1, 'add_video', 'Add Video'),
(50, 1, 'add_watermark_blog_images', 'Add Watermark to Blog Images'),
(51, 1, 'add_watermark_product_images', 'Add Watermark to Product Images'),
(52, 1, 'add_watermark_thumbnail_images', 'Add Watermark to Thumbnail (Small) Images'),
(53, 1, 'additional_information', 'Additional Information'),
(54, 1, 'address', 'Address'),
(55, 1, 'admin_emails_will_send', 'Admin emails will be sent to this address'),
(56, 1, 'admin_panel', 'Admin Panel'),
(57, 1, 'admin_panel_link', 'Admin Panel Link'),
(58, 1, 'msg_administrator_added', 'Administrator successfully added!'),
(59, 1, 'administrators', 'Administrators'),
(60, 1, 'cache_refresh_time_exp', 'After this time, your cache files will be refreshed.'),
(61, 1, 'all', 'All'),
(62, 1, 'invoice_currency_warning', 'All amounts shown on this invoice are in'),
(63, 1, 'msg_reset_cache', 'All cache files have been deleted!'),
(64, 1, 'categories_all', 'All Categories'),
(65, 1, 'allow_all_currencies_classified_ads', 'Allow All Currencies for Ordinary Listing'),
(66, 1, 'allow_duplicate_license_keys', 'Allow Duplicate License Keys'),
(67, 1, 'allowed_file_extensions', 'Allowed File Extensions'),
(68, 1, 'alphabetically', 'Alphabetically'),
(69, 1, 'always', 'Always'),
(70, 1, 'msg_send_confirmation_email', 'An activation email has been sent to your email address. Please confirm your account.'),
(71, 1, 'msg_payment_error', 'An error occurred during the payment!'),
(72, 1, 'msg_error', 'An error occurred please try again!'),
(73, 1, 'animations', 'Animations'),
(74, 1, 'api_key', 'Api Key'),
(75, 1, 'app_id', 'App ID'),
(76, 1, 'app_secret', 'App Secret'),
(77, 1, 'appear_on_homepage', 'Appear on the Homepage'),
(78, 1, 'app_name', 'Application Name'),
(79, 1, 'approve', 'Approve'),
(80, 1, 'approve_before_publishing', 'Approve Products Before Publishing'),
(81, 1, 'approved', 'Approved'),
(82, 1, 'approved_comments', 'Approved Comments'),
(83, 1, 'balance_exp', 'Approved earnings'),
(84, 1, 'april', 'April'),
(85, 1, 'confirm_close_user_shop', 'Are you sure you want to close this shop?'),
(86, 1, 'confirm_approve_order', 'Are you sure you want to confirm this order?'),
(87, 1, 'confirm_comments', 'Are you sure you want to delete selected comments?'),
(88, 1, 'confirm_messages', 'Are you sure you want to delete selected conversations?'),
(89, 1, 'confirm_products', 'Are you sure you want to delete selected products?'),
(90, 1, 'confirm_reviews', 'Are you sure you want to delete selected reviews?'),
(91, 1, 'confirm_product_audio', 'Are you sure you want to delete this audio?'),
(92, 1, 'confirm_category', 'Are you sure you want to delete this category?'),
(93, 1, 'confirm_comment', 'Are you sure you want to delete this comment?'),
(94, 1, 'confirm_message', 'Are you sure you want to delete this conversation?'),
(95, 1, 'confirm_custom_field', 'Are you sure you want to delete this custom field?'),
(96, 1, 'confirm_delete', 'Are you sure you want to delete this item?'),
(97, 1, 'confirm_language', 'Are you sure you want to delete this language?'),
(98, 1, 'confirm_option', 'Are you sure you want to delete this option?'),
(99, 1, 'confirm_page', 'Are you sure you want to delete this page?'),
(100, 1, 'confirm_post', 'Are you sure you want to delete this post?'),
(101, 1, 'confirm_product', 'Are you sure you want to delete this product?'),
(102, 1, 'confirm_quote_request', 'Are you sure you want to delete this quote request?'),
(103, 1, 'confirm_review', 'Are you sure you want to delete this review?'),
(104, 1, 'confirm_slider_item', 'Are you sure you want to delete this slider item?'),
(105, 1, 'confirm_subscriber', 'Are you sure you want to delete this subscriber?'),
(106, 1, 'confirm_user', 'Are you sure you want to delete this user?'),
(107, 1, 'confirm_variation', 'Are you sure you want to delete this variation?'),
(108, 1, 'confirm_product_video', 'Are you sure you want to delete this video?'),
(109, 1, 'confirm_product_permanent', 'Are you sure you want to permanently delete this product?'),
(110, 1, 'msg_accept_bank_transfer', 'Are you sure you want to set this order as payment received?'),
(111, 1, 'ask_question', 'Ask Question'),
(112, 1, 'audio', 'Audio'),
(113, 1, 'audio_preview', 'Audio Preview'),
(114, 1, 'august', 'August'),
(115, 1, 'priority_none', 'Automatically Calculated Priority'),
(116, 1, 'awaiting_payment', 'Awaiting Payment'),
(117, 1, 'awaiting_sellers_bid', 'Awaiting Seller\'s Bid'),
(118, 1, 'aws_key', 'AWS Access Key'),
(119, 1, 'aws_base_url', 'AWS Base URL'),
(120, 1, 'aws_storage', 'AWS S3 Storage'),
(121, 1, 'aws_secret', 'AWS Secret Key'),
(122, 1, 'back', 'Back'),
(123, 1, 'backward', 'Backward'),
(124, 1, 'balance', 'Balance'),
(125, 1, 'ban_user', 'Ban User'),
(126, 1, 'bank_account_holder_name', 'Bank Account Holder\'s Name'),
(127, 1, 'swift_iban', 'Bank Account Number/IBAN'),
(128, 1, 'bank_accounts', 'Bank Accounts'),
(129, 1, 'bank_branch_city', 'Bank Branch City'),
(130, 1, 'bank_branch_country', 'Bank Branch Country'),
(131, 1, 'bank_name', 'Bank Name'),
(132, 1, 'bank_transfer', 'Bank Transfer'),
(133, 1, 'bank_transfer_accepted', 'Bank transfer accepted'),
(134, 1, 'bank_transfer_declined', 'Bank transfer declined'),
(135, 1, 'bank_transfer_notifications', 'Bank Transfers Notifications'),
(136, 1, 'banned', 'Banned'),
(137, 1, 'banner', 'Banner'),
(138, 1, 'banner_width', 'Banner Width'),
(139, 1, 'bidding_system', 'Bidding System'),
(140, 1, 'bidding_system_request_quote', 'Bidding System (Request Quote)'),
(141, 1, 'bidding_system_emails', 'Bidding system emails'),
(142, 1, 'billing_address', 'Billing Address'),
(143, 1, 'blog', 'Blog'),
(144, 1, 'blog_ad_space_1', 'Blog Ad Space 1'),
(145, 1, 'blog_ad_space_2', 'Blog Ad Space 2'),
(146, 1, 'blog_comments', 'Blog Comments'),
(147, 1, 'blog_post_details_ad_space', 'Blog Post Details Ad Space'),
(148, 1, 'blog_post_details_sidebar_ad_space', 'Blog Post Details Sidebar Ad Space'),
(149, 1, 'blog_posts', 'Blog Posts'),
(150, 1, 'blog_slider', 'Blog Slider'),
(151, 1, 'bottom', 'Bottom'),
(152, 1, 'boxed', 'Boxed'),
(153, 1, 'browse_files', 'Browse Files'),
(154, 1, 'bucket_name', 'Bucket Name'),
(155, 1, 'bulk_category_upload', 'Bulk Category Upload'),
(156, 1, 'bulk_product_upload', 'Bulk Product Upload'),
(157, 1, 'button', 'Button'),
(158, 1, 'button_color', 'Button Color'),
(159, 1, 'button_text', 'Button Text'),
(160, 1, 'button_text_color', 'Button Text Color'),
(161, 1, 'buy_button_link', 'Buy button link'),
(162, 1, 'buy_now', 'Buy Now'),
(163, 1, 'buyer', 'Buyer'),
(164, 1, 'by', 'By'),
(165, 1, 'by_category_order', 'by Category Order'),
(166, 1, 'by_date', 'by Date'),
(167, 1, 'cache_refresh_time', 'Cache Refresh Time (Minute)'),
(168, 1, 'cache_system', 'Cache System'),
(169, 1, 'calculated_price', 'Calculated Price'),
(170, 1, 'cancel', 'Cancel'),
(171, 1, 'cancelled', 'Cancelled'),
(172, 1, 'card_number', 'Card Number'),
(173, 1, 'cart', 'Cart'),
(174, 1, 'cash_on_delivery', 'Cash on Delivery'),
(175, 1, 'categories', 'Categories'),
(176, 1, 'category', 'Category'),
(177, 1, 'category_id_finder', 'Category Id Finder'),
(178, 1, 'category_level', 'Category Level'),
(179, 1, 'category_name', 'Category Name'),
(180, 1, 'msg_category_added', 'Category successfully added!'),
(181, 1, 'msg_category_deleted', 'Category successfully deleted!'),
(182, 1, 'cell_phone', 'Cell Phone'),
(183, 1, 'center', 'Center'),
(184, 1, 'change_password', 'Change Password'),
(185, 1, 'msg_updated', 'Changes successfully saved!'),
(186, 1, 'checkbox', 'Checkbox (Multiple Selection)'),
(187, 1, 'checkout', 'Checkout'),
(188, 1, 'choose_plan', 'Choose Plan'),
(189, 1, 'cities', 'Cities'),
(190, 1, 'city', 'City'),
(191, 1, 'classified_ads_adding_product_as_listing', 'Classified Ads (Adding a Product or Service as an Ordinary Listing)'),
(192, 1, 'clear', 'Clear'),
(193, 1, 'email_text_see_product', 'Click the button below to see the product.'),
(194, 1, 'client_id', 'Client ID'),
(195, 1, 'client_information', 'Client Information'),
(196, 1, 'client_secret', 'Client Secret'),
(197, 1, 'close', 'Close'),
(198, 1, 'close_user_shop', 'Close User Shop'),
(199, 1, 'closed', 'Closed'),
(200, 1, 'color', 'Color'),
(201, 1, 'comment', 'Comment'),
(202, 1, 'comment_approval_system', 'Comment Approval System'),
(203, 1, 'msg_comment_approved', 'Comment successfully approved!'),
(204, 1, 'msg_comment_deleted', 'Comment successfully deleted!'),
(205, 1, 'comments', 'Comments'),
(206, 1, 'commission_rate', 'Commission Rate'),
(207, 1, 'completed', 'Completed'),
(208, 1, 'completed_orders', 'Completed Orders'),
(209, 1, 'completed_payouts', 'Completed Payouts'),
(210, 1, 'completed_sales', 'Completed Sales'),
(211, 1, 'confirm_user_email', 'Confirm Email'),
(212, 1, 'confirm_order_received_exp', 'Confirm if you have received your order.'),
(213, 1, 'confirm_order_received', 'Confirm Order Received'),
(214, 1, 'password_confirm', 'Confirm Password'),
(215, 1, 'confirm_payment', 'Confirm Payment'),
(216, 1, 'confirm_your_account', 'Confirm Your Account'),
(217, 1, 'confirmed', 'Confirmed'),
(218, 1, 'connect_with_facebook', 'Connect with Facebook'),
(219, 1, 'connect_with_google', 'Connect with Google'),
(220, 1, 'connect_with_vk', 'Connect with VKontakte'),
(221, 1, 'contact', 'Contact'),
(222, 1, 'contact_message', 'Contact Message'),
(223, 1, 'contact_messages', 'Contact Messages'),
(224, 1, 'contact_settings', 'Contact Settings'),
(225, 1, 'contact_text', 'Contact Text'),
(226, 1, 'content', 'Content'),
(227, 1, 'continue_to_checkout', 'Continue to Checkout'),
(228, 1, 'continue_to_payment', 'Continue to Payment'),
(229, 1, 'continue_to_payment_method', 'Continue to Payment Method'),
(230, 1, 'cookies_warning', 'Cookies Warning'),
(231, 1, 'copyright', 'Copyright'),
(232, 1, 'countries', 'Countries'),
(233, 1, 'country', 'Country'),
(234, 1, 'cpf', 'CPF'),
(235, 1, 'create_new_plan', 'Create a New Plan'),
(236, 1, 'created_variations', 'Created Variations'),
(237, 1, 'credit_card', 'Credit Card'),
(238, 1, 'csv_file', 'CSV File'),
(239, 1, 'currencies', 'Currencies'),
(240, 1, 'currency', 'Currency'),
(241, 1, 'currency_code', 'Currency Code'),
(242, 1, 'currency_format', 'Currency Format'),
(243, 1, 'currency_name', 'Currency Name'),
(244, 1, 'currency_settings', 'Currency Settings'),
(245, 1, 'currency_symbol', 'Currency Symbol'),
(246, 1, 'currency_symbol_format', 'Currency Symbol Format'),
(247, 1, 'current_plan', 'Current Plan'),
(248, 1, 'custom', 'Custom'),
(249, 1, 'custom_css_codes', 'Custom CSS Codes'),
(250, 1, 'custom_field', 'Custom Field'),
(251, 1, 'custom_field_options', 'Custom Field Options'),
(252, 1, 'msg_custom_field_added', 'Custom field successfully added!'),
(253, 1, 'msg_custom_field_deleted', 'Custom field successfully deleted!'),
(254, 1, 'show_under_these_categories', 'Custom field will be displayed under these categories'),
(255, 1, 'custom_fields', 'Custom Fields'),
(256, 1, 'custom_javascript_codes', 'Custom JavaScript Codes'),
(257, 1, 'cvv', 'CVV'),
(258, 1, 'daily', 'Daily'),
(259, 1, 'daily_plan', 'Daily Plan'),
(260, 1, 'dashboard', 'Dashboard'),
(261, 1, 'data_type', 'Data Type'),
(262, 1, 'date', 'Date'),
(263, 1, 'date_of_birth', 'Date of Birth'),
(264, 1, 'day', 'Day'),
(265, 1, 'day_ago', 'day ago'),
(266, 1, 'days', 'Days'),
(267, 1, 'days_ago', 'days ago'),
(268, 1, 'days_left', 'days left'),
(269, 1, 'december', 'December'),
(270, 1, 'decline', 'Decline'),
(271, 1, 'declined', 'Declined'),
(272, 1, 'default', 'Default'),
(273, 1, 'default_currency', 'Default Currency'),
(274, 1, 'default_language', 'Default Language'),
(275, 1, 'msg_default_language_delete', 'Default language cannot be deleted!'),
(276, 1, 'default_option', 'Default Option'),
(277, 1, 'msg_default_page_delete', 'Default pages cannot be deleted!'),
(278, 1, 'delete', 'Delete'),
(279, 1, 'delete_conversation', 'Delete Conversation'),
(280, 1, 'delete_permanently', 'Delete Permanently'),
(281, 1, 'delete_quote', 'Delete Quote'),
(282, 1, 'deleted_products', 'Deleted Products'),
(283, 1, 'demo_url', 'Demo URL'),
(284, 1, 'description', 'Description'),
(285, 1, 'details', 'Details'),
(286, 1, 'digital', 'Digital'),
(287, 1, 'digital_file_required', 'Digital file is required!'),
(288, 1, 'digital_files', 'Digital Files'),
(289, 1, 'digital_products', 'Digital Products'),
(290, 1, 'digital_sales', 'Digital Sales'),
(291, 1, 'disable', 'Disable'),
(292, 1, 'vendor_verification_system_exp', 'Disable if you want to allow all users to add products.'),
(293, 1, 'discount_rate', 'Discount Rate'),
(294, 1, 'documentation', 'Documentation'),
(295, 1, 'dont_have_account', 'Don\'t have an account?'),
(296, 1, 'dont_want_receive_emails', 'Don\'t want receive these emails?'),
(297, 1, 'download', 'Download'),
(298, 1, 'download_csv_example', 'Download CSV Example'),
(299, 1, 'download_csv_template', 'Download CSV Template'),
(300, 1, 'download_sitemap', 'Download Sitemap'),
(301, 1, 'downloads', 'Downloads'),
(302, 1, 'draft', 'Draft'),
(303, 1, 'draft_added', 'Draft added successfully!'),
(304, 1, 'drafts', 'Drafts'),
(305, 1, 'drag_drop_file_here', 'Drag and drop file here or'),
(306, 1, 'drag_drop_images_here', 'Drag and drop images here or'),
(307, 1, 'dropdown', 'Dropdown (Single Selection)'),
(308, 1, 'duration', 'Duration'),
(309, 1, 'earned_amount', 'Earned Amount'),
(310, 1, 'earnings', 'Earnings'),
(311, 1, 'edit', 'Edit'),
(312, 1, 'edit_banner', 'Edit Banner'),
(313, 1, 'edit_details', 'Edit Details'),
(314, 1, 'edit_option', 'Edit Option'),
(315, 1, 'edit_options', 'Edit Options'),
(316, 1, 'edit_plan', 'Edit Plan'),
(317, 1, 'edit_product', 'Edit Product'),
(318, 1, 'edit_translations', 'Edit Translations'),
(319, 1, 'edit_user', 'Edit User'),
(320, 1, 'edit_variation', 'Edit Variation'),
(321, 1, 'effect', 'Effect'),
(322, 1, 'email', 'Email'),
(323, 1, 'email_address', 'Email Address'),
(324, 1, 'email_options', 'Email Options'),
(325, 1, 'email_settings', 'Email Settings'),
(326, 1, 'email_status', 'Email Status'),
(327, 1, 'msg_email_sent', 'Email successfully sent!'),
(328, 1, 'email_template', 'Email Template'),
(329, 1, 'email_verification', 'Email Verification'),
(330, 1, 'enable', 'Enable'),
(331, 1, 'end', 'End'),
(332, 1, 'enter_location', 'Enter Location'),
(333, 1, 'files_included_ext', 'Enter the extensions of the files that you are going to sell (i.e. JPG, MP4, MP3)'),
(334, 1, 'enter_email', 'Enter your email'),
(335, 1, 'reset_password_subtitle', 'Enter your email address'),
(336, 1, 'example', 'Example'),
(337, 1, 'expiration_date', 'Expiration Date (MM / YY)'),
(338, 1, 'expired_products', 'Expired Products'),
(339, 1, 'explanation', 'Explanation'),
(340, 1, 'export', 'Export'),
(341, 1, 'external_link', 'External Link'),
(342, 1, 'facebook_comments', 'Facebook Comments'),
(343, 1, 'facebook_comments_code', 'Facebook Comments Plugin Code'),
(344, 1, 'facebook_login', 'Facebook Login'),
(345, 1, 'facebook_url', 'Facebook URL'),
(346, 1, 'favicon', 'Favicon'),
(347, 1, 'feature', 'Feature'),
(348, 1, 'featured', 'Featured'),
(349, 1, 'featured_badge', 'Featured Badge'),
(350, 1, 'featured_categories', 'Featured Categories'),
(351, 1, 'featured_products', 'Featured Products'),
(352, 1, 'featured_products_payment_currency', 'Featured Products Payment Currency'),
(353, 1, 'featured_products_system', 'Featured Products System'),
(354, 1, 'featured_products_transactions', 'Featured Products Transactions'),
(355, 1, 'features', 'Features'),
(356, 1, 'february', 'February'),
(357, 1, 'field', 'Field'),
(358, 1, 'field_name', 'Field Name'),
(359, 1, 'file_too_large', 'File is too large. Max file size:'),
(360, 1, 'file_upload', 'File Upload'),
(361, 1, 'files_included', 'Files Included'),
(362, 1, 'filter', 'Filter'),
(363, 1, 'filter_products', 'Filter Products'),
(364, 1, 'first_name', 'First Name'),
(365, 1, 'flag', 'Flag'),
(366, 1, 'folder_name', 'Folder Name'),
(367, 1, 'follow', 'Follow'),
(368, 1, 'follow_us', 'Follow Us'),
(369, 1, 'followers', 'Followers'),
(370, 1, 'following', 'Following'),
(371, 1, 'font_family', 'Font Family'),
(372, 1, 'font_settings', 'Font Settings'),
(373, 1, 'fonts', 'Fonts'),
(374, 1, 'footer', 'Footer'),
(375, 1, 'footer_about_section', 'Footer About Section'),
(376, 1, 'forgot_password', 'Forgot Password?'),
(377, 1, 'forward', 'Forward'),
(378, 1, 'free', 'Free'),
(379, 1, 'free_product', 'Free Product'),
(380, 1, 'free_promotion', 'Free Promotion'),
(381, 1, 'frequency', 'Frequency'),
(382, 1, 'friday', 'Friday'),
(383, 1, 'from', 'From:'),
(384, 1, 'full_name', 'Full Name'),
(385, 1, 'full_width', 'Full Width'),
(386, 1, 'general', 'General'),
(387, 1, 'general_information', 'General Information'),
(388, 1, 'general_settings', 'General Settings'),
(389, 1, 'generate', 'Generate'),
(390, 1, 'gmail_smtp', 'Gmail SMTP'),
(391, 1, 'go_back_to_products', 'Go Back to the Products Page'),
(392, 1, 'go_back_to_shop_settings', 'Go Back to the Shop Settings'),
(393, 1, 'goto_home', 'Go to the Homepage'),
(394, 1, 'go_to_your_product', 'Go to Your Product'),
(395, 1, 'google_adsense_code', 'Google Adsense Code'),
(396, 1, 'google_analytics', 'Google Analytics Code'),
(397, 1, 'google_login', 'Google Login'),
(398, 1, 'google_recaptcha', 'Google reCAPTCHA'),
(399, 1, 'google_url', 'Google+ URL'),
(400, 1, 'guest', 'Guest'),
(401, 1, 'guest_checkout', 'Guest Checkout'),
(402, 1, 'half_width', 'Half Width'),
(403, 1, 'have_account', 'Have an account?'),
(404, 1, 'header', 'Header'),
(405, 1, 'help_documents', 'Help Documents'),
(406, 1, 'hi', 'Hi'),
(407, 1, 'hidden', 'Hidden'),
(408, 1, 'hidden_products', 'Hidden Products'),
(409, 1, 'hide', 'Hide'),
(410, 1, 'hide_vendor_contact_information', 'Hide Vendor Contact Information on the Site'),
(411, 1, 'highest_price', 'Highest Price'),
(412, 1, 'home', 'Home'),
(413, 1, 'homepage', 'Homepage'),
(414, 1, 'homepage_banners', 'Homepage Banners'),
(415, 1, 'homepage_manager', 'Homepage Manager'),
(416, 1, 'homepage_title', 'Homepage Title'),
(417, 1, 'horizontal_alignment', 'Horizontal Alignment'),
(418, 1, 'hour_ago', 'hour ago'),
(419, 1, 'hourly', 'Hourly'),
(420, 1, 'hours_ago', 'hours ago'),
(421, 1, 'terms_conditions_exp', 'I have read and agree to the'),
(422, 1, 'iban', 'IBAN'),
(423, 1, 'id', 'Id'),
(424, 1, 'identity_number', 'Identity Number'),
(425, 1, 'multi_vendor_system_exp', 'If you disable it, only Admin can add product.'),
(426, 1, 'pwa_warning', 'If you enable PWA option, read \'Progressive Web App (PWA)\' section from the documentation to make the necessary settings.'),
(427, 1, 'slug_exp', 'If you leave it empty, it will be generated automatically.'),
(428, 1, 'image', 'Image'),
(429, 1, 'images', 'Images'),
(430, 1, 'import_language', 'Import Language'),
(431, 1, 'msg_confirmed_required', 'In order to login to the site, you must confirm your email address.'),
(432, 1, 'start_selling_exp', 'In order to sell your products, you must be a verified member. Verification is a one-time process. This verification process is necessary because of spammers and fraud.'),
(433, 1, 'in_stock', 'In Stock'),
(434, 1, 'inactivate_all', 'Inactivate All'),
(435, 1, 'inactive', 'Inactive'),
(436, 1, 'index_ad_space_1', 'Index Ad Space 1'),
(437, 1, 'index_ad_space_2', 'Index Ad Space 2'),
(438, 1, 'index_slider', 'Index Slider'),
(439, 1, 'footer_information', 'Information'),
(440, 1, 'instagram_url', 'Instagram URL'),
(441, 1, 'instant_download', 'Instant download'),
(442, 1, 'msg_insufficient_balance', 'Insufficient balance!'),
(443, 1, 'iban_long', 'International Bank Account Number'),
(444, 1, 'invalid_attempt', 'Invalid Attempt!'),
(445, 1, 'invalid_file_type', 'Invalid file type!'),
(446, 1, 'invalid_withdrawal_amount', 'Invalid withdrawal amount!'),
(447, 1, 'invoice', 'Invoice'),
(448, 1, 'invoices', 'Invoices'),
(449, 1, 'ip_address', 'Ip Address'),
(450, 1, 'item', 'Item'),
(451, 1, 'msg_added', 'Item successfully added!'),
(452, 1, 'msg_deleted', 'Item successfully deleted!'),
(453, 1, 'iyzico', 'Iyzico'),
(454, 1, 'january', 'January'),
(455, 1, 'json_language_file', 'JSON Language File'),
(456, 1, 'july', 'July'),
(457, 1, 'june', 'June'),
(458, 1, 'just_now', 'Just Now'),
(459, 1, 'keep_shopping', 'Keep Shopping'),
(460, 1, 'keywords', 'Keywords'),
(461, 1, 'label', 'Label'),
(462, 1, 'language', 'Language'),
(463, 1, 'language_code', 'Language Code'),
(464, 1, 'language_name', 'Language Name'),
(465, 1, 'language_settings', 'Language Settings'),
(466, 1, 'msg_language_added', 'Language successfully added!'),
(467, 1, 'msg_language_deleted', 'Language successfully deleted!'),
(468, 1, 'languages', 'Languages'),
(469, 1, 'latest_blog_posts_exp', 'Last added blog posts'),
(470, 1, 'featured_products_exp', 'Last added featured products'),
(471, 1, 'latest_products_exp', 'Last added products'),
(472, 1, 'last_modification', 'Last Modification'),
(473, 1, 'last_name', 'Last Name'),
(474, 1, 'last_seen', 'Last seen: '),
(475, 1, 'latest_blog_posts', 'Latest Blog Posts'),
(476, 1, 'latest_comments', 'Latest Comments'),
(477, 1, 'latest_members', 'Latest Members'),
(478, 1, 'latest_orders', 'Latest Orders'),
(479, 1, 'latest_pending_products', 'Latest Pending Products'),
(480, 1, 'latest_posts', 'Latest Posts'),
(481, 1, 'latest_products', 'Latest Products'),
(482, 1, 'latest_reviews', 'Latest Reviews'),
(483, 1, 'latest_sales', 'Latest Sales'),
(484, 1, 'latest_transactions', 'Latest Transactions'),
(485, 1, 'left', 'Left'),
(486, 1, 'left_to_right', 'Left to Right (LTR)'),
(487, 1, 'license_certificate', 'License Certificate'),
(488, 1, 'license_key', 'License Key'),
(489, 1, 'license_keys', 'License Keys'),
(490, 1, 'msg_add_license_keys', 'License keys successfully added!'),
(491, 1, 'link', 'Link'),
(492, 1, 'linkedin_url', 'Linkedin URL'),
(493, 1, 'listing_type', 'Listing Type'),
(494, 1, 'live_preview', 'Live Preview'),
(495, 1, 'load_more', 'Load More'),
(496, 1, 'local_storage', 'Local Storage'),
(497, 1, 'location', 'Location'),
(498, 1, 'login', 'Login'),
(499, 1, 'logo', 'Logo'),
(500, 1, 'logo_email', 'Logo Email'),
(501, 1, 'logout', 'Logout'),
(502, 1, 'lowest_price', 'Lowest Price'),
(503, 1, 'mail', 'Mail'),
(504, 1, 'mail_host', 'Mail Host'),
(505, 1, 'mail_library', 'Mail Library'),
(506, 1, 'mail_password', 'Mail Password'),
(507, 1, 'mail_port', 'Mail Port'),
(508, 1, 'mail_protocol', 'Mail Protocol'),
(509, 1, 'mail_title', 'Mail Title'),
(510, 1, 'mail_username', 'Mail Username'),
(511, 1, 'main', 'main'),
(512, 1, 'main_files', 'Main File(s)'),
(513, 1, 'maintenance_mode', 'Maintenance Mode'),
(514, 1, 'bank_transfer_exp', 'Make your payment directly into our bank account.'),
(515, 1, 'management_tools', 'Management Tools'),
(516, 1, 'march', 'March'),
(517, 1, 'marketplace', 'Marketplace'),
(518, 1, 'marketplace_selling_product_on_the_site', 'Marketplace (Selling Products on the Site)'),
(519, 1, 'max', 'Max'),
(520, 1, 'max_file_size', 'Max File Size'),
(521, 1, 'may', 'May'),
(522, 1, 'member', 'Member'),
(523, 1, 'member_since', 'Member since'),
(524, 1, 'members', 'Members'),
(525, 1, 'membership', 'Membership'),
(526, 1, 'membership_payments', 'Membership Payments'),
(527, 1, 'membership_plan', 'Membership Plan'),
(528, 1, 'membership_plan_payment', 'Membership Plan Payment'),
(529, 1, 'membership_plans', 'Membership Plans'),
(530, 1, 'membership_transactions', 'Membership Transactions'),
(531, 1, 'menu_limit', 'Menu Limit'),
(532, 1, 'message', 'Message'),
(533, 1, 'msg_message_deleted', 'Message successfully deleted!'),
(534, 1, 'messages', 'Messages'),
(535, 1, 'meta_tag', 'Meta Tag'),
(536, 1, 'middle', 'Middle'),
(537, 1, 'min', 'Min'),
(538, 1, 'min_poyout_amount', 'Minimum payout amount'),
(539, 1, 'min_poyout_amounts', 'Minimum Payout Amounts'),
(540, 1, 'minute_ago', 'minute ago'),
(541, 1, 'minutes_ago', 'minutes ago'),
(542, 1, 'mode', 'Mode'),
(543, 1, 'location_exp', 'Modesy allows you to shop from anywhere in the world.'),
(544, 1, 'monday', 'Monday'),
(545, 1, 'month', 'Month'),
(546, 1, 'month_ago', 'month ago'),
(547, 1, 'monthly', 'Monthly'),
(548, 1, 'monthly_plan', 'Monthly Plan'),
(549, 1, 'monthly_sales', 'Monthly sales'),
(550, 1, 'months_ago', 'months ago'),
(551, 1, 'more', 'More'),
(552, 1, 'more_from', 'More from'),
(553, 1, 'most_recent', 'Most Recent'),
(554, 1, 'audio_preview_exp', 'MP3 or WAV preview audio'),
(555, 1, 'video_preview_exp', 'MP4 or WEBM preview video'),
(556, 1, 'multi_vendor_system', 'Multi-Vendor System'),
(557, 1, 'multilingual_system', 'Multilingual System'),
(558, 1, 'my_account', 'My Account'),
(559, 1, 'my_cart', 'My Cart'),
(560, 1, 'name', 'Name'),
(561, 1, 'name_on_the_card', 'Name on the Card'),
(562, 1, 'navigation', 'Navigation'),
(563, 1, 'navigation_template', 'Navigation Template'),
(564, 1, 'never', 'Never'),
(565, 1, 'new', 'New'),
(566, 1, 'new_message', 'New'),
(567, 1, 'new_arrivals', 'New Arrivals'),
(568, 1, 'new_password', 'New Password'),
(569, 1, 'new_quote_request', 'New Quote Request'),
(570, 1, 'newsletter', 'Newsletter'),
(571, 1, 'next', 'Next'),
(572, 1, 'no', 'No'),
(573, 1, 'no_comments_found', 'No comments found for this product. Be the first to comment!'),
(574, 1, 'no_discount', 'No Discount'),
(575, 1, 'no_members_found', 'No members found!'),
(576, 1, 'no_messages_found', 'No messages found!'),
(577, 1, 'no_products_found', 'No products found!'),
(578, 1, 'no_records_found', 'No records found!'),
(579, 1, 'no_reviews_found', 'No reviews found!'),
(580, 1, 'none', 'None'),
(581, 1, 'november', 'November'),
(582, 1, 'number', 'Number'),
(583, 1, 'membership_number_of_ads', 'Number of Active Ads'),
(584, 1, 'number_of_ads', 'Number of Ads'),
(585, 1, 'day_count', 'Number of Days'),
(586, 1, 'number_of_days', 'Number of Days'),
(587, 1, 'number_of_entries', 'Number of Entries'),
(588, 1, 'number_featured_products', 'Number of Featured Products to Show'),
(589, 1, 'number_latest_products', 'Number of Latest Products to Show'),
(590, 1, 'month_count', 'Number of Months'),
(591, 1, 'number_remaining_ads', 'Number of Remaining Ads'),
(592, 1, 'number_of_total_sales', 'Number of total sales'),
(593, 1, 'october', 'October'),
(594, 1, 'ok', 'OK'),
(595, 1, 'old_password', 'Old Password'),
(596, 1, 'product_approve_published', 'Once it is approved, it will be published on the site.'),
(597, 1, 'msg_bank_transfer_text', 'Once you have placed your order, you can make your payment to one of these bank accounts. Please add your order number to your payment description.'),
(598, 1, 'msg_promote_bank_transfer_text', 'Once you have placed your order, you can make your payment to one of these bank accounts. Please add your transaction number to your payment description.'),
(599, 1, 'online', 'Online'),
(600, 1, 'open_user_shop', 'Open User Shop'),
(601, 1, 'option', 'Option'),
(602, 1, 'msg_option_added', 'Option added successfully!'),
(603, 1, 'option_display_type', 'Option Display Type'),
(604, 1, 'option_name', 'Option Name'),
(605, 1, 'optional', 'Optional'),
(606, 1, 'options', 'Options'),
(607, 1, 'login_with_email', 'Or login with email'),
(608, 1, 'register_with_email', 'Or register with email'),
(609, 1, 'order', 'Order'),
(610, 1, 'order_details', 'Order Details'),
(611, 1, 'order_id', 'Order Id'),
(612, 1, 'order_information', 'Order Information'),
(613, 1, 'order_number', 'Order Number'),
(614, 1, 'order_summary', 'Order Summary'),
(615, 1, 'orders', 'Orders'),
(616, 1, 'out_of_stock', 'Out of Stock'),
(617, 1, 'page_not_found', 'Page not found'),
(618, 1, 'msg_page_added', 'Page successfully added!'),
(619, 1, 'msg_page_deleted', 'Page successfully deleted!'),
(620, 1, 'page_type', 'Page Type'),
(621, 1, 'page_views', 'Page Views'),
(622, 1, 'pages', 'Pages'),
(623, 1, 'pagseguro', 'PagSeguro'),
(624, 1, 'panel', 'Panel'),
(625, 1, 'parent', 'Parent'),
(626, 1, 'parent_category', 'Parent Category'),
(627, 1, 'parent_option', 'Parent Option'),
(628, 1, 'parent_variation', 'Parent Variation'),
(629, 1, 'password', 'Password'),
(630, 1, 'password_reset', 'Password Reset'),
(631, 1, 'paste_ad_code', 'Paste Ad Code'),
(632, 1, 'paste_ad_url', 'Paste Ad URL'),
(633, 1, 'pause', 'Pause'),
(634, 1, 'pay', 'Pay'),
(635, 1, 'pay_now', 'Pay Now'),
(636, 1, 'cash_on_delivery_exp', 'Pay with cash upon delivery.'),
(637, 1, 'payer_email', 'Payer Email'),
(638, 1, 'payment', 'Payment'),
(639, 1, 'payment_amount', 'Payment Amount'),
(640, 1, 'msg_payment_completed', 'Payment completed successfully!'),
(641, 1, 'payment_details', 'Payment Details'),
(642, 1, 'payment_history', 'Payment History'),
(643, 1, 'payment_id', 'Payment Id'),
(644, 1, 'payment_method', 'Payment Method'),
(645, 1, 'payment_note', 'Payment Note'),
(646, 1, 'payment_received', 'Payment Received'),
(647, 1, 'payment_settings', 'Payment Settings'),
(648, 1, 'payment_status', 'Payment Status'),
(649, 1, 'payments', 'Payments'),
(650, 1, 'payout_requests', 'Payout Requests'),
(651, 1, 'payout_settings', 'Payout Settings'),
(652, 1, 'payouts', 'Payouts'),
(653, 1, 'paypal_email_address', 'PayPal Email Address'),
(654, 1, 'paystack', 'PayStack'),
(655, 1, 'pending', 'Pending'),
(656, 1, 'pending_comments', 'Pending Comments'),
(657, 1, 'pending_payment', 'Pending Payment'),
(658, 1, 'pending_products', 'Pending Products'),
(659, 1, 'pending_quote', 'Pending Quote'),
(660, 1, 'phone', 'Phone'),
(661, 1, 'phone_number', 'Phone Number'),
(662, 1, 'physical', 'Physical'),
(663, 1, 'physical_products', 'Physical Products'),
(664, 1, 'pinterest_url', 'Pinterest URL'),
(665, 1, 'place_order', 'Place Order'),
(666, 1, 'plan_expiration_date', 'Plan Expiration Date'),
(667, 1, 'play', 'Play'),
(668, 1, 'msg_confirmation_email', 'Please click on the button below to confirm your account.'),
(669, 1, 'email_reset_password', 'Please click on the button below to reset your password.'),
(670, 1, 'msg_complete_payment', 'Please click the button below to complete the payment.'),
(671, 1, 'msg_recaptcha', 'Please confirm that you are not a robot!'),
(672, 1, 'msg_delete_posts', 'Please delete posts belonging to this category first!'),
(673, 1, 'msg_delete_subcategories', 'Please delete subcategories belonging to this category first!'),
(674, 1, 'please_wait', 'Please wait...'),
(675, 1, 'popular', 'Popular'),
(676, 1, 'msg_post_added', 'Post successfully added!'),
(677, 1, 'msg_post_deleted', 'Post successfully deleted!'),
(678, 1, 'postal_code', 'Postal Code'),
(679, 1, 'postcode', 'Postcode'),
(680, 1, 'posts', 'Posts'),
(681, 1, 'preferences', 'Preferences'),
(682, 1, 'preview', 'Preview'),
(683, 1, 'price', 'Price'),
(684, 1, 'price_per_day', 'Price Per Day'),
(685, 1, 'price_per_month', 'Price Per Month'),
(686, 1, 'pricing', 'Pricing'),
(687, 1, 'primary', 'Primary'),
(688, 1, 'print', 'Print'),
(689, 1, 'priority', 'Priority'),
(690, 1, 'order_processing', 'Processing'),
(691, 1, 'processing', 'Processing...'),
(692, 1, 'product', 'Product'),
(693, 1, 'product_ad_space', 'Product Ad Space'),
(694, 1, 'product_added', 'Product added successfully!'),
(695, 1, 'product_bottom_ad_space', 'Product Bottom Ad Space'),
(696, 1, 'product_code', 'Product Code'),
(697, 1, 'product_comments', 'Product Comments'),
(698, 1, 'product_details', 'Product Details'),
(699, 1, 'product_id', 'Product Id'),
(700, 1, 'product_link_structure', 'Product Link Structure'),
(701, 1, 'product_location_system', 'Product Location System'),
(702, 1, 'product_price', 'Product Price'),
(703, 1, 'product_promotion', 'Product Promotion'),
(704, 1, 'product_promoting_payment', 'Product Promotion Payment'),
(705, 1, 'product_promoting_payment_exp', 'Product Promotion Payment'),
(706, 1, 'msg_product_approved', 'Product successfully approved!'),
(707, 1, 'msg_product_deleted', 'Product successfully deleted!'),
(708, 1, 'product_type', 'Product Type'),
(709, 1, 'product_url', 'Product URL'),
(710, 1, 'production', 'Production'),
(711, 1, 'products', 'Products'),
(712, 1, 'products_ad_space', 'Products Ad Space'),
(713, 1, 'products_by_category', 'Products by Category'),
(714, 1, 'products_sidebar_ad_space', 'Products Sidebar Ad Space'),
(715, 1, 'product_image_exp', 'Products with good and clear images are sold faster!'),
(716, 1, 'profile', 'Profile'),
(717, 1, 'profile_ad_space', 'Profile Ad Space'),
(718, 1, 'profile_sidebar_ad_space', 'Profile Sidebar Ad Space'),
(719, 1, 'pwa', 'Progressive Web App (PWA)'),
(720, 1, 'promote', 'Promote'),
(721, 1, 'stripe_payment_for', 'Promote payment for'),
(722, 1, 'promote_plan', 'Promote Plan'),
(723, 1, 'promote_your_product', 'Promote Your Product'),
(724, 1, 'promotion_payments', 'Promotion Payments'),
(725, 1, 'public_key', 'Public Key'),
(726, 1, 'publishable_key', 'Publishable Key'),
(727, 1, 'purchase_code', 'Purchase Code'),
(728, 1, 'purchased_plan', 'Purchased Plan'),
(729, 1, 'quantity', 'Quantity'),
(730, 1, 'footer_quick_links', 'Quick Links'),
(731, 1, 'quote', 'Quote'),
(732, 1, 'quote_request', 'Quote Request'),
(733, 1, 'quote_requests', 'Quote Requests'),
(734, 1, 'radio_button', 'Radio Button (Single Selection)'),
(735, 1, 'rate_this_product', 'Rate this product'),
(736, 1, '1_business_day', 'Ready to ship in 1 Business Day'),
(737, 1, '2_3_business_days', 'Ready to ship in 2-3 Business Days'),
(738, 1, '4_7_business_days', 'Ready to ship in 4-7 Business Days'),
(739, 1, '8_15_business_days', 'Ready to ship in 8-15 Business Days'),
(740, 1, 'receipt', 'Receipt'),
(741, 1, 'received_quote_requests', 'Received Quote Requests'),
(742, 1, 'refresh_cache_database_changes', 'Refresh Cache Files When Database Changes'),
(743, 1, 'region', 'Region'),
(744, 1, 'register', 'Register'),
(745, 1, 'regular', 'Regular'),
(746, 1, 'regular_listing', 'Regular Listing'),
(747, 1, 'reject_quote', 'Reject Quote'),
(748, 1, 'rejected_quote', 'Rejected Quote'),
(749, 1, 'related_posts', 'Related Posts'),
(750, 1, 'remaining_days', 'Remaining Days'),
(751, 1, 'remove', 'Remove'),
(752, 1, 'remove_from_featured', 'Remove from Featured'),
(753, 1, 'remove_from_product_filters', 'Remove from Product Filters'),
(754, 1, 'remove_from_special_offers', 'Remove from Special Offers'),
(755, 1, 'remove_from_wishlist', 'Remove from wishlist'),
(756, 1, 'remove_user_ban', 'Remove User Ban'),
(757, 1, 'renew_your_plan', 'Renew Your Plan'),
(758, 1, 'reply', 'Reply'),
(759, 1, 'report_bank_transfer', 'Report Bank Transfer'),
(760, 1, 'request_a_quote', 'Request a Quote'),
(761, 1, 'required', 'Required'),
(762, 1, 'resend_activation_email', 'Resend Activation Email'),
(763, 1, 'reset', 'Reset'),
(764, 1, 'reset_cache', 'Reset Cache'),
(765, 1, 'reset_filters', 'Reset Filters'),
(766, 1, 'reset_location', 'Reset Location'),
(767, 1, 'reset_password', 'Reset Password'),
(768, 1, 'restore', 'Restore'),
(769, 1, 'return_to_cart', 'Return to cart'),
(770, 1, 'review', 'Review'),
(771, 1, 'msg_review_deleted', 'Review successfully deleted!'),
(772, 1, 'reviews', 'Reviews'),
(773, 1, 'right', 'Right'),
(774, 1, 'right_to_left', 'Right to Left (RTL)'),
(775, 1, 'route_settings', 'Route Settings'),
(776, 1, 'row_width', 'Row Width'),
(777, 1, 'rss_feeds', 'RSS Feeds'),
(778, 1, 'rss_system', 'RSS System'),
(779, 1, 'sale', 'Sale'),
(780, 1, 'sale_id', 'Sale Id'),
(781, 1, 'sales', 'Sales'),
(782, 1, 'sandbox', 'Sandbox'),
(783, 1, 'saturday', 'Saturday'),
(784, 1, 'save_and_continue', 'Save and Continue'),
(785, 1, 'save_as_draft', 'Save as Draft'),
(786, 1, 'save_changes', 'Save Changes'),
(787, 1, 'search', 'Search'),
(788, 1, 'search_exp', 'Search for products or members'),
(789, 1, 'search_products', 'Search Products'),
(790, 1, 'secret_key', 'Secret Key'),
(791, 1, 'secure_key', 'Secure Key'),
(792, 1, 'see_details', 'See Details'),
(793, 1, 'see_more', 'See more'),
(794, 1, 'see_order_details', 'See Order Details'),
(795, 1, 'select', 'Select'),
(796, 1, 'select_ad_space', 'Select Ad Space'),
(797, 1, 'select_all', 'Select All'),
(798, 1, 'select_existing_variation', 'Select an Existing Variation'),
(799, 1, 'select_option', 'Select an option'),
(800, 1, 'select_category', 'Select Category'),
(801, 1, 'select_country', 'Select Country'),
(802, 1, 'select_favicon', 'Select Favicon'),
(803, 1, 'select_file', 'Select File'),
(804, 1, 'select_image', 'Select Image'),
(805, 1, 'select_language', 'Select Language'),
(806, 1, 'select_location', 'Select Location'),
(807, 1, 'select_logo', 'Select Logo'),
(808, 1, 'select_payment_option', 'Select Payment Option'),
(809, 1, 'products_by_category_exp', 'Show products by categories on the homepage'),
(810, 1, 'featured_categories_exp', 'Select the categories you want to show under the slider'),
(811, 1, 'select_your_plan_exp', 'Select your membership plan to continue'),
(812, 1, 'select_your_plan', 'Select Your Plan'),
(813, 1, 'sell_now', 'Sell Now'),
(814, 1, 'sell_my_product_on_site', 'Sell product on the site'),
(815, 1, 'seller', 'Seller'),
(816, 1, 'seller_balances', 'Seller Balances'),
(817, 1, 'sellers_bid', 'Seller\'s Bid'),
(818, 1, 'send', 'Send'),
(819, 1, 'email_option_contact_messages', 'Send contact messages to email address'),
(820, 1, 'send_email', 'Send Email'),
(821, 1, 'send_email_to_buyer', 'Send Email to Buyer'),
(822, 1, 'email_option_send_order_to_buyer', 'Send email to buyer after purchase (Send order summary)'),
(823, 1, 'email_option_send_email_order_shipped', 'Send email to buyer when order shipped'),
(824, 1, 'send_email_subscribers', 'Send Email to Subscribers'),
(825, 1, 'email_option_product_added', 'Send email when a new product is added'),
(826, 1, 'send_email_shop_opening_request', 'Send email when there is a new shop opening request'),
(827, 1, 'email_option_send_email_new_message', 'Send me an email when someone send me a message'),
(828, 1, 'send_message', 'Send Message'),
(829, 1, 'send_test_email', 'Send Test Email'),
(830, 1, 'seo', 'SEO'),
(831, 1, 'seo_tools', 'Seo Tools'),
(832, 1, 'september', 'September'),
(833, 1, 'server_response', 'Server\'s Response'),
(834, 1, 'set_as_default', 'Set as Default'),
(835, 1, 'set_payout_account', 'Set Payout Account'),
(836, 1, 'settings', 'Settings'),
(837, 1, 'settings_language', 'Settings Language'),
(838, 1, 'share', 'Share'),
(839, 1, 'shipped', 'Shipped'),
(840, 1, 'shipped_product', 'Shipped Product'),
(841, 1, 'shipping', 'Shipping'),
(842, 1, 'shipping_location', 'Shipping & Location'),
(843, 1, 'shipping_address', 'Shipping Address'),
(844, 1, 'shipping_cost', 'Shipping Cost'),
(845, 1, 'shipping_time', 'Shipping Time'),
(846, 1, 'shop_description', 'Shop Description'),
(847, 1, 'shop_name', 'Shop Name'),
(848, 1, 'shop_now', 'Shop Now'),
(849, 1, 'shop_opening_request', 'Shop Opening Request'),
(850, 1, 'shop_opening_requests', 'Shop Opening Requests'),
(851, 1, 'shop_settings', 'Shop Settings'),
(852, 1, 'shopping_cart', 'Shopping Cart'),
(853, 1, 'short_form', 'Short Form'),
(854, 1, 'show', 'Show'),
(855, 1, 'show_all', 'Show All'),
(856, 1, 'show_breadcrumb', 'Show Breadcrumb'),
(857, 1, 'show_category_image_on_menu', 'Show Category Image on Menu'),
(858, 1, 'show_image_on_navigation', 'Show Category Image on the Navigation'),
(859, 1, 'show_cookies_warning', 'Show Cookies Warning'),
(860, 1, 'show_first_search_lists', 'Show first in search lists'),
(861, 1, 'show_my_email', 'Show my email address'),
(862, 1, 'show_my_location', 'Show my location'),
(863, 1, 'show_my_phone', 'Show my phone number'),
(864, 1, 'show_option_images_on_slider', 'Show Option Images on Slider When an Option is Selected'),
(865, 1, 'show_right_column', 'Show Right Column'),
(866, 1, 'show_title', 'Show Title'),
(867, 1, 'site_description', 'Site Description'),
(868, 1, 'site_font', 'Site Font'),
(869, 1, 'site_key', 'Site Key'),
(870, 1, 'site_title', 'Site Title'),
(871, 1, 'sitemap', 'Sitemap'),
(872, 1, 'msg_sitemap_updated', 'Sitemap successfully updated!'),
(873, 1, 'skip', 'Skip'),
(874, 1, 'sku', 'SKU'),
(875, 1, 'slider', 'Slider'),
(876, 1, 'msg_slider_added', 'Slider item successfully added!'),
(877, 1, 'msg_slider_deleted', 'Slider item successfully deleted!'),
(878, 1, 'slider_items', 'Slider Items'),
(879, 1, 'slider_settings', 'Slider Settings'),
(880, 1, 'slug', 'Slug'),
(881, 1, 'social_login', 'Social Login'),
(882, 1, 'social_media', 'Social Media'),
(883, 1, 'social_media_settings', 'Social Media Settings'),
(884, 1, 'sold', 'Sold'),
(885, 1, 'sort_by', 'Sort By:'),
(886, 1, 'sort_categories', 'Sort Categories'),
(887, 1, 'sort_options', 'Sort Options'),
(888, 1, 'sort_parent_categories_by_category_order', 'Sort Parent Categories by Category Order'),
(889, 1, 'warning_category_sort', 'Sorting with drag and drop will be active only when the \"by Category Order\" option is selected.'),
(890, 1, 'special_offers', 'Special Offers'),
(891, 1, 'start', 'Start'),
(892, 1, 'start_selling', 'Start Selling'),
(893, 1, 'state', 'State'),
(894, 1, 'states', 'States'),
(895, 1, 'status', 'Status'),
(896, 1, 'stock', 'Stock'),
(897, 1, 'storage', 'Storage'),
(898, 1, 'store_name', 'Store Name'),
(899, 1, 'stripe', 'Stripe'),
(900, 1, 'stripe_checkout', 'Stripe Checkout'),
(901, 1, 'subcategory', 'Subcategory'),
(902, 1, 'subject', 'Subject'),
(903, 1, 'submit', 'Submit'),
(904, 1, 'submit_a_new_quote', 'Submit a New Quote'),
(905, 1, 'submit_a_quote', 'Submit a Quote'),
(906, 1, 'subscribe', 'Subscribe'),
(907, 1, 'msg_subscriber_deleted', 'Subscriber successfully deleted!'),
(908, 1, 'subscribers', 'Subscribers'),
(909, 1, 'subtotal', 'Subtotal'),
(910, 1, 'succeeded', 'Succeeded'),
(911, 1, 'summary', 'Summary'),
(912, 1, 'sunday', 'Sunday'),
(913, 1, 'swift', 'SWIFT'),
(914, 1, 'swift_code', 'SWIFT Code'),
(915, 1, 'system_settings', 'System Settings'),
(916, 1, 'tag', 'Tag'),
(917, 1, 'tags', 'Tags'),
(918, 1, 'tell_us_about_shop', 'Tell Us About Your Shop'),
(919, 1, 'text', 'Text'),
(920, 1, 'text_color', 'Text Color'),
(921, 1, 'text_direction', 'Text Direction'),
(922, 1, 'text_editor_language', 'Text Editor Language'),
(923, 1, 'textarea', 'Textarea'),
(924, 1, 'email_text_thank_for_order', 'Thank you for your order!'),
(925, 1, 'banner_location_exp', 'The banner will be added under the selected section'),
(926, 1, 'adsense_head_exp', 'The codes you add here will be added in the <head></head> tags.'),
(927, 1, 'msg_email_unique_error', 'The email has already been taken.'),
(928, 1, 'number_of_links_in_menu', 'The number of links that appear in the menu'),
(929, 1, 'the_operation_completed', 'The operation completed successfully!'),
(930, 1, 'page_not_found_sub', 'The page you are looking for doesn\'t exist.'),
(931, 1, 'priority_exp', 'The priority of a particular URL relative to other pages on the same site'),
(932, 1, 'msg_request_sent', 'The request has been sent successfully!'),
(933, 1, 'msg_shop_name_unique_error', 'The shop name has already been taken.'),
(934, 1, 'msg_slug_unique_error', 'The slug has already been taken.'),
(935, 1, 'last_modification_exp', 'The time the URL was last modified'),
(936, 1, 'msg_username_unique_error', 'The username has already been taken.'),
(937, 1, 'there_is_shop_opening_request', 'There is a new shop opening request.'),
(938, 1, 'msg_change_password_error', 'There was a problem changing your password!'),
(939, 1, 'msg_contact_error', 'There was a problem sending your message!'),
(940, 1, 'custom_javascript_codes_exp', 'These codes will be added to the footer of the site.'),
(941, 1, 'custom_css_codes_exp', 'These codes will be added to the header of the site.'),
(942, 1, 'iyzico_warning', 'This is the \"Checkout Form\" integration, not the \"Marketplace\" integration.'),
(943, 1, 'msg_option_exists', 'This option already exists!'),
(944, 1, 'default_option_exp', 'This option will be selected by default. It will use the default images and price'),
(945, 1, 'msg_product_slug_used', 'This slug is used by another product!'),
(946, 1, 'frequency_exp', 'This value indicates how frequently the content at a particular URL is likely to change '),
(947, 1, 'cvv_exp', 'Three-digits code on the back of your card'),
(948, 1, 'thursday', 'Thursday'),
(949, 1, 'timezone', 'Timezone'),
(950, 1, 'title', 'Title'),
(951, 1, 'gmail_warning', 'To send e-mails with Gmail server, please read Email Settings section in our documentation.'),
(952, 1, 'to', 'To:'),
(953, 1, 'token', 'Token'),
(954, 1, 'top', 'Top'),
(955, 1, 'top_menu', 'Top Menu'),
(956, 1, 'total', 'Total'),
(957, 1, 'total_amount', 'Total Amount:'),
(958, 1, 'transaction_number', 'Transaction Number'),
(959, 1, 'transactions', 'Transactions'),
(960, 1, 'translation', 'Translation'),
(961, 1, 'tuesday', 'Tuesday'),
(962, 1, 'twitter_url', 'Twitter URL'),
(963, 1, 'type', 'Type'),
(964, 1, 'type_extension', 'Type an extension and hit enter '),
(965, 1, 'type_tag', 'Type tag and hit enter'),
(966, 1, 'msg_error_cart_unapproved_products', 'Unapproved products cannot be added to the cart!'),
(967, 1, 'unconfirmed', 'Unconfirmed'),
(968, 1, 'unfollow', 'Unfollow'),
(969, 1, 'unit_price', 'Unit Price'),
(970, 1, 'unlimited', 'Unlimited'),
(971, 1, 'unlimited_stock', 'Unlimited Stock'),
(972, 1, 'unsubscribe', 'Unsubscribe'),
(973, 1, 'unsubscribe_successful', 'Unsubscribe Successful!'),
(974, 1, 'update_category', 'Update Category'),
(975, 1, 'update_city', 'Update City'),
(976, 1, 'update_country', 'Update Country'),
(977, 1, 'update_currency', 'Update Currency'),
(978, 1, 'update_custom_field', 'Update Custom Field'),
(979, 1, 'update_font', 'Update Font'),
(980, 1, 'update_language', 'Update Language'),
(981, 1, 'update_location', 'Update Location'),
(982, 1, 'update_order_status', 'Update Order Status'),
(983, 1, 'update_page', 'Update Page'),
(984, 1, 'update_post', 'Update Post'),
(985, 1, 'update_product', 'Update Product'),
(986, 1, 'update_profile', 'Update Profile'),
(987, 1, 'update_quote', 'Update Quote'),
(988, 1, 'update_seller_balance', 'Update Seller Balance'),
(989, 1, 'update_sitemap', 'Update Sitemap'),
(990, 1, 'update_slider_item', 'Update Slider Item'),
(991, 1, 'update_state', 'Update State'),
(992, 1, 'updated', 'Updated'),
(993, 1, 'upload', 'Upload'),
(994, 1, 'upload_your_banner', 'Upload Your Banner'),
(995, 1, 'uploaded', 'Uploaded'),
(996, 1, 'uploading', 'Uploading...'),
(997, 1, 'url', 'URL'),
(998, 1, 'use_default_payment_account', 'Use as default payment account'),
(999, 1, 'use_default_price', 'Use default price'),
(1000, 1, 'use_different_price_for_options', 'Use Different Price for Options'),
(1001, 1, 'use_same_address_for_billing', 'Use same address for billing address'),
(1002, 1, 'use_this_date', 'Use This Date'),
(1003, 1, 'used', 'Used'),
(1004, 1, 'user', 'User'),
(1005, 1, 'user_id', 'User Id'),
(1006, 1, 'user_reviews', 'User Reviews'),
(1007, 1, 'msg_user_deleted', 'User successfully deleted!'),
(1008, 1, 'username', 'Username'),
(1009, 1, 'users', 'Users'),
(1010, 1, 'vat_exp', 'Value-Added Tax'),
(1011, 1, 'variation_type', 'Variation Type'),
(1012, 1, 'variations', 'Variations'),
(1013, 1, 'vat', 'VAT'),
(1014, 1, 'vat_included', 'VAT Included'),
(1015, 1, 'vendor', 'Vendor'),
(1016, 1, 'vendor_verification_system', 'Vendor Verification System'),
(1017, 1, 'vendors', 'Vendors'),
(1018, 1, 'vertical_alignment', 'Vertical Alignment'),
(1019, 1, 'video', 'Video'),
(1020, 1, 'video_preview', 'Video Preview'),
(1021, 1, 'view_all', 'View All'),
(1022, 1, 'view_details', 'View Details'),
(1023, 1, 'view_invoice', 'View Invoice'),
(1024, 1, 'view_license_keys', 'View License Keys'),
(1025, 1, 'view_options', 'View Options'),
(1026, 1, 'view_product', 'View Product'),
(1027, 1, 'view_site', 'View Site'),
(1028, 1, 'visibility', 'Visibility'),
(1029, 1, 'visible', 'Visible'),
(1030, 1, 'visual_settings', 'Visual Settings'),
(1031, 1, 'vk_url', 'VK URL'),
(1032, 1, 'vk_login', 'VKontakte Login'),
(1033, 1, 'waiting', 'Waiting...'),
(1034, 1, 'warning', 'Warning'),
(1035, 1, 'watermark', 'Watermark'),
(1036, 1, 'watermark_image', 'Watermark Image'),
(1037, 1, 'msg_reset_password_error', 'We can\'t find a user with that e-mail address!'),
(1038, 1, 'msg_start_selling', 'We have received your request. Your store will be open when your request is approved.'),
(1039, 1, 'msg_reset_password_success', 'We\'ve sent an email for resetting your password to your email address. Please check your email for next steps.'),
(1040, 1, 'wednesday', 'Wednesday'),
(1041, 1, 'weekly', 'Weekly'),
(1042, 1, 'confirm_order_received_warning', 'When you receive your order, please check the products you have purchased. If there is not any problem, click \'Confirm Order Received\' button. After confirming your order, the money will be transferred to the seller.'),
(1043, 1, 'msg_expired_plan', 'When your plan expires, if you do not renew your plan within 3 days, your ads will be added to the \"Expired Products\" section and will not be displayed on the site.'),
(1044, 1, 'wishlist', 'Wishlist'),
(1045, 1, 'msg_cron_sitemap', 'With this URL you can automatically update your sitemap.'),
(1046, 1, 'withdraw_money', 'Withdraw Money'),
(1047, 1, 'withdraw_amount', 'Withdrawal Amount'),
(1048, 1, 'withdraw_method', 'Withdrawal Method'),
(1049, 1, 'write_a_message', 'Write a message...'),
(1050, 1, 'write_review', 'Write a Review...'),
(1051, 1, 'login_error', 'Wrong email or password!'),
(1052, 1, 'msg_wrong_old_password', 'Wrong old password!'),
(1053, 1, 'year_ago', 'year ago'),
(1054, 1, 'yearly', 'Yearly'),
(1055, 1, 'years_ago', 'years ago'),
(1056, 1, 'yes', 'Yes');
INSERT INTO `language_translations` (`id`, `lang_id`, `label`, `translation`) VALUES
(1057, 1, 'active_payment_request_error', 'You already have an active payment request! Once this is complete, you can make a new request.'),
(1058, 1, 'checking_out_as_guest', 'You are checking out as a guest'),
(1059, 1, 'external_link_exp', 'You can add an external product link. (i.e. https://domain.com/product)'),
(1060, 1, 'bulk_category_upload_exp', 'You can add your categories with a CSV file from this section\r\n'),
(1061, 1, 'bulk_product_upload_exp', 'You can add your products with a CSV file from this section'),
(1062, 1, 'msg_bank_transfer_text_order_completed', 'You can make your payment to one of these bank accounts. Please add your order number to your payment description.'),
(1063, 1, 'msg_bank_transfer_text_transaction_completed', 'You can make your payment to one of these bank accounts. Please add your transaction number to your payment description.'),
(1064, 1, 'homepage_banners_exp', 'You can manage the product banners on the homepage from this section'),
(1065, 1, 'send_test_email_exp', 'You can send a test mail to check if your mail server is working.'),
(1066, 1, 'help_documents_exp', 'You can use these documents to generate your CSV file\r\n'),
(1067, 1, 'category_id_finder_exp', 'You can use this section to find out the Id of a category'),
(1068, 1, 'msg_quote_request_error', 'You cannot request a quote for your own item!'),
(1069, 1, 'msg_message_sent_error', 'You cannot send message to yourself!'),
(1070, 1, 'route_settings_warning', 'You cannot use special characters in routes. If your language contains special characters, please be careful when editing routes. If you enter an invalid route, you will not be able to access the related page.'),
(1071, 1, 'do_not_have_membership_plan', 'You do not have a membership plan. Click the button below to buy a membership plan.'),
(1072, 1, 'you_have_new_message', 'You have a new message'),
(1073, 1, 'you_have_new_order', 'You have a new order'),
(1074, 1, 'you_have_new_quote_request', 'You have a new quote request.'),
(1075, 1, 'msg_no_created_variations', 'You have no created variations.'),
(1076, 1, 'msg_reached_ads_limit', 'You have reached your ad adding limit! If you want to add more ads, you can upgrade your current plan by clicking the button below.'),
(1077, 1, 'cash_on_delivery_warning', 'You have selected \'Cash on Delivery\' as your payment method. You must pay the total amount when you receive your package. If you accept this payment method, please click the button below to complete your order.'),
(1078, 1, 'msg_accept_terms', 'You have to accept the terms!'),
(1079, 1, 'you_may_also_like', 'You May Also Like'),
(1080, 1, 'msg_digital_product_register_error', 'You must create an account to purchase a digital product.'),
(1081, 1, 'msg_error_product_type', 'You must enable at least one product type'),
(1082, 1, 'msg_error_selected_system', 'You must enable at least one system'),
(1083, 1, 'msg_payout_paypal_error', 'You must enter your PayPal email address to make this payment request'),
(1084, 1, 'you_will_earn', 'You Will Earn'),
(1085, 1, 'msg_unsubscribe', 'You will no longer receive emails from us!'),
(1086, 1, 'msg_register_success', 'Your account has been created successfully!'),
(1087, 1, 'msg_ban_error', 'Your account has been suspended!'),
(1088, 1, 'your_balance', 'Your Balance'),
(1089, 1, 'your_cart_is_empty', 'Your cart is empty!'),
(1090, 1, 'msg_comment_sent_successfully', 'Your comment has been sent. It will be published after being reviewed by the site management.'),
(1091, 1, 'msg_newsletter_success', 'Your email address has been successfully added!'),
(1092, 1, 'msg_confirmed', 'Your email address has been successfully confirmed!'),
(1093, 1, 'msg_newsletter_error', 'Your email address is already registered!'),
(1094, 1, 'msg_membership_renewed', 'Your membership plan has been successfully renewed!'),
(1095, 1, 'msg_plan_expired', 'Your membership plan has expired!'),
(1096, 1, 'msg_contact_success', 'Your message has been successfully sent!'),
(1097, 1, 'msg_message_sent', 'Your message has been successfully sent!'),
(1098, 1, 'email_text_new_order', 'Your order has been received and is now processed. Your order details are shown below.'),
(1099, 1, 'your_order_shipped', 'Your order has been shipped'),
(1100, 1, 'msg_order_completed', 'Your order has been successfully completed!'),
(1101, 1, 'msg_change_password_success', 'Your password has been successfully changed!'),
(1102, 1, 'msg_payment_success', 'Your payment has been successfully completed!'),
(1103, 1, 'msg_add_product_success', 'Your payment has been successfully completed! Once your product is approved, it will be published on our site!'),
(1104, 1, 'msg_payment_database_error', 'Your payment has been successfully completed, but there was a problem with adding the order to the database! Please contact our site management for this order!'),
(1105, 1, 'your_quote_accepted', 'Your quote has been accepted.'),
(1106, 1, 'your_quote_rejected', 'Your quote has been rejected.'),
(1107, 1, 'your_quote_request_replied', 'Your quote request has been replied.'),
(1108, 1, 'your_rating', 'Your Rating:'),
(1109, 1, 'msg_quote_request_sent', 'Your request has been successfully submitted.'),
(1110, 1, 'msg_shop_opening_requests', 'Your request to open a store is under evaluation!'),
(1111, 1, 'msg_review_added', 'Your review has been successfully added!'),
(1112, 1, 'your_shop_opening_request_approved', 'Your shop opening request has been approved. You can go to our site and start to sell your items!'),
(1113, 1, 'msg_shop_request_declined', 'Your shop opening request has been declined. Thank you for your interest.'),
(1114, 1, 'youtube_url', 'Youtube URL'),
(1115, 1, 'zip_code', 'Zip Code'),
(1116, 1, 'exchange_rate', 'Exchange Rate'),
(1117, 1, 'currency_converter', 'Currency Converter'),
(1118, 1, 'automatically_update_exchange_rates', 'Automatically Update Exchange Rates'),
(1119, 1, 'currency_converter_api', 'Currency Converter API'),
(1120, 1, 'access_key', 'Access Key'),
(1121, 1, 'base_currency', 'Base Currency'),
(1122, 1, 'all_active_currencies', 'All active currencies'),
(1123, 1, 'server_key', 'Server Key'),
(1124, 1, 'abuse_report_exp', 'Briefly describe the issue you are facing'),
(1125, 1, 'abuse_report_msg', 'Your report has reached us. Thank you!'),
(1126, 1, 'content_type', 'Content Type'),
(1127, 1, 'sent_by', 'Sent By'),
(1128, 1, 'view_content', 'View Content'),
(1129, 1, 'cover_image', 'Cover Image'),
(1130, 1, 'deleted', 'Deleted'),
(1131, 1, 'product_or_seller_profile_url', 'Product or seller profile URL'),
(1132, 1, 'search_by_location', 'Search by Location'),
(1133, 1, 'most_viewed_products', 'Most Viewed Products'),
(1134, 1, 'vendor_bulk_product_upload', 'Vendor Bulk Product Upload'),
(1135, 1, 'product_cache_system', 'Product Cache System'),
(1136, 1, 'static_content_cache_system', 'Static Content Cache System'),
(1137, 1, 'warning_static_content_cache_system', 'Static content cache system is for records (categories, custom fields, language translations etc.) that do not change much on the site. The cache files will be refreshed automatically when there is a change in these records. It is recommended to activate this system always for a faster site.'),
(1138, 1, 'warning_plan_used', 'This plan has been used before'),
(1139, 1, 'warning_cannot_choose_plan', 'You cannot choose this plan due to the number of products you have added'),
(1140, 1, 'warning_membership_admin_role', 'Admin role does not require a membership plan.'),
(1141, 1, 'assign_membership_plan', 'Assign Membership Plan'),
(1142, 1, 'personal_website_url', 'Personal Website URL'),
(1143, 1, 'contact_seller', 'Contact Seller'),
(1144, 1, 'already_have_active_request', 'You already have an active request for this product!'),
(1145, 1, 'order_not_yet_shipped', 'The order has not yet been shipped.'),
(1146, 1, 'warning_add_order_tracking_code', 'You can add the order tracking code and link while changing the order status.'),
(1147, 1, 'tracking_code', 'Tracking Code'),
(1148, 1, 'tracking_url', 'Tracking URL'),
(1149, 1, 'order_has_been_shipped', 'The order has been shipped!'),
(1150, 1, 'multiple_sale', 'Multiple Sale'),
(1151, 1, 'multiple_sale_option_1', 'Yes, I want to sell this product to more than one customer'),
(1152, 1, 'multiple_sale_option_2', 'No, I want to sell this product to a single customer'),
(1153, 1, 'sold_products', 'Sold Products'),
(1154, 1, 'show_sold_products_on_site', 'Show Sold Products on the Site'),
(1155, 1, 'report_comment', 'Report Comment'),
(1156, 1, 'report_review', 'Report Review'),
(1157, 1, 'report', 'Report'),
(1158, 1, 'abuse_reports', 'Abuse Reports'),
(1159, 1, 'reported_content', 'Reported Content'),
(1160, 1, 'report_this_product', 'Report this product'),
(1161, 1, 'report_this_seller', 'Report this seller'),
(1162, 1, 'filter_key', 'Filter Key'),
(1163, 1, 'filter_key_exp', 'Don\'t add special characters'),
(1164, 1, 'product_settings', 'Product Settings'),
(1165, 1, 'whatsapp_url', 'WhatsApp URL'),
(1166, 1, 'telegram_url', 'Telegram URL'),
(1167, 1, 'dashboard_font', 'Dashboard Font'),
(1168, 1, 'classified_ads', 'Classified Ads'),
(1169, 1, 'show_subcategory_products', 'Show subcategory products'),
(1170, 1, 'msg_error_sku', 'This SKU is used for your another product!'),
(1171, 1, 'msg_dont_have_downloadable_files', 'You don\'t have any downloadable files.'),
(1172, 1, 'paid', 'Paid'),
(1173, 1, 'shipping_settings', 'Shipping Settings'),
(1174, 1, 'shipping_zones', 'Shipping Zones '),
(1175, 1, 'zone_name', 'Zone Name'),
(1176, 1, 'regions', 'Regions'),
(1177, 1, 'shipping_methods', 'Shipping Methods'),
(1178, 1, 'add_shipping_zone', 'Add Shipping Zone'),
(1179, 1, 'select_region', 'Select Region'),
(1180, 1, 'continent', 'Continent'),
(1181, 1, 'no_results_found', 'No Results Found'),
(1182, 1, 'all_countries', 'All Countries'),
(1183, 1, 'all_states', 'All States'),
(1184, 1, 'flat_rate', 'Flat Rate'),
(1185, 1, 'local_pickup', 'Local Pickup'),
(1186, 1, 'free_shipping', 'Free Shipping'),
(1187, 1, 'add_shipping_method', 'Add Shipping Method'),
(1188, 1, 'method_name', 'Method Name'),
(1189, 1, 'cost', 'Cost'),
(1190, 1, 'minimum_order_amount', 'Minimum order amount'),
(1191, 1, 'charge_shipping_for_each_product', 'Charge shipping for each product in the cart'),
(1192, 1, 'charge_shipping_for_each_different_product', 'Charge shipping for each different product in the cart'),
(1193, 1, 'cost_calculation_type', 'Cost Calculation Type'),
(1194, 1, 'edit_shipping_zone', 'Edit Shipping Zone'),
(1195, 1, 'add_new_address', 'Add New Address'),
(1196, 1, 'address_title', 'Address Title'),
(1197, 1, 'shipping_delivery_times', 'Shipping Delivery Times'),
(1198, 1, 'shipping_delivery_times_exp', 'You can add shipping delivery times from here (E.g: Ready to ship in 1 Business Day)'),
(1199, 1, 'add_delivery_time', 'Add Delivery Time'),
(1200, 1, 'edit_delivery_time', 'Edit Delivery Time'),
(1201, 1, 'delivery_time', 'Delivery Time'),
(1202, 1, 'edit_address', 'Edit Address'),
(1203, 1, 'shipping_method', 'Shipping Method'),
(1204, 1, 'shipping_information', 'Shipping Information'),
(1205, 1, 'not_added_shipping_address', 'You have not added a shipping address yet.'),
(1206, 1, 'no_delivery_is_made_to_address', 'No delivery is made to the address you have chosen.'),
(1207, 1, 'products_sent_different_stores', 'Your products will be sent by different stores.'),
(1208, 1, 'fixed_shipping_cost_for_cart_total', 'Fixed Shipping Cost for Cart Total'),
(1209, 1, 'seller_does_not_ship_to_address', 'This seller does not ship to the address you have chosen. You can continue by removing the products of this seller from your cart.'),
(1210, 1, 'add_product_sell_license_keys', 'Add a Product to Sell License Keys'),
(1211, 1, 'add_product_sell_license_keys_exp', 'Add a product to sell only license keys'),
(1212, 1, 'selling_license_keys', 'Selling License Keys'),
(1213, 1, 'license_keys_system_exp', 'Add all your license keys from here. The system will automatically give a license key to each buyer.'),
(1214, 1, 'download_license_key', 'Download License Key'),
(1215, 1, 'shop_location', 'Shop Location'),
(1216, 1, 'shipping_classes', 'Shipping Classes'),
(1217, 1, 'add_shipping_class', 'Add Shipping Class'),
(1218, 1, 'edit_shipping_class', 'Edit Shipping Class'),
(1219, 1, 'shipping_classes_exp', 'Shipping classes allow you to define different shipping costs for your products. If you have products with high shipping costs (large in weight and size), you can add a class from here and set a different price for each shipping method for this class. You can choose shipping classes during adding your products.'),
(1220, 1, 'shipping_class_costs', 'Shipping Class Costs'),
(1221, 1, 'shipping_class', 'Shipping Class'),
(1222, 1, 'select_your_location', 'Select Your Location'),
(1223, 1, 'product_does_not_ship_location', 'This product does not ship to this location.\r\n'),
(1224, 1, 'bank_accounts_exp', 'You can make your payment to one of these bank accounts.'),
(1225, 1, 'update_exchange_rates', 'Update Exchange Rates');

-- --------------------------------------------------------

--
-- Table structure for table `location_cities`
--

CREATE TABLE `location_cities` (
  `id` mediumint(9) NOT NULL,
  `name` varchar(200) NOT NULL,
  `country_id` smallint(6) NOT NULL,
  `state_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `location_countries`
--

CREATE TABLE `location_countries` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `continent_code` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location_states`
--

CREATE TABLE `location_states` (
  `id` mediumint(9) NOT NULL,
  `name` varchar(200) NOT NULL,
  `country_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `media_type` varchar(20) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `storage` varchar(20) DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `title_array` text DEFAULT NULL,
  `number_of_ads` int(11) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `is_free` tinyint(1) DEFAULT 0,
  `is_unlimited_number_of_ads` tinyint(1) DEFAULT 0,
  `is_unlimited_time` tinyint(1) DEFAULT 0,
  `features_array` text DEFAULT NULL,
  `plan_order` smallint(6) DEFAULT 1,
  `is_popular` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membership_transactions`
--

CREATE TABLE `membership_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `plan_title` varchar(500) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `buyer_type` varchar(20) DEFAULT NULL,
  `price_subtotal` varchar(50) DEFAULT NULL,
  `price_vat` bigint(20) DEFAULT 0,
  `price_shipping` varchar(50) DEFAULT NULL,
  `price_total` varchar(50) DEFAULT NULL,
  `price_currency` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `buyer_type` varchar(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT 'physical',
  `listing_type` varchar(20) DEFAULT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `product_slug` varchar(500) DEFAULT NULL,
  `product_unit_price` bigint(20) DEFAULT NULL,
  `product_quantity` tinyint(4) DEFAULT NULL,
  `product_currency` varchar(20) DEFAULT NULL,
  `product_vat_rate` double DEFAULT 0,
  `product_vat` bigint(20) DEFAULT 0,
  `product_total_price` bigint(20) DEFAULT NULL,
  `variation_option_ids` varchar(255) DEFAULT NULL,
  `commission_rate` tinyint(4) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `shipping_tracking_number` varchar(255) DEFAULT NULL,
  `shipping_tracking_url` varchar(500) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `seller_shipping_cost` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_shipping`
--

CREATE TABLE `order_shipping` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `shipping_first_name` varchar(255) DEFAULT NULL,
  `shipping_last_name` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_phone_number` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_zip_code` varchar(20) DEFAULT NULL,
  `billing_first_name` varchar(255) DEFAULT NULL,
  `billing_last_name` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `billing_phone_number` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_zip_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `page_content` longtext DEFAULT NULL,
  `page_order` int(11) DEFAULT 1,
  `visibility` tinyint(1) DEFAULT 1,
  `title_active` tinyint(1) DEFAULT 1,
  `location` varchar(50) DEFAULT 'information',
  `is_custom` tinyint(1) NOT NULL DEFAULT 1,
  `page_default_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `lang_id`, `title`, `slug`, `description`, `keywords`, `page_content`, `page_order`, `visibility`, `title_active`, `location`, `is_custom`, `page_default_name`, `created_at`) VALUES
(1, 1, 'Terms & Conditions', 'terms-conditions', 'Terms & Conditions Page', 'Terms, Conditions, Page', NULL, 1, 1, 1, 'information', 0, 'terms_conditions', '2020-11-21 10:40:30'),
(2, 1, 'Contact', 'contact', 'Contact Page', 'Contact, Page', NULL, 1, 1, 1, 'top_menu', 0, 'contact', '2020-11-21 10:40:30'),
(3, 1, 'Blog', 'blog', 'Blog Page', 'Blog, Page', NULL, 1, 1, 1, 'quick_links', 0, 'blog', '2020-11-21 10:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `purchased_plan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_key` varchar(255) DEFAULT NULL,
  `public_key` varchar(500) DEFAULT NULL,
  `secret_key` varchar(500) DEFAULT NULL,
  `environment` varchar(30) DEFAULT 'production',
  `locale` varchar(30) DEFAULT NULL,
  `base_currency` varchar(30) DEFAULT 'all',
  `status` tinyint(1) DEFAULT 0,
  `logos` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `name_key`, `public_key`, `secret_key`, `environment`, `locale`, `base_currency`, `status`, `logos`) VALUES
(1, 'PayPal', 'paypal', '', '', 'production', '', 'all', 0, 'visa,mastercard,amex,discover,paypal'),
(2, 'Stripe', 'stripe', '', '', 'production', 'auto', 'all', 0, 'visa,mastercard,amex,stripe'),
(3, 'Paystack', 'paystack', '', '', 'production', '', 'all', 0, 'visa,mastercard,verve,paystack'),
(4, 'Razorpay', 'razorpay', '', '', 'production', '', 'INR', 0, 'visa,mastercard,amex,maestro,diners,rupay,razorpay'),
(5, 'Flutterwave', 'flutterwave', '', '', 'production', '', 'all', 0, 'visa,mastercard,amex,maestro,flutterwave'),
(6, 'Iyzico', 'iyzico', '', '', 'production', '', 'TRY', 0, 'visa,mastercard,amex,troy,iyzico'),
(7, 'Midtrans', 'midtrans', '', '', 'production', '', 'IDR', 0, 'visa,mastercard,amex,jcb,midtrans');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL,
  `default_currency` varchar(30) DEFAULT 'USD',
  `allow_all_currencies_for_classied` tinyint(1) DEFAULT 1,
  `currency_converter` tinyint(1) DEFAULT 0,
  `auto_update_exchange_rates` tinyint(1) DEFAULT 1,
  `currency_converter_api` varchar(100) DEFAULT NULL,
  `currency_converter_api_key` varchar(255) DEFAULT NULL,
  `bank_transfer_enabled` tinyint(1) DEFAULT 0,
  `bank_transfer_accounts` text DEFAULT NULL,
  `cash_on_delivery_enabled` tinyint(1) DEFAULT 1,
  `price_per_day` bigint(20) DEFAULT 1,
  `price_per_month` bigint(20) DEFAULT 3,
  `free_product_promotion` tinyint(1) DEFAULT 0,
  `payout_paypal_enabled` tinyint(1) DEFAULT 1,
  `payout_iban_enabled` tinyint(1) DEFAULT 1,
  `payout_swift_enabled` tinyint(1) DEFAULT 1,
  `min_payout_paypal` bigint(20) DEFAULT 5000,
  `min_payout_iban` bigint(20) DEFAULT 5000,
  `min_payout_swift` bigint(20) DEFAULT 50000
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `default_currency`, `allow_all_currencies_for_classied`, `currency_converter`, `auto_update_exchange_rates`, `currency_converter_api`, `currency_converter_api_key`, `bank_transfer_enabled`, `bank_transfer_accounts`, `cash_on_delivery_enabled`, `price_per_day`, `price_per_month`, `free_product_promotion`, `payout_paypal_enabled`, `payout_iban_enabled`, `payout_swift_enabled`, `min_payout_paypal`, `min_payout_iban`, `min_payout_swift`) VALUES
(1, 'USD', 1, 0, 0, NULL, NULL, 0, NULL, 0, 10, 100, 0, 1, 1, 1, 5000, 5000, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payout_method` varchar(100) DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT 'physical',
  `listing_type` varchar(20) DEFAULT 'sell_on_site',
  `sku` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `discount_rate` smallint(3) DEFAULT 0,
  `vat_rate` double DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_promoted` tinyint(1) DEFAULT 0,
  `promote_start_date` timestamp NULL DEFAULT NULL,
  `promote_end_date` timestamp NULL DEFAULT NULL,
  `promote_plan` varchar(100) DEFAULT NULL,
  `promote_day` int(11) DEFAULT NULL,
  `is_special_offer` tinyint(1) DEFAULT 0,
  `special_offer_date` timestamp NULL DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `rating` varchar(50) DEFAULT '0',
  `pageviews` int(11) DEFAULT 0,
  `demo_url` varchar(1000) DEFAULT NULL,
  `external_link` varchar(1000) DEFAULT NULL,
  `files_included` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 1,
  `shipping_class_id` int(11) DEFAULT NULL,
  `shipping_delivery_time_id` int(11) DEFAULT NULL,
  `multiple_sale` tinyint(1) DEFAULT 1,
  `is_sold` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `is_draft` tinyint(1) DEFAULT 0,
  `is_free_product` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `lang_id` tinyint(4) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_license_keys`
--

CREATE TABLE `product_license_keys` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `license_key` varchar(500) DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_settings`
--

CREATE TABLE `product_settings` (
  `id` int(11) NOT NULL,
  `marketplace_sku` tinyint(1) DEFAULT 1,
  `marketplace_variations` tinyint(1) DEFAULT 1,
  `marketplace_shipping` tinyint(1) DEFAULT 1,
  `marketplace_product_location` tinyint(1) DEFAULT 1,
  `classified_price` tinyint(1) DEFAULT 1,
  `classified_price_required` tinyint(1) DEFAULT 1,
  `classified_product_location` tinyint(1) DEFAULT 1,
  `classified_external_link` tinyint(1) DEFAULT 1,
  `physical_demo_url` tinyint(1) DEFAULT 0,
  `physical_video_preview` tinyint(1) DEFAULT 1,
  `physical_audio_preview` tinyint(1) DEFAULT 1,
  `digital_demo_url` tinyint(1) DEFAULT 1,
  `digital_video_preview` tinyint(1) DEFAULT 1,
  `digital_audio_preview` tinyint(1) DEFAULT 1,
  `digital_allowed_file_extensions` varchar(500) DEFAULT 'zip',
  `sitemap_frequency` varchar(30) DEFAULT 'monthly',
  `sitemap_last_modification` varchar(30) DEFAULT 'server_response',
  `sitemap_priority` varchar(30) DEFAULT 'automatically'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_settings`
--

INSERT INTO `product_settings` (`id`, `marketplace_sku`, `marketplace_variations`, `marketplace_shipping`, `marketplace_product_location`, `classified_price`, `classified_price_required`, `classified_product_location`, `classified_external_link`, `physical_demo_url`, `physical_video_preview`, `physical_audio_preview`, `digital_demo_url`, `digital_video_preview`, `digital_audio_preview`, `digital_allowed_file_extensions`, `sitemap_frequency`, `sitemap_last_modification`, `sitemap_priority`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '\"zip\"', 'daily', 'server_response', 'automatically');

-- --------------------------------------------------------

--
-- Table structure for table `promoted_transactions`
--

CREATE TABLE `promoted_transactions` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `purchased_plan` varchar(255) DEFAULT NULL,
  `day_count` int(11) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_title` varchar(500) DEFAULT NULL,
  `product_quantity` mediumint(9) DEFAULT 1,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `price_offered` bigint(20) DEFAULT NULL,
  `price_currency` varchar(20) DEFAULT NULL,
  `is_buyer_deleted` tinyint(1) DEFAULT 0,
  `is_seller_deleted` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` varchar(10000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `route_key` varchar(100) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_key`, `route`) VALUES
(1, 'admin', 'admin'),
(2, 'blog', 'blog'),
(3, 'tag', 'tag'),
(4, 'quote_requests', 'quote-requests'),
(5, 'cart', 'cart'),
(6, 'shipping', 'shipping'),
(7, 'payment_method', 'payment-method'),
(8, 'payment', 'payment'),
(9, 'promote_payment_completed', 'promote-payment-completed'),
(10, 'orders', 'orders'),
(11, 'order_details', 'order-details'),
(12, 'order_completed', 'order-completed'),
(13, 'completed_orders', 'completed-orders'),
(14, 'messages', 'messages'),
(15, 'conversation', 'conversation'),
(16, 'dashboard', 'dashboard'),
(17, 'profile', 'profile'),
(18, 'wishlist', 'wishlist'),
(19, 'settings', 'settings'),
(20, 'update_profile', 'update-profile'),
(21, 'followers', 'followers'),
(22, 'following', 'following'),
(23, 'sales', 'sales'),
(24, 'sale', 'sale'),
(25, 'product', 'product'),
(26, 'add_product', 'add-product'),
(27, 'start_selling', 'start-selling'),
(28, 'products', 'products'),
(29, 'product_details', 'product-details'),
(30, 'edit_product', 'edit-product'),
(31, 'pending_products', 'pending-products'),
(32, 'hidden_products', 'hidden-products'),
(33, 'latest_products', 'latest-products'),
(34, 'featured_products', 'featured-products'),
(35, 'drafts', 'drafts'),
(36, 'bulk_product_upload', 'bulk-product-upload'),
(37, 'downloads', 'downloads'),
(38, 'seller', 'seller'),
(39, 'earnings', 'earnings'),
(40, 'withdraw_money', 'withdraw-money'),
(41, 'payouts', 'payouts'),
(42, 'set_payout_account', 'set-payout-account'),
(43, 'comments', 'comments'),
(44, 'reviews', 'reviews'),
(45, 'category', 'category'),
(46, 'completed_sales', 'completed-sales'),
(47, 'shop_settings', 'shop-settings'),
(49, 'shipping_address', 'shipping-address'),
(50, 'social_media', 'social-media'),
(51, 'search', 'search'),
(52, 'register', 'register'),
(53, 'members', 'members'),
(54, 'forgot_password', 'forgot-password'),
(55, 'change_password', 'change-password'),
(56, 'reset_password', 'reset-password'),
(57, 'rss_feeds', 'rss-feeds'),
(58, 'terms_conditions', 'terms-conditions'),
(59, 'contact', 'contact'),
(60, 'select_membership_plan', 'select-membership-plan'),
(61, 'membership_payment_completed', 'membership-payment-completed'),
(62, 'payment_history', 'payment-history'),
(63, 'expired_products', 'expired-products'),
(64, 'cover_image', 'cover-image'),
(65, 'sold_products', 'sold-products'),
(66, 'shipping_settings', 'shipping-settings'),
(67, 'add_shipping_zone', 'add-shipping-zone'),
(68, 'edit_shipping_zone', 'edit-shipping-zone');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `site_font` smallint(6) DEFAULT 19,
  `dashboard_font` smallint(6) DEFAULT 22,
  `site_title` varchar(255) DEFAULT NULL,
  `homepage_title` varchar(255) DEFAULT 'Home',
  `site_description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `whatsapp_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `about_footer` varchar(1000) DEFAULT NULL,
  `contact_text` text DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `copyright` varchar(500) DEFAULT NULL,
  `cookies_warning` tinyint(1) DEFAULT 0,
  `cookies_warning_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `lang_id`, `site_font`, `dashboard_font`, `site_title`, `homepage_title`, `site_description`, `keywords`, `facebook_url`, `twitter_url`, `instagram_url`, `pinterest_url`, `linkedin_url`, `vk_url`, `whatsapp_url`, `telegram_url`, `youtube_url`, `about_footer`, `contact_text`, `contact_address`, `contact_email`, `contact_phone`, `copyright`, `cookies_warning`, `cookies_warning_text`, `created_at`) VALUES
(1, 1, 19, 22, 'Modesy - Marketplace - Classified Ads Script', 'Home', 'Modesy Index Page', 'index, home, modesy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Copyright 2021 Modesy - All Rights Reserved.', 0, NULL, '2021-02-20 22:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `country_id` varchar(20) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_classes`
--

CREATE TABLE `shipping_classes` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_delivery_times`
--

CREATE TABLE `shipping_delivery_times` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `option_array` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zone_locations`
--

CREATE TABLE `shipping_zone_locations` (
  `id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `continent_code` varchar(10) DEFAULT NULL,
  `country_id` int(11) DEFAULT 0,
  `state_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zone_methods`
--

CREATE TABLE `shipping_zone_methods` (
  `id` int(11) NOT NULL,
  `name_array` text DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `method_type` varchar(100) DEFAULT NULL,
  `flat_rate_cost_calculation_type` varchar(100) DEFAULT NULL,
  `flat_rate_cost` bigint(20) DEFAULT NULL,
  `flat_rate_class_costs_array` text DEFAULT NULL,
  `local_pickup_cost` bigint(20) DEFAULT NULL,
  `free_shipping_min_amount` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `item_order` smallint(6) DEFAULT 1,
  `button_text` varchar(255) DEFAULT NULL,
  `animation_title` varchar(50) DEFAULT 'none',
  `animation_description` varchar(50) DEFAULT 'none',
  `animation_button` varchar(50) DEFAULT 'none',
  `image` varchar(255) DEFAULT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `text_color` varchar(30) DEFAULT '#ffffff',
  `button_color` varchar(30) DEFAULT '#222222',
  `button_text_color` varchar(30) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `storage_settings`
--

CREATE TABLE `storage_settings` (
  `id` int(11) NOT NULL,
  `storage` varchar(255) DEFAULT 'local',
  `aws_key` varchar(255) DEFAULT NULL,
  `aws_secret` varchar(255) DEFAULT NULL,
  `aws_bucket` varchar(255) DEFAULT NULL,
  `aws_region` varchar(255) DEFAULT 'us-west-2',
  `aws_base_url` varchar(1000) DEFAULT 'https://s3.amazonaws.com/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `storage_settings`
--

INSERT INTO `storage_settings` (`id`, `storage`, `aws_key`, `aws_secret`, `aws_bucket`, `aws_region`, `aws_base_url`) VALUES
(1, 'local', NULL, NULL, NULL, NULL, 'https://s3.amazonaws.com/');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` varchar(30) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_amount` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT 'name@domain.com',
  `email_status` tinyint(1) DEFAULT 0,
  `token` varchar(500) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'member',
  `balance` bigint(20) DEFAULT 0,
  `number_of_sales` int(11) DEFAULT 0,
  `user_type` varchar(20) DEFAULT 'registered',
  `facebook_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `vkontakte_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `cover_image_type` varchar(30) DEFAULT 'full_width',
  `banned` tinyint(1) DEFAULT 0,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `about_me` varchar(5000) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `show_email` tinyint(1) DEFAULT 0,
  `show_phone` tinyint(1) DEFAULT 0,
  `show_location` tinyint(1) DEFAULT 0,
  `personal_website_url` varchar(500) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `whatsapp_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `show_rss_feeds` tinyint(1) DEFAULT 0,
  `send_email_new_message` tinyint(1) DEFAULT 0,
  `is_active_shop_request` tinyint(1) DEFAULT 0,
  `is_membership_plan_expired` tinyint(1) DEFAULT 0,
  `is_used_free_plan` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_membership_plans`
--

CREATE TABLE `users_membership_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `plan_title` varchar(500) DEFAULT NULL,
  `number_of_ads` int(11) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT 'USD',
  `is_free` tinyint(1) DEFAULT 0,
  `is_unlimited_number_of_ads` tinyint(1) DEFAULT 0,
  `is_unlimited_time` tinyint(1) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `plan_status` tinyint(1) DEFAULT 0,
  `plan_start_date` timestamp NULL DEFAULT NULL,
  `plan_end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_payout_accounts`
--

CREATE TABLE `users_payout_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payout_paypal_email` varchar(255) DEFAULT NULL,
  `iban_full_name` varchar(255) DEFAULT NULL,
  `iban_country_id` varchar(20) DEFAULT NULL,
  `iban_bank_name` varchar(255) DEFAULT NULL,
  `iban_number` varchar(500) DEFAULT NULL,
  `swift_full_name` varchar(255) DEFAULT NULL,
  `swift_address` varchar(500) DEFAULT NULL,
  `swift_state` varchar(255) DEFAULT NULL,
  `swift_city` varchar(255) DEFAULT NULL,
  `swift_postcode` varchar(100) DEFAULT NULL,
  `swift_country_id` varchar(20) DEFAULT NULL,
  `swift_bank_account_holder_name` varchar(255) DEFAULT NULL,
  `swift_iban` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `swift_bank_name` varchar(255) DEFAULT NULL,
  `swift_bank_branch_city` varchar(255) DEFAULT NULL,
  `swift_bank_branch_country_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `label_names` text DEFAULT NULL,
  `variation_type` varchar(50) DEFAULT NULL,
  `insert_type` varchar(10) DEFAULT 'new',
  `option_display_type` varchar(30) DEFAULT 'text',
  `show_images_on_slider` tinyint(1) DEFAULT 0,
  `use_different_price` tinyint(1) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `variation_options`
--

CREATE TABLE `variation_options` (
  `id` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `option_names` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `discount_rate` smallint(3) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `use_default_price` tinyint(1) NOT NULL DEFAULT 0,
  `no_discount` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transfers`
--
ALTER TABLE `bank_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `blog_images`
--
ALTER TABLE `blog_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_is_featured` (`is_featured`),
  ADD KEY `idx_show_products_on_index` (`show_products_on_index`),
  ADD KEY `idx_category_order` (`category_order`),
  ADD KEY `idx_featured_order` (`featured_order`);

--
-- Indexes for table `categories_lang`
--
ALTER TABLE `categories_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender_id` (`sender_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`);

--
-- Indexes for table `conversation_messages`
--
ALTER TABLE `conversation_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_conversation_id` (`conversation_id`),
  ADD KEY `idx_sender_id` (`sender_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields_category`
--
ALTER TABLE `custom_fields_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_field_id` (`field_id`);

--
-- Indexes for table `custom_fields_options`
--
ALTER TABLE `custom_fields_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_field_id` (`field_id`),
  ADD KEY `idx_option_key` (`option_key`);

--
-- Indexes for table `custom_fields_options_lang`
--
ALTER TABLE `custom_fields_options_lang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_option_id` (`option_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `custom_fields_product`
--
ALTER TABLE `custom_fields_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_field_id` (`field_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_selected_option_id` (`selected_option_id`);

--
-- Indexes for table `digital_files`
--
ALTER TABLE `digital_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `digital_sales`
--
ALTER TABLE `digital_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_following_id` (`following_id`),
  ADD KEY `idx_follower_id` (`follower_id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_is_main` (`is_main`);

--
-- Indexes for table `images_file_manager`
--
ALTER TABLE `images_file_manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `images_variation`
--
ALTER TABLE `images_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_variation_option_id` (`variation_option_id`),
  ADD KEY `idx_is_main` (`is_main`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_translations`
--
ALTER TABLE `language_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `location_cities`
--
ALTER TABLE `location_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`);

--
-- Indexes for table `location_countries`
--
ALTER TABLE `location_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_states`
--
ALTER TABLE `location_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country_id` (`country_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_number` (`order_number`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_seller_id` (`seller_id`),
  ADD KEY `idx_buyer_id` (`buyer_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `order_shipping`
--
ALTER TABLE `order_shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_id` (`payment_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_is_promoted` (`is_promoted`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_is_deleted` (`is_deleted`),
  ADD KEY `idx_is_draft` (`is_draft`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_price` (`price`),
  ADD KEY `idx_discount_rate` (`discount_rate`),
  ADD KEY `idx_is_special_offer` (`is_special_offer`),
  ADD KEY `idx_is_sold` (`is_sold`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `product_license_keys`
--
ALTER TABLE `product_license_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_is_used` (`is_used`);

--
-- Indexes for table `product_settings`
--
ALTER TABLE `product_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promoted_transactions`
--
ALTER TABLE `promoted_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_seller_id` (`seller_id`),
  ADD KEY `idx_buyer_id` (`buyer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_classes`
--
ALTER TABLE `shipping_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `shipping_delivery_times`
--
ALTER TABLE `shipping_delivery_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zone_locations`
--
ALTER TABLE `shipping_zone_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_zone_id` (`zone_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `shipping_zone_methods`
--
ALTER TABLE `shipping_zone_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_zone_id` (`zone_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage_settings`
--
ALTER TABLE `storage_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_id` (`payment_id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_banned` (`banned`);

--
-- Indexes for table `users_membership_plans`
--
ALTER TABLE `users_membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_payout_accounts`
--
ALTER TABLE `users_payout_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_is_visible` (`is_visible`);

--
-- Indexes for table `variation_options`
--
ALTER TABLE `variation_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_variation_id` (`variation_id`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bank_transfers`
--
ALTER TABLE `bank_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_images`
--
ALTER TABLE `blog_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories_lang`
--
ALTER TABLE `categories_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversation_messages`
--
ALTER TABLE `conversation_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_category`
--
ALTER TABLE `custom_fields_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_options`
--
ALTER TABLE `custom_fields_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_options_lang`
--
ALTER TABLE `custom_fields_options_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields_product`
--
ALTER TABLE `custom_fields_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_files`
--
ALTER TABLE `digital_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_sales`
--
ALTER TABLE `digital_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homepage_banners`
--
ALTER TABLE `homepage_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images_file_manager`
--
ALTER TABLE `images_file_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images_variation`
--
ALTER TABLE `images_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_translations`
--
ALTER TABLE `language_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1226;

--
-- AUTO_INCREMENT for table `location_cities`
--
ALTER TABLE `location_cities`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_countries`
--
ALTER TABLE `location_countries`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_states`
--
ALTER TABLE `location_states`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_shipping`
--
ALTER TABLE `order_shipping`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_license_keys`
--
ALTER TABLE `product_license_keys`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_settings`
--
ALTER TABLE `product_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promoted_transactions`
--
ALTER TABLE `promoted_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_classes`
--
ALTER TABLE `shipping_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_delivery_times`
--
ALTER TABLE `shipping_delivery_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zone_locations`
--
ALTER TABLE `shipping_zone_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zone_methods`
--
ALTER TABLE `shipping_zone_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storage_settings`
--
ALTER TABLE `storage_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_membership_plans`
--
ALTER TABLE `users_membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_payout_accounts`
--
ALTER TABLE `users_payout_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variation_options`
--
ALTER TABLE `variation_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
