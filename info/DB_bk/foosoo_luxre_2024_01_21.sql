-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql1404b.xserver.jp
-- 生成日時: 2024 年 1 月 21 日 22:06
-- サーバのバージョン： 5.7.27
-- PHP のバージョン: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `foosoo_luxre`
--
CREATE DATABASE IF NOT EXISTS `foosoo_luxre` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `foosoo_luxre`;

DELIMITER $$
--
-- プロシージャ
--
DROP PROCEDURE IF EXISTS `zankin`$$
CREATE DEFINER=`foosoo_luxre`@`sv1432.xserver.jp` PROCEDURE `zankin` (IN `target_serial_user` CHAR(10))   BEGIN
DECLARE paid_amount int;
DECLARE keiyaku_amount int;
DECLARE zankin_amount int;

SELECT SUM(amount_payment) INTO paid_amount from payment_histories where serial_user in (select serial_user from contracts where cancel is null and deleted_at is null and serial_user=target_serial_user) and deleted_at is null;

IF paid_amount is null then SET paid_amount=0;
END IF;

SELECT SUM(keiyaku_kingaku) INTO keiyaku_amount
  	FROM contracts
  	WHERE serial_user = target_serial_user and deleted_at is null;
IF keiyaku_amount is null then SET keiyaku_amount=0;
END IF;
   
SET zankin_amount = keiyaku_amount - paid_amount;
UPDATE users SET zankin=zankin_amount WHERE serial_user=target_serial_user;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- テーブルの構造 `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_admin` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `admins`
--

