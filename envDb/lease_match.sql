-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lease_match`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_requirements`
--

CREATE TABLE `accommodation_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `disability` varchar(10) DEFAULT NULL,
  `disability_type` varchar(100) DEFAULT NULL,
  `special_accomodation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accommodation_requirements`
--

INSERT INTO `accommodation_requirements` (`id`, `user_id`, `disability`, `disability_type`, `special_accomodation`, `created_at`, `updated_at`) VALUES
(4, 16, 'Yes', 'South Whittier', 'Architecto delectus impedit.', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(5, 17, 'Yes', 'Walnut Creek', 'Odit dolorem laboriosam eos magnam repudiandae quibusdam optio.', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(9, 24, 'Yes', 'kk', 'lklk', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(11, 28, 'No', NULL, NULL, '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(12, 29, 'No', '4', 'f', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(13, 30, 'Yes', 'fjds', 'skdfsd', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(14, 31, 'Yes', 'fadsf', 'fadsfa', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(15, 32, 'Yes', 'fasdfsa', 'ffadsf', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(16, 33, 'No', NULL, NULL, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(17, 34, 'Yes', 'Nashua', 'Ducimus iure ut quasi tempore ipsam explicabo cupiditate qui voluptatum.', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(19, 38, 'No', NULL, NULL, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(20, 39, 'No', NULL, NULL, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `additional_note`
--

CREATE TABLE `additional_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `general_note` varchar(255) DEFAULT NULL,
  `work_with_broker` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_note`
--

INSERT INTO `additional_note` (`id`, `user_id`, `general_note`, `work_with_broker`, `created_at`, `updated_at`) VALUES
(1, 17, 'general note', 'Yes', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(5, 24, 'jklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljklkljljljkl', 'Yes', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(7, 28, 'fdsafa', 'Yes', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(8, 29, 'fkjfklfjf', 'Yes', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(9, 30, 'sdjkfdsa', 'Yes', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(10, 31, 'kaksjflkjd', 'Yes', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(11, 32, 'fasdfff', 'Yes', '2024-10-15 04:28:59', '2024-10-15 04:28:59'),
(12, 33, 'as', 'Yes', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(13, 34, 'Iusto in fuga placeat autem sint architecto voluptates deserunt omnis.', 'No', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(15, 38, 'dsajflkas', 'No', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(16, 39, NULL, 'Yes', '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `additional_requirements`
--

CREATE TABLE `additional_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `max_rent_to_pay` int(10) UNSIGNED DEFAULT NULL,
  `preffered_move_in_date` date DEFAULT NULL,
  `lease_length_preference` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_requirements`
--

INSERT INTO `additional_requirements` (`id`, `user_id`, `max_rent_to_pay`, `preffered_move_in_date`, `lease_length_preference`, `created_at`, `updated_at`) VALUES
(4, 16, 180, '2023-12-27', '18', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(5, 17, 177, '2024-01-24', '6', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(9, 24, 9099, '2024-10-12', '6', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(11, 28, 53245, '2024-10-16', '12', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(12, 29, 43, '2024-10-16', '12', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(13, 30, 9, '2024-10-16', '6', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(14, 31, 5432, '2024-10-16', '6', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(15, 32, 432, '2024-10-16', '6', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(16, 33, 23424, '2024-10-15', '12', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(17, 34, 123, '2024-12-11', '24', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(19, 38, 543, '2024-10-17', '6', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(20, 39, 8, '2024-10-17', '6', '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `api_settings`
--

CREATE TABLE `api_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `publishable_key` varchar(255) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL COMMENT '0=>InActive, 1=>Active',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_settings`
--

INSERT INTO `api_settings` (`id`, `secret_key`, `publishable_key`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'sk_test_51MianPCCOZ6H0AgUPVuxd4qnHD9FAfPRRazQMgYT63SGSgq3odBSnmP6XndKlkyDvUP7bx1RRj58x11oNxoQT9tK00aOoeO8mp', 'pk_test_51MianPCCOZ6H0AgU23ZzXDl8UDTHdGpt0SGCJQsLHIjPTUzbujtLC3XGceAZsMu9zlQWc9gFElCmUpCSTL6F0uhx00I12aUUfa', 1, 1, 1, '2024-06-06 06:40:51', '2024-06-09 23:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `replied_by` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `phone`, `message`, `reply`, `replied_by`, `date`, `created_at`, `updated_at`) VALUES
(1, 'Alvera Thiel-Dicki', 'your.email+fakedata58570@gmail.com', 'Praesentium veniam assumenda fugiat.', '374', 'Asperiores ab doloribus.', 'Reply Asperiores ab doloribus.Reply Asperiores ab doloribus.Reply Asperiores ab doloribus.Reply Asperiores ab doloribus.Reply Asperiores ab doloribus.Reply Asperiores ab doloribus.', 1, '2024-06-10', '2024-06-10 00:33:42', '2024-06-25 06:30:17'),
(2, 'Asia Wilderman', 'your.email+fakedata77033@gmail.com', 'Impedit assumenda facere ipsa nisi doloremque dolore.', '215', 'Et ex culpa illo quaerat minus quam.', '', NULL, '2024-06-10', '2024-06-10 00:33:45', '2024-06-10 02:57:28'),
(3, 'Asa Lueilwitz', 'your.email+fakedata19974@gmail.com', 'Ratione ad facere nobis perferendis deleniti atque voluptates.', '556', 'Quis quae culpa nam.', NULL, NULL, '2024-06-10', '2024-06-10 00:33:47', '2024-06-10 00:33:47'),
(4, 'Riley Sawayn', 'your.email+fakedata87244@gmail.com', 'Dolores a molestias occaecati praesentium veritatis saepe vero voluptatum iure.', '196', 'Excepturi quaerat nesciunt facere ducimus odit totam ad.Excepturi quaerat nesciunt facere ducimus odit totam ad.Excepturi quaerat nesciunt facere ducimus odit totam ad.Excepturi quaerat nesciunt facere ducimus odit totam ad.Excepturi quaerat nesciunt facere ducimus odit totam ad.', NULL, NULL, '2024-06-10', '2024-06-10 00:33:52', '2024-06-10 00:33:52'),
(5, 'Shad O\'Connell', 'your.email+fakedata88575@gmail.com', 'Ab omnis ipsum.', '142', 'Aspernatur minima eius est tempore sequi dolor libero dolore.Aspernatur minima eius est tempore sequi dolor libero dolore.Aspernatur minima eius est tempore sequi dolor libero dolore.Aspernatur minima eius est tempore sequi dolor libero dolore.', '', NULL, '2024-06-10', '2024-06-10 00:34:00', '2024-06-10 03:00:56'),
(6, 'Dudley Frami', 'your.email+fakedata46929@gmail.com', 'Eaque omnis saepe debitis deserunt.', '525897987979', 'Id tenetur alias temporibus.', NULL, NULL, '2024-10-11', '2024-10-11 05:44:56', '2024-10-11 05:44:56'),
(7, 'Silas D\'Amore', 'your.email+fakedata62867@gmail.com', 'Ullam voluptas eaque officia distinctio hic.', '2268779798', 'Pariatur culpa in vitae incidunt fuga non nisi amet.', NULL, NULL, '2024-10-11', '2024-10-11 05:45:10', '2024-10-11 05:45:10'),
(8, 'Korbin Rogahn-Will', 'your.email+fakedata48032@gmail.com', 'Blanditiis magnam reprehenderit assumenda laudantium sed architecto ea.', '758779977997', 'Officia voluptatibus nulla tenetur veniam asperiores ratione provident.', NULL, NULL, '2024-10-11', '2024-10-11 05:45:31', '2024-10-11 05:45:31'),
(9, 'Frederick Bosco', 'your.email+fakedata68315@gmail.com', 'Ut ex necessitatibus consequatur repudiandae adipisci magni fugit quia.', '1958999999089', 'Porro natus iste.', NULL, NULL, '2024-10-11', '2024-10-11 05:56:25', '2024-10-11 05:56:25'),
(10, 'Brennon Kuhlman', 'your.email+fakedata42201@gmail.com', 'Ex in omnis alias facilis praesentium.', '1802345324521', 'Quasi nobis tenetur earum molestias nam deserunt.', NULL, NULL, '2024-10-11', '2024-10-11 06:00:47', '2024-10-11 06:00:47'),
(11, 'Arely Pacocha', 'your.email+fakedata63316@gmail.com', 'Architecto maiores reprehenderit.', '206243543524351', 'Nam sapiente deleniti in maiores placeat consequatur.', NULL, NULL, '2024-10-11', '2024-10-11 06:01:34', '2024-10-11 06:01:34'),
(12, 'Nikko Torp', 'dksjflk@gmail', 'Sapiente enim fugit cum eveniet distinctio.', '1763450', 'Voluptatum commodi quisquam recusandae eveniet quis neque mollitia alias temporibus.', NULL, NULL, '2024-10-12', '2024-10-12 05:10:29', '2024-10-12 05:10:29'),
(13, 'Leif Gorczany', 'fdajfjafl@gmail.com', 'Voluptate maxime sunt voluptatem aperiam numquam placeat adipisci quia praesentium.', '551234452345242', 'Sit provident labore magni necessitatibus ipsam dolorem animi.', NULL, NULL, '2024-10-12', '2024-10-12 06:17:31', '2024-10-12 06:17:31'),
(14, 'Rhiannon Hackett', 'dsajks@gmail.com', 'Error quam aspernatur.', '4174235234', 'Labore excepturi ea ad numquam tempore enim.', NULL, NULL, '2024-10-12', '2024-10-12 07:41:53', '2024-10-12 07:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `doc_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `doc_name`, `doc_url`, `created_at`, `updated_at`) VALUES
(3, 16, 'Uqm7KjpPZ4ghNiXxEjd2jkeMyRDSMlJ0.png', '/uploads/user_documents/DrWwrgfFQKZ1WibfH2jFFrrk1wyuyeSm.png', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(4, 16, 'image (5).png', '/uploads/user_documents/RvyFwfRmfePWYxk6v1pA4ZuLD37ecgkV.png', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(5, 16, 'loading.gif', '/uploads/user_documents/jbBoxBLdkccwkYu5NuXqdMYmyk1AZYqs.gif', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(6, 17, 'image (5).png', '/uploads/user_documents/SIAkW51eNYQyzLwKPKvgZ8LZ5eLIZKSF.png', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(11, 24, 'ac-4.png', '/public/uploads/user_documents/rdG20FmChZlKes9QmdgOFINgG7gPvWtI.png', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(13, 28, 'download.jfif', '/public/uploads/user_documents/x6bpyMP30OVg0OBRXphONGgtxBiSLPex.jfif', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(14, 29, 'download.jfif', '/public/uploads/user_documents/YujMx7u6GfQaJ37hvjsi0vBDisIy3byD.jfif', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(15, 30, 'download.jfif', '/public/uploads/user_documents/XChNLQRWVdbohwSPWA4gcz6MqkV3w8QS.jfif', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(16, 31, 'download.jfif', '/public/uploads/user_documents/nA2K6nlJdsiXAyP7d3syGcTZcv4DKePA.jfif', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(17, 32, 'download.jfif', '/public/uploads/user_documents/1xRkn8xcEIlLHH53TiSmplIrbFdK83KG.jfif', '2024-10-15 04:28:59', '2024-10-15 04:28:59'),
(18, 33, 'ac-1.jpg', '/public/uploads/user_documents/S1S7my44G4gISCS3hStYYHcrnbr4spBp.jpg', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(19, 34, 'ac-1.jpg', '/public/uploads/user_documents/MMiEE0v1Bxs3lVNnIhlZsLjSg2j80VqP.jpg', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(20, 34, 'ac-2.jpg', '/public/uploads/user_documents/HRK560fWVL0lsFEeDiYl9JvJ9kFg2pz8.jpg', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 38, 'download.jfif', '/public/uploads/user_documents/0mU0kH2EV6abROEzH19RzuWUdppPhsTO.jfif', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(24, 39, 'ac-2.jpg', '/public/uploads/user_documents/A4YXw24vGYtz7HDwHGjkP3NZJP770dKe.jpg', '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_information`
--

CREATE TABLE `financial_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `annual_income` varchar(100) DEFAULT NULL,
  `employment_status` varchar(100) DEFAULT NULL,
  `employer_name` varchar(100) DEFAULT NULL,
  `income_type` varchar(100) DEFAULT NULL,
  `rental_budget` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_information`
--

INSERT INTO `financial_information` (`id`, `user_id`, `annual_income`, `employment_status`, `employer_name`, `income_type`, `rental_budget`, `created_at`, `updated_at`) VALUES
(8, 16, '70k_80k', 'Retired', 'Ida Schumm', 'Salary', 372, '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(9, 17, '100k+', 'Retired', 'Ansley Bins', 'Salary', 616, '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(13, 24, '20k_30k', 'Employed', 'kjljl', 'Salary', 5354, '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(15, 28, '90k_100k', 'Employed', 'fkjsdfl', 'Salary', 23453, '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(16, 29, '30k_40k', 'Employed', 'Kelsi Trantow', 'Salary', 222, '2024-10-15 03:05:15', '2024-10-15 03:05:15'),
(17, 30, '90k_100k', 'Self Employed', 'jfkdsajf', 'Salary', 2543, '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(18, 31, '100k+', 'Employed', 'fasdf', 'Salary', 6346, '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(19, 32, '20k_30k', 'Retired', '24532', 'Salary', 52345, '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(20, 33, '40k_50k', 'Self Employed', 'hamza', 'Salary', 123, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(21, 34, '100k+', 'Employed', 'Francisco McCullough', 'Other', 12, '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 36, '20k_30k', 'Employed', NULL, 'Salary', 345, '2024-10-16 01:45:31', '2024-10-16 01:45:31'),
(24, 37, '20k_30k', 'Employed', NULL, 'Salary', 345, '2024-10-16 01:46:42', '2024-10-16 01:46:42'),
(25, 38, '20k_30k', 'Employed', NULL, 'Salary', 345, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(26, 39, '10k_20k', 'Employed', NULL, 'Benefits', 99, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `household_info`
--

CREATE TABLE `household_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `household_size` varchar(100) DEFAULT NULL,
  `household_moving_reason` varchar(255) DEFAULT NULL,
  `number_of_adults` int(10) UNSIGNED DEFAULT NULL,
  `number_of_children` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `household_info`
--

INSERT INTO `household_info` (`id`, `user_id`, `household_size`, `household_moving_reason`, `number_of_adults`, `number_of_children`, `created_at`, `updated_at`) VALUES
(5, 16, '399', NULL, 318, 108, '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(6, 17, '454', NULL, 57, 473, '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(10, 24, '900090', NULL, 5, 45, '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(12, 28, '45', NULL, 5234, 543, '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(13, 29, '43', NULL, 34, 34, '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(14, 30, '99879', NULL, 98098, 8808, '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(15, 31, '5243', NULL, 4, 4, '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(16, 32, '432524', NULL, 234535, 523452, '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(17, 33, '500', NULL, 3, 4, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(18, 34, 'Wyomin', NULL, 333, 486, '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(20, 38, '12', NULL, 10, 2, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(21, 39, '9809', NULL, 52, 52, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_additional`
--

CREATE TABLE `landlord_additional` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(10) UNSIGNED NOT NULL,
  `special_note` text DEFAULT NULL,
  `property_photos` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_additional`
--

INSERT INTO `landlord_additional` (`id`, `landlord_id`, `special_note`, `property_photos`, `created_at`, `updated_at`) VALUES
(2, 2, 'dfsadf', NULL, '2024-06-03 00:23:02', '2024-06-03 00:23:02'),
(3, 3, 'Vermont', NULL, '2024-06-03 00:28:56', '2024-06-03 00:28:56'),
(4, 5, 'Vermont', NULL, '2024-06-03 00:30:21', '2024-06-03 00:30:21'),
(5, 6, 'Vermont', NULL, '2024-06-03 00:33:31', '2024-06-03 00:33:31'),
(6, 8, 'Vermont', NULL, '2024-06-03 00:34:25', '2024-06-03 00:34:25'),
(10, 12, 'Nebraska', NULL, '2024-06-03 00:59:26', '2024-06-03 00:59:26'),
(17, 19, 'fdsafsadfjlksjdfksajd fksad fjksafd jakdf aksfd a fdas fd safdsafsadfjlksjdfksajd fksad fjksafd jakdf aksfd a fdas fd safdsafsadfjlksjdfksajd fksad fjksafd jakdf aksfd a fdas fd safdsafsadfjlksjdfksajd fksad fjksafd jakdf aksfd a fdas fd safdsafsadfjlksjd', NULL, '2024-10-10 06:40:28', '2024-10-10 06:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_personal`
--

CREATE TABLE `landlord_personal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `status` smallint(5) DEFAULT 0 COMMENT '0=>inactive,\r\n1=>active\r\n',
  `enquiry_status` smallint(5) NOT NULL DEFAULT 1 COMMENT '1=>Available, 2=>Blocked, 3=>Booked',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_personal`
--

INSERT INTO `landlord_personal` (`id`, `full_name`, `email`, `phone_number`, `company_name`, `status`, `enquiry_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Vladimir Bahringer', 'your.email+fakedata75574@gmail.com', '320', 'Howell LLC', 0, 1, NULL, 1, '2024-06-26 00:23:02', '2024-10-16 00:56:00'),
(3, 'Marcelo Dibbert', 'your.email+fakedata79851@gmail.com', '555', 'Thiel, Bartell and Nikolaus', 0, 1, NULL, 1, '2024-06-26 00:28:56', '2024-10-16 00:56:01'),
(5, 'Marcelo Dibbert', 'asdyour.email+fakedata79851@gmail.com', '555', 'Thiel, Bartell and Nikolaus', 1, 1, NULL, 1, '2024-06-28 00:30:21', '2024-07-06 03:27:48'),
(6, 'Marcelo Dibbert', 'assddyour.email+fakedata79851@gmail.com', '555', 'Thiel, Bartell and Nikolaus', 1, 1, NULL, 1, '2024-06-29 00:33:31', '2024-07-06 03:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_property`
--

CREATE TABLE `landlord_property` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(10) UNSIGNED DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `appartment_number` varchar(100) DEFAULT NULL,
  `neighbourhood` varchar(100) DEFAULT NULL,
  `property_type` varchar(100) DEFAULT NULL,
  `number_of_units` int(10) UNSIGNED DEFAULT NULL,
  `year_built` int(10) UNSIGNED DEFAULT NULL,
  `major_renovation` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_property`
--

INSERT INTO `landlord_property` (`id`, `landlord_id`, `street_address`, `appartment_number`, `neighbourhood`, `property_type`, `number_of_units`, `year_built`, `major_renovation`, `created_at`, `updated_at`) VALUES
(2, 2, '22757 Hoeger Spurs', '580', 'Distinctio consequuntur exercitationem hic dolore aliquid laboriosam quisquam.', 'Studio', 565, 459, 85, '2024-06-03 00:23:02', '2024-06-03 00:23:02'),
(3, 3, '326 Bernita Circles', '409', 'Error repellendus reiciendis optio in.', 'House', 123, 512, 87, '2024-06-03 00:28:56', '2024-06-03 00:28:56'),
(4, 5, '326 Bernita Circles', '409', 'Error repellendus reiciendis optio in.', 'House', 123, 512, 87, '2024-06-03 00:30:21', '2024-06-03 00:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_property_images`
--

CREATE TABLE `landlord_property_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(10) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_property_images`
--

INSERT INTO `landlord_property_images` (`id`, `landlord_id`, `file_name`, `path`, `created_at`, `updated_at`) VALUES
(10, 3, 'Uqm7KjpPZ4ghNiXxEjd2jkeMyRDSMlJ0.png', '/uploads/property_photos/y2xg5V2LO0E0W4OZ1R1BkrRFEt2KQhZT.png', '2024-06-11 01:26:07', '2024-06-11 01:26:07'),
(14, 19, 'ac-1.jpg', '/public/uploads/property_photos/c5qvnpXqfjV2awcKSE8nq3NWiIzqSxif.jpg', '2024-10-10 06:40:28', '2024-10-10 06:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_rental`
--

CREATE TABLE `landlord_rental` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(10) UNSIGNED DEFAULT NULL,
  `size_square_feet` int(10) UNSIGNED DEFAULT NULL,
  `number_of_bedrooms` int(10) UNSIGNED DEFAULT NULL,
  `number_of_bathrooms` int(10) UNSIGNED DEFAULT NULL,
  `rental_type` varchar(100) DEFAULT NULL,
  `monthly_rent` decimal(8,2) DEFAULT NULL,
  `security_deposit` decimal(8,2) DEFAULT NULL,
  `lease_duration` int(10) UNSIGNED DEFAULT NULL,
  `renwal_option` varchar(100) DEFAULT NULL,
  `list_of_amenities` varchar(255) DEFAULT NULL,
  `special_feature` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_rental`
--

INSERT INTO `landlord_rental` (`id`, `landlord_id`, `size_square_feet`, `number_of_bedrooms`, `number_of_bathrooms`, `rental_type`, `monthly_rent`, `security_deposit`, `lease_duration`, `renwal_option`, `list_of_amenities`, `special_feature`, `created_at`, `updated_at`) VALUES
(2, 2, 161, 263, 647, 'Unfurnished', 651.00, NULL, 297, 'Monthly', 'Bailey', 'Distinctio fuga error molestiae dolores ut.', '2024-06-03 00:23:02', '2024-06-03 00:23:02'),
(3, 3, 641, 201, 509, 'Furnished', 76.00, NULL, 482, 'Half Yearly', 'Bradtke', 'Voluptatem distinctio aut consequatur iure ipsum nulla.', '2024-06-03 00:28:56', '2024-06-03 00:28:56'),
(4, 5, 641, 201, 509, 'Furnished', 76.00, NULL, 482, 'Half Yearly', 'Bradtke', 'Voluptatem distinctio aut consequatur iure ipsum nulla.', '2024-06-03 00:30:21', '2024-06-03 00:30:21'),
(5, 6, 641, 201, 509, 'Furnished', 76.00, NULL, 482, 'Half Yearly', 'Bradtke', 'Voluptatem distinctio aut consequatur iure ipsum nulla.', '2024-06-03 00:33:31', '2024-06-03 00:33:31'),
(6, 8, 641, 201, 509, 'Furnished', 76.00, NULL, 482, 'Half Yearly', 'Bradtke', 'Voluptatem distinctio aut consequatur iure ipsum nulla.', '2024-06-03 00:34:25', '2024-06-03 00:34:25'),
(10, 12, 75, 516, 514, 'Furnished', 488.00, NULL, 347, 'Monthly', 'Waelchi', 'Est ea accusamus.', '2024-06-03 00:59:26', '2024-06-03 00:59:26'),
(17, 19, 52345, 523, 532, 'Furnished', 3425.00, 5353.00, 234, 'Quarterly', 'fdsaf', 'fsadf', '2024-10-10 06:40:28', '2024-10-10 06:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_tenant`
--

CREATE TABLE `landlord_tenant` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `landlord_id` int(10) UNSIGNED NOT NULL,
  `tenant_characteristics` varchar(255) DEFAULT NULL,
  `credit_score` varchar(100) DEFAULT NULL,
  `income_requirements` varchar(100) DEFAULT NULL,
  `rental_history` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landlord_tenant`
--

INSERT INTO `landlord_tenant` (`id`, `landlord_id`, `tenant_characteristics`, `credit_score`, `income_requirements`, `rental_history`, `created_at`, `updated_at`) VALUES
(2, 2, 'Placeat nobis atque iste sapie', 'Pasadena', '563 Paula Ranch', 'Est nobis magni ducimus.', '2024-06-03 00:23:02', '2024-06-03 00:23:02'),
(3, 3, 'Distinctio sapiente quasi porro deleniti qui nam mir praesentium inventore nobis.Dolore sicusantium nulla fugit excepturi aperiam in', 'Lincoln', '104 Lind Field', 'Officia ut sed odit.', '2024-06-03 00:28:56', '2024-06-03 00:28:56'),
(4, 5, 'Distinctio sapiente quasi porro deleniti qui nam mir praesentium inventore nobis.Dolore sicusantium nulla fugit excepturi aperiam in', 'Lincoln', '104 Lind Field', 'Officia ut sed odit.', '2024-06-03 00:30:21', '2024-06-03 00:30:21'),
(5, 6, 'Distinctio sapiente quasi porro deleniti qui nam mir praesentium inventore nobis.Dolore sicusantium nulla fugit excepturi aperiam in', 'Lincoln', '104 Lind Field', 'Officia ut sed odit.', '2024-06-03 00:33:31', '2024-06-03 00:33:31'),
(6, 8, 'Distinctio sapiente quasi porro deleniti qui nam mir praesentium inventore nobis.Dolore sicusantium nulla fugit excepturi aperiam in', 'Lincoln', '104 Lind Field', 'Officia ut sed odit.', '2024-06-03 00:34:25', '2024-06-03 00:34:25'),
(10, 12, 'Delectus placeat explicabo minus ne', 'Perth Amboy', '5622 Michaela Valleys', 'In alias illo culpa aut eligendi.', '2024-06-03 00:59:26', '2024-06-03 00:59:26'),
(17, 19, 'fsffasdf', 'fads', 'fasdfad', 'fdsafa', '2024-10-10 06:40:28', '2024-10-10 06:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `legal_compliance`
--

CREATE TABLE `legal_compliance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `criminal_record` varchar(10) DEFAULT NULL,
  `legal_right` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_compliance`
--

INSERT INTO `legal_compliance` (`id`, `user_id`, `criminal_record`, `legal_right`, `created_at`, `updated_at`) VALUES
(4, 16, 'Yes', 'Visa Holder', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(5, 17, 'Yes', 'Visa Holder', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(9, 24, 'No', 'Visa Holder', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(11, 28, 'Yes', 'Citizen', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(12, 29, 'Yes', 'Citizen', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(13, 30, 'Yes', 'Citizen', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(14, 31, 'Yes', 'Citizen', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(15, 32, 'Yes', 'Citizen', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(16, 33, 'Yes', 'Citizen', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(17, 34, 'No', 'Visa Holder', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(19, 38, 'No', 'Citizen', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(20, 39, 'Yes', 'Visa Holder', '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `living_situation`
--

CREATE TABLE `living_situation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `current_address` varchar(255) DEFAULT NULL,
  `moving_reason` varchar(255) DEFAULT NULL,
  `prev_landlord_contact` varchar(100) DEFAULT NULL,
  `lease_violation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `living_situation`
--

INSERT INTO `living_situation` (`id`, `user_id`, `current_address`, `moving_reason`, `prev_landlord_contact`, `lease_violation`, `created_at`, `updated_at`) VALUES
(8, 16, '475 Goodwin Harbor', 'Tempore ratione molestiae.', 'Bermuda', 'Hoeger', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(9, 17, '705 Medhurst Bypass', 'Quis non recusandae.', 'Mayotte', 'Grady', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(13, 24, 'address', 'reason', 'adfdsf', 'fdfadf', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(15, 28, 'flkdsajkfl', 'fasdkjfldasj', 'jkasdflka', 'kjasdlfjla', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(16, 29, 'jkjaskdjf', 'fkdfs', 'faksdfjal', 'fndsfklads', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(17, 30, 'jfsalkd', 'jfaksld', 'fads', 'fasd', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(18, 31, 'fdsafdfsf', 'fadsfas', 'fasdfsa', 'fsadfas', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(19, 32, 'asdffa', 'fadsfsad', 'fsdfasf', 'fasdfads', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(20, 33, 'abc bahria town', 'reason', '2312', NULL, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(21, 34, '370 Harber Glens', 'Ipsa facilis exercitationem voluptatibus natus ad.', 'Ukraine', 'Howell', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 36, 'fsda', NULL, NULL, NULL, '2024-10-16 01:45:31', '2024-10-16 01:45:31'),
(24, 37, 'fsda', NULL, NULL, NULL, '2024-10-16 01:46:42', '2024-10-16 01:46:42'),
(25, 38, 'fsda', NULL, NULL, NULL, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(26, 39, 'jjkljl', NULL, NULL, NULL, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seq_no` smallint(5) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `enable` smallint(5) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `seq_no`, `name`, `route`, `image`, `enable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dashboard', 'admin.dashboard', 'assets/images/icon-home.svg', 1, '2024-06-04 08:11:55', NULL),
(2, 2, 'Admin Users', 'admin.admin_user', 'assets/images/icon-user.svg', 1, '2024-06-04 08:11:55', NULL),
(3, 3, 'Subscriptions', 'admin.subscription', 'assets/images/icon-pricing.svg', 1, '2024-06-04 08:11:55', NULL),
(4, 4, 'Landlord', 'admin.landlord', 'assets/images/icon-list.svg', 1, '2024-06-04 08:11:55', NULL),
(5, 5, 'Tenant', 'admin.tenant', 'assets/images/icon-list.svg', 1, '2024-06-04 08:11:55', NULL),
(6, 6, 'API Settings', 'admin.api_settings', 'assets/images/icon-cog-fill.svg', 1, '2024-06-04 08:11:55', NULL),
(7, 7, 'User Payments', 'admin.user_payments', 'assets/images/icon-credit-card.svg', 1, '2024-06-04 08:11:55', NULL),
(8, 8, 'User Subscriptions', 'admin.user_subscriptions', 'assets/images/icon-pricing.svg', 1, '2024-06-04 08:11:55', NULL),
(9, 9, 'Contact Us', 'admin.contact_us', 'assets/images/icon-help.svg', 1, '2024-06-04 08:11:55', NULL),
(10, 1, 'My Account', 'admin.my_account', 'assets/images/icon-user.svg', 1, '2024-06-04 08:11:55', NULL),
(11, 11, 'Enquiry Process', 'admin.enquiry_process', 'assets/images/icon-list.svg', 0, '2024-06-04 08:11:55', NULL),
(12, 11, 'Property Matches', 'admin.property_matches', 'assets/images/icon-match.svg', 1, '2024-06-04 08:11:55', NULL),
(13, 12, 'Required Documents', 'admin.required_documents', 'assets/images/icon-file.svg', 1, '2024-06-04 08:11:55', NULL),
(14, 12, 'Enquiry Requests', 'admin.enquiry_requests', 'assets/images/icon-reqdoc.svg', 1, '2024-06-04 08:11:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_control`
--

CREATE TABLE `menu_control` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_control`
--

INSERT INTO `menu_control` (`id`, `user_id`, `menu_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(29, 14, 1, NULL, 1, '2024-06-12 02:08:20', '2024-06-12 02:08:20'),
(30, 14, 2, NULL, 1, '2024-06-12 02:08:20', '2024-06-12 02:08:20'),
(31, 14, 3, NULL, 1, '2024-06-12 02:08:20', '2024-06-12 02:08:20'),
(32, 14, 10, NULL, 1, '2024-06-12 02:08:20', '2024-06-12 02:08:20'),
(33, 20, 3, 1, NULL, '2024-06-25 01:07:03', '2024-06-25 01:07:03'),
(34, 20, 4, 1, NULL, '2024-06-25 01:07:03', '2024-06-25 01:07:03'),
(35, 20, 5, 1, NULL, '2024-06-25 01:07:03', '2024-06-25 01:07:03'),
(36, 20, 7, 1, NULL, '2024-06-25 01:07:03', '2024-06-25 01:07:03'),
(37, 20, 14, 1, NULL, '2024-06-25 01:07:03', '2024-06-25 01:07:03'),
(48, 21, 3, NULL, 1, '2024-06-25 01:30:04', '2024-06-25 01:30:04'),
(49, 21, 4, NULL, 1, '2024-06-25 01:30:04', '2024-06-25 01:30:04'),
(50, 21, 6, NULL, 1, '2024-06-25 01:30:04', '2024-06-25 01:30:04'),
(51, 21, 13, NULL, 1, '2024-06-25 01:30:04', '2024-06-25 01:30:04'),
(52, 21, 14, NULL, 1, '2024-06-25 01:30:04', '2024-06-25 01:30:04'),
(53, 22, 1, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(54, 22, 2, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(55, 22, 3, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(56, 22, 4, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(57, 22, 5, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(58, 22, 8, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(59, 22, 9, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(60, 22, 12, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(61, 22, 13, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(62, 22, 14, 1, NULL, '2024-06-25 02:09:11', '2024-06-25 02:09:11'),
(71, 25, 1, 1, NULL, '2024-10-11 02:39:04', '2024-10-11 02:39:04'),
(72, 25, 3, 1, NULL, '2024-10-11 02:39:04', '2024-10-11 02:39:04'),
(73, 25, 7, 1, NULL, '2024-10-11 02:39:04', '2024-10-11 02:39:04'),
(74, 25, 13, 1, NULL, '2024-10-11 02:39:04', '2024-10-11 02:39:04'),
(75, 26, 5, 1, NULL, '2024-10-11 02:40:26', '2024-10-11 02:40:26'),
(76, 26, 6, 1, NULL, '2024-10-11 02:40:26', '2024-10-11 02:40:26'),
(77, 26, 7, 1, NULL, '2024-10-11 02:40:27', '2024-10-11 02:40:27'),
(78, 26, 10, 1, NULL, '2024-10-11 02:40:27', '2024-10-11 02:40:27'),
(79, 26, 12, 1, NULL, '2024-10-11 02:40:27', '2024-10-11 02:40:27'),
(88, 13, 1, NULL, 1, '2024-10-19 02:08:46', '2024-10-19 02:08:46'),
(89, 13, 12, NULL, 1, '2024-10-19 02:08:46', '2024-10-19 02:08:46'),
(90, 13, 13, NULL, 1, '2024-10-19 02:08:46', '2024-10-19 02:08:46'),
(91, 13, 14, NULL, 1, '2024-10-19 02:08:46', '2024-10-19 02:08:46'),
(92, 40, 1, 1, NULL, '2024-10-19 02:29:04', '2024-10-19 02:29:04'),
(93, 40, 2, 1, NULL, '2024-10-19 02:29:04', '2024-10-19 02:29:04'),
(94, 40, 3, 1, NULL, '2024-10-19 02:29:04', '2024-10-19 02:29:04'),
(160, 2, 1, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(161, 2, 2, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(162, 2, 3, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(163, 2, 4, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(164, 2, 5, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(165, 2, 6, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(166, 2, 7, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(167, 2, 8, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(168, 2, 9, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(169, 2, 10, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(170, 2, 12, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(171, 2, 13, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(172, 2, 14, NULL, 2, '2024-10-19 03:19:38', '2024-10-19 03:19:38'),
(173, 3, 2, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(174, 3, 3, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(175, 3, 4, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(176, 3, 5, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(177, 3, 7, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(178, 3, 8, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(179, 3, 9, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06'),
(180, 3, 10, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(24, '2024_05_31_080243_create_additoinal_note_table', 2),
(53, '2014_10_12_100000_create_password_reset_tokens_table', 3),
(54, '2019_08_19_000000_create_failed_jobs_table', 3),
(55, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(56, '2024_05_27_114725_create_pricing_plans_table', 3),
(57, '2024_05_30_101442_create_landlord_personal_table', 3),
(58, '2024_05_30_101733_create_landlord_property_table', 3),
(59, '2024_05_30_102011_create_landlord_rental_table', 3),
(60, '2024_05_30_110053_create_landlord_tenant_table', 3),
(61, '2024_05_30_110334_create_landlord_additional_table', 3),
(62, '2024_05_31_053204_create_user_personal_info_table', 3),
(63, '2024_05_31_053605_create_residential_preference_table', 3),
(64, '2024_05_31_053910_create_financial_information_table', 3),
(65, '2024_05_31_054239_create_rental_assistance_table', 3),
(66, '2024_05_31_060016_create_living_situation_table', 3),
(67, '2024_05_31_060149_create_household_info_table', 3),
(68, '2024_05_31_060328_create_pet_information_table', 3),
(69, '2024_05_31_062601_create_accommodation_requirements_table', 3),
(70, '2024_05_31_065802_create_additional_requirements_table', 3),
(71, '2024_05_31_075908_create_legal_compliance_table', 3),
(72, '2024_05_31_080059_create_user_references_table', 3),
(74, '2024_05_31_080359_create_documents_table', 3),
(77, '2024_06_03_051008_create_landlord_property_images_table', 4),
(78, '2024_06_04_080053_create_menu_table', 5),
(79, '2024_06_04_121110_create_menu_control_table', 6),
(81, '2024_05_31_080243_create_additional_note_table', 7),
(82, '2024_06_06_112622_create_api_settings_table', 8),
(83, '2024_06_07_064952_create_user_subscription_table', 9),
(84, '2024_06_07_070027_create_user_payments_table', 10),
(85, '2024_05_31_094652_create_contact_us_table', 11),
(86, '2024_06_12_105923_create_enquiry_process_table', 12),
(87, '2024_06_12_105923_create_enquiry_header_table', 13),
(88, '2024_06_13_053614_create_enquiry_detail_table', 14),
(89, '2024_06_13_055427_create_enquiry_document_table', 15),
(91, '2024_06_14_180541_create_required_documents_table', 16),
(92, '2024_06_13_055427_create_tenant_enquiry_documents_table', 17),
(93, '2024_06_20_070924_create_property_matches_table', 18),
(94, '2024_06_12_105923_create_tenant_enquiry_header_table', 19),
(96, '2024_06_13_053614_create_tenant_enquiry_requests_table', 20),
(97, '2024_06_28_045714_create_notifications_table', 21),
(98, '2014_10_12_000000_create_users_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_code` varchar(255) NOT NULL,
  `from_user_id` int(10) UNSIGNED DEFAULT NULL,
  `to_user_id` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `read_flag` smallint(6) DEFAULT NULL COMMENT '0=>unread,1=>read',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `module_code`, `from_user_id`, `to_user_id`, `subject`, `message`, `read_flag`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SUB-ADMIN ACTIVATION', 1, 21, 'Activate Sub-Admin', 'Your account will now active, kindly login from below link.', 0, 1, NULL, '2024-06-28 01:25:13', '2024-06-28 01:25:13'),
(2, 'SUB-ADMIN ACTIVATION', 1, 21, 'Activate Sub-Admin', 'Your account will now active, kindly login from below link.', 0, 1, NULL, '2024-06-28 01:25:29', '2024-06-28 01:25:29'),
(4, 'TENANT ACTIVATION', 1, 18, 'Activate Tenant', 'Your account will now active, you can login your account.', 0, 1, NULL, '2024-06-28 01:37:26', '2024-06-28 01:37:26'),
(5, 'ENQUIRY REQUEST', 16, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 1, 16, NULL, '2024-06-28 02:22:50', '2024-06-28 05:37:34'),
(6, 'ENQUIRY REQUEST', 15, 1, 'Tenant Enquiry Request', 'Thank you for submitting the application request. The application has been received and is currently under review. Our team will contact you shortly with further details.', 1, 15, NULL, '2024-06-28 05:10:15', '2024-06-28 05:37:34'),
(7, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Confirmed', 'Your application request is confirmed by admin. Our team will contact you shortly with further details.', 1, 1, NULL, '2024-06-28 05:10:52', '2024-06-28 05:39:14'),
(8, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Request Document', 'Your application request is in process kindly upload requested documents for further process.', 1, 1, NULL, '2024-06-28 05:12:49', '2024-06-28 05:39:14'),
(9, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 1, 15, NULL, '2024-06-28 05:14:52', '2024-06-28 05:37:34'),
(10, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Approved', 'Your application request is approved by admin.', 1, 1, NULL, '2024-06-28 05:37:48', '2024-06-28 05:39:14'),
(11, 'ENQUIRY REQUEST', 15, 1, 'Tenant Enquiry Request', 'Thank you for submitting the application request. The application has been received and is currently under review. Our team will contact you shortly with further details.', 0, 15, NULL, '2024-06-28 06:03:00', '2024-06-28 06:03:00'),
(12, 'SUB-ADMIN ACTIVATION', 1, 12, 'Activate Sub-Admin', 'Your account will now active, you can login your account', 0, 1, NULL, '2024-06-28 06:16:46', '2024-06-28 06:16:46'),
(13, 'ENQUIRY REQUEST', 13, 16, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 13, NULL, '2024-07-01 05:32:47', '2024-07-01 05:32:47'),
(14, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Confirmed', 'Your application request is confirmed by admin. Our team will contact you shortly with further details.', 0, 1, NULL, '2024-07-06 00:42:12', '2024-07-06 00:42:12'),
(15, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Request Document', 'Your application request is in process kindly upload requested documents for further process.', 0, 1, NULL, '2024-07-06 00:42:38', '2024-07-06 00:42:38'),
(16, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 00:59:12', '2024-07-06 00:59:12'),
(17, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 00:59:36', '2024-07-06 00:59:36'),
(18, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 01:00:15', '2024-07-06 01:00:15'),
(19, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:20:51', '2024-07-06 02:20:51'),
(20, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:21:57', '2024-07-06 02:21:57'),
(21, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:23:08', '2024-07-06 02:23:08'),
(22, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:26:39', '2024-07-06 02:26:39'),
(23, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:27:25', '2024-07-06 02:27:25'),
(24, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:28:28', '2024-07-06 02:28:28'),
(25, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:35:00', '2024-07-06 02:35:00'),
(26, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:43:37', '2024-07-06 02:43:37'),
(27, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:44:28', '2024-07-06 02:44:28'),
(28, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:51:03', '2024-07-06 02:51:03'),
(29, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:52:54', '2024-07-06 02:52:54'),
(30, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:55:07', '2024-07-06 02:55:07'),
(31, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 02:56:19', '2024-07-06 02:56:19'),
(32, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 02:56:50', '2024-07-06 02:56:50'),
(33, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 03:03:44', '2024-07-06 03:03:44'),
(34, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 03:08:51', '2024-07-06 03:08:51'),
(35, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Returned', 'Your application request is returned by admin. Kindly reupload document and submit.', 0, 1, NULL, '2024-07-06 03:10:17', '2024-07-06 03:10:17'),
(36, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 03:10:54', '2024-07-06 03:10:54'),
(37, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Approved', 'Your application request is approved by admin.', 0, 1, NULL, '2024-07-06 03:11:17', '2024-07-06 03:11:17'),
(38, 'ENQUIRY REQUEST', 15, 1, 'Tenant Enquiry Request', 'Thank you for submitting the application request. The application has been received and is currently under review. Our team will contact you shortly with further details.', 0, 15, NULL, '2024-07-06 03:12:11', '2024-07-06 03:12:11'),
(39, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Confirmed', 'Your application request is confirmed by admin. Our team will contact you shortly with further details.', 0, 1, NULL, '2024-07-06 03:12:22', '2024-07-06 03:12:22'),
(40, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Request Document', 'Your application request is in process kindly upload requested documents for further process.', 0, 1, NULL, '2024-07-06 03:12:31', '2024-07-06 03:12:31'),
(41, 'ENQUIRY REQUEST', 15, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 15, NULL, '2024-07-06 03:13:07', '2024-07-06 03:13:07'),
(42, 'ENQUIRY REQUEST', 1, 15, 'Enquiry Process Application Cancelled', 'Your application request is cancelled by admin. if you have any query contact admin.', 0, 1, NULL, '2024-07-06 03:13:32', '2024-07-06 03:13:32'),
(43, 'BUY SUBSCRIPTION', 15, 1, 'Tenant Buy Plan', 'The tenant has successfully purchased/update a Tier 02 subscription.', 0, 15, NULL, '2024-07-06 07:27:14', '2024-07-06 07:27:14'),
(44, 'BUY SUBSCRIPTION', 15, 1, 'Tenant Buy Plan', 'The tenant has successfully purchased/update a Tier 03 subscription.', 0, 15, NULL, '2024-07-06 07:27:57', '2024-07-06 07:27:57'),
(45, 'TENANT REGISTRATION', 23, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 23, NULL, '2024-10-10 04:06:30', '2024-10-10 04:06:30'),
(46, 'TENANT REGISTRATION', 24, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 24, NULL, '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(47, 'BUY SUBSCRIPTION', 16, 1, 'Tenant Buy Plan', 'The tenant has successfully purchased/update a Tier 01 subscription.', 0, 16, NULL, '2024-10-11 00:57:04', '2024-10-11 00:57:04'),
(48, 'ENQUIRY REQUEST', 16, 1, 'Tenant Document Upload', 'The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.', 0, 16, NULL, '2024-10-11 02:29:05', '2024-10-11 02:29:05'),
(49, 'SUB-ADMIN REGISTER', 1, 25, 'Welcome to LEASE MATCH!', 'We\'re excited to have you on board.', 0, 1, NULL, '2024-10-11 02:39:04', '2024-10-11 02:39:04'),
(50, 'SUB-ADMIN ACTIVATION', 1, 25, 'Activate Sub-Admin', 'Your account will now active, you can login your account', 0, 1, NULL, '2024-10-11 02:39:17', '2024-10-11 02:39:17'),
(51, 'SUB-ADMIN REGISTER', 1, 26, 'Welcome to LEASE MATCH!', 'We\'re excited to have you on board.', 0, 1, NULL, '2024-10-11 02:40:27', '2024-10-11 02:40:27'),
(52, 'SUB-ADMIN ACTIVATION', 1, 26, 'Activate Sub-Admin', 'Your account will now active, you can login your account', 0, 1, NULL, '2024-10-11 02:40:39', '2024-10-11 02:40:39'),
(53, 'SUB-ADMIN ACTIVATION', 1, 25, 'Activate Sub-Admin', 'Your account will now active, you can login your account', 0, 1, NULL, '2024-10-11 02:40:56', '2024-10-11 02:40:56'),
(54, 'SUB-ADMIN ACTIVATION', 1, 26, 'Activate Sub-Admin', 'Your account will now active, you can login your account', 0, 1, NULL, '2024-10-11 02:41:03', '2024-10-11 02:41:03'),
(55, 'TENANT REGISTRATION', 27, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 27, NULL, '2024-10-15 02:32:22', '2024-10-15 02:32:22'),
(56, 'TENANT REGISTRATION', 28, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 28, NULL, '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(57, 'TENANT REGISTRATION', 29, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 29, NULL, '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(58, 'TENANT REGISTRATION', 30, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 30, NULL, '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(59, 'TENANT REGISTRATION', 31, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 31, NULL, '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(60, 'TENANT REGISTRATION', 32, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 32, NULL, '2024-10-15 04:28:59', '2024-10-15 04:28:59'),
(61, 'TENANT REGISTRATION', 33, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 33, NULL, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(62, 'TENANT REGISTRATION', 34, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 34, NULL, '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(63, 'TENANT REGISTRATION', 35, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 35, NULL, '2024-10-15 04:48:00', '2024-10-15 04:48:00'),
(64, 'TENANT REGISTRATION', 38, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 38, NULL, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(65, 'TENANT REGISTRATION', 39, 1, 'Tenant Registration', 'Tenant is successfully registered to you portal, kindly review tenant details.', 0, 39, NULL, '2024-10-16 01:58:30', '2024-10-16 01:58:30'),
(66, 'SUB-ADMIN REGISTER', 1, 40, 'Welcome to LEASE MATCH!', 'We\'re excited to have you on board.', 0, 1, NULL, '2024-10-19 02:29:04', '2024-10-19 02:29:04'),
(67, 'SUB-ADMIN REGISTER', 2, 3, 'Welcome to LEASE MATCH!', 'We\'re excited to have you on board.', 0, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 03:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_information`
--

CREATE TABLE `pet_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `has_pets` varchar(10) DEFAULT NULL,
  `pet_type` varchar(100) DEFAULT NULL,
  `number_of_pets` int(10) UNSIGNED DEFAULT NULL,
  `pet_size` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_information`
--

INSERT INTO `pet_information` (`id`, `user_id`, `has_pets`, `pet_type`, `number_of_pets`, `pet_size`, `created_at`, `updated_at`) VALUES
(5, 16, 'No', '71726 Dominic Cape', 399, '- Select a Pet Size -', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(6, 17, 'Yes', '462 Hills Extension', 181, 'Small', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(10, 24, 'Yes', 'fdds', 9, 'Small', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(12, 28, 'Yes', 'skldjf', 524, 'Small', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(13, 29, 'Yes', '4', 4, 'Small', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(14, 30, 'Yes', '98', 8, 'Small', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(15, 31, 'Yes', '43', 4, 'Small', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(16, 32, 'Yes', '5234', 524, 'Small', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(17, 33, 'No', NULL, NULL, NULL, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(18, 34, 'Yes', '256 Newton Place', 224, 'Large', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(20, 38, 'No', NULL, NULL, NULL, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(21, 39, 'No', NULL, NULL, NULL, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `initial_price` double(8,2) DEFAULT NULL,
  `monthly_price` double(8,2) DEFAULT NULL,
  `number_of_matches` int(11) DEFAULT NULL,
  `directly_contact_flag` smallint(6) DEFAULT 0 COMMENT '0=>disable, 1=>enable',
  `process_application_flag` smallint(6) DEFAULT 0 COMMENT '0=>disable, 1=>enable',
  `necessary_doc_flag` smallint(6) DEFAULT 0 COMMENT '0=>disable, 1=>enable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_plans`
--

INSERT INTO `pricing_plans` (`id`, `title`, `initial_price`, `monthly_price`, `number_of_matches`, `directly_contact_flag`, `process_application_flag`, `necessary_doc_flag`, `created_at`, `updated_at`) VALUES
(1, 'Tier 01', 15.00, 10.00, 0, 0, 0, 0, '2024-06-12 02:33:28', '2024-06-12 02:33:28'),
(2, 'Tier 02', 15.00, 20.00, 5, 1, 0, 1, '2024-06-24 05:58:05', '2024-06-24 05:58:05'),
(3, 'Tier 03', 15.00, 30.00, 5, 1, 1, 1, '2024-06-24 05:58:12', '2024-06-24 05:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `property_matches`
--

CREATE TABLE `property_matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `landlord_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_matches`
--

INSERT INTO `property_matches` (`id`, `user_id`, `landlord_id`, `date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 15, 3, '2024-06-21', 1, NULL, '2024-06-21 03:13:15', '2024-06-21 03:13:15'),
(6, 15, 5, '2024-06-21', 1, NULL, '2024-06-21 05:10:21', '2024-06-21 05:10:21'),
(7, 15, 6, '2024-06-21', 1, NULL, '2024-06-21 05:10:23', '2024-06-21 05:10:23'),
(8, 15, 8, '2024-06-21', 1, NULL, '2024-06-21 05:10:26', '2024-06-21 05:10:26'),
(15, 15, 1, '2024-10-12', 1, NULL, '2024-10-12 02:44:48', '2024-10-12 02:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `rental_assistance`
--

CREATE TABLE `rental_assistance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `rental_voucher` varchar(10) DEFAULT NULL,
  `voucher_type` varchar(100) DEFAULT NULL,
  `certification_detail` varchar(255) DEFAULT NULL,
  `certification_expiry` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rental_assistance`
--

INSERT INTO `rental_assistance` (`id`, `user_id`, `rental_voucher`, `voucher_type`, `certification_detail`, `certification_expiry`, `created_at`, `updated_at`) VALUES
(8, 16, 'Yes', 'Other', 'CERTIFICATE DETAIL', '2024-10-24', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(9, 17, 'No', 'Other', 'your.email+fakedata22080@gmail.com', '2024-05-07', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(13, 24, 'Yes', 'Section 8', 'kllkl', '2024-10-12', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(15, 28, 'Yes', 'SOTA', 'jkdlsajf', '2024-10-16', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(16, 29, 'Yes', 'SOTA', 'ujkljk', '2024-10-16', '2024-10-15 03:05:15', '2024-10-15 03:05:15'),
(17, 30, 'Yes', 'Section 8', 'dsfakfjk', '2024-10-16', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(18, 31, 'Yes', 'Section 8', '6365', '2024-10-16', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(19, 32, 'Yes', 'Section 8', '52345', '2024-10-16', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(20, 33, 'No', 'SOTA', NULL, NULL, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(21, 34, 'Yes', 'CityFheps', 'your.email+fakedata95391@gmail.com', '2024-11-08', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 36, 'Yes', 'Section 8', 'adsfsad', '2024-10-17', '2024-10-16 01:45:31', '2024-10-16 01:45:31'),
(24, 37, 'Yes', 'Section 8', 'adsfsad', '2024-10-17', '2024-10-16 01:46:42', '2024-10-16 01:46:42'),
(25, 38, 'Yes', 'Section 8', 'adsfsad', '2024-10-17', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(26, 39, 'Yes', 'SOTA', 'jkj', '2024-10-17', '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `required_documents`
--

CREATE TABLE `required_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `required_documents`
--

INSERT INTO `required_documents` (`id`, `name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Lease Requirement Exception for First-Time Renters', 'Current lease in the name of the applicant unless the applicant is a first time renter.', 1, 1, NULL, '2024-06-14 03:11:14', '2024-06-28 00:52:55'),
(2, 'Government-Issued Photo ID Requirement.', 'Two forms of photo identification, issued by US Government, State or municipality such as\r\npassport, resident card, and driver\'s license.', 1, 1, NULL, '2024-06-21 06:25:44', '2024-06-27 01:35:30'),
(3, 'Household Documentation Requirements', 'Birth certificate of any children. Social Security Card of all household member.', 1, 1, NULL, '2024-06-22 07:35:07', '2024-06-27 02:12:58'),
(4, 'Utility/Phone Bill Verification', 'Last 3 consecutive months of utility or phone bill in your name.', 1, 1, NULL, '2024-06-22 07:37:03', '2024-06-27 02:13:38'),
(5, '6 recent consecutive pay stubs', '6 recent consecutive pay stubs', 1, 1, NULL, '2024-06-22 07:37:12', '2024-06-27 02:13:50'),
(6, 'Original employment letter on company letterhead', 'Original employment letter on company letterhead', 1, 1, NULL, '2024-06-22 07:37:36', '2024-06-27 02:18:32'),
(7, 'Self-Employment Income Verification', 'Self-Employed: Notarized Letter fiom accountant or tax preparer projecting current year\'s\r\nearning', 1, 1, NULL, '2024-06-27 01:33:53', '2024-06-27 02:14:34'),
(8, 'Income Tax Returns Verification', 'Last 2 years of income tax returns with W-2(s) [1099(s) and all other schedules if applicable]', 1, 1, NULL, '2024-06-27 02:15:09', '2024-06-27 02:15:09'),
(9, 'Pension/SSI/Public Assistance Awards)', 'Pension/SSI/Public Assistance Awards)', 1, 1, NULL, '2024-06-27 02:15:21', '2024-06-27 02:15:21'),
(10, 'Proof of child support (if applicable)', 'Proof of child support (if applicable)', 1, 1, NULL, '2024-06-27 02:15:29', '2024-06-27 02:15:29'),
(11, 'Bank Statements Verification', '6 months of recent consecutive bank statements', 1, 1, NULL, '2024-06-27 02:15:53', '2024-06-27 02:15:53'),
(12, 'Current Savings Account Statements', 'Current Savings Account Statements', 1, 1, NULL, '2024-06-27 02:16:18', '2024-06-27 02:16:18'),
(13, 'Rent Subsidy Verification', 'Rent Subsidy voucher such as Section 8 or any other program', 1, 1, NULL, '2024-06-27 02:16:54', '2024-06-27 02:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `residential_preference`
--

CREATE TABLE `residential_preference` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `preferred_location` varchar(100) DEFAULT NULL,
  `preferred_property_type` varchar(100) DEFAULT NULL,
  `min_bedrooms_needed` int(10) UNSIGNED DEFAULT NULL,
  `min_bathrooms_needed` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residential_preference`
--

INSERT INTO `residential_preference` (`id`, `user_id`, `preferred_location`, `preferred_property_type`, `min_bedrooms_needed`, `min_bathrooms_needed`, `created_at`, `updated_at`) VALUES
(8, 16, 'Brooklyn', 'House', 1, 2, '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(9, 17, 'Queens', 'House', 4, 3, '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(13, 24, 'Bronx', 'Apartment', 2, 1, '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(15, 28, 'Bronx', 'Apartment', 1, 1, '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(16, 29, 'Staten Island', 'Studio', 1, 1, '2024-10-15 03:05:15', '2024-10-15 03:05:15'),
(17, 30, 'Bronx', 'Condo', 1, 1, '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(18, 31, 'Bronx', 'Apartment', 1, 2, '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(19, 32, 'Staten Island', 'Condo', 1, 1, '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(20, 33, 'Staten Island', 'Apartment', 2, 1, '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(21, 34, 'Manhattan', 'House', 1, 4, '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 36, 'Bronx', 'Apartment', 1, 1, '2024-10-16 01:45:31', '2024-10-16 01:45:31'),
(24, 37, 'Bronx', 'Apartment', 1, 1, '2024-10-16 01:46:42', '2024-10-16 01:46:42'),
(25, 38, 'Bronx', 'Apartment', 1, 1, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(26, 39, 'Bronx', 'Apartment', 2, 2, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_enquiry_documents`
--

CREATE TABLE `tenant_enquiry_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enquiry_id` int(10) UNSIGNED DEFAULT NULL,
  `enquiry_request_id` int(10) UNSIGNED DEFAULT NULL,
  `document_id` int(10) UNSIGNED DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `status` smallint(5) DEFAULT NULL COMMENT '1=>Approved,\r\n2=>Returned,\r\n3=>Cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenant_enquiry_documents`
--

INSERT INTO `tenant_enquiry_documents` (`id`, `enquiry_id`, `enquiry_request_id`, `document_id`, `doc_name`, `path`, `status`, `created_at`, `updated_at`) VALUES
(10, 12, 38, 5, 'application.png', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/10/s1SH88EumD6Zfzbknbkb7LpeKtRwvm3H.png', NULL, '2024-06-26 05:29:36', '2024-07-06 02:23:08'),
(11, 12, 38, 3, 'enterprise.png', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/11/g85RhY4tN3rYCMV51MOmASIVpxZOAvek.png', NULL, '2024-06-26 05:29:36', '2024-07-06 02:23:08'),
(12, 13, 43, 1, 'vecteezy_air-conditioner-appliance_12909769.png', 'http://127.0.0.1:8000/public/uploads/tenant_enquiry_documents/12/MzHKjSDnQ1sOCOvxkC7TnPZTKpSU5c86.png', NULL, '2024-06-27 04:08:18', '2024-10-11 02:29:05'),
(13, 13, 43, 2, 'vecteezy_air-conditioner-appliance_12909773.png', 'http://127.0.0.1:8000/public/uploads/tenant_enquiry_documents/13/vLup8a7QxUS1GJf4ci7Xqn4rQmYG2dGQ.png', NULL, '2024-06-27 04:08:18', '2024-10-11 02:29:05'),
(14, 14, 47, 1, 'characteristic.png', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/14/peQzwjGAAPhBZSh8YstC1k0cFfUlrsEG.png', NULL, '2024-06-28 05:12:49', '2024-07-06 02:23:08'),
(15, 14, 47, 2, 'application.png', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/15/l4IdHMxT5kx3zkbgJWZulNDS841jQK5w.png', NULL, '2024-06-28 05:12:49', '2024-07-06 02:23:08'),
(16, 14, 47, 3, 'subscription-business-model.png', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/16/pB00hOwnyoOnRqviSkWLhhnPWQtzGkg9.png', NULL, '2024-06-28 05:12:49', '2024-07-06 02:23:08'),
(17, 15, 53, 1, 'leasematch parameters.pdf', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/17/njSaX3O0GOJQbxM1FYurCEvFbNH9qnFE.pdf', 1, '2024-07-06 00:42:38', '2024-07-06 03:11:17'),
(18, 15, 53, 2, 'Tenant Inquiry Form Edits.pdf', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/18/1XwzLSnIPefY4R6QaoJ81gP2darexzWV.pdf', 1, '2024-07-06 00:42:38', '2024-07-06 03:11:17'),
(19, 15, 53, 3, 'Required Docs LeaseMatch.pdf', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/19/N22LpWuu7RjeCIrfEFLWsLI288m5nmk3.pdf', 1, '2024-07-06 00:42:38', '2024-07-06 03:11:17'),
(20, 16, 79, 13, 'leasematch parameters.pdf', 'http://127.0.0.1:8000/uploads/tenant_enquiry_documents/20/C4CMctMzksGqEpmXZ7p8i41CL80kBsFQ.pdf', 3, '2024-07-06 03:12:31', '2024-07-06 03:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_enquiry_header`
--

CREATE TABLE `tenant_enquiry_header` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `landlord_id` int(10) UNSIGNED DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL COMMENT '1=>Application Requested, 2=>Application confirmed, 3=>waiting for doc confirm, 4=>waiting for doc upload, 5=>document uploaded, 6=>Document approved, 7=>Document return, 8=>Document cancel, \r\n9=>waiting',
  `date` date DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenant_enquiry_header`
--

INSERT INTO `tenant_enquiry_header` (`id`, `user_id`, `landlord_id`, `status`, `date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(12, 15, 3, 8, '2024-06-26', 15, NULL, '2024-06-26 02:47:34', '2024-06-26 06:12:22'),
(13, 16, 3, 5, '2024-06-26', 16, NULL, '2024-06-26 03:02:34', '2024-10-11 02:29:05'),
(14, 15, 5, 6, '2024-06-28', 15, NULL, '2024-06-28 05:10:15', '2024-06-28 05:37:48'),
(15, 15, 6, 6, '2024-06-28', 15, NULL, '2024-06-28 06:03:00', '2024-07-06 03:11:17'),
(16, 15, 8, 8, '2024-07-06', 15, NULL, '2024-07-06 03:12:11', '2024-07-06 03:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_enquiry_requests`
--

CREATE TABLE `tenant_enquiry_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enquiry_id` int(10) UNSIGNED DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL COMMENT '1=>Application Request, 2=>Doc Upload',
  `message` text DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL COMMENT '1=>Application Requested, \r\n                                                    2=>Application confirmed, \r\n                                                    3=>waiting for doc confirm, \r\n                                                    4=>waiting for doc upload, \r\n                                                    5=>document uploaded, \r\n                                                    6=>Document approved,\r\n                                                    7=>Document return,\r\n\r\n8=>Document cancel,\r\n\r\n9=>waiting',
  `date` date DEFAULT NULL,
  `submitted_by` varchar(100) DEFAULT NULL COMMENT '1=>Customer, 2=>Admin',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenant_enquiry_requests`
--

INSERT INTO `tenant_enquiry_requests` (`id`, `enquiry_id`, `type`, `message`, `status`, `date`, `submitted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(35, 12, 1, 'process my application request for this landlord', 1, '2024-06-26', '15', 15, NULL, '2024-06-26 02:47:34', '2024-06-26 02:47:34'),
(36, 13, 1, 'another request', 9, '2024-06-26', '16', 16, NULL, '2024-06-26 03:02:34', '2024-06-26 03:02:34'),
(37, 12, 1, 'Application confirmed by admin', 2, '2024-06-26', '1', 1, NULL, '2024-06-26 05:19:20', '2024-06-26 05:19:20'),
(38, 12, 1, 'Request for documents by admin', 4, '2024-06-26', '1', 1, NULL, '2024-06-26 05:29:36', '2024-06-26 05:29:36'),
(39, 12, 1, 'Documents uploaded by customer', 5, '2024-06-26', '15', 15, NULL, '2024-06-26 05:40:24', '2024-06-26 05:40:24'),
(40, 12, 1, 'Returned by admin', 7, '2024-06-26', '1', 1, NULL, '2024-06-26 06:00:17', '2024-06-26 06:00:17'),
(41, 12, 1, 'Cancelled by admin', 8, '2024-06-26', '1', 1, NULL, '2024-06-26 06:12:22', '2024-06-26 06:12:22'),
(42, 13, 1, 'Application confirmed by admin', 2, '2024-06-26', '1', 1, NULL, '2024-06-26 06:12:35', '2024-06-26 06:12:35'),
(43, 13, 1, 'Request for documents by admin', 4, '2024-06-27', '1', 1, NULL, '2024-06-27 04:08:18', '2024-06-27 04:08:18'),
(44, 13, 1, 'Documents uploaded by customer', 5, '2024-06-28', '16', 16, NULL, '2024-06-28 02:22:50', '2024-06-28 02:22:50'),
(45, 14, 1, 'aoooddd', 1, '2024-06-28', '15', 15, NULL, '2024-06-28 05:10:15', '2024-06-28 05:10:15'),
(46, 14, 1, 'Application confirmed by admin', 2, '2024-06-28', '1', 1, NULL, '2024-06-28 05:10:52', '2024-06-28 05:10:52'),
(47, 14, 1, 'Request for documents by admin', 4, '2024-06-28', '1', 1, NULL, '2024-06-28 05:12:49', '2024-06-28 05:12:49'),
(48, 14, 1, 'Documents uploaded by customer', 5, '2024-06-28', '15', 15, NULL, '2024-06-28 05:14:52', '2024-06-28 05:14:52'),
(49, 14, 1, 'Approved by admin', 6, '2024-06-28', '1', 1, NULL, '2024-06-28 05:37:48', '2024-06-28 05:37:48'),
(50, 15, 1, 'asdfasdf', 1, '2024-06-28', '15', 15, NULL, '2024-06-28 06:03:00', '2024-06-28 06:03:00'),
(51, 13, 1, 'Returned by admin', 7, '2024-07-01', '13', 13, NULL, '2024-07-01 05:32:47', '2024-07-01 05:32:47'),
(52, 15, 1, 'Application confirmed by admin', 2, '2024-07-06', '1', 1, NULL, '2024-07-06 00:42:12', '2024-07-06 00:42:12'),
(53, 15, 1, 'Request for documents by admin', 4, '2024-07-06', '1', 1, NULL, '2024-07-06 00:42:38', '2024-07-06 00:42:38'),
(54, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 00:59:12', '2024-07-06 00:59:12'),
(55, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 00:59:36', '2024-07-06 00:59:36'),
(56, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 01:00:15', '2024-07-06 01:00:15'),
(57, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:20:51', '2024-07-06 02:20:51'),
(58, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:21:57', '2024-07-06 02:21:57'),
(59, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:22:23', '2024-07-06 02:22:23'),
(60, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:23:08', '2024-07-06 02:23:08'),
(61, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:26:39', '2024-07-06 02:26:39'),
(62, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:27:25', '2024-07-06 02:27:25'),
(63, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:28:28', '2024-07-06 02:28:28'),
(64, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:35:00', '2024-07-06 02:35:00'),
(65, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:43:37', '2024-07-06 02:43:37'),
(66, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:44:28', '2024-07-06 02:44:28'),
(67, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:51:03', '2024-07-06 02:51:03'),
(68, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:52:54', '2024-07-06 02:52:54'),
(69, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:55:07', '2024-07-06 02:55:07'),
(70, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 02:56:19', '2024-07-06 02:56:19'),
(71, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 02:56:50', '2024-07-06 02:56:50'),
(72, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 03:03:44', '2024-07-06 03:03:44'),
(73, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 03:08:51', '2024-07-06 03:08:51'),
(74, 15, 1, 'Returned by admin', 7, '2024-07-06', '1', 1, NULL, '2024-07-06 03:10:17', '2024-07-06 03:10:17'),
(75, 15, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 03:10:54', '2024-07-06 03:10:54'),
(76, 15, 1, 'Approved by admin', 6, '2024-07-06', '1', 1, NULL, '2024-07-06 03:11:17', '2024-07-06 03:11:17'),
(77, 16, 1, 'aasdfasdfsfd', 1, '2024-07-06', '15', 15, NULL, '2024-07-06 03:12:11', '2024-07-06 03:12:11'),
(78, 16, 1, 'Application confirmed by admin', 2, '2024-07-06', '1', 1, NULL, '2024-07-06 03:12:22', '2024-07-06 03:12:22'),
(79, 16, 1, 'Request for documents by admin', 4, '2024-07-06', '1', 1, NULL, '2024-07-06 03:12:31', '2024-07-06 03:12:31'),
(80, 16, 1, 'Documents uploaded by customer', 5, '2024-07-06', '15', 15, NULL, '2024-07-06 03:13:07', '2024-07-06 03:13:07'),
(81, 16, 1, 'Cancelled by admin', 8, '2024-07-06', '1', 1, NULL, '2024-07-06 03:13:32', '2024-07-06 03:13:32'),
(82, 13, 1, 'Documents uploaded by customer', 5, '2024-10-11', '16', 16, NULL, '2024-10-11 02:29:05', '2024-10-11 02:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT 1 COMMENT '1=superAdmin, 2 = subAdmin, 3 = user',
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_created_at` timestamp NULL DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1 COMMENT '1=active, 0 = inactive',
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `stripe_customer_id` varchar(100) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `first_name`, `middle_name`, `last_name`, `phone_number`, `email`, `email_verified_at`, `password`, `otp`, `otp_created_at`, `status`, `profile_picture`, `remember_token`, `stripe_customer_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', NULL, NULL, '245234523452', 'admin@example.com', NULL, '$2y$12$3Vx.QIFR6efAyCiFI8jgDewSF8kpF4jnc9V/YaacMzwtaAFIAzoy.', NULL, NULL, 1, '/uploads/user/profile/LI8pUnITBv1yGyaoMRLkLs0p6HCFRjEf.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Sub Admin', NULL, NULL, '245234523452', 'subadmin@example.com', NULL, '$2y$12$3Vx.QIFR6efAyCiFI8jgDewSF8kpF4jnc9V/YaacMzwtaAFIAzoy.', NULL, NULL, 1, '/uploads/user/profile/xcXgb6JM1h9Lc05sDkHfYIJGgwacj2YA.png', NULL, NULL, NULL, 2, NULL, '2024-10-19 03:19:38'),
(3, 3, 'User', 'Jasper Batz', 'Schinner', '48324523523', 'user@example.com', NULL, '$2y$12$3Vx.QIFR6efAyCiFI8jgDewSF8kpF4jnc9V/YaacMzwtaAFIAzoy.', NULL, NULL, 1, '/uploads/user/profile/OrGJonwJTNgrPYoL87EA5s0cpkr2e5NI.jpg', NULL, NULL, 2, NULL, '2024-10-19 03:24:06', '2024-10-19 05:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_subscription_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_method_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `stripe_customer_id` varchar(255) DEFAULT NULL,
  `stripe_subscription_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payments`
--

INSERT INTO `user_payments` (`id`, `user_subscription_id`, `user_id`, `plan_id`, `payment_method_id`, `amount`, `transaction_id`, `stripe_customer_id`, `stripe_subscription_id`, `status`, `response`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 1, NULL, NULL, 'ch_3PPJqvCCOZ6H0AgU0sSQ8xXO', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PPJqvCCOZ6H0AgU0sSQ8xXO\",\"object\":\"charge\",\"amount\":1000,\"amount_captured\":1000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PPJqvCCOZ6H0AgU0ozwhfyb\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717832297,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":36,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":1000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":1000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKOmUkLMGMgZwF3e4cGk6LBZNa7j8-qYfL6nQIfsg6njiTWhTuekaYUFdoqK-zbDWSRhs8xEyOqTqPsAD\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-08', '2024-06-08 02:38:18', '2024-06-08 02:38:18'),
(2, 2, 15, 2, NULL, NULL, 'ch_3PPJtlCCOZ6H0AgU1JSwLubJ', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PPJtlCCOZ6H0AgU1JSwLubJ\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PPJtlCCOZ6H0AgU1wL8bbs0\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717832473,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":56,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKJmWkLMGMgZang05BFQ6LBauRElyEL33y-HBMFHvkyUubYjFvCszJUoPQd3alvAu0v8cX-Vviwl6XOIx\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-08', '2024-06-08 02:41:14', '2024-06-08 02:41:14'),
(3, 3, 15, 3, NULL, 30.00, 'ch_3PPK3SCCOZ6H0AgU0pBKfLCd', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PPK3SCCOZ6H0AgU0pBKfLCd\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PPK3SCCOZ6H0AgU0IHkbxtS\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717833074,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":26,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKPKakLMGMgZEewk9F686LBbJ4cRR1cBGKf3fxPIuphAJtSJsWHMaHjAgaMPS0Sd54JNhQ_KoXNTosVMA\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-08', '2024-06-08 02:51:15', '2024-06-08 02:51:15'),
(4, 4, 15, 2, NULL, 20.00, 'ch_3PPKUmCCOZ6H0AgU0M5bWFwP', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PPKUmCCOZ6H0AgU0M5bWFwP\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PPKUmCCOZ6H0AgU0kc6YuY5\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717834768,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":6,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKJGokLMGMgajc9IgkB46LBagHJ9P6pcnMZ-2FXP034uk45ABcNiSZZ2cMtEXvM_gRVtnhDsQainvvdJ6\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-08', '2024-06-08 03:19:29', '2024-06-08 03:19:29'),
(5, 5, 15, 3, NULL, 30.00, 'ch_3PPKVkCCOZ6H0AgU0ukMPIzR', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PPKVkCCOZ6H0AgU0ukMPIzR\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PPKVkCCOZ6H0AgU0OyZrBM1\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717834828,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":36,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKM2okLMGMgbp3igiY706LBbPz60lucN_BEQOy9fNioaylrU7McRz21xXlQRKKu_N5KN6ID7ECgqs5jk3\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-08', '2024-06-08 03:20:30', '2024-06-08 03:20:30'),
(6, 6, 15, 1, NULL, 10.00, 'ch_3PQ050CCOZ6H0AgU09OZcYZy', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PQ050CCOZ6H0AgU09OZcYZy\",\"object\":\"charge\",\"amount\":1000,\"amount_captured\":1000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PQ050CCOZ6H0AgU0LAVhk2E\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1717994618,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":17,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":1000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":1000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKPuImrMGMgaRwvtjyiY6LBY-COW3H-T0mLW2Gk_t4cj3XleI-qOjQo836_8aEcXPFjJIVdifk0xBlDHl\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-10', '2024-06-09 23:43:41', '2024-06-09 23:43:41'),
(7, 7, 15, 1, NULL, 10.00, 'ch_3PQQY9CCOZ6H0AgU0pEqLSQC', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PQQY9CCOZ6H0AgU0pEqLSQC\",\"object\":\"charge\",\"amount\":1000,\"amount_captured\":1000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PQQY9CCOZ6H0AgU0mci5O0b\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1718096369,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":43,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":1000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":1000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKPKjoLMGMgbywnmZHFE6LBbq3nh18staplnZY3AfPgD1N44K8OSxIND6r3TwZxVXianb8L2pv_yg2272\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-11', '2024-06-11 03:59:30', '2024-06-11 03:59:30'),
(8, 8, 15, 3, NULL, 30.00, 'ch_3PQltkCCOZ6H0AgU10er8ZDd', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PQltkCCOZ6H0AgU10er8ZDd\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PQltkCCOZ6H0AgU112zY9rD\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1718178432,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":36,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKIClpbMGMgatQfUlnpk6LBZGQoMKJwThQRPwtIbrtIRZoMenCsfan9VP15w43ZW5WKe1w2Iab47WMEbm\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-12', '2024-06-12 02:47:12', '2024-06-12 02:47:13'),
(9, 9, 16, 2, NULL, 20.00, 'ch_3PTfg6CCOZ6H0AgU0J7St3LB', 'cus_QKKKhV5vruN5YW', NULL, 'succeeded', '{\"id\":\"ch_3PTfg6CCOZ6H0AgU0J7St3LB\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PTfg6CCOZ6H0AgU0VU1Vt6U\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1718869506,\"currency\":\"usd\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":31,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKIO8z7MGMgZClXI9QLw6LBYmgphai8XQ5bSJceSUbNLbWtl5MSk9rAFSEvcpynlOhjaQ6LvvYht1rRnD\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-20', '2024-06-20 02:45:07', '2024-06-20 02:45:07'),
(10, 10, 15, 2, NULL, 20.00, 'ch_3PVAbkCCOZ6H0AgU0vnJdlMe', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PVAbkCCOZ6H0AgU0vnJdlMe\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PVAbkCCOZ6H0AgU0iR6K0Hd\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1719226728,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":3,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKOmi5bMGMgYJ_RlaNyk6LBY_uM6A7m-n7tezMrZbKemPwgeVKKbqs2BOtzJYnYuSAX1y6iMSoTqakXAc\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-24', '2024-06-24 05:58:50', '2024-06-24 05:58:50'),
(11, 11, 15, 3, NULL, 30.00, 'ch_3PVBgPCCOZ6H0AgU16ZaegJd', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PVBgPCCOZ6H0AgU16ZaegJd\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PVBgPCCOZ6H0AgU18ng4PFQ\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1719230861,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":18,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKI3D5bMGMga_N7SCS9Y6LBab2hd93k9vc5qyjZ1xqAN0m2QIx_xadYpJgOXRaisAdm0gqFdt3kGN1NL7\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-24', '2024-06-24 07:07:42', '2024-06-24 07:07:42'),
(12, 12, 16, 3, NULL, 30.00, 'ch_3PVBgsCCOZ6H0AgU095XOtk7', 'cus_QKKKhV5vruN5YW', NULL, 'succeeded', '{\"id\":\"ch_3PVBgsCCOZ6H0AgU095XOtk7\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PVBgsCCOZ6H0AgU08raelut\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1719230890,\"currency\":\"usd\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":61,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKKrD5bMGMgb33qLSyuw6LBZwFUlUNOqvCL8jV9icgcuQ3pKlkyI6SKHXD3kXQLMP7XSr2CtRg3a_HIaK\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-24', '2024-06-24 07:08:11', '2024-06-24 07:08:11'),
(13, 13, 15, 2, NULL, 20.00, 'ch_3PVYIhCCOZ6H0AgU0izSbQR5', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PVYIhCCOZ6H0AgU0izSbQR5\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PVYIhCCOZ6H0AgU02szlTCJ\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1719317803,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":51,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKKzq6rMGMgY2hQCJOtQ6LBZGpjAp0r9t7xdW7qY0hFXxutg_VtpUZIeVZCrgYX7yOs4i4p8pUS3dqEnX\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-25', '2024-06-25 07:16:44', '2024-06-25 07:16:44'),
(14, 14, 15, 3, NULL, 30.00, 'ch_3PVYLbCCOZ6H0AgU0E6bjtAP', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PVYLbCCOZ6H0AgU0E6bjtAP\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PVYLbCCOZ6H0AgU0UgRQjGq\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1719317983,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":10,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKODr6rMGMgaVufbo2Vw6LBaB0oqNuYws5yTBmL5u45TOkUuDpyEw687EzOv52QkwpI_PkJOe7b76q1fK\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-06-25', '2024-06-25 07:19:45', '2024-06-25 07:19:45'),
(15, 15, 15, 2, NULL, 20.00, 'ch_3PZXhsCCOZ6H0AgU01YviNxR', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PZXhsCCOZ6H0AgU01YviNxR\",\"object\":\"charge\",\"amount\":2000,\"amount_captured\":2000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PZXhsCCOZ6H0AgU0FGp0oeg\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1720268832,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":1,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":2000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":2000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKKHwpLQGMgY6Ma-VYFY6LBYcNj9sMkKdVIJkOFWud-jGx9Z2I1w-McnJRs3fuTItBttdo3Qtr8-BNha3\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-07-06', '2024-07-06 07:27:14', '2024-07-06 07:27:14'),
(16, 16, 15, 3, NULL, 30.00, 'ch_3PZXiZCCOZ6H0AgU0bui6D3P', 'cus_QFWnQzp1F7DLQX', NULL, 'succeeded', '{\"id\":\"ch_3PZXiZCCOZ6H0AgU0bui6D3P\",\"object\":\"charge\",\"amount\":3000,\"amount_captured\":3000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3PZXiZCCOZ6H0AgU0sFcwzs9\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1720268875,\"currency\":\"usd\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":2,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"payment_method_details\":{\"card\":{\"amount_authorized\":3000,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":3000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKMzwpLQGMgYe3gOgRzw6LBZOcECWVdPjYWa7zyzEuD5PljjLhqU0_p_bCfmToB-8CIu-2ppV8pt-WtZ8\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PP1jkCCOZ6H0AgUTXv8EMEQ\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QFWnQzp1F7DLQX\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-07-06', '2024-07-06 07:27:57', '2024-07-06 07:27:57');
INSERT INTO `user_payments` (`id`, `user_subscription_id`, `user_id`, `plan_id`, `payment_method_id`, `amount`, `transaction_id`, `stripe_customer_id`, `stripe_subscription_id`, `status`, `response`, `date`, `created_at`, `updated_at`) VALUES
(17, 17, 16, 1, NULL, 10.00, 'ch_3Q8bouCCOZ6H0AgU1UviOluw', 'cus_QKKKhV5vruN5YW', NULL, 'succeeded', '{\"id\":\"ch_3Q8bouCCOZ6H0AgU1UviOluw\",\"object\":\"charge\",\"amount\":1000,\"amount_captured\":1000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3Q8bouCCOZ6H0AgU1NiHf6cA\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1728626124,\"currency\":\"usd\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"description\":\"Payment for order\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":36,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"payment_method_details\":{\"card\":{\"amount_authorized\":1000,\"authorization_code\":null,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":null},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":1000,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xTWlhblBDQ09aNkgwQWdVKMz7orgGMgboE5lgCL06LBb_kVYqEwszH0v5j6yaE4PQj3cOp-25e7-JmXrisdMVPHanDy3xuOQSdPoS\",\"refunded\":false,\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1PTffxCCOZ6H0AgUcFJDGgnx\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_QKKKhV5vruN5YW\",\"cvc_check\":null,\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"E28cBpxNh9lGZuKG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '2024-10-11', '2024-10-11 00:57:04', '2024-10-11 00:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_personal_info`
--

CREATE TABLE `user_personal_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_personal_info`
--

INSERT INTO `user_personal_info` (`id`, `user_id`, `name`, `date_of_birth`, `email`, `phone_number`, `created_at`, `updated_at`) VALUES
(8, 16, 'Sierra Moore', '2024-01-26', 'hamza123@5dsolutions.ae', '9629010262', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(9, 17, 'Domenic Mayer', '2025-01-23', 'your.email+fakedata60806@gmail.com', '0244636597', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(13, 24, 'Garfield Cruickshank', '2024-03-14', 'your.email+fakedata10172@gmail.com', '243524515235', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(15, 28, 'fjdsjfjf', '2024-10-14', 'akfajdskf@gmail.com', '5636534654365', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(16, 29, 'Josue Murray', '2024-08-28', 'your.email+fakedata47694@gmail.com', '710212975798', '2024-10-15 03:05:15', '2024-10-15 03:05:15'),
(17, 30, 'Ahmed Stehr', '2024-01-14', 'your.email+fakedata38401@gmail.com', '817810500', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(18, 31, 'Gust Ritchie', '2024-04-07', 'your.email+fakedata84502@gmail.com', '559945993', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(19, 32, 'Reece Muller', '2024-10-14', 'your.email+fakedata21711@gmail.com', '262382709899', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(20, 33, 'hamza', '2024-10-06', 'hamza@5dsolutions.ae', '123132123123', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(21, 34, 'Naomi Kunze', '2024-07-31', 'your.email+fakedata86256@gmail.com', '253151497129', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(23, 36, 'Dallas Harber', '2024-08-08', 'your.email+fakedata17760@gmail.com', '93720812434', '2024-10-16 01:45:31', '2024-10-16 01:45:31'),
(24, 37, 'Dallas Harber', '2024-08-08', 'your.email+fakedata17760@gmail.com', '93720812434', '2024-10-16 01:46:42', '2024-10-16 01:46:42'),
(25, 38, 'Dallas Harber', '2024-08-08', 'your.email+fakedata17760@gmail.com', '93720812434', '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(26, 39, 'Javier Conroy', '2024-01-31', 'your.email+fakedata84103@gmail.com', '4065533118', '2024-10-16 01:58:29', '2024-10-16 01:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_references`
--

CREATE TABLE `user_references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `reference_name` varchar(100) DEFAULT NULL,
  `reference_relationship` varchar(100) DEFAULT NULL,
  `contact_information` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_references`
--

INSERT INTO `user_references` (`id`, `user_id`, `reference_name`, `reference_relationship`, `contact_information`, `created_at`, `updated_at`) VALUES
(4, 16, 'Cary Goyette', 'Voluptatum labore quas rerum a voluptate porro.', 'Bahamas', '2024-06-06 02:32:18', '2024-06-06 02:32:18'),
(5, 17, 'Lelah Kuhn-Barton', 'Illo reiciendis iure molestiae molestias dolores aut.', 'Republic of Korea', '2024-06-06 02:40:32', '2024-06-06 02:40:32'),
(9, 24, 'lkklkj', 'kklk', 'kljlkj', '2024-10-11 00:11:14', '2024-10-11 00:11:14'),
(11, 28, 'adsfd', 'fdsaf', 'fdsaf', '2024-10-15 02:37:37', '2024-10-15 02:37:37'),
(12, 29, 'fjfklfj', 'fkjllfjlf', 'fjkjlljflf', '2024-10-15 03:05:16', '2024-10-15 03:05:16'),
(13, 30, 'jsdjfkds', 'fsdfad', 'sdfasdf', '2024-10-15 04:09:33', '2024-10-15 04:09:33'),
(14, 31, 'jlkajsf', 'fadsfsad', 'fadsfasd', '2024-10-15 04:15:05', '2024-10-15 04:15:05'),
(15, 32, 'fdasfd', 'fdsafasdf', 'fasdfadsfasd', '2024-10-15 04:28:58', '2024-10-15 04:28:58'),
(16, 33, 'Adnan', 'as', 'as', '2024-10-15 04:38:59', '2024-10-15 04:38:59'),
(17, 34, 'Johnpaul Adams', 'Velit perspiciatis dolore reiciendis eius.', 'United States of America', '2024-10-15 04:42:15', '2024-10-15 04:42:15'),
(19, 38, NULL, NULL, NULL, '2024-10-16 01:48:19', '2024-10-16 01:48:19'),
(20, 39, NULL, NULL, NULL, '2024-10-16 01:58:30', '2024-10-16 01:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_subscription`
--

CREATE TABLE `user_subscription` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_id` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `duration_days` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subscription`
--

INSERT INTO `user_subscription` (`id`, `user_id`, `plan_id`, `start_date`, `end_date`, `duration_days`, `created_at`, `updated_at`) VALUES
(1, 15, 1, '2024-06-08', '2024-06-08', 30, '2024-06-08 02:38:18', '2024-06-08 02:41:14'),
(2, 15, 2, '2024-06-08', '2024-06-08', 30, '2024-06-08 02:41:14', '2024-06-08 02:51:15'),
(3, 15, 3, '2024-06-08', '2024-06-08', 30, '2024-06-08 02:51:15', '2024-06-08 03:19:29'),
(4, 15, 2, '2024-06-08', '2024-06-08', 30, '2024-06-08 03:19:29', '2024-06-08 03:20:30'),
(5, 15, 3, '2024-06-08', '2024-06-10', 30, '2024-06-08 03:20:30', '2024-06-09 23:43:41'),
(6, 15, 1, '2024-06-10', '2024-06-11', 30, '2024-06-09 23:43:41', '2024-06-11 03:59:30'),
(7, 15, 1, '2024-06-11', '2024-06-12', 30, '2024-06-11 03:59:30', '2024-06-12 02:47:13'),
(8, 15, 3, '2024-06-12', '2024-06-24', 30, '2024-06-12 02:47:13', '2024-06-24 05:58:50'),
(9, 16, 2, '2024-06-20', '2024-06-24', 30, '2024-06-20 02:45:07', '2024-06-24 07:08:11'),
(10, 15, 2, '2024-06-24', '2024-06-24', 30, '2024-06-24 05:58:50', '2024-06-24 07:07:42'),
(11, 15, 3, '2024-06-24', '2024-06-25', 30, '2024-06-24 07:07:42', '2024-06-25 07:16:44'),
(12, 16, 3, '2024-06-24', '2024-10-11', 30, '2024-06-24 07:08:11', '2024-10-11 00:57:04'),
(13, 15, 2, '2024-06-25', '2024-06-25', 30, '2024-06-25 07:16:44', '2024-06-25 07:19:45'),
(14, 15, 3, '2024-06-25', '2024-07-06', 30, '2024-06-25 07:19:45', '2024-07-06 07:27:14'),
(15, 15, 2, '2024-07-06', '2024-07-06', 30, '2024-07-06 07:27:14', '2024-07-06 07:27:57'),
(16, 15, 3, '2024-07-06', '2024-08-05', 30, '2024-07-06 07:27:57', '2024-07-06 07:27:57'),
(17, 16, 1, '2024-10-11', '2024-11-10', 30, '2024-10-11 00:57:04', '2024-10-11 00:57:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation_requirements`
--
ALTER TABLE `accommodation_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_note`
--
ALTER TABLE `additional_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_settings`
--
ALTER TABLE `api_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_information`
--
ALTER TABLE `financial_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `household_info`
--
ALTER TABLE `household_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_additional`
--
ALTER TABLE `landlord_additional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_personal`
--
ALTER TABLE `landlord_personal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landlord_personal_email_unique` (`email`);

--
-- Indexes for table `landlord_property`
--
ALTER TABLE `landlord_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_property_images`
--
ALTER TABLE `landlord_property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_rental`
--
ALTER TABLE `landlord_rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_tenant`
--
ALTER TABLE `landlord_tenant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_compliance`
--
ALTER TABLE `legal_compliance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `living_situation`
--
ALTER TABLE `living_situation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_control`
--
ALTER TABLE `menu_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pet_information`
--
ALTER TABLE `pet_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_matches`
--
ALTER TABLE `property_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_assistance`
--
ALTER TABLE `rental_assistance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `required_documents`
--
ALTER TABLE `required_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residential_preference`
--
ALTER TABLE `residential_preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant_enquiry_documents`
--
ALTER TABLE `tenant_enquiry_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant_enquiry_header`
--
ALTER TABLE `tenant_enquiry_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant_enquiry_requests`
--
ALTER TABLE `tenant_enquiry_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_personal_info`
--
ALTER TABLE `user_personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_references`
--
ALTER TABLE `user_references`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_subscription`
--
ALTER TABLE `user_subscription`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation_requirements`
--
ALTER TABLE `accommodation_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `additional_note`
--
ALTER TABLE `additional_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `additional_requirements`
--
ALTER TABLE `additional_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `api_settings`
--
ALTER TABLE `api_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_information`
--
ALTER TABLE `financial_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `household_info`
--
ALTER TABLE `household_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `landlord_additional`
--
ALTER TABLE `landlord_additional`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `landlord_personal`
--
ALTER TABLE `landlord_personal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `landlord_property`
--
ALTER TABLE `landlord_property`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `landlord_property_images`
--
ALTER TABLE `landlord_property_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `landlord_rental`
--
ALTER TABLE `landlord_rental`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `landlord_tenant`
--
ALTER TABLE `landlord_tenant`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `legal_compliance`
--
ALTER TABLE `legal_compliance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `living_situation`
--
ALTER TABLE `living_situation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `menu_control`
--
ALTER TABLE `menu_control`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_information`
--
ALTER TABLE `pet_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_matches`
--
ALTER TABLE `property_matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rental_assistance`
--
ALTER TABLE `rental_assistance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `required_documents`
--
ALTER TABLE `required_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `residential_preference`
--
ALTER TABLE `residential_preference`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tenant_enquiry_documents`
--
ALTER TABLE `tenant_enquiry_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tenant_enquiry_header`
--
ALTER TABLE `tenant_enquiry_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tenant_enquiry_requests`
--
ALTER TABLE `tenant_enquiry_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_personal_info`
--
ALTER TABLE `user_personal_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_references`
--
ALTER TABLE `user_references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_subscription`
--
ALTER TABLE `user_subscription`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
