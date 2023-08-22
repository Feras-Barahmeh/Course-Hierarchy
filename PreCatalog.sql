-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 22, 2023 at 09:52 PM
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
-- Database: `PreCatalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `AdminID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Privilege` tinyint(3) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL,
  `language` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminID`, `Email`, `Password`, `Privilege`, `Name`, `language`) VALUES
(1, 'feras@adm.ttu.edu.jo', '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', 1, 'Feras', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Colleges`
--

CREATE TABLE `Colleges` (
  `CollegeID` int(11) UNSIGNED NOT NULL,
  `CollegeName` varchar(100) NOT NULL,
  `TotalStudentsInCollege` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Colleges`
--

INSERT INTO `Colleges` (`CollegeID`, `CollegeName`, `TotalStudentsInCollege`) VALUES
(1, 'Engineering', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `CourseID` int(11) UNSIGNED NOT NULL,
  `CourseName` varchar(50) NOT NULL,
  `Year` enum('FirstYear','SecondYear','ThirdYear','FourthYear','FifthYear') DEFAULT NULL COMMENT 'to determine the academic year in which the course is offered',
  `CourseMajorID` int(11) UNSIGNED NOT NULL,
  `NumberHourCourse` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`CourseID`, `CourseName`, `Year`, `CourseMajorID`, `NumberHourCourse`) VALUES
(1, 'CPP', 'FirstYear', 1, 3),
(2, 'Physics 1', 'FirstYear', 1, 3),
(3, 'Physics 2', 'FirstYear', 1, 3),
(4, 'calculus 1', 'FirstYear', 1, 3),
(5, 'calculus 2', 'FirstYear', 1, 3),
(6, 'Python', 'FirstYear', 1, 3),
(7, 'Digital Logic Design', 'FirstYear', 1, 3),
(8, 'Engineering Mathmatical', 'FirstYear', 1, 3),
(9, 'Circuit', 'FirstYear', 1, 3),
(10, 'Chimstry', 'FirstYear', 1, 3),
(11, 'Statically', 'FirstYear', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Departments`
--

CREATE TABLE `Departments` (
  `DepartmentID` int(11) UNSIGNED NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `TotalStudentsInDepartment` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `CollegeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Departments`
--

INSERT INTO `Departments` (`DepartmentID`, `DepartmentName`, `TotalStudentsInDepartment`, `CollegeID`) VALUES
(1, 'Computer and Communications Engineering', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Enrollment`
--

CREATE TABLE `Enrollment` (
  `EnrollmentID` int(10) UNSIGNED NOT NULL,
  `StudentID` int(10) UNSIGNED NOT NULL,
  `CourseID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Guides`
--

CREATE TABLE `Guides` (
  `GuideID` int(11) UNSIGNED NOT NULL,
  `GuideName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(10) DEFAULT NULL,
  `YearsOfExperience` int(11) DEFAULT NULL,
  `OfficeHours` varchar(100) DEFAULT NULL,
  `GuideDepartmentID` int(11) UNSIGNED NOT NULL,
  `Privilege` tinyint(3) UNSIGNED NOT NULL,
  `Password` varchar(255) NOT NULL,
  `language` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Guides`
--

INSERT INTO `Guides` (`GuideID`, `GuideName`, `Email`, `PhoneNumber`, `YearsOfExperience`, `OfficeHours`, `GuideDepartmentID`, `Privilege`, `Password`, `language`) VALUES
(1, 'Ahmad Mohammad', 'ahmadmohammad@gui.ttu.edu.jo', '', 0, 'Sun 9-10', 1, 3, '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Instructors`
--

CREATE TABLE `Instructors` (
  `InstructorID` int(11) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `InstructorDepartmentID` int(11) UNSIGNED NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(10) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL COMMENT 'The state or province where the instructor is located.',
  `Country` varchar(50) DEFAULT NULL COMMENT 'The country where the instructor is located.',
  `DOB` date DEFAULT NULL,
  `HireDate` date DEFAULT NULL,
  `Salary` decimal(9,2) NOT NULL,
  `YearsOfExperience` tinyint(2) UNSIGNED NOT NULL CHECK (`YearsOfExperience` <= 70),
  `IfFullTime` tinyint(1) NOT NULL COMMENT 'A boolean column indicating whether the instructor is a full-time employee (true/false).',
  `IsActive` tinyint(1) NOT NULL COMMENT ' A boolean column indicating whether the instructor is currently active (true/false).',
  `Privilege` tinyint(3) UNSIGNED NOT NULL,
  `Password` varchar(200) NOT NULL,
  `NationalIdentificationNumber` varchar(11) NOT NULL,
  `language` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Instructors`
--

INSERT INTO `Instructors` (`InstructorID`, `FirstName`, `InstructorDepartmentID`, `LastName`, `Email`, `PhoneNumber`, `Address`, `City`, `State`, `Country`, `DOB`, `HireDate`, `Salary`, `YearsOfExperience`, `IfFullTime`, `IsActive`, `Privilege`, `Password`, `NationalIdentificationNumber`, `language`) VALUES
(1, 'Naem', 1, 'Alodat', 'naem@ins.ttu.edu.jo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1200.00, 12, 1, 1, 2, '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', '15896365878', 0),
(2, 'Abd Alilah', 1, 'Shapatat', 'abd@ins.ttu.edu.jo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6000.00, 12, 1, 1, 2, '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', '15896365800', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Majors`
--

CREATE TABLE `Majors` (
  `MajorID` int(11) UNSIGNED NOT NULL,
  `NumberHoursMajor` tinyint(3) UNSIGNED NOT NULL,
  `NumberStudentInMajor` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `CoursesNumber` tinyint(3) UNSIGNED NOT NULL,
  `MajorName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `MajorDepartmentID` int(11) UNSIGNED NOT NULL,
  `MajorCollegeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Majors`
--

INSERT INTO `Majors` (`MajorID`, `NumberHoursMajor`, `NumberStudentInMajor`, `CoursesNumber`, `MajorName`, `MajorDepartmentID`, `MajorCollegeID`) VALUES
(1, 162, 3, 62, 'Intelligent System Engineering', 1, 1),
(2, 162, 0, 62, 'Computer Enginner', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `StudentID` int(11) UNSIGNED NOT NULL,
  `StudentYear` enum('FirstYear','SecondYear','ThirdYear','FourthYear','FifthYear') NOT NULL DEFAULT 'FirstYear',
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `StudentDepartmentID` int(11) UNSIGNED NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Privilege` tinyint(3) UNSIGNED NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `language` tinyint(2) NOT NULL DEFAULT 0,
  `StudentMajor` int(11) UNSIGNED NOT NULL,
  `StudentCollegeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`StudentID`, `StudentYear`, `FirstName`, `LastName`, `Password`, `StudentDepartmentID`, `Gender`, `Address`, `Email`, `Privilege`, `PhoneNumber`, `language`, `StudentMajor`, `StudentCollegeID`) VALUES
(1, 'FirstYear', 'Majd', 'Barahmeh', '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', 1, 'Male', '', 'majd@stu.ttu.edu.jo', 4, '0785102996', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Votes`
--

CREATE TABLE `Votes` (
  `VoteID` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) NOT NULL,
  `ForYear` enum('FirstYear','SecondYear','ThirdYear','FourthYear','FifthYear','') DEFAULT NULL,
  `ForMajor` int(11) DEFAULT NULL,
  `ForDepartment` int(11) DEFAULT NULL,
  `TimeShare` datetime DEFAULT current_timestamp(),
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  `AddedBy` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Votes`
--

INSERT INTO `Votes` (`VoteID`, `Title`, `ForYear`, `ForMajor`, `ForDepartment`, `TimeShare`, `IsActive`, `AddedBy`) VALUES
(3, 'Summary 2023', 'FirstYear', 1, 1, '2023-08-22 22:52:48', b'1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `Colleges`
--
ALTER TABLE `Colleges`
  ADD PRIMARY KEY (`CollegeID`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `FK_Course_Major` (`CourseMajorID`);

--
-- Indexes for table `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD UNIQUE KEY `DepartmentName` (`DepartmentName`),
  ADD KEY `FK_Collage_ID` (`CollegeID`);

--
-- Indexes for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `Guides`
--
ALTER TABLE `Guides`
  ADD PRIMARY KEY (`GuideID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Guide_Department` (`GuideDepartmentID`);

--
-- Indexes for table `Instructors`
--
ALTER TABLE `Instructors`
  ADD PRIMARY KEY (`InstructorID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Instruct_In_Collage` (`InstructorDepartmentID`);

--
-- Indexes for table `Majors`
--
ALTER TABLE `Majors`
  ADD PRIMARY KEY (`MajorID`),
  ADD UNIQUE KEY `MajorName` (`MajorName`),
  ADD KEY `FK_Major_College` (`MajorCollegeID`),
  ADD KEY `FK_Major_Department` (`MajorDepartmentID`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Department_Studetn` (`StudentDepartmentID`),
  ADD KEY `FK_Major_Studetn` (`StudentMajor`),
  ADD KEY `FK_Student_College` (`StudentCollegeID`);

--
-- Indexes for table `Votes`
--
ALTER TABLE `Votes`
  ADD PRIMARY KEY (`VoteID`),
  ADD KEY `FK_Guider` (`AddedBy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Colleges`
--
ALTER TABLE `Colleges`
  MODIFY `CollegeID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `CourseID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Departments`
--
ALTER TABLE `Departments`
  MODIFY `DepartmentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Enrollment`
--
ALTER TABLE `Enrollment`
  MODIFY `EnrollmentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Guides`
--
ALTER TABLE `Guides`
  MODIFY `GuideID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Instructors`
--
ALTER TABLE `Instructors`
  MODIFY `InstructorID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Majors`
--
ALTER TABLE `Majors`
  MODIFY `MajorID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `StudentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Votes`
--
ALTER TABLE `Votes`
  MODIFY `VoteID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `FK_Course_Major` FOREIGN KEY (`CourseMajorID`) REFERENCES `Majors` (`MajorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Departments`
--
ALTER TABLE `Departments`
  ADD CONSTRAINT `FK_Collage_ID` FOREIGN KEY (`CollegeID`) REFERENCES `Colleges` (`CollegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD CONSTRAINT `Enrollment_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `Students` (`StudentID`),
  ADD CONSTRAINT `Enrollment_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `Courses` (`CourseID`);

--
-- Constraints for table `Guides`
--
ALTER TABLE `Guides`
  ADD CONSTRAINT `FK_Guide_Department` FOREIGN KEY (`GuideDepartmentID`) REFERENCES `Departments` (`DepartmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Instructors`
--
ALTER TABLE `Instructors`
  ADD CONSTRAINT `FK_Instruct_In_Collage` FOREIGN KEY (`InstructorDepartmentID`) REFERENCES `Colleges` (`CollegeID`);

--
-- Constraints for table `Majors`
--
ALTER TABLE `Majors`
  ADD CONSTRAINT `FK_Major_College` FOREIGN KEY (`MajorCollegeID`) REFERENCES `Colleges` (`CollegeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Major_Department` FOREIGN KEY (`MajorDepartmentID`) REFERENCES `Departments` (`DepartmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Students`
--
ALTER TABLE `Students`
  ADD CONSTRAINT `FK_Department_Studetn` FOREIGN KEY (`StudentDepartmentID`) REFERENCES `Departments` (`DepartmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Major_Studetn` FOREIGN KEY (`StudentMajor`) REFERENCES `Majors` (`MajorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Student_College` FOREIGN KEY (`StudentCollegeID`) REFERENCES `Colleges` (`CollegeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Votes`
--
ALTER TABLE `Votes`
  ADD CONSTRAINT `FK_Guider` FOREIGN KEY (`AddedBy`) REFERENCES `Guides` (`GuideID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
