-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 19, 2021 at 10:03 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purcase_id` int(11) DEFAULT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bin` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `p_id`, `level`, `created_at`, `updated_at`) VALUES
(16, 'BB', NULL, NULL, '2021-05-23 09:06:06', '2021-05-23 09:06:06'),
(17, 'sdfsdf', NULL, NULL, '2021-06-14 08:06:25', '2021-06-14 08:06:25'),
(18, 'sdfsdf', NULL, NULL, '2021-06-14 08:06:26', '2021-06-14 08:06:26'),
(19, 'www', 17, NULL, '2021-06-14 08:06:34', '2021-06-14 08:06:34'),
(20, 'www', 17, NULL, '2021-06-14 08:06:35', '2021-06-14 08:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2021_03_10_124412_create_purchases', 1),
(10, '2021_03_10_125200_create_application', 1),
(11, '2021_03_10_125637_add_status', 1),
(12, '2021_03_15_112851_add_size', 1),
(13, '2021_03_16_114510_change_integer', 1),
(14, '2021_05_09_123244_create_categories', 1),
(15, '2021_05_09_123641_create_categories', 2),
(16, '2021_05_13_141649_product', 3),
(17, '2021_05_13_141659_order', 3),
(18, '2021_05_13_185101_add_image_path', 4),
(19, '2021_05_13_185125_add_image_path2', 4),
(20, '2021_05_15_103020_create_product_images', 5),
(21, '2021_05_15_105626_add_change_images', 6),
(22, '2021_05_20_145325_create_ordered', 7),
(23, '2021_05_20_150017_add_paid_to_users_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('01bf4dd9313cc9472939c47949bb45f4bddb400a1be8c442eab0c69ab60d2d09a1c9d8a7ce860efe', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:41:27', '2021-06-10 13:41:27', '2022-06-10 18:41:27'),
('04a1d51d3f2885c9f476e3adbfc0ff2d534c9f3a03a4d4ee8b943e0d18510c6381265046b36ae6df', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:58:54', '2021-06-14 07:58:54', '2022-06-14 12:58:54'),
('0b78de19d81a56711d49433322a530109c0e6b06616436a47c7f807bb22817c4db87668f9c18e4df', 1, 1, 'MyApp', '[]', 0, '2021-05-15 05:11:34', '2021-05-15 05:11:34', '2022-05-15 10:11:34'),
('0ffe032c2ff159c58accf743ec77638ac8acd452ee6d09fe637a7763df00c2c345f69c6d454f6a59', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:04:19', '2021-06-14 08:04:19', '2022-06-14 13:04:19'),
('10e4ef59a28a161e1998f588390df3d4e92be8f07b7bd89816345d5a6bc519bccfeca8360edf4e60', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:55:12', '2021-06-10 13:55:12', '2022-06-10 18:55:12'),
('1ab168ba99c1bd2d1a30a07dc3b10891a4de9f0c5c17669df6453544090b450d02e5270d09f2d71c', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:26:14', '2021-06-10 14:26:14', '2022-06-10 19:26:14'),
('1b1da62fd66da43f109c8d8c0b1c5bad82ca5ceace950f31004dd11ad5248418dfeae1a0a53a1c31', 2, 1, 'MyApp', '[]', 0, '2021-05-13 09:35:52', '2021-05-13 09:35:52', '2022-05-13 14:35:52'),
('2a008c5efdd8c8a84cd12361a695118a8493c53a51576e5cf5d29e70060294a980d0ef32f1e4e9a6', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:58:57', '2021-06-14 07:58:57', '2022-06-14 12:58:57'),
('30637d1bed21f056bd97ba7b2103d80fa47ee699f7bcdbdedaa3f621077cf72c3e261a95558e3634', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:16:52', '2021-06-10 14:16:52', '2022-06-10 19:16:52'),
('356c0eda83d90688bd554a237bf84227f5378ee8709daf03253197246c2d2254954220f9e16bf6d6', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:59:09', '2021-06-10 13:59:09', '2022-06-10 18:59:09'),
('362469756f976a387909cc70c4a44b023b88ce63f3bd841478d816cd272e476ceaca91d6a682dc06', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:22:28', '2021-06-10 14:22:28', '2022-06-10 19:22:28'),
('373cb31d073558aa4bb33f5905edcab78b23fa5c89bf6f4e55facd336c5f286ea545317ae86eea1c', 1, 1, 'MyApp', '[]', 0, '2021-05-15 11:15:48', '2021-05-15 11:15:48', '2022-05-15 16:15:48'),
('3be98b9076b95c14c590cb38b3bb6e4eae079c49f668afbef7db57736e447011681f82e7234b3c65', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:58:37', '2021-06-14 07:58:37', '2022-06-14 12:58:37'),
('3f2bfc328764c00bba2291d3aee27763fcd01afc78b48a914736ca6a1cb7d71c91eac9a192664277', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:52:42', '2021-06-10 13:52:42', '2022-06-10 18:52:42'),
('3fa18c5102b0b3a821318f61917dc9e187eff05495aaa72ca57876282228adbebe01ae191b34fde3', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:01:44', '2021-06-14 08:01:44', '2022-06-14 13:01:44'),
('42640794743dab92b213f28c8358efbb39d302d463a12075477339363a6774ff0e6fa0c41664308b', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:51:27', '2021-06-10 13:51:27', '2022-06-10 18:51:27'),
('4513046d03bc1386d2e2b865e755488df87fd20817543c3207c4fc3d69896d54ad55742c6b262e2a', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:25:31', '2021-06-10 14:25:31', '2022-06-10 19:25:31'),
('4698934a61cf6584e7c5eb8f2c03351f81686db5df3ccd48038cca0ff17ce387548e0b9e6be802e0', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:57:24', '2021-06-10 13:57:24', '2022-06-10 18:57:24'),
('4d238291a8b142791b0721c2d39bb810f6725a4238ffbd4ece30b00667f0ceb9f9ef3cad4483daae', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:53:28', '2021-06-10 13:53:28', '2022-06-10 18:53:28'),
('50ada449d20ad4c761abf1f7019b6cc191da1c9bab3ee0cad579215f9137f1d4c6669bb263482421', 1, 1, 'MyApp', '[]', 0, '2021-05-13 13:42:52', '2021-05-13 13:42:52', '2022-05-13 18:42:52'),
('53e2891dace5f0a526cc34fb389b426fad983881b2fcecde5fb348d7f169bef283f0596b501c223f', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:59:06', '2021-06-10 13:59:06', '2022-06-10 18:59:06'),
('5ff789c0cdd68079a056ed73a0fb05c9fc476a01a39c34dadb20570cb6cb3cebce47910462c5ee41', 1, 1, 'MyApp', '[]', 0, '2021-05-18 09:59:17', '2021-05-18 09:59:17', '2022-05-18 14:59:17'),
('62cb5f33167cfbf7421814fa42e8e44f02adb1366948250466b7900b67302177b531249214226549', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:37:58', '2021-06-10 14:37:58', '2022-06-10 19:37:58'),
('64ebb5e23b4ad3d3c2a80280bb527f904500c673c7a8c2adb8ad5b76e1f7fb1192d5a7d12d5718f7', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:47:57', '2021-06-10 13:47:57', '2022-06-10 18:47:57'),
('652e725adfbdbcda8e04ed7dda92bb80f63a9918c78c8f67b37b0fab970665a5374a9f6689a20be7', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:39:24', '2021-06-10 14:39:24', '2022-06-10 19:39:24'),
('67508b0d39d7d8b16373d73eb0b20ef0355f973678fd701eefc2d32857f1d62315bf443ad84b38e6', 1, 1, 'MyApp', '[]', 0, '2021-05-22 07:40:15', '2021-05-22 07:40:15', '2022-05-22 12:40:15'),
('6951292655fc77315dc78da322d888f77cfea213a9a1349d1a657aca46d21c3bdc09d5a17c78e48c', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:37:23', '2021-06-10 14:37:23', '2022-06-10 19:37:23'),
('7008d9f8e23f4cec179299bebfaf70388c1695121d61f8c1d215c3adc22b6ae4618f685fe2fa6557', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:59:09', '2021-06-10 13:59:09', '2022-06-10 18:59:09'),
('708bc1e45711adba4c13fabf1de0910876d471d2793c753a726628af6d3505ad8a925895e2608f57', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:44:38', '2021-06-10 13:44:38', '2022-06-10 18:44:38'),
('73f4d99bc458147a57e83a1a0758ce9c0d0244a8e9dea5ab83fb0d2fc396f1ca9b79115121604aeb', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:47:00', '2021-06-10 13:47:00', '2022-06-10 18:47:00'),
('7bb662f50967fc6bfd05ec0b0e7eca6a8f0c56c6dfa27b91d8129909e979126d525e521b5e471817', 1, 1, 'MyApp', '[]', 0, '2021-05-23 05:04:42', '2021-05-23 05:04:42', '2022-05-23 10:04:42'),
('7e61ad9645710df8488392c3afce5dc237446d9bbb5900f541ba68e00583a1d31bd239845e10cf3a', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:59:08', '2021-06-10 13:59:08', '2022-06-10 18:59:08'),
('8546efc5d207a1cfa52b4f769dc7d4d2099cae5038ac6fdc6e316e11745f31ff3a73bba1c4625d10', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:33', '2021-06-14 07:57:33', '2022-06-14 12:57:33'),
('883f66f3af57ed67d3a36e92f81cad8ee30c85095f5155b0cb8430962a3aa7f92b61c73c38a41125', 1, 1, 'MyApp', '[]', 0, '2021-06-09 13:20:41', '2021-06-09 13:20:41', '2022-06-09 18:20:41'),
('903448d2642af9ca27b51f181386f5f6c8a2debb1b3a914feebdf94fe5f37344431e9958c4956a1b', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:16:53', '2021-06-10 14:16:53', '2022-06-10 19:16:53'),
('9606e144d0de631a323696d5a41048ae8b20ee56b52f66e9f2859f343536d3a60803b610f091b783', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:31', '2021-06-14 07:57:31', '2022-06-14 12:57:31'),
('98c07e5f969dcb405406554dfc67ad3ab0bbd120fa54675a1fb491f5cc82e4b20cc8023a4f2a0410', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:16:50', '2021-06-10 14:16:50', '2022-06-10 19:16:50'),
('9bd74bc89f9064e331f9c6957e99bf865d4dc02d82de26675ea60e97d45ecba5f54fde445bd14635', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:37', '2021-06-14 07:57:37', '2022-06-14 12:57:37'),
('9d92c12435dfe4ac448495b7562e2a7897e33d2e3180d577cb9eed3ccf11776ea89a72ddede30d44', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:02:42', '2021-06-14 08:02:42', '2022-06-14 13:02:42'),
('a4100873644a469ff3956c2a92f1e2104e08b161d8f062913dbd5bbfb8575ba418dd8ebe1b5deb74', 1, 1, 'MyApp', '[]', 0, '2021-05-22 14:31:21', '2021-05-22 14:31:21', '2022-05-22 19:31:21'),
('a56d444c669a488bd58f88d43df23ba58e6267c16f73d7c7f013b72c45e094c8eb2da9f4dbafd894', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:50:00', '2021-06-10 13:50:00', '2022-06-10 18:50:00'),
('a596f5ecd3e214d2532ef90e4e20f611a5ae46aa365fce7c1d7c32d1f0922034a4063b1a0a717198', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:04:20', '2021-06-14 08:04:20', '2022-06-14 13:04:20'),
('aab4e53c4c66ca4890c94583677ae408f18e0e4b92b2e96de2e934174f7db459ee557f76798d2692', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:36:22', '2021-06-10 14:36:22', '2022-06-10 19:36:22'),
('ac768e77eba127e415fb2c83b9a3470de32a518d03944d1a4957d45b4fb20252919508cbf1688429', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:36', '2021-06-14 07:57:36', '2022-06-14 12:57:36'),
('ace85ba996f71950ae4c5a423700789a0d51c806a489f64403f16d72997a313dc9ba5cbc7589ee1a', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:29:35', '2021-06-10 14:29:35', '2022-06-10 19:29:35'),
('b5d0ab2093bd0c9984618bb32389c3156fbcb614b6d6310608710df87542d2b771d7d00e32858f0d', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:33:33', '2021-06-10 14:33:33', '2022-06-10 19:33:33'),
('bb683e36c5d9c2e7821226ede5eb677cb60d8a30be19bf05bbcefde379383b779266f252fc0846a2', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:47:28', '2021-06-10 13:47:28', '2022-06-10 18:47:28'),
('bbc71b93bb38a9b12c5953951d11e626505ac070ba395929c7b4ef36b9f4b04597a90a01b0efdf98', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:18:33', '2021-06-10 14:18:33', '2022-06-10 19:18:33'),
('bfc8b2a3b5f3b80012dd16cea5395411bc6690a1ef2255d89bb98eeb400a0c22157062396773377e', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:17:10', '2021-06-10 14:17:10', '2022-06-10 19:17:10'),
('c532fda2d837015f2cc746cddc7fa068d3926803337a960f61a44dde9470c5df7f66fecb2726f624', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:39:56', '2021-06-10 14:39:56', '2022-06-10 19:39:56'),
('cde2636c415cf253ec27e6b48e585ae9bd43f9c30f26d2464125ec4253244ef8be6c0315edf5503b', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:59:10', '2021-06-10 13:59:10', '2022-06-10 18:59:10'),
('ce0e15cc5641476380af0d9567d7a3bde8ff3fa270f7f0d14faf531ac62139189929e2dd9c13b6a8', 1, 1, 'MyApp', '[]', 0, '2021-05-13 12:38:10', '2021-05-13 12:38:10', '2022-05-13 17:38:10'),
('ce699789b99420950175a1d37e309194a31e5181a9ef2123df0015078261e18e60a5c52d8caeba02', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:02:16', '2021-06-14 08:02:16', '2022-06-14 13:02:16'),
('d0dd975fdbfec0695302e94ca48946c9c85ea82f2a2c1e58278ec590428c61191d66286500f33e07', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:04:16', '2021-06-14 08:04:16', '2022-06-14 13:04:16'),
('d27ff7e161633fe76107c30a8bc58a80a4af43b6b9e1a287f5f12e58d3b41622c3ecefb79a0ca999', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:24:12', '2021-06-10 14:24:12', '2022-06-10 19:24:12'),
('d2f171803ceb6f3125cf3ed00c033cdc22d3aa71cc96c3921db3e33a1b8e69ec2618aba2bffa280c', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:28:06', '2021-06-10 14:28:06', '2022-06-10 19:28:06'),
('d6438db697fb1f3483f40cf379c4339fdcbf0aaa1887f18629a42e9dc3570a9d42176a0245dec0c3', 1, 1, 'MyApp', '[]', 0, '2021-06-09 13:19:29', '2021-06-09 13:19:29', '2022-06-09 18:19:29'),
('d99ceb9e08ab35750f4d98f3adcab2e31e2be66ed1791646a2b6c9181f61001c0a2bfec1e57f9c49', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:03:01', '2021-06-14 08:03:01', '2022-06-14 13:03:01'),
('dda77aaa50f173b72e2a230b07e75fd5b68a687e56ac64aaad65030e21b6f836fd71bd0488430618', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:51:07', '2021-06-10 13:51:07', '2022-06-10 18:51:07'),
('de3323f1c452d38faa4fa041e4e3c1615ce619cc53307facbdda706ae44a865b5fbf9cb2d6f52c9f', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:05:03', '2021-06-14 08:05:03', '2022-06-14 13:05:03'),
('e9a3b56cdae73eadea1c837132cb99d7769857c53a5f675af8862589b417c2a68660e969e10c96a2', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:03:47', '2021-06-14 08:03:47', '2022-06-14 13:03:47'),
('e9b32de188a1e8f83b036a3c780c3e08829bdec3da47e0cd4688cd9b6d0c84d9a98e95ad38f63238', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:28:42', '2021-06-10 14:28:42', '2022-06-10 19:28:42'),
('ea191dfdca57ac2710f3fa371dd7990ab55120f2e33c9b7e9c15ba1f83248b577036e8d267061487', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:05:30', '2021-06-14 08:05:30', '2022-06-14 13:05:30'),
('eb41e233eb3721e61538736d9230d6b92e613d856802d5c672d33687008355aa989f7686be0e4dda', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:23:35', '2021-06-10 14:23:35', '2022-06-10 19:23:35'),
('edfbfe80954612eea0f209990bd2fd3c8cd4d5e27be93548ea322678f807479ef318d7c624171eb1', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:36', '2021-06-14 07:57:36', '2022-06-14 12:57:36'),
('ef6563570abdd9f2579cc26ab532a712c5aa2890843ffda86c48604db8f928e26ee9c9101469c66e', 1, 1, 'MyApp', '[]', 0, '2021-05-16 06:46:30', '2021-05-16 06:46:30', '2022-05-16 11:46:30'),
('f731f82543119ab4fe0697d731e5323668a2787e9c3d00b0df489d8a3a3c4f4f0a0f8413ed1ce478', 1, 1, 'MyApp', '[]', 0, '2021-06-14 08:05:05', '2021-06-14 08:05:05', '2022-06-14 13:05:05'),
('fa6a53abbad26cfee728ef28bb27a755bd29264d6ad89e263b92fe0429b3e273423934447c9d29f4', 1, 1, 'MyApp', '[]', 0, '2021-06-09 13:20:29', '2021-06-09 13:20:29', '2022-06-09 18:20:29'),
('fafce44a8d83bc005b5609e45ee41e336a79cf73c6fb04a8809c06832d48023e9b5510249f3b2c85', 1, 1, 'MyApp', '[]', 0, '2021-06-10 14:40:33', '2021-06-10 14:40:33', '2022-06-10 19:40:33'),
('fbee8f05fb0f610346f185a9978085dcbfc65427399e31eebbb213863d04ef69b1613aad75e23554', 1, 1, 'MyApp', '[]', 0, '2021-06-10 13:48:25', '2021-06-10 13:48:25', '2022-06-10 18:48:25'),
('fcfa17f03bf6435bc73f59bf0d88a9aa52394280ab527d3eda792815b710b5cd841323c85273a172', 1, 1, 'MyApp', '[]', 0, '2021-06-14 07:57:35', '2021-06-14 07:57:35', '2022-06-14 12:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'U1GN69LtFto3ta2fZJQBH5oKXRb5uCJbuUlRC797', NULL, 'http://localhost', 1, 0, 0, '2021-05-13 09:35:39', '2021-05-13 09:35:39'),
(2, NULL, 'Laravel Password Grant Client', 'RM99hYOKqrr9Bm66cO36F2Jj5nTc9d09BKIWiWnB', 'users', 'http://localhost', 0, 1, 0, '2021-05-13 09:35:39', '2021-05-13 09:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-05-13 09:35:39', '2021-05-13 09:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_path` longtext COLLATE utf8mb4_unicode_ci,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `name`, `description`, `price`, `count`, `size`, `category_id`, `sale`, `payed`, `created_at`, `updated_at`, `image_path`, `order_id`) VALUES
(1, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:02:08', '2021-06-09 13:02:08', NULL, 1),
(2, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:02:08', '2021-06-09 13:02:08', NULL, 1),
(3, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:03:58', '2021-06-09 13:03:58', NULL, 2),
(4, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:03:58', '2021-06-09 13:03:58', NULL, 2),
(5, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:04:05', '2021-06-09 13:04:05', NULL, 3),
(6, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:04:05', '2021-06-09 13:04:05', NULL, 3),
(7, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:06:09', '2021-06-09 13:06:09', NULL, 4),
(8, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:06:09', '2021-06-09 13:06:09', NULL, 4),
(9, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:06:14', '2021-06-09 13:06:14', NULL, 5),
(10, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:06:14', '2021-06-09 13:06:14', NULL, 5),
(11, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:07:34', '2021-06-09 13:07:34', NULL, 6),
(12, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:07:34', '2021-06-09 13:07:34', NULL, 6),
(13, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:09:32', '2021-06-09 13:09:32', NULL, 7),
(14, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:09:32', '2021-06-09 13:09:32', NULL, 7),
(15, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:10:58', '2021-06-09 13:10:58', NULL, 8),
(16, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:10:58', '2021-06-09 13:10:58', NULL, 8),
(17, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:21:41', '2021-06-09 13:21:41', NULL, 9),
(18, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:23:24', '2021-06-09 13:23:24', NULL, 10),
(19, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, '0', '2021-06-09 13:25:31', '2021-06-09 13:25:31', NULL, 11),
(20, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:26:08', '2021-06-09 13:26:08', NULL, 12),
(21, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:55:55', '2021-06-09 13:55:55', NULL, 13),
(22, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:57:35', '2021-06-09 13:57:35', NULL, 14),
(23, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:58:11', '2021-06-09 13:58:11', NULL, 15),
(24, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:58:49', '2021-06-09 13:58:49', NULL, 16),
(25, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:59:08', '2021-06-09 13:59:08', NULL, 17),
(26, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-09 13:59:21', '2021-06-09 13:59:21', NULL, 18),
(27, 'BBB', 'sdflkjsldf', 100, '2', NULL, 16, NULL, '0', '2021-06-10 13:32:45', '2021-06-10 13:32:45', NULL, 19),
(28, 'BBB', 'sdflkjsldf', 100, '4', NULL, 16, NULL, '0', '2021-06-14 08:08:12', '2021-06-14 08:08:12', NULL, 20),
(29, 'ssdfs', 'sdl;fs;dflk;sdf', 1200, '2', NULL, 16, NULL, '0', '2021-06-14 08:10:48', '2021-06-14 08:10:48', NULL, 33);

-- --------------------------------------------------------

--
-- Table structure for table `ordered`
--

CREATE TABLE `ordered` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `info` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ordered`
--

INSERT INTO `ordered` (`id`, `info`, `created_at`, `updated_at`) VALUES
(1, ' ', '2021-06-09 13:02:08', '2021-06-09 13:02:08'),
(2, ' ', '2021-06-09 13:03:58', '2021-06-09 13:03:58'),
(3, ' ', '2021-06-09 13:04:05', '2021-06-09 13:04:05'),
(4, ' ', '2021-06-09 13:06:09', '2021-06-09 13:06:09'),
(5, ' ', '2021-06-09 13:06:14', '2021-06-09 13:06:14'),
(6, ' ', '2021-06-09 13:07:34', '2021-06-09 13:07:34'),
(7, ' ', '2021-06-09 13:09:32', '2021-06-09 13:09:32'),
(8, ' ', '2021-06-09 13:10:58', '2021-06-09 13:10:58'),
(9, ' ', '2021-06-09 13:21:41', '2021-06-09 13:21:41'),
(10, ' ', '2021-06-09 13:23:24', '2021-06-09 13:23:24'),
(11, ' ', '2021-06-09 13:25:31', '2021-06-09 13:25:31'),
(12, ' ', '2021-06-09 13:26:08', '2021-06-09 13:26:08'),
(13, ' ', '2021-06-09 13:55:55', '2021-06-09 13:55:55'),
(14, ' ', '2021-06-09 13:57:35', '2021-06-09 13:57:35'),
(15, ' ', '2021-06-09 13:58:11', '2021-06-09 13:58:11'),
(16, ' ', '2021-06-09 13:58:49', '2021-06-09 13:58:49'),
(17, ' ', '2021-06-09 13:59:08', '2021-06-09 13:59:08'),
(18, ' ', '2021-06-09 13:59:21', '2021-06-09 13:59:21'),
(19, ' ', '2021-06-10 13:32:45', '2021-06-10 13:32:45'),
(20, ' ', '2021-06-14 08:08:12', '2021-06-14 08:08:12'),
(21, ' ', '2021-06-14 08:10:26', '2021-06-14 08:10:26'),
(22, ' ', '2021-06-14 08:10:27', '2021-06-14 08:10:27'),
(23, ' ', '2021-06-14 08:10:28', '2021-06-14 08:10:28'),
(24, ' ', '2021-06-14 08:10:29', '2021-06-14 08:10:29'),
(25, ' ', '2021-06-14 08:10:30', '2021-06-14 08:10:30'),
(26, ' ', '2021-06-14 08:10:30', '2021-06-14 08:10:30'),
(27, ' ', '2021-06-14 08:10:30', '2021-06-14 08:10:30'),
(28, ' ', '2021-06-14 08:10:31', '2021-06-14 08:10:31'),
(29, ' ', '2021-06-14 08:10:31', '2021-06-14 08:10:31'),
(30, ' ', '2021-06-14 08:10:31', '2021-06-14 08:10:31'),
(31, ' ', '2021-06-14 08:10:38', '2021-06-14 08:10:38'),
(32, ' ', '2021-06-14 08:10:41', '2021-06-14 08:10:41'),
(33, ' ', '2021-06-14 08:10:48', '2021-06-14 08:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_path` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `count`, `size`, `category_id`, `sale`, `new`, `top`, `created_at`, `updated_at`, `image_path`) VALUES
(16, 'BBB', 'sdflkjsldf', 100, '22', NULL, 16, NULL, NULL, NULL, '2021-05-23 09:36:28', '2021-05-23 09:36:28', NULL),
(17, 'CCC', 'sdflkjsldf', 100, '22', NULL, 16, NULL, NULL, NULL, '2021-05-23 09:36:49', '2021-05-23 09:36:49', NULL),
(18, 'ssdfs', 'sdl;fs;dflk;sdf', 1200, '2', NULL, 16, NULL, NULL, NULL, '2021-06-14 08:07:10', '2021-06-14 08:07:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` longtext COLLATE utf8mb4_unicode_ci,
  `deleted` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image_path`, `deleted`, `created_at`, `updated_at`, `product_id`) VALUES
(46, '/storage/products/23.05.2021/product-T5bSt6MEN00LnjN1kob8.png', 0, '2021-05-23 09:36:28', '2021-05-23 09:36:28', 16),
(47, '/storage/products/23.05.2021/product-ilh9wY4lp82QXvvA1C10.png', 0, '2021-05-23 09:36:49', '2021-05-23 09:36:49', 17),
(48, '/storage/products/23.05.2021/product-MXNoivrTIKVltT0jMVF1.svg', 0, '2021-05-23 09:36:49', '2021-05-23 09:36:49', 17),
(49, '/storage/products/14.06.2021/product-jH6oZr7UxjEoor74RtNs.png', 0, '2021-06-14 08:07:10', '2021-06-14 08:07:10', 18);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_purchase` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_purchase` int(11) DEFAULT NULL,
  `link_document` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Администратор системы', 'kenes@gmail.com', NULL, '$2y$10$HCeMNGcQ3jLvHKdm.5crpeOL65GOPpRcG5IEGwVKLYwy.vQPSs3qO', NULL, '2021-05-13 09:33:29', '2021-05-13 09:33:29'),
(2, 'Администратор системы', 'kenes2@gmail.com', NULL, '$2y$10$wbd3oy7SZNNRLedWtBdjYeYzCsEArM05Dt9CybyxO4cMJQppsXTVa', NULL, '2021-05-13 09:34:39', '2021-05-13 09:34:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered`
--
ALTER TABLE `ordered`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ordered`
--
ALTER TABLE `ordered`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
