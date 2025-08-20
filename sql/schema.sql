CREATE DATABASE wellness_tracker;
USE wellness_tracker;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



--
-- Database: `ack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `pin` char(4) NOT NULL DEFAULT '1234',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `position`, `pin`, `is_admin`) VALUES
(1, 'admin', 'Super Admin', '4455', 1),
(2, 'K Takae', 'PM', '1234', 0),
(3, 'M Takano', 'DPM', '1234', 0),
(4, 'T Mitani', 'DPM', '1234', 0),
(5, 'S Amano', 'Construction Manager', '1234', 0),
(6, 'H Sako', 'Admin Manager', '1234', 0),
(7, 'W Paul', 'Contracts Manager', '1234', 0),
(8, 'Wan Mohd', 'QS', '1234', 0),
(9, 'Mark Ian', 'QS', '1234', 0),
(10, 'M. Zobayer', 'QS', '1234', 0),
(11, 'M. Anis', 'QS', '1234', 0),
(12, 'J Sany', 'QS/PO', '1234', 0),
(13, 'Agus B.', 'Design Eng.', '1234', 0),
(14, 'Resti', 'Autocad Operator', '1234', 0),
(15, 'Patrick', 'Autocad Operator', '1234', 0),
(16, 'Brandon', 'Planning Eng.', '1234', 0),
(17, 'N. Ishikawa', 'Section Manager', '1234', 0),
(18, 'Y. Banno', 'Civil Eng.', '1234', 0),
(19, 'Carlo', 'Chief Eng.', '1234', 0),
(20, 'M. Siddik', 'Mechanical Sup.', '1234', 0),
(21, 'N. Tada', 'Section Manager', '1234', 0),
(22, 'So Sakurai', 'Civil Eng.', '1234', 0),
(23, 'Mr. Kamarul', 'Section Manager', '1234', 0),
(24, 'K. Yuki', 'Section Manager', '1234', 0),
(25, 'T Karasawa', 'Civil Eng.', '1234', 0),
(26, 'Antonio Luna', 'Chief Eng.', '1234', 0),
(27, 'Palash', 'Engineer', '1234', 0),
(28, 'Ronald', 'QAQC Manager', '1234', 0),
(30, 'Jahangir', 'QAQC Sup.', '1234', 0),
(31, 'M. Azhan', 'lang Surveyor', '1234', 0),
(32, 'R. Yanagida', 'Asst. Admin Manager', '1234', 0),
(33, 'D. Hishimura', 'Asst. Account Manager', '1234', 0),
(34, 'Liton K. Das', 'Account Officer', '1234', 0),
(35, 'M. Mizan', 'Account Officer', '1234', 0),
(36, 'M. Mamun', 'Logistics Officer', '1234', 0),
(37, 'Albert', 'HR Officer', '1234', 0),
(38, 'Rudy', 'HR Officer', '1234', 0),
(39, 'Shamim', 'HR Officer', '1234', 0),
(40, 'Ashik', 'IT ', '1234', 0),
(41, 'Nahid', 'IT', '1122', 0),
(42, 'M. Hasan', 'Clerk', '1234', 0),
(43, 'Al Amin', 'Clerk', '1234', 0),
(44, 'Daryl', 'Lead Safety Officer', '1234', 0),
(45, 'M A Q Sujon', 'WSH Coordnator', '1234', 0),
(46, 'Riad', 'WSH Coordinator', '1234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wellness_status`
--

CREATE TABLE `wellness_status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Well','Not Well') NOT NULL,
  `date` date NOT NULL DEFAULT curdate(),
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `wellness_status`
--

INSERT INTO `wellness_status` (`id`, `user_id`, `status`, `date`, `submitted_at`) VALUES
(1, 3, 'Well', '2025-08-16', '2025-08-16 08:00:52'),
(2, 5, 'Well', '2025-08-16', '2025-08-16 08:15:34'),
(3, 2, 'Well', '2025-08-16', '2025-08-16 11:04:26'),
(4, 4, 'Well', '2025-08-16', '2025-08-16 12:38:42'),
(5, 5, 'Well', '2025-08-17', '2025-08-17 04:15:31'),
(6, 3, 'Well', '2025-08-17', '2025-08-17 04:22:57'),
(7, 9, 'Well', '2025-08-17', '2025-08-17 04:36:42'),
(8, 2, 'Not Well', '2025-08-17', '2025-08-17 05:30:24'),
(9, 10, 'Not Well', '2025-08-17', '2025-08-17 05:42:15'),
(10, 14, 'Well', '2025-08-17', '2025-08-17 05:42:59'),
(11, 16, 'Not Well', '2025-08-17', '2025-08-17 05:43:29'),
(12, 15, 'Well', '2025-08-17', '2025-08-17 05:43:56'),
(13, 19, 'Not Well', '2025-08-17', '2025-08-17 05:46:17'),
(14, 12, 'Not Well', '2025-08-17', '2025-08-17 05:49:10'),
(15, 18, 'Not Well', '2025-08-17', '2025-08-17 05:49:49'),
(16, 8, 'Not Well', '2025-08-17', '2025-08-17 05:50:44'),
(17, 13, 'Not Well', '2025-08-17', '2025-08-17 06:08:20'),
(18, 11, 'Not Well', '2025-08-17', '2025-08-17 08:09:32'),
(19, 21, 'Well', '2025-08-17', '2025-08-17 08:49:13'),
(20, 27, 'Well', '2025-08-17', '2025-08-17 11:29:23'),
(21, 26, 'Not Well', '2025-08-17', '2025-08-17 12:04:19'),
(22, 41, 'Well', '2025-08-18', '2025-08-18 03:44:36'),
(23, 45, 'Well', '2025-08-18', '2025-08-18 03:48:31'),
(24, 44, 'Not Well', '2025-08-18', '2025-08-18 03:48:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wellness_status`
--
ALTER TABLE `wellness_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_status` (`user_id`,`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `wellness_status`
--
ALTER TABLE `wellness_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wellness_status`
--
ALTER TABLE `wellness_status`
  ADD CONSTRAINT `wellness_status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
