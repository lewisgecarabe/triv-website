-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 06:17 AM
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
-- Database: `triv_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `plan_file` varchar(255) DEFAULT NULL,
  `status` enum('pending','in-progress','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `user_id`, `name`, `email`, `mobile`, `message`, `plan_file`, `status`, `created_at`, `updated_at`) VALUES
(3, 4, 'sss', 'kkk@gmail.com', 'rrr', 'dssdcs', NULL, 'completed', '2025-05-29 00:59:45', '2025-05-29 01:00:29'),
(4, 5, 'Alma Perol', 'avperol@gmail.com', '09192642054', 'HDGHHSD', NULL, 'pending', '2025-05-29 03:04:23', NULL),
(5, 5, 'Alma Perol', 'avperol@gmail.com', '09192642054', 'JSJJJSJSS', 'plan_5_1748487907.pdf', 'in-progress', '2025-05-29 03:05:07', '2025-05-29 03:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE `developers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `github` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `order_position` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `name`, `position`, `bio`, `image`, `email`, `github`, `linkedin`, `order_position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Noel Andrae Lara Villanueva', 'Full Stack Developer', 'Experienced developer with expertise in PHP, JavaScript, and database management.', 'noelv.jpg', 'noel@example.com', 'noelv', 'noel-villanueva', 1, 'active', '2025-05-28 13:09:13', '2025-05-28 13:09:13'),
(2, 'Lance Aidrian Benico', 'Full Stack Developer', 'Skilled developer with focus on front-end technologies and responsive design.', 'lanceb.jpg', 'lance@example.com', 'lanceb', 'lance-benico', 2, 'active', '2025-05-28 13:09:13', '2025-05-28 13:09:13'),
(3, 'Lewis Leander Gecarane', 'Full Stack Developer', 'Versatile developer with strong back-end skills and database optimization expertise.', 'lewisg.jpeg', 'lewis@example.com', 'lewisg', 'lewis-gecarane', 3, 'active', '2025-05-28 13:09:13', '2025-05-28 13:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `employment_type` enum('full-time','part-time','contract','internship') DEFAULT 'full-time',
  `description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `qualifications` text NOT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive','closed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `department`, `location`, `employment_type`, `description`, `responsibilities`, `qualifications`, `schedule`, `benefits`, `salary_range`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Senior Architect', 'Architecture', 'Manila, Philippines (On-site)', 'full-time', 'Lead architectural design projects from concept to completion, collaborating with clients and construction teams to deliver innovative, sustainable building solutions.', '• Develop architectural designs and concepts for residential, commercial, and mixed-use projects\n• Prepare detailed drawings, specifications, and construction documents\n• Coordinate with engineers, contractors, and clients throughout the project lifecycle\n• Ensure compliance with building codes, regulations, and sustainability standards\n• Manage project timelines and budgets\n• Mentor junior architects and lead design teams', '• Bachelor\'s or Master\'s degree in Architecture\n• Licensed architect with 5+ years of professional experience\n• Proficiency in AutoCAD, Revit, SketchUp, and other design software\n• Strong portfolio demonstrating design excellence and technical expertise\n• Excellent communication and leadership skills\n• Experience with sustainable design principles and practices', 'Monday to Friday, 9:00 AM - 6:00 PM', '• Competitive salary package\n• Health insurance coverage\n• Professional development opportunities\n• Performance bonuses\n• Paid time off and holidays', '₱80,000 - ₱120,000', 'active', '2025-05-28 12:42:05', '2025-05-28 12:42:05'),
