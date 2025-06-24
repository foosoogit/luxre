-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql1404b.xserver.jp
-- 生成日時: 2025 年 6 月 10 日 08:11
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
-- データベース: `foosoo_nagano01`
--
CREATE DATABASE IF NOT EXISTS `foosoo_nagano01` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foosoo_nagano01`;

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
(2, '2024-01-17 23:30:23', '2024-01-17 23:30:23', 'ksuzuki', 'A_001', 'moezbeauty.ts@gmail.com_fault', NULL, '$2y$12$.xYNnzvs1JAxouv6hemoFuJVKArpko03dvsi1sGW2i08SbyrAEIoe', NULL),
(3, '2025-06-06 03:28:24', '2025-06-06 03:28:29', 'ksuzuki', 'A_002', 'info@luxre.site', NULL, '$2y$12$SHDBul0t3ACIMQelzEc0Pe6Q89Gf63jESGT.aPxRHCgdhbwkLNZ6a', NULL);

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
-- テーブルの構造 `cash_books`
--

DROP TABLE IF EXISTS `cash_books`;
CREATE TABLE `cash_books` (
  `id` int(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `target_date` varchar(10) NOT NULL,
  `in_out` varchar(5) NOT NULL,
  `summary` varchar(100) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `balance` varchar(10) DEFAULT NULL,
  `inputter` varchar(10) DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(13, NULL, NULL, 'PointValidityTerm', '1', NULL, 'ポイント有効期間(年数)'),
(14, '2024-10-15 01:56:20', '2024-10-15 01:56:20', 'BookingDisplayPeriod', '7', NULL, '予約連絡表示期間'),
(15, '2024-10-15 01:56:20', '2024-10-15 01:56:20', 'BirthdayDisplayPeriod', '7', NULL, '誕生日表示期間'),
(16, '2025-03-04 02:31:59', '2025-03-04 02:32:08', 'PaymentMethod', 'card_クレジットカード,paypay_PayPay,smart_スマート支払い,cash_現金,default_支払い不履行', NULL, '支払い方法');

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
(1, '2024-01-19 19:36:36', '2024-06-17 08:46:08', NULL, 'K_000001-0001', '000001', NULL, NULL, '1', '2024-01-20', NULL, 'cyclic', '脂肪冷却', '2024-01-20', '4900', 'K_000001-0001', '4900', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-01-20', NULL, 'SF_002', '2024-01-20', NULL, NULL),
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
(25, '2024-02-14 01:31:36', '2025-01-16 06:59:15', NULL, 'K_000010-0002', '000010', NULL, NULL, NULL, '2024-02-14', NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-02-14', '12000', 'K_000010-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-01-16', NULL, NULL),
(28, '2024-02-16 18:11:22', '2024-02-16 18:13:07', NULL, 'K_000011-0001', '000011', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-02-17', '4500', 'K_000011-0001', '4500', '現金', '1', '2024-02-17', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(30, '2024-02-16 21:10:41', '2024-02-16 21:11:01', NULL, 'K_000012-0001', '000012', NULL, NULL, '1', '2024-02-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-17', '6500', 'K_000012-0001', '6500', '現金', '1', '2024-02-17', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-02-17', NULL, NULL),
(31, '2024-02-17 18:41:24', '2024-02-17 18:43:03', NULL, 'K_000013-0001', '000013', NULL, NULL, '1', '2024-02-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-02-18', '6000', 'K_000013-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(33, '2024-02-17 20:17:20', '2024-03-06 17:43:22', NULL, 'K_000003-0002', '000003', NULL, NULL, '2', '2024-02-18', NULL, 'cyclic', '脂肪冷却（LINEクーポン）', '2024-02-18', '9500', 'K_000003-0002', '9500', '現金', '1', '2024-02-18', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-02-18', NULL, NULL),
(34, '2024-02-17 20:20:35', '2025-03-06 02:36:51', NULL, 'K_000003-0003', '000003', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-03-07', '20000', 'K_000003-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2025-02-19', NULL, NULL),
(39, '2024-02-21 00:03:02', '2024-06-18 00:35:56', NULL, 'K_000001-0002', '000001', NULL, NULL, NULL, '2024-02-21', NULL, 'subscription', 'キャピテーション＋脂肪冷却', '2024-02-21', '21600', 'K_000001-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-04-24', '2024-04-28', NULL),
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
(62, '2024-03-08 18:36:57', '2024-12-22 08:47:22', NULL, 'K_000024-0002', '000024', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-03-09', '12000', 'K_000024-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-12-22', NULL, NULL),
(63, '2024-03-09 00:05:33', '2024-08-28 04:18:11', NULL, 'K_000022-0002', '000022', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-03-28', '16000', 'K_000022-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-07-31', NULL, '3週間に1回の方'),
(64, '2024-03-12 23:15:25', '2024-03-12 23:15:43', NULL, 'K_000025-0001', '000025', NULL, NULL, '1', '2024-03-13', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-13', '4000', 'K_000025-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-03-13', NULL, 'SF_002', '2024-03-13', NULL, NULL),
(65, '2024-03-13 18:21:52', '2024-03-13 18:22:12', NULL, 'K_000026-0001', '000026', NULL, NULL, '1', '2024-03-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-14', '4000', 'K_000026-0001', '4000', '現金', '1', '2024-03-14', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-14', NULL, NULL),
(66, '2024-03-13 18:23:45', '2024-06-26 09:26:13', NULL, 'K_000026-0002', '000026', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-03-14', '12000', 'K_000026-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '2024-05-30', '2024-06-26', NULL),
(67, '2024-03-17 18:21:40', '2024-03-17 18:21:59', NULL, 'K_000027-0001', '000027', NULL, NULL, '1', '2024-03-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-03-18', '6000', 'K_000027-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-03-18', NULL, 'SF_002', '2024-03-18', NULL, NULL),
(68, '2024-03-20 20:20:29', '2024-03-20 20:20:43', NULL, 'K_000028-0001', '000028', NULL, NULL, '1', '2024-03-21', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-21', '4000', 'K_000028-0001', '4000', '現金', '1', '2024-03-21', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-21', NULL, NULL),
(69, '2024-03-24 21:46:48', '2024-03-24 21:47:08', NULL, 'K_000029-0001', '000029', NULL, NULL, '1', '2024-03-25', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-03-25', '6000', 'K_000029-0001', '6000', '現金', '1', '2024-03-25', NULL, '6000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-25', NULL, NULL),
(70, '2024-03-24 22:24:00', '2024-03-24 22:24:23', NULL, 'K_000029-0002', '000029', NULL, NULL, '1', '2024-03-25', NULL, 'cyclic', '脂肪冷却', '2024-03-25', '16000', 'K_000029-0002', '16000', '現金', '1', '2024-03-25', NULL, '16000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-25', NULL, NULL),
(71, '2024-03-26 22:22:47', '2024-03-26 22:23:04', NULL, 'K_000030-0001', '000030', NULL, NULL, '1', '2024-03-27', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-03-27', '4000', 'K_000030-0001', '4000', '現金', '1', '2024-03-27', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-03-27', NULL, NULL),
(75, '2024-04-01 01:07:43', '2024-04-01 01:08:02', NULL, 'K_000031-0001', '000031', NULL, NULL, '1', '2024-04-01', NULL, 'cyclic', '脂肪冷却', '2024-04-01', '4000', 'K_000031-0001', '4000', '現金', '1', '2024-04-01', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-01', NULL, NULL),
(76, '2024-04-01 01:09:15', '2024-09-06 06:19:07', NULL, 'K_000031-0002', '000031', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-01', '16000', 'K_000031-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-04-22', '2024-09-06', NULL),
(78, '2024-04-05 19:38:17', '2024-04-05 19:38:37', NULL, 'K_000032-0001', '000032', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'フォトフェイシャル', '2024-04-06', '4600', 'K_000032-0001', '4600', '現金', '1', '2024-04-06', NULL, '4600', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-06', NULL, NULL),
(79, '2024-04-05 21:43:44', '2024-04-05 22:33:34', '2024-04-05 22:33:34', 'K_000033-0001', '000033', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-06', '5500', 'K_000033-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-06', NULL, 'SF_002', NULL, NULL, NULL),
(80, '2024-04-05 21:43:50', '2024-04-05 21:44:08', NULL, 'K_000033-0002', '000033', NULL, NULL, '1', '2024-04-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-06', '5500', 'K_000033-0002', '5500', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-04-06', NULL, 'SF_002', '2024-04-06', NULL, NULL),
(81, '2024-04-06 18:46:34', '2024-04-06 18:46:53', NULL, 'K_000031-0003', '000031', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', 'フォトフェイシャル＋パック', '2024-04-07', '4000', 'K_000031-0003', '4000', '現金', '1', '2024-04-07', NULL, '4000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-07', NULL, NULL),
(82, '2024-04-06 23:43:13', '2024-04-06 23:45:11', NULL, 'K_000034-0001', '000034', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-07', '4000', 'K_000034-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-07', NULL, 'SF_002', '2024-04-07', NULL, NULL),
(84, '2024-04-07 01:05:03', '2024-04-07 01:05:41', NULL, 'K_000035-0001', '000035', NULL, NULL, '1', '2024-04-07', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-07', '6500', 'K_000035-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-07', NULL, 'SF_002', '2024-04-07', NULL, NULL),
(85, '2024-04-09 21:02:06', '2024-04-11 19:37:16', NULL, 'K_000036-0001', '000036', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-12', '6000', 'K_000036-0001', '6000', '現金', '1', '2024-04-12', NULL, '6000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(86, '2024-04-10 21:10:36', '2024-04-10 21:13:29', NULL, 'K_000009-0003', '000009', NULL, NULL, '1', '2024-04-11', NULL, 'cyclic', '脂肪冷却', '2024-04-11', '16000', 'K_000009-0003', '16000', '現金', '1', '2024-04-11', NULL, '16000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-11', NULL, NULL),
(87, '2024-04-10 21:14:24', '2025-02-11 07:42:02', NULL, 'K_000009-0004', '000009', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-11', '16000', 'K_000009-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2025-02-06', NULL, NULL),
(90, '2024-04-11 19:38:25', '2024-09-28 04:40:13', NULL, 'K_000036-0002', '000036', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-04-12', '12000', 'K_000036-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', NULL, NULL, NULL, 'SF_002', '2024-08-23', '2024-09-28', NULL),
(91, '2024-04-11 21:19:56', '2024-04-11 21:20:13', NULL, 'K_000037-0001', '000037', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-12', '6500', 'K_000037-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-12', NULL, 'SF_002', '2024-04-12', NULL, NULL),
(92, '2024-04-11 21:21:08', '2024-04-11 21:21:08', NULL, 'K_000037-0002', '000037', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-04-12', '11000', 'K_000037-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', NULL, NULL, NULL),
(93, '2024-04-12 00:36:05', '2024-04-12 00:36:22', NULL, 'K_000038-0001', '000038', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-04-12', '7500', 'K_000038-0001', '7500', '現金', '1', '2024-04-12', NULL, '7500', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(94, '2024-04-12 00:37:14', '2025-02-12 03:45:33', NULL, 'K_000038-0002', '000038', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-12', '16000', 'K_000038-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-08', NULL, NULL),
(95, '2024-04-12 02:25:57', '2024-04-12 02:26:25', NULL, 'K_000039-0001', '000039', NULL, NULL, '1', '2024-04-12', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-04-12', '5000', 'K_000039-0001', '5000', '現金', '1', '2024-04-12', NULL, '5000', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-12', NULL, NULL),
(96, '2024-04-12 02:27:31', '2024-06-18 00:34:17', NULL, 'K_000039-0002', '000039', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却(お腹)', '2024-04-12', '16000', 'K_000039-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '2024-06-17', '2024-06-17', NULL),
(97, '2024-04-13 00:54:19', '2024-04-13 00:55:33', NULL, 'K_000040-0001', '000040', NULL, NULL, '1', '2024-04-13', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-04-13', '7500', 'K_000040-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-04-13', NULL, 'SF_002', '2024-04-13', NULL, NULL),
(98, '2024-04-17 06:32:42', '2024-04-17 06:32:58', NULL, 'K_000041-0001', '000041', NULL, NULL, '1', '2024-04-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-17', '6000', 'K_000041-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-17', NULL, 'SF_002', '2024-04-17', NULL, NULL),
(99, '2024-04-19 05:15:41', '2024-04-19 05:15:58', NULL, 'K_000042-0001', '000042', NULL, NULL, '1', '2024-04-19', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-04-19', '8500', 'K_000042-0001', '8500', '現金', '1', '2024-04-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-19', NULL, NULL),
(100, '2024-04-20 08:56:10', '2024-04-20 08:56:27', NULL, 'K_000040-0002', '000040', NULL, NULL, '1', '2024-04-20', NULL, 'cyclic', '【LINEクーポン】脂肪冷却', '2024-04-20', '5000', 'K_000040-0002', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-20', NULL, 'SF_002', '2024-04-20', NULL, NULL),
(101, '2024-04-21 05:13:56', '2024-04-21 05:18:24', NULL, 'K_000043-0001', '000043', NULL, NULL, '1', '2024-04-21', NULL, 'cyclic', '脂肪冷却', '2024-04-21', '4000', 'K_000043-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-21', NULL, 'SF_002', '2024-04-21', NULL, NULL),
(102, '2024-04-22 01:34:39', '2024-04-22 01:54:27', NULL, 'K_000044-0001', '000044', NULL, NULL, '1', '2024-04-21', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-21', '7000', 'K_000044-0001', '7000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-21', NULL, 'SF_002', '2024-04-21', NULL, NULL),
(106, '2024-04-22 03:10:57', '2024-04-22 03:11:14', NULL, 'K_000045-0001', '000045', NULL, NULL, '1', '2024-04-22', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-04-22', '5000', 'K_000045-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-22', NULL, 'SF_002', '2024-04-22', NULL, NULL),
(107, '2024-04-22 04:34:46', '2024-04-22 04:35:10', NULL, 'K_000046-0001', '000046', NULL, NULL, '1', '2024-04-22', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-22', '6500', 'K_000046-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-04-22', NULL, 'SF_002', '2024-04-22', NULL, NULL),
(108, '2024-04-22 10:00:04', '2024-09-06 06:18:35', NULL, 'K_000031-0004', '000031', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-04-22', '11000', 'K_000031-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-08-28', '2024-09-06', NULL),
(111, '2024-04-27 09:14:11', '2025-05-18 07:56:51', NULL, 'K_000049-0001', '000049', NULL, NULL, '1', '2024-04-27', NULL, 'cyclic', '脂肪冷却＋ハイドラ', '2024-04-27', '8500', 'K_000049-0001', '8500', '現金', '1', '2024-04-27', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-27', NULL, NULL),
(112, '2024-04-27 09:15:15', '2025-02-23 07:21:17', NULL, 'K_000049-0002', '000049', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-04-27', '16000', 'K_000049-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-23', NULL, NULL),
(113, '2024-04-28 03:29:39', '2024-04-28 03:29:57', NULL, 'K_000050-0001', '000050', NULL, NULL, '1', '2024-04-28', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-04-28', '6500', 'K_000050-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-04-28', NULL, 'SF_002', '2024-04-28', NULL, NULL),
(114, '2024-04-28 10:13:50', '2024-11-04 03:47:39', NULL, 'K_000040-0003', '000040', NULL, NULL, NULL, '2024-04-28', NULL, 'subscription', 'キャピテーション＋脂肪冷却', '2024-04-28', '21600', 'K_000040-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-11-04', '2024-11-04', NULL),
(115, '2024-04-29 04:47:56', '2024-04-29 04:48:10', NULL, 'K_000052-0001', '000052', NULL, NULL, '1', '2024-04-29', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-04-29', '6000', 'K_000052-0001', '6000', '現金', '1', '2024-04-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-29', NULL, NULL),
(116, '2024-04-29 07:22:53', '2024-04-29 07:23:12', NULL, 'K_000053-0001', '000053', NULL, NULL, '1', '2024-04-29', NULL, 'cyclic', 'ハイドラ＋脂肪冷却', '2024-04-29', '6000', 'K_000053-0001', '6000', '現金', '1', '2024-04-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-04-29', NULL, NULL),
(117, '2024-04-29 07:24:14', '2025-02-28 07:04:08', NULL, 'K_000053-0002', '000053', NULL, NULL, NULL, '2024-05-22', NULL, 'subscription', '脂肪冷却', '2024-04-29', '16000', 'K_000053-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-28', NULL, '3ヶ月に1回\r\n(3ヶ月分お支払い)'),
(119, '2024-05-01 03:40:35', '2024-05-01 03:40:52', NULL, 'K_000054-0001', '000054', NULL, NULL, '1', '2024-05-01', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-05-01', '7300', 'K_000054-0001', '7300', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-05-01', NULL, 'SF_002', '2024-05-01', NULL, NULL),
(120, '2024-05-01 11:20:54', '2024-05-01 11:22:11', NULL, 'K_000055-0001', '000055', NULL, NULL, '1', '2024-05-01', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-01', '5000', 'K_000055-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-05-01', NULL, 'SF_002', '2024-05-01', NULL, NULL),
(121, '2024-05-01 11:21:42', '2024-07-11 03:48:45', NULL, 'K_000055-0002', '000055', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-05-01', '11000', 'K_000055-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', NULL, NULL, NULL, 'SF_002', '2024-07-11', '2024-07-11', NULL),
(123, '2024-05-02 08:28:41', '2024-05-02 08:28:57', NULL, 'K_000056-0001', '000056', NULL, NULL, '1', '2024-05-02', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-02', '6500', 'K_000056-0001', '6500', '現金', '1', '2024-05-02', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-02', NULL, NULL),
(124, '2024-05-02 08:49:13', '2024-09-14 07:15:56', NULL, 'K_000056-0002', '000056', NULL, NULL, NULL, NULL, NULL, 'subscription', 'フォトフェイシャル', '2024-05-02', '11000', 'K_000056-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-06-14', '2024-06-14', NULL),
(125, '2024-05-05 09:47:15', '2024-05-05 09:47:32', NULL, 'K_000057-0001', '000057', NULL, NULL, '1', '2024-05-05', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-05', '5500', 'K_000057-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-05', NULL, 'SF_002', '2024-05-05', NULL, NULL),
(126, '2024-05-06 03:27:03', '2024-05-06 03:27:24', NULL, 'K_000058-0001', '000058', NULL, NULL, '1', '2024-05-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-06', '6500', 'K_000058-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-06', NULL, 'SF_002', '2024-05-06', NULL, NULL),
(127, '2024-05-10 03:23:19', '2024-08-10 07:19:24', NULL, 'K_000022-0003', '000022', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-05-10', '8000', 'K_000022-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, '追加モニター料金'),
(128, '2024-05-12 03:53:12', '2024-05-12 03:53:29', NULL, 'K_000059-0001', '000059', NULL, NULL, '1', '2024-05-12', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-05-12', '6000', 'K_000059-0001', '6000', '現金', '1', '2024-05-12', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-12', NULL, NULL),
(129, '2024-05-12 05:17:46', '2024-05-12 05:18:05', NULL, 'K_000060-0001', '000060', NULL, NULL, '1', '2024-05-12', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-12', '4800', 'K_000060-0001', '4800', '現金', '1', '2024-05-12', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-12', NULL, NULL),
(130, '2024-05-12 10:31:41', '2024-05-12 10:31:58', NULL, 'K_000061-0001', '000061', NULL, NULL, '1', '2024-05-12', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-12', '6500', 'K_000061-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', 'VISA', '1', '2024-05-12', NULL, 'SF_002', '2024-05-12', NULL, NULL),
(131, '2024-05-13 04:51:54', '2024-05-13 04:52:10', NULL, 'K_000022-0004', '000022', NULL, NULL, '1', '2024-05-13', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-13', '10000', 'K_000022-0004', '10000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-13', NULL, 'SF_002', '2024-05-13', NULL, NULL),
(132, '2024-05-15 03:19:16', '2024-05-15 03:19:33', NULL, 'K_000062-0001', '000062', NULL, NULL, '1', '2024-05-15', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-05-15', '8200', 'K_000062-0001', '8200', '現金', '1', '2024-05-15', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-15', NULL, NULL),
(133, '2024-05-16 03:27:08', '2024-05-16 03:27:24', NULL, 'K_000063-0001', '000063', NULL, NULL, '1', '2024-05-16', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-16', '6500', 'K_000063-0001', '6500', '現金', '1', '2024-05-16', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-16', NULL, NULL),
(134, '2024-05-17 04:53:30', '2024-05-17 04:56:49', NULL, 'K_000064-0001', '000064', NULL, NULL, '1', '2024-05-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-17', '6500', 'K_000064-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-17', NULL, 'SF_002', '2024-05-17', NULL, NULL),
(135, '2024-05-17 05:11:36', '2024-07-06 04:57:27', NULL, 'K_000064-0002', '000064', NULL, NULL, NULL, NULL, NULL, 'subscription', 'キャピテーション＋脂肪冷却', '2024-05-17', '21600', 'K_000064-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-07-06', NULL, NULL),
(136, '2024-05-17 06:49:41', '2024-05-17 06:50:39', NULL, 'K_000065-0001', '000065', NULL, NULL, '1', '2024-05-17', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-17', '6500', 'K_000065-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-17', NULL, 'SF_002', '2024-05-17', NULL, NULL),
(137, '2024-05-18 06:44:16', '2024-05-18 06:44:33', NULL, 'K_000066-0001', '000066', NULL, NULL, '1', '2024-05-18', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-18', '5000', 'K_000066-0001', '5000', '現金', '1', '2024-05-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-18', NULL, NULL),
(138, '2024-05-18 08:05:55', '2024-05-18 08:06:11', NULL, 'K_000049-0003', '000049', NULL, NULL, '1', '2024-05-18', NULL, 'cyclic', '【LINEクーポン】ハイドラ＋フォト', '2024-05-18', '10000', 'K_000049-0003', '10000', '現金', '1', '2024-05-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-18', NULL, NULL),
(139, '2024-05-19 04:20:04', '2024-05-19 04:20:20', NULL, 'K_000067-0001', '000067', NULL, NULL, '1', '2024-05-19', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-05-19', '8000', 'K_000067-0001', '8000', '現金', '1', '2024-05-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-19', NULL, NULL),
(140, '2024-05-19 07:08:37', '2024-05-19 07:08:52', NULL, 'K_000068-0001', '000068', NULL, NULL, '1', '2024-05-19', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-05-19', '7500', 'K_000068-0001', '7500', '現金', '1', '2024-05-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-19', NULL, NULL),
(141, '2024-05-20 03:23:22', '2024-05-20 03:23:39', NULL, 'K_000069-0001', '000069', NULL, NULL, '1', '2024-05-20', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-20', '6500', 'K_000069-0001', '6500', '現金', '1', '2024-05-20', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-20', NULL, NULL),
(142, '2024-05-20 05:03:44', '2024-05-20 05:03:58', NULL, 'K_000070-0001', '000070', NULL, NULL, '1', '2024-05-20', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-05-20', '5000', 'K_000070-0001', '5000', '現金', '1', '2024-05-20', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-20', NULL, NULL),
(143, '2024-05-22 05:00:45', '2024-05-22 05:01:14', NULL, 'K_000071-0001', '000071', NULL, NULL, '1', '2024-05-22', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-22', '4500', 'K_000071-0001', '4500', '現金', '1', '2024-05-22', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-22', NULL, NULL),
(145, '2024-05-22 07:19:53', '2024-06-18 00:33:45', NULL, 'K_000039-0003', '000039', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却(二の腕・太もも)', '2024-05-22', '17600', 'K_000039-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-05-24', '2024-06-17', NULL),
(148, '2024-05-25 03:16:32', '2024-05-25 03:16:49', NULL, 'K_000072-0001', '000072', NULL, NULL, '1', '2024-05-25', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-25', '6500', 'K_000072-0001', '6500', '現金', '1', '2024-05-25', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-25', NULL, NULL),
(149, '2024-05-25 06:28:54', '2024-05-25 06:29:08', NULL, 'K_000073-0001', '000073', NULL, NULL, '1', '2024-05-25', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-25', '5000', 'K_000073-0001', '5000', '現金', '1', '2024-05-25', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-25', NULL, NULL),
(150, '2024-05-26 07:28:58', '2024-05-26 07:29:13', NULL, 'K_000074-0001', '000074', NULL, NULL, '1', '2024-05-26', NULL, 'cyclic', '全身脱毛(VIO込)＋フォト', '2024-05-26', '7000', 'K_000074-0001', '7000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-26', NULL, 'SF_002', '2024-05-26', NULL, NULL),
(151, '2024-05-28 03:07:29', '2024-05-28 04:17:14', NULL, 'K_000043-0002', '000043', NULL, NULL, '1', '2024-05-28', NULL, 'cyclic', '脂肪冷却', '2024-05-28', '4000', 'K_000043-0002', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-28', NULL, 'SF_002', '2024-05-28', NULL, NULL),
(152, '2024-05-29 03:12:39', '2024-05-29 03:12:57', NULL, 'K_000075-0001', '000075', NULL, NULL, '1', '2024-05-29', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-29', '6300', 'K_000075-0001', '6300', '現金', '1', '2024-05-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-05-29', NULL, NULL),
(153, '2024-05-31 09:43:05', '2024-05-31 09:46:20', NULL, 'K_000058-0002', '000058', NULL, NULL, '1', '2024-05-31', NULL, 'cyclic', '【LINEクーポン】ハイドラ＋フォト', '2024-05-31', '10000', 'K_000058-0002', '10000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-05-31', NULL, 'SF_002', '2024-05-31', NULL, NULL),
(154, '2024-05-31 09:50:54', '2025-02-28 05:15:51', NULL, 'K_000058-0003', '000058', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-05-31', '15000', 'K_000058-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-24', NULL, NULL),
(155, '2024-06-01 06:46:09', '2024-06-01 06:46:28', NULL, 'K_000076-0001', '000076', NULL, NULL, '1', '2024-06-01', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-06-01', '5900', 'K_000076-0001', '5900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-01', NULL, 'SF_002', '2024-06-01', NULL, NULL),
(156, '2024-06-01 06:46:52', '2024-11-27 10:33:36', NULL, 'K_000076-0002', '000076', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-06-01', '12000', 'K_000076-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-11-25', '2024-11-27', NULL),
(157, '2024-06-01 08:08:36', '2024-06-01 08:08:51', NULL, 'K_000077-0001', '000077', NULL, NULL, '1', '2024-06-01', NULL, 'cyclic', '脂肪冷却', '2024-06-01', '5500', 'K_000077-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', 'Master', '1', '2024-06-01', NULL, 'SF_002', '2024-06-01', NULL, NULL),
(158, '2024-06-01 10:23:53', '2024-06-01 10:24:08', NULL, 'K_000078-0001', '000078', NULL, NULL, '1', '2024-06-01', NULL, 'cyclic', '脇＆VIO脱毛', '2024-06-01', '5000', 'K_000078-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-01', NULL, 'SF_002', '2024-06-01', NULL, NULL),
(159, '2024-06-02 01:52:41', '2024-07-31 05:05:11', NULL, 'K_000059-0002', '000059', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-06-02', '12000', 'K_000059-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-07-21', '2024-07-31', NULL),
(160, '2024-06-03 03:56:31', '2024-06-03 03:56:46', NULL, 'K_000079-0001', '000079', NULL, NULL, '1', '2024-06-03', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-06-03', '7300', 'K_000079-0001', '7300', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-03', NULL, 'SF_002', '2024-06-03', NULL, NULL),
(161, '2024-06-03 09:17:46', '2024-06-03 09:18:02', NULL, 'K_000080-0001', '000080', NULL, NULL, '1', '2024-06-03', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-03', '4000', 'K_000080-0001', '4000', '現金', '1', '2024-06-03', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-03', NULL, NULL),
(162, '2024-06-05 04:57:44', '2024-06-05 04:58:01', NULL, 'K_000081-0001', '000081', NULL, NULL, '1', '2024-06-05', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-05', '3500', 'K_000081-0001', '3500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-05', NULL, 'SF_002', '2024-06-05', NULL, NULL),
(163, '2024-06-05 07:02:40', '2024-06-05 07:03:19', NULL, 'K_000082-0001', '000082', NULL, NULL, '1', '2024-06-05', NULL, 'cyclic', '脂肪冷却', '2024-06-05', '4500', 'K_000082-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-05', NULL, 'SF_002', '2024-06-05', NULL, NULL),
(165, '2024-06-05 09:15:29', '2024-06-05 09:15:45', NULL, 'K_000083-0001', '000083', NULL, NULL, '1', '2024-06-05', NULL, 'cyclic', 'フォトフェイシャル', '2024-06-05', '6700', 'K_000083-0001', '6700', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-05', NULL, 'SF_002', '2024-06-05', NULL, NULL),
(166, '2024-06-05 10:54:03', '2024-06-05 10:54:46', NULL, 'K_000084-0001', '000084', NULL, NULL, '1', '2024-06-05', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-05', '3500', 'K_000084-0001', '3500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-05', NULL, 'SF_002', '2024-06-05', NULL, NULL),
(168, '2024-06-06 04:30:37', '2024-06-06 04:31:00', NULL, 'K_000085-0001', '000085', NULL, NULL, '1', '2024-06-06', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-06-06', '8500', 'K_000085-0001', '8500', '現金', '1', '2024-06-06', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-06', NULL, NULL),
(169, '2024-06-06 05:55:03', '2024-06-06 06:19:37', NULL, 'K_000009-0005', '000009', NULL, NULL, '1', '2024-06-06', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-06', '10000', 'K_000009-0005', '10000', '現金', '1', '2024-06-06', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-06', NULL, NULL),
(170, '2024-06-06 08:15:32', '2024-06-06 08:15:46', NULL, 'K_000086-0001', '000086', NULL, NULL, '1', '2024-06-06', NULL, 'cyclic', '【トライアル】キャピ＋脂肪冷却', '2024-06-06', '3000', 'K_000086-0001', '3000', '現金', '1', '2024-06-06', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-06', NULL, NULL),
(171, '2024-06-07 10:25:25', '2024-06-07 10:26:14', NULL, 'K_000087-0001', '000087', NULL, NULL, '1', '2024-06-07', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-06-07', '7500', 'K_000087-0001', '7500', '現金', '1', '2024-06-07', NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-06-07', NULL, NULL),
(173, '2024-06-08 03:22:30', '2024-06-08 03:22:47', NULL, 'K_000088-0001', '000088', NULL, NULL, '1', '2024-06-08', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-08', '6500', 'K_000088-0001', '6500', '現金', '1', '2024-06-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-08', NULL, NULL),
(174, '2024-06-08 03:23:29', '2025-02-22 02:00:55', NULL, 'K_000088-0002', '000088', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-06-08', '12000', 'K_000088-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-22', NULL, NULL),
(175, '2024-06-08 07:03:11', '2024-06-08 07:03:26', NULL, 'K_000089-0001', '000089', NULL, NULL, '1', '2024-06-08', NULL, 'cyclic', 'フォトフェイシャル', '2024-06-08', '5000', 'K_000089-0001', '5000', '現金', '1', '2024-06-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-08', NULL, NULL),
(176, '2024-06-09 05:30:09', '2024-06-09 05:30:24', NULL, 'K_000090-0001', '000090', NULL, NULL, '1', '2024-06-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-09', '6100', 'K_000090-0001', '6100', '現金', '1', '2024-06-09', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-09', NULL, NULL),
(177, '2024-06-09 07:00:19', '2024-06-09 07:00:35', NULL, 'K_000091-0001', '000091', NULL, NULL, '1', '2024-06-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-09', '6300', 'K_000091-0001', '6300', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-09', NULL, 'SF_002', '2024-06-09', NULL, NULL),
(178, '2024-06-10 05:21:40', '2024-06-10 05:22:01', NULL, 'K_000092-0001', '000092', NULL, NULL, '1', '2024-06-10', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-10', '6500', 'K_000092-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-10', NULL, 'SF_002', '2024-06-10', NULL, NULL),
(179, '2024-06-12 09:44:45', '2024-06-12 09:45:03', NULL, 'K_000071-0002', '000071', NULL, NULL, '1', '2024-06-12', NULL, 'cyclic', '脂肪冷却', '2024-06-12', '9000', 'K_000071-0002', '9000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-12', NULL, 'SF_002', '2024-06-12', NULL, NULL),
(180, '2024-06-13 04:58:14', '2024-06-13 04:59:08', NULL, 'K_000093-0001', '000093', NULL, NULL, '1', '2024-06-13', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-13', '6500', 'K_000093-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-13', NULL, 'SF_002', '2024-06-13', NULL, NULL),
(181, '2024-06-14 06:27:04', '2024-06-14 06:27:21', NULL, 'K_000094-0001', '000094', NULL, NULL, '1', '2024-06-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-06-14', '6000', 'K_000094-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-14', NULL, 'SF_002', '2024-06-14', NULL, NULL),
(183, '2024-06-14 08:22:41', '2025-02-22 06:33:29', NULL, 'K_000056-0003', '000056', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-14', '15000', 'K_000056-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-22', NULL, NULL),
(185, '2024-06-15 03:34:14', '2024-06-15 03:34:34', NULL, 'K_000095-0001', '000095', NULL, NULL, '1', '2024-06-15', NULL, 'cyclic', 'フォトフェイシャル＋美白パック', '2024-06-15', '5500', 'K_000095-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-15', NULL, 'SF_002', '2024-06-15', NULL, NULL),
(186, '2024-06-15 07:59:12', '2024-06-15 07:59:29', NULL, 'K_000049-0004', '000049', NULL, NULL, '1', '2024-06-15', NULL, 'cyclic', 'ハイドラフェイシャル＋バブルパック', '2024-06-15', '6000', 'K_000049-0004', '6000', '現金', '1', '2024-06-15', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-15', NULL, NULL),
(187, '2024-06-21 07:38:53', '2024-06-21 07:39:24', NULL, 'K_000076-0003', '000076', NULL, NULL, '1', '2024-06-21', NULL, 'cyclic', 'ハイドラ＋パック', '2024-06-21', '6000', 'K_000076-0003', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-21', NULL, 'SF_002', '2024-06-21', NULL, NULL),
(188, '2024-06-22 10:26:26', '2024-06-22 10:26:42', NULL, 'K_000096-0001', '000096', NULL, NULL, '1', '2024-06-22', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-22', '6500', 'K_000096-0001', '6500', '現金', '1', '2024-06-22', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-22', NULL, NULL),
(189, '2024-06-23 03:20:16', '2024-06-23 03:20:31', NULL, 'K_000097-0001', '000097', NULL, NULL, '1', '2024-06-23', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-23', '5000', 'K_000097-0001', '5000', '現金', '1', '2024-06-23', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-23', NULL, NULL),
(190, '2024-06-23 07:12:55', '2024-06-23 07:13:11', NULL, 'K_000098-0001', '000098', NULL, NULL, '1', '2024-06-23', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-06-23', '4500', 'K_000098-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-23', NULL, 'SF_002', '2024-06-23', NULL, NULL),
(191, '2024-06-23 09:03:06', '2024-06-23 09:03:56', NULL, 'K_000099-0001', '000099', NULL, NULL, '1', '2024-06-23', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-23', '4700', 'K_000099-0001', '4700', '現金', '1', '2024-06-23', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-23', NULL, NULL),
(192, '2024-06-24 03:15:12', '2024-06-24 03:20:45', NULL, 'K_000069-0002', '000069', NULL, NULL, '1', '2024-06-24', NULL, 'cyclic', '【LINEクーポン】ハイドラ＋フォト', '2024-06-24', '10000', 'K_000069-0002', '10000', '現金', '1', '2024-06-24', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-24', NULL, NULL),
(193, '2024-06-24 07:38:03', '2024-06-24 07:38:19', NULL, 'K_000100-0001', '000100', NULL, NULL, '1', '2024-06-24', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-24', '2700', 'K_000100-0001', '2700', '現金', '1', '2024-06-24', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-24', NULL, NULL),
(194, '2024-06-24 11:00:20', '2024-06-24 11:00:37', NULL, 'K_000031-0005', '000031', NULL, NULL, '1', '2024-06-24', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-24', '5000', 'K_000031-0005', '5000', '現金', '1', '2024-06-24', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-24', NULL, NULL),
(195, '2024-06-26 07:54:10', '2024-06-26 07:55:23', NULL, 'K_000101-0001', '000101', NULL, NULL, '1', '2024-06-26', NULL, 'cyclic', '脇＆VIO脱毛', '2024-06-26', '5000', 'K_000101-0001', '5000', '現金', '1', '2024-06-26', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-26', NULL, NULL),
(197, '2024-06-26 07:55:49', '2024-07-26 03:25:56', NULL, 'K_000101-0002', '000101', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-06-26', '12000', 'K_000101-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-07-17', NULL, NULL),
(198, '2024-06-27 08:35:05', '2024-06-27 08:39:59', NULL, 'K_000055-0003', '000055', NULL, NULL, '1', '2024-06-27', NULL, 'cyclic', '【LINEクーポン】ハイドラ＋パック', '2024-06-27', '6000', 'K_000055-0003', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-27', NULL, 'SF_002', '2024-06-27', NULL, NULL),
(200, '2024-06-28 08:32:30', '2024-06-28 08:36:12', NULL, 'K_000102-0001', '000102', NULL, NULL, '1', '2024-06-28', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-06-28', '4400', 'K_000102-0001', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-28', NULL, 'SF_002', '2024-06-28', NULL, NULL),
(202, '2024-06-29 04:57:28', '2024-06-29 04:57:55', NULL, 'K_000072-0002', '000072', NULL, NULL, '1', '2024-06-29', NULL, 'cyclic', '【インスタクーポン】ハイドラ＋フォト', '2024-06-29', '5000', 'K_000072-0002', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-29', NULL, 'SF_002', '2024-06-29', NULL, NULL),
(204, '2024-06-29 07:13:11', '2024-06-29 07:13:28', NULL, 'K_000103-0001', '000103', NULL, NULL, '1', '2024-06-29', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-06-29', '3600', 'K_000103-0001', 'NaN', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-06-29', NULL, 'SF_002', '2024-06-29', NULL, NULL),
(205, '2024-06-29 09:47:42', '2024-06-29 09:48:00', NULL, 'K_000104-0001', '000104', NULL, NULL, '1', '2024-06-29', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-06-29', '6000', 'K_000104-0001', '6000', '現金', '1', '2024-06-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-06-29', NULL, NULL),
(206, '2024-06-29 10:00:21', '2024-10-31 01:28:10', NULL, 'K_000104-0002', '000104', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-06-29', '16000', 'K_000104-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-10-12', '2024-10-31', NULL),
(207, '2024-07-03 03:06:36', '2024-07-03 04:00:32', NULL, 'K_000043-0003', '000043', NULL, NULL, '1', '2024-07-03', NULL, 'cyclic', '脂肪冷却', '2024-07-03', '4000', 'K_000043-0003', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-03', NULL, 'SF_002', '2024-07-03', NULL, NULL),
(210, '2024-07-05 06:56:11', '2024-07-06 05:57:22', NULL, 'K_000053-0003', '000053', NULL, NULL, '1', '2024-07-05', NULL, 'cyclic', '【トライアル】全身脱毛(顔・VIO込)', '2024-07-05', '1000', 'K_000053-0003', '1000', '現金', '1', '2024-07-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-06', NULL, NULL),
(211, '2024-07-05 10:45:33', '2024-07-05 10:45:57', NULL, 'K_000105-0001', '000105', NULL, NULL, '1', '2024-07-05', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-05', '6300', 'K_000105-0001', '6300', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-05', NULL, 'SF_002', '2024-07-05', NULL, NULL),
(212, '2024-07-07 03:09:47', '2024-07-07 03:10:07', NULL, 'K_000106-0001', '000106', NULL, NULL, '1', '2024-07-07', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-07-07', '4900', 'K_000106-0001', '4900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-07', NULL, 'SF_002', '2024-07-07', NULL, NULL),
(213, '2024-07-07 11:07:49', '2024-07-07 11:08:29', NULL, 'K_000107-0001', '000107', NULL, NULL, '1', '2024-07-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-07', '1000', 'K_000107-0001', '1000', '現金', '1', '2024-07-07', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-07', NULL, NULL),
(214, '2024-07-08 04:39:30', '2024-07-08 04:39:50', NULL, 'K_000108-0001', '000108', NULL, NULL, '1', '2024-07-08', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-07-08', '6600', 'K_000108-0001', '6600', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-08', NULL, 'SF_002', '2024-07-08', NULL, NULL),
(215, '2024-07-08 06:03:28', '2024-07-08 06:03:46', NULL, 'K_000109-0001', '000109', NULL, NULL, '1', '2024-07-08', NULL, 'cyclic', 'フォトフェイシャル', '2024-07-08', '4800', 'K_000109-0001', '4800', '現金', '1', '2024-07-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-08', NULL, NULL),
(216, '2024-07-10 05:29:05', '2024-07-10 05:29:20', NULL, 'K_000110-0001', '000110', NULL, NULL, '1', '2024-07-10', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-10', '6500', 'K_000110-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-10', NULL, 'SF_002', '2024-07-10', NULL, NULL),
(217, '2024-07-10 07:07:30', '2024-07-10 07:07:50', NULL, 'K_000111-0001', '000111', NULL, NULL, '1', '2024-07-10', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-10', '6600', 'K_000111-0001', '6600', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-10', NULL, 'SF_002', '2024-07-10', NULL, NULL),
(218, '2024-07-11 01:33:41', '2025-02-06 08:34:14', NULL, 'K_000055-0004', '000055', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】ハイドラ＋プラズマ＋パック', '2024-07-11', '9000', 'K_000055-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-01-09', NULL, NULL),
(220, '2024-07-11 05:22:41', '2024-07-11 05:23:01', NULL, 'K_000112-0001', '000112', NULL, NULL, '1', '2024-07-11', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-07-11', '5000', 'K_000112-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-11', NULL, 'SF_002', '2024-07-11', NULL, NULL),
(221, '2024-07-14 03:39:13', '2024-07-14 03:39:28', NULL, 'K_000113-0001', '000113', NULL, NULL, '1', '2024-07-14', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-14', '4500', 'K_000113-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-14', NULL, 'SF_002', '2024-07-14', NULL, NULL),
(222, '2024-07-14 05:11:33', '2024-07-14 05:11:49', NULL, 'K_000114-0001', '000114', NULL, NULL, '1', '2024-07-14', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-14', '6500', 'K_000114-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-14', NULL, 'SF_002', '2024-07-14', NULL, NULL),
(223, '2024-07-14 08:58:10', '2024-08-18 08:49:51', NULL, 'K_000049-0005', '000049', NULL, NULL, '1', '2024-07-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-14', '1000', 'K_000049-0005', '1000', '現金', '1', '2024-07-14', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-14', NULL, NULL);
INSERT INTO `contracts` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_keiyaku`, `serial_user`, `serial_staff`, `course`, `treatments_num`, `keiyaku_kikan_start`, `keiyaku_kikan_end`, `keiyaku_type`, `keiyaku_name`, `keiyaku_bi`, `keiyaku_kingaku`, `keiyaku_num`, `keiyaku_kingaku_total`, `how_to_pay`, `how_many_pay_genkin`, `date_first_pay_genkin`, `date_second_pay_genkin`, `amount_first_pay_cash`, `amount_second_pay_cash`, `card_company`, `how_many_pay_card`, `date_pay_card`, `tantosya`, `serial_tantosya`, `date_latest_visit`, `cancel`, `remarks`) VALUES
(224, '2024-07-17 04:09:53', '2025-04-30 07:11:01', NULL, 'K_000076-0004', '000076', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】ハイドラ＋プラズマ＋パック', '2024-07-24', '10000', 'K_000076-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-06', '2025-04-30', NULL),
(225, '2024-07-18 03:00:39', '2024-07-18 03:14:35', NULL, 'K_000069-0003', '000069', NULL, NULL, '1', '2024-07-18', NULL, 'cyclic', 'ハイドラ＋バブルパック', '2024-07-18', '6000', 'K_000069-0003', '6000', '現金', '1', '2024-07-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-18', NULL, NULL),
(226, '2024-07-18 09:39:45', '2024-07-18 09:40:32', NULL, 'K_000003-0004', '000003', NULL, NULL, '1', '2024-07-18', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-18', '1000', 'K_000003-0004', '1000', '現金', '1', '2024-07-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-18', NULL, NULL),
(227, '2024-07-18 11:59:38', '2024-09-06 06:18:10', NULL, 'K_000031-0006', '000031', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-18', '4000', 'K_000031-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', '2024-09-06', NULL),
(228, '2024-07-18 12:01:56', '2024-07-18 12:02:24', NULL, 'K_000031-0007', '000031', NULL, NULL, '1', '2024-07-18', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-18', '1000', 'K_000031-0007', '1000', '現金', '1', '2024-07-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-18', NULL, NULL),
(229, '2024-07-19 09:38:07', '2025-02-07 02:57:09', NULL, 'K_000056-0004', '000056', NULL, NULL, '1', '2024-07-19', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-19', '1000', 'K_000056-0004', '1000', '現金', '1', '2024-07-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-19', NULL, NULL),
(230, '2024-07-20 01:40:28', '2025-03-26 04:14:44', NULL, 'K_000114-0002', '000114', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-21', '15000', 'K_000114-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-23', '2025-03-26', NULL),
(231, '2024-07-20 06:46:33', '2024-07-20 06:47:11', NULL, 'K_000115-0001', '000115', NULL, NULL, '1', '2024-07-20', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-20', '6000', 'K_000115-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-20', NULL, 'SF_002', '2024-07-20', NULL, NULL),
(233, '2024-07-20 06:47:35', '2024-07-20 06:47:47', NULL, 'K_000115-0002', '000115', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-07-20', '12000', 'K_000115-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(234, '2024-07-20 08:48:23', '2024-08-17 03:19:41', NULL, 'K_000116-0001', '000116', NULL, NULL, '6', '2024-07-20', NULL, 'cyclic', '【モニター】ハイドラ＋プラズマ＋パック', '2024-07-20', '33000', 'K_000116-0001', '33000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-20', NULL, 'SF_002', '2024-08-17', NULL, NULL),
(236, '2024-07-21 05:49:24', '2024-07-21 05:51:43', NULL, 'K_000117-0001', '000117', NULL, NULL, '1', '2024-07-21', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-21', '3000', 'K_000117-0001', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-21', NULL, 'SF_003', '2024-07-21', NULL, NULL),
(237, '2024-07-21 11:16:18', '2024-07-21 11:16:34', NULL, 'K_000118-0001', '000118', NULL, NULL, '1', '2024-07-21', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-07-21', '4500', 'K_000118-0001', '4500', '現金', '1', '2024-07-21', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-21', NULL, NULL),
(238, '2024-07-24 05:09:10', '2024-07-24 05:09:25', NULL, 'K_000071-0003', '000071', NULL, NULL, '1', '2024-07-24', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-07-24', '5000', 'K_000071-0003', '5000', '現金', '1', '2024-07-24', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-24', NULL, NULL),
(239, '2024-07-24 06:44:23', '2024-07-24 06:45:13', NULL, 'K_000119-0001', '000119', NULL, NULL, '1', '2024-07-24', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-24', '6500', 'K_000119-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-24', NULL, 'SF_002', '2024-07-24', NULL, NULL),
(243, '2024-07-26 03:54:50', '2024-07-26 03:55:06', NULL, 'K_000120-0001', '000120', NULL, NULL, '1', '2024-07-26', NULL, 'cyclic', 'フォトフェイシャル', '2024-07-26', '5000', 'K_000120-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-26', NULL, 'SF_002', '2024-07-26', NULL, NULL),
(244, '2024-07-27 06:08:04', '2024-07-27 06:08:40', NULL, 'K_000121-0001', '000121', NULL, NULL, '1', '2024-07-27', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-27', '5600', 'K_000121-0001', '5600', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-27', NULL, 'SF_002', '2024-07-27', NULL, NULL),
(246, '2024-07-27 06:09:39', '2025-02-27 03:48:35', NULL, 'K_000121-0002', '000121', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-27', '15000', 'K_000121-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-15', NULL, NULL),
(250, '2024-07-27 08:13:06', '2025-05-02 03:57:20', NULL, 'K_000040-0004', '000040', NULL, NULL, '1', '2024-07-27', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-27', '1000', 'K_000040-0004', '1000', '現金', '1', '2024-07-27', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-07-27', NULL, NULL),
(251, '2024-07-27 10:13:45', '2024-07-27 10:14:23', NULL, 'K_000122-0001', '000122', NULL, NULL, '1', '2024-07-27', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-27', '6500', 'K_000122-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-27', NULL, 'SF_002', '2024-07-27', NULL, NULL),
(253, '2024-07-28 03:28:02', '2024-07-28 03:28:17', NULL, 'K_000123-0001', '000123', NULL, NULL, '1', '2024-07-28', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-07-28', '7500', 'K_000123-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-28', NULL, 'SF_002', '2024-07-28', NULL, NULL),
(254, '2024-07-28 08:01:56', '2024-07-28 08:02:15', NULL, 'K_000049-0006', '000049', NULL, NULL, '1', '2024-07-28', NULL, 'cyclic', 'キャピテーション', '2024-07-28', '5000', 'K_000049-0006', '5000', '現金', '1', '2024-07-28', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-28', NULL, NULL),
(255, '2024-07-29 04:23:19', '2024-07-29 04:23:34', NULL, 'K_000124-0001', '000124', NULL, NULL, '1', '2024-07-29', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-07-29', '1000', 'K_000124-0001', '1000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-29', NULL, 'SF_002', '2024-07-29', NULL, NULL),
(256, '2024-07-29 04:24:11', '2024-07-29 04:24:26', NULL, 'K_000043-0004', '000043', NULL, NULL, '1', '2024-07-29', NULL, 'cyclic', '脂肪冷却', '2024-07-29', '4000', 'K_000043-0004', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-29', NULL, 'SF_002', '2024-07-29', NULL, NULL),
(257, '2024-07-29 06:58:22', '2024-07-29 06:58:45', NULL, 'K_000125-0001', '000125', NULL, NULL, '1', '2024-07-29', NULL, 'cyclic', '脂肪冷却', '2024-07-29', '4700', 'K_000125-0001', '4700', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-07-29', NULL, 'SF_002', '2024-07-29', NULL, NULL),
(258, '2024-07-29 06:59:28', '2024-09-05 01:55:51', NULL, 'K_000125-0002', '000125', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却＋美白パック', '2024-07-29', '15300', 'K_000125-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-09-05', NULL, NULL),
(259, '2024-07-29 09:19:25', '2024-07-30 04:29:57', NULL, 'K_000126-0001', '000126', NULL, NULL, '1', '2024-07-29', NULL, 'cyclic', '脂肪冷却＋ハイドラ', '2024-07-29', '9000', 'K_000126-0001', '9000', '現金', '1', '2024-07-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-29', NULL, NULL),
(260, '2024-07-29 09:20:15', '2024-09-08 08:56:12', NULL, 'K_000126-0002', '000126', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-07-29', '15000', 'K_000126-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-08-19', '2024-09-08', NULL),
(261, '2024-07-31 04:16:14', '2024-07-31 04:31:15', NULL, 'K_000022-0005', '000022', NULL, NULL, '1', '2024-07-31', NULL, 'cyclic', 'リポレーザーお試し', '2024-07-31', '1000', 'K_000022-0005', '1000', '現金', '1', '2024-07-31', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-07-31', NULL, NULL),
(262, '2024-08-01 10:07:05', '2024-08-01 10:07:23', NULL, 'K_000118-0002', '000118', NULL, NULL, '1', '2024-08-01', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-01', '1000', 'K_000118-0002', '1000', '現金', '1', '2024-08-01', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-01', NULL, NULL),
(263, '2024-08-01 10:07:47', '2024-11-27 10:35:27', NULL, 'K_000118-0003', '000118', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-08-01', '12000', 'K_000118-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-11-27', '2024-11-27', NULL),
(264, '2024-08-01 10:08:52', '2025-03-03 05:56:43', NULL, 'K_000118-0004', '000118', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】ハイドラ＋プラズマ＋パック', '2024-08-01', '10000', 'K_000118-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-01-15', '2025-01-15', NULL),
(265, '2024-08-02 07:40:46', '2025-03-01 04:25:01', NULL, 'K_000053-0004', '000053', NULL, NULL, NULL, '2024-09-13', NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-08-02', '8000', 'K_000053-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-21', NULL, NULL),
(267, '2024-08-03 03:18:16', '2024-08-03 03:18:33', NULL, 'K_000127-0001', '000127', NULL, NULL, '1', '2024-08-03', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-03', '6000', 'K_000127-0001', '6000', '現金', '1', '2024-08-03', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-03', NULL, NULL),
(268, '2024-08-03 03:18:58', '2025-02-19 10:46:16', NULL, 'K_000127-0002', '000127', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-08-03', '12000', 'K_000127-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-19', NULL, NULL),
(269, '2024-08-03 05:22:22', '2024-08-03 05:22:48', NULL, 'K_000128-0001', '000128', NULL, NULL, '1', '2024-08-03', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-03', '6500', 'K_000128-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-03', NULL, 'SF_002', '2024-08-03', NULL, NULL),
(270, '2024-08-03 07:05:32', '2024-08-03 07:06:06', NULL, 'K_000129-0001', '000129', NULL, NULL, '1', '2024-08-03', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-03', '6200', 'K_000129-0001', '6200', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-03', NULL, 'SF_002', '2024-08-03', NULL, NULL),
(272, '2024-08-05 02:51:09', '2024-08-05 02:51:25', NULL, 'K_000130-0001', '000130', NULL, NULL, '1', '2024-08-05', NULL, 'cyclic', '脂肪冷却', '2024-08-05', '5400', 'K_000130-0001', '5400', '現金', '1', '2024-08-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-05', NULL, NULL),
(273, '2024-08-05 07:11:36', '2024-08-05 07:11:50', NULL, 'K_000131-0001', '000131', NULL, NULL, '1', '2024-08-05', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-08-05', '8000', 'K_000131-0001', '8000', '現金', '1', '2024-08-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-05', NULL, NULL),
(274, '2024-08-07 05:07:22', '2024-08-07 05:13:22', NULL, 'K_000112-0002', '000112', NULL, NULL, '1', '2024-08-07', NULL, 'cyclic', 'ハイドラ＋脂肪冷却', '2024-08-07', '8000', 'K_000112-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-07', NULL, 'SF_002', '2024-08-07', NULL, NULL),
(275, '2024-08-07 05:14:10', '2025-05-23 02:06:56', NULL, 'K_000112-0003', '000112', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラ＋脂肪冷却', '2024-08-07', '24000', 'K_000112-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-26', NULL, NULL),
(276, '2024-08-09 04:59:45', '2024-08-09 05:08:40', NULL, 'K_000069-0004', '000069', NULL, NULL, '1', '2024-08-09', NULL, 'cyclic', 'キャピテーション', '2024-08-09', '5000', 'K_000069-0004', '5000', '現金', '1', '2024-08-09', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-09', NULL, NULL),
(277, '2024-08-09 07:46:30', '2024-08-09 07:52:31', NULL, 'K_000122-0002', '000122', NULL, NULL, '1', '2024-08-09', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-08-09', '8000', 'K_000122-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-09', NULL, 'SF_002', '2024-08-09', NULL, NULL),
(279, '2024-08-09 09:49:46', '2024-08-09 09:50:01', NULL, 'K_000132-0001', '000132', NULL, NULL, '1', '2024-08-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-09', '7000', 'K_000132-0001', '7000', '現金', '1', '2024-08-09', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-09', NULL, NULL),
(280, '2024-08-11 09:17:16', '2024-08-11 09:17:31', NULL, 'K_000133-0001', '000133', NULL, NULL, '1', '2024-08-11', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-08-11', '7500', 'K_000133-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-11', NULL, 'SF_002', '2024-08-11', NULL, NULL),
(281, '2024-08-12 04:11:58', '2024-08-12 04:12:16', NULL, 'K_000134-0001', '000134', NULL, NULL, '1', '2024-08-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-08-12', '8000', 'K_000134-0001', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-12', NULL, 'SF_002', '2024-08-12', NULL, NULL),
(282, '2024-08-18 03:23:12', '2024-08-18 03:23:27', NULL, 'K_000135-0001', '000135', NULL, NULL, '1', '2024-08-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-18', '6500', 'K_000135-0001', '6500', '現金', '1', '2024-08-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-18', NULL, NULL),
(283, '2024-08-18 03:25:56', '2024-10-19 02:01:50', NULL, 'K_000135-0002', '000135', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル', '2024-08-18', '14000', 'K_000135-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-10-17', '2024-10-19', NULL),
(284, '2024-08-18 05:43:54', '2024-08-18 05:44:16', NULL, 'K_000136-0001', '000136', NULL, NULL, '1', '2024-08-18', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-18', '6000', 'K_000136-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-18', NULL, 'SF_002', '2024-08-18', NULL, NULL),
(285, '2024-08-18 07:04:36', '2025-02-23 06:57:17', NULL, 'K_000049-0007', '000049', NULL, NULL, NULL, NULL, NULL, 'subscription', 'VIO脱毛', '2024-08-18', '7000', 'K_000049-0007', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-23', NULL, NULL),
(287, '2024-08-18 08:56:48', '2024-08-18 09:20:43', NULL, 'K_000049-0008', '000049', NULL, NULL, '1', '2024-08-18', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-18', '12000', 'K_000049-0008', '12000', '現金', '1', '2024-08-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-08-18', NULL, NULL),
(288, '2024-08-19 02:26:15', '2024-08-19 04:16:47', NULL, 'K_000043-0005', '000043', NULL, NULL, '1', '2024-08-19', NULL, 'cyclic', '脂肪冷却', '2024-08-19', '4000', 'K_000043-0005', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-19', NULL, 'SF_002', '2024-08-19', NULL, NULL),
(289, '2024-08-19 02:28:58', '2024-08-19 04:17:05', NULL, 'K_000124-0002', '000124', NULL, NULL, '1', '2024-08-19', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-19', '6000', 'K_000124-0002', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-19', NULL, 'SF_002', '2024-08-19', NULL, NULL),
(290, '2024-08-21 06:19:21', '2024-08-21 06:20:24', NULL, 'K_000083-0002', '000083', NULL, NULL, '1', '2024-08-21', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-21', '8300', 'K_000083-0002', '1000', '現金', '1', '2024-08-21', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-21', NULL, NULL),
(292, '2024-08-21 09:57:32', '2024-08-21 09:57:58', NULL, 'K_000010-0003', '000010', NULL, NULL, '1', '2024-08-21', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-08-21', '5000', 'K_000010-0003', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-21', NULL, 'SF_002', '2024-08-21', NULL, NULL),
(294, '2024-08-22 09:35:20', '2024-08-22 09:35:36', NULL, 'K_000137-0001', '000137', NULL, NULL, '1', '2024-08-22', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-22', '1000', 'K_000137-0001', '1000', '現金', '1', '2024-08-22', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_003', '2024-08-22', NULL, NULL),
(295, '2024-08-23 03:07:28', '2024-08-23 03:07:44', NULL, 'K_000106-0002', '000106', NULL, NULL, '1', '2024-08-23', NULL, 'cyclic', '【LINEクーポン】脂肪冷却＋ハイドラ', '2024-08-23', '8000', 'K_000106-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-23', NULL, 'SF_002', '2024-08-23', NULL, NULL),
(296, '2024-08-23 08:07:51', '2024-08-23 08:08:05', NULL, 'K_000030-0002', '000030', NULL, NULL, '1', '2024-08-23', NULL, 'cyclic', '【LINEクーポン】脂肪冷却＋ハイドラ', '2024-08-23', '8000', 'K_000030-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-23', NULL, 'SF_002', '2024-08-23', NULL, NULL),
(297, '2024-08-23 09:15:21', '2024-08-23 09:15:35', NULL, 'K_000071-0004', '000071', NULL, NULL, '1', '2024-08-23', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-23', '1000', 'K_000071-0004', '1000', '現金', '1', '2024-08-23', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-23', NULL, NULL),
(298, '2024-08-24 03:27:23', '2024-08-24 03:27:38', NULL, 'K_000138-0001', '000138', NULL, NULL, '1', '2024-08-24', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-24', '5000', 'K_000138-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-24', NULL, 'SF_002', '2024-08-24', NULL, NULL),
(299, '2024-08-25 09:40:50', '2024-08-25 09:41:06', NULL, 'K_000139-0001', '000139', NULL, NULL, '1', '2024-08-25', NULL, 'cyclic', '脂肪冷却＋ハイドラフェイシャル', '2024-08-25', '9000', 'K_000139-0001', '9000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-25', NULL, 'SF_002', '2024-08-25', NULL, NULL),
(300, '2024-08-26 03:30:49', '2024-08-26 03:31:12', NULL, 'K_000140-0001', '000140', NULL, NULL, '1', '2024-08-26', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-26', '6300', 'K_000140-0001', '6300', '現金', '1', '2024-08-26', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-26', NULL, NULL),
(301, '2024-08-26 04:29:55', '2025-03-03 06:00:44', NULL, 'K_000120-0002', '000120', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】ハイドラ＋プラズマ＋パック', '2024-08-26', '10000', 'K_000120-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-01-26', '2025-01-26', NULL),
(302, '2024-08-26 10:12:21', '2024-08-26 10:28:37', NULL, 'K_000141-0001', '000141', NULL, NULL, '1', '2024-08-26', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-26', '1000', 'K_000141-0001', '1000', '現金', '1', '2024-08-26', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-26', NULL, NULL),
(303, '2024-08-28 03:55:45', '2024-08-28 03:56:00', NULL, 'K_000142-0001', '000142', NULL, NULL, '1', '2024-08-28', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-08-28', '5500', 'K_000142-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-08-28', NULL, 'SF_002', '2024-08-28', NULL, NULL),
(304, '2024-08-28 03:56:19', '2025-03-03 03:14:36', NULL, 'K_000142-0002', '000142', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-08-28', '12000', 'K_000142-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-28', NULL, NULL),
(305, '2024-08-29 03:29:40', '2024-08-29 03:30:01', NULL, 'K_000143-0001', '000143', NULL, NULL, '1', '2024-08-29', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-29', '6500', 'K_000143-0001', '6500', '現金', '1', '2024-08-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-29', NULL, NULL),
(306, '2024-08-31 06:39:58', '2024-08-31 06:40:16', NULL, 'K_000144-0001', '000144', NULL, NULL, '1', '2024-08-31', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-31', '0', 'K_000144-0001', '0', '現金', '1', '2024-08-31', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-31', NULL, NULL),
(307, '2024-08-31 09:44:37', '2024-08-31 09:44:54', NULL, 'K_000145-0001', '000145', NULL, NULL, '1', '2024-08-31', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-08-31', '6500', 'K_000145-0001', '6500', '現金', '1', '2024-08-31', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-08-31', NULL, NULL),
(308, '2024-09-01 05:34:08', '2024-09-01 05:34:23', NULL, 'K_000146-0001', '000146', NULL, NULL, '1', '2024-09-01', NULL, 'cyclic', 'ハイドラ', '2024-09-01', '7300', 'K_000146-0001', '7300', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-01', NULL, 'SF_002', '2024-09-01', NULL, NULL),
(309, '2024-09-01 07:08:47', '2024-09-01 07:09:05', NULL, 'K_000147-0001', '000147', NULL, NULL, '1', '2024-09-01', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-09-01', '3500', 'K_000147-0001', '3500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-01', NULL, 'SF_002', '2024-09-01', NULL, NULL),
(310, '2024-09-04 03:23:27', '2024-09-04 03:24:01', NULL, 'K_000111-0002', '000111', NULL, NULL, '1', '2024-09-04', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-09-04', '8000', 'K_000111-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-04', NULL, 'SF_002', '2024-09-04', NULL, NULL),
(311, '2024-09-04 08:28:55', '2024-09-04 08:29:26', NULL, 'K_000148-0001', '000148', NULL, NULL, '1', '2024-09-04', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-09-04', '6000', 'K_000148-0001', '6000', '現金', '1', '2024-09-04', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-09-04', NULL, NULL),
(312, '2024-09-06 08:21:09', '2025-03-03 05:58:04', NULL, 'K_000122-0003', '000122', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】ハイドラ＋プラズマ＋パック', '2024-09-06', '10000', 'K_000122-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-26', '2025-02-26', NULL),
(313, '2024-09-07 03:48:20', '2024-09-07 03:49:07', NULL, 'K_000071-0005', '000071', NULL, NULL, '1', '2024-09-07', NULL, 'cyclic', '【LINEクーポン】脂肪冷却', '2024-09-07', '6000', 'K_000071-0005', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-07', NULL, 'SF_002', '2024-09-07', NULL, NULL),
(314, '2024-09-07 06:15:03', '2024-09-07 06:15:32', NULL, 'K_000149-0001', '000149', NULL, NULL, '1', '2024-09-07', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-09-07', '6500', 'K_000149-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-07', NULL, 'SF_002', '2024-09-07', NULL, NULL),
(315, '2024-09-07 08:32:32', '2024-09-07 08:33:17', NULL, 'K_000117-0002', '000117', NULL, NULL, '1', '2024-09-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-09-07', '6000', 'K_000117-0002', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-07', NULL, 'SF_002', '2024-09-07', NULL, NULL),
(317, '2024-09-09 04:04:47', '2024-09-09 04:05:09', NULL, 'K_000043-0006', '000043', NULL, NULL, '1', '2024-09-09', NULL, 'cyclic', '脂肪冷却', '2024-09-09', '4000', 'K_000043-0006', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-09', NULL, 'SF_002', '2024-09-09', NULL, NULL),
(318, '2024-09-09 04:06:42', '2024-09-09 04:07:06', NULL, 'K_000124-0003', '000124', NULL, NULL, '1', '2024-09-09', NULL, 'cyclic', '全身脱毛（顔）', '2024-09-09', '5000', 'K_000124-0003', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-09', NULL, 'SF_002', '2024-09-09', NULL, NULL),
(319, '2024-09-13 06:24:20', '2024-09-13 06:32:15', NULL, 'K_000043-0007', '000043', NULL, NULL, '1', '2024-09-13', NULL, 'cyclic', 'リファ商品', '2024-09-13', '15818', 'K_000043-0007', '15818', '現金', '1', '2024-09-13', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-09-13', NULL, NULL),
(326, '2024-09-15 03:53:08', '2024-09-15 03:55:05', NULL, 'K_000139-0002', '000139', NULL, NULL, '1', '2024-09-15', NULL, 'cyclic', '脂肪冷却', '2024-09-15', '16000', 'K_000139-0002', '16000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-15', NULL, 'SF_002', '2024-09-15', NULL, NULL),
(327, '2024-09-15 03:56:04', '2024-12-12 09:39:58', NULL, 'K_000139-0003', '000139', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-09-15', '16000', 'K_000139-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-12-09', '2024-12-12', NULL),
(328, '2024-09-15 08:37:18', '2024-09-15 08:37:44', NULL, 'K_000035-0002', '000035', NULL, NULL, '1', '2024-09-15', NULL, 'cyclic', 'フォトフェイシャル', '2024-09-15', '13000', 'K_000035-0002', '13000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-15', NULL, 'SF_002', '2024-09-15', NULL, NULL),
(329, '2024-09-20 10:12:02', '2024-09-20 10:13:24', NULL, 'K_000150-0001', '000150', NULL, NULL, '1', '2024-09-20', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-09-20', '7700', 'K_000150-0001', '7700', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-20', NULL, 'SF_002', '2024-09-20', NULL, NULL),
(330, '2024-09-21 04:56:07', '2024-09-21 05:30:16', NULL, 'K_000069-0005', '000069', NULL, NULL, '1', '2024-09-21', NULL, 'cyclic', '【LINEクーポン】ハイドラ＋脂肪冷却', '2024-09-21', '8000', 'K_000069-0005', '8000', '現金', '1', '2024-09-21', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-09-21', NULL, NULL),
(332, '2024-09-22 03:31:02', '2024-09-22 03:31:16', NULL, 'K_000151-0001', '000151', NULL, NULL, '1', '2024-09-22', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-09-22', '6500', 'K_000151-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-22', NULL, 'SF_002', '2024-09-22', NULL, NULL),
(333, '2024-09-22 03:45:54', '2024-12-04 08:28:05', NULL, 'K_000151-0002', '000151', NULL, NULL, NULL, NULL, NULL, 'subscription', '【9月キャンペーン】ハイドラ＋フォト＋炭酸パック', '2024-09-22', '16000', 'K_000151-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-11-16', '2024-12-04', NULL),
(334, '2024-09-26 03:29:53', '2024-09-26 03:30:08', NULL, 'K_000108-0002', '000108', NULL, NULL, '1', '2024-09-26', NULL, 'cyclic', '脂肪冷却', '2024-09-26', '17000', 'K_000108-0002', '17000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-26', NULL, 'SF_002', '2024-09-26', NULL, NULL),
(335, '2024-09-29 07:30:00', '2024-09-29 07:30:16', NULL, 'K_000043-0008', '000043', NULL, NULL, '1', '2024-09-27', NULL, 'cyclic', 'リファ商品', '2024-09-29', '11700', 'K_000043-0008', '11700', '現金', '1', '2024-09-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-09-27', NULL, NULL),
(336, '2024-09-29 10:37:54', '2024-12-07 08:53:16', NULL, 'K_000152-0001', '000152', NULL, NULL, '5', '2024-09-29', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-09-29', '25000', 'K_000152-0001', '125000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-29', NULL, 'SF_002', '2024-12-07', NULL, NULL),
(337, '2024-09-30 02:21:34', '2024-09-30 06:21:51', NULL, 'K_000043-0009', '000043', NULL, NULL, '1', '2024-09-30', NULL, 'cyclic', '脂肪冷却', '2024-09-30', '4000', 'K_000043-0009', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-30', NULL, 'SF_002', '2024-09-30', NULL, NULL),
(338, '2024-09-30 02:22:27', '2024-09-30 04:31:55', NULL, 'K_000124-0004', '000124', NULL, NULL, '1', '2024-09-30', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-09-30', '6000', 'K_000124-0004', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-09-30', NULL, 'SF_002', '2024-09-30', NULL, NULL),
(339, '2024-10-03 03:19:59', '2024-10-03 03:20:23', NULL, 'K_000153-0001', '000153', NULL, NULL, '1', '2024-10-03', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2024-10-03', '8500', 'K_000153-0001', '8500', '現金', '1', '2024-10-03', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-03', NULL, NULL),
(340, '2024-10-05 05:29:12', '2024-10-05 05:29:30', NULL, 'K_000154-0001', '000154', NULL, NULL, '1', '2024-10-05', NULL, 'cyclic', '脂肪冷却', '2024-10-05', '5000', 'K_000154-0001', '5000', '現金', '1', '2024-10-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-05', NULL, NULL),
(341, '2024-10-12 06:38:58', '2024-10-12 06:39:34', NULL, 'K_000155-0001', '000155', NULL, NULL, '1', '2024-10-12', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-10-12', '8000', 'K_000155-0001', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-12', NULL, 'SF_002', '2024-10-12', NULL, NULL),
(343, '2024-10-12 08:49:56', '2024-10-12 08:50:13', NULL, 'K_000156-0001', '000156', NULL, NULL, '1', '2024-10-12', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-10-12', '6500', 'K_000156-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-12', NULL, 'SF_002', '2024-10-12', NULL, NULL),
(344, '2024-10-13 07:08:52', '2024-10-13 07:09:07', NULL, 'K_000157-0001', '000157', NULL, NULL, '1', '2024-10-13', NULL, 'cyclic', 'ハイドラフェイシャル', '2024-10-13', '4800', 'K_000157-0001', '4800', '現金', '1', '2024-10-13', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-13', NULL, NULL),
(345, '2024-10-13 09:30:58', '2024-10-13 09:31:13', NULL, 'K_000158-0001', '000158', NULL, NULL, '1', '2024-10-13', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-10-13', '6000', 'K_000158-0001', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-13', NULL, 'SF_002', '2024-10-13', NULL, NULL),
(346, '2024-10-14 09:26:33', '2024-10-14 09:27:02', NULL, 'K_000159-0001', '000159', NULL, NULL, '1', '2024-10-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-10-14', '6500', 'K_000159-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-14', NULL, 'SF_002', '2024-10-14', NULL, NULL),
(349, '2024-10-16 09:25:27', '2025-02-21 05:01:48', NULL, 'K_000160-0001', '000160', NULL, NULL, NULL, NULL, NULL, 'subscription', '電磁パルス', '2024-10-16', '0', 'K_000160-0001', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-21', NULL, NULL),
(350, '2024-10-18 03:06:01', '2024-10-18 03:06:16', NULL, 'K_000161-0001', '000161', NULL, NULL, '1', '2024-10-18', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-10-18', '5500', 'K_000161-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-18', NULL, 'SF_002', '2024-10-18', NULL, NULL),
(351, '2024-10-18 06:56:39', '2025-02-28 05:16:42', NULL, 'K_000127-0003', '000127', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】脂肪冷却（4部位）', '2024-10-28', '29000', 'K_000127-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-26', NULL, NULL),
(352, '2024-10-18 06:57:47', '2025-02-26 09:09:34', NULL, 'K_000153-0002', '000153', NULL, NULL, NULL, NULL, NULL, 'subscription', '【モニター】脂肪冷却（4部位）', '2024-10-21', '29000', 'K_000153-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-26', NULL, NULL),
(353, '2024-10-18 10:43:35', '2024-10-18 10:43:51', NULL, 'K_000162-0001', '000162', NULL, NULL, '1', '2024-10-18', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-10-18', '6500', 'K_000162-0001', '6500', '現金', '1', '2024-10-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-18', NULL, NULL),
(354, '2024-10-19 07:57:09', '2024-10-19 07:57:24', NULL, 'K_000032-0002', '000032', NULL, NULL, '1', '2024-10-19', NULL, 'cyclic', '【LINEクーポン】次世代EMS', '2024-10-19', '4000', 'K_000032-0002', '4000', '現金', '1', '2024-10-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-19', NULL, NULL),
(355, '2024-10-21 03:46:42', '2024-10-21 03:55:26', NULL, 'K_000163-0001', '000163', NULL, NULL, '1', '2024-10-21', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2024-10-21', '11000', 'K_000163-0001', '11000', '現金', '1', '2024-10-21', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-21', NULL, NULL),
(357, '2024-10-23 03:57:44', '2024-10-23 03:58:00', NULL, 'K_000032-0003', '000032', NULL, NULL, '1', '2024-10-23', NULL, 'cyclic', '【トライアル】脂肪冷却', '2024-10-23', '5000', 'K_000032-0003', '5000', '現金', '1', '2024-10-23', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-10-23', NULL, NULL),
(358, '2024-10-24 05:31:37', '2024-10-24 08:19:41', NULL, 'K_000043-0010', '000043', NULL, NULL, '1', '2024-10-24', NULL, 'cyclic', '次世代EMS', '2024-10-24', '4000', 'K_000043-0010', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-24', NULL, 'SF_002', '2024-10-24', NULL, NULL),
(359, '2024-10-24 05:33:10', '2024-10-24 08:20:04', NULL, 'K_000124-0005', '000124', NULL, NULL, '1', '2024-10-24', NULL, 'cyclic', '全身脱毛', '2024-10-24', '6000', 'K_000124-0005', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-10-24', NULL, 'SF_002', '2024-10-24', NULL, NULL),
(360, '2024-11-03 02:56:47', '2024-11-03 02:58:04', NULL, 'K_000164-0001', '000164', NULL, NULL, '1', '2024-11-03', NULL, 'cyclic', 'うなじ脱毛', '2024-11-03', '3000', 'K_000164-0001', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-03', NULL, 'SF_002', '2024-11-03', NULL, NULL),
(362, '2024-11-03 08:00:43', '2024-11-03 08:01:04', NULL, 'K_000038-0003', '000038', NULL, NULL, '1', '2024-11-03', NULL, 'cyclic', '【ポイント消化】フォトフェイシャル', '2024-11-03', '0', 'K_000038-0003', '0', '現金', '1', '2024-11-03', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-11-03', NULL, NULL),
(363, '2024-11-04 02:00:56', '2024-11-04 02:06:35', NULL, 'K_000040-0005', '000040', NULL, NULL, '1', '2024-11-04', NULL, 'cyclic', '【ポイント消化】脂肪冷却', '2024-11-04', '0', 'K_000040-0005', '0', '現金', '1', '2024-11-04', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-11-04', NULL, NULL),
(364, '2024-11-04 03:33:21', '2024-12-03 01:35:19', NULL, 'K_000040-0006', '000040', NULL, NULL, NULL, NULL, NULL, 'subscription', '電磁パルス', '2024-11-04', '13000', 'K_000040-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', '2024-12-03', NULL),
(365, '2024-11-06 01:57:47', '2024-11-06 03:28:19', NULL, 'K_000108-0003', '000108', NULL, NULL, '1', '2024-11-06', NULL, 'cyclic', '脂肪冷却', '2024-11-06', '16600', 'K_000108-0003', '17000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-06', NULL, 'SF_002', '2024-11-06', NULL, NULL),
(368, '2024-11-09 10:19:39', '2024-11-09 10:20:01', NULL, 'K_000165-0001', '000165', NULL, NULL, '1', '2024-11-09', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-11-09', '6500', 'K_000165-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-09', NULL, 'SF_002', '2024-11-09', NULL, NULL),
(369, '2024-11-13 03:23:49', '2024-11-13 03:34:58', NULL, 'K_000166-0001', '000166', NULL, NULL, '1', '2024-11-13', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-11-13', '7500', 'K_000166-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-13', NULL, 'SF_002', '2024-11-13', NULL, NULL),
(370, '2024-11-13 05:28:34', '2024-11-13 05:28:53', NULL, 'K_000167-0001', '000167', NULL, NULL, '1', '2024-11-13', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2024-11-13', '3000', 'K_000167-0001', '3000', '現金', '1', '2024-11-13', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-11-13', NULL, NULL),
(371, '2024-11-15 02:25:11', '2024-11-15 04:42:36', NULL, 'K_000124-0006', '000124', NULL, NULL, '1', '2024-11-15', NULL, 'cyclic', '全身脱毛（顔）', '2024-11-15', '5000', 'K_000124-0006', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-15', NULL, 'SF_002', '2024-11-15', NULL, NULL),
(373, '2024-11-15 02:26:41', '2024-11-15 04:44:13', NULL, 'K_000043-0011', '000043', NULL, NULL, '1', '2024-11-15', NULL, 'cyclic', '脂肪冷却', '2024-11-15', '4000', 'K_000043-0011', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-15', NULL, 'SF_002', '2024-11-15', NULL, NULL),
(374, '2024-11-16 03:06:35', '2024-11-16 03:06:50', NULL, 'K_000168-0001', '000168', NULL, NULL, '1', '2024-11-16', NULL, 'cyclic', 'フォトフェイシャル', '2024-11-16', '4900', 'K_000168-0001', '4900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-16', NULL, 'SF_002', '2024-11-16', NULL, NULL),
(375, '2024-11-17 06:08:04', '2024-11-17 06:08:19', NULL, 'K_000169-0001', '000169', NULL, NULL, '1', '2024-11-17', NULL, 'cyclic', '脂肪冷却', '2024-11-17', '5500', 'K_000169-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-17', NULL, 'SF_002', '2024-11-17', NULL, NULL),
(376, '2024-11-18 04:34:13', '2024-11-18 04:34:27', NULL, 'K_000170-0001', '000170', NULL, NULL, '1', '2024-11-18', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2024-11-18', '10500', 'K_000170-0001', '10500', '現金', '1', '2024-11-18', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-11-18', NULL, NULL),
(379, '2024-11-23 01:38:19', '2024-11-23 03:54:45', NULL, 'K_000024-0003', '000024', NULL, NULL, '1', '2024-11-23', NULL, 'cyclic', '髭脱毛', '2024-11-23', '5500', 'K_000024-0003', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-23', NULL, 'SF_002', '2024-11-23', NULL, NULL),
(380, '2024-11-25 08:13:40', '2024-12-02 04:00:32', NULL, 'K_000170-0002', '000170', NULL, NULL, NULL, NULL, NULL, 'subscription', '次世代EMS', '2024-11-30', '26000', 'K_000170-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2024-12-02', NULL, NULL),
(381, '2024-11-28 07:30:54', '2024-11-28 07:31:09', NULL, 'K_000171-0001', '000171', NULL, NULL, '1', '2024-11-28', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-11-28', '6500', 'K_000171-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-28', NULL, 'SF_002', '2024-11-28', NULL, NULL),
(382, '2024-11-29 05:15:37', '2024-11-29 05:32:21', NULL, 'K_000172-0001', '000172', NULL, NULL, '1', '2024-11-29', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-11-29', '5500', 'K_000172-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-11-29', NULL, 'SF_002', '2024-11-29', NULL, NULL),
(385, '2024-11-30 06:33:53', '2024-12-27 08:24:47', '2024-12-27 08:24:47', 'K_000170-0003', '000170', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却(3部位)', '2024-12-16', '38400', 'K_000170-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', NULL, NULL, NULL),
(388, '2024-12-04 01:55:15', '2024-12-04 03:31:55', NULL, 'K_000108-0004', '000108', NULL, NULL, '1', '2024-12-04', NULL, 'cyclic', '脂肪冷却', '2024-12-04', '17000', 'K_000108-0004', '17000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-04', NULL, 'SF_002', '2024-12-04', NULL, NULL),
(389, '2024-12-05 03:29:55', '2025-02-07 05:02:58', NULL, 'K_000056-0005', '000056', NULL, NULL, '1', '2025-02-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-02-07', '3000', 'K_000056-0005', '3000', '現金', '1', '2025-02-07', NULL, '3000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-02-07', NULL, NULL),
(390, '2024-12-05 05:25:53', '2024-12-05 06:56:47', NULL, 'K_000010-0004', '000010', NULL, NULL, '1', '2024-12-05', NULL, 'cyclic', '【ポイント消化】ハイドラフェイシャル', '2024-12-05', '0', 'K_000010-0004', '0', '現金', '1', '2024-12-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-12-05', NULL, NULL),
(391, '2024-12-07 03:22:47', '2024-12-07 03:23:08', NULL, 'K_000173-0001', '000173', NULL, NULL, '1', '2024-12-07', NULL, 'cyclic', 'キャピ＋脂肪冷却', '2024-12-07', '8000', 'K_000173-0001', '8000', '現金', '1', '2024-12-07', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-12-07', NULL, NULL),
(392, '2024-12-07 03:23:28', '2025-03-07 04:17:14', NULL, 'K_000173-0002', '000173', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-12-07', '12000', 'K_000173-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-27', NULL, NULL),
(393, '2024-12-08 03:46:16', '2024-12-08 03:46:31', NULL, 'K_000174-0001', '000174', NULL, NULL, '1', '2024-12-08', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2024-12-08', '10500', 'K_000174-0001', '10500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-08', NULL, 'SF_002', '2024-12-08', NULL, NULL),
(394, '2024-12-08 06:49:45', '2024-12-08 06:50:01', NULL, 'K_000175-0001', '000175', NULL, NULL, '1', '2024-12-08', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2024-12-08', '10400', 'K_000175-0001', '0', '現金', '1', '2024-12-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-12-08', NULL, NULL),
(395, '2024-12-08 06:51:58', '2024-12-25 04:32:34', NULL, 'K_000175-0002', '000175', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2024-12-08', '16000', 'K_000175-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', '2024-12-25', NULL),
(396, '2024-12-08 06:58:08', '2024-12-08 07:01:15', NULL, 'K_000175-0003', '000175', NULL, NULL, '1', '2024-12-08', NULL, 'cyclic', '発汗ドーム', '2024-12-08', '2000', 'K_000175-0003', '2000', '現金', '1', '2024-12-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(400, '2024-12-13 02:45:20', '2024-12-13 04:55:28', NULL, 'K_000043-0012', '000043', NULL, NULL, NULL, NULL, NULL, 'subscription', '発汗＋キャピ', '2024-12-13', '4000', 'K_000043-0012', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-12-13', NULL, NULL),
(401, '2024-12-13 02:46:15', '2024-12-13 04:20:07', NULL, 'K_000124-0007', '000124', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2024-12-13', '6000', 'K_000124-0007', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2024-12-13', NULL, NULL),
(402, '2024-12-14 08:02:10', '2024-12-14 08:02:25', NULL, 'K_000156-0002', '000156', NULL, NULL, '1', '2024-12-14', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-12-14', '8000', 'K_000156-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-14', NULL, 'SF_002', '2024-12-14', NULL, NULL),
(403, '2024-12-15 05:28:48', '2024-12-15 05:49:38', '2024-12-15 05:49:38', 'K_000176-0001', '000176', NULL, NULL, '1', '2024-12-15', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-12-15', '8000', 'K_000176-0001', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', NULL, NULL, NULL),
(404, '2024-12-15 05:28:53', '2024-12-15 05:29:11', NULL, 'K_000176-0002', '000176', NULL, NULL, '1', '2024-12-15', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2024-12-15', '8000', 'K_000176-0002', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-15', NULL, 'SF_002', '2024-12-15', NULL, NULL),
(405, '2024-12-16 03:16:18', '2024-12-16 03:22:32', NULL, 'K_000038-0004', '000038', NULL, NULL, '1', '2024-12-16', NULL, 'cyclic', '【LINEクーポン】毛穴洗浄＋ローズパック', '2024-12-16', '8000', 'K_000038-0004', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-16', NULL, 'SF_002', '2024-12-16', NULL, NULL),
(406, '2024-12-16 04:58:29', '2024-12-16 04:58:44', NULL, 'K_000177-0001', '000177', NULL, NULL, '1', '2024-12-16', NULL, 'cyclic', '【インスタ広告】脂肪冷却モニター', '2024-12-16', '5000', 'K_000177-0001', '5000', '現金', '1', '2024-12-16', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-12-16', NULL, NULL),
(407, '2024-12-20 02:31:08', '2025-02-22 03:28:52', NULL, 'K_000172-0002', '000172', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-12-20', '15000', 'K_000172-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-06', '2025-02-22', NULL),
(408, '2024-12-21 06:00:49', '2024-12-21 06:01:06', NULL, 'K_000178-0001', '000178', NULL, NULL, '1', '2024-12-21', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-12-21', '6500', 'K_000178-0001', '6500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-21', NULL, 'SF_002', '2024-12-21', NULL, NULL),
(409, '2024-12-22 04:22:17', '2024-12-22 06:10:41', NULL, 'K_000049-0009', '000049', NULL, NULL, '1', '2024-12-22', NULL, 'cyclic', '【LINEクーポン】毛穴洗浄＋ローズパック', '2024-12-22', '8000', 'K_000049-0009', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-22', NULL, 'SF_002', '2024-12-22', NULL, NULL),
(410, '2024-12-22 06:36:44', '2024-12-22 08:46:54', NULL, 'K_000024-0004', '000024', NULL, NULL, '1', '2024-12-22', NULL, 'cyclic', '髭脱毛', '2024-12-22', '7700', 'K_000024-0004', '7700', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-22', NULL, 'SF_002', '2024-12-22', NULL, NULL),
(411, '2024-12-23 03:50:14', '2024-12-23 03:50:51', NULL, 'K_000179-0001', '000179', NULL, NULL, '1', '2024-12-23', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2024-12-23', '7700', 'K_000179-0001', '7700', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-23', NULL, 'SF_002', '2024-12-23', NULL, NULL),
(413, '2024-12-28 01:57:16', '2024-12-28 03:24:57', NULL, 'K_000121-0003', '000121', NULL, NULL, '1', '2024-12-28', NULL, 'cyclic', 'ローズパック', '2024-12-28', '2000', 'K_000121-0003', '2000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2024-12-28', NULL, 'SF_002', '2024-12-28', NULL, NULL),
(417, '2024-12-29 05:37:50', '2024-12-29 05:38:08', NULL, 'K_000180-0001', '000180', NULL, NULL, '1', '2024-12-29', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2024-12-29', '0', 'K_000180-0001', '0', '現金', '1', '2024-12-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2024-12-29', NULL, NULL),
(418, '2025-01-03 05:46:42', '2025-03-03 03:13:54', NULL, 'K_000010-0005', '000010', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛', '2025-01-03', '12000', 'K_000010-0005', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-27', NULL, NULL),
(419, '2025-01-08 03:27:07', '2025-01-08 03:27:23', NULL, 'K_000142-0003', '000142', NULL, NULL, '1', '2025-01-08', NULL, 'cyclic', '【物販】美容液', '2025-01-08', '8140', 'K_000142-0003', '8140', '現金', '1', '2025-01-08', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-08', NULL, NULL),
(420, '2025-01-10 04:50:16', '2025-01-10 04:50:33', NULL, 'K_000167-0002', '000167', NULL, NULL, '1', '2025-01-10', NULL, 'cyclic', 'ハイドラ＋プラズマ', '2025-01-10', '8000', 'K_000167-0002', '8000', '現金', '1', '2025-01-10', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-10', NULL, NULL),
(422, '2025-01-12 05:33:53', '2025-06-08 01:59:00', NULL, 'K_000181-0001', '000181', NULL, NULL, '17', '2025-01-12', NULL, 'cyclic', '全身脱毛（顔・VIO込）【１年間通い放題コース】', '2025-01-12', '100000', 'K_000181-0001', '100000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-01-13', NULL, 'SF_002', '2025-06-08', NULL, NULL),
(423, '2025-01-12 10:37:46', '2025-01-12 10:38:02', NULL, 'K_000182-0001', '000182', NULL, NULL, '1', '2025-01-12', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2025-01-12', '11000', 'K_000182-0001', '11000', '現金', '1', '2025-01-12', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-12', NULL, NULL),
(425, '2025-01-15 08:25:46', '2025-01-15 08:26:21', NULL, 'K_000183-0001', '000183', NULL, NULL, '1', '2025-01-15', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-01-15', '1000', 'K_000183-0001', '1000', '現金', '1', '2025-01-15', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-01-15', NULL, NULL),
(426, '2025-01-20 03:07:00', '2025-01-20 03:08:34', NULL, 'K_000184-0001', '000184', NULL, NULL, '1', '2025-01-20', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-01-20', '8500', 'K_000184-0001', '8500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-01-20', NULL, 'SF_002', '2025-01-20', NULL, NULL),
(428, '2025-01-23 03:28:06', '2025-01-23 03:28:22', NULL, 'K_000185-0001', '000185', NULL, NULL, '1', '2025-01-23', NULL, 'cyclic', '毛穴洗浄', '2025-01-23', '5000', 'K_000185-0001', '5000', '現金', '1', '2025-01-23', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-23', NULL, NULL),
(429, '2025-01-24 09:10:39', '2025-01-24 09:10:57', NULL, 'K_000186-0001', '000186', NULL, NULL, '1', '2025-01-24', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-01-24', '6500', 'K_000186-0001', '6500', '現金', '1', '2025-01-24', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-24', NULL, NULL),
(430, '2025-01-25 06:31:38', '2025-01-25 06:32:07', NULL, 'K_000040-0007', '000040', NULL, NULL, '1', '2025-01-25', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-01-25', '1000', 'K_000040-0007', '1000', '現金', '1', '2025-01-25', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-01-25', NULL, NULL),
(431, '2025-01-25 08:29:25', '2025-01-25 10:19:07', NULL, 'K_000117-0003', '000117', NULL, NULL, '1', '2025-01-25', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-01-25', '1000', 'K_000117-0003', '1000', '現金', '1', '2025-01-25', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-01-25', NULL, NULL),
(432, '2025-01-26 07:33:15', '2025-01-26 07:33:32', NULL, 'K_000187-0001', '000187', NULL, NULL, '1', '2025-01-26', NULL, 'cyclic', '脂肪冷却', '2025-01-26', '2500', 'K_000187-0001', '2500', '現金', '1', '2025-01-26', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-26', NULL, NULL),
(433, '2025-01-29 05:36:22', '2025-01-29 05:36:44', NULL, 'K_000188-0001', '000188', NULL, NULL, '1', '2025-01-29', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-01-29', '8000', 'K_000188-0001', '8000', '現金', '1', '2025-01-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-29', NULL, NULL),
(434, '2025-01-30 04:19:52', '2025-01-30 04:20:06', NULL, 'K_000127-0004', '000127', NULL, NULL, '1', '2025-01-30', NULL, 'cyclic', '【ポイント消化】キャピテーション', '2025-01-30', '0', 'K_000127-0004', '0', '現金', '1', '2025-01-30', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-01-30', NULL, NULL),
(435, '2025-01-31 08:35:18', '2025-01-31 08:37:01', NULL, 'K_000059-0003', '000059', NULL, NULL, '1', '2025-01-31', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-01-31', '1000', 'K_000059-0003', '1000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-01-31', NULL, 'SF_004', '2025-01-31', NULL, NULL),
(437, '2025-01-31 08:53:29', '2025-03-03 05:20:46', NULL, 'K_000176-0003', '000176', NULL, NULL, '1', '2025-01-31', NULL, 'cyclic', 'ハイドラ＋プラズマ＋炭酸パック', '2025-01-31', '4000', 'K_000176-0003', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-01-31', NULL, 'SF_002', '2025-01-31', NULL, NULL);
INSERT INTO `contracts` (`id`, `created_at`, `updated_at`, `deleted_at`, `serial_keiyaku`, `serial_user`, `serial_staff`, `course`, `treatments_num`, `keiyaku_kikan_start`, `keiyaku_kikan_end`, `keiyaku_type`, `keiyaku_name`, `keiyaku_bi`, `keiyaku_kingaku`, `keiyaku_num`, `keiyaku_kingaku_total`, `how_to_pay`, `how_many_pay_genkin`, `date_first_pay_genkin`, `date_second_pay_genkin`, `amount_first_pay_cash`, `amount_second_pay_cash`, `card_company`, `how_many_pay_card`, `date_pay_card`, `tantosya`, `serial_tantosya`, `date_latest_visit`, `cancel`, `remarks`) VALUES
(438, '2025-02-01 09:26:28', '2025-02-01 10:01:24', NULL, 'K_000189-0001', '000189', NULL, NULL, '1', '2025-02-01', NULL, 'cyclic', 'キャピ＋脂肪冷却', '2025-02-01', '8000', 'K_000189-0001', '8000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-01', NULL, 'SF_002', '2025-02-01', NULL, NULL),
(439, '2025-02-01 10:01:50', '2025-03-01 04:26:15', NULL, 'K_000189-0002', '000189', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-02-01', '16000', 'K_000189-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-22', NULL, NULL),
(440, '2025-02-05 04:43:45', '2025-02-05 04:44:50', NULL, 'K_000190-0001', '000190', NULL, NULL, '1', '2025-02-05', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-02-05', '2500', 'K_000190-0001', '2500', '現金', '1', '2025-02-05', NULL, '2500', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-02-05', NULL, NULL),
(441, '2025-02-06 03:35:38', '2025-06-05 03:17:10', NULL, 'K_000009-0006', '000009', NULL, NULL, NULL, NULL, NULL, 'subscription', '【1周年キャンペーン】メニューランダム', '2025-02-06', '5000', 'K_000009-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '', NULL, NULL),
(442, '2025-02-06 07:14:12', '2025-02-06 07:14:28', NULL, 'K_000055-0005', '000055', NULL, NULL, '1', '2025-02-06', NULL, 'cyclic', '【ポイント消化】毛穴洗浄', '2025-02-06', '0', 'K_000055-0005', '0', '現金', '1', '2025-02-06', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-06', NULL, NULL),
(444, '2025-02-07 05:12:14', '2025-03-01 06:27:54', NULL, 'K_000056-0006', '000056', NULL, NULL, NULL, NULL, NULL, 'subscription', '【１周年記念】メニューランダム', '2025-02-07', '5000', 'K_000056-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-03-01', NULL, NULL),
(445, '2025-02-07 08:54:56', '2025-02-07 08:55:13', NULL, 'K_000191-0001', '000191', NULL, NULL, '1', '2025-02-07', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-02-07', '6500', 'K_000191-0001', '6500', '現金', '1', '2025-02-07', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-07', NULL, NULL),
(446, '2025-02-07 10:44:32', '2025-02-07 10:45:02', NULL, 'K_000076-0005', '000076', NULL, NULL, '1', '2025-02-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-02-07', '1000', 'K_000076-0005', '1000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-07', NULL, 'SF_004', '2025-02-07', NULL, NULL),
(447, '2025-02-07 10:45:41', '2025-04-30 07:22:31', NULL, 'K_000076-0006', '000076', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-02-07', '5000', 'K_000076-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_004', '', '2025-04-30', NULL),
(448, '2025-02-08 03:42:23', '2025-02-28 03:59:12', NULL, 'K_000038-0005', '000038', NULL, NULL, NULL, NULL, NULL, 'subscription', '【1周年キャンペーン】メニューランダム', '2025-02-08', '5000', 'K_000038-0005', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-02-28', NULL, NULL),
(449, '2025-02-08 04:51:11', '2025-02-08 05:41:24', NULL, 'K_000192-0001', '000192', NULL, NULL, '1', '2025-02-08', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-02-08', '8000', 'K_000192-0001', '8500', 'smart', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-08', NULL, NULL),
(452, '2025-02-08 05:13:13', '2025-03-16 04:03:02', NULL, 'K_000192-0002', '000192', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-02-08', '16000', 'K_000192-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-03-01', '2025-03-16', NULL),
(453, '2025-02-08 05:13:50', '2025-03-16 04:03:21', NULL, 'K_000192-0003', '000192', NULL, NULL, NULL, NULL, NULL, 'subscription', '【１周年記念】メニューランダム', '2025-02-08', '5000', 'K_000192-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '2025-03-01', '2025-03-16', NULL),
(457, '2025-02-08 07:22:26', '2025-02-08 07:22:59', NULL, 'K_000193-0001', '000193', NULL, NULL, '1', '2025-02-08', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-02-08', '7500', 'K_000193-0001', '7500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-08', NULL, 'SF_002', '2025-02-08', NULL, NULL),
(459, '2025-02-10 05:14:35', '2025-02-10 05:14:48', NULL, 'K_000195-0001', '000195', NULL, NULL, '1', '2025-02-10', NULL, 'cyclic', '脂肪冷却', '2025-02-10', '5000', 'K_000195-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-10', NULL, 'SF_002', '2025-02-10', NULL, NULL),
(460, '2025-02-15 04:41:01', '2025-03-01 04:24:27', NULL, 'K_000053-0005', '000053', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-02-15', '16000', 'K_000053-0005', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(461, '2025-02-15 05:35:30', '2025-02-15 05:35:46', NULL, 'K_000156-0003', '000156', NULL, NULL, '1', '2025-02-15', NULL, 'cyclic', 'ハイドラ＋プラズマ＋パック', '2025-02-15', '8500', 'K_000156-0003', '8500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-15', NULL, 'SF_002', '2025-02-15', NULL, NULL),
(462, '2025-02-22 10:05:37', '2025-02-22 10:05:51', NULL, 'K_000196-0001', '000196', NULL, NULL, '1', '2025-02-22', NULL, 'cyclic', '脂肪冷却', '2025-02-22', '5000', 'K_000196-0001', '5000', '現金', '1', '2025-02-22', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-22', NULL, NULL),
(463, '2025-02-23 05:33:00', '2025-02-23 05:33:22', NULL, 'K_000197-0001', '000197', NULL, NULL, '1', '2025-02-23', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-02-23', '4000', 'K_000197-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-02-23', NULL, 'SF_002', '2025-02-23', NULL, NULL),
(464, '2025-02-27 07:31:07', '2025-02-27 07:31:22', NULL, 'K_000198-0001', '000198', NULL, NULL, '1', '2025-02-27', NULL, 'cyclic', '脂肪冷却', '2025-02-27', '4800', 'K_000198-0001', '4800', '現金', '1', '2025-02-27', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-02-27', NULL, NULL),
(465, '2025-02-27 10:33:58', '2025-02-28 01:34:30', NULL, 'K_000153-0003', '000153', NULL, NULL, '1', '2025-02-27', '2025-02-27', 'cyclic', '全身脱毛+顔+VIO', '2025-02-27', '1000', 'K_000153-0003', '1000', '現金', '1', '2025-02-27', NULL, '1000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-02-28', NULL, NULL),
(466, '2025-02-28 06:36:49', '2025-05-24 09:14:13', NULL, 'K_000195-0002', '000195', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-02-28', '16000', 'K_000195-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-28', NULL, NULL),
(467, '2025-02-28 06:39:40', '2025-05-24 09:14:09', NULL, 'K_000195-0003', '000195', NULL, NULL, NULL, NULL, NULL, 'subscription', '【１周年記念】メニューランダム', '2025-02-28', '5000', 'K_000195-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '2025-02-28', NULL, NULL),
(468, '2025-03-01 09:42:30', '2025-03-01 09:45:56', NULL, 'K_000199-0001', '000199', NULL, NULL, '1', '2025-03-01', NULL, 'cyclic', '脂肪冷却＋フォトフェイシャル', '2025-03-01', '10000', 'K_000199-0001', '10000', '現金', '1', '2025-03-01', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-03-01', NULL, NULL),
(471, '2025-03-02 03:50:12', '2025-03-02 03:51:11', NULL, 'K_000200-0001', '000200', NULL, NULL, '1', '2025-03-02', '2025-03-02', 'cyclic', 'キャピ+脂肪冷却', '2025-03-02', '7800', 'K_000200-0001', '7800', '現金', '1', '2025-03-02', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-03-02', NULL, NULL),
(472, '2025-03-02 07:19:07', '2025-04-02 04:56:14', NULL, 'K_000201-0001', '000201', NULL, NULL, '1', '2025-03-02', NULL, 'cyclic', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-03-02', '3500', 'K_000201-0001', '3500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-02', NULL, 'SF_002', '2025-03-02', NULL, NULL),
(474, '2025-03-08 04:39:47', '2025-03-17 07:18:19', NULL, 'K_000059-0004', '000059', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛+顔+VIO', '2025-03-08', '12000', 'K_000059-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_004', '2025-03-08', '2025-03-17', NULL),
(475, '2025-03-12 02:49:11', '2025-03-12 02:49:28', NULL, 'K_000108-0005', '000108', NULL, NULL, '1', '2025-03-12', NULL, 'cyclic', 'フォトフェイシャル', '2025-03-12', '13000', 'K_000108-0005', '13000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-12', NULL, 'SF_002', '2025-03-12', NULL, NULL),
(476, '2025-03-14 03:47:36', '2025-04-02 04:56:42', NULL, 'K_000202-0001', '000202', NULL, NULL, '1', '2025-03-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-03-14', '5000', 'K_000202-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-02', NULL, 'SF_002', '2025-03-14', NULL, NULL),
(478, '2025-03-15 05:56:27', '2025-03-15 05:57:03', NULL, 'K_000204-0001', '000204', NULL, NULL, '1', '2025-03-15', NULL, 'cyclic', 'キャピテーション＋脂肪冷却＋EMS', '2025-03-15', '10500', 'K_000204-0001', '10500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-15', NULL, 'SF_002', '2025-03-15', NULL, NULL),
(480, '2025-03-16 08:39:03', '2025-03-16 08:39:18', NULL, 'K_000049-0010', '000049', NULL, NULL, NULL, NULL, NULL, 'subscription', '【１周年記念】メニューランダム', '2025-03-16', '5000', 'K_000049-0010', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(481, '2025-03-16 10:25:14', '2025-03-16 10:25:25', NULL, 'K_000058-0004', '000058', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-03-16', '15000', 'K_000058-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(482, '2025-03-21 05:50:22', '2025-03-21 05:50:37', NULL, 'K_000142-0004', '000142', NULL, NULL, '1', '2025-03-21', NULL, 'cyclic', '【トライアル】毛穴洗浄', '2025-03-21', '5000', 'K_000142-0004', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-21', NULL, 'SF_002', '2025-03-21', NULL, NULL),
(483, '2025-03-24 08:20:04', '2025-03-24 08:20:20', NULL, 'K_000205-0001', '000205', NULL, NULL, '1', '2025-03-24', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-03-24', '7800', 'K_000205-0001', '7800', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-24', NULL, 'SF_002', '2025-03-24', NULL, NULL),
(484, '2025-03-29 07:37:13', '2025-03-29 09:16:55', NULL, 'K_000206-0001', '000206', NULL, NULL, '1', '2025-03-29', NULL, 'cyclic', 'キャピ＋脂肪冷却＋次世代EMS', '2025-03-29', '11000', 'K_000206-0001', '11000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-03-29', NULL, 'SF_002', '2025-03-29', NULL, NULL),
(486, '2025-03-31 03:49:13', '2025-03-31 03:50:16', NULL, 'K_000207-0001', '000207', NULL, NULL, '1', '2025-03-31', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-03-31', '8500', 'K_000207-0001', '8500', '現金', '1', '2025-03-31', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-03-31', NULL, NULL),
(487, '2025-03-31 03:51:14', '2025-03-31 03:51:26', NULL, 'K_000207-0002', '000207', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-03-31', '16000', 'K_000207-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(488, '2025-03-31 03:52:06', '2025-03-31 03:52:17', NULL, 'K_000207-0003', '000207', NULL, NULL, NULL, NULL, NULL, 'subscription', '【１周年記念】メニューランダム', '2025-03-31', '5000', 'K_000207-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(489, '2025-04-02 03:01:11', '2025-04-02 03:14:10', NULL, 'K_000208-0001', '000208', NULL, NULL, '1', '2025-04-02', '2025-04-02', 'cyclic', '神原 杏惟', '2025-04-02', '5500', 'K_000208-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-02', NULL, 'SF_004', '2025-04-02', NULL, NULL),
(490, '2025-04-02 03:11:37', '2025-06-07 04:30:53', NULL, 'K_000208-0002', '000208', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却モニター', '2025-04-02', '29000', 'K_000208-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', '', '2025-06-07', NULL),
(493, '2025-04-04 04:14:02', '2025-04-04 06:54:30', NULL, 'K_000209-0001', '000209', NULL, NULL, '1', '2025-04-04', '2025-04-04', 'cyclic', 'ハイドラ+フォト', '2025-04-04', '3000', 'K_000209-0001', '3000', '現金', '1', '2025-04-04', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-04-04', NULL, NULL),
(495, '2025-04-04 06:01:04', '2025-04-04 06:01:04', NULL, 'K_000209-0002', '000209', NULL, NULL, NULL, NULL, NULL, 'subscription', 'ハイドラフェイシャル＋フォトフェイシャル', '2025-04-04', '7000', 'K_000209-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_004', NULL, NULL, NULL),
(497, '2025-04-05 05:37:08', '2025-04-05 05:53:38', NULL, 'K_000210-0001', '000210', NULL, NULL, '1', '2025-04-05', '2025-04-05', 'cyclic', '毛穴洗浄+フォト', '2025-04-05', '3000', 'K_000210-0001', '3000', '現金', '1', '2025-04-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-04-05', NULL, NULL),
(498, '2025-04-09 05:40:20', '2025-04-09 07:00:13', NULL, 'K_000053-0006', '000053', NULL, NULL, '1', '2025-04-09', '2025-04-09', 'cyclic', 'ハイドラ+フォト', '2025-04-09', '3000', 'K_000053-0006', '3000', '現金', '1', '2025-04-09', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-04-09', NULL, NULL),
(499, '2025-04-11 04:35:34', '2025-04-11 04:52:39', NULL, 'K_000211-0001', '000211', NULL, NULL, '1', '2025-04-11', '2025-04-11', 'cyclic', 'ハイドラ+フォト', '2025-04-11', '3000', 'K_000211-0001', '3000', '現金', '1', '2025-04-11', NULL, '3000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-04-11', NULL, NULL),
(500, '2025-04-11 04:38:06', '2025-06-07 04:30:19', NULL, 'K_000211-0002', '000211', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-04-11', '16000', 'K_000211-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_004', '2025-04-11', '2025-06-07', NULL),
(503, '2025-04-11 08:34:50', '2025-04-11 08:35:12', NULL, 'K_000183-0002', '000183', NULL, NULL, '1', '2025-04-11', '2025-04-11', 'cyclic', 'ハイドラ+フォト', '2025-04-11', '3000', 'K_000183-0002', '3000', '現金', '1', '2025-04-11', NULL, '3000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-04-11', NULL, NULL),
(505, '2025-04-12 03:28:04', '2025-04-12 03:28:25', NULL, 'K_000212-0001', '000212', NULL, NULL, '1', '2025-04-12', NULL, 'cyclic', 'キャピテーション＋脂肪冷却', '2025-04-12', '11900', 'K_000212-0001', '11900', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-12', NULL, 'SF_002', '2025-04-12', NULL, NULL),
(506, '2025-04-12 03:29:47', '2025-04-12 03:29:57', NULL, 'K_000212-0002', '000212', NULL, NULL, NULL, NULL, NULL, 'subscription', '脂肪冷却', '2025-04-12', '16000', 'K_000212-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(507, '2025-04-12 03:40:16', '2025-04-12 03:40:27', NULL, 'K_000212-0003', '000212', NULL, NULL, NULL, NULL, NULL, 'subscription', 'キャピテーション', '2025-04-12', '5000', 'K_000212-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(508, '2025-04-12 08:04:04', '2025-04-12 09:19:11', NULL, 'K_000213-0001', '000213', NULL, NULL, '1', '2025-04-12', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-04-12', '6500', 'K_000213-0001', '6500', '現金', '1', '2025-04-12', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-04-12', NULL, NULL),
(509, '2025-04-17 03:02:12', '2025-04-17 03:02:29', NULL, 'K_000142-0005', '000142', NULL, NULL, '1', '2025-04-17', NULL, 'cyclic', 'バストアップ', '2025-04-17', '3000', 'K_000142-0005', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-17', NULL, 'SF_002', '2025-04-17', NULL, NULL),
(510, '2025-04-17 10:26:36', '2025-04-17 10:29:45', NULL, 'K_000214-0001', '000214', NULL, NULL, '1', '2025-04-17', '2025-04-17', 'cyclic', 'キャピ+脂肪冷却+EMS', '2025-04-17', '15000', 'K_000214-0001', '15000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-17', NULL, 'SF_004', '2025-04-17', NULL, NULL),
(511, '2025-04-17 10:31:18', '2025-05-24 09:15:34', NULL, 'K_000214-0002', '000214', NULL, NULL, NULL, NULL, NULL, 'subscription', 'キャピテーション＋脂肪冷却モニター', '2025-04-17', '35000', 'K_000214-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', NULL, NULL, NULL),
(512, '2025-04-18 06:01:12', '2025-04-18 06:01:29', NULL, 'K_000069-0006', '000069', NULL, NULL, '1', '2025-04-18', NULL, 'cyclic', 'バストアップ', '2025-04-18', '3000', 'K_000069-0006', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-18', NULL, 'SF_002', '2025-04-18', NULL, NULL),
(513, '2025-04-20 08:59:46', '2025-04-20 09:55:38', NULL, 'K_000215-0001', '000215', NULL, NULL, '1', '2025-04-20', NULL, 'cyclic', 'バストアップ', '2025-04-20', '5000', 'K_000215-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-20', NULL, 'SF_002', '2025-04-20', NULL, NULL),
(514, '2025-04-20 10:05:11', '2025-04-20 10:05:25', NULL, 'K_000215-0002', '000215', NULL, NULL, NULL, NULL, NULL, 'subscription', 'バストアップ+全身脱毛', '2025-04-20', '25000', 'K_000215-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(515, '2025-04-25 02:53:26', '2025-04-25 02:55:43', NULL, 'K_000216-0001', '000216', NULL, NULL, '1', '2025-04-25', NULL, 'cyclic', 'バストアップ', '2025-04-25', '3000', 'K_000216-0001', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-25', NULL, 'SF_002', '2025-04-25', NULL, NULL),
(516, '2025-04-25 02:56:01', '2025-04-25 02:56:14', NULL, 'K_000216-0002', '000216', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-04-25', '12000', 'K_000216-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(517, '2025-04-28 03:10:04', '2025-04-28 03:10:23', NULL, 'K_000108-0006', '000108', NULL, NULL, '1', '2025-04-28', NULL, 'cyclic', 'バストアップ', '2025-04-28', '3000', 'K_000108-0006', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-28', NULL, 'SF_002', '2025-04-28', NULL, NULL),
(518, '2025-04-28 06:38:07', '2025-04-28 06:38:25', NULL, 'K_000217-0001', '000217', NULL, NULL, '1', '2025-04-28', NULL, 'cyclic', '【トライアル】全身脱毛（顔・VIO込）', '2025-04-28', '3000', 'K_000217-0001', '3000', '現金', '1', '2025-04-28', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-04-28', NULL, NULL),
(519, '2025-04-28 06:39:17', '2025-04-28 06:39:33', NULL, 'K_000217-0002', '000217', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-04-28', '10000', 'K_000217-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(520, '2025-04-28 08:17:17', '2025-04-28 08:17:32', NULL, 'K_000019-0002', '000019', NULL, NULL, '1', '2025-04-28', NULL, 'cyclic', '【トライアル】バストアップ', '2025-04-28', '3000', 'K_000019-0002', '3000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-04-28', NULL, 'SF_002', '2025-04-28', NULL, NULL),
(521, '2025-04-30 02:55:04', '2025-04-30 02:58:53', NULL, 'K_000218-0001', '000218', NULL, NULL, '1', '2025-04-30', NULL, 'cyclic', '【トライアル】バストアップ', '2025-04-30', '3000', 'K_000218-0001', '3000', '現金', '1', '2025-04-30', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-04-30', NULL, NULL),
(522, '2025-05-01 09:05:43', '2025-05-01 09:05:59', NULL, 'K_000053-0007', '000053', NULL, NULL, '1', '2025-05-01', NULL, 'cyclic', '【トライアル】バストアップ', '2025-05-01', '3000', 'K_000053-0007', '3000', '現金', '1', '2025-05-01', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-05-01', NULL, NULL),
(523, '2025-05-02 02:57:26', '2025-05-02 03:46:46', NULL, 'K_000040-0008', '000040', NULL, NULL, '1', '2025-05-02', '2025-05-02', 'cyclic', 'バストアップ', '2025-05-02', '3000', 'K_000040-0008', '3000', '現金', '1', '2025-05-02', NULL, '3000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-05-02', NULL, NULL),
(524, '2025-05-03 01:37:27', '2025-05-03 02:53:18', NULL, 'K_000181-0002', '000181', NULL, NULL, '1', '2025-05-03', NULL, 'cyclic', '【トライアル】バストアップ', '2025-05-03', '3000', 'K_000181-0002', '3000', '現金', '1', '2025-05-03', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-03', NULL, NULL),
(525, '2025-05-07 09:44:28', '2025-05-07 09:45:35', NULL, 'K_000142-0006', '000142', NULL, NULL, NULL, NULL, NULL, 'subscription', 'バストアップ', '2025-05-08', '13000', 'K_000142-0006', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', NULL, NULL, NULL),
(528, '2025-05-14 03:18:34', '2025-05-14 04:40:54', NULL, 'K_000067-0002', '000067', NULL, NULL, '1', '2025-05-14', NULL, 'cyclic', '【LINE会員様限定】バストアップ', '2025-05-14', '5000', 'K_000067-0002', '5000', '現金', '1', '2025-05-14', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-14', NULL, NULL),
(529, '2025-05-14 03:52:57', '2025-05-14 04:24:22', NULL, 'K_000219-0001', '000219', NULL, NULL, '1', '2025-05-14', '2025-05-14', 'cyclic', 'キャピ+脂肪冷却+次世代EMS', '2025-05-14', '15000', 'K_000219-0001', '15000', '現金', '1', '2025-05-14', NULL, '15000', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-05-14', NULL, NULL),
(530, '2025-05-14 09:25:55', '2025-05-14 09:26:08', NULL, 'K_000220-0001', '000220', NULL, NULL, '1', '2025-05-14', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-05-14', '3800', 'K_000220-0001', '3800', '現金', '1', '2025-05-14', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-14', NULL, NULL),
(531, '2025-05-15 08:29:11', '2025-05-15 08:29:37', NULL, 'K_000221-0001', '000221', NULL, NULL, '1', '2025-05-15', NULL, 'cyclic', 'バストアップ', '2025-05-15', '5000', 'K_000221-0001', '5000', '現金', '1', '2025-05-15', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-15', NULL, NULL),
(532, '2025-05-16 01:45:40', '2025-05-16 04:13:10', NULL, 'K_000026-0003', '000026', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛＋フォト', '2025-05-16', '18000', 'K_000026-0003', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_002', NULL, NULL, NULL),
(535, '2025-05-17 07:05:03', '2025-05-17 07:05:18', NULL, 'K_000144-0002', '000144', NULL, NULL, '1', '2025-05-17', NULL, 'cyclic', 'バストアップ', '2025-05-17', '5000', 'K_000144-0002', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-17', NULL, 'SF_002', '2025-05-17', NULL, NULL),
(536, '2025-05-19 03:27:24', '2025-05-19 03:27:42', NULL, 'K_000222-0001', '000222', NULL, NULL, '1', '2025-05-19', NULL, 'cyclic', 'バストアップ', '2025-05-19', '3000', 'K_000222-0001', '3000', '現金', '1', '2025-05-19', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-19', NULL, NULL),
(537, '2025-05-22 03:42:23', '2025-05-22 04:03:15', NULL, 'K_000223-0001', '000223', NULL, NULL, '1', '2025-05-22', NULL, 'cyclic', '脂肪冷却', '2025-05-22', '9900', 'K_000223-0001', '9900', '現金', '1', '2025-05-22', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-22', NULL, NULL),
(539, '2025-05-22 09:07:18', '2025-05-22 10:33:17', NULL, 'K_000224-0001', '000224', NULL, NULL, '1', '2025-05-22', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-05-22', '5000', 'K_000224-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-22', NULL, 'SF_002', '2025-05-22', NULL, NULL),
(541, '2025-05-23 04:00:37', '2025-05-23 06:34:40', NULL, 'K_000112-0004', '000112', NULL, NULL, NULL, '2025-05-23', NULL, 'subscription', 'バストアップ', '2025-05-23', '', 'K_000112-0004', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-23', NULL, 'SF_002', NULL, NULL, NULL),
(552, '2025-05-25 03:42:38', '2025-05-25 03:42:38', NULL, 'K_000222-0002', '000222', NULL, NULL, NULL, '2025-05-23', NULL, 'subscription', 'バストアップ', '2025-05-25', '15000', 'K_000222-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', NULL, NULL, NULL),
(553, '2025-05-25 09:11:27', '2025-05-25 09:11:37', NULL, 'K_000040-0009', '000040', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-05-25', '10800', 'K_000040-0009', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(554, '2025-05-25 10:34:53', '2025-05-25 10:41:31', NULL, 'K_000225-0001', '000225', NULL, NULL, '1', '2025-05-25', '2025-05-25', 'cyclic', 'ハイドラ+フォト', '2025-05-25', '4000', 'K_000225-0001', '4000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-25', NULL, 'SF_004', '2025-05-25', NULL, NULL),
(555, '2025-05-29 03:01:36', '2025-05-29 04:10:25', NULL, 'K_000226-0001', '000226', NULL, NULL, '1', '2025-05-29', NULL, 'cyclic', 'フォトフェイシャル', '2025-05-29', '2500', 'K_000226-0001', '2500', '現金', '1', '2025-05-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-29', NULL, NULL),
(556, '2025-05-29 04:23:36', '2025-05-29 04:34:57', NULL, 'K_000226-0002', '000226', NULL, NULL, '1', '2025-05-29', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-05-29', '6000', 'K_000226-0002', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-29', NULL, 'SF_002', '', NULL, NULL),
(557, '2025-05-29 05:25:56', '2025-05-29 05:26:11', NULL, 'K_000227-0001', '000227', NULL, NULL, '1', '2025-05-29', NULL, 'cyclic', 'バストアップ', '2025-05-29', '5000', 'K_000227-0001', '5000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-29', NULL, 'SF_004', '2025-05-29', NULL, NULL),
(558, '2025-05-29 05:28:34', '2025-05-29 05:28:49', NULL, 'K_000228-0001', '000228', NULL, NULL, '1', '2025-05-29', NULL, 'cyclic', 'バストアップ', '2025-05-29', '5000', 'K_000228-0001', '5000', '現金', '1', '2025-05-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-05-29', NULL, NULL),
(559, '2025-05-29 06:00:27', '2025-05-29 06:00:46', NULL, 'K_000229-0001', '000229', NULL, NULL, '1', '2025-05-29', NULL, 'cyclic', 'バストアップ', '2025-05-29', '5000', 'K_000229-0001', '5000', '現金', '1', '2025-05-29', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '2025-05-29', NULL, NULL),
(560, '2025-05-30 04:15:46', '2025-05-30 04:16:02', NULL, 'K_000142-0007', '000142', NULL, NULL, '1', '2025-05-30', NULL, 'cyclic', '【ポイント消化】フォトフェイシャル', '2025-05-30', '0', 'K_000142-0007', 'NaN', '現金', '1', '2025-05-30', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-05-30', NULL, NULL),
(561, '2025-05-30 05:23:53', '2025-05-30 05:25:15', NULL, 'K_000230-0001', '000230', NULL, NULL, '1', '2025-05-30', '2025-05-30', 'cyclic', '全身脱毛+顔+VIO', '2025-05-30', '5500', 'K_000230-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_004', '2025-05-30', NULL, NULL),
(562, '2025-05-30 05:26:21', '2025-05-30 05:26:34', NULL, 'K_000230-0002', '000230', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛+顔+VIO', '2025-05-30', '10800', 'K_000230-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_004', '', NULL, NULL),
(563, '2025-05-31 06:58:28', '2025-05-31 08:36:10', NULL, 'K_000156-0004', '000156', NULL, NULL, '1', '2025-05-31', NULL, 'cyclic', 'ハイドラ＋ジェリーマスク', '2025-05-31', '10000', 'K_000156-0004', '10000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-05-31', NULL, 'SF_002', '2025-05-31', NULL, NULL),
(565, '2025-05-31 09:03:55', '2025-05-31 09:23:27', NULL, 'K_000231-0001', '000231', NULL, NULL, '1', '2025-05-31', '2025-05-31', 'cyclic', '全身脱毛+顔+VIO', '2025-05-31', '6000', 'K_000231-0001', '6000', '現金', '1', '2025-05-31', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_004', '', NULL, NULL),
(566, '2025-05-31 09:04:03', '2025-05-31 09:11:58', NULL, 'K_000231-0002', '000231', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-05-31', '10800', 'K_000231-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '2', NULL, NULL, 'SF_004', NULL, NULL, NULL),
(572, '2025-06-01 05:42:43', '2025-06-01 06:08:53', NULL, 'K_000232-0001', '000232', NULL, NULL, '1', '2025-06-01', NULL, 'cyclic', '顔脱毛', '2025-06-01', '4500', 'K_000232-0001', '4500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-06-01', NULL, 'SF_002', '2025-06-01', NULL, NULL),
(574, '2025-06-01 06:17:55', '2025-06-01 06:18:19', NULL, 'K_000232-0002', '000232', NULL, NULL, '1', '2025-06-01', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-06-01', '6000', 'K_000232-0002', '6000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-06-01', NULL, 'SF_002', '', NULL, NULL),
(575, '2025-06-02 02:16:08', '2025-06-02 03:53:09', NULL, 'K_000108-0007', '000108', NULL, NULL, '1', '2025-06-02', NULL, 'cyclic', '脂肪冷却', '2025-06-02', '16000', 'K_000108-0007', '16000', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-06-02', NULL, 'SF_002', '2025-06-02', NULL, NULL),
(577, '2025-06-05 09:13:27', '2025-06-05 09:25:28', NULL, 'K_000233-0001', '000233', NULL, NULL, '1', '2025-06-05', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-06-05', '5800', 'K_000233-0001', '5800', '現金', '1', '2025-06-05', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-06-05', NULL, NULL),
(578, '2025-06-05 09:25:42', '2025-06-05 09:26:04', NULL, 'K_000233-0002', '000233', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-06-05', '10800', 'K_000233-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL),
(579, '2025-06-05 11:01:37', '2025-06-05 11:02:04', NULL, 'K_000235-0001', '000235', NULL, NULL, '1', '2025-06-05', '2025-06-05', 'cyclic', '全身脱毛+顔+VIO', '2025-06-05', '5500', 'K_000235-0001', '5500', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', '1', '2025-06-05', NULL, 'SF_004', '2025-06-05', NULL, NULL),
(580, '2025-06-07 02:00:42', '2025-06-07 02:00:55', NULL, 'K_000121-0004', '000121', NULL, NULL, '1', '2025-06-07', NULL, 'cyclic', '【ポイント消化】バストアップ', '2025-06-07', '0', 'K_000121-0004', '0', '現金', '1', '2025-06-07', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-06-07', NULL, NULL),
(581, '2025-06-07 08:37:12', '2025-06-07 10:06:41', NULL, 'K_000236-0001', '000236', NULL, NULL, '1', '2025-06-07', NULL, 'cyclic', '全身脱毛（顔・VIO込）', '2025-06-07', '6000', 'K_000236-0001', '6000', '現金', '1', '2025-06-07', NULL, '', '', NULL, NULL, NULL, NULL, 'SF_002', '2025-06-07', NULL, NULL),
(582, '2025-06-07 10:07:02', '2025-06-07 10:07:10', NULL, 'K_000236-0002', '000236', NULL, NULL, NULL, NULL, NULL, 'subscription', '全身脱毛（顔・VIO込）', '2025-06-07', '10800', 'K_000236-0002', '', 'Credit Card', NULL, NULL, NULL, '', '', '未選択', NULL, NULL, NULL, 'SF_002', '', NULL, NULL);

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
(29, '2024-02-16 18:12:59', '2024-02-16 18:12:59', NULL, 'K_000011-0001-0001', 'K_000011-0001', '000011', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL),
(30, '2024-02-16 21:10:41', '2024-02-16 21:10:41', NULL, 'K_000012-0001-0001', 'K_000012-0001', '000012', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(32, '2024-02-17 18:43:03', '2024-02-17 18:43:03', NULL, 'K_000013-0001-0001', 'K_000013-0001', '000013', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
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
(62, '2024-03-06 21:05:56', '2025-03-06 02:36:51', NULL, 'K_000003-0003-0001', 'K_000003-0003', '000003', NULL, 'サブスクリプション', NULL, '20000', NULL, NULL),
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
(125, '2024-05-01 03:40:35', '2024-05-01 03:40:35', NULL, 'K_000054-0001-0001', 'K_000054-0001', '000054', NULL, 'キャピ＋脂肪冷却', '1', '7300', '7300', NULL),
(127, '2024-05-01 11:21:42', '2024-05-01 11:21:42', NULL, 'K_000055-0002-0001', 'K_000055-0002', '000055', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(128, '2024-05-01 11:22:11', '2024-05-01 11:22:11', NULL, 'K_000055-0001-0001', 'K_000055-0001', '000055', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(129, '2024-05-02 08:28:41', '2024-05-02 08:28:41', NULL, 'K_000056-0001-0001', 'K_000056-0001', '000056', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(130, '2024-05-02 08:49:13', '2024-05-02 08:49:13', NULL, 'K_000056-0002-0001', 'K_000056-0002', '000056', NULL, 'サブスクリプション', NULL, '11000', NULL, NULL),
(131, '2024-05-05 09:47:15', '2024-05-05 09:47:15', NULL, 'K_000057-0001-0001', 'K_000057-0001', '000057', NULL, 'ハイドラフェイシャル', '1', '5500', '5500', NULL),
(132, '2024-05-06 03:27:03', '2024-05-06 03:27:03', NULL, 'K_000058-0001-0001', 'K_000058-0001', '000058', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(133, '2024-05-10 03:23:19', '2024-05-10 03:23:19', NULL, 'K_000022-0003-0001', 'K_000022-0003', '000022', NULL, 'サブスクリプション', NULL, '8000', NULL, NULL),
(134, '2024-05-12 03:53:12', '2024-05-12 03:53:12', NULL, 'K_000059-0001-0001', 'K_000059-0001', '000059', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(135, '2024-05-12 05:17:46', '2024-05-12 05:17:46', NULL, 'K_000060-0001-0001', 'K_000060-0001', '000060', NULL, 'ハイドラフェイシャル', '1', '4800', '4800', NULL),
(136, '2024-05-12 10:31:41', '2024-05-12 10:31:41', NULL, 'K_000061-0001-0001', 'K_000061-0001', '000061', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(137, '2024-05-13 04:51:54', '2024-05-13 04:51:54', NULL, 'K_000022-0004-0001', 'K_000022-0004', '000022', NULL, 'ハイドラ＋フォト', '1', '10000', '10000', NULL),
(138, '2024-05-15 03:19:16', '2024-05-15 03:19:16', NULL, 'K_000062-0001-0001', 'K_000062-0001', '000062', NULL, '脂肪冷却＋ハイドラ', '1', '8200', '8200', NULL),
(139, '2024-05-16 03:27:08', '2024-05-16 03:27:08', NULL, 'K_000063-0001-0001', 'K_000063-0001', '000063', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(140, '2024-05-17 04:53:30', '2024-05-17 04:53:30', NULL, 'K_000064-0001-0001', 'K_000064-0001', '000064', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(141, '2024-05-17 05:11:36', '2024-05-17 05:11:36', NULL, 'K_000064-0002-0001', 'K_000064-0002', '000064', NULL, 'サブスクリプション', NULL, '21600', NULL, NULL),
(142, '2024-05-17 06:49:41', '2024-05-17 06:49:41', NULL, 'K_000065-0001-0001', 'K_000065-0001', '000065', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(143, '2024-05-18 06:44:16', '2024-05-18 06:44:16', NULL, 'K_000066-0001-0001', 'K_000066-0001', '000066', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(144, '2024-05-18 08:05:55', '2024-05-18 08:05:55', NULL, 'K_000049-0003-0001', 'K_000049-0003', '000049', NULL, 'ハイドラ＋フォト', '1', '10000', '10000', NULL),
(145, '2024-05-19 04:20:04', '2024-05-19 04:20:04', NULL, 'K_000067-0001-0001', 'K_000067-0001', '000067', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(146, '2024-05-19 07:08:37', '2024-05-19 07:08:37', NULL, 'K_000068-0001-0001', 'K_000068-0001', '000068', NULL, 'キャピ＋脂肪冷却', '1', '7500', '7500', NULL),
(147, '2024-05-20 03:23:22', '2024-05-20 03:23:22', NULL, 'K_000069-0001-0001', 'K_000069-0001', '000069', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(148, '2024-05-20 05:03:44', '2024-05-20 05:03:44', NULL, 'K_000070-0001-0001', 'K_000070-0001', '000070', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(149, '2024-05-22 05:00:45', '2024-05-22 05:00:45', NULL, 'K_000071-0001-0001', 'K_000071-0001', '000071', NULL, 'ハイドラ＋フォト', '1', '4500', '4500', NULL),
(152, '2024-05-22 07:40:43', '2024-05-22 07:40:43', NULL, 'K_000039-0002-0001', 'K_000039-0002', '000039', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(153, '2024-05-22 07:41:04', '2024-05-22 07:41:04', NULL, 'K_000039-0003-0001', 'K_000039-0003', '000039', NULL, 'サブスクリプション', NULL, '17600', NULL, NULL),
(154, '2024-05-25 03:16:32', '2024-05-25 03:16:32', NULL, 'K_000072-0001-0001', 'K_000072-0001', '000072', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(155, '2024-05-25 06:28:54', '2024-05-25 06:28:54', NULL, 'K_000073-0001-0001', 'K_000073-0001', '000073', NULL, 'ハイドラ＋フォト', '1', '5000', '5000', NULL),
(156, '2024-05-26 07:28:58', '2024-05-26 07:28:58', NULL, 'K_000074-0001-0001', 'K_000074-0001', '000074', NULL, '全身脱毛(VIO込)＋フォト', '1', '7000', '7000', NULL),
(157, '2024-05-28 03:07:29', '2024-05-28 03:07:29', NULL, 'K_000043-0002-0001', 'K_000043-0002', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(158, '2024-05-29 03:12:39', '2024-05-29 03:12:39', NULL, 'K_000075-0001-0001', 'K_000075-0001', '000075', NULL, 'ハイドラ＋フォト', '1', '6300', '6300', NULL),
(159, '2024-05-31 09:43:05', '2024-05-31 09:43:05', NULL, 'K_000058-0002-0001', 'K_000058-0002', '000058', NULL, 'ハイドラ＋フォト', '1', '10000', '10000', NULL),
(160, '2024-05-31 09:50:54', '2024-05-31 09:50:54', NULL, 'K_000058-0003-0001', 'K_000058-0003', '000058', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(161, '2024-06-01 06:46:09', '2024-06-01 06:46:09', NULL, 'K_000076-0001-0001', 'K_000076-0001', '000076', NULL, '全身脱毛＋顔＋VIO', '1', '5900', '5900', NULL),
(162, '2024-06-01 06:46:52', '2024-06-01 06:46:52', NULL, 'K_000076-0002-0001', 'K_000076-0002', '000076', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(163, '2024-06-01 08:08:36', '2024-06-01 08:08:36', NULL, 'K_000077-0001-0001', 'K_000077-0001', '000077', NULL, '脂肪冷却', '1', '5500', '5500', NULL),
(164, '2024-06-01 10:23:53', '2024-06-01 10:23:53', NULL, 'K_000078-0001-0001', 'K_000078-0001', '000078', NULL, '脇＆VIO脱毛', '1', '5000', '5000', NULL),
(165, '2024-06-02 01:52:41', '2024-06-02 01:52:41', NULL, 'K_000059-0002-0001', 'K_000059-0002', '000059', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(166, '2024-06-03 03:56:31', '2024-06-03 03:56:31', NULL, 'K_000079-0001-0001', 'K_000079-0001', '000079', NULL, 'キャピ＋脂肪冷却', '1', '7300', '7300', NULL),
(167, '2024-06-03 09:17:46', '2024-06-03 09:17:46', NULL, 'K_000080-0001-0001', 'K_000080-0001', '000080', NULL, 'ハイドラフェイシャル', '1', '4000', '4000', NULL),
(168, '2024-06-05 04:57:44', '2024-06-05 04:57:44', NULL, 'K_000081-0001-0001', 'K_000081-0001', '000081', NULL, 'ハイドラ＋フォト', '1', '3500', '3500', NULL),
(170, '2024-06-05 07:03:00', '2024-06-05 07:03:00', NULL, 'K_000082-0001-0001', 'K_000082-0001', '000082', NULL, '脂肪冷却', '1', '4500', '4500', NULL),
(171, '2024-06-05 09:15:29', '2024-06-05 09:15:29', NULL, 'K_000083-0001-0001', 'K_000083-0001', '000083', NULL, 'フォトフェイシャル', '1', '6700', '6700', NULL),
(173, '2024-06-05 10:54:18', '2024-06-05 10:54:18', NULL, 'K_000084-0001-0001', 'K_000084-0001', '000084', NULL, 'ハイドラ＋フォト', '1', '3500', '3500', NULL),
(174, '2024-06-06 04:30:37', '2024-06-06 04:30:37', NULL, 'K_000085-0001-0001', 'K_000085-0001', '000085', NULL, '脂肪冷却＋ハイドラ', '1', '8500', '8500', NULL),
(175, '2024-06-06 05:55:03', '2024-06-06 05:55:03', NULL, 'K_000009-0005-0001', 'K_000009-0005', '000009', NULL, 'ハイドラ＋フォト', '1', '10000', '10000', NULL),
(176, '2024-06-06 08:15:32', '2024-06-06 08:15:32', NULL, 'K_000086-0001-0001', 'K_000086-0001', '000086', NULL, 'キャピ＋脂肪冷却', '1', '3000', '3000', NULL),
(178, '2024-06-07 10:25:57', '2024-06-07 10:25:57', NULL, 'K_000087-0001-0001', 'K_000087-0001', '000087', NULL, 'キャピ＋脂肪冷却', '0', '7500', '7500', NULL),
(179, '2024-06-08 03:22:30', '2024-06-08 03:22:30', NULL, 'K_000088-0001-0001', 'K_000088-0001', '000088', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(180, '2024-06-08 03:23:29', '2024-06-08 03:23:29', NULL, 'K_000088-0002-0001', 'K_000088-0002', '000088', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(181, '2024-06-08 07:03:11', '2024-06-08 07:03:11', NULL, 'K_000089-0001-0001', 'K_000089-0001', '000089', NULL, 'フォトフェイシャル', '1', '5000', '5000', NULL),
(182, '2024-06-09 05:30:09', '2024-06-09 05:30:09', NULL, 'K_000090-0001-0001', 'K_000090-0001', '000090', NULL, 'ハイドラ＋フォト', '1', '6100', '6100', NULL),
(183, '2024-06-09 07:00:19', '2024-06-09 07:00:19', NULL, 'K_000091-0001-0001', 'K_000091-0001', '000091', NULL, 'ハイドラ＋フォト', '1', '6300', '6300', NULL),
(184, '2024-06-10 05:21:40', '2024-06-10 05:21:40', NULL, 'K_000092-0001-0001', 'K_000092-0001', '000092', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(185, '2024-06-12 09:44:45', '2024-06-12 09:44:45', NULL, 'K_000071-0002-0001', 'K_000071-0002', '000071', NULL, '脂肪冷却', '1', '9000', '9000', NULL),
(186, '2024-06-13 04:58:14', '2024-06-13 04:58:14', NULL, 'K_000093-0001-0001', 'K_000093-0001', '000093', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(188, '2024-06-14 06:27:04', '2024-06-14 06:27:04', NULL, 'K_000094-0001-0001', 'K_000094-0001', '000094', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(189, '2024-06-14 08:22:41', '2024-06-14 08:22:41', NULL, 'K_000056-0003-0001', 'K_000056-0003', '000056', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(190, '2024-06-14 08:59:45', '2024-06-14 08:59:45', NULL, 'K_000001-0002-0001', 'K_000001-0002', '000001', NULL, 'サブスクリプション', NULL, '21600', NULL, NULL),
(191, '2024-06-15 03:34:14', '2024-06-15 03:34:14', NULL, 'K_000095-0001-0001', 'K_000095-0001', '000095', NULL, 'フォト＋美白パック', '1', '5500', '5500', NULL),
(192, '2024-06-15 07:59:12', '2024-06-15 07:59:12', NULL, 'K_000049-0004-0001', 'K_000049-0004', '000049', NULL, 'ハイドラ＋バブルパック', '1', '6000', '6000', NULL),
(193, '2024-06-21 07:38:53', '2024-06-21 07:38:53', NULL, 'K_000076-0003-0001', 'K_000076-0003', '000076', NULL, 'ハイドラ＋バブルパック', '1', '6000', '6000', NULL),
(194, '2024-06-22 10:26:26', '2024-06-22 10:26:26', NULL, 'K_000096-0001-0001', 'K_000096-0001', '000096', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(195, '2024-06-23 03:20:16', '2024-06-23 03:20:16', NULL, 'K_000097-0001-0001', 'K_000097-0001', '000097', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(196, '2024-06-23 07:12:55', '2024-06-23 07:12:55', NULL, 'K_000098-0001-0001', 'K_000098-0001', '000098', NULL, 'キャピ＋脂肪冷却', '1', '4500', '4500', NULL),
(197, '2024-06-23 09:03:06', '2024-06-23 09:03:06', NULL, 'K_000099-0001-0001', 'K_000099-0001', '000099', NULL, 'ハイドラフェイシャル', '1', '4700', '4700', NULL),
(198, '2024-06-24 03:15:12', '2024-06-24 03:15:12', NULL, 'K_000069-0002-0001', 'K_000069-0002', '000069', NULL, 'ハイドラ＋フォト', '1', '10000', '10000', NULL),
(199, '2024-06-24 07:38:03', '2024-06-24 07:38:03', NULL, 'K_000100-0001-0001', 'K_000100-0001', '000100', NULL, 'ハイドラフェイシャル', '1', '2700', '2700', NULL),
(200, '2024-06-24 11:00:20', '2024-06-24 11:00:20', NULL, 'K_000031-0005-0001', 'K_000031-0005', '000031', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(202, '2024-06-26 07:54:10', '2024-06-26 07:54:10', NULL, 'K_000101-0001-0001', 'K_000101-0001', '000101', NULL, '脇＆VIO脱毛', '1', '5000', '5000', NULL),
(203, '2024-06-26 07:55:49', '2024-06-26 07:55:49', NULL, 'K_000101-0002-0001', 'K_000101-0002', '000101', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(205, '2024-06-27 08:40:00', '2024-06-27 08:40:00', NULL, 'K_000055-0003-0001', 'K_000055-0003', '000055', NULL, 'ハイドラ＋バブルパック', '1', '6000', '6000', NULL),
(207, '2024-06-28 08:35:52', '2024-06-28 08:35:52', NULL, 'K_000102-0001-0001', 'K_000102-0001', '000102', NULL, 'ハイドラフェイシャル', '0', '', '', NULL),
(209, '2024-06-29 04:57:36', '2024-06-29 04:57:36', NULL, 'K_000072-0002-0001', 'K_000072-0002', '000072', NULL, 'ハイドラ＋フォト', '1', '5000', '5000', NULL),
(210, '2024-06-29 07:13:11', '2024-06-29 07:13:11', NULL, 'K_000103-0001-0001', 'K_000103-0001', '000103', NULL, 'ハイドラ＋フォト', '1', '', 'NaN', NULL),
(211, '2024-06-29 09:47:42', '2024-06-29 09:47:42', NULL, 'K_000104-0001-0001', 'K_000104-0001', '000104', NULL, 'キャピ＋脂肪冷却', '1', '6000', '6000', NULL),
(212, '2024-06-29 10:00:21', '2024-06-29 10:00:21', NULL, 'K_000104-0002-0001', 'K_000104-0002', '000104', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(213, '2024-07-03 03:06:36', '2024-07-03 03:06:36', NULL, 'K_000043-0003-0001', 'K_000043-0003', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(216, '2024-07-05 06:56:11', '2024-07-05 06:56:11', NULL, 'K_000053-0003-0001', 'K_000053-0003', '000053', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(217, '2024-07-05 10:45:33', '2024-07-05 10:45:33', NULL, 'K_000105-0001-0001', 'K_000105-0001', '000105', NULL, 'ハイドラ＋フォト', '1', '6300', '6300', NULL),
(218, '2024-07-07 03:09:47', '2024-07-07 03:09:47', NULL, 'K_000106-0001-0001', 'K_000106-0001', '000106', NULL, 'ハイドラフェイシャル', '1', '4900', '4900', NULL),
(219, '2024-07-07 11:07:49', '2024-07-07 11:07:49', NULL, 'K_000107-0001-0001', 'K_000107-0001', '000107', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(220, '2024-07-08 04:39:30', '2024-07-08 04:39:30', NULL, 'K_000108-0001-0001', 'K_000108-0001', '000108', NULL, 'キャピ＋脂肪冷却', '1', '6600', '6600', NULL),
(221, '2024-07-08 06:03:28', '2024-07-08 06:03:28', NULL, 'K_000109-0001-0001', 'K_000109-0001', '000109', NULL, 'フォトフェイシャル', '1', '4800', '4800', NULL),
(222, '2024-07-10 05:29:05', '2024-07-10 05:29:05', NULL, 'K_000110-0001-0001', 'K_000110-0001', '000110', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(223, '2024-07-10 07:07:30', '2024-07-10 07:07:30', NULL, 'K_000111-0001-0001', 'K_000111-0001', '000111', NULL, 'ハイドラ＋フォト', '1', '6600', '6600', NULL),
(226, '2024-07-11 05:22:41', '2024-07-11 05:22:41', NULL, 'K_000112-0001-0001', 'K_000112-0001', '000112', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(227, '2024-07-14 03:39:13', '2024-07-14 03:39:13', NULL, 'K_000113-0001-0001', 'K_000113-0001', '000113', NULL, 'ハイドラ＋フォト', '1', '4500', '4500', NULL),
(228, '2024-07-14 05:11:33', '2024-07-14 05:11:33', NULL, 'K_000114-0001-0001', 'K_000114-0001', '000114', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(229, '2024-07-14 08:58:10', '2024-07-14 08:58:10', NULL, 'K_000049-0005-0001', 'K_000049-0005', '000049', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(231, '2024-07-18 03:00:39', '2024-07-18 03:00:39', NULL, 'K_000069-0003-0001', 'K_000069-0003', '000069', NULL, 'ハイドラ＋バブルパック', '1', '6000', '6000', NULL),
(232, '2024-07-18 09:39:45', '2024-07-18 09:39:45', NULL, 'K_000003-0004-0001', 'K_000003-0004', '000003', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(233, '2024-07-18 11:59:38', '2024-07-18 11:59:38', NULL, 'K_000031-0006-0001', 'K_000031-0006', '000031', NULL, 'サブスクリプション', NULL, '4000', NULL, NULL),
(234, '2024-07-18 12:01:56', '2024-07-18 12:01:56', NULL, 'K_000031-0007-0001', 'K_000031-0007', '000031', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(235, '2024-07-19 09:38:07', '2024-07-19 09:38:07', NULL, 'K_000056-0004-0001', 'K_000056-0004', '000056', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(238, '2024-07-20 06:46:55', '2024-07-20 06:46:55', NULL, 'K_000115-0001-0001', 'K_000115-0001', '000115', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(239, '2024-07-20 06:47:35', '2024-07-20 06:47:35', NULL, 'K_000115-0002-0001', 'K_000115-0002', '000115', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(241, '2024-07-20 08:52:36', '2024-07-20 08:52:36', NULL, 'K_000116-0001-0001', 'K_000116-0001', '000116', NULL, 'ハイドラ＋プラズマ＋パック', '1', '33000', '33000', NULL),
(242, '2024-07-21 05:49:24', '2024-07-21 05:49:24', NULL, 'K_000117-0001-0001', 'K_000117-0001', '000117', NULL, '全身脱毛＋顔＋VIO', '1', '3000', '3000', NULL),
(243, '2024-07-21 11:16:18', '2024-07-21 11:16:18', NULL, 'K_000118-0001-0001', 'K_000118-0001', '000118', NULL, 'ハイドラフェイシャル', '1', '4500', '4500', NULL),
(244, '2024-07-24 05:09:10', '2024-07-24 05:09:10', NULL, 'K_000071-0003-0001', 'K_000071-0003', '000071', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(246, '2024-07-24 06:44:57', '2024-07-24 06:44:57', NULL, 'K_000119-0001-0001', 'K_000119-0001', '000119', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(248, '2024-07-24 09:26:24', '2024-07-24 09:26:24', NULL, 'K_000055-0004-0001', 'K_000055-0004', '000055', NULL, 'サブスクリプション', NULL, '9000', NULL, NULL),
(249, '2024-07-26 03:54:50', '2024-07-26 03:54:50', NULL, 'K_000120-0001-0001', 'K_000120-0001', '000120', NULL, 'フォトフェイシャル', '1', '5000', '5000', NULL),
(251, '2024-07-27 06:08:26', '2024-07-27 06:08:26', NULL, 'K_000121-0001-0001', 'K_000121-0001', '000121', NULL, 'ハイドラ＋フォト', '1', '5600', '5600', NULL),
(252, '2024-07-27 06:09:39', '2024-07-27 06:09:39', NULL, 'K_000121-0002-0001', 'K_000121-0002', '000121', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(254, '2024-07-27 07:32:12', '2024-07-27 07:32:12', NULL, 'K_000114-0002-0001', 'K_000114-0002', '000114', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(255, '2024-07-27 07:32:36', '2024-07-27 07:32:36', NULL, 'K_000076-0004-0001', 'K_000076-0004', '000076', NULL, 'サブスクリプション', NULL, '10000', NULL, NULL),
(256, '2024-07-27 08:13:06', '2024-07-27 08:13:06', NULL, 'K_000040-0004-0001', 'K_000040-0004', '000040', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(258, '2024-07-27 10:14:08', '2024-07-27 10:14:08', NULL, 'K_000122-0001-0001', 'K_000122-0001', '000122', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(259, '2024-07-28 03:28:02', '2024-07-28 03:28:02', NULL, 'K_000123-0001-0001', 'K_000123-0001', '000123', NULL, 'ハイドラ＋プラズマ＋パック', '1', '7500', '7500', NULL),
(260, '2024-07-28 08:01:56', '2024-07-28 08:01:56', NULL, 'K_000049-0006-0001', 'K_000049-0006', '000049', NULL, 'キャピテーション', '1', '5000', '5000', NULL),
(261, '2024-07-29 04:23:19', '2024-07-29 04:23:19', NULL, 'K_000124-0001-0001', 'K_000124-0001', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(262, '2024-07-29 04:24:11', '2024-07-29 04:24:11', NULL, 'K_000043-0004-0001', 'K_000043-0004', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(263, '2024-07-29 06:58:22', '2024-07-29 06:58:22', NULL, 'K_000125-0001-0001', 'K_000125-0001', '000125', NULL, '脂肪冷却', '1', '4700', '4700', NULL),
(264, '2024-07-29 06:59:28', '2024-07-29 06:59:28', NULL, 'K_000125-0002-0001', 'K_000125-0002', '000125', NULL, 'サブスクリプション', NULL, '15300', NULL, NULL),
(265, '2024-07-29 09:19:25', '2024-07-29 09:19:25', NULL, 'K_000126-0001-0001', 'K_000126-0001', '000126', NULL, '脂肪冷却＋ハイドラ', '1', '9000', '9000', NULL),
(266, '2024-07-29 09:20:15', '2024-07-29 09:20:15', NULL, 'K_000126-0002-0001', 'K_000126-0002', '000126', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(267, '2024-07-31 04:16:14', '2024-07-31 04:16:14', NULL, 'K_000022-0005-0001', 'K_000022-0005', '000022', NULL, 'リポレーザー', '1', '1000', '1000', NULL),
(268, '2024-08-01 10:07:05', '2024-08-01 10:07:05', NULL, 'K_000118-0002-0001', 'K_000118-0002', '000118', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(269, '2024-08-01 10:07:47', '2024-08-01 10:07:47', NULL, 'K_000118-0003-0001', 'K_000118-0003', '000118', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(270, '2024-08-01 10:08:52', '2024-08-01 10:08:52', NULL, 'K_000118-0004-0001', 'K_000118-0004', '000118', NULL, 'サブスクリプション', NULL, '10000', NULL, NULL),
(273, '2024-08-03 03:18:16', '2024-08-03 03:18:16', NULL, 'K_000127-0001-0001', 'K_000127-0001', '000127', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(274, '2024-08-03 03:18:58', '2024-08-03 03:18:58', NULL, 'K_000127-0002-0001', 'K_000127-0002', '000127', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(275, '2024-08-03 05:22:22', '2024-08-03 05:22:22', NULL, 'K_000128-0001-0001', 'K_000128-0001', '000128', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(277, '2024-08-03 07:05:49', '2024-08-03 07:05:49', NULL, 'K_000129-0001-0001', 'K_000129-0001', '000129', NULL, 'ハイドラ＋フォト', '1', '6200', '6200', NULL),
(278, '2024-08-05 02:51:09', '2024-08-05 02:51:09', NULL, 'K_000130-0001-0001', 'K_000130-0001', '000130', NULL, '脂肪冷却', '1', '5400', '5400', NULL),
(279, '2024-08-05 07:11:36', '2024-08-05 07:11:36', NULL, 'K_000131-0001-0001', 'K_000131-0001', '000131', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(280, '2024-08-07 05:07:22', '2024-08-07 05:07:22', NULL, 'K_000112-0002-0001', 'K_000112-0002', '000112', NULL, '脂肪冷却＋ハイドラ', '1', '8000', '8000', NULL),
(282, '2024-08-09 04:59:45', '2024-08-09 04:59:45', NULL, 'K_000069-0004-0001', 'K_000069-0004', '000069', NULL, 'キャピテーション', '1', '5000', '5000', NULL),
(284, '2024-08-09 07:49:17', '2024-08-09 07:49:17', NULL, 'K_000122-0002-0001', 'K_000122-0002', '000122', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(285, '2024-08-09 09:49:46', '2024-08-09 09:49:46', NULL, 'K_000132-0001-0001', 'K_000132-0001', '000132', NULL, 'ハイドラ＋フォト', '1', '7000', '7000', NULL),
(286, '2024-08-11 09:17:16', '2024-08-11 09:17:16', NULL, 'K_000133-0001-0001', 'K_000133-0001', '000133', NULL, 'キャピ＋脂肪冷却', '1', '7500', '7500', NULL),
(287, '2024-08-12 04:11:58', '2024-08-12 04:11:58', NULL, 'K_000134-0001-0001', 'K_000134-0001', '000134', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(288, '2024-08-18 03:23:12', '2024-08-18 03:23:12', NULL, 'K_000135-0001-0001', 'K_000135-0001', '000135', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(289, '2024-08-18 03:25:56', '2024-08-18 03:25:56', NULL, 'K_000135-0002-0001', 'K_000135-0002', '000135', NULL, 'サブスクリプション', NULL, '14000', NULL, NULL),
(290, '2024-08-18 05:43:54', '2024-08-18 05:43:54', NULL, 'K_000136-0001-0001', 'K_000136-0001', '000136', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(292, '2024-08-18 08:55:26', '2024-08-18 08:55:26', NULL, 'K_000049-0007-0001', 'K_000049-0007', '000049', NULL, 'サブスクリプション', NULL, '7000', NULL, NULL),
(293, '2024-08-18 08:56:48', '2024-08-18 08:56:48', NULL, 'K_000049-0008-0001', 'K_000049-0008', '000049', NULL, '全身脱毛＋顔＋VIO', '1', '12000', '12000', NULL),
(294, '2024-08-19 02:26:15', '2024-08-19 02:26:15', NULL, 'K_000043-0005-0001', 'K_000043-0005', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(295, '2024-08-19 02:28:58', '2024-08-19 02:28:58', NULL, 'K_000124-0002-0001', 'K_000124-0002', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(297, '2024-08-21 06:20:04', '2024-08-21 06:20:04', NULL, 'K_000083-0002-0001', 'K_000083-0002', '000083', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(299, '2024-08-21 09:57:42', '2024-08-21 09:57:42', NULL, 'K_000010-0003-0001', 'K_000010-0003', '000010', NULL, 'ハイドラ＋プラズマ＋パック', '1', '5000', '5000', NULL),
(300, '2024-08-22 09:35:20', '2024-08-22 09:35:20', NULL, 'K_000137-0001-0001', 'K_000137-0001', '000137', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(301, '2024-08-23 03:07:28', '2024-08-23 03:07:28', NULL, 'K_000106-0002-0001', 'K_000106-0002', '000106', NULL, '脂肪冷却＋ハイドラ', '1', '8000', '8000', NULL),
(302, '2024-08-23 08:07:51', '2024-08-23 08:07:51', NULL, 'K_000030-0002-0001', 'K_000030-0002', '000030', NULL, '脂肪冷却＋ハイドラ', '1', '8000', '8000', NULL),
(303, '2024-08-23 09:15:21', '2024-08-23 09:15:21', NULL, 'K_000071-0004-0001', 'K_000071-0004', '000071', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(304, '2024-08-24 03:27:23', '2024-08-24 03:27:23', NULL, 'K_000138-0001-0001', 'K_000138-0001', '000138', NULL, 'ハイドラ＋フォト', '1', '5000', '5000', NULL),
(305, '2024-08-25 09:40:50', '2024-08-25 09:40:50', NULL, 'K_000139-0001-0001', 'K_000139-0001', '000139', NULL, '脂肪冷却＋ハイドラ', '1', '9000', '9000', NULL),
(306, '2024-08-26 03:30:49', '2024-08-26 03:30:49', NULL, 'K_000140-0001-0001', 'K_000140-0001', '000140', NULL, '全身脱毛＋顔＋VIO', '1', '6300', '6300', NULL),
(307, '2024-08-26 04:29:55', '2024-08-26 04:29:55', NULL, 'K_000120-0002-0001', 'K_000120-0002', '000120', NULL, 'サブスクリプション', NULL, '10000', NULL, NULL),
(308, '2024-08-26 10:12:21', '2024-08-26 10:12:21', NULL, 'K_000141-0001-0001', 'K_000141-0001', '000141', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(309, '2024-08-28 03:55:45', '2024-08-28 03:55:45', NULL, 'K_000142-0001-0001', 'K_000142-0001', '000142', NULL, '全身脱毛＋顔＋VIO', '1', '5500', '5500', NULL),
(310, '2024-08-28 03:56:19', '2024-08-28 03:56:19', NULL, 'K_000142-0002-0001', 'K_000142-0002', '000142', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(311, '2024-08-29 03:29:40', '2024-08-29 03:29:40', NULL, 'K_000143-0001-0001', 'K_000143-0001', '000143', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(312, '2024-08-31 06:39:58', '2024-08-31 06:39:58', NULL, 'K_000144-0001-0001', 'K_000144-0001', '000144', NULL, 'ハイドラ＋フォト', '1', '0', '0', NULL),
(313, '2024-08-31 09:44:37', '2024-08-31 09:44:37', NULL, 'K_000145-0001-0001', 'K_000145-0001', '000145', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(314, '2024-09-01 05:34:08', '2024-09-01 05:34:08', NULL, 'K_000146-0001-0001', 'K_000146-0001', '000146', NULL, 'ハイドラ＋プラズマ＋パック', '1', '7300', '7300', NULL),
(315, '2024-09-01 07:08:47', '2024-09-01 07:08:47', NULL, 'K_000147-0001-0001', 'K_000147-0001', '000147', NULL, 'ハイドラ＋フォト', '1', '3500', '3500', NULL),
(316, '2024-09-04 03:23:27', '2024-09-04 03:23:27', NULL, 'K_000111-0002-0001', 'K_000111-0002', '000111', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(317, '2024-09-04 08:28:55', '2024-09-04 08:28:55', NULL, 'K_000148-0001-0001', 'K_000148-0001', '000148', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(318, '2024-09-06 08:21:09', '2024-09-06 08:21:09', NULL, 'K_000122-0003-0001', 'K_000122-0003', '000122', NULL, 'サブスクリプション', NULL, '10000', NULL, NULL),
(319, '2024-09-07 03:48:20', '2024-09-07 03:48:20', NULL, 'K_000071-0005-0001', 'K_000071-0005', '000071', NULL, '脂肪冷却', '1', '6000', '6000', NULL),
(320, '2024-09-07 06:15:03', '2024-09-07 06:15:03', NULL, 'K_000149-0001-0001', 'K_000149-0001', '000149', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(321, '2024-09-07 08:32:32', '2024-09-07 08:32:32', NULL, 'K_000117-0002-0001', 'K_000117-0002', '000117', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(323, '2024-09-09 04:04:47', '2024-09-09 04:04:47', NULL, 'K_000043-0006-0001', 'K_000043-0006', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(324, '2024-09-09 04:06:42', '2024-09-09 04:06:42', NULL, 'K_000124-0003-0001', 'K_000124-0003', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '5000', '5000', NULL),
(325, '2024-09-13 06:24:20', '2024-09-13 06:24:20', NULL, 'K_000043-0007-0001', 'K_000043-0007', '000043', NULL, 'MTG', '1', '15818', '15818', NULL),
(332, '2024-09-15 03:53:08', '2024-09-15 03:53:08', NULL, 'K_000139-0002-0001', 'K_000139-0002', '000139', NULL, '脂肪冷却', '1', '16000', '16000', NULL),
(333, '2024-09-15 03:56:04', '2024-09-15 03:56:04', NULL, 'K_000139-0003-0001', 'K_000139-0003', '000139', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(334, '2024-09-15 08:37:18', '2024-09-15 08:37:18', NULL, 'K_000035-0002-0001', 'K_000035-0002', '000035', NULL, 'フォトフェイシャル', '1', '13000', '13000', NULL),
(335, '2024-09-20 10:12:02', '2024-09-20 10:12:02', NULL, 'K_000150-0001-0001', 'K_000150-0001', '000150', NULL, 'キャピ＋脂肪冷却', '1', '7700', '7700', NULL),
(337, '2024-09-21 05:30:16', '2024-09-21 05:30:16', NULL, 'K_000069-0005-0001', 'K_000069-0005', '000069', NULL, '脂肪冷却＋ハイドラ', '1', '8000', '8000', NULL),
(338, '2024-09-22 03:31:02', '2024-09-22 03:31:02', NULL, 'K_000151-0001-0001', 'K_000151-0001', '000151', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(339, '2024-09-22 03:45:54', '2024-09-22 03:45:54', NULL, 'K_000151-0002-0001', 'K_000151-0002', '000151', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(340, '2024-09-26 03:29:53', '2024-09-26 03:29:53', NULL, 'K_000108-0002-0001', 'K_000108-0002', '000108', NULL, '脂肪冷却', '1', '17000', '17000', NULL),
(341, '2024-09-29 07:30:00', '2024-09-29 07:30:00', NULL, 'K_000043-0008-0001', 'K_000043-0008', '000043', NULL, 'MTG', '1', '11700', '11700', NULL),
(342, '2024-09-29 10:37:54', '2024-09-29 10:37:54', NULL, 'K_000152-0001-0001', 'K_000152-0001', '000152', NULL, '全身脱毛＋顔＋VIO', '5', '25000', '125000', NULL),
(343, '2024-09-30 02:21:34', '2024-09-30 02:21:34', NULL, 'K_000043-0009-0001', 'K_000043-0009', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(344, '2024-09-30 02:22:27', '2024-09-30 02:22:27', NULL, 'K_000124-0004-0001', 'K_000124-0004', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(345, '2024-10-03 03:19:59', '2024-10-03 03:19:59', NULL, 'K_000153-0001-0001', 'K_000153-0001', '000153', NULL, 'キャピ＋脂肪冷却', '1', '8500', '8500', NULL),
(346, '2024-10-05 05:29:12', '2024-10-05 05:29:12', NULL, 'K_000154-0001-0001', 'K_000154-0001', '000154', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(348, '2024-10-12 06:39:17', '2024-10-12 06:39:17', NULL, 'K_000155-0001-0001', 'K_000155-0001', '000155', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(349, '2024-10-12 08:49:56', '2024-10-12 08:49:56', NULL, 'K_000156-0001-0001', 'K_000156-0001', '000156', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(350, '2024-10-13 07:08:52', '2024-10-13 07:08:52', NULL, 'K_000157-0001-0001', 'K_000157-0001', '000157', NULL, 'ハイドラフェイシャル', '1', '4800', '4800', NULL),
(351, '2024-10-13 09:30:58', '2024-10-13 09:30:58', NULL, 'K_000158-0001-0001', 'K_000158-0001', '000158', NULL, 'ハイドラ＋フォト', '1', '6000', '6000', NULL),
(353, '2024-10-14 09:26:47', '2024-10-14 09:26:47', NULL, 'K_000159-0001-0001', 'K_000159-0001', '000159', NULL, '全身脱毛＋顔＋VIO', '1', '6500', '6500', NULL),
(354, '2024-10-16 03:13:52', '2024-10-16 03:13:52', NULL, 'K_000010-0002-0001', 'K_000010-0002', '000010', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(355, '2024-10-16 09:25:27', '2024-10-16 09:25:27', NULL, 'K_000160-0001-0001', 'K_000160-0001', '000160', NULL, 'サブスクリプション', NULL, '0', NULL, NULL),
(356, '2024-10-18 03:06:01', '2024-10-18 03:06:01', NULL, 'K_000161-0001-0001', 'K_000161-0001', '000161', NULL, '全身脱毛＋顔＋VIO', '1', '5500', '5500', NULL),
(357, '2024-10-18 06:56:39', '2024-10-18 06:56:39', NULL, 'K_000127-0003-0001', 'K_000127-0003', '000127', NULL, 'サブスクリプション', NULL, '29000', NULL, NULL),
(358, '2024-10-18 06:57:47', '2024-10-18 06:57:47', NULL, 'K_000153-0002-0001', 'K_000153-0002', '000153', NULL, 'サブスクリプション', NULL, '29000', NULL, NULL),
(359, '2024-10-18 10:43:35', '2024-10-18 10:43:35', NULL, 'K_000162-0001-0001', 'K_000162-0001', '000162', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(360, '2024-10-19 07:57:09', '2024-10-19 07:57:09', NULL, 'K_000032-0002-0001', 'K_000032-0002', '000032', NULL, '次世代EMS', '1', '4000', '4000', NULL),
(362, '2024-10-21 03:55:19', '2024-10-21 03:55:19', NULL, 'K_000163-0001-0001', 'K_000163-0001', '000163', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '11000', '11000', NULL),
(363, '2024-10-23 03:57:44', '2024-10-23 03:57:44', NULL, 'K_000032-0003-0001', 'K_000032-0003', '000032', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(364, '2024-10-24 05:31:37', '2024-10-24 05:31:37', NULL, 'K_000043-0010-0001', 'K_000043-0010', '000043', NULL, '次世代EMS', '1', '4000', '4000', NULL),
(365, '2024-10-24 05:33:10', '2024-10-24 05:33:10', NULL, 'K_000124-0005-0001', 'K_000124-0005', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(367, '2024-11-03 02:57:39', '2024-11-03 02:57:39', NULL, 'K_000164-0001-0001', 'K_000164-0001', '000164', NULL, 'うなじ脱毛', '1', '3000', '3000', NULL),
(368, '2024-11-03 08:00:43', '2024-11-03 08:00:43', NULL, 'K_000038-0003-0001', 'K_000038-0003', '000038', NULL, 'フォトフェイシャル', '1', '0', '0', NULL),
(369, '2024-11-04 02:00:56', '2024-11-04 02:00:56', NULL, 'K_000040-0005-0001', 'K_000040-0005', '000040', NULL, '脂肪冷却', '1', '0', '0', NULL),
(370, '2024-11-04 03:33:21', '2024-11-04 03:33:21', NULL, 'K_000040-0006-0001', 'K_000040-0006', '000040', NULL, 'サブスクリプション', NULL, '13000', NULL, NULL),
(373, '2024-11-06 02:11:46', '2024-11-06 02:11:46', NULL, 'K_000108-0003-0001', 'K_000108-0003', '000108', NULL, '脂肪冷却', '1', '17000', '17000', NULL),
(374, '2024-11-09 10:19:39', '2024-11-09 10:19:39', NULL, 'K_000165-0001-0001', 'K_000165-0001', '000165', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(375, '2024-11-13 03:23:49', '2024-11-13 03:23:49', NULL, 'K_000166-0001-0001', 'K_000166-0001', '000166', NULL, 'ハイドラ＋プラズマ＋パック', '1', '7500', '7500', NULL),
(376, '2024-11-13 05:28:34', '2024-11-13 05:28:34', NULL, 'K_000167-0001-0001', 'K_000167-0001', '000167', NULL, '全身脱毛＋顔＋VIO', '1', '3000', '3000', NULL),
(378, '2024-11-15 02:25:37', '2024-11-15 02:25:37', NULL, 'K_000124-0006-0001', 'K_000124-0006', '000124', NULL, '全身脱毛＋顔＋VIO', '1', '5000', '5000', NULL),
(379, '2024-11-15 02:26:41', '2024-11-15 02:26:41', NULL, 'K_000043-0011-0001', 'K_000043-0011', '000043', NULL, '脂肪冷却', '1', '4000', '4000', NULL),
(380, '2024-11-16 03:06:35', '2024-11-16 03:06:35', NULL, 'K_000168-0001-0001', 'K_000168-0001', '000168', NULL, 'フォトフェイシャル', '1', '4900', '4900', NULL),
(381, '2024-11-17 06:08:04', '2024-11-17 06:08:04', NULL, 'K_000169-0001-0001', 'K_000169-0001', '000169', NULL, '次世代EMS', '1', '5500', '5500', NULL),
(382, '2024-11-18 04:34:13', '2024-11-18 04:34:13', NULL, 'K_000170-0001-0001', 'K_000170-0001', '000170', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '10500', '10500', NULL),
(383, '2024-11-22 03:40:21', '2024-11-22 03:40:21', NULL, 'K_000053-0004-0001', 'K_000053-0004', '000053', NULL, 'サブスクリプション', NULL, '8000', NULL, NULL),
(384, '2024-11-22 03:40:37', '2024-11-22 03:40:37', NULL, 'K_000053-0002-0001', 'K_000053-0002', '000053', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(385, '2024-11-23 01:38:19', '2024-11-23 01:38:19', NULL, 'K_000024-0003-0001', 'K_000024-0003', '000024', NULL, '髭脱毛', '1', '5500', '5500', NULL),
(387, '2024-11-28 07:30:54', '2024-11-28 07:30:54', NULL, 'K_000171-0001-0001', 'K_000171-0001', '000171', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(388, '2024-11-29 05:15:37', '2024-11-29 05:15:37', NULL, 'K_000172-0001-0001', 'K_000172-0001', '000172', NULL, 'ハイドラ＋フォト', '1', '5500', '5500', NULL),
(393, '2024-11-30 06:34:19', '2024-11-30 06:34:19', NULL, 'K_000170-0002-0001', 'K_000170-0002', '000170', NULL, 'サブスクリプション', NULL, '26000', NULL, NULL),
(394, '2024-12-04 01:55:15', '2024-12-04 01:55:15', NULL, 'K_000108-0004-0001', 'K_000108-0004', '000108', NULL, '脂肪冷却', '1', '17000', '17000', NULL),
(396, '2024-12-05 05:25:53', '2024-12-05 05:25:53', NULL, 'K_000010-0004-0001', 'K_000010-0004', '000010', NULL, 'ハイドラフェイシャル', '1', '0', '0', NULL),
(397, '2024-12-07 03:22:47', '2024-12-07 03:22:47', NULL, 'K_000173-0001-0001', 'K_000173-0001', '000173', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(398, '2024-12-07 03:23:28', '2024-12-07 03:23:28', NULL, 'K_000173-0002-0001', 'K_000173-0002', '000173', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(399, '2024-12-08 03:46:16', '2024-12-08 03:46:16', NULL, 'K_000174-0001-0001', 'K_000174-0001', '000174', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '10500', '10500', NULL),
(400, '2024-12-08 06:49:45', '2024-12-08 06:49:45', NULL, 'K_000175-0001-0001', 'K_000175-0001', '000175', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '0', '10400', '0', NULL),
(401, '2024-12-08 06:51:58', '2024-12-08 06:51:58', NULL, 'K_000175-0002-0001', 'K_000175-0002', '000175', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(404, '2024-12-08 07:01:15', '2024-12-08 07:01:15', NULL, 'K_000175-0003-0001', 'K_000175-0003', '000175', NULL, '発汗ドーム', '1', '2000', '2000', NULL),
(405, '2024-12-08 07:24:17', '2024-12-27 08:24:47', '2024-12-27 08:24:47', 'K_000170-0003-0001', 'K_000170-0003', '000170', NULL, 'サブスクリプション', NULL, '38400', NULL, NULL),
(406, '2024-12-13 02:45:20', '2024-12-13 02:45:20', NULL, 'K_000043-0012-0001', 'K_000043-0012', '000043', NULL, 'サブスクリプション', NULL, '4000', NULL, NULL),
(407, '2024-12-13 02:46:15', '2024-12-13 02:46:15', NULL, 'K_000124-0007-0001', 'K_000124-0007', '000124', NULL, 'サブスクリプション', NULL, '6000', NULL, NULL),
(408, '2024-12-14 08:02:10', '2024-12-14 08:02:10', NULL, 'K_000156-0002-0001', 'K_000156-0002', '000156', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(409, '2024-12-15 05:28:48', '2024-12-15 05:49:38', '2024-12-15 05:49:38', 'K_000176-0001-0001', 'K_000176-0001', '000176', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(410, '2024-12-15 05:28:53', '2024-12-15 05:28:53', NULL, 'K_000176-0002-0001', 'K_000176-0002', '000176', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(411, '2024-12-16 03:16:18', '2024-12-16 03:16:18', NULL, 'K_000038-0004-0001', 'K_000038-0004', '000038', NULL, '毛穴洗浄＋ローズパック', '1', '8000', '8000', NULL),
(412, '2024-12-16 04:58:29', '2024-12-16 04:58:29', NULL, 'K_000177-0001-0001', 'K_000177-0001', '000177', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(413, '2024-12-20 02:31:08', '2024-12-20 02:31:08', NULL, 'K_000172-0002-0001', 'K_000172-0002', '000172', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(414, '2024-12-21 06:00:49', '2024-12-21 06:00:49', NULL, 'K_000178-0001-0001', 'K_000178-0001', '000178', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(415, '2024-12-22 04:22:17', '2024-12-22 04:22:17', NULL, 'K_000049-0009-0001', 'K_000049-0009', '000049', NULL, '毛穴洗浄＋ローズパック', '1', '8000', '8000', NULL),
(416, '2024-12-22 06:36:44', '2024-12-22 06:36:44', NULL, 'K_000024-0004-0001', 'K_000024-0004', '000024', NULL, '髭脱毛', '1', '7700', '7700', NULL),
(418, '2024-12-23 03:50:33', '2024-12-23 03:50:33', NULL, 'K_000179-0001-0001', 'K_000179-0001', '000179', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '7700', '7700', NULL),
(421, '2024-12-28 03:24:57', '2024-12-28 03:24:57', NULL, 'K_000121-0003-0001', 'K_000121-0003', '000121', NULL, 'ローズパック', '1', '2000', '2000', NULL),
(423, '2024-12-29 05:37:50', '2024-12-29 05:37:50', NULL, 'K_000180-0001-0001', 'K_000180-0001', '000180', NULL, 'ハイドラ＋フォト', '1', '0', '0', NULL),
(424, '2025-01-03 05:46:42', '2025-01-03 05:46:42', NULL, 'K_000010-0005-0001', 'K_000010-0005', '000010', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(425, '2025-01-08 03:27:07', '2025-01-08 03:27:07', NULL, 'K_000142-0003-0001', 'K_000142-0003', '000142', NULL, '美容液', '1', '8140', '8140', NULL),
(426, '2025-01-10 04:50:16', '2025-01-10 04:50:16', NULL, 'K_000167-0002-0001', 'K_000167-0002', '000167', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8000', '8000', NULL),
(429, '2025-01-12 10:37:46', '2025-01-12 10:37:46', NULL, 'K_000182-0001-0001', 'K_000182-0001', '000182', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '11000', '11000', NULL),
(430, '2025-01-13 01:30:10', '2025-01-13 01:30:10', NULL, 'K_000181-0001-0001', 'K_000181-0001', '000181', NULL, '全身脱毛＋顔＋VIO', '1', '100000', '100000', NULL),
(431, '2025-01-15 08:25:46', '2025-01-15 08:25:46', NULL, 'K_000183-0001-0001', 'K_000183-0001', '000183', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(433, '2025-01-20 03:08:19', '2025-01-20 03:08:19', NULL, 'K_000184-0001-0001', 'K_000184-0001', '000184', NULL, 'キャピ＋脂肪冷却', '1', '8500', '8500', NULL),
(434, '2025-01-23 03:28:06', '2025-01-23 03:28:06', NULL, 'K_000185-0001-0001', 'K_000185-0001', '000185', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(435, '2025-01-24 09:10:39', '2025-01-24 09:10:39', NULL, 'K_000186-0001-0001', 'K_000186-0001', '000186', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(436, '2025-01-25 06:31:38', '2025-01-25 06:31:38', NULL, 'K_000040-0007-0001', 'K_000040-0007', '000040', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(437, '2025-01-25 08:29:25', '2025-01-25 08:29:25', NULL, 'K_000117-0003-0001', 'K_000117-0003', '000117', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(438, '2025-01-26 07:33:15', '2025-01-26 07:33:15', NULL, 'K_000187-0001-0001', 'K_000187-0001', '000187', NULL, '脂肪冷却', '1', '2500', '2500', NULL),
(439, '2025-01-29 05:36:22', '2025-01-29 05:36:22', NULL, 'K_000188-0001-0001', 'K_000188-0001', '000188', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(440, '2025-01-30 04:19:52', '2025-01-30 04:19:52', NULL, 'K_000127-0004-0001', 'K_000127-0004', '000127', NULL, 'キャピテーション', '1', '0', '0', NULL),
(442, '2025-01-31 08:36:25', '2025-01-31 08:36:25', NULL, 'K_000059-0003-0001', 'K_000059-0003', '000059', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL);
INSERT INTO `contract_details` (`id`, `created_at`, `updated_at`, `deleted_at`, `contract_detail_serial`, `serial_keiyaku`, `serial_user`, `serial_staff`, `keiyaku_naiyo`, `keiyaku_num`, `unit_price`, `price`, `remarks`) VALUES
(443, '2025-01-31 08:53:29', '2025-01-31 08:53:29', NULL, 'K_000176-0003-0001', 'K_000176-0003', '000176', NULL, 'ハイドラ＋プラズマ＋パック', '1', '4000', '4000', NULL),
(444, '2025-02-01 09:26:28', '2025-02-01 09:26:28', NULL, 'K_000189-0001-0001', 'K_000189-0001', '000189', NULL, 'キャピ＋脂肪冷却', '1', '8000', '8000', NULL),
(445, '2025-02-01 10:01:50', '2025-02-01 10:01:50', NULL, 'K_000189-0002-0001', 'K_000189-0002', '000189', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(446, '2025-02-05 04:43:45', '2025-02-05 04:43:45', NULL, 'K_000190-0001-0001', 'K_000190-0001', '000190', NULL, '全身脱毛＋顔＋VIO', '1', '2500', '2500', NULL),
(448, '2025-02-06 07:14:12', '2025-02-06 07:14:12', NULL, 'K_000055-0005-0001', 'K_000055-0005', '000055', NULL, 'ハイドラフェイシャル', '1', '0', '0', NULL),
(449, '2025-02-07 04:56:41', '2025-02-07 04:56:41', NULL, 'K_000056-0005-0001', 'K_000056-0005', '000056', NULL, '全身脱毛＋顔＋VIO', '1', '3000', '3000', NULL),
(450, '2025-02-07 05:12:14', '2025-02-07 05:12:14', NULL, 'K_000056-0006-0001', 'K_000056-0006', '000056', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(451, '2025-02-07 08:54:56', '2025-02-07 08:54:56', NULL, 'K_000191-0001-0001', 'K_000191-0001', '000191', NULL, 'ハイドラ＋フォト', '1', '6500', '6500', NULL),
(452, '2025-02-07 10:44:32', '2025-02-07 10:44:32', NULL, 'K_000076-0005-0001', 'K_000076-0005', '000076', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(453, '2025-02-07 10:45:41', '2025-02-07 10:45:41', NULL, 'K_000076-0006-0001', 'K_000076-0006', '000076', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(454, '2025-02-08 03:42:23', '2025-02-08 03:42:23', NULL, 'K_000038-0005-0001', 'K_000038-0005', '000038', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(458, '2025-02-08 05:13:13', '2025-02-08 05:13:13', NULL, 'K_000192-0002-0001', 'K_000192-0002', '000192', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(459, '2025-02-08 05:13:50', '2025-02-08 05:13:50', NULL, 'K_000192-0003-0001', 'K_000192-0003', '000192', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(462, '2025-02-08 05:41:14', '2025-02-08 05:41:14', NULL, 'K_000192-0001-0001', 'K_000192-0001', '000192', NULL, 'キャピ＋脂肪冷却', '1', '8500', '8500', NULL),
(464, '2025-02-08 07:22:43', '2025-02-08 07:22:43', NULL, 'K_000193-0001-0001', 'K_000193-0001', '000193', NULL, 'キャピ＋脂肪冷却', '1', '7500', '7500', NULL),
(465, '2025-02-10 05:14:35', '2025-02-10 05:14:35', NULL, 'K_000195-0001-0001', 'K_000195-0001', '000195', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(466, '2025-02-15 04:41:01', '2025-02-15 04:41:01', NULL, 'K_000053-0005-0001', 'K_000053-0005', '000053', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(467, '2025-02-15 05:35:30', '2025-02-15 05:35:30', NULL, 'K_000156-0003-0001', 'K_000156-0003', '000156', NULL, 'ハイドラ＋プラズマ＋パック', '1', '8500', '8500', NULL),
(468, '2025-02-22 10:05:37', '2025-02-22 10:05:37', NULL, 'K_000196-0001-0001', 'K_000196-0001', '000196', NULL, '脂肪冷却', '1', '5000', '5000', NULL),
(469, '2025-02-23 05:33:00', '2025-02-23 05:33:00', NULL, 'K_000197-0001-0001', 'K_000197-0001', '000197', NULL, 'ハイドラ＋フォト', '1', '4000', '4000', NULL),
(470, '2025-02-27 07:31:07', '2025-02-27 07:31:07', NULL, 'K_000198-0001-0001', 'K_000198-0001', '000198', NULL, '脂肪冷却', '1', '4800', '4800', NULL),
(471, '2025-02-27 10:33:58', '2025-02-27 10:33:58', NULL, 'K_000153-0003-0001', 'K_000153-0003', '000153', NULL, '全身脱毛＋顔＋VIO', '1', '1000', '1000', NULL),
(476, '2025-03-01 09:45:56', '2025-03-01 09:45:56', NULL, 'K_000199-0001-0001', 'K_000199-0001', '000199', NULL, '脂肪冷却＋フォト', '1', '10000', '10000', NULL),
(477, '2025-03-02 03:50:12', '2025-03-02 03:50:12', NULL, 'K_000200-0001-0001', 'K_000200-0001', '000200', NULL, 'キャピ＋脂肪冷却', '1', '7800', '7800', NULL),
(479, '2025-03-02 07:19:32', '2025-03-02 07:19:32', NULL, 'K_000201-0001-0001', 'K_000201-0001', '000201', NULL, 'ハイドラ＋フォト', '1', '3500', '3500', NULL),
(480, '2025-03-08 04:39:47', '2025-03-08 04:39:47', NULL, 'K_000059-0004-0001', 'K_000059-0004', '000059', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(481, '2025-03-12 02:49:11', '2025-03-12 02:49:11', NULL, 'K_000108-0005-0001', 'K_000108-0005', '000108', NULL, 'フォトフェイシャル', '1', '13000', '13000', NULL),
(485, '2025-03-15 05:56:48', '2025-03-15 05:56:48', NULL, 'K_000204-0001-0001', 'K_000204-0001', '000204', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '10500', '10500', NULL),
(486, '2025-03-16 08:39:03', '2025-03-16 08:39:03', NULL, 'K_000049-0010-0001', 'K_000049-0010', '000049', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(487, '2025-03-16 10:25:14', '2025-03-16 10:25:14', NULL, 'K_000058-0004-0001', 'K_000058-0004', '000058', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(488, '2025-03-21 05:50:22', '2025-03-21 05:50:22', NULL, 'K_000142-0004-0001', 'K_000142-0004', '000142', NULL, 'ハイドラフェイシャル', '1', '5000', '5000', NULL),
(489, '2025-03-24 08:20:04', '2025-03-24 08:20:04', NULL, 'K_000205-0001-0001', 'K_000205-0001', '000205', NULL, 'キャピ＋脂肪冷却', '1', '7800', '7800', NULL),
(491, '2025-03-29 07:37:45', '2025-03-29 07:37:45', NULL, 'K_000206-0001-0001', 'K_000206-0001', '000206', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '11000', '11000', NULL),
(492, '2025-03-31 03:49:13', '2025-03-31 03:49:13', NULL, 'K_000207-0001-0001', 'K_000207-0001', '000207', NULL, 'キャピ＋脂肪冷却', '1', '8500', '8500', NULL),
(493, '2025-03-31 03:51:14', '2025-03-31 03:51:14', NULL, 'K_000207-0002-0001', 'K_000207-0002', '000207', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(494, '2025-03-31 03:52:06', '2025-03-31 03:52:06', NULL, 'K_000207-0003-0001', 'K_000207-0003', '000207', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(497, '2025-04-02 03:13:59', '2025-04-02 03:13:59', NULL, 'K_000208-0001-0001', 'K_000208-0001', '000208', NULL, '脂肪冷却', '1', '5500', '5500', NULL),
(498, '2025-04-02 04:56:42', '2025-04-02 04:56:42', NULL, 'K_000202-0001-0001', 'K_000202-0001', '000202', NULL, '全身脱毛＋顔＋VIO', '1', '5000', '5000', NULL),
(501, '2025-04-04 06:01:04', '2025-04-04 06:01:04', NULL, 'K_000209-0002-0001', 'K_000209-0002', '000209', NULL, 'サブスクリプション', NULL, '7000', NULL, NULL),
(502, '2025-04-04 06:54:30', '2025-04-04 06:54:30', NULL, 'K_000209-0001-0001', 'K_000209-0001', '000209', NULL, 'ハイドラ＋フォト', '1', '3000', '3000', NULL),
(503, '2025-04-05 05:37:08', '2025-04-05 05:37:08', NULL, 'K_000210-0001-0001', 'K_000210-0001', '000210', NULL, 'ハイドラ＋フォト', '1', '3000', '3000', NULL),
(504, '2025-04-09 05:40:20', '2025-04-09 05:40:20', NULL, 'K_000053-0006-0001', 'K_000053-0006', '000053', NULL, 'ハイドラ＋フォト', '1', '3000', '3000', NULL),
(507, '2025-04-11 04:51:59', '2025-04-11 04:51:59', NULL, 'K_000211-0001-0001', 'K_000211-0001', '000211', NULL, 'ハイドラ＋フォト', '1', '3000', '3000', NULL),
(510, '2025-04-11 08:34:50', '2025-04-11 08:34:50', NULL, 'K_000183-0002-0001', 'K_000183-0002', '000183', NULL, 'ハイドラ＋フォト', '1', '3000', '3000', NULL),
(511, '2025-04-12 03:28:04', '2025-04-12 03:28:04', NULL, 'K_000212-0001-0001', 'K_000212-0001', '000212', NULL, 'キャピ＋脂肪冷却', '1', '11900', '11900', NULL),
(512, '2025-04-12 03:29:47', '2025-04-12 03:29:47', NULL, 'K_000212-0002-0001', 'K_000212-0002', '000212', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(513, '2025-04-12 03:40:16', '2025-04-12 03:40:16', NULL, 'K_000212-0003-0001', 'K_000212-0003', '000212', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(514, '2025-04-12 08:04:04', '2025-04-12 08:04:04', NULL, 'K_000213-0001-0001', 'K_000213-0001', '000213', NULL, '全身脱毛＋顔＋VIO', '1', '6500', '6500', NULL),
(515, '2025-04-17 03:02:12', '2025-04-17 03:02:12', NULL, 'K_000142-0005-0001', 'K_000142-0005', '000142', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(516, '2025-04-17 10:26:36', '2025-04-17 10:26:36', NULL, 'K_000214-0001-0001', 'K_000214-0001', '000214', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '15000', '15000', NULL),
(518, '2025-04-18 06:01:12', '2025-04-18 06:01:12', NULL, 'K_000069-0006-0001', 'K_000069-0006', '000069', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(519, '2025-04-20 08:59:46', '2025-04-20 08:59:46', NULL, 'K_000215-0001-0001', 'K_000215-0001', '000215', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(520, '2025-04-20 10:05:11', '2025-04-20 10:05:11', NULL, 'K_000215-0002-0001', 'K_000215-0002', '000215', NULL, 'サブスクリプション', NULL, '25000', NULL, NULL),
(521, '2025-04-25 02:53:26', '2025-04-25 02:53:26', NULL, 'K_000216-0001-0001', 'K_000216-0001', '000216', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(522, '2025-04-25 02:56:02', '2025-04-25 02:56:02', NULL, 'K_000216-0002-0001', 'K_000216-0002', '000216', NULL, 'サブスクリプション', NULL, '12000', NULL, NULL),
(523, '2025-04-28 03:10:04', '2025-04-28 03:10:04', NULL, 'K_000108-0006-0001', 'K_000108-0006', '000108', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(524, '2025-04-28 06:38:07', '2025-04-28 06:38:07', NULL, 'K_000217-0001-0001', 'K_000217-0001', '000217', NULL, '全身脱毛＋顔＋VIO', '1', '3000', '3000', NULL),
(525, '2025-04-28 06:39:17', '2025-04-28 06:39:17', NULL, 'K_000217-0002-0001', 'K_000217-0002', '000217', NULL, 'サブスクリプション', NULL, '10000', NULL, NULL),
(526, '2025-04-28 08:17:17', '2025-04-28 08:17:17', NULL, 'K_000019-0002-0001', 'K_000019-0002', '000019', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(527, '2025-04-30 02:55:04', '2025-04-30 02:55:04', NULL, 'K_000218-0001-0001', 'K_000218-0001', '000218', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(528, '2025-05-01 09:05:43', '2025-05-01 09:05:43', NULL, 'K_000053-0007-0001', 'K_000053-0007', '000053', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(529, '2025-05-02 02:57:26', '2025-05-02 02:57:26', NULL, 'K_000040-0008-0001', 'K_000040-0008', '000040', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(530, '2025-05-03 01:37:27', '2025-05-03 01:37:27', NULL, 'K_000181-0002-0001', 'K_000181-0002', '000181', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(532, '2025-05-07 09:45:35', '2025-05-07 09:45:35', NULL, 'K_000142-0006-0001', 'K_000142-0006', '000142', NULL, 'サブスクリプション', NULL, '13000', NULL, NULL),
(533, '2025-05-11 04:20:11', '2025-05-11 04:20:11', NULL, 'K_000211-0002-0001', 'K_000211-0002', '000211', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(534, '2025-05-14 03:18:34', '2025-05-14 03:18:34', NULL, 'K_000067-0002-0001', 'K_000067-0002', '000067', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(535, '2025-05-14 03:52:57', '2025-05-14 03:52:57', NULL, 'K_000219-0001-0001', 'K_000219-0001', '000219', NULL, 'キャピ＋脂肪冷却＋次世代EMS', '1', '15000', '15000', NULL),
(536, '2025-05-14 09:25:55', '2025-05-14 09:25:55', NULL, 'K_000220-0001-0001', 'K_000220-0001', '000220', NULL, '全身脱毛＋顔＋VIO', '1', '3800', '3800', NULL),
(537, '2025-05-15 08:29:11', '2025-05-15 08:29:11', NULL, 'K_000221-0001-0001', 'K_000221-0001', '000221', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(540, '2025-05-16 04:13:10', '2025-05-16 04:13:10', NULL, 'K_000026-0003-0001', 'K_000026-0003', '000026', NULL, 'サブスクリプション', NULL, '18000', NULL, NULL),
(541, '2025-05-17 07:05:03', '2025-05-17 07:05:03', NULL, 'K_000144-0002-0001', 'K_000144-0002', '000144', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(542, '2025-05-19 03:27:24', '2025-05-19 03:27:24', NULL, 'K_000222-0001-0001', 'K_000222-0001', '000222', NULL, 'バストアップ', '1', '3000', '3000', NULL),
(544, '2025-05-22 04:02:59', '2025-05-22 04:02:59', NULL, 'K_000223-0001-0001', 'K_000223-0001', '000223', NULL, '脂肪冷却', '1', '9900', '9900', NULL),
(545, '2025-05-22 09:07:18', '2025-05-22 09:07:18', NULL, 'K_000224-0001-0001', 'K_000224-0001', '000224', NULL, '全身脱毛＋顔＋VIO', '1', '5000', '5000', NULL),
(546, '2025-05-23 02:06:56', '2025-05-23 02:06:56', NULL, 'K_000112-0003-0001', 'K_000112-0003', '000112', NULL, 'サブスクリプション', NULL, '24000', NULL, NULL),
(553, '2025-05-23 06:34:40', '2025-05-23 06:34:40', NULL, 'K_000112-0004-0001', 'K_000112-0004', '000112', NULL, 'サブスクリプション', NULL, '', NULL, NULL),
(554, '2025-05-24 09:14:09', '2025-05-24 09:14:09', NULL, 'K_000195-0003-0001', 'K_000195-0003', '000195', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(555, '2025-05-24 09:14:13', '2025-05-24 09:14:13', NULL, 'K_000195-0002-0001', 'K_000195-0002', '000195', NULL, 'サブスクリプション', NULL, '16000', NULL, NULL),
(556, '2025-05-24 09:14:59', '2025-05-24 09:14:59', NULL, 'K_000208-0002-0001', 'K_000208-0002', '000208', NULL, 'サブスクリプション', NULL, '29000', NULL, NULL),
(557, '2025-05-24 09:15:34', '2025-05-24 09:15:34', NULL, 'K_000214-0002-0001', 'K_000214-0002', '000214', NULL, 'サブスクリプション', NULL, '35000', NULL, NULL),
(558, '2025-05-25 03:42:38', '2025-05-25 03:42:38', NULL, 'K_000222-0002-0001', 'K_000222-0002', '000222', NULL, 'サブスクリプション', NULL, '15000', NULL, NULL),
(559, '2025-05-25 09:11:27', '2025-05-25 09:11:27', NULL, 'K_000040-0009-0001', 'K_000040-0009', '000040', NULL, 'サブスクリプション', NULL, '10800', NULL, NULL),
(560, '2025-05-25 10:34:53', '2025-05-25 10:34:53', NULL, 'K_000225-0001-0001', 'K_000225-0001', '000225', NULL, 'ハイドラ＋フォト', '1', '4000', '4000', NULL),
(561, '2025-05-29 03:01:36', '2025-05-29 03:01:36', NULL, 'K_000226-0001-0001', 'K_000226-0001', '000226', NULL, 'フォトフェイシャル', '1', '2500', '2500', NULL),
(562, '2025-05-29 04:23:37', '2025-05-29 04:23:37', NULL, 'K_000226-0002-0001', 'K_000226-0002', '000226', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(563, '2025-05-29 05:25:56', '2025-05-29 05:25:56', NULL, 'K_000227-0001-0001', 'K_000227-0001', '000227', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(564, '2025-05-29 05:28:34', '2025-05-29 05:28:34', NULL, 'K_000228-0001-0001', 'K_000228-0001', '000228', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(565, '2025-05-29 06:00:27', '2025-05-29 06:00:27', NULL, 'K_000229-0001-0001', 'K_000229-0001', '000229', NULL, 'バストアップ', '1', '5000', '5000', NULL),
(566, '2025-05-30 04:15:46', '2025-05-30 04:15:46', NULL, 'K_000142-0007-0001', 'K_000142-0007', '000142', NULL, 'フォトフェイシャル', '1', '０', 'NaN', NULL),
(567, '2025-05-30 05:23:53', '2025-05-30 05:23:53', NULL, 'K_000230-0001-0001', 'K_000230-0001', '000230', NULL, '全身脱毛＋顔＋VIO', '1', '5500', '5500', NULL),
(568, '2025-05-30 05:26:21', '2025-05-30 05:26:21', NULL, 'K_000230-0002-0001', 'K_000230-0002', '000230', NULL, 'サブスクリプション', NULL, '10800', NULL, NULL),
(570, '2025-05-31 08:35:57', '2025-05-31 08:35:57', NULL, 'K_000156-0004-0001', 'K_000156-0004', '000156', NULL, '毛穴洗浄＋ローズパック', '1', '10000', '10000', NULL),
(576, '2025-05-31 09:11:58', '2025-05-31 09:11:58', NULL, 'K_000231-0002-0001', 'K_000231-0002', '000231', NULL, 'サブスクリプション', NULL, '10800', NULL, NULL),
(577, '2025-05-31 09:23:27', '2025-05-31 09:23:27', NULL, 'K_000231-0001-0001', 'K_000231-0001', '000231', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(579, '2025-06-01 05:43:12', '2025-06-01 05:43:12', NULL, 'K_000232-0001-0001', 'K_000232-0001', '000232', NULL, '顔脱毛', '1', '4500', '4500', NULL),
(580, '2025-06-01 06:17:55', '2025-06-01 06:17:55', NULL, 'K_000232-0002-0001', 'K_000232-0002', '000232', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(581, '2025-06-02 02:16:08', '2025-06-02 02:16:08', NULL, 'K_000108-0007-0001', 'K_000108-0007', '000108', NULL, '脂肪冷却', '1', '16000', '16000', NULL),
(582, '2025-06-05 03:17:10', '2025-06-05 03:17:10', NULL, 'K_000009-0006-0001', 'K_000009-0006', '000009', NULL, 'サブスクリプション', NULL, '5000', NULL, NULL),
(583, '2025-06-05 09:13:27', '2025-06-05 09:13:27', NULL, 'K_000233-0001-0001', 'K_000233-0001', '000233', NULL, '全身脱毛＋顔＋VIO', '1', '5800', '5800', NULL),
(584, '2025-06-05 09:25:42', '2025-06-05 09:25:42', NULL, 'K_000233-0002-0001', 'K_000233-0002', '000233', NULL, 'サブスクリプション', NULL, '10800', NULL, NULL),
(585, '2025-06-05 11:01:37', '2025-06-05 11:01:37', NULL, 'K_000235-0001-0001', 'K_000235-0001', '000235', NULL, '全身脱毛＋顔＋VIO', '1', '5500', '5500', NULL),
(586, '2025-06-07 02:00:42', '2025-06-07 02:00:42', NULL, 'K_000121-0004-0001', 'K_000121-0004', '000121', NULL, 'バストアップ', '1', '0', '0', NULL),
(587, '2025-06-07 08:37:12', '2025-06-07 08:37:12', NULL, 'K_000236-0001-0001', 'K_000236-0001', '000236', NULL, '全身脱毛＋顔＋VIO', '1', '6000', '6000', NULL),
(588, '2025-06-07 10:07:02', '2025-06-07 10:07:02', NULL, 'K_000236-0002-0001', 'K_000236-0002', '000236', NULL, 'サブスクリプション', NULL, '10800', NULL, NULL);

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
  `deleted_at` timestamp NULL DEFAULT NULL,
  `target_serial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '対象者シリアル',
  `target_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日付',
  `time_in` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '入出時間',
  `time_out` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '退出時間',
  `target_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '氏名',
  `staff_name_kana` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'しめい',
  `to_mail_address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '送り先メールアドレス',
  `from_mail_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '送り元メールアドレス',
  `reason_late` text COLLATE utf8mb4_unicode_ci COMMENT '遅刻理由',
  `remarks` text COLLATE utf8mb4_unicode_ci COMMENT '備考',
  `ip_address_in` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IPアドレス',
  `ip_address_out` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '退勤時IPアドレス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `in_out_histories`
--

INSERT INTO `in_out_histories` (`id`, `created_at`, `updated_at`, `deleted_at`, `target_serial`, `target_date`, `time_in`, `time_out`, `target_name`, `staff_name_kana`, `to_mail_address`, `from_mail_address`, `reason_late`, `remarks`, `ip_address_in`, `ip_address_out`) VALUES
(9, '2024-04-18 09:15:40', '2024-04-18 09:21:43', NULL, 'SF_002', '2024-04-18', '2024-04-18 18:15:40', '2024-04-18 18:21:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2024-04-19 01:03:12', '2024-04-19 10:00:09', NULL, 'SF_002', '2024-04-19', '2024-04-19 10:03:12', '2024-04-19 19:00:09', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '2024-04-20 01:58:30', '2024-04-20 10:00:01', NULL, 'SF_002', '2024-04-20', '2024-04-20 10:58:30', '2024-04-20 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2024-04-21 01:58:25', '2024-04-21 01:58:25', NULL, 'SF_002', '2024-04-21', '2024-04-21 10:58:25', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2024-04-22 01:03:36', '2024-04-22 10:59:24', NULL, 'SF_002', '2024-04-22', '2024-04-22 10:03:36', '2024-04-22 19:59:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '2024-04-24 01:58:06', '2024-04-24 11:43:43', NULL, 'SF_002', '2024-04-24', '2024-04-24 10:58:06', '2024-04-24 20:43:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2024-04-25 01:55:05', '2024-04-25 01:55:05', NULL, 'SF_002', '2024-04-25', '2024-04-25 10:55:05', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '2024-04-26 01:55:45', '2024-04-26 10:00:01', NULL, 'SF_002', '2024-04-26', '2024-04-26 10:55:45', '2024-04-26 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2024-04-27 01:57:44', '2024-04-27 10:00:16', NULL, 'SF_002', '2024-04-27', '2024-04-27 10:57:44', '2024-04-27 19:00:16', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '2024-04-28 01:22:59', '2024-04-28 01:22:59', NULL, 'SF_002', '2024-04-28', '2024-04-28 10:22:59', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '2024-04-29 01:58:07', '2024-04-29 10:00:01', NULL, 'SF_002', '2024-04-29', '2024-04-29 10:58:07', '2024-04-29 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '2024-05-01 00:56:26', '2024-05-01 00:56:26', NULL, 'SF_002', '2024-05-01', '2024-05-01 09:56:26', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '2024-05-05 01:01:22', '2024-05-05 10:16:58', NULL, 'SF_002', '2024-05-05', '2024-05-05 10:01:22', '2024-05-05 19:16:58', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '2024-05-06 01:37:48', '2024-05-06 10:00:24', NULL, 'SF_002', '2024-05-06', '2024-05-06 10:37:48', '2024-05-06 19:00:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '2024-05-08 02:04:33', '2024-05-08 02:04:33', NULL, 'SF_002', '2024-05-08', '2024-05-08 11:04:33', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '2024-05-10 01:59:44', '2024-05-10 01:59:44', NULL, 'SF_002', '2024-05-10', '2024-05-10 10:59:44', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2024-05-11 01:02:22', '2024-05-11 09:53:56', NULL, 'SF_002', '2024-05-11', '2024-05-11 10:02:22', '2024-05-11 18:53:56', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '2024-05-12 01:05:28', '2024-05-12 10:42:11', NULL, 'SF_002', '2024-05-12', '2024-05-12 10:05:28', '2024-05-12 19:42:11', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '2024-05-13 01:57:18', '2024-05-13 01:57:18', NULL, 'SF_002', '2024-05-13', '2024-05-13 10:57:18', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '2024-05-15 00:52:53', '2024-05-15 00:52:53', NULL, 'SF_002', '2024-05-15', '2024-05-15 09:52:53', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '2024-05-16 00:56:47', '2024-05-16 10:00:14', NULL, 'SF_002', '2024-05-16', '2024-05-16 09:56:47', '2024-05-16 19:00:14', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '2024-05-17 01:56:23', '2024-05-17 01:56:23', NULL, 'SF_002', '2024-05-17', '2024-05-17 10:56:23', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '2024-05-19 00:58:13', '2024-05-19 00:58:13', NULL, 'SF_002', '2024-05-19', '2024-05-19 09:58:13', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '2024-05-20 01:02:29', '2024-05-20 10:00:09', NULL, 'SF_002', '2024-05-20', '2024-05-20 10:02:29', '2024-05-20 19:00:09', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '2024-05-24 01:07:36', '2024-05-24 01:07:36', NULL, 'SF_002', '2024-05-24', '2024-05-24 10:07:36', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '2024-05-26 01:02:13', '2024-05-26 01:02:13', NULL, 'SF_002', '2024-05-26', '2024-05-26 10:02:13', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '2024-05-27 01:58:38', '2024-05-27 01:58:38', NULL, 'SF_002', '2024-05-27', '2024-05-27 10:58:38', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '2024-05-31 01:55:09', '2024-05-31 01:55:09', NULL, 'SF_002', '2024-05-31', '2024-05-31 10:55:09', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '2024-06-20 05:28:39', '2024-06-20 05:28:59', NULL, 'SF_002', '2024-06-20', '2024-06-20 14:28:39', '2024-06-20 14:28:59', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '2024-06-22 01:56:32', '2024-06-22 10:44:31', NULL, 'SF_002', '2024-06-22', '2024-06-22 10:56:32', '2024-06-22 19:44:31', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '2024-06-23 00:57:54', '2024-06-23 10:01:33', NULL, 'SF_002', '2024-06-23', '2024-06-23 09:57:54', '2024-06-23 19:01:33', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '2024-06-24 01:04:27', '2024-06-24 11:07:26', NULL, 'SF_002', '2024-06-24', '2024-06-24 10:04:27', '2024-06-24 20:07:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '2024-06-26 01:59:43', '2024-06-26 10:00:07', NULL, 'SF_002', '2024-06-26', '2024-06-26 10:59:43', '2024-06-26 19:00:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '2024-06-27 00:58:33', '2024-06-27 00:58:33', NULL, 'SF_002', '2024-06-27', '2024-06-27 09:58:33', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '2024-06-27 09:01:08', '2024-06-27 09:01:08', NULL, 'SF_003', '2024-06-27', '2024-06-27 18:01:08', NULL, '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '2024-06-28 02:00:04', '2024-06-28 10:00:18', NULL, 'SF_002', '2024-06-28', '2024-06-28 11:00:04', '2024-06-28 19:00:18', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '2024-07-01 01:56:51', '2024-07-01 10:00:05', NULL, 'SF_002', '2024-07-01', '2024-07-01 10:56:51', '2024-07-01 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '2024-07-01 07:26:09', '2024-07-01 09:30:29', NULL, 'SF_003', '2024-07-01', '2024-07-01 16:26:09', '2024-07-01 18:30:29', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '2024-07-03 02:08:22', '2024-07-03 10:00:38', NULL, 'SF_002', '2024-07-03', '2024-07-03 11:08:22', '2024-07-03 19:00:38', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '2024-07-04 01:57:37', '2024-07-04 10:17:39', NULL, 'SF_002', '2024-07-04', '2024-07-04 10:57:37', '2024-07-04 19:17:39', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '2024-07-04 07:25:53', '2024-07-04 10:17:50', NULL, 'SF_003', '2024-07-04', '2024-07-04 16:25:53', '2024-07-04 19:17:50', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '2024-07-05 01:08:49', '2024-07-05 11:08:42', NULL, 'SF_002', '2024-07-05', '2024-07-05 10:08:49', '2024-07-05 20:08:42', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '2024-07-05 07:33:52', '2024-07-05 11:08:49', NULL, 'SF_003', '2024-07-05', '2024-07-05 16:33:52', '2024-07-05 20:08:49', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '2024-07-06 01:10:33', '2024-07-06 10:00:02', NULL, 'SF_002', '2024-07-06', '2024-07-06 10:10:33', '2024-07-06 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '2024-07-07 01:05:23', '2024-07-07 11:30:15', NULL, 'SF_002', '2024-07-07', '2024-07-07 10:05:23', '2024-07-07 20:30:15', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '2024-07-07 07:58:27', '2024-07-07 11:30:21', NULL, 'SF_003', '2024-07-07', '2024-07-07 16:58:27', '2024-07-07 20:30:21', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '2024-07-08 01:11:16', '2024-07-08 09:31:48', NULL, 'SF_002', '2024-07-08', '2024-07-08 10:11:16', '2024-07-08 18:31:48', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '2024-07-10 02:05:39', '2024-07-10 10:00:05', NULL, 'SF_002', '2024-07-10', '2024-07-10 11:05:39', '2024-07-10 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '2024-07-10 07:40:59', '2024-07-10 10:00:11', NULL, 'SF_003', '2024-07-10', '2024-07-10 16:40:59', '2024-07-10 19:00:11', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '2024-07-11 01:11:06', '2024-07-11 01:11:06', NULL, 'SF_002', '2024-07-11', '2024-07-11 10:11:06', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '2024-07-13 01:59:40', '2024-07-13 09:53:48', NULL, 'SF_002', '2024-07-13', '2024-07-13 10:59:40', '2024-07-13 18:53:48', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '2024-07-14 01:05:14', '2024-07-14 10:00:17', NULL, 'SF_002', '2024-07-14', '2024-07-14 10:05:14', '2024-07-14 19:00:17', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '2024-07-14 05:53:04', '2024-07-14 09:30:18', NULL, 'SF_003', '2024-07-14', '2024-07-14 14:53:04', '2024-07-14 18:30:18', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, '2024-07-17 01:58:21', '2024-07-17 11:10:35', NULL, 'SF_002', '2024-07-17', '2024-07-17 10:58:21', '2024-07-17 20:10:35', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '2024-07-18 01:09:41', '2024-07-18 12:23:41', NULL, 'SF_002', '2024-07-18', '2024-07-18 10:09:41', '2024-07-18 21:23:41', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, '2024-07-18 07:28:41', '2024-07-18 12:24:02', NULL, 'SF_003', '2024-07-18', '2024-07-18 16:28:41', '2024-07-18 21:24:02', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, '2024-07-19 01:12:40', '2024-07-19 16:27:08', NULL, 'SF_002', '2024-07-19', '2024-07-19 10:12:40', '2024-07-19 19:13:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '2024-07-19 07:38:25', '2024-07-20 09:54:25', NULL, 'SF_003', '2024-07-19', '2024-07-19 16:38:25', '2024-07-19 19:13:46', '清藤 侑美', NULL, NULL, NULL, 'トイレに行っていたため', '16:30出勤', NULL, NULL),
(69, '2024-07-20 01:08:09', '2024-07-20 10:00:02', NULL, 'SF_002', '2024-07-20', '2024-07-20 10:08:09', '2024-07-20 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, '2024-07-21 01:08:00', '2024-07-21 11:44:54', NULL, 'SF_002', '2024-07-21', '2024-07-21 10:08:00', '2024-07-21 20:44:54', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '2024-07-21 01:21:54', '2024-07-21 06:00:20', NULL, 'SF_003', '2024-07-21', '2024-07-21 10:21:54', '2024-07-21 15:00:20', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, '2024-07-22 01:13:46', '2024-07-22 09:24:45', NULL, 'SF_002', '2024-07-22', '2024-07-22 10:13:46', '2024-07-22 18:24:45', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, '2024-07-24 03:08:27', '2024-07-24 11:00:20', NULL, 'SF_002', '2024-07-24', '2024-07-24 12:08:27', '2024-07-24 20:00:20', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, '2024-07-25 01:13:45', '2024-07-25 09:45:08', NULL, 'SF_002', '2024-07-25', '2024-07-25 10:13:45', '2024-07-25 18:45:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, '2024-07-25 07:30:20', '2024-07-25 09:45:02', NULL, 'SF_003', '2024-07-25', '2024-07-25 16:30:20', '2024-07-25 18:45:02', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, '2024-07-26 01:56:40', '2024-07-26 09:44:54', NULL, 'SF_002', '2024-07-26', '2024-07-26 10:56:40', '2024-07-26 18:44:54', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '2024-07-27 02:22:17', '2024-07-27 10:38:40', NULL, 'SF_002', '2024-07-27', '2024-07-27 11:22:17', '2024-07-27 19:38:40', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, '2024-07-27 02:56:56', '2024-07-27 10:38:45', NULL, 'SF_003', '2024-07-27', '2024-07-27 11:56:56', '2024-07-27 19:38:45', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, '2024-07-28 01:08:41', '2024-07-28 10:00:02', NULL, 'SF_002', '2024-07-28', '2024-07-28 10:08:41', '2024-07-28 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, '2024-07-29 02:04:17', '2024-07-29 10:11:07', NULL, 'SF_002', '2024-07-29', '2024-07-29 11:04:17', '2024-07-29 19:11:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, '2024-07-31 01:01:08', '2024-07-31 11:15:28', NULL, 'SF_002', '2024-07-31', '2024-07-31 10:01:08', '2024-07-31 20:15:28', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, '2024-07-31 07:35:00', '2024-07-31 11:15:19', NULL, 'SF_003', '2024-07-31', '2024-07-31 16:35:00', '2024-07-31 20:15:19', '清藤 侑美', NULL, NULL, NULL, '大雨のため', '16:30出勤', NULL, NULL),
(83, '2024-08-01 01:12:00', '2024-08-01 10:47:21', NULL, 'SF_002', '2024-08-01', '2024-08-01 10:12:00', '2024-08-01 19:47:21', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, '2024-08-01 08:03:54', '2024-08-29 04:37:38', NULL, 'SF_003', '2024-08-01', '2024-08-01 17:03:54', '2024-08-01 16:30:26', '清藤 侑美', NULL, NULL, NULL, NULL, '押し忘れ（16:30出勤）', NULL, NULL),
(85, '2024-08-02 02:03:48', '2024-08-11 07:47:37', NULL, 'SF_002', '2024-08-02', '2024-08-02 11:03:48', '2024-08-02 18:40:17', '川島 花乃', NULL, NULL, NULL, NULL, '大雨のため', NULL, NULL),
(86, '2024-08-03 01:09:45', '2024-08-11 07:47:27', NULL, 'SF_002', '2024-08-03', '2024-08-03 10:09:45', '2024-08-03 18:37:33', '川島 花乃', NULL, NULL, NULL, NULL, '大雨のため', NULL, NULL),
(87, '2024-08-03 01:23:04', '2024-08-03 07:30:31', NULL, 'SF_003', '2024-08-03', '2024-08-03 10:23:04', '2024-08-03 16:30:31', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '2024-08-04 02:02:25', '2024-08-11 07:18:22', NULL, 'SF_002', '2024-08-04', '2024-08-04 11:02:25', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(89, '2024-08-05 01:08:13', '2024-08-11 07:46:32', NULL, 'SF_002', '2024-08-05', '2024-08-05 10:08:13', '2024-08-05 17:01:03', '川島 花乃', NULL, NULL, NULL, NULL, '眼科のため(17:00退勤)', NULL, NULL),
(90, '2024-08-07 02:07:34', '2024-08-07 10:00:01', NULL, 'SF_002', '2024-08-07', '2024-08-07 11:07:34', '2024-08-07 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, '2024-08-10 01:04:53', '2024-08-10 10:00:12', NULL, 'SF_002', '2024-08-10', '2024-08-10 10:04:53', '2024-08-10 19:00:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, '2024-08-10 01:26:34', '2024-08-10 10:00:08', NULL, 'SF_003', '2024-08-10', '2024-08-10 10:26:34', '2024-08-10 19:00:08', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, '2024-08-12 01:03:28', '2024-08-12 10:00:19', NULL, 'SF_002', '2024-08-12', '2024-08-12 10:03:28', '2024-08-12 19:00:19', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, '2024-08-17 01:08:04', '2024-08-17 10:00:02', NULL, 'SF_002', '2024-08-17', '2024-08-17 10:08:04', '2024-08-17 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, '2024-08-18 01:05:44', '2024-08-18 10:00:03', NULL, 'SF_002', '2024-08-18', '2024-08-18 10:05:44', '2024-08-18 19:00:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, '2024-08-18 06:02:54', '2024-08-18 10:00:14', NULL, 'SF_003', '2024-08-18', '2024-08-18 15:02:54', '2024-08-18 19:00:14', '清藤 侑美', NULL, NULL, NULL, '道が混んでいたため', '15：00出勤', NULL, NULL),
(97, '2024-08-19 01:57:30', '2024-08-21 09:15:47', NULL, 'SF_002', '2024-08-19', '2024-08-19 10:57:30', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(98, '2024-08-21 00:53:52', '2024-08-21 10:14:56', NULL, 'SF_002', '2024-08-21', '2024-08-21 09:53:52', '2024-08-21 19:14:56', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, '2024-08-21 07:23:59', '2024-08-21 10:15:01', NULL, 'SF_003', '2024-08-21', '2024-08-21 16:23:59', '2024-08-21 19:15:01', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, '2024-08-22 01:01:48', '2024-08-22 09:51:21', NULL, 'SF_002', '2024-08-22', '2024-08-22 10:01:48', '2024-08-22 18:51:21', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, '2024-08-22 07:26:07', '2024-08-22 09:51:26', NULL, 'SF_003', '2024-08-22', '2024-08-22 16:26:07', '2024-08-22 18:51:26', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, '2024-08-23 00:59:44', '2024-08-23 11:21:10', NULL, 'SF_002', '2024-08-23', '2024-08-23 09:59:44', '2024-08-23 20:21:10', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, '2024-08-23 07:15:07', '2024-08-23 11:21:15', NULL, 'SF_003', '2024-08-23', '2024-08-23 16:15:07', '2024-08-23 20:21:15', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, '2024-08-24 01:00:02', '2024-08-24 10:03:33', NULL, 'SF_002', '2024-08-24', '2024-08-24 10:00:02', '2024-08-24 19:03:33', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '2024-08-25 01:57:43', '2024-08-25 10:00:03', NULL, 'SF_002', '2024-08-25', '2024-08-25 10:57:43', '2024-08-25 19:00:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, '2024-08-26 00:55:01', '2024-08-26 11:00:05', NULL, 'SF_002', '2024-08-26', '2024-08-26 09:55:01', '2024-08-26 20:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, '2024-08-26 07:26:59', '2024-08-26 11:00:11', NULL, 'SF_003', '2024-08-26', '2024-08-26 16:26:59', '2024-08-26 20:00:11', '清藤 侑美', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, '2024-08-28 01:00:04', '2024-08-28 10:44:33', NULL, 'SF_002', '2024-08-28', '2024-08-28 10:00:04', '2024-08-28 19:44:33', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, '2024-08-29 01:02:08', '2024-08-29 09:06:43', NULL, 'SF_002', '2024-08-29', '2024-08-29 10:02:08', '2024-08-29 18:06:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, '2024-08-31 02:01:33', '2024-08-31 10:08:51', NULL, 'SF_002', '2024-08-31', '2024-08-31 11:01:33', '2024-08-31 19:08:51', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, '2024-09-01 01:56:29', '2024-09-01 10:00:00', NULL, 'SF_002', '2024-09-01', '2024-09-01 10:56:29', '2024-09-01 19:00:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, '2024-09-04 00:51:14', '2024-09-20 04:21:19', NULL, 'SF_002', '2024-09-04', '2024-09-04 09:51:14', '2024-09-04 18:51:46', '川島 花乃', NULL, NULL, NULL, NULL, '会食の為', NULL, NULL),
(113, '2024-09-05 01:12:44', '2024-09-05 10:53:36', NULL, 'SF_002', '2024-09-05', '2024-09-05 10:12:44', '2024-09-05 19:53:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, '2024-09-06 01:54:36', '2024-09-06 10:36:02', NULL, 'SF_002', '2024-09-06', '2024-09-06 10:54:36', '2024-09-06 19:36:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, '2024-09-07 01:10:34', '2024-09-20 04:21:25', NULL, 'SF_002', '2024-09-07', '2024-09-07 10:10:34', '2024-09-07 18:38:42', '川島 花乃', NULL, NULL, NULL, NULL, '会食の為', NULL, NULL),
(116, '2024-09-08 01:56:24', '2024-09-08 10:00:12', NULL, 'SF_002', '2024-09-08', '2024-09-08 10:56:24', '2024-09-08 19:00:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, '2024-09-12 01:57:58', '2024-09-12 10:00:16', NULL, 'SF_002', '2024-09-12', '2024-09-12 10:57:58', '2024-09-12 19:00:16', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, '2024-09-13 01:55:43', '2024-09-13 10:31:26', NULL, 'SF_002', '2024-09-13', '2024-09-13 10:55:43', '2024-09-13 19:31:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, '2024-09-14 01:53:48', '2024-09-14 10:00:44', NULL, 'SF_002', '2024-09-14', '2024-09-14 10:53:48', '2024-09-14 19:00:44', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, '2024-09-15 01:55:01', '2024-09-15 10:00:12', NULL, 'SF_002', '2024-09-15', '2024-09-15 10:55:01', '2024-09-15 19:00:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, '2024-09-16 01:01:39', '2024-09-16 10:00:07', NULL, 'SF_002', '2024-09-16', '2024-09-16 10:01:39', '2024-09-16 19:00:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, '2024-09-19 00:59:39', '2024-09-20 04:20:25', NULL, 'SF_002', '2024-09-19', '2024-09-19 09:59:39', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(123, '2024-09-20 01:04:20', '2024-09-20 10:40:02', NULL, 'SF_002', '2024-09-20', '2024-09-20 10:04:20', '2024-09-20 19:40:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, '2024-09-21 01:08:03', '2024-09-21 10:00:07', NULL, 'SF_002', '2024-09-21', '2024-09-21 10:08:03', '2024-09-21 19:00:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, '2024-09-22 01:34:57', '2024-09-22 10:00:04', NULL, 'SF_002', '2024-09-22', '2024-09-22 10:34:57', '2024-09-22 19:00:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, '2024-09-25 01:07:27', '2024-09-25 10:01:04', NULL, 'SF_002', '2024-09-25', '2024-09-25 10:07:27', '2024-09-25 19:01:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, '2024-09-26 00:54:43', '2024-09-26 10:00:50', NULL, 'SF_002', '2024-09-26', '2024-09-26 09:54:43', '2024-09-26 19:00:50', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, '2024-09-27 01:57:47', '2024-09-27 09:36:07', NULL, 'SF_002', '2024-09-27', '2024-09-27 10:57:47', '2024-09-27 18:35:52', '川島 花乃', NULL, NULL, NULL, NULL, '会食の為', NULL, NULL),
(129, '2024-09-28 01:37:26', '2024-09-28 10:41:36', NULL, 'SF_002', '2024-09-28', '2024-09-28 10:37:26', '2024-09-28 19:41:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, '2024-10-02 04:36:18', '2024-10-02 10:49:00', NULL, 'SF_002', '2024-10-02', '2024-10-02 13:36:18', '2024-10-02 19:49:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, '2024-10-09 10:02:29', '2024-10-09 10:02:29', NULL, 'SF_002', '2024-10-09', '2024-10-09 19:02:29', NULL, '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, '2024-10-11 01:09:25', '2024-10-11 10:00:04', NULL, 'SF_002', '2024-10-11', '2024-10-11 10:09:25', '2024-10-11 19:00:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, '2024-10-31 02:38:50', '2024-10-31 10:10:03', NULL, 'SF_002', '2024-10-31', '2024-10-31 11:38:50', '2024-10-31 19:10:03', '川島 花乃', NULL, NULL, NULL, NULL, 'テスト(実際9：55出勤)', NULL, NULL),
(134, '2024-11-01 00:59:07', '2024-11-01 10:00:05', NULL, 'SF_002', '2024-11-01', '2024-11-01 09:59:07', '2024-11-01 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, '2024-11-02 01:57:45', '2024-11-02 10:00:07', NULL, 'SF_002', '2024-11-02', '2024-11-02 10:57:45', '2024-11-02 19:00:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, '2024-11-03 01:11:10', '2024-11-03 10:00:01', NULL, 'SF_002', '2024-11-03', '2024-11-03 10:11:10', '2024-11-03 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, '2024-11-04 00:52:26', '2024-11-06 01:03:55', NULL, 'SF_002', '2024-11-04', '2024-11-04 09:52:26', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(138, '2024-11-06 01:03:09', '2024-11-06 10:00:15', NULL, 'SF_002', '2024-11-06', '2024-11-06 10:03:09', '2024-11-06 19:00:15', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, '2024-11-07 01:09:40', '2024-11-07 10:19:44', NULL, 'SF_002', '2024-11-07', '2024-11-07 10:09:40', '2024-11-07 19:19:44', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, '2024-11-09 01:55:46', '2024-11-09 10:22:03', NULL, 'SF_002', '2024-11-09', '2024-11-09 10:55:46', '2024-11-09 19:22:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, '2024-11-13 00:57:41', '2024-11-13 10:00:03', NULL, 'SF_002', '2024-11-13', '2024-11-13 09:57:41', '2024-11-13 19:00:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, '2024-11-14 01:52:53', '2024-11-14 10:28:54', NULL, 'SF_002', '2024-11-14', '2024-11-14 10:52:53', '2024-11-14 19:28:54', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, '2024-11-15 01:54:23', '2024-11-15 10:21:58', NULL, 'SF_002', '2024-11-15', '2024-11-15 10:54:23', '2024-11-15 19:21:58', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, '2024-11-16 01:09:28', '2024-11-16 10:00:02', NULL, 'SF_002', '2024-11-16', '2024-11-16 10:09:28', '2024-11-16 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, '2024-11-17 01:54:16', '2024-11-17 10:00:18', NULL, 'SF_002', '2024-11-17', '2024-11-17 10:54:16', '2024-11-17 19:00:18', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, '2024-11-18 01:38:05', '2024-11-18 10:38:51', NULL, 'SF_002', '2024-11-18', '2024-11-18 10:38:05', '2024-11-18 19:38:51', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, '2024-11-20 01:56:06', '2024-11-20 10:34:15', NULL, 'SF_002', '2024-11-20', '2024-11-20 10:56:06', '2024-11-20 19:34:15', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, '2024-11-21 01:58:06', '2024-11-21 10:13:24', NULL, 'SF_002', '2024-11-21', '2024-11-21 10:58:06', '2024-11-21 19:13:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, '2024-11-22 01:56:37', '2024-11-22 10:00:31', NULL, 'SF_002', '2024-11-22', '2024-11-22 10:56:37', '2024-11-22 19:00:31', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, '2024-11-23 01:08:21', '2024-11-24 01:57:56', NULL, 'SF_002', '2024-11-23', '2024-11-23 10:08:21', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(151, '2024-11-24 01:57:13', '2024-11-24 10:01:06', NULL, 'SF_002', '2024-11-24', '2024-11-24 10:57:13', '2024-11-24 19:01:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, '2024-11-25 01:59:43', '2024-11-25 10:08:24', NULL, 'SF_002', '2024-11-25', '2024-11-25 10:59:43', '2024-11-25 19:08:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, '2024-11-27 01:06:15', '2024-11-27 10:15:09', NULL, 'SF_002', '2024-11-27', '2024-11-27 10:06:15', '2024-11-27 19:15:09', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, '2024-11-28 01:59:13', '2024-11-28 10:01:43', NULL, 'SF_002', '2024-11-28', '2024-11-28 10:59:13', '2024-11-28 19:01:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, '2024-11-29 01:59:25', '2024-11-30 01:10:46', NULL, 'SF_002', '2024-11-29', '2024-11-29 10:59:25', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '退勤押し忘れ(19:00退勤)', NULL, NULL),
(156, '2024-11-30 01:10:15', '2024-11-30 10:00:17', NULL, 'SF_002', '2024-11-30', '2024-11-30 10:10:15', '2024-11-30 19:00:17', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, '2024-12-01 01:10:54', '2024-12-01 10:02:08', NULL, 'SF_002', '2024-12-01', '2024-12-01 10:10:54', '2024-12-01 19:02:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, '2024-12-02 01:59:33', '2024-12-02 10:01:05', NULL, 'SF_002', '2024-12-02', '2024-12-02 10:59:33', '2024-12-02 19:01:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, '2024-12-02 07:56:38', '2024-12-02 10:01:15', NULL, 'SF_004', '2024-12-02', '2024-12-02 16:56:38', '2024-12-02 19:01:15', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, '2024-12-04 00:57:54', '2024-12-04 10:01:08', NULL, 'SF_002', '2024-12-04', '2024-12-04 09:57:54', '2024-12-04 19:01:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, '2024-12-05 01:16:04', '2024-12-05 10:00:32', NULL, 'SF_002', '2024-12-05', '2024-12-05 10:16:04', '2024-12-05 19:00:32', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, '2024-12-06 01:57:48', '2024-12-06 10:19:03', NULL, 'SF_002', '2024-12-06', '2024-12-06 10:57:48', '2024-12-06 19:19:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, '2024-12-07 01:11:03', '2024-12-07 10:17:03', NULL, 'SF_002', '2024-12-07', '2024-12-07 10:11:03', '2024-12-07 19:17:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, '2024-12-08 01:08:51', '2024-12-08 10:01:07', NULL, 'SF_002', '2024-12-08', '2024-12-08 10:08:51', '2024-12-08 19:01:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, '2024-12-09 01:57:10', '2024-12-09 10:27:12', NULL, 'SF_002', '2024-12-09', '2024-12-09 10:57:10', '2024-12-09 19:27:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, '2024-12-12 01:59:09', '2024-12-12 10:18:39', NULL, 'SF_002', '2024-12-12', '2024-12-12 10:59:09', '2024-12-12 19:18:39', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, '2024-12-12 08:26:40', '2024-12-12 10:19:07', NULL, 'SF_004', '2024-12-12', '2024-12-12 17:26:40', '2024-12-12 19:19:07', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, '2024-12-13 02:00:01', '2024-12-13 10:03:03', NULL, 'SF_002', '2024-12-13', '2024-12-13 11:00:01', '2024-12-13 19:03:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, '2024-12-15 09:42:28', '2024-12-16 01:12:28', NULL, 'SF_002', '2024-12-15', '2024-12-15 18:42:28', '2024-12-15 19:20:47', '川島 花乃', NULL, NULL, NULL, NULL, 'スキャナー不具合(10:56出勤)', NULL, NULL),
(170, '2024-12-15 10:21:45', '2024-12-16 01:12:20', NULL, 'SF_004', '2024-12-15', '2024-12-15 19:21:45', '2024-12-15 19:22:06', '田熊 柊花', NULL, NULL, NULL, NULL, 'スキャナー不具合(18:00出勤)', NULL, NULL),
(171, '2024-12-16 01:10:34', '2024-12-16 10:04:06', NULL, 'SF_002', '2024-12-16', '2024-12-16 10:10:34', '2024-12-16 19:04:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, '2024-12-18 02:04:26', '2024-12-18 10:26:21', NULL, 'SF_002', '2024-12-18', '2024-12-18 11:04:26', '2024-12-18 19:26:21', '川島 花乃', NULL, NULL, NULL, '渋滞の為', NULL, NULL, NULL),
(173, '2024-12-19 01:59:36', '2024-12-19 10:20:02', NULL, 'SF_002', '2024-12-19', '2024-12-19 10:59:36', '2024-12-19 19:20:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, '2024-12-19 08:03:08', '2024-12-19 10:20:21', NULL, 'SF_004', '2024-12-19', '2024-12-19 17:03:08', '2024-12-19 19:20:21', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, '2024-12-20 01:56:56', '2024-12-20 10:14:58', NULL, 'SF_002', '2024-12-20', '2024-12-20 10:56:56', '2024-12-20 19:14:58', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, '2024-12-20 07:59:04', '2024-12-20 10:15:04', NULL, 'SF_004', '2024-12-20', '2024-12-20 16:59:04', '2024-12-20 19:15:04', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, '2024-12-21 01:56:38', '2024-12-21 10:00:05', NULL, 'SF_002', '2024-12-21', '2024-12-21 10:56:38', '2024-12-21 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, '2024-12-22 01:56:19', '2024-12-22 11:01:25', NULL, 'SF_002', '2024-12-22', '2024-12-22 10:56:19', '2024-12-22 20:01:25', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, '2024-12-23 01:09:39', '2024-12-23 10:00:32', NULL, 'SF_002', '2024-12-23', '2024-12-23 10:09:39', '2024-12-23 19:00:32', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, '2024-12-23 05:26:00', '2024-12-23 10:00:37', NULL, 'SF_004', '2024-12-23', '2024-12-23 14:26:00', '2024-12-23 19:00:37', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, '2024-12-25 01:56:47', '2024-12-25 10:19:25', NULL, 'SF_002', '2024-12-25', '2024-12-25 10:56:47', '2024-12-25 19:19:25', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, '2024-12-26 01:56:38', '2024-12-26 10:06:58', NULL, 'SF_002', '2024-12-26', '2024-12-26 10:56:38', '2024-12-26 19:06:58', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, '2024-12-27 01:57:36', '2024-12-27 10:00:09', NULL, 'SF_002', '2024-12-27', '2024-12-27 10:57:36', '2024-12-27 19:00:09', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, '2024-12-28 01:15:57', '2024-12-28 10:01:11', NULL, 'SF_002', '2024-12-28', '2024-12-28 10:15:57', '2024-12-28 19:01:11', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, '2024-12-29 01:23:03', '2024-12-29 10:02:39', NULL, 'SF_002', '2024-12-29', '2024-12-29 10:23:03', '2024-12-29 19:02:39', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, '2025-01-06 01:46:41', '2025-01-06 11:09:48', NULL, 'SF_002', '2025-01-06', '2025-01-06 10:46:41', '2025-01-06 20:09:48', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, '2025-01-06 08:15:16', '2025-01-06 11:09:55', NULL, 'SF_004', '2025-01-06', '2025-01-06 17:15:16', '2025-01-06 20:09:55', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, '2025-01-08 01:06:21', '2025-01-08 10:19:08', NULL, 'SF_002', '2025-01-08', '2025-01-08 10:06:21', '2025-01-08 19:19:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, '2025-01-09 01:09:57', '2025-01-09 10:22:26', NULL, 'SF_002', '2025-01-09', '2025-01-09 10:09:57', '2025-01-09 19:22:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, '2025-01-10 01:34:34', '2025-01-10 10:11:57', NULL, 'SF_002', '2025-01-10', '2025-01-10 10:34:34', '2025-01-10 19:11:57', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, '2025-01-11 01:48:47', '2025-01-11 10:04:25', NULL, 'SF_002', '2025-01-11', '2025-01-11 10:48:47', '2025-01-11 19:04:25', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, '2025-01-12 01:07:00', '2025-01-12 10:38:45', NULL, 'SF_002', '2025-01-12', '2025-01-12 10:07:00', '2025-01-12 19:38:45', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, '2025-01-13 01:02:35', '2025-01-13 10:25:26', NULL, 'SF_002', '2025-01-13', '2025-01-13 10:02:35', '2025-01-13 19:25:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, '2025-01-15 02:09:22', '2025-01-15 10:22:49', NULL, 'SF_002', '2025-01-15', '2025-01-15 11:09:22', '2025-01-15 19:22:49', '川島 花乃', NULL, NULL, NULL, '渋滞の為', NULL, NULL, NULL),
(195, '2025-01-15 04:23:23', '2025-03-03 05:05:47', NULL, 'SF_004', '2025-01-15', '2025-01-15 13:00:00', '2025-01-15 17:35:25', '田熊 柊花', NULL, NULL, NULL, NULL, '押し忘れ（13時出勤）', NULL, NULL),
(196, '2025-01-16 01:57:05', '2025-01-16 10:31:20', NULL, 'SF_002', '2025-01-16', '2025-01-16 10:57:05', '2025-01-16 19:31:20', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, '2025-01-17 01:53:27', '2025-01-17 10:00:40', NULL, 'SF_002', '2025-01-17', '2025-01-17 10:53:27', '2025-01-17 19:00:40', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, '2025-01-18 01:50:48', '2025-01-18 10:26:12', NULL, 'SF_002', '2025-01-18', '2025-01-18 10:50:48', '2025-01-18 19:26:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, '2025-01-19 01:43:06', '2025-01-19 10:47:12', NULL, 'SF_002', '2025-01-19', '2025-01-19 10:43:06', '2025-01-19 19:47:12', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, '2025-01-20 01:04:05', '2025-01-20 10:26:25', NULL, 'SF_002', '2025-01-20', '2025-01-20 10:04:05', '2025-01-20 19:26:25', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, '2025-01-22 01:56:17', '2025-01-22 10:29:16', NULL, 'SF_002', '2025-01-22', '2025-01-22 10:56:17', '2025-01-22 19:29:16', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, '2025-01-22 08:28:32', '2025-01-22 10:29:36', NULL, 'SF_004', '2025-01-22', '2025-01-22 17:28:32', '2025-01-22 19:29:36', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, '2025-01-23 01:41:28', '2025-01-23 10:01:59', NULL, 'SF_002', '2025-01-23', '2025-01-23 10:41:28', '2025-01-23 19:01:59', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, '2025-01-24 01:07:37', '2025-01-24 10:52:36', NULL, 'SF_002', '2025-01-24', '2025-01-24 10:07:37', '2025-01-24 19:52:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, '2025-01-25 01:00:41', '2025-01-25 10:38:19', NULL, 'SF_002', '2025-01-25', '2025-01-25 10:00:41', '2025-01-25 19:38:19', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, '2025-01-25 03:23:27', '2025-01-25 10:39:21', NULL, 'SF_004', '2025-01-25', '2025-01-25 12:23:27', '2025-01-25 19:39:21', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, '2025-01-26 01:45:00', '2025-01-27 01:14:26', NULL, 'SF_002', '2025-01-26', '2025-01-26 10:45:00', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '押し忘れ(19:00)退勤', NULL, NULL),
(208, '2025-01-27 01:13:53', '2025-01-27 04:03:28', NULL, 'SF_002', '2025-01-27', '2025-01-27 10:13:53', '2025-01-27 13:03:00', '川島 花乃', NULL, NULL, NULL, NULL, '体調不良の為早退', NULL, NULL),
(209, '2025-01-29 00:57:11', '2025-01-29 10:19:09', NULL, 'SF_002', '2025-01-29', '2025-01-29 09:57:11', '2025-01-29 19:19:09', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, '2025-01-29 04:28:04', '2025-01-29 10:19:24', NULL, 'SF_004', '2025-01-29', '2025-01-29 13:28:04', '2025-01-29 19:19:24', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, '2025-01-30 01:47:50', '2025-01-30 10:26:26', NULL, 'SF_002', '2025-01-30', '2025-01-30 10:47:50', '2025-01-30 19:26:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, '2025-01-31 01:48:35', '2025-01-31 10:39:06', NULL, 'SF_002', '2025-01-31', '2025-01-31 10:48:35', '2025-01-31 19:39:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, '2025-01-31 04:01:16', '2025-02-04 06:43:45', NULL, 'SF_004', '2025-01-31', '2025-01-31 13:01:16', ' 19:40:00', '田熊 柊花', NULL, NULL, NULL, NULL, '押し忘れ(19:40退勤)', NULL, NULL),
(214, '2025-02-01 01:53:42', '2025-02-01 10:25:04', NULL, 'SF_002', '2025-02-01', '2025-02-01 10:53:42', '2025-02-01 19:25:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, '2025-02-02 01:08:18', '2025-02-02 10:14:06', NULL, 'SF_002', '2025-02-02', '2025-02-02 10:08:18', '2025-02-02 19:14:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, '2025-02-03 01:54:07', '2025-02-03 10:07:19', NULL, 'SF_002', '2025-02-03', '2025-02-03 10:54:07', '2025-02-03 19:07:19', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, '2025-02-05 01:00:29', '2025-02-05 10:23:31', NULL, 'SF_002', '2025-02-05', '2025-02-05 10:00:29', '2025-02-05 19:23:31', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, '2025-02-05 03:10:23', '2025-03-03 05:05:18', NULL, 'SF_004', '2025-02-05', '2025-02-05 11:30:00', '2025-02-05 19:23:47', '田熊 柊花', NULL, NULL, NULL, NULL, '押し忘れ(11:30)出勤', NULL, NULL),
(219, '2025-02-06 01:12:39', '2025-02-06 10:14:37', NULL, 'SF_002', '2025-02-06', '2025-02-06 10:12:39', '2025-02-06 19:14:37', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, '2025-02-07 01:56:55', '2025-02-07 10:47:41', NULL, 'SF_002', '2025-02-07', '2025-02-07 10:56:55', '2025-02-07 19:47:41', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, '2025-02-07 10:48:28', '2025-03-03 05:05:03', NULL, 'SF_004', '2025-02-07', '2025-02-07 11:30:00', '2025-02-07 19:49:18', '田熊 柊花', NULL, NULL, NULL, NULL, '押し忘れ(11:30出勤)', NULL, NULL),
(222, '2025-02-08 01:11:15', '2025-02-08 10:05:25', NULL, 'SF_002', '2025-02-08', '2025-02-08 10:11:15', '2025-02-08 19:05:25', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, '2025-02-09 01:49:44', '2025-02-09 10:00:27', NULL, 'SF_002', '2025-02-09', '2025-02-09 10:49:44', '2025-02-09 19:00:27', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, '2025-02-10 01:50:04', '2025-02-10 10:01:54', NULL, 'SF_002', '2025-02-10', '2025-02-10 10:50:04', '2025-02-10 19:01:54', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, '2025-02-12 01:48:30', '2025-02-12 10:46:41', NULL, 'SF_002', '2025-02-12', '2025-02-12 10:48:30', '2025-02-12 19:46:41', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, '2025-02-12 02:58:42', '2025-02-12 10:46:36', NULL, 'SF_004', '2025-02-12', '2025-02-12 11:58:42', '2025-02-12 19:46:36', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, '2025-02-15 00:54:33', '2025-02-19 02:09:46', NULL, 'SF_002', '2025-02-15', '2025-02-15 09:54:33', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '押し忘れ(19:00退勤)', NULL, NULL),
(228, '2025-02-19 01:49:15', '2025-02-19 11:08:22', NULL, 'SF_002', '2025-02-19', '2025-02-19 10:49:15', '2025-02-19 20:08:22', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, '2025-02-19 02:57:29', '2025-02-19 11:08:39', NULL, 'SF_004', '2025-02-19', '2025-02-19 11:57:29', '2025-02-19 20:08:39', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, '2025-02-21 00:57:22', '2025-02-21 10:26:07', NULL, 'SF_002', '2025-02-21', '2025-02-21 09:57:22', '2025-02-21 19:26:07', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, '2025-02-22 00:53:23', '2025-02-22 10:08:03', NULL, 'SF_002', '2025-02-22', '2025-02-22 09:53:23', '2025-02-22 19:08:03', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, '2025-02-23 01:08:32', '2025-02-23 10:08:45', NULL, 'SF_002', '2025-02-23', '2025-02-23 10:08:32', '2025-02-23 19:08:45', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, '2025-02-24 01:08:20', '2025-02-24 10:24:46', NULL, 'SF_002', '2025-02-24', '2025-02-24 10:08:20', '2025-02-24 19:24:46', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, '2025-02-26 01:07:03', '2025-02-26 10:28:01', NULL, 'SF_002', '2025-02-26', '2025-02-26 10:07:03', '2025-02-26 19:28:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, '2025-02-27 01:13:40', '2025-02-27 10:45:24', NULL, 'SF_002', '2025-02-27', '2025-02-27 10:13:40', '2025-02-27 19:45:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, '2025-02-27 03:06:53', '2025-03-03 05:04:44', NULL, 'SF_004', '2025-02-27', '2025-02-27 12:00:00', '2025-02-27 19:41:06', '田熊 柊花', NULL, NULL, NULL, NULL, '押し忘れ（12:00出勤）', NULL, NULL),
(237, '2025-02-28 01:16:30', '2025-02-28 09:14:24', NULL, 'SF_002', '2025-02-28', '2025-02-28 10:16:30', '2025-02-28 18:14:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, '2025-02-28 02:58:17', '2025-02-28 09:14:40', NULL, 'SF_004', '2025-02-28', '2025-02-28 11:58:17', '2025-02-28 18:14:40', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, '2025-03-01 01:54:47', '2025-03-01 10:01:35', NULL, 'SF_002', '2025-03-01', '2025-03-01 10:54:47', '2025-03-01 19:01:35', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, '2025-03-02 01:29:09', '2025-03-02 10:00:48', NULL, 'SF_002', '2025-03-02', '2025-03-02 10:29:09', '2025-03-02 19:00:48', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, '2025-03-02 01:53:27', '2025-03-02 10:01:11', NULL, 'SF_004', '2025-03-02', '2025-03-02 10:53:27', '2025-03-02 19:01:11', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, '2025-03-03 01:53:47', '2025-03-03 10:22:06', NULL, 'SF_002', '2025-03-03', '2025-03-03 10:53:47', '2025-03-03 19:22:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, '2025-03-03 02:48:56', '2025-03-03 09:17:04', NULL, 'SF_004', '2025-03-03', '2025-03-03 11:48:56', '2025-03-03 18:17:04', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, '2025-03-06 01:58:57', '2025-03-06 10:22:52', NULL, 'SF_002', '2025-03-06', '2025-03-06 10:58:57', '2025-03-06 19:22:52', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, '2025-03-07 01:49:28', '2025-03-07 10:13:53', NULL, 'SF_002', '2025-03-07', '2025-03-07 10:49:28', '2025-03-07 19:13:53', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, '2025-03-07 02:57:05', '2025-03-07 10:13:59', NULL, 'SF_004', '2025-03-07', '2025-03-07 11:57:05', '2025-03-07 19:13:59', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, '2025-03-08 01:43:52', '2025-03-08 10:00:22', NULL, 'SF_002', '2025-03-08', '2025-03-08 10:43:52', '2025-03-08 19:00:22', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, '2025-03-08 02:26:51', '2025-03-08 10:00:31', NULL, 'SF_004', '2025-03-08', '2025-03-08 11:26:51', '2025-03-08 19:00:31', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, '2025-03-09 01:59:18', '2025-03-09 12:10:04', NULL, 'SF_002', '2025-03-09', '2025-03-09 10:59:18', '2025-03-09 21:10:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, '2025-03-12 00:57:40', '2025-03-12 10:23:36', NULL, 'SF_002', '2025-03-12', '2025-03-12 09:57:40', '2025-03-12 19:23:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, '2025-03-12 02:53:14', '2025-03-12 10:24:02', NULL, 'SF_004', '2025-03-12', '2025-03-12 11:53:14', '2025-03-12 19:24:02', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, '2025-03-13 01:10:30', '2025-03-13 10:04:39', NULL, 'SF_002', '2025-03-13', '2025-03-13 10:10:30', '2025-03-13 19:04:39', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, '2025-03-14 01:31:41', '2025-03-14 10:04:50', NULL, 'SF_002', '2025-03-14', '2025-03-14 10:31:41', '2025-03-14 19:04:50', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, '2025-03-14 02:53:19', '2025-03-14 10:05:23', NULL, 'SF_004', '2025-03-14', '2025-03-14 11:53:19', '2025-03-14 19:05:23', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, '2025-03-15 01:09:11', '2025-03-15 10:00:00', NULL, 'SF_002', '2025-03-15', '2025-03-15 10:09:11', '2025-03-15 19:00:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, '2025-03-15 02:46:17', '2025-03-15 10:00:09', NULL, 'SF_004', '2025-03-15', '2025-03-15 11:46:17', '2025-03-15 19:00:09', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, '2025-03-16 01:10:45', '2025-03-16 10:26:10', NULL, 'SF_002', '2025-03-16', '2025-03-16 10:10:45', '2025-03-16 19:26:10', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(258, '2025-03-17 01:49:52', '2025-03-17 10:30:45', NULL, 'SF_002', '2025-03-17', '2025-03-17 10:49:52', '2025-03-17 19:30:45', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, '2025-03-17 02:51:24', '2025-03-17 10:31:03', NULL, 'SF_004', '2025-03-17', '2025-03-17 11:51:24', '2025-03-17 19:31:03', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(260, '2025-03-19 01:00:47', '2025-03-21 02:00:27', NULL, 'SF_002', '2025-03-19', '2025-03-19 10:00:47', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '押し忘れ(19:00退勤)', NULL, NULL),
(261, '2025-03-21 01:59:46', '2025-03-21 10:00:31', NULL, 'SF_002', '2025-03-21', '2025-03-21 10:59:46', '2025-03-21 19:00:31', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, '2025-03-21 02:39:31', '2025-03-21 10:00:25', NULL, 'SF_004', '2025-03-21', '2025-03-21 11:39:31', '2025-03-21 19:00:25', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, '2025-03-22 01:08:26', '2025-03-22 10:12:41', NULL, 'SF_002', '2025-03-22', '2025-03-22 10:08:26', '2025-03-22 19:12:41', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, '2025-03-23 01:57:04', '2025-03-23 10:09:08', NULL, 'SF_002', '2025-03-23', '2025-03-23 10:57:04', '2025-03-23 19:09:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, '2025-03-24 01:51:31', '2025-03-24 10:38:32', NULL, 'SF_002', '2025-03-24', '2025-03-24 10:51:31', '2025-03-24 19:38:32', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(266, '2025-03-24 02:56:39', '2025-03-24 09:33:37', NULL, 'SF_004', '2025-03-24', '2025-03-24 11:56:39', '2025-03-24 18:33:37', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(267, '2025-03-26 01:38:45', '2025-03-26 10:17:32', NULL, 'SF_002', '2025-03-26', '2025-03-26 10:38:45', '2025-03-26 19:17:32', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(268, '2025-03-27 01:47:39', '2025-03-27 10:00:01', NULL, 'SF_002', '2025-03-27', '2025-03-27 10:47:39', '2025-03-27 19:00:01', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(269, '2025-03-27 02:52:35', '2025-03-27 10:00:08', NULL, 'SF_004', '2025-03-27', '2025-03-27 11:52:35', '2025-03-27 19:00:08', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(270, '2025-03-28 01:53:03', '2025-03-28 10:13:26', NULL, 'SF_002', '2025-03-28', '2025-03-28 10:53:03', '2025-03-28 19:13:26', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(271, '2025-03-29 01:50:29', '2025-03-29 10:01:40', NULL, 'SF_002', '2025-03-29', '2025-03-29 10:50:29', '2025-03-29 19:01:40', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(272, '2025-03-30 01:07:08', '2025-03-30 10:01:55', NULL, 'SF_002', '2025-03-30', '2025-03-30 10:07:08', '2025-03-30 19:01:55', '川島 花乃', NULL, NULL, NULL, NULL, NULL, NULL, '219.104.136.68'),
(275, '2025-03-31 01:16:34', '2025-03-31 10:00:05', NULL, 'SF_002', '2025-03-31', '2025-03-31 10:16:34', '2025-03-31 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(276, '2025-03-31 02:52:19', '2025-03-31 10:01:02', NULL, 'SF_004', '2025-03-31', '2025-03-31 11:52:19', '2025-03-31 19:01:02', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(277, '2025-04-02 01:24:22', '2025-04-02 13:26:46', NULL, 'SF_002', '2025-04-02', '2025-04-02 10:24:22', '2025-04-02 17:30:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '121.117.50.143'),
(278, '2025-04-02 01:30:31', '2025-04-02 01:30:31', NULL, 'SF_004', '2025-04-02', '2025-04-02 10:30:31', '2025-04-02 17:30:00', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', NULL),
(279, '2025-04-03 01:10:02', '2025-04-03 10:01:30', NULL, 'SF_002', '2025-04-03', '2025-04-03 10:10:02', '2025-04-03 19:01:30', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(280, '2025-04-04 01:41:31', '2025-04-04 10:20:18', NULL, 'SF_002', '2025-04-04', '2025-04-04 10:41:31', '2025-04-04 19:20:18', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(281, '2025-04-04 02:50:10', '2025-04-04 10:20:24', NULL, 'SF_004', '2025-04-04', '2025-04-04 11:50:10', '2025-04-04 19:20:24', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(282, '2025-04-05 01:53:04', '2025-04-05 10:07:56', NULL, 'SF_002', '2025-04-05', '2025-04-05 10:53:04', '2025-04-05 19:07:56', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(283, '2025-04-05 01:55:34', '2025-04-05 10:08:02', NULL, 'SF_004', '2025-04-05', '2025-04-05 10:55:34', '2025-04-05 19:08:02', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(284, '2025-04-06 01:53:31', '2025-04-06 10:00:14', NULL, 'SF_002', '2025-04-06', '2025-04-06 10:53:31', '2025-04-06 19:00:14', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(285, '2025-04-09 01:54:54', '2025-04-09 10:43:57', NULL, 'SF_002', '2025-04-09', '2025-04-09 10:54:54', '2025-04-09 19:43:57', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(286, '2025-04-09 02:47:13', '2025-04-09 10:36:08', NULL, 'SF_004', '2025-04-09', '2025-04-09 11:47:13', '2025-04-09 19:36:08', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(287, '2025-04-10 01:10:27', '2025-04-10 10:15:43', NULL, 'SF_002', '2025-04-10', '2025-04-10 10:10:27', '2025-04-10 19:15:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(288, '2025-04-11 01:53:23', '2025-04-11 10:00:28', NULL, 'SF_002', '2025-04-11', '2025-04-11 10:53:23', '2025-04-11 19:00:28', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(289, '2025-04-11 01:59:54', '2025-04-11 10:00:40', NULL, 'SF_004', '2025-04-11', '2025-04-11 10:59:54', '2025-04-11 19:00:40', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(290, '2025-04-12 01:10:52', '2025-04-12 10:07:58', NULL, 'SF_002', '2025-04-12', '2025-04-12 10:10:52', '2025-04-12 19:07:58', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27');
INSERT INTO `in_out_histories` (`id`, `created_at`, `updated_at`, `deleted_at`, `target_serial`, `target_date`, `time_in`, `time_out`, `target_name`, `staff_name_kana`, `to_mail_address`, `from_mail_address`, `reason_late`, `remarks`, `ip_address_in`, `ip_address_out`) VALUES
(291, '2025-04-12 01:55:32', '2025-04-12 10:08:32', NULL, 'SF_004', '2025-04-12', '2025-04-12 10:55:32', '2025-04-12 19:08:32', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(292, '2025-04-13 01:52:49', '2025-04-13 10:00:10', NULL, 'SF_002', '2025-04-13', '2025-04-13 10:52:49', '2025-04-13 19:00:10', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(293, '2025-04-14 01:16:28', '2025-04-14 10:13:38', NULL, 'SF_002', '2025-04-14', '2025-04-14 10:16:28', '2025-04-14 19:13:38', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(294, '2025-04-14 01:48:33', '2025-04-14 10:14:09', NULL, 'SF_004', '2025-04-14', '2025-04-14 10:48:33', '2025-04-14 19:14:09', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(295, '2025-04-16 01:52:08', '2025-04-16 10:21:57', NULL, 'SF_002', '2025-04-16', '2025-04-16 10:52:08', '2025-04-16 19:21:57', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(296, '2025-04-17 01:35:48', '2025-04-17 10:44:21', NULL, 'SF_002', '2025-04-17', '2025-04-17 10:35:48', '2025-04-17 19:44:21', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(297, '2025-04-17 01:35:53', '2025-04-17 10:44:47', NULL, 'SF_004', '2025-04-17', '2025-04-17 10:35:53', '2025-04-17 19:44:47', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(298, '2025-04-18 01:54:04', '2025-04-18 09:10:23', NULL, 'SF_002', '2025-04-18', '2025-04-18 10:54:04', '2025-04-18 18:09:58', '川島 花乃', NULL, NULL, NULL, NULL, 'オーナーとミーティングの為', '153.185.58.27', '153.185.58.27'),
(299, '2025-04-19 01:07:40', '2025-04-19 10:00:27', NULL, 'SF_002', '2025-04-19', '2025-04-19 10:07:40', '2025-04-19 19:00:27', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(300, '2025-04-20 01:13:19', '2025-04-20 10:22:40', NULL, 'SF_002', '2025-04-20', '2025-04-20 10:13:19', '2025-04-20 19:22:40', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(301, '2025-04-20 01:28:52', '2025-04-20 10:22:54', NULL, 'SF_004', '2025-04-20', '2025-04-20 10:28:52', '2025-04-20 19:22:54', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(302, '2025-04-23 01:49:31', '2025-04-23 10:00:05', NULL, 'SF_002', '2025-04-23', '2025-04-23 10:49:31', '2025-04-23 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(303, '2025-04-24 01:56:42', '2025-04-24 10:00:04', NULL, 'SF_002', '2025-04-24', '2025-04-24 10:56:42', '2025-04-24 19:00:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(304, '2025-04-25 01:10:23', '2025-04-25 10:37:39', NULL, 'SF_002', '2025-04-25', '2025-04-25 10:10:23', '2025-04-25 19:37:39', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(305, '2025-04-25 03:03:48', '2025-04-25 10:37:56', NULL, 'SF_004', '2025-04-25', '2025-04-25 12:03:48', '2025-04-25 19:37:56', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(306, '2025-04-26 01:13:10', '2025-04-26 10:00:02', NULL, 'SF_002', '2025-04-26', '2025-04-26 10:13:10', '2025-04-26 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(307, '2025-04-27 01:54:23', '2025-04-27 10:00:15', NULL, 'SF_002', '2025-04-27', '2025-04-27 10:54:23', '2025-04-27 19:00:15', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(308, '2025-04-28 01:11:27', '2025-04-28 10:07:36', NULL, 'SF_002', '2025-04-28', '2025-04-28 10:11:27', '2025-04-28 19:07:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(309, '2025-04-30 01:12:15', '2025-04-30 10:21:33', NULL, 'SF_002', '2025-04-30', '2025-04-30 10:12:15', '2025-04-30 19:21:33', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(310, '2025-04-30 03:55:08', '2025-04-30 10:21:39', NULL, 'SF_004', '2025-04-30', '2025-04-30 12:55:08', '2025-04-30 19:21:39', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(311, '2025-05-01 01:13:58', '2025-05-01 10:01:22', NULL, 'SF_002', '2025-05-01', '2025-05-01 10:13:58', '2025-05-01 19:01:22', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(312, '2025-05-01 01:45:41', '2025-05-01 10:01:14', NULL, 'SF_004', '2025-05-01', '2025-05-01 10:45:41', '2025-05-01 19:01:14', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(313, '2025-05-02 01:17:20', '2025-05-02 10:00:05', NULL, 'SF_002', '2025-05-02', '2025-05-02 10:17:20', '2025-05-02 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(314, '2025-05-02 01:24:04', '2025-05-02 09:17:10', NULL, 'SF_004', '2025-05-02', '2025-05-02 10:24:04', '2025-05-02 18:17:10', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(315, '2025-05-03 01:12:53', '2025-05-03 10:01:53', NULL, 'SF_002', '2025-05-03', '2025-05-03 10:12:53', '2025-05-03 19:01:53', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(316, '2025-05-04 01:48:28', '2025-05-04 10:00:02', NULL, 'SF_002', '2025-05-04', '2025-05-04 10:48:28', '2025-05-04 19:00:02', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(317, '2025-05-07 01:22:18', '2025-05-07 10:00:05', NULL, 'SF_002', '2025-05-07', '2025-05-07 10:22:18', '2025-05-07 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(318, '2025-05-07 01:33:19', '2025-05-07 09:05:13', NULL, 'SF_004', '2025-05-07', '2025-05-07 10:33:19', '2025-05-07 18:05:13', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(319, '2025-05-08 01:21:04', '2025-05-08 10:00:11', NULL, 'SF_002', '2025-05-08', '2025-05-08 10:21:04', '2025-05-08 19:00:11', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(320, '2025-05-08 01:40:30', '2025-05-08 10:00:16', NULL, 'SF_004', '2025-05-08', '2025-05-08 10:40:30', '2025-05-08 19:00:16', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(321, '2025-05-09 01:22:55', '2025-05-09 10:01:22', NULL, 'SF_002', '2025-05-09', '2025-05-09 10:22:55', '2025-05-09 19:01:22', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(322, '2025-05-09 01:37:01', '2025-05-09 09:01:21', NULL, 'SF_004', '2025-05-09', '2025-05-09 10:37:01', '2025-05-09 18:01:21', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(323, '2025-05-11 01:43:59', '2025-05-11 10:00:24', NULL, 'SF_002', '2025-05-11', '2025-05-11 10:43:59', '2025-05-11 19:00:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(324, '2025-05-12 01:17:37', '2025-05-12 10:00:35', NULL, 'SF_002', '2025-05-12', '2025-05-12 10:17:37', '2025-05-12 19:00:35', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(325, '2025-05-12 01:33:01', '2025-05-12 10:01:11', NULL, 'SF_004', '2025-05-12', '2025-05-12 10:33:01', '2025-05-12 19:01:11', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(326, '2025-05-14 01:34:03', '2025-05-14 10:01:50', NULL, 'SF_002', '2025-05-14', '2025-05-14 10:34:03', '2025-05-14 19:01:50', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(327, '2025-05-14 01:34:14', '2025-05-14 10:02:02', NULL, 'SF_004', '2025-05-14', '2025-05-14 10:34:14', '2025-05-14 19:02:02', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(328, '2025-05-15 01:22:20', '2025-05-15 10:00:51', NULL, 'SF_002', '2025-05-15', '2025-05-15 10:22:20', '2025-05-15 19:00:51', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(329, '2025-05-15 01:32:05', '2025-05-15 10:01:05', NULL, 'SF_004', '2025-05-15', '2025-05-15 10:32:05', '2025-05-15 19:01:05', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(330, '2025-05-16 01:20:47', '2025-05-16 10:06:00', NULL, 'SF_002', '2025-05-16', '2025-05-16 10:20:47', '2025-05-16 19:06:00', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(331, '2025-05-17 01:20:46', '2025-05-17 10:00:06', NULL, 'SF_002', '2025-05-17', '2025-05-17 10:20:46', '2025-05-17 19:00:06', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(332, '2025-05-18 01:18:51', '2025-05-18 10:05:36', NULL, 'SF_002', '2025-05-18', '2025-05-18 10:18:51', '2025-05-18 19:05:36', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(333, '2025-05-19 01:22:28', '2025-05-19 10:00:11', NULL, 'SF_002', '2025-05-19', '2025-05-19 10:22:28', '2025-05-19 19:00:11', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(334, '2025-05-22 01:04:19', '2025-05-22 10:51:29', NULL, 'SF_002', '2025-05-22', '2025-05-22 10:04:19', '2025-05-22 19:51:29', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(335, '2025-05-23 01:30:46', '2025-05-23 10:00:05', NULL, 'SF_002', '2025-05-23', '2025-05-23 10:30:46', '2025-05-23 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(336, '2025-05-24 01:27:39', '2025-05-24 10:51:24', NULL, 'SF_002', '2025-05-24', '2025-05-24 10:27:39', '2025-05-24 19:51:24', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(337, '2025-05-25 01:32:51', '2025-05-25 10:45:30', NULL, 'SF_002', '2025-05-25', '2025-05-25 10:32:51', '2025-05-25 19:45:30', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(338, '2025-05-25 01:40:10', '2025-05-25 10:45:43', NULL, 'SF_004', '2025-05-25', '2025-05-25 10:40:10', '2025-05-25 19:45:43', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(339, '2025-05-26 01:15:19', '2025-05-26 10:00:08', NULL, 'SF_002', '2025-05-26', '2025-05-26 10:15:19', '2025-05-26 19:00:08', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(340, '2025-05-26 01:38:48', '2025-05-26 09:06:38', NULL, 'SF_004', '2025-05-26', '2025-05-26 10:38:48', '2025-05-26 18:06:38', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(341, '2025-05-28 01:49:32', '2025-05-28 10:06:55', NULL, 'SF_002', '2025-05-28', '2025-05-28 10:49:32', '2025-05-28 19:06:55', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(342, '2025-05-28 02:58:27', '2025-05-28 10:07:01', NULL, 'SF_004', '2025-05-28', '2025-05-28 11:58:27', '2025-05-28 19:07:01', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(343, '2025-05-29 01:30:28', '2025-05-29 10:37:23', NULL, 'SF_002', '2025-05-29', '2025-05-29 10:30:28', '2025-05-29 19:37:23', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(344, '2025-05-29 01:36:02', '2025-05-29 07:27:14', NULL, 'SF_004', '2025-05-29', '2025-05-29 10:36:02', '2025-05-29 16:27:14', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(345, '2025-05-30 01:25:06', '2025-05-30 10:00:05', NULL, 'SF_002', '2025-05-30', '2025-05-30 10:25:06', '2025-05-30 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(346, '2025-05-30 03:04:18', '2025-05-30 05:36:32', NULL, 'SF_004', '2025-05-30', '2025-05-30 12:04:18', '2025-05-30 14:36:32', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(347, '2025-05-31 01:54:23', '2025-05-31 10:01:31', NULL, 'SF_002', '2025-05-31', '2025-05-31 10:54:23', '2025-05-31 19:01:31', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(348, '2025-05-31 01:54:29', '2025-05-31 10:01:37', NULL, 'SF_004', '2025-05-31', '2025-05-31 10:54:29', '2025-05-31 19:01:37', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(349, '2025-06-01 01:21:02', '2025-06-01 10:00:05', NULL, 'SF_002', '2025-06-01', '2025-06-01 10:21:02', '2025-06-01 19:00:05', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(350, '2025-06-02 01:22:35', '2025-06-05 10:18:35', NULL, 'SF_002', '2025-06-02', '2025-06-02 10:22:35', NULL, '川島 花乃', NULL, NULL, NULL, NULL, '押し忘れ(17:30退勤)', '153.185.58.27', NULL),
(351, '2025-06-02 01:36:56', '2025-06-02 11:41:11', NULL, 'SF_004', '2025-06-02', '2025-06-02 10:36:56', '2025-06-02 20:41:11', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(352, '2025-06-04 03:58:23', '2025-06-04 08:06:12', NULL, 'SF_004', '2025-06-04', '2025-06-04 12:58:23', '2025-06-04 17:06:12', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(353, '2025-06-05 01:04:13', '2025-06-05 11:10:14', NULL, 'SF_002', '2025-06-05', '2025-06-05 10:04:13', '2025-06-05 20:10:14', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(354, '2025-06-05 01:26:08', '2025-06-05 11:10:08', NULL, 'SF_004', '2025-06-05', '2025-06-05 10:26:08', '2025-06-05 20:10:08', '田熊 柊花', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(355, '2025-06-06 01:52:18', '2025-06-06 10:00:43', NULL, 'SF_002', '2025-06-06', '2025-06-06 10:52:18', '2025-06-06 19:00:43', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(356, '2025-06-07 01:15:22', '2025-06-07 10:48:04', NULL, 'SF_002', '2025-06-07', '2025-06-07 10:15:22', '2025-06-07 19:48:04', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(357, '2025-06-08 01:12:56', '2025-06-08 10:06:57', NULL, 'SF_002', '2025-06-08', '2025-06-08 10:12:56', '2025-06-08 19:06:57', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27'),
(358, '2025-06-09 01:56:03', '2025-06-09 10:00:17', NULL, 'SF_002', '2025-06-09', '2025-06-09 10:56:03', '2025-06-09 19:00:17', '川島 花乃', NULL, NULL, NULL, NULL, NULL, '153.185.58.27', '153.185.58.27');

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
  `reservation` datetime DEFAULT NULL COMMENT '予約日時',
  `referee_num` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zankin` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支払い残金',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- テーブルのインデックス `cash_books`
--
ALTER TABLE `cash_books`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- テーブルの AUTO_INCREMENT `cash_books`
--
ALTER TABLE `cash_books`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `configrations`
--
ALTER TABLE `configrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=583;

--
-- テーブルの AUTO_INCREMENT `contract_details`
--
ALTER TABLE `contract_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルの AUTO_INCREMENT `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10985;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- テーブルの AUTO_INCREMENT `recorders`
--
ALTER TABLE `recorders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1285;

--
-- テーブルの AUTO_INCREMENT `sales_records`
--
ALTER TABLE `sales_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `treatment_contents`
--
ALTER TABLE `treatment_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- テーブルの AUTO_INCREMENT `visit_histories`
--
ALTER TABLE `visit_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4293;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
