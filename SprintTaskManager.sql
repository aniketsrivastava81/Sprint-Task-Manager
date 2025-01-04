-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2025 at 09:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sprintTaskManagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `recipient`, `type`, `date`, `is_read`) VALUES
(1, 'You have been assigned a new task: Implement user login.', 1, 'task_assignment', '2025-01-03', 0),
(2, 'Task \"Implement user login\" has been moved to \"In Progress\".', 1, 'task_update', '2025-01-03', 0),
(3, 'Your task \"Fix login bug\" is due tomorrow. Please complete it on time.', 1, 'task_due', '2025-01-03', 1),
(4, 'You have been assigned a new task: Set up database schema.', 2, 'task_assignment', '2025-01-03', 0),
(5, 'Your task \"Set up database schema\" has been marked as completed.', 2, 'task_update', '2025-01-03', 1),
(6, 'Task \"Database schema setup\" is now in \"Code Review\" stage.', 2, 'task_update', '2025-01-03', 0),
(7, 'You have been assigned a new task: Create API documentation.', 3, 'task_assignment', '2025-01-03', 0),
(8, 'Task \"Create API documentation\" is now in \"Testing\" phase.', 3, 'task_update', '2025-01-03', 1),
(9, 'Task \"Implement user login\" has been marked as blocked due to dependency.', 3, 'task_blocked', '2025-01-03', 0),
(10, 'You have been assigned a new task: Optimize database queries.', 4, 'task_assignment', '2025-01-03', 0),
(11, 'Task \"Optimize database queries\" has been completed successfully.', 4, 'task_update', '2025-01-03', 1),
(12, 'Sprint deadline is approaching! Tasks must be completed by 2025-01-10.', 4, 'sprint_deadline', '2025-01-03', 0),
(13, 'You have been assigned a new task: Create unit tests for the API.', 5, 'task_assignment', '2025-01-03', 1),
(14, 'Task \"Create unit tests for the API\" has been moved to \"Ready for Review\".', 5, 'task_update', '2025-01-03', 0),
(15, 'Your task \"Optimize database queries\" is now overdue. Please update its status.', 5, 'task_due', '2025-01-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `priority` enum('High','Medium','Low','Wish') DEFAULT 'Medium',
  `visibility` enum('Y','N') DEFAULT 'N',
  `duration` enum('Long','Medium','Short','Unknown') DEFAULT 'Unknown',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `title`, `description`, `assigned_to`, `status`, `priority`, `visibility`, `duration`, `created_at`, `due_date`) VALUES
(1, 'Task 1', 'This is a description for task 1', 1, 'pending', 'High', 'Y', 'Long', '2024-12-27 01:36:29', '2025-01-24'),
(2, 'Task 2', 'This is a description for task 2', 2, 'in_progress', 'Medium', 'N', 'Short', '2024-12-27 01:36:29', '2025-01-01'),
(3, 'Task 3', 'This is a description for task 3', 3, 'completed', 'Low', 'Y', 'Long', '2024-12-27 01:36:29', '2025-01-31'),
(4, 'Task 4', 'This is a description for task 4', 4, 'pending', 'High', 'N', 'Unknown', '2024-12-27 01:36:29', '2025-01-29'),
(5, 'Task 5', 'This is a description for task 5', 5, 'in_progress', 'Wish', 'Y', 'Medium', '2024-12-27 01:36:29', '2025-01-30'),
(7, 't6', '7575r', 4, 'pending', 'High', 'Y', 'Long', '2025-01-02 00:18:51', '2025-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email_id` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `email_id`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'John Doe', 'john', 'johndoe@example.com', '1234567890', '$2y$10$j6ZVxI.y4oLHZw5f4MJJqOZb664.zp1w6FNw8AQ9J00V06vyBfFCa', 'admin', '2024-12-27 01:26:35'),
(2, 'Jane Smith', 'jane', 'janesmith@example.com', '09876541333', '$2y$10$NoN5Gk3WU0XGWntjN4dZney9Sl2dakt2iBViUECYpJez9NpR.lCQy', 'employee', '2024-12-27 01:26:35'),
(3, 'Alice Johnson', 'alice', 'alice@example.com', '1122334455', '$2y$10$j6ZVxI.y4oLHZw5f4MJJqOZb664.zp1w6FNw8AQ9J00V06vyBfFCa', 'employee', '2024-12-27 01:26:35'),
(4, 'Bob Williams', 'bob', 'bob@example.co.ca', '5566778899', '$2y$10$j6ZVxI.y4oLHZw5f4MJJqOZb664.zp1w6FNw8AQ9J00V06vyBfFCa', 'employee', '2024-12-27 01:26:35'),
(5, 'Charlie Brown', 'charlie', 'charlie@example.com', '6677889900', '$2y$10$j6ZVxI.y4oLHZw5f4MJJqOZb664.zp1w6FNw8AQ9J00V06vyBfFCa', 'employee', '2024-12-27 01:26:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreignkey_recipient_user_userid` (`recipient`) USING BTREE;

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`recipient`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