(2, 'Civil Engineer', 'Engineering', 'Manila, Philippines (On-site)', 'full-time', 'Design and oversee construction projects ensuring structural integrity, safety compliance, and efficient execution while coordinating with architects and contractors.', '• Develop detailed engineering designs and calculations for construction projects\n• Prepare technical specifications and construction documents\n• Conduct site inspections and quality control assessments\n• Coordinate with architects, contractors, and other stakeholders\n• Ensure compliance with building codes and safety regulations\n• Manage project timelines and technical resources', '• Bachelor\'s degree in Civil Engineering\n• Licensed Civil Engineer with 3+ years of experience\n• Proficiency in AutoCAD, STAAD Pro, and other engineering software\n• Strong analytical and problem-solving skills\n• Experience with construction management and site supervision\n• Excellent communication and teamwork abilities', 'Monday to Friday, 8:00 AM - 5:00 PM', '• Competitive salary package\n• Health insurance coverage\n• Professional development allowance\n• Performance bonuses\n• Paid time off and holidays', '₱60,000 - ₱90,000', 'active', '2025-05-28 12:42:05', '2025-05-28 12:42:05'),
(3, 'Interior Designer', 'Interior Design', 'Manila, Philippines (Hybrid)', 'full-time', 'Create stunning, functional interior spaces that reflect clients\' visions and needs, selecting materials, colors, and furnishings while managing project timelines and budgets.', '• Develop interior design concepts and space planning solutions\n• Select appropriate materials, finishes, furniture, and accessories\n• Create mood boards, renderings, and presentation materials\n• Coordinate with architects, contractors, and vendors\n• Manage project budgets and timelines\n• Ensure client satisfaction throughout the design process', '• Bachelor\'s degree in Interior Design or related field\n• 3+ years of professional interior design experience\n• Proficiency in AutoCAD, SketchUp, and Adobe Creative Suite\n• Strong portfolio demonstrating design versatility and creativity\n• Knowledge of materials, finishes, and furniture sourcing\n• Excellent communication and client management skills', 'Monday to Friday, 9:00 AM - 6:00 PM (2 days remote option)', '• Competitive salary package\n• Health insurance coverage\n• Flexible work arrangements\n• Professional development opportunities\n• Paid time off and holidays', '₱45,000 - ₱70,000', 'active', '2025-05-28 12:42:05', '2025-05-28 12:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `resume_file` varchar(255) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `experience` varchar(50) NOT NULL,
  `cover_letter` text NOT NULL,
  `start_date` date NOT NULL,
  `expected_salary` varchar(100) DEFAULT NULL,
  `referral_source` varchar(100) DEFAULT NULL,
  `status` enum('pending','reviewing','shortlisted','interviewed','hired','rejected') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `category`, `title`, `location`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'architectural-design', '2 Storey House', 'Santa Rosa, Laguna', 'A residential house in Bel Air, Santa Rosa Laguna.', 'a.jpg', 'active', '2025-05-23 00:42:55', '2025-05-23 00:42:55'),
