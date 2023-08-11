-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2023 at 11:30 AM
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
(1, 'feras@stu.ttu.edu.jo', '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', 1, 'Feras', 0);

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
(1, 'Enginnering', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `CourseID` int(11) UNSIGNED NOT NULL,
  `CourseRequirement` int(11) UNSIGNED DEFAULT NULL,
  `CourseName` varchar(50) NOT NULL,
  `CreditHours` int(4) NOT NULL DEFAULT 0,
  `Year` enum('FirstYear','SecondYear','ThirdYear','FourthYear','FifthYear') DEFAULT NULL COMMENT 'to determine the academic year in which the course is offered',
  `AffiliatedToDepartment` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Departments`
--

CREATE TABLE `Departments` (
  `DepartmentID` int(11) UNSIGNED NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `TotalStudentsInDepartment` smallint(5) UNSIGNED DEFAULT 0,
  `CollegeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Departments`
--

INSERT INTO `Departments` (`DepartmentID`, `DepartmentName`, `TotalStudentsInDepartment`, `CollegeID`) VALUES
(1, 'Computer and communications Engineering', NULL, 1);

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
-- Table structure for table `Guide`
--

CREATE TABLE `Guide` (
  `GuideID` int(11) NOT NULL,
  `GuideName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Expertise` varchar(100) DEFAULT NULL,
  `YearsOfExperience` int(11) DEFAULT NULL,
  `Availability` varchar(50) DEFAULT NULL,
  `OfficeHours` varchar(100) DEFAULT NULL,
  `Bio` text DEFAULT NULL,
  `Department` int(11) UNSIGNED NOT NULL,
  `Privilege` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Naem', 1, 'Alodat', 'naem@stu.ttu.edu.jo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1500.00, 12, 1, 1, 2, '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', '15896365878', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Majors`
--

CREATE TABLE `Majors` (
  `MajorID` int(11) UNSIGNED NOT NULL,
  `NumberHoursMajor` tinyint(3) UNSIGNED NOT NULL,
  `NumberStudentInMajor` smallint(5) UNSIGNED DEFAULT NULL,
  `CoursesNumber` tinyint(3) UNSIGNED NOT NULL,
  `MajorName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `MajorDepartmentID` int(11) UNSIGNED NOT NULL,
  `MajorCollegeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Majors`
--

INSERT INTO `Majors` (`MajorID`, `NumberHoursMajor`, `NumberStudentInMajor`, `CoursesNumber`, `MajorName`, `MajorDepartmentID`, `MajorCollegeID`) VALUES
(2, 162, NULL, 62, 'intelligent system Engineering', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `StudentID` int(11) UNSIGNED NOT NULL,
  `NumberHoursSuccess` int(10) UNSIGNED NOT NULL,
  `AdmissionYear` year(4) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `StudentCollegeID` int(11) UNSIGNED NOT NULL,
  `DOB` date DEFAULT NULL COMMENT 'Date Of Birth',
  `Gender` enum('Male','Female') NOT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Privilege` tinyint(3) UNSIGNED NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `language` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`StudentID`, `NumberHoursSuccess`, `AdmissionYear`, `FirstName`, `LastName`, `Password`, `StudentCollegeID`, `DOB`, `Gender`, `Address`, `Email`, `Privilege`, `PhoneNumber`, `language`) VALUES
(1, 15, NULL, 'Majd ', 'Barahmeh', '$2a$07$yeNCSNwRpYopOhv0TrrReO.CgBLQTGn6YYr1a96YlnBHx6bYBpe7.', 1, NULL, 'Male', NULL, 'majd@stu.ttu.edu.jo', 4, NULL, 0);

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
  ADD PRIMARY KEY (`CourseID`);

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
-- Indexes for table `Guide`
--
ALTER TABLE `Guide`
  ADD PRIMARY KEY (`GuideID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Department` (`Department`);

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
  ADD UNIQUE KEY `Email` (`Email`);

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
  MODIFY `CourseID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `Guide`
--
ALTER TABLE `Guide`
  MODIFY `GuideID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Instructors`
--
ALTER TABLE `Instructors`
  MODIFY `InstructorID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Majors`
--
ALTER TABLE `Majors`
  MODIFY `MajorID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `StudentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `FK_Affiliated_To_A_College` FOREIGN KEY (`CourseID`) REFERENCES `Departments` (`DepartmentID`);

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
-- Constraints for table `Guide`
--
ALTER TABLE `Guide`
  ADD CONSTRAINT `FK_Department` FOREIGN KEY (`Department`) REFERENCES `Departments` (`DepartmentID`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
