-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2022 at 03:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_students`
--

CREATE TABLE `all_students` (
  `email` varchar(100) NOT NULL,
  `studentID` varchar(100) NOT NULL,
  `courseNumber` varchar(100) NOT NULL,
  `term` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_students`
--

INSERT INTO `all_students` (`email`, `studentID`, `courseNumber`, `term`, `year`, `firstName`, `lastName`) VALUES
('joe@comp307.com', '123456789', 'COMP 250', 'Fall', '2022', 'Joe', 'Brown'),
('mary@comp307.com', '147258369', 'COMP 250', 'Fall', '2022', 'Mary', 'Smith');

-- --------------------------------------------------------

--
-- Table structure for table `all_ta`
--

CREATE TABLE `all_ta` (
  `email` varchar(100) NOT NULL,
  `courseNumber` varchar(100) NOT NULL,
  `term` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_ta`
--

INSERT INTO `all_ta` (`email`, `courseNumber`, `term`, `year`, `firstName`, `lastName`) VALUES
('william@comp307.com', 'COMP 250', 'Winter', '2023', 'William', 'Miller'),
('joe@comp307.com', 'COMP 402', 'Winter', '2023', 'Joe', 'Brown'),
('martin@comp307.com', 'COMP 307', 'Fall', '2022', 'Martin', 'Walker'),
('martin@comp307.com', 'COMP 421', 'Winter', '2023', 'Martin', 'Walker'),
('sarah@comp307.com', 'COMP 250', 'Fall', '2022', 'Sarah', 'Hall'),
('sarah@comp307.com', 'COMP 251', 'Winter', '2023', 'Sarah', 'Hall');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseName` varchar(256) NOT NULL,
  `courseDesc` text NOT NULL,
  `term` varchar(8) NOT NULL,
  `year` varchar(4) NOT NULL,
  `courseNumber` varchar(8) NOT NULL,
  `courseInstructor` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseName`, `courseDesc`, `term`, `year`, `courseNumber`, `courseInstructor`) VALUES
('Introduction to Computer Science', 'Mathematical tools (binary numbers, induction, recurrence relations, asymptotic complexity, establishing correctness of programs), Data structures (arrays, stacks, queues, linked lists, trees, binary trees, binary search trees, heaps, hash tables), Recursive and non-recursive algorithms (searching and sorting, tree and graph traversal). Abstract data types, inheritance. Selected topics.', 'Fall', '2022', 'COMP 250', 'ann@comp307.com'),
('Algorithms and Data Structures', 'Introduction to algorithm design and analysis. Graph algorithms, greedy algorithms, data structures, dynamic programming, maximum flows.', 'Winter', '2023', 'COMP 251', 'william@comp307.com'),
('Principles of Web Development', 'The course discusses the major principles, algorithms, languages and technologies that underlie web development. Students receive practical hands-on experience through a project.', 'Fall', '2022', 'COMP 307', 'joseph@comp307.com'),
('Honours Project in Computer Science and Biology', 'One-semester research project applying computational approaches to a biological problem. The project is (co)-supervised by a professor in Computer Science and/or Biology or related fields.', 'Winter', '2023', 'COMP 402', 'mathieu@comp307.com'),
('Database Systems', 'Database Design: conceptual design of databases (e.g., entity-relationship model), relational data model, functional dependencies. Database Manipulation: relational algebra, SQL, database application programming, triggers, access control. Database Implementation: transactions, concurrency control, recovery, query execution and query optimization.', 'Winter', '2023', 'COMP 421', 'sophie@comp307.com');

-- --------------------------------------------------------

--
-- Table structure for table `courses_quota`
--

CREATE TABLE `courses_quota` (
  `TermYear` varchar(100) NOT NULL,
  `CourseNumber` varchar(100) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `CourseType` varchar(100) NOT NULL,
  `InstructorName` varchar(100) NOT NULL,
  `EnrollmentNumber` int(11) NOT NULL,
  `TAQuota` int(11) NOT NULL,
  `PositionsToAssign` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses_quota`
--

INSERT INTO `courses_quota` (`TermYear`, `CourseNumber`, `CourseName`, `CourseType`, `InstructorName`, `EnrollmentNumber`, `TAQuota`, `PositionsToAssign`) VALUES
('Fall 2022', 'COMP 250', 'Intro to Computer Science', 'Regular', 'Sarah Hall', 80, 2, 1),
('Winter 2023', 'COMP 251', 'Algorithms and Data Structures', 'Regular', 'William Miller', 100, 3, 1),
('Winter 2023', 'COMP 421', 'Database Systems', 'Regular', 'Sophie Moore', 200, 6, 6),
('Fall 2022', 'COMP 307', 'Principles of Web Development', 'Regular', 'Joseph Vybihal', 100, 3, 2),
('Winter 2023', 'COMP 402', 'Honours Project in Computer Science and Biology', 'Regular', 'Mathieu Blanchette', 40, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor` varchar(40) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `course` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`professor`, `faculty`, `department`, `course`) VALUES
('ann@comp307.com', 'Science', 'Computer Science', 'COMP 250'),
('avi@comp307.com', 'Science', 'Computer Science', 'COMP 307'),
('joseph@comp307.com', 'Science', 'Computer Science', 'COMP 307'),
('mathieu@comp307.com', 'Science', 'Computer Science', 'COMP 402'),
('sophie@comp307.com', 'Science', 'Computer Science', 'COMP 421'),
('william@comp307.com', 'Science', 'Computer Science', 'COMP 251');

-- --------------------------------------------------------

--
-- Table structure for table `ta_assigned`
--

CREATE TABLE `ta_assigned` (
  `AssignID` int(11) NOT NULL,
  `TermYear` varchar(100) NOT NULL,
  `CourseNum` varchar(100) NOT NULL,
  `TAName` varchar(100) NOT NULL,
  `StudentID` varchar(100) NOT NULL,
  `TAEmail` varchar(100) NOT NULL,
  `AssignedHours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_assigned`
--

INSERT INTO `ta_assigned` (`AssignID`, `TermYear`, `CourseNum`, `TAName`, `StudentID`, `TAEmail`, `AssignedHours`) VALUES
(13, 'Fall 2022', 'COMP 307', 'Martin Walker', '777888999', 'martin@comp307.com', 180),
(15, 'Winter 2023', 'COMP 402', 'Joe Brown', '123456789', 'joe@comp307.com', 90),
(16, 'Winter 2023', 'COMP 251', 'Sarah Hall', '444555666', 'sarah@comp307.com', 180),
(17, 'Fall 2022', 'COMP 250', 'Sarah Hall', '444555666', 'sarah@comp307.com', 90);

-- --------------------------------------------------------

--
-- Table structure for table `ta_cohort`
--

CREATE TABLE `ta_cohort` (
  `TermYear` varchar(100) NOT NULL,
  `TAName` varchar(100) NOT NULL,
  `StudentID` varchar(100) NOT NULL,
  `LegalName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `GradUgrad` varchar(100) NOT NULL,
  `SupervisorName` varchar(100) NOT NULL,
  `Priority` varchar(100) NOT NULL,
  `NumberHours` int(11) NOT NULL,
  `DateApplied` varchar(100) NOT NULL,
  `TheLocation` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Degree` varchar(100) NOT NULL,
  `CoursesApplied` varchar(100) NOT NULL,
  `OpenToOtherCourses` varchar(100) NOT NULL,
  `Notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_cohort`
--

INSERT INTO `ta_cohort` (`TermYear`, `TAName`, `StudentID`, `LegalName`, `Email`, `GradUgrad`, `SupervisorName`, `Priority`, `NumberHours`, `DateApplied`, `TheLocation`, `Phone`, `Degree`, `CoursesApplied`, `OpenToOtherCourses`, `Notes`) VALUES
('Fall 2022', 'William Miller', '111222333', 'William Miller', 'william@comp307.com', 'grad', 'Sarah Hall', 'no', 90, '2022-01-10', 'Trottier', '5141234567', 'Computer Science', 'COMP 250', 'yes', ''),
('Fall 2022', 'Martin Walker', '777888999', 'Martin Walker', 'martin@comp307.com', 'grad', 'Joseph Vybihal', 'yes', 180, '2022-09-13', 'McIntyre', '5145145145', 'Computer Science', 'COMP 307; COMP 250', 'yes', 'Bye'),
('Fall 2022', 'Sarah Hall', '444555666', 'Sarah Hall', 'sarah@comp307.com', 'grad', 'Sarah Hall', 'yes', 90, '2022-10-29', 'Adams', '5149876543', 'Computer Science', 'COMP 250; COMP 307', 'no', ''),
('Winter 2023', 'Martin Walker', '777888999', 'Martin Walker', 'martin@comp307.com', 'grad', 'Sophie Moore', 'no', 180, '2022-11-29', 'McIntyre', '5145145145', 'Computer Science', 'COMP 421; COMP 251', 'yes', 'Dont choose me'),
('Winter 2023', 'Joe Brown', '123456789', 'Joe Brown', 'joe@comp307.com', 'ugrad', 'Mathieu Blanchette', 'yes', 90, '2022-04-15', 'McConnell', '5141597324', 'Computer Science', 'COMP 402', 'yes', 'Hello'),
('Winter 2023', 'Sarah Hall', '444555666', 'Sarah Hall', 'sarah@comp307.com', 'grad', 'William Miller', 'yes', 180, '2022-06-07', 'Adams', '5149876543', 'Computer Science', 'COMP 251; COMP 421', 'yes', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `ta_history`
--

CREATE TABLE `ta_history` (
  `RecordID` int(11) NOT NULL,
  `TermYear` varchar(100) NOT NULL,
  `TAName` varchar(100) NOT NULL,
  `TAEmail` varchar(100) NOT NULL,
  `CourseNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_history`
--

INSERT INTO `ta_history` (`RecordID`, `TermYear`, `TAName`, `TAEmail`, `CourseNumber`) VALUES
(1, 'Fall 2020', 'Willian Miller', 'william.miller@mail.mcgill.ca', 'COMP 202'),
(2, 'Winter 2021', 'Martin Walker', 'martin.walker@mail.mcgill.ca', 'COMP 206'),
(3, 'Winter 2021', 'William Miller', 'william.miller@mail.mcgill.ca', 'COMP 202'),
(4, 'Fall 2021', 'Joe Brown', 'joe.brown@mail.mcgill.ca', 'COMP 251'),
(11, 'Fall 2022', 'Martin Walker', 'martin@comp307.com', 'COMP 307'),
(13, 'Winter 2023', 'Joe Brown', 'joe@comp307.com', 'COMP 402'),
(14, 'Winter 2023', 'Sarah Hall', 'sarah@comp307.com', 'COMP 251'),
(15, 'Fall 2022', 'Sarah Hall', 'sarah@comp307.com', 'COMP 250');

-- --------------------------------------------------------

--
-- Table structure for table `ta_performance`
--

CREATE TABLE `ta_performance` (
  `TermYear` varchar(100) NOT NULL,
  `CourseNumber` varchar(100) NOT NULL,
  `TAName` varchar(100) NOT NULL,
  `TAEmail` varchar(100) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `TimeStamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_performance`
--

INSERT INTO `ta_performance` (`TermYear`, `CourseNumber`, `TAName`, `TAEmail`, `Comment`, `TimeStamp`) VALUES
('Fall 2022', 'COMP 250', 'Sarah Hall', 'sarah@comp307.com', 'Worked hard!', '2022-12-04'),
('Fall 2022', 'COMP 250', 'William Miller', 'william@comp307.com', 'Did not correct assignments fast enough!', '2022-12-04'),
('Winter 2023', 'COMP 251', 'Sarah Hall', 'sarah@comp307.com', 'Good at explaining difficult concepts to students!', '2022-12-04'),
('Winter 2023', 'COMP 421', 'Martin Walker', 'martin@comp307.com', 'Students complaining about him.', '2022-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `ta_rating`
--

CREATE TABLE `ta_rating` (
  `rated_by` varchar(100) NOT NULL,
  `rating_for` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `term` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_rating`
--

INSERT INTO `ta_rating` (`rated_by`, `rating_for`, `course`, `term`, `year`, `rating`, `comment`) VALUES
('mary@comp307.com', 'sarah@comp307.com', 'COMP 250', 'Fall', '2022', '5', 'Very helpful!'),
('mary@comp307.com', 'joe@comp307.com', 'COMP 402', 'Winter', '2023', '1', 'Did not like him!'),
('joe@comp307.com', 'sarah@comp307.com', 'COMP 250', 'Fall', '2022', '2', 'Not helpful, do not recommend!'),
('joe@comp307.com', 'martin@comp307.com', 'COMP 307', 'Fall', '2022', '4', 'Good TA');

-- --------------------------------------------------------

--
-- Table structure for table `ta_wishlist`
--

CREATE TABLE `ta_wishlist` (
  `TermYear` varchar(100) NOT NULL,
  `CourseNumber` varchar(100) NOT NULL,
  `ProfName` varchar(100) NOT NULL,
  `TAName` varchar(100) NOT NULL,
  `TAEmail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_wishlist`
--

INSERT INTO `ta_wishlist` (`TermYear`, `CourseNumber`, `ProfName`, `TAName`, `TAEmail`) VALUES
('Winter 2023', 'COMP 251', 'William Miller', 'Sarah Hall', 'sarah@comp307.com'),
('Winter 2023', 'COMP 421', 'Sophie Moore', 'Martin Walker', 'martin@comp307.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`firstName`, `lastName`, `email`, `password`, `createdAt`, `updatedAt`) VALUES
('Ann', 'Lee', 'ann@comp307.com', '$2y$10$8Crpfowt8OG1ACfcgAualOPtVbEM4.0jdRF0am2hqdM839NX9ynfe', '2022-12-04 06:23:18', '2022-12-04 18:36:06'),
('Avinash', 'Bhat', 'avi@comp307.com', '$2y$10$iqQA5ffMBUaBn0weeSM8.eKbEwhyGPOqV.DxKL.Ox2A1cq.0QfpuW', '2022-10-11 04:42:50', '2022-10-11 04:42:50'),
('Jane', 'Doe', 'jane@comp307.com', '$2y$10$Jq/Ab6L6yPpGbPmyt5tC1e5uO81fP4YBLAow4LHPRgVtLjU8rcK7C', '2022-10-13 18:09:22', '2022-10-13 18:09:22'),
('Joe', 'Brown', 'joe@comp307.com', '$2y$10$qdiws8GEJHg8pl9kQLYxe.drCyBgo510H8c9VIo8Hbot.BIwHvRUW', '2022-12-04 07:10:24', '2022-12-04 07:10:24'),
('John', 'Doe', 'john@comp307.com', '$2y$10$jAGY.QSoQwIoTH13LWUaKu3LdCoYOG2zey0pz4qJNtTdaF3G4Elqy', '2022-10-09 16:46:43', '2022-10-09 16:46:43'),
('Joseph', 'Vybihal', 'joseph@comp307.com', '$2y$10$MwaR9.9RqkKnjGsj6ELtAugh4EwRjh84esjwp6tf52XOTZpy6xxGu', '2022-10-13 14:36:07', '2022-10-13 14:36:07'),
('Martin', 'Walker', 'martin@comp307.com', '$2y$10$kZwidfgLQQvoLWQr/xW0fuOqtbo0sERDHPBWrKbKJyxDhM7Y9Bhx.', '2022-12-04 07:11:24', '2022-12-04 07:11:24'),
('Mary', 'Smith', 'mary@comp307.com', '$2y$10$5zJQ8c.MWd1BXo5fJb61sOKInv1hDmdK4ig7NYrZYtRHuXVHOnGcO', '2022-12-04 07:43:56', '2022-12-04 07:43:56'),
('Mathieu', 'Blanchette', 'mathieu@comp307.com', '$2y$10$5HxIGFEmYO6OyG7IOgjlmuCRofwLTG2Ah9DtiEdGetHD.rZZN0Xbq', '2022-10-13 18:09:22', '2022-10-13 18:09:22'),
('Sarah', 'Hall', 'sarah@comp307.com', '$2y$10$Zso1aBIHZ0q8N3wua.mNMuwmRiYcoEjDwn0JJFGDn0PFT/ARmhgMa', '2022-12-04 07:12:49', '2022-12-04 07:12:49'),
('Sophie', 'Moore', 'sophie@comp307.com', '$2y$10$LaSwtIPL/Q.jJgdrBQU7yuLyO1v1x74LJZoj5Bqto4XczjDI3rD2i', '2022-12-04 06:58:45', '2022-12-04 06:58:45'),
('William', 'Miller', 'william@comp307.com', '$2y$10$zbzJ3FnboNkZrKOyUa7LJer6lhbBQCaZKRZyjYuYlIg3n20bPxj.W', '2022-12-04 06:22:30', '2022-12-04 18:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `idx` int(11) NOT NULL,
  `userType` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`idx`, `userType`) VALUES
(1, 'student'),
(2, 'professor'),
(3, 'ta'),
(4, 'admin'),
(5, 'sysop');

-- --------------------------------------------------------

--
-- Table structure for table `user_usertype`
--

CREATE TABLE `user_usertype` (
  `userId` varchar(40) NOT NULL,
  `userTypeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_usertype`
--

INSERT INTO `user_usertype` (`userId`, `userTypeId`) VALUES
('john@comp307.com', 5),
('avi@comp307.com', 5),
('joseph@comp307.com', 2),
('jane@comp307.com', 3),
('jane@comp307.com', 1),
('mathieu@comp307.com', 2),
('mathieu@comp307.com', 5),
('mathieu@comp307.com', 4),
('william@comp307.com', 2),
('ann@comp307.com', 2),
('william@comp307.com', 3),
('sophie@comp307.com', 2),
('sophie@comp307.com', 5),
('joe@comp307.com', 1),
('joe@comp307.com', 3),
('martin@comp307.com', 3),
('sarah@comp307.com', 3),
('mary@comp307.com', 1),
('sarah@comp307.com', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseNumber`),
  ADD KEY `CourseInstructor_ForeignKey` (`courseInstructor`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`professor`),
  ADD KEY `CourseNumber_ForeignKey` (`course`);

--
-- Indexes for table `ta_assigned`
--
ALTER TABLE `ta_assigned`
  ADD PRIMARY KEY (`AssignID`);

--
-- Indexes for table `ta_history`
--
ALTER TABLE `ta_history`
  ADD PRIMARY KEY (`RecordID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `idx` (`idx`);

--
-- Indexes for table `user_usertype`
--
ALTER TABLE `user_usertype`
  ADD KEY `User_ForeignKey` (`userId`),
  ADD KEY `UserType_ForeignKey` (`userTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ta_assigned`
--
ALTER TABLE `ta_assigned`
  MODIFY `AssignID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ta_history`
--
ALTER TABLE `ta_history`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `CourseInstructor_ForeignKey` FOREIGN KEY (`courseInstructor`) REFERENCES `user` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `CourseNumber_ForeignKey` FOREIGN KEY (`course`) REFERENCES `course` (`courseNumber`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ProfName_ForeignKey` FOREIGN KEY (`professor`) REFERENCES `user` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `user_usertype`
--
ALTER TABLE `user_usertype`
  ADD CONSTRAINT `UserType_ForeignKey` FOREIGN KEY (`userTypeId`) REFERENCES `usertype` (`idx`) ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ForeignKey` FOREIGN KEY (`userId`) REFERENCES `user` (`email`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
