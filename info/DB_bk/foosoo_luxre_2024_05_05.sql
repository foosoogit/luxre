-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql1404b.xserver.jp
-- 生成日時: 2024 年 5 月 05 日 16:23
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
DROP PROCEDURE IF EXISTS `total_point`$$
CREATE DEFINER=`foosoo_luxre`@`sv1432.xserver.jp` PROCEDURE `total_point` (IN `target_serial_user` VARCHAR(10) CHARSET utf8)   BEGIN
	DECLARE t_point int;
	SELECT SUM(point) INTO t_point from points where serial_user =  target_serial_user and deleted_at is null;
	UPDATE users SET total_points=t_point WHERE serial_user=target_serial_user;
END$$

DROP PROCEDURE IF EXISTS `zankin`$$
CREATE DEFINER=`foosoo_luxre`@`sv1432.xserver.jp` PROCEDURE `zankin` (IN `target_serial_user` CHAR(10))   BEGIN
DECLARE paid_amount int;
DECLARE keiyaku_amount int;
DECLARE zankin_amount int;

/*
SELECT SUM(amount_payment) INTO paid_amount from payment_histories where serial_user in (select serial_user from contracts where cancel is null and deleted_at is null and serial_user=target_serial_user) and deleted_at is null;
*/

SELECT SUM(amount_payment) INTO paid_amount from payment_histories where serial_keiyaku in (select serial_keiyaku from contracts where cancel is null and deleted_at is null and keiyaku_type<>"subscription" and serial_user=target_serial_user);

IF paid_amount is null then SET paid_amount=0;
END IF;

