-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql1404b.xserver.jp
-- 生成日時: 2024 年 2 月 21 日 09:07
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
(1, '2024-01-19 19:36:36', '2024-02-03 00:38:48', NULL, 'K_000001-0001', '000001', NULL, NULL, '1', '2024-01-20', NULL, 'cyclic', '脂肪冷却', '2024-01-20', '4900', 'K_000001-0001', '4900', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-01-20', NULL, 'SF_002', '2024-01-20', NULL, NULL),
(4, '2024-01-21 18:05:02', '2024-02-03 00:39:02', NULL, 'K_000002-0001', '000002', NULL, NULL, '1', '2024-01-22', NULL, 'cyclic', '脂肪冷却', '2024-01-22', '4500', 'K_000002-0001', '4500', '現金', '1', '2024-01-22', NULL, '4500', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-01-22', NULL, NULL),
(5, '2024-01-27 22:06:45', '2024-02-03 00:39:13', NULL, 'K_000003-0001', '000003', NULL, NULL, '1', '2024-01-28', NULL, 'cyclic', 'キャピ＋脂肪冷却（トライアル）', '2024-01-28', '3000', 'K_000003-0001', '3000', '現金', '1', '2024-01-28', NULL, '3000', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-01-28', NULL, NULL),
(6, '2024-02-02 21:47:18', '2024-02-03 00:39:25', NULL, 'K_000004-0001', '000004', NULL, NULL, '1', '2024-02-03', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-02-03', '1900', 'K_000004-0001', '1900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-03', NULL, 'SF_002', '2024-02-03', NULL, NULL),
(7, '2024-02-03 00:10:14', '2024-02-03 00:38:32', NULL, 'K_000005-0001', '000005', NULL, NULL, '1', '2024-02-03', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-02-03', '7900', 'K_000005-0001', '7900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-03', NULL, 'SF_002', '2024-02-03', NULL, NULL),
(8, '2024-02-03 00:35:09', '2024-02-03 00:58:57', NULL, 'K_000005-0002', '000005', NULL, NULL, NULL, '2024-02-03', NULL, 'subscription', 'キャピテーション', '2024-02-03', '11000', 'K_000005-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(15, '2024-02-06 22:39:45', '2024-02-06 22:43:19', NULL, 'K_000006-0001', '000006', NULL, NULL, '1', '2024-02-07', NULL, 'cyclic', '光フォトフェイシャル', '2024-02-07', '1300', 'K_000006-0001', '1300', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-02-07', NULL, 'SF_002', '2024-02-07', NULL, NULL),
(18, '2024-02-08 20:40:46', '2024-02-08 21:07:44', NULL, 'K_000007-0001', '000007', NULL, NULL, '1', '2024-02-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-09', '6500', 'K_000007-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-09', NULL, 'SF_002', '2024-02-09', NULL, NULL),
(20, '2024-02-10 01:23:00', '2024-02-10 01:24:47', NULL, 'K_000008-0001', '000008', NULL, NULL, '1', '2024-02-10', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-10', '6500', 'K_000008-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-10', NULL, 'SF_002', '2024-02-10', NULL, NULL),
(23, '2024-02-11 19:39:18', '2024-02-11 19:39:36', NULL, 'K_000009-0001', '000009', NULL, NULL, '1', '2024-02-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-02-12', '7900', 'K_000009-0001', '7900', '現金', '1', '2024-02-12', NULL, '7900', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-12', NULL, NULL),
(24, '2024-02-14 01:27:49', '2024-02-14 01:31:42', NULL, 'K_000010-0001', '000010', NULL, NULL, '1', '2024-02-14', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-14', '6000', 'K_000010-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', 'AMEX', '1', '2024-02-14', NULL, 'SF_002', '2024-02-14', NULL, NULL),
(25, '2024-02-14 01:31:36', '2024-02-14 23:33:46', NULL, 'K_000010-0002', '000010', NULL, NULL, NULL, '2024-02-14', NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-02-14', '12000', 'K_000010-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'AMEX', NULL, NULL, NULL, 'SF_002', '2024-02-15', NULL, NULL),
(28, '2024-02-16 18:11:22', '2024-02-16 18:13:07', NULL, 'K_000011-0001', '000011', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-02-17', '4500', 'K_000011-0001', '4500', '現金', '1', '2024-02-17', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(30, '2024-02-16 21:10:41', '2024-02-16 21:11:01', NULL, 'K_000012-0001', '000012', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-17', '6500', 'K_000012-0001', '6500', '現金', '1', '2024-02-17', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(31, '2024-02-17 18:41:24', '2024-02-17 18:43:03', NULL, 'K_000013-0001', '000013', NULL, NULL, '1', '2024-02-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-18', '6000', 'K_000013-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(33, '2024-02-17 20:17:20', '2024-02-17 20:54:01', NULL, 'K_000003-0002', '000003', NULL, NULL, '2', '2024-02-18', NULL, 'cyclic', '脂肪冷却', '2024-02-18', '9500', 'K_000003-0002', '9500', '現金', '1', '2024-02-18', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(34, '2024-02-17 20:20:35', '2024-02-17 20:51:22', '2024-02-17 20:51:22', 'K_000003-0003', '000003', NULL, NULL, '1', '2024-02-18', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-02-18', '4500', 'K_000003-0003', '4500', '現金', '1', '2024-02-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL);

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
(9, '2024-02-03 00:38:16', '2024-02-03 00:38:16', NULL, 'K_000005-0002-0001', 'K_000005-0002', '000005', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(10, '2024-02-03 00:38:32', '2024-02-03 00:38:32', NULL, 'K_000005-0001-0001', 'K_000005-0001', '000005', NULL, 'キャピ＋脂肪冷却', '1', '7900', '7900', NULL),
(11, '2024-02-03 00:38:48', '2024-02-03 00:38:48', NULL, 'K_000001-0001-0001', 'K_000001-0001', '000001', NULL, '脂肪冷却', '1', '4900', '4900', NULL),
(12, '2024-02-03 00:39:02', '2024-02-03 00:39:02', NULL, 'K_000002-0001-0001', 'K_000002-0001', '000002', NULL, '脂肪冷却', '1', '4500', '4500', NULL),
(13, '2024-02-03 00:39:13', '2024-02-03 00:39:13', NULL, 'K_000003-0001-0001', 'K_000003-0001', '000003', NULL, 'キャピ＋脂肪冷却', '1', '3000', '3000', NULL),
(14, '2024-02-03 00:39:25', '2024-02-03 00:39:25', NULL, 'K_000004-0001-0001', 'K_000004-0001', '000004', NULL, '全身脱毛＋顔＋VIO', '1', '1900', '1900', NULL),
(17, '2024-02-06 22:43:19', '2024-02-06 22:43:19', NULL, 'K_000006-0001-0001', 'K_000006-0001', '000006', NULL, 'フェイシャル', '1', '1300', '1300', NULL),
(19, '2024-02-08 21:06:59', '2024-02-08 21:06:59', NULL, 'K_000007-0001-0001', 'K_000007-0001', '000007', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(22, '2024-02-10 01:24:21', '2024-02-10 01:24:21', NULL, 'K_000008-0001-0001', 'K_000008-0001', '000008', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(23, '2024-02-11 19:39:19', '2024-02-11 19:39:19', NULL, 'K_000009-0001-0001', 'K_000009-0001', '000009', NULL, 'キャピ＋脂肪冷却', '1', '7900', '7900', NULL),
(26, '2024-02-14 01:31:42', '2024-02-14 01:31:42', NULL, 'K_000010-0001-0001', 'K_000010-0001', '000010', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(27, '2024-02-14 20:35:46', '2024-02-14 20:35:46', NULL, 'K_000010-0002-0001', 'K_000010-0002', '000010', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(29, '2024-02-16 18:12:59', '2024-02-16 18:12:59', NULL, 'K_000011-0001-0001', 'K_000011-0001', '000011', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL),
(30, '2024-02-16 21:10:41', '2024-02-16 21:10:41', NULL, 'K_000012-0001-0001', 'K_000012-0001', '000012', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(32, '2024-02-17 18:43:03', '2024-02-17 18:43:03', NULL, 'K_000013-0001-0001', 'K_000013-0001', '000013', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(34, '2024-02-17 20:20:35', '2024-02-17 20:51:22', '2024-02-17 20:51:22', 'K_000003-0003-0001', 'K_000003-0003', '000003', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL),
(41, '2024-02-17 20:53:50', '2024-02-17 20:53:50', NULL, 'K_000003-0002-0001', 'K_000003-0002', '000003', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(42, '2024-02-17 20:53:50', '2024-02-17 20:53:50', NULL, 'K_000003-0002-0002', 'K_000003-0002', '000003', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL);

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
-- テーブルの構造 `in_out_histories`
--

DROP TABLE IF EXISTS `in_out_histories`;
CREATE TABLE `in_out_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `target_serial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '対象者シリアル',
  `target_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日付',
  `time_in` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '入出時間',
  `time_out` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '退出時間',
  `target_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '氏名',
  `student_name_kana` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'しめい',
  `to_mail_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '送り先メールアドレス',
  `from_mail_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '送り元メールアドレス'
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
(21, '2023_12_21_015213_create_trigger', 1),
(22, '2024_01_19_085913_create_in_out_histories_table', 2);

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
(1, '2024-01-19 19:37:05', '2024-01-19 19:37:05', NULL, 'P_000001-0001-01', 'K_000001-0001', '000001', 'A_001', '2024-01-20', '4900', 'card', NULL),
(2, '2024-01-21 18:06:17', '2024-01-21 18:06:17', NULL, 'P_000002-0001-01', 'K_000002-0001', '000002', 'A_001', '2024-01-22', '4500', 'cash', NULL),
(3, '2024-01-27 22:08:30', '2024-01-27 22:08:30', NULL, 'P_000003-0001-01', 'K_000003-0001', '000003', 'A_001', '2024-01-28', '3000', 'cash', NULL),
(4, '2024-02-02 21:47:39', '2024-02-02 21:47:39', NULL, 'P_000004-0001-01', 'K_000004-0001', '000004', 'A_001', '2024-02-03', '1900', 'card', NULL),
(5, '2024-02-03 00:34:05', '2024-02-03 00:34:05', NULL, 'P_000005-0001-01', 'K_000005-0001', '000005', 'A_001', '2024-02-03', '7900', 'card', NULL),
(6, '2024-02-03 00:58:57', '2024-02-03 00:58:57', NULL, 'P_000005-0002-01', 'K_000005-0002', '000005', 'A_001', '2024-02-03', '11000', 'card', NULL),
(9, '2024-02-06 22:41:54', '2024-02-06 22:41:54', NULL, 'P_000006-0001-01', 'K_000006-0001', '000006', 'A_001', '2024-02-07', '1300', 'card', NULL),
(11, '2024-02-08 21:07:44', '2024-02-08 21:07:44', NULL, 'P_000007-0001-01', 'K_000007-0001', '000007', 'A_001', '2024-02-09', '6500', 'paypay', NULL),
(12, '2024-02-10 01:24:47', '2024-02-10 01:24:47', NULL, 'P_000008-0001-01', 'K_000008-0001', '000008', 'A_001', '2024-02-10', '6500', 'paypay', NULL),
(13, '2024-02-11 19:39:36', '2024-02-11 19:39:36', NULL, 'P_000009-0001-01', 'K_000009-0001', '000009', 'A_001', '2024-02-12', '7900', 'cash', NULL),
(14, '2024-02-14 01:28:14', '2024-02-14 01:28:14', NULL, 'P_000010-0001-01', 'K_000010-0001', '000010', 'A_001', '2024-02-14', '6000', 'card', NULL),
(16, '2024-02-14 23:33:46', '2024-02-14 23:33:46', NULL, 'P_000010-0002-01', 'K_000010-0002', '000010', 'A_001', '2024-02-14', '12000', 'card', NULL),
(17, '2024-02-14 23:33:46', '2024-02-14 23:33:46', NULL, 'P_000010-0002-02', 'K_000010-0002', '000010', 'A_001', '2024-02-15', '12000', 'card', NULL),
(20, '2024-02-16 18:13:07', '2024-02-16 18:13:07', NULL, 'P_000011-0001-01', 'K_000011-0001', '000011', 'A_001', '2024-02-17', '4500', 'cash', NULL),
(21, '2024-02-16 21:11:01', '2024-02-16 21:11:01', NULL, 'P_000012-0001-01', 'K_000012-0001', '000012', 'A_001', '2024-02-17', '6500', 'cash', NULL),
(22, '2024-02-17 18:41:42', '2024-02-17 18:41:42', NULL, 'P_000013-0001-01', 'K_000013-0001', '000013', 'A_001', '2024-02-18', '6000', 'paypay', NULL),
(24, '2024-02-17 20:20:55', '2024-02-17 20:51:22', '2024-02-17 20:51:22', 'P_000003-0003-01', 'K_000003-0003', '000003', 'A_001', '2024-02-18', '4500', 'cash', NULL),
(27, '2024-02-17 20:54:01', '2024-02-17 20:54:01', NULL, 'P_000003-0002-01', 'K_000003-0002', '000003', 'A_001', '2024-02-18', '9500', 'cash', NULL);

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
(2, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(3, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(4, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(5, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(6, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(7, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(8, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(9, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(10, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(11, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(12, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(13, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(14, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(15, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(16, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(17, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(18, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(19, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(20, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(21, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(22, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(23, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(24, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(25, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(26, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(27, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(28, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(29, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(30, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL);

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
(21, '2024-01-19 17:58:11', '2024-01-19 17:58:11', NULL, 'Tr_00037', '脂肪冷却', 'しぼうれいきゃく', NULL, NULL),
(22, '2024-01-27 20:32:23', '2024-01-27 20:32:23', NULL, 'Tr_00038', 'キャピ＋脂肪冷却', 'しぼうれいきゃく', NULL, NULL),
(23, '2024-01-27 20:32:55', '2024-01-27 20:32:55', NULL, 'Tr_00039', 'キャピ＋脂肪冷却', 'しぼうれいきゃく', NULL, NULL),
(24, '2024-02-08 21:06:40', '2024-02-08 21:06:40', NULL, 'Tr_00040', 'ハイドラ＋フォト', 'はいどらふぉと', NULL, NULL),
(25, '2024-02-16 18:12:36', '2024-02-16 18:12:36', NULL, 'Tr_00041', 'ハイドラフェイシャル', 'はいどらふぇいしゃる', NULL, NULL);

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
(1, '2024-01-19 17:28:02', '2024-01-19 17:28:02', NULL, '000001', '2024-01-20', '橋本', '朋佳', 'はしもと', 'ともか', 'woman', '1996', '06', '19', '3290414', '9', '下野市小金井', '４‐11‐2　サダルースウドB101', NULL, NULL, '08032818619', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(2, '2024-01-21 17:03:15', '2024-01-21 17:03:15', NULL, '000002', '2024-01-22', '永島', '晴奈', 'ながしま', 'はるな', 'woman', '1999', '08', '23', '3294308', '9', '栃木市岩船町下津原', '198', NULL, NULL, '08081230056', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(3, '2024-01-27 20:30:16', '2024-01-27 20:30:16', NULL, '000003', '2024-01-28', '一色', '道代', 'いっしき', 'みちよ', 'woman', '1990', '05', '08', '3290205', '9', '小山市間々田', '2456‐39', NULL, NULL, '08098784793', NULL, NULL, NULL, NULL, NULL, NULL, 'その他(鈴木さん紹介)', '', NULL, NULL, '0', NULL),
(4, '2024-02-02 20:05:20', '2024-02-02 20:05:20', NULL, '000004', '2024-02-03', '白石', '千尋', 'しらいし', 'ちひろ', 'woman', '1996', '12', '12', '3230819', '9', '小山市横倉新田', '91‐4', NULL, NULL, '08011585347', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(5, '2024-02-02 22:47:54', '2024-02-02 22:47:54', NULL, '000005', '2024-02-03', '碓井', '裕子', 'うすい', 'ゆうこ', 'woman', '1983', '09', '04', '3070005', '8', '結城市川木谷', '1‐3‐9', NULL, NULL, '09052119167', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(6, '2024-02-06 22:37:58', '2024-02-06 22:37:58', NULL, '000006', '2024-02-07', '清水', '恵子', 'しみず', 'けいこ', 'woman', '1975', '02', '14', '3070001', '8', '結城市結城', '9946-261', NULL, NULL, '0805359785', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(7, '2024-02-08 20:39:13', '2024-02-08 20:41:32', NULL, '000007', '2024-02-09', '水上', '由記', 'みずかみ', 'ゆき', 'woman', '1975', '03', '23', '3400145', '11', '幸手市平須賀', '2‐9', NULL, NULL, '08013935815', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(9, '2024-02-10 00:05:51', '2024-02-10 01:23:17', NULL, '000008', '2024-02-10', '西片', 'ひなた', 'にしかた', 'ひなた', 'woman', '2002', '08', '06', '3230829', '9', '小山市東城南', '1‐25‐11', NULL, NULL, '09092171635', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(11, '2024-02-11 18:00:52', '2024-02-11 18:00:52', NULL, '000009', '2024-02-12', '川澄', 'めぐみ', 'かわすみ', 'めぐみ', 'woman', '1988', '12', '20', '3230824', '9', '小山市雨ケ谷新田', '78‐63', NULL, NULL, '09080093844', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(12, '2024-02-14 01:26:50', '2024-02-14 01:26:50', NULL, '000010', '2024-02-14', '佐藤', '真未', 'さとう', 'まみ', 'woman', '1988', '10', '31', '3290212', '9', '小山市平和', '86‐7', NULL, NULL, '08011862467', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '-12000', NULL),
(13, '2024-02-16 18:10:12', '2024-02-16 18:10:12', NULL, '000011', '2024-02-17', '五月女', '笑優', 'そうとめ', 'まゆ', 'woman', '2003', '09', '01', '3231104', '9', '栃木市藤岡町藤岡', '1421‐1', NULL, NULL, '08084711619', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(14, '2024-02-16 21:10:03', '2024-02-16 21:10:03', NULL, '000012', '2024-02-17', '小林', '美羽', 'こばやし', 'みう', 'woman', '2001', '08', '03', '3290201', '8', '小山市栗宮', '2‐2‐20', NULL, NULL, '07021995078', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(15, '2024-02-17 18:40:28', '2024-02-17 18:40:28', NULL, '000013', '2024-02-18', '池田', '千恵子', 'いけだ', 'ちえこ', 'woman', '1974', '10', '23', '3070053', '8', '結城市新福寺', '2‐18‐14', NULL, NULL, '09023333613', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL);

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
(1, '2024-01-19 19:37:05', '2024-02-06 23:37:32', NULL, 'V_000001-0001-01', 'K_000001-0001', '000001', 'SF_002', '2024-01-20', '脂肪冷却', NULL),
(2, '2024-01-21 18:06:17', '2024-01-21 18:06:17', NULL, 'V_000002-0001-01', 'K_000002-0001', '000002', NULL, '2024-01-22', '脂肪冷却', NULL),
(3, '2024-01-27 22:08:30', '2024-01-27 22:11:30', NULL, 'V_000003-0001-01', 'K_000003-0001', '000003', NULL, '2024-01-28', 'キャピ＋脂肪冷却', NULL),
(4, '2024-02-02 21:47:39', '2024-02-06 23:39:33', NULL, 'V_000004-0001-01', 'K_000004-0001', '000004', 'SF_002', '2024-02-03', '全身脱毛＋顔＋VIO', NULL),
(5, '2024-02-03 00:34:05', '2024-02-03 00:34:05', NULL, 'V_000005-0001-01', 'K_000005-0001', '000005', NULL, '2024-02-03', '0', NULL),
(6, '2024-02-06 22:41:54', '2024-02-06 22:42:26', NULL, 'V_000006-0001-01', 'K_000006-0001', '000006', 'SF_002', '2024-02-07', 'フェイシャル', NULL),
(7, '2024-02-08 20:41:05', '2024-02-08 21:07:44', NULL, 'V_000007-0001-01', 'K_000007-0001', '000007', NULL, '2024-02-09', 'ハイドラ＋フォト', NULL),
(9, '2024-02-10 01:24:47', '2024-02-10 01:25:02', NULL, 'V_000008-0001-01', 'K_000008-0001', '000008', 'SF_002', '2024-02-10', 'ハイドラ＋フォト', NULL),
(10, '2024-02-11 19:39:36', '2024-02-11 19:40:33', NULL, 'V_000009-0001-01', 'K_000009-0001', '000009', 'SF_002', '2024-02-12', 'キャピ＋脂肪冷却', NULL),
(11, '2024-02-14 01:28:14', '2024-02-14 01:28:27', NULL, 'V_000010-0001-01', 'K_000010-0001', '000010', 'SF_002', '2024-02-14', 'ハイドラ＋フォト', NULL),
(12, '2024-02-14 23:33:46', '2024-02-14 23:35:30', NULL, 'V_000010-0002-01', 'K_000010-0002', '000010', 'SF_002', '2024-02-15', '全身脱毛＋顔＋VIO', NULL),
(13, '2024-02-16 18:11:45', '2024-02-16 18:13:07', NULL, 'V_000011-0001-01', 'K_000011-0001', '000011', NULL, '2024-02-17', 'ハイドラフェイシャル', NULL),
(15, '2024-02-16 21:11:01', '2024-02-16 21:11:20', NULL, 'V_000012-0001-01', 'K_000012-0001', '000012', 'SF_002', '2024-02-17', 'ハイドラ＋フォト', NULL),
(16, '2024-02-17 18:41:42', '2024-02-17 18:41:56', NULL, 'V_000013-0001-01', 'K_000013-0001', '000013', 'SF_002', '2024-02-18', 'ハイドラ＋フォト', NULL),
(17, '2024-02-17 20:17:41', '2024-02-17 20:54:01', NULL, 'V_000003-0002-01', 'K_000003-0002', '000003', NULL, '2024-02-18', '脂肪冷却', NULL),
(18, '2024-02-17 20:20:55', '2024-02-17 20:51:22', '2024-02-17 20:51:22', 'V_000003-0003-01', 'K_000003-0003', '000003', NULL, '2024-02-18', 'ハイドラフェイシャル', NULL),
(21, '2024-02-17 20:52:53', '2024-02-17 20:54:01', NULL, 'V_000003-0002-02', 'K_000003-0002', '000003', NULL, '2024-02-18', 'ハイドラフェイシャル', NULL);

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
-- テーブルのインデックス `in_out_histories`
--
ALTER TABLE `in_out_histories`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- テーブルの AUTO_INCREMENT `contract_details`
--
ALTER TABLE `contract_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- テーブルの AUTO_INCREMENT `in_out_histories`
--
ALTER TABLE `in_out_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルの AUTO_INCREMENT `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `recorders`
--
ALTER TABLE `recorders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `visit_histories`
--
ALTER TABLE `visit_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
