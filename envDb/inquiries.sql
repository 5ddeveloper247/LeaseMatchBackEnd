-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 11:56 AM
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
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `industry_sector` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) NOT NULL,
  `phone_number` varchar(18) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `type_of_space` varchar(255) DEFAULT NULL,
  `preferred_lease_term` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `business_name`, `industry_sector`, `year`, `company_website`, `full_name`, `job_title`, `phone_number`, `email`, `type_of_space`, `preferred_lease_term`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Magn', NULL, 'Quinton Kassulke', 'Direct Quality Representative', '6917995989898', 'your.email+fakedata21675@gmail.com', NULL, NULL, '2024-10-21 04:16:12', '2024-10-21 04:16:12'),
(2, 'Nathan Bergstrom', 'Aliquid soluta soluta est assumenda voluptatem.', 'Laud', 'Conroy Group', 'Miller Nader', 'International Brand Planner', '17376508798', 'your.email+fakedata91092@gmail.com', NULL, 'short-term', '2024-10-21 04:26:04', '2024-10-21 04:26:04'),
(3, 'Celia_Durgan78', 'Aspernatur cum dicta ex nobis cupiditate ipsa.', '2024', 'Gibson - Wisoky', 'Alfred Bailey', 'Customer Quality Director', '660001606843', 'your.email+fakedata12244@gmail.com', 'Retail', 'short-term', '2024-10-21 04:32:59', '2024-10-21 04:32:59'),
(4, 'Marcelino.Mills39', 'Maiores amet doloribus adipisci accusamus accusant', '2023', 'O\'Conner - Howe', 'Frances Rosenbaum', 'Future Paradigm Manager', '544672722389', 'your.email+fakedata50525@gmail.com', 'Retail', 'short-term', '2024-10-21 04:42:45', '2024-10-21 04:42:45'),
(5, 'Summer.Hegmann55', 'Eveniet ipsam nulla dolorem labore necessitatibus', '2023', 'Quigley LLC', 'Cristopher Leuschke', 'Principal Functionality Strategist', '255482095843', 'your.email+fakedata60860@gmail.com', 'other', 'short-term', '2024-10-21 04:43:45', '2024-10-21 04:43:45'),
(6, 'Kendra.Borer', 'Odit adipisci temporibus eos ex nulla architecto c', '2023', 'Mann - Marvin', 'Davon Ziemann', 'Lead Metrics Technician', '14193700', 'your.email+fakedata66680@gmail.com', 'Other type', 'short-term', '2024-10-21 04:45:47', '2024-10-21 04:45:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