(2, 'architectural-design', '4 Storey Residential and Commercial Building', 'Romblon Romblon', 'An eco-friendly residential design with minimal environmental impact and energy-efficient features.', 'project4.jpg', 'active', '2025-05-23 00:42:55', '2025-05-23 00:42:55'),
(3, 'interior-design', 'Condominium', 'DMCI Homes. Torre de Manila', 'High-end interior design for a city center condo, featuring custom furnishings and premium finishes.', 'condo.jpg', 'active', '2025-05-23 00:42:55', '2025-05-23 00:42:55'),
(4, 'construction', 'New Commercial Complex', 'Makati City', 'A state-of-the-art commercial building with sustainable materials.', '6831c1bdc6419.png', 'active', '2025-05-23 00:42:55', '2025-05-24 12:55:25'),
(7, 'construction', 'School', 'Tondo, Manila', 'Secret', '6837cd8080ac1.gif', 'inactive', '2025-05-29 02:59:12', '2025-05-31 04:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `short_description`, `slug`, `image`, `banner_image`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Construction', 'From foundation to finishing, we build durable structures that last for generations. Our construction services deliver exceptional quality and craftsmanship for both residential and commercial projects.', 'From foundation to finishing, we build durable structures that last for generations.', 'construction', 'services_construction.jpg', 'services_construction.jpg', 1, 'active', '2025-05-28 22:31:07', '2025-05-31 03:41:43'),
(2, 'Renovation', 'Breathe new life into old spaces with our modern renovation solutions. Transform your space with our thoughtful approach to renovations.', 'Breathe new life into old spaces with our modern renovation solutions.', 'renovation', 'services_renovation.jpg', 'services_renovation.jpg', 2, 'active', '2025-05-28 22:31:07', '2025-05-31 03:31:13'),
(3, 'Architectural Design', 'Innovative and sustainable designs crafted to inspire and function. Our architectural design services combine creativity with practicality.', 'Innovative and sustainable designs crafted to inspire and function.', 'architectural-design', 'services_architecturalDesign.jpg', 'services_architecturalDesign.jpg', 3, 'active', '2025-05-28 22:31:07', NULL),
(4, 'Interior Design', 'Creating elegant interiors that reflect your personality and lifestyle. Our interior design services create comfortable, functional, and attractive spaces.', 'Creating elegant interiors that reflect your personality and lifestyle.', 'interior-design', 'services_interiorDesign.jpg', 'services_interiorDesign.jpg', 4, 'active', '2025-05-28 22:31:07', NULL),
(5, 'Extension', 'Expand your space seamlessly while preserving your original structure\'s charm. Our extension services offer a cost-effective way to gain additional room.', 'Expand your space seamlessly while preserving your original structure\'s charm.', 'extension', 'services_extension.jpg', 'services_extension.jpg', 5, 'active', '2025-05-28 22:31:07', '2025-05-31 04:28:42'),
(6, 'Cleaning', 'cleaning tara na linis tayo', 'cleaning with us', 'cleaning', '6837d1527c7a4.gif', '6837d1527c996.gif', 6, 'inactive', '2025-05-29 03:15:30', '2025-09-12 04:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `specialization` text DEFAULT NULL,
  `years_experience` int(11) DEFAULT 0,
  `order_position` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `position`, `bio`, `image`, `email`, `phone`, `linkedin`, `specialization`, `years_experience`, `order_position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Engr. Noel R. Villanueva', 'Founder | Consultant', 'Experienced engineer and consultant with extensive expertise in construction management and project development.', 'nrv.jpg', '', '', '', 'Construction Management, Project Development', 20, 1, 'active', '2025-05-28 13:09:50', '2025-05-28 19:01:02'),
(2, 'Arch. Ma. Alyza Linelle L. Villanueva, RMP', 'Founder | Principal Architect', 'Licensed architect specializing in residential and commercial design with a focus on sustainable and functional architecture.', 'alv.jpg', '', NULL, NULL, 'Architectural Design, Sustainable Architecture', 0, 2, 'active', '2025-05-28 13:09:50', '2025-05-28 18:54:36'),
(3, 'Engr. Jan Alison Lynwhel L. Villanueva', 'Founder | Site Engineer', 'Site engineer with expertise in construction supervision, quality control, and project implementation.', 'jlv.jpg', '', NULL, NULL, 'Site Engineering, Quality Control', 0, 3, 'active', '2025-05-28 13:09:50', '2025-05-28 18:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `last_login`) VALUES
(3, 'Lewis Gecarane', 'lewisgecarane@gmail.com', '$2y$10$Kxc9/gyDrO4QbL3RGWgG.eqG66g36fnid9dvjoWO2q5FzC8NROOrS', 'admin', 'active', '2025-05-28 11:07:34', '2025-05-30 10:29:49'),
(4, 'Lewis Gecarane', 'gg@gmail.com', '$2y$10$E7dxYmBZ4tqLEXy4Pl.Hx.o.MzUwZl.aE9eZ.ed8k28q7ilYf5DnG', 'client', 'active', '2025-05-28 11:53:08', '2025-09-12 04:09:35'),
(5, 'Alma Perol', 'avperol@gmail.com', '$2y$10$iwiPn36.mtWZmOM.ywVjc.N5kW8Wrq5Lc3DhkfQDCuMH/jFh9xUXy', 'client', 'active', '2025-05-29 03:01:46', '2025-05-29 03:02:15'),
(6, 'Admin', 'admin@triv.com', '$2y$10$ufu0o67UlrachOkCNh.X7.HFF91OqwUMswAY3MYbXKQmmKmX7Ah4K', 'admin', 'active', '2025-05-31 04:03:12', '2025-09-12 04:12:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD CONSTRAINT `contact_inquiries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