INSERT INTO `admins` (`id`, `created_at`, `updated_at`, `name`, `serial_admin`, `email`, `email_verified_at`, `password`, `remember_token`) VALUES
(1, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'fsuzuki', 'A_000', 'awa@szemi-gp.com', NULL, '$2y$12$LIGhL.dZlw56NTboriHFmumRFxKRIBA46BsZNsoWSf8OYGgxvNB9u', NULL),
(2, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'ksuzuki', 'A_001', 'moezbeauty.ts@gmail.com', NULL, '$2y$12$.xYNnzvs1JAxouv6hemoFuJVKArpko03dvsi1sGW2i08SbyrAEIoe', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_branch` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'シリアル ',
  `name_branch` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支店名',
  `postal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '郵便番号',
  `address_branch` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支店住所',
  `phone_branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支店メールアドレス',
  `open_date` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '開院日',
  `note` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `configrations`
--

DROP TABLE IF EXISTS `configrations`;
CREATE TABLE `configrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'key',
  `value1` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'value-1',
  `value2` text COLLATE utf8mb4_unicode_ci COMMENT 'value-2',
  `setumei` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '説明'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `configrations`
--

INSERT INTO `configrations` (`id`, `created_at`, `updated_at`, `subject`, `value1`, `value2`, `setumei`) VALUES
(1, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'KeiyakuNumMax', '24', NULL, '最大契約回数'),
(2, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'Card Company', 'VISA,Master,AMEX', NULL, 'クレジット会社'),
(3, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'DdisplayLineNumCustomerList', '15', NULL, '顧客リストの表示行数'),
(4, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'DdisplayLineNumContractList', '15', NULL, '契約リストの表示行数'),
(5, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'ReasonComing', 'ホットペッパー,Instagram,美シャインホームページ,知人の紹介,チラシ,その他', NULL, '来院のきっかけｹ'),
(6, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'MaxTreatmentsTimes', '24', NULL, '最大施術回'),
(7, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'PaymentNumMax', '12', NULL, '分割支払最大回数'),
(8, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'KesanMonth', '8', NULL, '決算月'),
(9, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'TargetContractMoney', '2022-05-3000000,2022-06-3000000,2022-08-1500000,2022-07-3500000,2022-02-200000,2022-04-3000000,2022-09-2000000,2022-03-3000000,2022-10-1500000,2022-11-1500000,2022-12-1500000,2023-01-1500000,2023-02-1500000,2023-03-1500000,2023-04-1500000,2023-05-1500000,2023-06-1500000,2023-07-1500000,2023-08-1500000,2023-09-1500000,2023-10-1000000,2023-11-1500000,2023-12-1500000,2024-01-1000000', NULL, '契約目標金額'),
(10, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'PageInf', 'top,メニュー,admin.top;ContractList,契約リスト,customers.ContractList.post;CustomersList,顧客リスト,customers.CustomersList.show.post;DailyReport,日報,admin.DailyReport.post;MonthlyReport,月報,admin.MonthlyReport.post;TreatmentList,施術一覧,admin.TreatmentList.post', NULL, 'URLから対応ページ設定');

-- --------------------------------------------------------

--
-- テーブルの構造 `contracts`
--

DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_keiyaku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約シリアル-自動',
  `serial_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'serial_user',
  `serial_staff` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID Staff',
  `course` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'コース',
  `treatments_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '施術シリアル',
  `keiyaku_kikan_start` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約開始日',
  `keiyaku_kikan_end` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約終了日',
  `keiyaku_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約形態(サブスク/期間・内容設定)',
  `keiyaku_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約名',
  `keiyaku_bi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約日',
  `keiyaku_kingaku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約金額',
  `keiyaku_num` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約回数',
  `keiyaku_kingaku_total` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約金額合計',
  `how_to_pay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い方法',
  `how_many_pay_genkin` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い回数-現金',
  `date_first_pay_genkin` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1回目支払日-現金',
  `date_second_pay_genkin` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '2回目支払日-現金',
  `amount_first_pay_cash` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1回目支払金額',
  `amount_second_pay_cash` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '2回目支払金額',
  `card_company` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'クレジットカード会社',
  `how_many_pay_card` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い回数-クレジットカード',
  `date_pay_card` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い日-クレジットカード',
  `tantosya` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '担当者',
  `serial_tantosya` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '担当者シリアル',
  `date_latest_visit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最終来店日',
  `cancel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'キャンセル日',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `contracts`
--

INSERT INTO `contracts` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_keiyaku`, `serial_user`, `serial_staff`, `course`, `treatments_num`, `keiyaku_kikan_start`, `keiyaku_kikan_end`, `keiyaku_type`, `keiyaku_name`, `keiyaku_bi`, `keiyaku_kingaku`, `keiyaku_num`, `keiyaku_kingaku_total`, `how_to_pay`, `how_many_pay_genkin`, `date_first_pay_genkin`, `date_second_pay_genkin`, `amount_first_pay_cash`, `amount_second_pay_cash`, `card_company`, `how_many_pay_card`, `date_pay_card`, `tantosya`, `serial_tantosya`, `date_latest_visit`, `cancel`, `remarks`) VALUES
(1, '2024-01-19 19:36:36', '2024-01-19 23:29:05', NULL, 'K_000001-0001', '000001', NULL, NULL, '1', '2024-01-20', '2024-01-20', 'cyclic', '脂肪冷却', '2024-01-20', '4900', 'K_000001-0001', '4900', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-01-20', NULL, 'SF_002', '2024-01-20', NULL, NULL);

--
-- トリガ `contracts`
--
DROP TRIGGER IF EXISTS `残金計算-keiyakus delete`;
DELIMITER $$
CREATE TRIGGER `残金計算-keiyakus delete` AFTER DELETE ON `contracts` FOR EACH ROW BEGIN
        CALL zankin(old.serial_user);
        END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `残金計算-keiyakus insert`;
DELIMITER $$
CREATE TRIGGER `残金計算-keiyakus insert` AFTER INSERT ON `contracts` FOR EACH ROW BEGIN
            CALL zankin(NEW.serial_user);
            END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `残金計算-keiyakus update`;
DELIMITER $$
CREATE TRIGGER `残金計算-keiyakus update` AFTER UPDATE ON `contracts` FOR EACH ROW BEGIN
            CALL zankin(NEW.serial_user);
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- テーブルの構造 `contract_details`
--

DROP TABLE IF EXISTS `contract_details`;
CREATE TABLE `contract_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contract_detail_serial` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約詳細シリアル',
  `serial_keiyaku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約番号',
  `serial_user` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'serial_user',
  `serial_staff` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID Staff',
  `keiyaku_naiyo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約内容',
  `keiyaku_num` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '回数',
  `unit_price` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '単価',
  `price` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '料金',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `contract_details`
--

INSERT INTO `contract_details` (`id`, `created_at`, `updated_at`, `deleted_at`, `contract_detail_serial`, `serial_keiyaku`, `serial_user`, `serial_staff`, `keiyaku_naiyo`, `keiyaku_num`, `unit_price`, `price`, `remarks`) VALUES
(3, '2024-01-19 23:29:05', '2024-01-19 23:29:05', NULL, 'K_000001-0001-0001', 'K_000001-0001', '000001', NULL, '脂肪冷却', '1', '4900', '4900', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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
-- テーブルの構造 `goods`
--

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_good` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_nmber` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '型番',
  `buying_price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '買値',
  `zaiko` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '在庫数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_11_20_062109_create_contracts_table', 1),
(7, '2023_11_20_062242_create_contract_details_table', 1),
(8, '2023_11_20_062417_create_payment_histories_table', 1),
(9, '2023_11_20_062504_create_visit_histories_table', 1),
(10, '2023_11_20_062548_create_sales_records_table', 1),
(11, '2023_11_20_062658_create_goods_table', 1),
(12, '2023_11_20_062742_create_recorders_table', 1),
(13, '2023_11_20_062826_create_treatment_contents_table', 1),
(14, '2023_11_20_062905_create_campaigns_table', 1),
(15, '2023_11_20_062936_create_referees_table', 1),
(16, '2023_11_20_063014_create_staff_table', 1),
(17, '2023_11_20_083628_create_configrations_table', 1),
(18, '2023_11_21_004758_create_admins_table', 1),
(19, '2023_11_23_054521_create_sessions_table', 1),
(20, '2023_11_24_020833_create_branches_table', 1),
(21, '2023_12_21_015213_create_trigger', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `payment_histories`
--

DROP TABLE IF EXISTS `payment_histories`;
CREATE TABLE `payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `payment_history_serial` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'テーブルシリアル',
  `serial_keiyaku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約番号',
  `serial_user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顧客番号',
  `serial_staff` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID Staff',
  `date_payment` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払日',
  `amount_payment` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払金額',
  `how_to_pay` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払方法',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `created_at`, `updated_at`, `deleted_at`, `payment_history_serial`, `serial_keiyaku`, `serial_user`, `serial_staff`, `date_payment`, `amount_payment`, `how_to_pay`, `remarks`) VALUES
(1, '2024-01-19 19:37:05', '2024-01-19 19:37:05', NULL, 'P_000001-0001-01', 'K_000001-0001', '000001', 'A_001', '2024-01-20', '4900', 'card', NULL);

--
-- トリガ `payment_histories`
--
DROP TRIGGER IF EXISTS `残金計算-payment_histories delete`;
DELIMITER $$
CREATE TRIGGER `残金計算-payment_histories delete` BEFORE DELETE ON `payment_histories` FOR EACH ROW BEGIN
            CALL zankin(OLD.serial_user);
            END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `残金計算-payment_histories insert`;
DELIMITER $$
CREATE TRIGGER `残金計算-payment_histories insert` AFTER INSERT ON `payment_histories` FOR EACH ROW BEGIN
            CALL zankin(NEW.serial_user);
            END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `残金計算-payment_histories update`;
DELIMITER $$
CREATE TRIGGER `残金計算-payment_histories update` AFTER UPDATE ON `payment_histories` FOR EACH ROW BEGIN
            CALL zankin(NEW.serial_user);
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- テーブルの構造 `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `recorders`
--

DROP TABLE IF EXISTS `recorders`;
CREATE TABLE `recorders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_recorder` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_recorder` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `recorders`
--

INSERT INTO `recorders` (`id`, `created_at`, `updated_at`, `deleted_at`, `id_recorder`, `name_recorder`, `location`, `location_url`, `memo`) VALUES
(1, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(2, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `referees`
--

DROP TABLE IF EXISTS `referees`;
CREATE TABLE `referees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `sales_records`
--

DROP TABLE IF EXISTS `sales_records`;
CREATE TABLE `sales_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_sales` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_good` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_sale` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '販売日',
  `selling_price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '販売価格',
  `buying_price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '仕入れ価格',
  `memo` text COLLATE utf8mb4_unicode_ci COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_staff` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_kanji` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name_kanji` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_kana` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name_kana` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `staff`
--

INSERT INTO `staff` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_staff`, `email`, `phone`, `last_name_kanji`, `first_name_kanji`, `last_name_kana`, `first_name_kana`, `birth_date`, `remember_token`) VALUES
(1, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'SF_001', NULL, NULL, '根岸', 'もえ子', 'ねぎし', 'もえこ', NULL, NULL),
(2, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'SF_002', NULL, NULL, '川島', '花乃', 'かわしま', 'かの', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `treatment_contents`
--

DROP TABLE IF EXISTS `treatment_contents`;
CREATE TABLE `treatment_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_treatment_contents` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '施術シリアル',
  `name_treatment_contents` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '施術名',
  `name_treatment_contents_kana` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '施術名カナ',
  `treatment_details` text COLLATE utf8mb4_unicode_ci COMMENT '施術説明',
  `memo` text COLLATE utf8mb4_unicode_ci COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `treatment_contents`
--

INSERT INTO `treatment_contents` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_treatment_contents`, `name_treatment_contents`, `name_treatment_contents_kana`, `treatment_details`, `memo`) VALUES
(1, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00003', '全顔脱毛', 'カオ', '顔全体し', NULL),
(2, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00005', '脇', 'ワキ', '脇', NULL),
(3, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00008', 'VIO', 'VIO', 'VIO', NULL),
(4, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00014', 'パーツ', 'パーツ', 'パーツ', NULL),
(5, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00017', 'ひざ上下・ひじ上下', 'ヒザジョウゲ', 'ひざ上下・ひじ上下', NULL),
(6, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00018', 'ひざ下', 'ヒザシタ', 'ひざ下', NULL),
(7, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00019', 'ひじ下', 'ヒジシタ', 'ひじ下', NULL),
(8, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00020', 'ひじ下ワキ', 'ヒジワキ', 'ひじ下ワキ', NULL),
(9, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00021', 'フェイシャル', 'フェイシャル', 'フェイシャル', NULL),
(10, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00022', 'マツエク', 'マツエク', 'マツエク', NULL),
(11, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00024', 'マッサージ', 'マッサージ', 'マッサージ', NULL),
(12, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00025', 'メイクアップ', 'メイクアップ', 'メイクアップ', NULL),
(13, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00027', '全身脱毛　顔VIO除く', 'ゼンシンダツモウ', '全身脱毛　顔VIO除く', NULL),
(14, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00028', '全身脱毛＋顔＋VIO', 'ゼンシンダツモウ', '全全身脱毛＋顔＋VIO', NULL),
(15, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00029', '全身脱毛10回コース（顔・VIO込）', NULL, NULL, NULL),
(16, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00030', 'キャビテーション', 'キャビテーション', NULL, NULL),
(17, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00031', '脱毛・キャビ・フェイシャル24回', 'ダツモウ', NULL, NULL),
(18, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00033', 'エリアシ', NULL, NULL, NULL),
(19, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00035', 'オールメニュー', 'オー', NULL, NULL),
(20, '2024-01-17 23:30:23', '2024-01-17 23:30:23', NULL, 'Tr_00036', 'ステラ痩身', 'ステラソウシン', '電磁パルス痩身', NULL),
(21, '2024-01-19 17:58:11', '2024-01-19 17:58:11', NULL, 'Tr_00037', '脂肪冷却', 'しぼうれいきゃく', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admission_date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Admission Date',
  `name_sei` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓',
  `name_mei` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名',
  `name_sei_kana` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'セイ',
  `name_mei_kana` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'メイ',
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_month` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_day` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_locality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_banti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci COMMENT '住所',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `reason_coming` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee_num` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee_target_serial` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zankin` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い残金',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_user`, `admission_date`, `name_sei`, `name_mei`, `name_sei_kana`, `name_mei_kana`, `gender`, `birth_year`, `birth_month`, `birth_day`, `postal`, `address_region`, `address_locality`, `address_banti`, `email`, `email_verified_at`, `phone`, `profile_photo_path`, `address`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `reason_coming`, `referee`, `referee_num`, `referee_target_serial`, `zankin`, `remember_token`) VALUES
(1, '2024-01-19 17:28:02', '2024-01-19 17:28:02', NULL, '000001', '2024-01-20', '橋本', '朋佳', 'はしもと', 'ともか', 'woman', '1996', '06', '19', '3290414', '9', '下野市小金井', '４‐11‐2　サダルースウドB101', NULL, NULL, '08032818619', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `visit_histories`
--

DROP TABLE IF EXISTS `visit_histories`;
CREATE TABLE `visit_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `visit_history_serial` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'テーブルシリアル',
  `serial_keiyaku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '契約番号',
  `serial_user` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'serial_user',
  `serial_staff` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'serial Staff',
  `date_visit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来店日',
  `treatment_dtails` text COLLATE utf8mb4_unicode_ci COMMENT '施術内容',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `visit_histories`
--

INSERT INTO `visit_histories` (`id`, `created_at`, `updated_at`, `deleted_at`, `visit_history_serial`, `serial_keiyaku`, `serial_user`, `serial_staff`, `date_visit`, `treatment_dtails`, `remarks`) VALUES
(1, '2024-01-19 19:37:05', '2024-01-19 23:32:14', NULL, 'V_000001-0001-01', 'K_000001-0001', '000001', NULL, '2024-01-20', '脂肪冷却', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_serial_admin_unique` (`serial_admin`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- テーブルのインデックス `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_serial_branch_unique` (`serial_branch`);

--
-- テーブルのインデックス `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `configrations`
--
ALTER TABLE `configrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contracts_serial_keiyaku_unique` (`serial_keiyaku`);

--
-- テーブルのインデックス `contract_details`
--
ALTER TABLE `contract_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contract_details_contract_detail_serial_unique` (`contract_detail_serial`);

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- テーブルのインデックス `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- テーブルのインデックス `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_histories_payment_history_serial_unique` (`payment_history_serial`);

--
-- テーブルのインデックス `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- テーブルのインデックス `recorders`
--
ALTER TABLE `recorders`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `referees`
--
ALTER TABLE `referees`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `sales_records`
--
ALTER TABLE `sales_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_records_serial_sales_unique` (`serial_sales`);

--
-- テーブルのインデックス `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- テーブルのインデックス `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_serial_staff_unique` (`serial_staff`);

--
-- テーブルのインデックス `treatment_contents`
--
ALTER TABLE `treatment_contents`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_serial_user_unique` (`serial_user`);

--
-- テーブルのインデックス `visit_histories`
--
ALTER TABLE `visit_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_histories_visit_history_serial_unique` (`visit_history_serial`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `configrations`
--
ALTER TABLE `configrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `contract_details`
--
ALTER TABLE `contract_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルの AUTO_INCREMENT `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `recorders`
--
ALTER TABLE `recorders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `referees`
--
ALTER TABLE `referees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `sales_records`
--
ALTER TABLE `sales_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `treatment_contents`
--
ALTER TABLE `treatment_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `visit_histories`
--
ALTER TABLE `visit_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