SELECT SUM(keiyaku_kingaku) INTO keiyaku_amount
  	FROM contracts
  	WHERE serial_user = target_serial_user and deleted_at is null and keiyaku_type<>"subscription";
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
(10, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'PageInf', 'top,メニュー,admin.top;ContractList,契約リスト,customers.ContractList.post;CustomersList,顧客リスト,customers.CustomersList.show.post;DailyReport,日報,admin.DailyReport.post;MonthlyReport,月報,admin.MonthlyReport.post;TreatmentList,施術一覧,admin.TreatmentList.post', NULL, 'URLから対応ページ設定'),
(11, '2024-04-01 02:38:20', '2024-04-25 06:29:24', 'UserPointVisit', '10', NULL, '来店時ポイント'),
(12, '2024-04-14 02:25:52', '2024-04-25 06:29:24', 'UserPointReferral', '20', NULL, '紹介時ポイント'),
(13, NULL, NULL, 'PointValidityTerm', '1', NULL, 'ポイント有効期間(年数)');

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
  `keiyaku_kikan_start` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約開始日',
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
(5, '2024-01-27 22:06:45', '2024-03-06 17:42:25', NULL, 'K_000003-0001', '000003', NULL, NULL, '1', '2024-01-28', NULL, 'cyclic', 'キャピ＋脂肪冷却（トライアル）', '2024-01-28', '3000', 'K_000003-0001', '3000', '現金', '1', '2024-01-28', NULL, '3000', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-01-28', NULL, NULL),
(6, '2024-02-02 21:47:18', '2024-02-03 00:39:25', NULL, 'K_000004-0001', '000004', NULL, NULL, '1', '2024-02-03', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-02-03', '1900', 'K_000004-0001', '1900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-03', NULL, 'SF_002', '2024-02-03', NULL, NULL),
(7, '2024-02-03 00:10:14', '2024-02-03 00:38:32', NULL, 'K_000005-0001', '000005', NULL, NULL, '1', '2024-02-03', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-02-03', '7900', 'K_000005-0001', '7900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-03', NULL, 'SF_002', '2024-02-03', NULL, NULL),
(8, '2024-02-03 00:35:09', '2024-04-22 10:02:17', NULL, 'K_000005-0002', '000005', NULL, NULL, NULL, '2024-02-03', NULL, 'subscription', 'キャピテーション', '2024-02-03', '11000', 'K_000005-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-03-28', NULL, NULL),
(15, '2024-02-06 22:39:45', '2024-02-06 22:43:19', NULL, 'K_000006-0001', '000006', NULL, NULL, '1', '2024-02-07', NULL, 'cyclic', '光フォトフェイシャル', '2024-02-07', '1300', 'K_000006-0001', '1300', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-02-07', NULL, 'SF_002', '2024-02-07', NULL, NULL),
(18, '2024-02-08 20:40:46', '2024-02-08 21:07:44', NULL, 'K_000007-0001', '000007', NULL, NULL, '1', '2024-02-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-09', '6500', 'K_000007-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-09', NULL, 'SF_002', '2024-02-09', NULL, NULL),
(20, '2024-02-10 01:23:00', '2024-02-10 01:24:47', NULL, 'K_000008-0001', '000008', NULL, NULL, '1', '2024-02-10', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-10', '6500', 'K_000008-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-02-10', NULL, 'SF_002', '2024-02-10', NULL, NULL),
(23, '2024-02-11 19:39:18', '2024-02-11 19:39:36', NULL, 'K_000009-0001', '000009', NULL, NULL, '1', '2024-02-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-02-12', '7900', 'K_000009-0001', '7900', '現金', '1', '2024-02-12', NULL, '7900', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-12', NULL, NULL),
(24, '2024-02-14 01:27:49', '2024-02-14 01:31:42', NULL, 'K_000010-0001', '000010', NULL, NULL, '1', '2024-02-14', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-14', '6000', 'K_000010-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', 'AMEX', '1', '2024-02-14', NULL, 'SF_002', '2024-02-14', NULL, NULL),
(25, '2024-02-14 01:31:36', '2024-05-05 04:17:10', NULL, 'K_000010-0002', '000010', NULL, NULL, NULL, '2024-02-14', NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-02-14', '12000', 'K_000010-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'AMEX', NULL, NULL, NULL, 'SF_002', '2024-04-24', NULL, NULL),
(28, '2024-02-16 18:11:22', '2024-02-16 18:13:07', NULL, 'K_000011-0001', '000011', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-02-17', '4500', 'K_000011-0001', '4500', '現金', '1', '2024-02-17', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(30, '2024-02-16 21:10:41', '2024-02-16 21:11:01', NULL, 'K_000012-0001', '000012', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-17', '6500', 'K_000012-0001', '6500', '現金', '1', '2024-02-17', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(31, '2024-02-17 18:41:24', '2024-02-17 18:43:03', NULL, 'K_000013-0001', '000013', NULL, NULL, '1', '2024-02-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-18', '6000', 'K_000013-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(33, '2024-02-17 20:17:20', '2024-03-06 17:43:22', NULL, 'K_000003-0002', '000003', NULL, NULL, '2', '2024-02-18', NULL, 'cyclic', '脂肪冷却（LINEクーポン）', '2024-02-18', '9500', 'K_000003-0002', '9500', '現金', '1', '2024-02-18', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(34, '2024-02-17 20:20:35', '2024-05-02 03:44:58', NULL, 'K_000003-0003', '000003', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-03-07', '20000', 'K_000003-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-05-02', NULL, NULL),
(39, '2024-02-21 00:03:02', '2024-04-24 09:44:28', NULL, 'K_000001-0002', '000001', NULL, NULL, NULL, '2024-02-21', NULL, 'subscription', 'キャピテーション＋脂肪冷却', '2024-02-21', '21600', 'K_000001-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-04-24', NULL, NULL),
(40, '2024-02-25 01:51:55', '2024-02-25 01:53:43', NULL, 'K_000014-0001', '000014', NULL, NULL, '1', '2024-02-25', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-02-25', '9000', 'K_000014-0001', '9000', '現金', '1', '2024-02-25', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-25', NULL, NULL),
(42, '2024-02-25 18:45:40', '2024-02-25 18:45:57', NULL, 'K_000015-0001', '000015', NULL, NULL, '1', '2024-02-26', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-26', '5300', 'K_000015-0001', '5300', '現金', '1', '2024-02-26', NULL, '5300', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-26', NULL, NULL),
(43, '2024-02-25 20:22:49', '2024-02-25 20:23:05', NULL, 'K_000016-0001', '000016', NULL, NULL, '1', '2024-02-26', NULL, 'cyclic', '脂肪冷却+ハイドラフェイシャル', '2024-02-26', '9000', 'K_000016-0001', '9000', '現金', '1', '2024-02-26', NULL, '9000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-26', NULL, NULL),
(44, '2024-02-27 19:21:05', '2024-02-27 19:21:21', NULL, 'K_000017-0001', '000017', NULL, NULL, '1', '2024-02-28', NULL, 'cyclic', '脂肪冷却', '2024-02-28', '4500', 'K_000017-0001', '4500', '現金', '1', '2024-02-28', NULL, '4500', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-28', NULL, NULL),
(45, '2024-02-29 20:32:10', '2024-02-29 20:33:13', NULL, 'K_000018-0001', '000018', NULL, NULL, '1', '2024-03-01', NULL, 'cyclic', 'フォトフェイシャル', '2024-03-01', '2500', 'K_000018-0001', '2500', '現金', '1', '2024-03-01', NULL, '2500', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-03-01', NULL, NULL),
(47, '2024-03-01 01:09:51', '2024-03-01 01:10:08', NULL, 'K_000019-0001', '000019', NULL, NULL, '1', '2024-03-01', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-03-01', '4500', 'K_000019-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-03-01', NULL, 'SF_002', '2024-03-01', NULL, NULL),
(48, '2024-03-01 23:58:41', '2024-03-02 00:02:07', NULL, 'K_000020-0001', '000020', NULL, NULL, '1', '2024-03-02', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-02', '4500', 'K_000020-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-03-02', NULL, 'SF_002', '2024-03-02', NULL, NULL),
(50, '2024-03-05 17:56:02', '2024-03-05 17:56:19', NULL, 'K_000021-0001', '000021', NULL, NULL, '1', '2024-03-06', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-03-06', '1500', 'K_000021-0001', '1500', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-03-06', NULL, 'SF_002', '2024-03-06', NULL, NULL),
(51, '2024-03-05 18:24:44', '2024-03-05 18:25:04', NULL, 'K_000022-0001', '000022', NULL, NULL, '1', '2024-03-06', NULL, 'cyclic', '脂肪冷却', '2024-03-06', '0', 'K_000022-0001', '0', '現金', '1', '2024-03-06', NULL, '0', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-06', NULL, NULL),
(54, '2024-03-06 18:47:18', '2024-03-06 18:48:45', NULL, 'K_000005-0003', '000005', NULL, NULL, '1', '2024-03-07', NULL, 'cyclic', '脂肪冷却（LINEクーポン）', '2024-03-07', '5000', 'K_000005-0003', '5000', '現金', '1', '2024-03-07', NULL, '5000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-07', NULL, NULL),
(58, '2024-03-07 22:43:00', '2024-03-07 22:44:44', NULL, 'K_000009-0002', '000009', NULL, NULL, '1', '2024-03-08', NULL, 'cyclic', '脂肪冷却＋ハイドラ＋フォト＋パック', '2024-03-08', '14000', 'K_000009-0002', '14000', '現金', '1', '2024-03-08', NULL, '14000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-08', NULL, NULL),
(59, '2024-03-08 02:47:25', '2024-03-08 02:48:31', NULL, 'K_000023-0001', '000023', NULL, NULL, '1', '2024-03-08', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-08', '4000', 'K_000023-0001', '4000', '現金', '1', '2024-03-08', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-08', NULL, NULL),
(60, '2024-03-08 18:34:36', '2024-03-08 18:35:14', NULL, 'K_000024-0001', '000024', NULL, NULL, '1', '2024-03-09', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-09', '4000', 'K_000024-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-03-09', NULL, 'SF_002', '2024-03-09', NULL, NULL),
(62, '2024-03-08 18:36:57', '2024-04-12 18:04:04', NULL, 'K_000024-0002', '000024', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-03-09', '12000', 'K_000024-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-04-13', NULL, NULL),
(63, '2024-03-09 00:05:33', '2024-04-28 03:36:43', NULL, 'K_000022-0002', '000022', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-03-28', '16000', 'K_000022-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-04-19', NULL, '3週間に1回の方'),
(64, '2024-03-12 23:15:25', '2024-03-12 23:15:43', NULL, 'K_000025-0001', '000025', NULL, NULL, '1', '2024-03-13', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-13', '4000', 'K_000025-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-03-13', NULL, 'SF_002', '2024-03-13', NULL, NULL),
(65, '2024-03-13 18:21:52', '2024-03-13 18:22:12', NULL, 'K_000026-0001', '000026', NULL, NULL, '1', '2024-03-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-14', '4000', 'K_000026-0001', '4000', '現金', '1', '2024-03-14', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-14', NULL, NULL),
(66, '2024-03-13 18:23:45', '2024-04-17 04:12:18', NULL, 'K_000026-0002', '000026', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-03-14', '12000', 'K_000026-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '2024-04-17', NULL, NULL),
(67, '2024-03-17 18:21:40', '2024-03-17 18:21:59', NULL, 'K_000027-0001', '000027', NULL, NULL, '1', '2024-03-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-03-18', '6000', 'K_000027-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-03-18', NULL, 'SF_002', '2024-03-18', NULL, NULL),
(68, '2024-03-20 20:20:29', '2024-03-20 20:20:43', NULL, 'K_000028-0001', '000028', NULL, NULL, '1', '2024-03-21', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-21', '4000', 'K_000028-0001', '4000', '現金', '1', '2024-03-21', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-21', NULL, NULL),
(69, '2024-03-24 21:46:48', '2024-03-24 21:47:08', NULL, 'K_000029-0001', '000029', NULL, NULL, '1', '2024-03-25', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-03-25', '6000', 'K_000029-0001', '6000', '現金', '1', '2024-03-25', NULL, '6000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-25', NULL, NULL),
(70, '2024-03-24 22:24:00', '2024-03-24 22:24:23', NULL, 'K_000029-0002', '000029', NULL, NULL, '1', '2024-03-25', NULL, 'cyclic', '脂肪冷却', '2024-03-25', '16000', 'K_000029-0002', '16000', '現金', '1', '2024-03-25', NULL, '16000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-25', NULL, NULL),
(71, '2024-03-26 22:22:47', '2024-03-26 22:23:04', NULL, 'K_000030-0001', '000030', NULL, NULL, '1', '2024-03-27', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-27', '4000', 'K_000030-0001', '4000', '現金', '1', '2024-03-27', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-27', NULL, NULL),
(75, '2024-04-01 01:07:43', '2024-04-01 01:08:02', NULL, 'K_000031-0001', '000031', NULL, NULL, '1', '2024-04-01', NULL, 'cyclic', '脂肪冷却', '2024-04-01', '4000', 'K_000031-0001', '4000', '現金', '1', '2024-04-01', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-01', NULL, NULL),
(76, '2024-04-01 01:09:15', '2024-04-22 09:49:58', NULL, 'K_000031-0002', '000031', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-01', '16000', 'K_000031-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-04-22', NULL, NULL),
(78, '2024-04-05 19:38:17', '2024-04-05 19:38:37', NULL, 'K_000032-0001', '000032', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'フォトフェイシャル', '2024-04-06', '4600', 'K_000032-0001', '4600', '現金', '1', '2024-04-06', NULL, '4600', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-06', NULL, NULL),
(79, '2024-04-05 21:43:44', '2024-04-05 22:33:34', '2024-04-05 22:33:34', 'K_000033-0001', '000033', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-06', '5500', 'K_000033-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-06', NULL, 'SF_002', NULL, NULL, NULL),
(80, '2024-04-05 21:43:50', '2024-04-05 21:44:08', NULL, 'K_000033-0002', '000033', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-06', '5500', 'K_000033-0002', '5500', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-04-06', NULL, 'SF_002', '2024-04-06', NULL, NULL),
(81, '2024-04-06 18:46:34', '2024-04-06 18:46:53', NULL, 'K_000031-0003', '000031', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', 'フォトフェイシャル＋パック', '2024-04-07', '4000', 'K_000031-0003', '4000', '現金', '1', '2024-04-07', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-07', NULL, NULL),
(82, '2024-04-06 23:43:13', '2024-04-06 23:45:11', NULL, 'K_000034-0001', '000034', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-07', '4000', 'K_000034-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-07', NULL, 'SF_002', '2024-04-07', NULL, NULL),
(84, '2024-04-07 01:05:03', '2024-04-07 01:05:41', NULL, 'K_000035-0001', '000035', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-07', '6500', 'K_000035-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-07', NULL, 'SF_002', '2024-04-07', NULL, NULL),
(85, '2024-04-09 21:02:06', '2024-04-11 19:37:16', NULL, 'K_000036-0001', '000036', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-12', '6000', 'K_000036-0001', '6000', '現金', '1', '2024-04-12', NULL, '6000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(86, '2024-04-10 21:10:36', '2024-04-10 21:13:29', NULL, 'K_000009-0003', '000009', NULL, NULL, '1', '2024-04-11', NULL, 'cyclic', '脂肪冷却', '2024-04-11', '16000', 'K_000009-0003', '16000', '現金', '1', '2024-04-11', NULL, '16000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-11', NULL, NULL),
(87, '2024-04-10 21:14:24', '2024-04-10 21:19:36', NULL, 'K_000009-0004', '000009', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-11', '16000', 'K_000009-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(90, '2024-04-11 19:38:25', '2024-05-05 02:03:28', NULL, 'K_000036-0002', '000036', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-04-12', '12000', 'K_000036-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-05-05', NULL, NULL),
(91, '2024-04-11 21:19:56', '2024-04-11 21:20:13', NULL, 'K_000037-0001', '000037', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-12', '6500', 'K_000037-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-12', NULL, 'SF_002', '2024-04-12', NULL, NULL),
(92, '2024-04-11 21:21:08', '2024-04-11 21:21:08', NULL, 'K_000037-0002', '000037', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-04-12', '11000', 'K_000037-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', NULL, NULL, NULL),
(93, '2024-04-12 00:36:05', '2024-04-12 00:36:22', NULL, 'K_000038-0001', '000038', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-04-12', '7500', 'K_000038-0001', '7500', '現金', '1', '2024-04-12', NULL, '7500', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(94, '2024-04-12 00:37:14', '2024-05-05 04:56:50', NULL, 'K_000038-0002', '000038', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-12', '16000', 'K_000038-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-05-05', NULL, NULL),
(95, '2024-04-12 02:25:57', '2024-04-12 02:26:25', NULL, 'K_000039-0001', '000039', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-04-12', '5000', 'K_000039-0001', '5000', '現金', '1', '2024-04-12', NULL, '5000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(96, '2024-04-12 02:27:31', '2024-05-05 07:07:24', NULL, 'K_000039-0002', '000039', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-12', '16000', 'K_000039-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '2024-05-05', NULL, NULL),
(97, '2024-04-13 00:54:19', '2024-04-13 00:55:33', NULL, 'K_000040-0001', '000040', NULL, NULL, '1', '2024-04-13', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-04-13', '7500', 'K_000040-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-04-13', NULL, 'SF_002', '2024-04-13', NULL, NULL),
(98, '2024-04-17 06:32:42', '2024-04-17 06:32:58', NULL, 'K_000041-0001', '000041', NULL, NULL, '1', '2024-04-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-17', '6000', 'K_000041-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-17', NULL, 'SF_002', '2024-04-17', NULL, NULL),
(99, '2024-04-19 05:15:41', '2024-04-19 05:15:58', NULL, 'K_000042-0001', '000042', NULL, NULL, '1', '2024-04-19', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-04-19', '8500', 'K_000042-0001', '8500', '現金', '1', '2024-04-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-19', NULL, NULL),
(100, '2024-04-20 08:56:10', '2024-04-20 08:56:27', NULL, 'K_000040-0002', '000040', NULL, NULL, '1', '2024-04-20', NULL, 'cyclic', '【LINEクーポン】脂肪冷却', '2024-04-20', '5000', 'K_000040-0002', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-20', NULL, 'SF_002', '2024-04-20', NULL, NULL),
(101, '2024-04-21 05:13:56', '2024-04-21 05:18:24', NULL, 'K_000043-0001', '000043', NULL, NULL, '1', '2024-04-21', NULL, 'cyclic', '脂肪冷却', '2024-04-21', '4000', 'K_000043-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-21', NULL, 'SF_002', '2024-04-21', NULL, NULL),
(102, '2024-04-22 01:34:39', '2024-04-22 01:54:27', NULL, 'K_000044-0001', '000044', NULL, NULL, '1', '2024-04-21', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-21', '7000', 'K_000044-0001', '7000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-21', NULL, 'SF_002', '2024-04-21', NULL, NULL),
(106, '2024-04-22 03:10:57', '2024-04-22 03:11:14', NULL, 'K_000045-0001', '000045', NULL, NULL, '1', '2024-04-22', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-04-22', '5000', 'K_000045-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-22', NULL, 'SF_002', '2024-04-22', NULL, NULL),
(107, '2024-04-22 04:34:46', '2024-04-22 04:35:10', NULL, 'K_000046-0001', '000046', NULL, NULL, '1', '2024-04-22', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-22', '6500', 'K_000046-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-04-22', NULL, 'SF_002', '2024-04-22', NULL, NULL),
(108, '2024-04-22 10:00:04', '2024-04-22 10:54:27', NULL, 'K_000031-0004', '000031', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-04-22', '11000', 'K_000031-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(111, '2024-04-27 09:14:11', '2024-04-27 09:14:35', NULL, 'K_000049-0001', '000049', NULL, NULL, '1', '2024-04-27', NULL, 'cyclic', '脂肪冷却＋ハイドラ', '2024-04-27', '8500', 'K_000049-0001', '8500', '現金', '1', '2024-04-27', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-27', NULL, NULL),
(112, '2024-04-27 09:15:15', '2024-04-27 09:15:28', NULL, 'K_000049-0002', '000049', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-27', '16000', 'K_000049-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(113, '2024-04-28 03:29:39', '2024-04-28 03:29:57', NULL, 'K_000050-0001', '000050', NULL, NULL, '1', '2024-04-28', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-28', '6500', 'K_000050-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-28', NULL, 'SF_002', '2024-04-28', NULL, NULL),
(114, '2024-04-28 10:13:50', '2024-05-02 09:38:07', NULL, 'K_000040-0003', '000040', NULL, NULL, NULL, '2024-04-28', NULL, 'subscription', 'キャピテーション＋脂肪冷却', '2024-04-28', '21600', 'K_000040-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-05-02', NULL, NULL),
(115, '2024-04-29 04:47:56', '2024-04-29 04:48:10', NULL, 'K_000052-0001', '000052', NULL, NULL, '1', '2024-04-29', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-29', '6000', 'K_000052-0001', '6000', '現金', '1', '2024-04-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-29', NULL, NULL),
(116, '2024-04-29 07:22:53', '2024-04-29 07:23:12', NULL, 'K_000053-0001', '000053', NULL, NULL, '1', '2024-04-29', NULL, 'cyclic', 'ハイドラ＋脂肪冷却', '2024-04-29', '6000', 'K_000053-0001', '6000', '現金', '1', '2024-04-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-29', NULL, NULL),
(117, '2024-04-29 07:24:14', '2024-04-29 08:09:00', NULL, 'K_000053-0002', '000053', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-29', '16000', 'K_000053-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', NULL, NULL, '3ヶ月に1回\r\n(3ヶ月分お支払い)'),
(119, '2024-05-01 03:40:35', '2024-05-01 03:40:52', NULL, 'K_000054-0001', '000054', NULL, NULL, '1', '2024-05-01', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-05-01', '7300', 'K_000054-0001', '7300', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-05-01', NULL, 'SF_002', '2024-05-01', NULL, NULL),
(120, '2024-05-01 11:20:54', '2024-05-01 11:22:11', NULL, 'K_000055-0001', '000055', NULL, NULL, '1', '2024-05-01', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-01', '5000', 'K_000055-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-05-01', NULL, 'SF_002', '2024-05-01', NULL, NULL),
(121, '2024-05-01 11:21:42', '2024-05-01 11:21:56', NULL, 'K_000055-0002', '000055', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-05-01', '11000', 'K_000055-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(123, '2024-05-02 08:28:41', '2024-05-02 08:28:57', NULL, 'K_000056-0001', '000056', NULL, NULL, '1', '2024-05-02', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-02', '6500', 'K_000056-0001', '6500', '現金', '1', '2024-05-02', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-02', NULL, NULL),
(124, '2024-05-02 08:49:13', '2024-05-02 08:49:23', NULL, 'K_000056-0002', '000056', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-05-02', '11000', 'K_000056-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL);

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
(10, '2024-02-03 00:38:32', '2024-02-03 00:38:32', NULL, 'K_000005-0001-0001', 'K_000005-0001', '000005', NULL, 'キャピ＋脂肪冷却', '1', '7900', '7900', NULL),
(11, '2024-02-03 00:38:48', '2024-02-03 00:38:48', NULL, 'K_000001-0001-0001', 'K_000001-0001', '000001', NULL, '脂肪冷却', '1', '4900', '4900', NULL),
(12, '2024-02-03 00:39:02', '2024-02-03 00:39:02', NULL, 'K_000002-0001-0001', 'K_000002-0001', '000002', NULL, '脂肪冷却', '1', '4500', '4500', NULL),
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
(43, '2024-02-21 00:03:02', '2024-02-21 00:03:02', NULL, 'K_000001-0002-0001', 'K_000001-0002', '000001', NULL, 'サブスクリプション', NULL, '21600', NULL, NULL),
(45, '2024-02-25 01:53:43', '2024-02-25 01:53:43', NULL, 'K_000014-0001-0001', 'K_000014-0001', '000014', NULL, '脂肪冷却＋ハイドラ', '1', '9000', '9000', NULL),
(46, '2024-02-25 18:45:40', '2024-02-25 18:45:40', NULL, 'K_000015-0001-0001', 'K_000015-0001', '000015', NULL, 'ハイドラ＋フォト', '1', '5300', '5300', NULL),
(47, '2024-02-25 20:22:49', '2024-02-25 20:22:49', NULL, 'K_000016-0001-0001', 'K_000016-0001', '000016', NULL, '脂肪冷却＋ハイドラ', '1', '9000', '9000', NULL),
(48, '2024-02-27 19:21:05', '2024-02-27 19:21:05', NULL, 'K_000017-0001-0001', 'K_000017-0001', '000017', NULL, '脂肪冷却', '1', '4500', '4500', NULL),
(50, '2024-02-29 20:33:13', '2024-02-29 20:33:13', NULL, 'K_000018-0001-0001', 'K_000018-0001', '000018', NULL, 'フォトフェイシャル', '1', '2500', '2500', NULL),
(51, '2024-03-01 01:09:51', '2024-03-01 01:09:51', NULL, 'K_000019-0001-0001', 'K_000019-0001', '000019', NULL, 'ハイドラ＋フォト', '1', '4500', '4500', NULL),
(53, '2024-03-01 23:59:11', '2024-03-01 23:59:11', NULL, 'K_000020-0001-0001', 'K_000020-0001', '000020', NULL, '全身脱毛＋顔＋VIO', '1', '4500', '4500', NULL),
(54, '2024-03-05 17:56:02', '2024-03-05 17:56:02', NULL, 'K_000021-0001-0001', 'K_000021-0001', '000021', NULL, 'ハイドラフェイシャル', '1', '1500', '1500', NULL),
(55, '2024-03-05 18:24:44', '2024-03-05 18:24:44', NULL, 'K_000022-0001-0001', 'K_000022-0001', '000022', NULL, '脂肪冷却', '1', '0', '0', NULL),
(56, '2024-03-06 17:42:25', '2024-03-06 17:42:25', NULL, 'K_000003-0001-0001', 'K_000003-0001', '000003', NULL, 'キャピ＋脂肪冷却', '1', '3000', '3000', NULL),
(57, '2024-03-06 17:43:22', '2024-03-06 17:43:22', NULL, 'K_000003-0002-0001', 'K_000003-0002', '000003', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(58, '2024-03-06 17:43:22', '2024-03-06 17:43:22', NULL, 'K_000003-0002-0002', 'K_000003-0002', '000003', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL),
(59, '2024-03-06 18:47:18', '2024-03-06 18:47:18', NULL, 'K_000005-0003-0001', 'K_000005-0003', '000005', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(62, '2024-03-06 21:05:56', '2024-03-06 21:05:56', NULL, 'K_000003-0003-0001', 'K_000003-0003', '000003', NULL, 'サブスクリプション', NULL, '20000', NULL, NULL),
(63, '2024-03-07 22:43:00', '2024-03-07 22:43:00', NULL, 'K_000009-0002-0001', 'K_000009-0002', '000009', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(64, '2024-03-07 22:43:00', '2024-03-07 22:43:00', NULL, 'K_000009-0002-0002', 'K_000009-0002', '000009', NULL, 'ハイドラ＋フォト＋パック', '1', '9000', '9000', NULL),
(65, '2024-03-08 02:47:25', '2024-03-08 02:47:25', NULL, 'K_000023-0001-0001', 'K_000023-0001', '000023', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(67, '2024-03-08 18:34:57', '2024-03-08 18:34:57', NULL, 'K_000024-0001-0001', 'K_000024-0001', '000024', NULL, '全身脱毛＋顔＋VIO', '0', '4000', '4000', NULL),
(68, '2024-03-08 18:36:57', '2024-03-08 18:36:57', NULL, 'K_000024-0002-0001', 'K_000024-0002', '000024', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(70, '2024-03-12 23:15:25', '2024-03-12 23:15:25', NULL, 'K_000025-0001-0001', 'K_000025-0001', '000025', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(71, '2024-03-13 18:21:52', '2024-03-13 18:21:52', NULL, 'K_000026-0001-0001', 'K_000026-0001', '000026', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(72, '2024-03-13 18:23:45', '2024-03-13 18:23:45', NULL, 'K_000026-0002-0001', 'K_000026-0002', '000026', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(73, '2024-03-17 18:21:40', '2024-03-17 18:21:40', NULL, 'K_000027-0001-0001', 'K_000027-0001', '000027', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(74, '2024-03-20 20:20:29', '2024-03-20 20:20:29', NULL, 'K_000028-0001-0001', 'K_000028-0001', '000028', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(75, '2024-03-24 21:46:48', '2024-03-24 21:46:48', NULL, 'K_000029-0001-0001', 'K_000029-0001', '000029', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(76, '2024-03-24 22:24:00', '2024-03-24 22:24:00', NULL, 'K_000029-0002-0001', 'K_000029-0002', '000029', NULL, '脂肪冷却', '1', '16000', '16000', NULL),
(77, '2024-03-26 22:22:47', '2024-03-26 22:22:47', NULL, 'K_000030-0001-0001', 'K_000030-0001', '000030', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(79, '2024-03-27 18:39:29', '2024-03-27 18:39:29', NULL, 'K_000022-0002-0001', 'K_000022-0002', '000022', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(81, '2024-04-01 01:07:43', '2024-04-01 01:07:43', NULL, 'K_000031-0001-0001', 'K_000031-0001', '000031', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(82, '2024-04-01 01:09:15', '2024-04-01 01:09:15', NULL, 'K_000031-0002-0001', 'K_000031-0002', '000031', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(84, '2024-04-05 19:38:17', '2024-04-05 19:38:17', NULL, 'K_000032-0001-0001', 'K_000032-0001', '000032', NULL, 'フォトフェイシャル', '1', '4600', '4600', NULL),
(85, '2024-04-05 21:43:44', '2024-04-05 22:33:34', '2024-04-05 22:33:34', 'K_000033-0001-0001', 'K_000033-0001', '000033', NULL, 'ハイドラ＋フォト', '1', '5500', '5500', NULL),
(86, '2024-04-05 21:43:50', '2024-04-05 21:43:50', NULL, 'K_000033-0002-0001', 'K_000033-0002', '000033', NULL, 'ハイドラ＋フォト', '1', '5500', '5500', NULL),
(87, '2024-04-06 18:46:34', '2024-04-06 18:46:34', NULL, 'K_000031-0003-0001', 'K_000031-0003', '000031', NULL, 'フォトフェイシャル', '1', '4000', '4000', NULL),
(89, '2024-04-06 23:44:54', '2024-04-06 23:44:54', NULL, 'K_000034-0001-0001', 'K_000034-0001', '000034', NULL, '全身脱毛＋顔＋VIO', '1', '4000', '4000', NULL),
(90, '2024-04-07 01:05:03', '2024-04-07 01:05:03', NULL, 'K_000035-0001-0001', 'K_000035-0001', '000035', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(92, '2024-04-10 21:10:36', '2024-04-10 21:10:36', NULL, 'K_000009-0003-0001', 'K_000009-0003', '000009', NULL, '脂肪冷却', '1', '16000', '16000', NULL),
(94, '2024-04-10 21:15:00', '2024-04-10 21:15:00', NULL, 'K_000009-0004-0001', 'K_000009-0004', '000009', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(95, '2024-04-11 19:37:01', '2024-04-11 19:37:01', NULL, 'K_000036-0001-0001', 'K_000036-0001', '000036', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(96, '2024-04-11 19:38:25', '2024-04-11 19:38:25', NULL, 'K_000036-0002-0001', 'K_000036-0002', '000036', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(97, '2024-04-11 21:19:56', '2024-04-11 21:19:56', NULL, 'K_000037-0001-0001', 'K_000037-0001', '000037', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(98, '2024-04-11 21:21:08', '2024-04-11 21:21:08', NULL, 'K_000037-0002-0001', 'K_000037-0002', '000037', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(99, '2024-04-12 00:36:05', '2024-04-12 00:36:05', NULL, 'K_000038-0001-0001', 'K_000038-0001', '000038', NULL, 'キャピ＋脂肪冷却', '1', '7500', '7500', NULL),
(100, '2024-04-12 00:37:14', '2024-04-12 00:37:14', NULL, 'K_000038-0002-0001', 'K_000038-0002', '000038', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(101, '2024-04-12 02:25:57', '2024-04-12 02:25:57', NULL, 'K_000039-0001-0001', 'K_000039-0001', '000039', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(102, '2024-04-12 02:27:31', '2024-04-12 02:27:31', NULL, 'K_000039-0002-0001', 'K_000039-0002', '000039', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(103, '2024-04-13 00:54:19', '2024-04-13 00:54:19', NULL, 'K_000040-0001-0001', 'K_000040-0001', '000040', NULL, 'キャピ＋脂肪冷却', '1', '7500', '7500', NULL),
(104, '2024-04-17 06:32:42', '2024-04-17 06:32:42', NULL, 'K_000041-0001-0001', 'K_000041-0001', '000041', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(105, '2024-04-19 05:15:41', '2024-04-19 05:15:41', NULL, 'K_000042-0001-0001', 'K_000042-0001', '000042', NULL, '脂肪冷却＋ハイドラ', '1', '8500', '8500', NULL),
(106, '2024-04-20 08:56:10', '2024-04-20 08:56:10', NULL, 'K_000040-0002-0001', 'K_000040-0002', '000040', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(107, '2024-04-21 05:13:56', '2024-04-21 05:13:56', NULL, 'K_000043-0001-0001', 'K_000043-0001', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(111, '2024-04-22 01:54:21', '2024-04-22 01:54:21', NULL, 'K_000044-0001-0001', 'K_000044-0001', '000044', NULL, 'ハイドラ＋フォト', '1', '7000', '7000', NULL),
(112, '2024-04-22 03:10:57', '2024-04-22 03:10:57', NULL, 'K_000045-0001-0001', 'K_000045-0001', '000045', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(113, '2024-04-22 04:34:46', '2024-04-22 04:34:46', NULL, 'K_000046-0001-0001', 'K_000046-0001', '000046', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(114, '2024-04-22 10:00:04', '2024-04-22 10:00:04', NULL, 'K_000031-0004-0001', 'K_000031-0004', '000031', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(116, '2024-04-22 10:02:17', '2024-04-22 10:02:17', NULL, 'K_000005-0002-0001', 'K_000005-0002', '000005', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(117, '2024-04-27 09:14:11', '2024-04-27 09:14:11', NULL, 'K_000049-0001-0001', 'K_000049-0001', '000049', NULL, '脂肪冷却＋ハイドラ', '1', '8500', '8500', NULL),
(118, '2024-04-27 09:15:15', '2024-04-27 09:15:15', NULL, 'K_000049-0002-0001', 'K_000049-0002', '000049', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(119, '2024-04-28 03:29:39', '2024-04-28 03:29:39', NULL, 'K_000050-0001-0001', 'K_000050-0001', '000050', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(120, '2024-04-28 10:13:50', '2024-04-28 10:13:50', NULL, 'K_000040-0003-0001', 'K_000040-0003', '000040', NULL, 'サブスクリプション', NULL, '21600', NULL, NULL),
(121, '2024-04-29 04:47:56', '2024-04-29 04:47:56', NULL, 'K_000052-0001-0001', 'K_000052-0001', '000052', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(122, '2024-04-29 07:22:53', '2024-04-29 07:22:53', NULL, 'K_000053-0001-0001', 'K_000053-0001', '000053', NULL, '脂肪冷却＋ハイドラ', '1', '6000', '6000', NULL),
(124, '2024-04-29 08:09:00', '2024-04-29 08:09:00', NULL, 'K_000053-0002-0001', 'K_000053-0002', '000053', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(125, '2024-05-01 03:40:35', '2024-05-01 03:40:35', NULL, 'K_000054-0001-0001', 'K_000054-0001', '000054', NULL, 'キャピ＋脂肪冷却', '1', '7300', '7300', NULL),
(127, '2024-05-01 11:21:42', '2024-05-01 11:21:42', NULL, 'K_000055-0002-0001', 'K_000055-0002', '000055', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(128, '2024-05-01 11:22:11', '2024-05-01 11:22:11', NULL, 'K_000055-0001-0001', 'K_000055-0001', '000055', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(129, '2024-05-02 08:28:41', '2024-05-02 08:28:41', NULL, 'K_000056-0001-0001', 'K_000056-0001', '000056', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(130, '2024-05-02 08:49:13', '2024-05-02 08:49:13', NULL, 'K_000056-0002-0001', 'K_000056-0002', '000056', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL);

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
  `target_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '氏名',
  `staff_name_kana` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'しめい',
  `to_mail_address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '送り先メールアドレス',
  `from_mail_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '送り元メールアドレス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `in_out_histories`
--

INSERT INTO `in_out_histories` (`id`, `created_at`, `updated_at`, `target_serial`, `target_date`, `time_in`, `time_out`, `target_name`, `staff_name_kana`, `to_mail_address`, `from_mail_address`) VALUES
(9, '2024-04-18 09:15:40', '2024-04-18 09:21:43', 'SF_002', '2024-04-18', '2024-04-18 18:15:40', '2024-04-18 18:21:43', '川島 花乃', NULL, NULL, NULL),
(10, '2024-04-19 01:03:12', '2024-04-19 10:00:09', 'SF_002', '2024-04-19', '2024-04-19 10:03:12', '2024-04-19 19:00:09', '川島 花乃', NULL, NULL, NULL),
(13, '2024-04-20 01:58:30', '2024-04-20 10:00:01', 'SF_002', '2024-04-20', '2024-04-20 10:58:30', '2024-04-20 19:00:01', '川島 花乃', NULL, NULL, NULL),
(14, '2024-04-21 01:58:25', '2024-04-21 01:58:25', 'SF_002', '2024-04-21', '2024-04-21 10:58:25', NULL, '川島 花乃', NULL, NULL, NULL),
(15, '2024-04-22 01:03:36', '2024-04-22 10:59:24', 'SF_002', '2024-04-22', '2024-04-22 10:03:36', '2024-04-22 19:59:24', '川島 花乃', NULL, NULL, NULL),
(16, '2024-04-24 01:58:06', '2024-04-24 11:43:43', 'SF_002', '2024-04-24', '2024-04-24 10:58:06', '2024-04-24 20:43:43', '川島 花乃', NULL, NULL, NULL),
(17, '2024-04-25 01:55:05', '2024-04-25 01:55:05', 'SF_002', '2024-04-25', '2024-04-25 10:55:05', NULL, '川島 花乃', NULL, NULL, NULL),
(18, '2024-04-26 01:55:45', '2024-04-26 10:00:01', 'SF_002', '2024-04-26', '2024-04-26 10:55:45', '2024-04-26 19:00:01', '川島 花乃', NULL, NULL, NULL),
(19, '2024-04-27 01:57:44', '2024-04-27 10:00:16', 'SF_002', '2024-04-27', '2024-04-27 10:57:44', '2024-04-27 19:00:16', '川島 花乃', NULL, NULL, NULL),
(20, '2024-04-28 01:22:59', '2024-04-28 01:22:59', 'SF_002', '2024-04-28', '2024-04-28 10:22:59', NULL, '川島 花乃', NULL, NULL, NULL),
(21, '2024-04-29 01:58:07', '2024-04-29 10:00:01', 'SF_002', '2024-04-29', '2024-04-29 10:58:07', '2024-04-29 19:00:01', '川島 花乃', NULL, NULL, NULL),
(22, '2024-05-01 00:56:26', '2024-05-01 00:56:26', 'SF_002', '2024-05-01', '2024-05-01 09:56:26', NULL, '川島 花乃', NULL, NULL, NULL),
(23, '2024-05-05 01:01:22', '2024-05-05 01:01:22', 'SF_002', '2024-05-05', '2024-05-05 10:01:22', NULL, '川島 花乃', NULL, NULL, NULL);

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

--
-- テーブルのデータのダンプ `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('mosugutys@gmail.com', '$2y$12$PsEx7oiGcxogzT2w303yduFNNfQnGfcXCvyIEj4QxqHGaON5Pql7i', '2024-05-02 08:26:34');

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
(9, '2024-02-06 22:41:54', '2024-02-06 22:41:54', NULL, 'P_000006-0001-01', 'K_000006-0001', '000006', 'A_001', '2024-02-07', '1300', 'card', NULL),
(11, '2024-02-08 21:07:44', '2024-02-08 21:07:44', NULL, 'P_000007-0001-01', 'K_000007-0001', '000007', 'A_001', '2024-02-09', '6500', 'paypay', NULL),
(12, '2024-02-10 01:24:47', '2024-02-10 01:24:47', NULL, 'P_000008-0001-01', 'K_000008-0001', '000008', 'A_001', '2024-02-10', '6500', 'paypay', NULL),
(13, '2024-02-11 19:39:36', '2024-02-11 19:39:36', NULL, 'P_000009-0001-01', 'K_000009-0001', '000009', 'A_001', '2024-02-12', '7900', 'cash', NULL),
(14, '2024-02-14 01:28:14', '2024-02-14 01:28:14', NULL, 'P_000010-0001-01', 'K_000010-0001', '000010', 'A_001', '2024-02-14', '6000', 'card', NULL),
(20, '2024-02-16 18:13:07', '2024-02-16 18:13:07', NULL, 'P_000011-0001-01', 'K_000011-0001', '000011', 'A_001', '2024-02-17', '4500', 'cash', NULL),
(21, '2024-02-16 21:11:01', '2024-02-16 21:11:01', NULL, 'P_000012-0001-01', 'K_000012-0001', '000012', 'A_001', '2024-02-17', '6500', 'cash', NULL),
(22, '2024-02-17 18:41:42', '2024-02-17 18:41:42', NULL, 'P_000013-0001-01', 'K_000013-0001', '000013', 'A_001', '2024-02-18', '6000', 'paypay', NULL),
(27, '2024-02-17 20:54:01', '2024-02-17 20:54:01', NULL, 'P_000003-0002-01', 'K_000003-0002', '000003', 'A_001', '2024-02-18', '9500', 'cash', NULL),
(37, '2024-02-25 01:52:50', '2024-02-25 01:52:50', NULL, 'P_000014-0001-01', 'K_000014-0001', '000014', 'A_001', '2024-02-25', '9000', 'cash', NULL),
(38, '2024-02-25 18:45:57', '2024-02-25 18:45:57', NULL, 'P_000015-0001-01', 'K_000015-0001', '000015', 'A_001', '2024-02-26', '5300', 'cash', NULL),
(39, '2024-02-25 20:23:05', '2024-02-25 20:23:05', NULL, 'P_000016-0001-01', 'K_000016-0001', '000016', 'A_001', '2024-02-26', '9000', 'cash', NULL),
(40, '2024-02-27 19:21:21', '2024-02-27 19:21:21', NULL, 'P_000017-0001-01', 'K_000017-0001', '000017', 'A_001', '2024-02-28', '4500', 'cash', NULL),
(41, '2024-02-29 20:32:28', '2024-02-29 20:32:28', NULL, 'P_000018-0001-01', 'K_000018-0001', '000018', 'A_001', '2024-03-01', '2500', 'cash', NULL),
(42, '2024-03-01 01:10:08', '2024-03-01 01:10:08', NULL, 'P_000019-0001-01', 'K_000019-0001', '000019', 'A_001', '2024-03-01', '4500', 'card', NULL),
(44, '2024-03-02 00:02:07', '2024-03-02 00:02:07', NULL, 'P_000020-0001-01', 'K_000020-0001', '000020', 'A_001', '2024-03-02', '4500', 'card', NULL),
(48, '2024-03-05 17:56:19', '2024-03-05 17:56:19', NULL, 'P_000021-0001-01', 'K_000021-0001', '000021', 'A_001', '2024-03-06', '1500', 'card', NULL),
(49, '2024-03-05 18:25:04', '2024-03-05 18:25:04', NULL, 'P_000022-0001-01', 'K_000022-0001', '000022', 'A_001', '2024-03-06', '0', 'cash', NULL),
(67, '2024-03-06 18:48:45', '2024-03-06 18:48:45', NULL, 'P_000005-0003-01', 'K_000005-0003', '000005', 'A_001', '2024-03-07', '5000', 'cash', NULL),
(76, '2024-03-07 22:44:44', '2024-03-07 22:44:44', NULL, 'P_000009-0002-01', 'K_000009-0002', '000009', 'A_001', '2024-03-08', '14000', 'cash', NULL),
(78, '2024-03-08 02:48:31', '2024-03-08 02:48:31', NULL, 'P_000023-0001-01', 'K_000023-0001', '000023', 'A_001', '2024-03-08', '4000', 'cash', NULL),
(79, '2024-03-08 18:35:14', '2024-03-08 18:35:14', NULL, 'P_000024-0001-01', 'K_000024-0001', '000024', 'A_001', '2024-03-09', '4000', 'card', NULL),
(81, '2024-03-12 23:15:43', '2024-03-12 23:15:43', NULL, 'P_000025-0001-01', 'K_000025-0001', '000025', 'A_001', '2024-03-13', '4000', 'card', NULL),
(82, '2024-03-13 18:22:12', '2024-03-13 18:22:12', NULL, 'P_000026-0001-01', 'K_000026-0001', '000026', 'A_001', '2024-03-14', '4000', 'cash', NULL),
(85, '2024-03-17 18:21:59', '2024-03-17 18:21:59', NULL, 'P_000027-0001-01', 'K_000027-0001', '000027', 'A_001', '2024-03-18', '6000', 'card', NULL),
(86, '2024-03-20 20:20:43', '2024-03-20 20:20:43', NULL, 'P_000028-0001-01', 'K_000028-0001', '000028', 'A_001', '2024-03-21', '4000', 'cash', NULL),
(92, '2024-03-24 21:47:08', '2024-03-24 21:47:08', NULL, 'P_000029-0001-01', 'K_000029-0001', '000029', 'A_001', '2024-03-25', '6000', 'cash', NULL),
(93, '2024-03-24 22:24:23', '2024-03-24 22:24:23', NULL, 'P_000029-0002-01', 'K_000029-0002', '000029', 'A_001', '2024-03-25', '16000', 'cash', NULL),
(94, '2024-03-26 22:23:04', '2024-03-26 22:23:04', NULL, 'P_000030-0001-01', 'K_000030-0001', '000030', 'A_001', '2024-03-27', '4000', 'cash', NULL),
(99, '2024-03-27 19:01:26', '2024-03-27 19:01:26', NULL, 'P_000005-0002-01', 'K_000005-0002', '000005', 'A_001', '2024-02-03', '11000', 'card', NULL),
(100, '2024-03-27 19:01:26', '2024-03-27 19:01:26', NULL, 'P_000005-0002-02', 'K_000005-0002', '000005', 'A_001', '2024-03-03', '11000', 'card', NULL),
(102, '2024-04-01 01:08:02', '2024-04-01 01:08:02', NULL, 'P_000031-0001-01', 'K_000031-0001', '000031', 'A_001', '2024-04-01', '4000', 'cash', NULL),
(120, '2024-04-05 19:38:37', '2024-04-05 19:38:37', NULL, 'P_000032-0001-01', 'K_000032-0001', '000032', 'A_001', '2024-04-06', '4600', 'cash', NULL),
(121, '2024-04-05 21:44:08', '2024-04-05 21:44:08', NULL, 'P_000033-0002-01', 'K_000033-0002', '000033', 'A_001', '2024-04-06', '5500', 'card', NULL),
(122, '2024-04-06 18:46:53', '2024-04-06 18:46:53', NULL, 'P_000031-0003-01', 'K_000031-0003', '000031', 'A_001', '2024-04-07', '4000', 'cash', NULL),
(123, '2024-04-06 23:45:11', '2024-04-06 23:45:11', NULL, 'P_000034-0001-01', 'K_000034-0001', '000034', 'A_001', '2024-04-07', '4000', 'paypay', NULL),
(124, '2024-04-07 01:05:41', '2024-04-07 01:05:41', NULL, 'P_000035-0001-01', 'K_000035-0001', '000035', 'A_001', '2024-04-07', '6500', 'card', NULL),
(134, '2024-04-10 21:13:29', '2024-04-10 21:13:29', NULL, 'P_000009-0003-01', 'K_000009-0003', '000009', 'A_001', '2024-04-11', '16000', 'cash', NULL),
(136, '2024-04-10 21:19:36', '2024-04-10 21:19:36', NULL, 'P_000009-0004-01', 'K_000009-0004', '000009', 'A_001', '2024-04-11', '16000', 'card', NULL),
(137, '2024-04-11 19:37:16', '2024-04-11 19:37:16', NULL, 'P_000036-0001-01', 'K_000036-0001', '000036', 'A_001', '2024-04-12', '6000', 'cash', NULL),
(139, '2024-04-11 21:20:13', '2024-04-11 21:20:13', NULL, 'P_000037-0001-01', 'K_000037-0001', '000037', 'A_001', '2024-04-12', '6500', 'paypay', NULL),
(140, '2024-04-12 00:36:22', '2024-04-12 00:36:22', NULL, 'P_000038-0001-01', 'K_000038-0001', '000038', 'A_001', '2024-04-12', '7500', 'cash', NULL),
(142, '2024-04-12 02:26:25', '2024-04-12 02:26:25', NULL, 'P_000039-0001-01', 'K_000039-0001', '000039', 'A_001', '2024-04-12', '5000', 'cash', NULL),
(145, '2024-04-12 18:04:04', '2024-04-12 18:04:04', NULL, 'P_000024-0002-01', 'K_000024-0002', '000024', 'A_001', '2024-03-09', '12000', 'card', NULL),
(146, '2024-04-12 18:04:04', '2024-04-12 18:04:04', NULL, 'P_000024-0002-02', 'K_000024-0002', '000024', 'A_001', '2024-04-13', '12000', 'card', NULL),
(148, '2024-04-13 00:55:33', '2024-04-13 00:55:33', NULL, 'P_000040-0001-01', 'K_000040-0001', '000040', 'A_001', '2024-04-13', '7500', 'card', NULL),
(152, '2024-04-17 04:12:18', '2024-04-17 04:12:18', NULL, 'P_000026-0002-01', 'K_000026-0002', '000026', 'A_001', '2024-03-14', '12000', 'card', NULL),
(153, '2024-04-17 04:12:18', '2024-04-17 04:12:18', NULL, 'P_000026-0002-02', 'K_000026-0002', '000026', 'A_001', '2024-04-14', '12000', 'card', NULL),
(155, '2024-04-17 06:32:58', '2024-04-17 06:32:58', NULL, 'P_000041-0001-01', 'K_000041-0001', '000041', 'A_001', '2024-04-17', '6000', 'card', NULL),
(161, '2024-04-19 05:15:57', '2024-04-19 05:15:57', NULL, 'P_000042-0001-01', 'K_000042-0001', '000042', 'A_001', '2024-04-19', '8500', 'cash', NULL),
(162, '2024-04-20 08:56:27', '2024-04-20 08:56:27', NULL, 'P_000040-0002-01', 'K_000040-0002', '000040', 'A_001', '2024-04-20', '5000', 'card', NULL),
(163, '2024-04-21 05:18:24', '2024-04-21 05:18:24', NULL, 'P_000043-0001-01', 'K_000043-0001', '000043', 'A_001', '2024-04-21', '4000', 'card', NULL),
(166, '2024-04-22 01:54:27', '2024-04-22 01:54:27', NULL, 'P_000044-0001-01', 'K_000044-0001', '000044', 'A_001', '2024-04-21', '7000', 'card', NULL),
(167, '2024-04-22 03:11:14', '2024-04-22 03:11:14', NULL, 'P_000045-0001-01', 'K_000045-0001', '000045', 'A_001', '2024-04-22', '5000', 'card', NULL),
(168, '2024-04-22 04:35:10', '2024-04-22 04:35:10', NULL, 'P_000046-0001-01', 'K_000046-0001', '000046', 'A_001', '2024-04-22', '6500', 'card', NULL),
(169, '2024-04-22 09:49:58', '2024-04-22 09:49:58', NULL, 'P_000031-0002-01', 'K_000031-0002', '000031', 'A_001', '2024-04-01', '16000', 'card', NULL),
(170, '2024-04-22 10:54:27', '2024-04-22 10:54:27', NULL, 'P_000031-0004-01', 'K_000031-0004', '000031', 'A_001', '2024-04-22', '11000', 'card', NULL),
(193, '2024-04-24 09:44:28', '2024-04-24 09:44:28', NULL, 'P_000001-0002-01', 'K_000001-0002', '000001', 'A_001', '2024-02-21', '21600', 'card', NULL),
(194, '2024-04-24 09:44:28', '2024-04-24 09:44:28', NULL, 'P_000001-0002-02', 'K_000001-0002', '000001', 'A_001', '2024-03-21', '21600', 'card', NULL),
(196, '2024-04-24 09:44:28', '2024-04-24 09:44:28', NULL, 'P_000001-0002-03', 'K_000001-0002', '000001', 'A_001', '2024-04-24', '21600', 'card', NULL),
(199, '2024-04-27 09:14:35', '2024-04-27 09:14:35', NULL, 'P_000049-0001-01', 'K_000049-0001', '000049', 'A_001', '2024-04-27', '8500', 'cash', NULL),
(200, '2024-04-27 09:15:28', '2024-04-27 09:15:28', NULL, 'P_000049-0002-01', 'K_000049-0002', '000049', 'A_001', '2024-04-27', '16000', 'card', NULL),
(201, '2024-04-28 03:29:57', '2024-04-28 03:29:57', NULL, 'P_000050-0001-01', 'K_000050-0001', '000050', 'A_001', '2024-04-28', '6500', 'card', NULL),
(202, '2024-04-28 03:36:43', '2024-04-28 03:36:43', NULL, 'P_000022-0002-01', 'K_000022-0002', '000022', 'A_001', '2024-03-28', '16000', 'card', NULL),
(203, '2024-04-28 03:36:43', '2024-04-28 03:36:43', NULL, 'P_000022-0002-02', 'K_000022-0002', '000022', 'A_001', '2024-04-28', '16000', 'card', NULL),
(206, '2024-04-29 04:48:10', '2024-04-29 04:48:10', NULL, 'P_000052-0001-01', 'K_000052-0001', '000052', 'A_001', '2024-04-29', '6000', 'cash', NULL),
(207, '2024-04-29 07:23:12', '2024-04-29 07:23:12', NULL, 'P_000053-0001-01', 'K_000053-0001', '000053', 'A_001', '2024-04-29', '6000', 'cash', NULL),
(208, '2024-05-01 03:40:52', '2024-05-01 03:40:52', NULL, 'P_000054-0001-01', 'K_000054-0001', '000054', 'A_001', '2024-05-01', '7300', 'card', NULL),
(209, '2024-05-01 11:21:09', '2024-05-01 11:21:09', NULL, 'P_000055-0001-01', 'K_000055-0001', '000055', 'A_001', '2024-05-01', '5000', 'card', NULL),
(210, '2024-05-01 11:21:56', '2024-05-01 11:21:56', NULL, 'P_000055-0002-01', 'K_000055-0002', '000055', 'A_001', '2024-05-01', '11000', 'card', NULL),
(211, '2024-05-02 03:44:58', '2024-05-02 03:44:58', NULL, 'P_000003-0003-01', 'K_000003-0003', '000003', 'A_001', '2024-03-07', '20000', 'card', NULL),
(212, '2024-05-02 03:44:58', '2024-05-02 03:44:58', NULL, 'P_000003-0003-02', 'K_000003-0003', '000003', 'A_001', '2024-04-07', '20000', 'card', NULL),
(214, '2024-05-02 08:28:57', '2024-05-02 08:28:57', NULL, 'P_000056-0001-01', 'K_000056-0001', '000056', 'A_001', '2024-05-02', '6500', 'cash', NULL),
(215, '2024-05-02 08:49:23', '2024-05-02 08:49:23', NULL, 'P_000056-0002-01', 'K_000056-0002', '000056', 'A_001', '2024-05-02', '11000', 'card', NULL),
(216, '2024-05-02 09:38:07', '2024-05-02 09:38:07', NULL, 'P_000040-0003-01', 'K_000040-0003', '000040', 'A_001', '2024-04-28', '21600', 'card', NULL),
(217, '2024-05-05 02:03:28', '2024-05-05 02:03:28', NULL, 'P_000036-0002-01', 'K_000036-0002', '000036', 'A_001', '2024-04-12', '12000', 'card', NULL),
(218, '2024-05-05 04:17:10', '2024-05-05 04:17:10', NULL, 'P_000010-0002-01', 'K_000010-0002', '000010', 'A_001', '2024-02-14', '12000', 'card', NULL),
(219, '2024-05-05 04:17:10', '2024-05-05 04:17:10', NULL, 'P_000010-0002-02', 'K_000010-0002', '000010', 'A_001', '2024-02-15', '12000', 'card', NULL),
(221, '2024-05-05 04:17:10', '2024-05-05 04:17:10', NULL, 'P_000010-0002-03', 'K_000010-0002', '000010', 'A_001', '2024-03-06', '12000', 'card', NULL),
(224, '2024-05-05 04:17:10', '2024-05-05 04:17:10', NULL, 'P_000010-0002-04', 'K_000010-0002', '000010', 'A_001', '2024-04-03', '12000', 'card', NULL),
(228, '2024-05-05 04:17:10', '2024-05-05 04:17:10', NULL, 'P_000010-0002-05', 'K_000010-0002', '000010', 'A_001', '2024-05-03', '12000', 'card', NULL),
(233, '2024-05-05 04:56:50', '2024-05-05 04:56:50', NULL, 'P_000038-0002-01', 'K_000038-0002', '000038', 'A_001', '2024-04-12', '16000', 'card', NULL),
(234, '2024-05-05 07:07:24', '2024-05-05 07:07:24', NULL, 'P_000039-0002-01', 'K_000039-0002', '000039', 'A_001', '2024-04-12', '16000', 'card', NULL);

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
-- テーブルの構造 `points`
--

DROP TABLE IF EXISTS `points`;
CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `serial_user` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ユーザーシリアル',
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '取得方法',
  `date_get` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '取得日',
  `point` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '取得ポイント',
  `visit_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来店日',
  `referred_serial` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '紹介された人',
  `note` text COLLATE utf8mb4_unicode_ci COMMENT '備考',
  `validity_flg` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '有効フラグ',
  `digestion_flg` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消化フラグ',
  `point_expiration_date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ポイント消滅日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `points`
--

INSERT INTO `points` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_user`, `method`, `date_get`, `point`, `visit_date`, `referred_serial`, `note`, `validity_flg`, `digestion_flg`, `point_expiration_date`) VALUES
(29, '2024-05-01 11:30:02', '2024-05-04 23:32:44', NULL, '000055', '来店', '2024-05-01', '10', '2024-05-01 20:30:02', NULL, NULL, 'true', 'false', ''),
(32, '2024-05-02 05:44:49', '2024-05-02 05:44:49', NULL, '000003', '来店', '2024-05-02', '10', '2024-05-02 14:44:49', NULL, NULL, 'true', 'false', NULL),
(33, '2024-05-02 10:55:50', '2024-05-02 10:55:50', NULL, '000040', '来店', '2024-05-02', '10', '2024-05-02 19:55:50', NULL, NULL, 'true', 'false', NULL),
(34, '2024-05-05 03:20:32', '2024-05-05 03:20:32', NULL, '000036', '来店', '2024-05-05', '10', '2024-05-05 12:20:32', NULL, NULL, 'true', 'false', NULL),
(35, '2024-05-05 06:04:38', '2024-05-05 06:04:38', NULL, '000038', '来店', '2024-05-05', '10', '2024-05-05 15:04:38', NULL, NULL, 'true', 'false', NULL);

--
-- トリガ `points`
--
DROP TRIGGER IF EXISTS `get total point delete`;
DELIMITER $$
CREATE TRIGGER `get total point delete` BEFORE DELETE ON `points` FOR EACH ROW BEGIN
	CALL total_point(old.serial_user);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `get total point insert`;
DELIMITER $$
CREATE TRIGGER `get total point insert` AFTER INSERT ON `points` FOR EACH ROW BEGIN
	CALL total_point(NEW.serial_user);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `get total point update`;
DELIMITER $$
CREATE TRIGGER `get total point update` AFTER UPDATE ON `points` FOR EACH ROW BEGIN
	CALL total_point(NEW.serial_user);
END
$$
DELIMITER ;

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
(30, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(31, NULL, NULL, NULL, '1', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(32, NULL, NULL, NULL, '1', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(33, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(34, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(35, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(36, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(37, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(38, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(39, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(40, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(41, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(42, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(43, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(44, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(45, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(46, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(47, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(48, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(49, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(50, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(51, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(52, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(53, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(54, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(55, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(56, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(57, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(58, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(59, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(60, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(61, NULL, NULL, NULL, '2', ' ', 'SaveTreatmentContent', '/admin/saveTreatment', NULL),
(62, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(63, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(64, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(65, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(66, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(67, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(68, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(69, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(70, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(71, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(72, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(73, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(74, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(75, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(76, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(77, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(78, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(79, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(80, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(81, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(82, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(83, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(84, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(85, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(86, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(87, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(88, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(89, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(90, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(91, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(92, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(93, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(94, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(95, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(96, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(97, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(98, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(99, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(100, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(101, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(102, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(103, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(104, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(105, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(106, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(107, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(108, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(109, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(110, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(111, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(112, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(113, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(114, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(115, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(116, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(117, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(118, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(119, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(120, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(121, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(122, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(123, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(124, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(125, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(126, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(127, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(128, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(129, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(130, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(131, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(132, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(133, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(134, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(135, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(136, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(137, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(138, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(139, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(140, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(141, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(142, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(143, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(144, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(145, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(146, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(147, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL),
(148, NULL, NULL, NULL, '2', ' ', 'recordVisitPaymentHistory', '/customers/recordVisitPaymentHistory', NULL);

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
(1, '2024-01-17 23:30:23', '2024-04-11 23:30:42', '2024-04-11 23:30:42', 'SF_001', NULL, NULL, '根岸', 'もえ子', 'ねぎし', 'もえこ', NULL, NULL),
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
(25, '2024-02-16 18:12:36', '2024-02-16 18:12:36', NULL, 'Tr_00041', 'ハイドラフェイシャル', 'はいどらふぇいしゃる', NULL, NULL),
(26, '2024-02-25 01:52:21', '2024-02-25 01:52:21', NULL, 'Tr_00042', '脂肪冷却＋ハイドラ', 'れいきゃく', NULL, NULL),
(27, '2024-02-29 20:32:58', '2024-02-29 20:32:58', NULL, 'Tr_00043', 'フォトフェイシャル', 'ふぉとふぇいしゃる', NULL, NULL),
(28, '2024-03-07 21:25:59', '2024-03-07 21:25:59', NULL, 'Tr_00044', 'ミネラルホワイトパック', 'み', NULL, NULL),
(29, '2024-03-07 21:26:27', '2024-03-07 21:26:27', NULL, 'Tr_00045', 'ハイドラ＋フォト＋パック', 'は', NULL, NULL),
(30, '2024-03-07 22:44:17', '2024-03-07 22:44:17', NULL, 'Tr_00046', '脂肪冷却＋ハイドラ＋フォト＋パック', 'し', NULL, NULL);

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
  `total_points` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee_num` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zankin` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い残金',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_user`, `admission_date`, `name_sei`, `name_mei`, `name_sei_kana`, `name_mei_kana`, `gender`, `birth_year`, `birth_month`, `birth_day`, `postal`, `address_region`, `address_locality`, `address_banti`, `email`, `email_verified_at`, `phone`, `profile_photo_path`, `address`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `reason_coming`, `total_points`, `referee_num`, `referee_name`, `zankin`, `remember_token`) VALUES
(1, '2024-01-19 17:28:02', '2024-04-28 23:59:21', NULL, '000001', '2024-01-20', '橋本', '朋佳', 'はしもと', 'ともか', 'woman', '1996', '06', '19', '3290414', '9', '下野市小金井', '４‐11‐2　サダルースウドB101', NULL, NULL, '08032818619', NULL, NULL, '$2y$12$DoGReDZlS94.T9f6x8nztegeFWrjWhxaxfR/Y3fOfTQd1ufjweZfy', NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', 'EAsVPCjkuSWvzn9yxZrpMPupTdSHvg6NAVvBIw2PrPOpORuwryYLvAknbM8r'),
(2, '2024-01-21 17:03:15', '2024-04-21 07:05:03', NULL, '000002', '2024-01-22', '永島', '晴奈', 'ながしま', 'はるな', 'woman', '1999', '08', '23', '3294308', '9', '栃木市岩船町下津原', '198', NULL, NULL, '08081230056', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(3, '2024-01-27 20:30:16', '2024-05-02 05:44:33', NULL, '000003', '2024-01-28', '一色', '道代', 'いっしき', 'みちよ', 'woman', '1990', '05', '08', '3290205', '9', '小山市間々田', '2456‐39', 'ymra.0508@gmail.com', NULL, '08098784793', NULL, NULL, '$2y$12$YeapPrzB0b18pILlddqgreyHPxRuS3GoZO/uDH0V/fdGE9Brhc0bi', NULL, NULL, NULL, 'その他(鈴木さん紹介)', '10', NULL, '', '0', '4a92Hv0FYJSPBH1PA9XQbVxU0WyUUPxfQ4bBsED68feY4yCjOd16eXpkbrjS'),
(4, '2024-02-02 20:05:20', '2024-02-02 20:05:20', NULL, '000004', '2024-02-03', '白石', '千尋', 'しらいし', 'ちひろ', 'woman', '1996', '12', '12', '3230819', '9', '小山市横倉新田', '91‐4', NULL, NULL, '08011585347', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(5, '2024-02-02 22:47:54', '2024-02-02 22:47:54', NULL, '000005', '2024-02-03', '碓井', '裕子', 'うすい', 'ゆうこ', 'woman', '1983', '09', '04', '3070005', '8', '結城市川木谷', '1‐3‐9', NULL, NULL, '09052119167', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(6, '2024-02-06 22:37:58', '2024-02-06 22:37:58', NULL, '000006', '2024-02-07', '清水', '恵子', 'しみず', 'けいこ', 'woman', '1975', '02', '14', '3070001', '8', '結城市結城', '9946-261', NULL, NULL, '0805359785', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(7, '2024-02-08 20:39:13', '2024-02-08 20:41:32', NULL, '000007', '2024-02-09', '水上', '由記', 'みずかみ', 'ゆき', 'woman', '1975', '03', '23', '3400145', '11', '幸手市平須賀', '2‐9', NULL, NULL, '08013935815', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(9, '2024-02-10 00:05:51', '2024-02-10 01:23:17', NULL, '000008', '2024-02-10', '西片', 'ひなた', 'にしかた', 'ひなた', 'woman', '2002', '08', '06', '3230829', '9', '小山市東城南', '1‐25‐11', NULL, NULL, '09092171635', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(11, '2024-02-11 18:00:52', '2024-02-11 18:00:52', NULL, '000009', '2024-02-12', '川澄', 'めぐみ', 'かわすみ', 'めぐみ', 'woman', '1988', '12', '20', '3230824', '9', '小山市雨ケ谷新田', '78‐63', NULL, NULL, '09080093844', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(12, '2024-02-14 01:26:50', '2024-02-14 01:26:50', NULL, '000010', '2024-02-14', '佐藤', '真未', 'さとう', 'まみ', 'woman', '1988', '10', '31', '3290212', '9', '小山市平和', '86‐7', NULL, NULL, '08011862467', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(13, '2024-02-16 18:10:12', '2024-02-16 18:10:12', NULL, '000011', '2024-02-17', '五月女', '笑優', 'そうとめ', 'まゆ', 'woman', '2003', '09', '01', '3231104', '9', '栃木市藤岡町藤岡', '1421‐1', NULL, NULL, '08084711619', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(14, '2024-02-16 21:10:03', '2024-02-16 21:10:03', NULL, '000012', '2024-02-17', '小林', '美羽', 'こばやし', 'みう', 'woman', '2001', '08', '03', '3290201', '8', '小山市栗宮', '2‐2‐20', NULL, NULL, '07021995078', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(15, '2024-02-17 18:40:28', '2024-02-17 18:40:28', NULL, '000013', '2024-02-18', '池田', '千恵子', 'いけだ', 'ちえこ', 'woman', '1974', '10', '23', '3070053', '8', '結城市新福寺', '2‐18‐14', NULL, NULL, '09023333613', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(16, '2024-02-25 01:51:08', '2024-02-25 01:51:08', NULL, '000014', '2024-02-25', '市村', '由紀子', 'いちむら', 'ゆきこ', 'woman', '1968', '01', '13', '3070001', '8', '結城市結城', '12021‐114', NULL, NULL, '09032444940', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(17, '2024-02-25 17:45:33', '2024-02-25 17:45:33', NULL, '000015', '2024-02-26', '五十嵐', '真由美', 'いがらし', 'まゆみ', 'woman', '1976', '11', '12', '3230826', '9', '小山市雨ヶ谷', '720‐9', NULL, NULL, '09040160340', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(18, '2024-02-25 20:06:16', '2024-02-25 20:06:16', NULL, '000016', '2024-02-26', '椎名', '嘉澄', 'しいな', 'かすみ', 'woman', '1992', '10', '29', '3230820', '9', '小山市西城南4丁目', '12‐18', NULL, NULL, '09011069313', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(19, '2024-02-27 18:50:13', '2024-02-27 18:50:13', NULL, '000017', '2024-02-28', '宮野', '梨菜', 'みやの', 'りな', 'woman', '2003', '08', '27', '3270831', '9', '佐野市浅沼町', '129‐23', NULL, NULL, '08078380929', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(20, '2024-02-29 19:35:39', '2024-02-29 19:35:39', NULL, '000018', '2024-03-01', '勝俣', '咲葉', 'かつまた', 'さよ', 'woman', '1999', '03', '22', '3290205', '9', '小山市間々田', '776‐96', NULL, NULL, '08022564679', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(21, '2024-03-01 00:44:16', '2024-03-01 00:44:16', NULL, '000019', '2024-03-01', '田村', '典子', 'たむら', 'のりこ', 'woman', '1988', '02', '11', '3230801', '9', '小山市鉢形', '714‐1', NULL, NULL, '09098353889', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(22, '2024-03-01 22:44:01', '2024-03-01 22:44:01', NULL, '000020', '2024-03-02', '黒須', '花', 'くろす', 'はな', 'woman', '1997', '03', '19', '3060404', '8', '猿島郡堺町長形', '1291‐3‐201', NULL, NULL, '09041781138', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(23, '2024-03-05 17:55:13', '2024-03-05 17:55:13', NULL, '000021', '2024-03-06', '野原', '里美', 'のはら', 'さとみ', 'woman', '1986', '04', '04', '3290214', '9', '小山市乙女', '1‐17‐10', NULL, NULL, '08054686473', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(24, '2024-03-05 18:24:03', '2024-03-05 18:24:03', NULL, '000022', '2024-03-06', '生沼', '奈緒', 'おいぬま', 'なお', 'woman', '1980', '09', '15', '3060123', '8', '古河市五部', '396‐10', NULL, NULL, '09027603131', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(25, '2024-03-08 02:46:48', '2024-03-08 02:46:48', NULL, '000023', '2024-03-08', '三木', '愛巳', 'みき', 'いつみ', 'woman', '2001', '06', '21', '3230014', '9', '小山市喜沢', '1475‐45', NULL, NULL, '07040239333', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(26, '2024-03-08 18:33:41', '2024-03-09 19:37:04', NULL, '000024', '2024-03-09', '関塚', '奈緒', 'せきづか', 'なお', 'woman', '1998', '09', '17', '3231104', '9', '栃木市藤岡町藤岡', '3746‐1', NULL, NULL, '08054209017', NULL, NULL, NULL, NULL, NULL, NULL, '知人の紹介', '', NULL, NULL, '0', NULL),
(28, '2024-03-12 22:04:01', '2024-03-12 22:04:01', NULL, '000025', '2024-03-13', '平沢', '光', 'ひらさわ', 'ひかり', 'woman', '1992', '12', '15', '3290206', '9', '小山市東間々田', '3‐31‐27', NULL, NULL, '09065368765', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(29, '2024-03-13 18:21:22', '2024-03-13 18:21:22', NULL, '000026', '2024-03-14', '落合', '麻美', 'おちあい', 'あさみ', 'woman', '1987', '11', '30', '3290214', '9', '小山市乙女', '1‐9‐19', NULL, NULL, '08058631821', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(30, '2024-03-17 17:12:11', '2024-03-17 17:12:11', NULL, '000027', '2024-03-18', '野中', 'めぐみ', 'のなか', 'めぐみ', 'woman', '1986', '02', '16', '3230034', '9', '神鳥谷', '1‐18‐12', NULL, NULL, '08012065302', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(31, '2024-03-20 20:19:45', '2024-03-20 20:19:45', NULL, '000028', '2024-03-21', '飯島', '優衣', 'いいじま', 'ゆい', 'woman', '1995', '01', '25', NULL, '8', '小山市', NULL, NULL, NULL, '08095010125', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(32, '2024-03-24 21:46:12', '2024-03-24 21:46:12', NULL, '000029', '2024-03-25', '山中', '綾', 'やまなか', 'あや', 'woman', '1992', '11', '10', '7000051', '33', '岡山市北区大伊福上町', '15‐9', NULL, NULL, '08062890608', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(33, '2024-03-26 22:22:12', '2024-03-26 22:22:12', NULL, '000030', '2024-03-27', '嶋田', '真琴', 'しまだ', 'まこと', 'woman', '2002', '12', '25', '3230821', '9', '小山市三峯', '1‐4‐10', NULL, NULL, '08049399114', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(34, '2024-04-01 00:11:38', '2024-04-06 17:34:00', NULL, '000031', '2024-04-01', '藤田', '瞳', 'ふじた', 'ひとみ', 'woman', '1994', '04', '03', '3230829', '9', '小山市東城南', '1‐10‐18‐303', NULL, NULL, '08011938244', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(36, '2024-04-05 19:37:28', '2024-04-05 19:37:28', NULL, '000032', '2024-04-06', '金井', '恵美', 'かない', 'えみ', 'woman', '1980', '09', '16', '3290205', '9', '小山市間々田', '1284', NULL, NULL, '08050087470', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(37, '2024-04-05 21:42:56', '2024-04-05 21:42:56', NULL, '000033', '2024-04-06', '山下', '尊子', 'やました', 'たかこ', 'woman', '1993', '05', '26', '3290414', '9', '下野市小金井', '2759‐1', NULL, NULL, '08059525682', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(39, '2024-04-06 23:42:16', '2024-04-06 23:44:40', NULL, '000034', '2024-04-07', '山口', '佳代子', 'やまぐち', 'かよこ', 'woman', '1985', '02', '22', '3230814', '9', '小山市田間', '726', NULL, NULL, '08020244796', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(41, '2024-04-07 01:04:21', '2024-04-07 01:08:45', NULL, '000035', '2024-04-07', '海老澤', '直子', 'えびはら', 'なおこ', 'woman', '1970', '10', '07', '3091107', '8', '筑西市間井', '747‐5', NULL, NULL, '09014351023', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(46, '2024-04-11 19:00:10', '2024-05-05 03:20:03', NULL, '000036', '2024-04-12', '星野', '直美', 'ほしの', 'なおみ', 'woman', '1986', '04', '21', '3230808', '9', '小山市出井', '709‐8', '212403n@gmail.com', NULL, '08063323997', NULL, NULL, '$2y$12$lax8NWxeiRL1sTNCa6t8FepdQnrgiSv0idMkSHW9oJqVwUB1fzuaC', NULL, NULL, NULL, 'ホットペッパー', '10', NULL, '', '0', 'Td02MQHTfHGoH1ZIXOe7179t8g168dSFyWP1ESqmFAsXGD7ybIjghpVxJusX'),
(47, '2024-04-11 21:19:16', '2024-04-11 21:36:05', NULL, '000037', '2024-04-12', '大友', '莉奈', 'おおとも', 'りな', 'woman', '1993', '04', '03', '3290103', '9', '下都賀市野木町', '若林42‐12', NULL, NULL, '08023904173', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(49, '2024-04-11 22:03:42', '2024-05-05 06:04:01', NULL, '000038', '2024-04-12', '潮田', '直子', 'うしおだ', 'なおこ', 'woman', '1977', '01', '08', '3070001', '8', '結城市結城', '6773‐12', 'sakura.nao18@icloud.com', NULL, '09027309016', NULL, NULL, '$2y$12$4EtmKAu0wmW2rh96ZW2SsewCjk.hG.LCYIfQpd4q.P4itt6a18hsm', NULL, NULL, NULL, 'ホットペッパー', '10', NULL, '', '0', 'wr9ezwuZhEjVXVDGYysyypzuxHztkILPK9X4DuDn7fSl5qJl0ukTyUAa9TuT'),
(50, '2024-04-12 01:12:43', '2024-04-12 01:12:43', NULL, '000039', '2024-04-12', '関', 'みちる', 'せき', 'みちる', 'woman', '1994', '10', '19', '3230819', '9', '小山市横倉新田', '272‐1', NULL, NULL, '08067481019', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(51, '2024-04-12 23:16:42', '2024-04-28 10:23:06', NULL, '000040', '2024-04-13', '西浦', '桜子', 'にしうら', 'さくらこ', 'woman', '2003', '11', '13', '3280111', '9', '栃木市都賀町家中', '5787‐8', 'nsur39zo@icloud.com', NULL, '08034328950', NULL, NULL, '$2y$12$R3sXx./r2h/CHqwCpOS6p.7nS0HR7npU3Lq5Dot3uq.CcaRzrUNgi', NULL, NULL, NULL, 'ホットペッパー', '10', NULL, NULL, '0', 'PRjdsANFZYdokeKtDNmksPzf8eCHP9QO0o1wC6llx8O18R5gnPxNiS0rf2Pr'),
(53, '2024-04-17 06:32:03', '2024-04-17 06:32:03', NULL, '000041', '2024-04-17', '須田', '大海', 'すだ', 'はるみ', 'woman', '1991', '06', '10', '3230062', '9', '小山市立木', '1221', NULL, NULL, '09031242536', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(54, '2024-04-19 04:39:20', '2024-04-19 04:39:20', NULL, '000042', '2024-04-19', '福田', '夏未', 'ふくだ', 'なつみ', 'woman', '1991', '08', '06', '3230820', '9', '小山市西城南', '5‐19‐14', NULL, NULL, '08011096086', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '', NULL, NULL, '0', NULL),
(55, '2024-04-21 04:45:29', '2024-04-29 08:01:17', NULL, '000043', '2024-04-21', '川島', '優雅', 'かわしま', 'ゆうが', 'man', '1993', '11', '28', '3700714', '10', '邑楽郡明和町梅原', '983‐5', NULL, NULL, '09072613770', NULL, NULL, NULL, NULL, NULL, NULL, '知人の紹介', '', NULL, NULL, '0', NULL),
(61, '2024-04-22 01:33:28', '2024-04-22 01:53:56', NULL, '000044', '2024-04-21', '小関', '夏希', 'おぜき', 'なつき', 'woman', '1984', '08', '06', '3230022', '9', '小山市駅東通り', '3丁目', NULL, NULL, '09093628643', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(64, '2024-04-22 03:10:16', '2024-04-22 03:10:16', NULL, '000045', '2024-04-22', '岩田', '優衣', 'いわた', 'ゆい', 'woman', '1990', '11', '27', '3230807', '9', '小山市城東', '2‐10‐10', NULL, NULL, '08055233903', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(65, '2024-04-22 03:30:30', '2024-04-22 03:30:30', NULL, '000046', '2024-04-22', '酒巻', '有理', 'さかまき', 'ゆり', 'woman', '1987', '08', '21', '3290205', '9', '小山市間々田', '2390‐27', NULL, NULL, '08050797219', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(67, '2024-04-25 06:26:42', '2024-05-01 11:45:24', '2024-05-01 12:06:19', '000047', '2024-04-25', '鈴木', '和宏', 'すずき', 'かずひろ', 'man', '1994', '01', '01', '０００００００', '10', '９５８５７', '８５７５７', NULL, NULL, '08080336651', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', '10', NULL, NULL, NULL, NULL),
(68, '2024-04-25 06:26:55', '2024-04-25 08:10:50', '2024-04-25 08:10:50', '000048', '2024-04-25', '株式会社モエザ　　　担当　川島花乃', '株式会社モエザ　　　担当　川島花乃', '株式会社モエザ　　　担当　川島花乃', '株式会社モエザ　　　担当　川島花乃', 'man', '1994', '01', '01', '3230820', '9', '小山市西城南', '８５７５７', 'kaz@carries.jp', NULL, '0285377087', NULL, NULL, '$2y$12$yB18PD/Q26iBORBj.MqmV..M8M6K9/bTfKlNW7UNjBmKZP85MS3Ni', NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, NULL, 'YNfAyJaaRdY9GKpftFqyOXx2rW3vslGRvYOiXSnf3sIBGyxDdhNfp64MmGO2'),
(69, '2024-04-27 09:13:19', '2024-04-27 09:13:19', NULL, '000049', '2024-04-27', '吉田', '由加理', 'よしだ', 'ゆかり', 'woman', '1967', '07', '11', '3210903', '9', '宇都宮市下平出町', '150‐2', NULL, NULL, '09025302217', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(70, '2024-04-28 03:28:58', '2024-04-28 03:32:18', NULL, '000050', '2024-04-28', '小谷野', '美佳', 'こやの', 'みか', 'woman', '1983', '06', '08', '3070013', '8', '結城市中', '247', NULL, NULL, '09023007221', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(72, '2024-04-28 07:00:54', '2024-04-28 08:02:19', '2024-05-01 12:06:37', '000051', '2024-04-28', '小山', '泰明', 'こやま', 'やすあき', 'man', '1986', '07', '01', '1540002', '13', '世田谷区下馬', '6‐2‐10', 'koyama.0701.yama@icloud.com', NULL, '09055670022', NULL, NULL, '$2y$12$SAKRtP5T0jSUubsAZMN//.N.kxKTOOPBlGoxkUtmcExzmHT7PadYS', NULL, NULL, NULL, 'ホットペッパー', '10', NULL, NULL, NULL, '3j2WwBNrMHhawoDR4739WOv7dRF81dzODaeP0P9qt9ge6hIjgRMr6OT4rKS7'),
(77, '2024-04-29 04:21:21', '2024-04-29 04:21:21', NULL, '000052', '2024-04-29', '檜山', '琴美', 'ひやま', 'ことみ', 'woman', '2003', '08', '19', '3070001', '8', '結城市結城', '1605‐3', NULL, NULL, '07043579872', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(78, '2024-04-29 07:15:21', '2024-05-02 03:31:54', NULL, '000053', '2024-04-29', '須藤', 'ひな', 'すどう', 'ひな', 'woman', '2003', '01', '05', '3091107', '8', '筑西市門井', '1935‐1', 'sudo2003@icloud.com', NULL, '08081447678', NULL, NULL, '$2y$12$55vYh0603j.EHoHFW02yAObWIYlvhDzQOoyUY/b86dOc3oEmPvH8O', NULL, NULL, NULL, '知人の紹介', NULL, NULL, '一色道代', '0', 'eyuyLOyVRBwIRxt09pN6Hlla9rsLXgwjWCqB2ZY94azZslFlSqObkVpicnvT'),
(82, '2024-05-01 02:10:39', '2024-05-01 02:10:39', NULL, '000054', '2024-05-01', '山本', '栞', 'やまもと', 'しおり', 'woman', '1993', '10', '31', '3070043', '8', '結城市武井', '538', NULL, NULL, '08047331334', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, NULL, '0', NULL),
(83, '2024-05-01 11:02:15', '2024-05-01 11:06:44', NULL, '000055', '2024-05-01', '男庭', '愛里沙', 'おにわ', 'ありさ', 'woman', '1995', '05', '27', '3070053', '8', '結城市新福寺', '5‐7‐7', 'ari310.oni@gmail.com', NULL, '09059952388', NULL, NULL, '$2y$12$yvpYB3gye7Bhl/EJQcNehuoyu9SIQp.VB3WMXN6qI6b7llYpZXw22', NULL, NULL, NULL, 'ホットペッパー', '10', NULL, NULL, '0', 'Ew6boVJsaXwQScnB3JyETvAuiTX0xtux8apUTVb0itGL1qywpToZgzWzA44r'),
(90, '2024-05-02 07:17:14', '2024-05-02 08:28:05', NULL, '000056', '2024-05-02', '播田實', '由香', 'はたみ', 'ゆか', 'woman', '1982', '11', '13', '3230820', '9', '小山市西城南', '6‐24‐9', 'mosugutys@gmail.com', NULL, '09010452470', NULL, NULL, NULL, NULL, NULL, NULL, 'ホットペッパー', NULL, NULL, '', '0', NULL);

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
  `point` int(11) DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `visit_histories`
--

INSERT INTO `visit_histories` (`id`, `created_at`, `updated_at`, `deleted_at`, `visit_history_serial`, `serial_keiyaku`, `serial_user`, `serial_staff`, `date_visit`, `treatment_dtails`, `point`, `remarks`) VALUES
(1, '2024-01-19 19:37:05', '2024-02-06 23:37:32', NULL, 'V_000001-0001-01', 'K_000001-0001', '000001', 'SF_002', '2024-01-20', '脂肪冷却', NULL, NULL),
(2, '2024-01-21 18:06:17', '2024-01-21 18:06:17', NULL, 'V_000002-0001-01', 'K_000002-0001', '000002', NULL, '2024-01-22', '脂肪冷却', NULL, NULL),
(3, '2024-01-27 22:08:30', '2024-01-27 22:11:30', NULL, 'V_000003-0001-01', 'K_000003-0001', '000003', NULL, '2024-01-28', 'キャピ＋脂肪冷却', NULL, NULL),
(4, '2024-02-02 21:47:39', '2024-02-06 23:39:33', NULL, 'V_000004-0001-01', 'K_000004-0001', '000004', 'SF_002', '2024-02-03', '全身脱毛＋顔＋VIO', NULL, NULL),
(5, '2024-02-03 00:34:05', '2024-02-03 00:34:05', NULL, 'V_000005-0001-01', 'K_000005-0001', '000005', NULL, '2024-02-03', '0', NULL, NULL),
(6, '2024-02-06 22:41:54', '2024-02-06 22:42:26', NULL, 'V_000006-0001-01', 'K_000006-0001', '000006', 'SF_002', '2024-02-07', 'フェイシャル', NULL, NULL),
(7, '2024-02-08 20:41:05', '2024-02-08 21:07:44', NULL, 'V_000007-0001-01', 'K_000007-0001', '000007', NULL, '2024-02-09', 'ハイドラ＋フォト', NULL, NULL),
(9, '2024-02-10 01:24:47', '2024-02-10 01:25:02', NULL, 'V_000008-0001-01', 'K_000008-0001', '000008', 'SF_002', '2024-02-10', 'ハイドラ＋フォト', NULL, NULL),
(10, '2024-02-11 19:39:36', '2024-02-11 19:40:33', NULL, 'V_000009-0001-01', 'K_000009-0001', '000009', 'SF_002', '2024-02-12', 'キャピ＋脂肪冷却', NULL, NULL),
(11, '2024-02-14 01:28:14', '2024-02-14 01:28:27', NULL, 'V_000010-0001-01', 'K_000010-0001', '000010', 'SF_002', '2024-02-14', 'ハイドラ＋フォト', NULL, NULL),
(12, '2024-02-14 23:33:46', '2024-05-05 04:17:10', NULL, 'V_000010-0002-01', 'K_000010-0002', '000010', NULL, '2024-02-15', '全身脱毛＋顔＋VIO', NULL, NULL),
(13, '2024-02-16 18:11:45', '2024-02-16 18:13:07', NULL, 'V_000011-0001-01', 'K_000011-0001', '000011', NULL, '2024-02-17', 'ハイドラフェイシャル', NULL, NULL),
(15, '2024-02-16 21:11:01', '2024-02-16 21:11:20', NULL, 'V_000012-0001-01', 'K_000012-0001', '000012', 'SF_002', '2024-02-17', 'ハイドラ＋フォト', NULL, NULL),
(16, '2024-02-17 18:41:42', '2024-02-17 18:41:56', NULL, 'V_000013-0001-01', 'K_000013-0001', '000013', 'SF_002', '2024-02-18', 'ハイドラ＋フォト', NULL, NULL),
(17, '2024-02-17 20:17:41', '2024-02-17 20:54:01', NULL, 'V_000003-0002-01', 'K_000003-0002', '000003', NULL, '2024-02-18', '脂肪冷却', NULL, NULL),
(18, '2024-02-17 20:20:55', '2024-05-02 03:45:12', NULL, 'V_000003-0003-01', 'K_000003-0003', '000003', 'SF_002', '2024-03-07', '脂肪冷却', NULL, NULL),
(21, '2024-02-17 20:52:53', '2024-02-17 20:54:01', NULL, 'V_000003-0002-02', 'K_000003-0002', '000003', NULL, '2024-02-18', 'ハイドラフェイシャル', NULL, NULL),
(26, '2024-02-21 01:04:17', '2024-04-24 09:44:28', NULL, 'V_000001-0002-01', 'K_000001-0002', '000001', NULL, '2024-02-21', 'キャピ＋脂肪冷却', NULL, NULL),
(28, '2024-02-25 01:52:50', '2024-02-25 01:53:25', NULL, 'V_000014-0001-01', 'K_000014-0001', '000014', 'SF_002', '2024-02-25', '脂肪冷却＋ハイドラ', NULL, NULL),
(29, '2024-02-25 18:45:57', '2024-02-25 18:46:10', NULL, 'V_000015-0001-01', 'K_000015-0001', '000015', 'SF_002', '2024-02-26', 'ハイドラ＋フォト', NULL, NULL),
(30, '2024-02-25 20:23:05', '2024-02-25 20:23:41', NULL, 'V_000016-0001-01', 'K_000016-0001', '000016', 'SF_002', '2024-02-26', '脂肪冷却＋ハイドラ', NULL, NULL),
(31, '2024-02-27 19:21:21', '2024-02-27 19:21:52', NULL, 'V_000017-0001-01', 'K_000017-0001', '000017', 'SF_002', '2024-02-28', '脂肪冷却', NULL, NULL),
(32, '2024-02-29 20:32:28', '2024-02-29 20:33:28', NULL, 'V_000018-0001-01', 'K_000018-0001', '000018', 'SF_002', '2024-03-01', 'フェイシャル', NULL, NULL),
(33, '2024-03-01 01:10:08', '2024-03-01 01:10:19', NULL, 'V_000019-0001-01', 'K_000019-0001', '000019', 'SF_002', '2024-03-01', 'ハイドラ＋フォト', NULL, NULL),
(34, '2024-03-01 23:59:35', '2024-03-02 00:02:07', NULL, 'V_000020-0001-01', 'K_000020-0001', '000020', NULL, '2024-03-02', '全身脱毛＋顔＋VIO', NULL, NULL),
(36, '2024-03-05 17:56:19', '2024-03-05 17:56:19', NULL, 'V_000021-0001-01', 'K_000021-0001', '000021', NULL, '2024-03-06', 'ハイドラフェイシャル', NULL, NULL),
(37, '2024-03-05 18:25:04', '2024-03-05 18:25:50', NULL, 'V_000022-0001-01', 'K_000022-0001', '000022', 'SF_002', '2024-03-06', '脂肪冷却', NULL, NULL),
(39, '2024-03-05 21:47:23', '2024-05-05 04:17:10', NULL, 'V_000010-0002-02', 'K_000010-0002', '000010', NULL, '2024-03-06', '全身脱毛＋顔＋VIO', NULL, NULL),
(44, '2024-03-06 18:47:42', '2024-03-06 18:48:45', NULL, 'V_000005-0003-01', 'K_000005-0003', '000005', NULL, '2024-03-07', '脂肪冷却', NULL, NULL),
(47, '2024-03-06 18:49:03', '2024-03-27 19:01:26', NULL, 'V_000005-0002-01', 'K_000005-0002', '000005', NULL, '2024-03-07', 'キャビテーション', NULL, NULL),
(51, '2024-03-07 22:44:44', '2024-03-07 22:45:15', NULL, 'V_000009-0002-01', 'K_000009-0002', '000009', 'SF_002', '2024-03-08', '脂肪冷却＋ハイドラ＋フォト＋パック', NULL, NULL),
(52, '2024-03-08 02:47:45', '2024-03-08 02:48:31', NULL, 'V_000023-0001-01', 'K_000023-0001', '000023', NULL, '2024-03-08', '全身脱毛＋顔＋VIO', NULL, NULL),
(54, '2024-03-08 18:35:14', '2024-03-08 18:36:20', NULL, 'V_000024-0001-01', 'K_000024-0001', '000024', 'SF_002', '2024-03-09', '全身脱毛＋顔＋VIO', NULL, NULL),
(55, '2024-03-12 23:15:43', '2024-03-12 23:17:14', NULL, 'V_000025-0001-01', 'K_000025-0001', '000025', 'SF_002', '2024-03-13', '全身脱毛＋顔＋VIO', NULL, NULL),
(56, '2024-03-13 18:22:12', '2024-03-13 18:22:56', NULL, 'V_000026-0001-01', 'K_000026-0001', '000026', 'SF_002', '2024-03-14', '全身脱毛＋顔＋VIO', NULL, NULL),
(58, '2024-03-16 23:40:22', '2024-05-02 03:44:58', NULL, 'V_000003-0003-02', 'K_000003-0003', '000003', NULL, '2024-03-17', '脂肪冷却', NULL, NULL),
(59, '2024-03-17 18:21:59', '2024-03-17 18:22:16', NULL, 'V_000027-0001-01', 'K_000027-0001', '000027', 'SF_002', '2024-03-18', 'ハイドラ＋フォト', NULL, NULL),
(60, '2024-03-20 20:20:43', '2024-03-20 22:43:17', NULL, 'V_000028-0001-01', 'K_000028-0001', '000028', 'SF_002', '2024-03-21', '全身脱毛＋顔＋VIO', NULL, NULL),
(63, '2024-03-20 22:38:57', '2024-05-02 03:44:58', NULL, 'V_000003-0003-03', 'K_000003-0003', '000003', NULL, '2024-03-21', '脂肪冷却', NULL, NULL),
(68, '2024-03-24 21:47:08', '2024-03-24 21:47:21', NULL, 'V_000029-0001-01', 'K_000029-0001', '000029', 'SF_002', '2024-03-25', 'ハイドラ＋フォト', NULL, NULL),
(69, '2024-03-24 22:24:23', '2024-03-24 22:24:53', NULL, 'V_000029-0002-01', 'K_000029-0002', '000029', 'SF_002', '2024-03-25', '脂肪冷却', NULL, NULL),
(70, '2024-03-26 22:23:04', '2024-03-26 22:23:50', NULL, 'V_000030-0001-01', 'K_000030-0001', '000030', 'SF_002', '2024-03-27', '全身脱毛＋顔＋VIO', NULL, NULL),
(72, '2024-03-27 01:14:36', '2024-04-24 09:44:28', NULL, 'V_000001-0002-02', 'K_000001-0002', '000001', NULL, '2024-03-27', 'キャピ＋脂肪冷却', NULL, NULL),
(73, '2024-03-27 17:42:09', '2024-04-28 03:36:43', NULL, 'V_000022-0002-01', 'K_000022-0002', '000022', NULL, '2024-03-28', '脂肪冷却', NULL, NULL),
(75, '2024-03-27 19:01:26', '2024-03-27 19:01:26', NULL, 'V_000005-0002-02', 'K_000005-0002', '000005', NULL, '2024-03-28', 'キャビテーション', NULL, NULL),
(76, '2024-04-01 01:08:02', '2024-04-01 01:08:30', NULL, 'V_000031-0001-01', 'K_000031-0001', '000031', 'SF_002', '2024-04-01', '脂肪冷却', NULL, NULL),
(80, '2024-04-02 21:57:23', '2024-05-05 04:17:10', NULL, 'V_000010-0002-03', 'K_000010-0002', '000010', NULL, '2024-04-03', '全身脱毛＋顔＋VIO', NULL, NULL),
(84, '2024-04-05 19:38:37', '2024-04-05 19:38:49', NULL, 'V_000032-0001-01', 'K_000032-0001', '000032', 'SF_002', '2024-04-06', 'フォトフェイシャル', NULL, NULL),
(85, '2024-04-05 21:44:08', '2024-04-05 21:44:18', NULL, 'V_000033-0002-01', 'K_000033-0002', '000033', 'SF_002', '2024-04-06', 'ハイドラ＋フォト', NULL, NULL),
(86, '2024-04-06 18:46:53', '2024-04-06 18:47:15', NULL, 'V_000031-0003-01', 'K_000031-0003', '000031', 'SF_002', '2024-04-07', 'フォトフェイシャル', NULL, NULL),
(87, '2024-04-06 23:45:11', '2024-04-06 23:45:40', NULL, 'V_000034-0001-01', 'K_000034-0001', '000034', 'SF_002', '2024-04-07', '全身脱毛＋顔＋VIO', NULL, NULL),
(88, '2024-04-07 01:05:41', '2024-04-07 01:05:53', NULL, 'V_000035-0001-01', 'K_000035-0001', '000035', 'SF_002', '2024-04-07', 'ハイドラ＋フォト', NULL, NULL),
(92, NULL, '2024-04-09 23:41:13', '2024-04-09 23:41:13', 'K_000036-0001-01', 'K_000036-0001', '000036', NULL, '2024-04-10', NULL, 1, NULL),
(93, '2024-04-09 23:41:13', '2024-04-11 19:37:54', NULL, 'V_000036-0001-01', 'K_000036-0001', '000036', 'SF_002', '2024-04-12', '全身脱毛＋顔＋VIO', NULL, NULL),
(97, '2024-04-10 16:43:12', '2024-04-10 16:43:12', NULL, 'SF_002-2024-04-11', 'STAFF', 'SF_002', NULL, '2024-04-11', NULL, NULL, NULL),
(98, '2024-04-10 16:43:18', '2024-04-10 16:43:18', NULL, 'SF_001-2024-04-11', 'STAFF', 'SF_001', NULL, '2024-04-11', NULL, NULL, NULL),
(102, '2024-04-10 18:27:48', '2024-05-02 03:44:58', NULL, 'V_000003-0003-04', 'K_000003-0003', '000003', NULL, '2024-04-11', '脂肪冷却', NULL, NULL),
(107, '2024-04-10 21:13:29', '2024-04-10 21:13:35', NULL, 'V_000009-0003-01', 'K_000009-0003', '000009', 'SF_002', '2024-04-11', '脂肪冷却', NULL, NULL),
(109, '2024-04-11 21:20:13', '2024-04-11 21:20:27', NULL, 'V_000037-0001-01', 'K_000037-0001', '000037', 'SF_002', '2024-04-12', 'ハイドラ＋フォト', NULL, NULL),
(110, '2024-04-11 23:24:43', '2024-04-11 23:24:43', NULL, 'SF_002-2024-04-12', 'STAFF', 'SF_002', NULL, '2024-04-12', NULL, NULL, NULL),
(111, '2024-04-12 00:36:22', '2024-04-12 00:36:42', NULL, 'V_000038-0001-01', 'K_000038-0001', '000038', 'SF_002', '2024-04-12', 'キャピ＋脂肪冷却', NULL, NULL),
(112, '2024-04-12 02:26:25', '2024-04-12 02:26:25', NULL, 'V_000039-0001-01', 'K_000039-0001', '000039', NULL, '2024-04-12', 'ハイドラフェイシャル', NULL, NULL),
(113, '2024-04-12 17:58:58', '2024-04-12 20:14:55', NULL, 'V_000024-0002-01', 'K_000024-0002', '000024', 'SF_002', '2024-04-13', '全身脱毛＋顔＋VIO', NULL, NULL),
(115, '2024-04-13 00:55:33', '2024-04-13 00:55:41', NULL, 'V_000040-0001-01', 'K_000040-0001', '000040', 'SF_002', '2024-04-13', 'キャピ＋脂肪冷却', NULL, NULL),
(116, '2024-04-17 04:12:18', '2024-04-17 04:13:23', NULL, 'V_000026-0002-01', 'K_000026-0002', '000026', 'SF_002', '2024-04-17', '全身脱毛＋顔＋VIO', NULL, NULL),
(117, '2024-04-17 06:32:58', '2024-04-17 06:32:58', NULL, 'V_000041-0001-01', 'K_000041-0001', '000041', NULL, '2024-04-17', 'ハイドラ＋フォト', NULL, NULL),
(122, '2024-04-18 03:27:56', '2024-05-02 03:44:58', NULL, 'V_000003-0003-05', 'K_000003-0003', '000003', NULL, '2024-04-18', '脂肪冷却', NULL, NULL),
(124, '2024-04-19 02:02:25', '2024-04-28 03:36:43', NULL, 'V_000022-0002-02', 'K_000022-0002', '000022', NULL, '2024-04-19', '脂肪冷却', NULL, NULL),
(127, '2024-04-19 05:15:58', '2024-04-19 05:16:16', NULL, 'V_000042-0001-01', 'K_000042-0001', '000042', 'SF_002', '2024-04-19', '脂肪冷却＋ハイドラ', NULL, NULL),
(128, '2024-04-20 08:56:27', '2024-04-20 08:56:52', NULL, 'V_000040-0002-01', 'K_000040-0002', '000040', 'SF_002', '2024-04-20', '脂肪冷却', NULL, NULL),
(129, '2024-04-21 05:18:24', '2024-04-21 05:18:24', NULL, 'V_000043-0001-01', 'K_000043-0001', '000043', NULL, '2024-04-21', '脂肪冷却', NULL, NULL),
(130, '2024-04-22 01:34:57', '2024-04-22 01:54:27', NULL, 'V_000044-0001-01', 'K_000044-0001', '000044', NULL, '2024-04-21', 'ハイドラ＋フォト', NULL, NULL),
(133, '2024-04-22 03:11:14', '2024-04-22 03:11:14', NULL, 'V_000045-0001-01', 'K_000045-0001', '000045', NULL, '2024-04-22', 'ハイドラフェイシャル', NULL, NULL),
(134, '2024-04-22 04:35:10', '2024-04-22 04:35:23', NULL, 'V_000046-0001-01', 'K_000046-0001', '000046', 'SF_002', '2024-04-22', 'ハイドラ＋フォト', NULL, NULL),
(135, '2024-04-22 09:49:58', '2024-04-22 09:50:24', NULL, 'V_000031-0002-01', 'K_000031-0002', '000031', 'SF_002', '2024-04-22', '脂肪冷却', NULL, NULL),
(139, '2024-04-24 07:00:11', '2024-05-05 04:17:10', NULL, 'V_000010-0002-04', 'K_000010-0002', '000010', NULL, '2024-04-24', '全身脱毛＋顔＋VIO', NULL, NULL),
(144, '2024-04-24 09:44:12', '2024-04-24 10:31:04', NULL, 'V_000001-0002-03', 'K_000001-0002', '000001', 'SF_002', '2024-04-24', 'キャピ＋脂肪冷却', NULL, NULL),
(148, '2024-04-27 09:14:35', '2024-04-27 09:49:18', NULL, 'V_000049-0001-01', 'K_000049-0001', '000049', 'SF_002', '2024-04-27', '脂肪冷却＋ハイドラ', NULL, NULL),
(149, '2024-04-28 03:29:57', '2024-04-28 03:30:10', NULL, 'V_000050-0001-01', 'K_000050-0001', '000050', 'SF_002', '2024-04-28', 'ハイドラ＋フォト', NULL, NULL),
(152, '2024-04-29 04:48:10', '2024-04-29 05:05:15', NULL, 'V_000052-0001-01', 'K_000052-0001', '000052', 'SF_002', '2024-04-29', '全身脱毛＋顔＋VIO', NULL, NULL),
(153, '2024-04-29 07:23:12', '2024-04-29 07:23:31', NULL, 'V_000053-0001-01', 'K_000053-0001', '000053', 'SF_002', '2024-04-29', '脂肪冷却＋ハイドラ', NULL, NULL),
(154, '2024-05-01 03:40:52', '2024-05-01 03:41:23', NULL, 'V_000054-0001-01', 'K_000054-0001', '000054', 'SF_002', '2024-05-01', 'キャピ＋脂肪冷却', NULL, NULL),
(155, '2024-05-01 11:21:09', '2024-05-01 11:21:09', NULL, 'V_000055-0001-01', 'K_000055-0001', '000055', NULL, '2024-05-01', 'ハイドラフェイシャル', NULL, NULL),
(161, '2024-05-02 03:44:58', '2024-05-02 04:32:56', NULL, 'V_000003-0003-06', 'K_000003-0003', '000003', 'SF_002', '2024-05-02', '脂肪冷却', NULL, NULL),
(162, '2024-05-02 08:28:57', '2024-05-02 08:29:09', NULL, 'V_000056-0001-01', 'K_000056-0001', '000056', 'SF_002', '2024-05-02', 'ハイドラ＋フォト', NULL, NULL),
(163, '2024-05-02 09:38:07', '2024-05-02 09:38:44', NULL, 'V_000040-0003-01', 'K_000040-0003', '000040', 'SF_002', '2024-05-02', 'キャピ＋脂肪冷却', NULL, NULL),
(164, '2024-05-05 02:03:28', '2024-05-05 03:10:17', NULL, 'V_000036-0002-01', 'K_000036-0002', '000036', 'SF_002', '2024-05-05', '全身脱毛＋顔＋VIO', NULL, NULL),
(169, '2024-05-05 04:56:50', '2024-05-05 05:07:58', NULL, 'V_000038-0002-01', 'K_000038-0002', '000038', 'SF_002', '2024-05-05', '脂肪冷却', NULL, NULL),
(170, '2024-05-05 07:07:24', '2024-05-05 07:08:12', NULL, 'V_000039-0002-01', 'K_000039-0002', '000039', 'SF_002', '2024-05-05', '脂肪冷却', NULL, NULL);

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
-- テーブルのインデックス `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `recorders`
--
ALTER TABLE `recorders`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルの AUTO_INCREMENT `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- テーブルの AUTO_INCREMENT `contract_details`
--
ALTER TABLE `contract_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルの AUTO_INCREMENT `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- テーブルの AUTO_INCREMENT `recorders`
--
ALTER TABLE `recorders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- テーブルの AUTO_INCREMENT `visit_histories`
--
ALTER TABLE `visit_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
