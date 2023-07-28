-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 28, 2023 at 10:23 AM
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
-- Table structure for table `Collages`
--

CREATE TABLE `Collages` (
  `CollageID` int(11) UNSIGNED NOT NULL,
  `CollegeName` varchar(100) NOT NULL,
  `TotalStudents` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Collages`
--

INSERT INTO `Collages` (`CollageID`, `CollegeName`, `TotalStudents`) VALUES
(1, 'Enginnering', 10000),
(2, 'Literature', 50000),
(3, 'Sciences', 60000),
(4, 'Medicine', 9000),
(5, 'Business', 15000),
(6, 'Social Sciences', 200),
(7, 'Education', 10000),
(8, 'Arts', 500),
(9, 'Information System', 20000);

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
  `TotalStudents` smallint(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `Instructors`
--

CREATE TABLE `Instructors` (
  `InstructorID` int(11) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `Department` int(11) UNSIGNED NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(10) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL COMMENT 'The state or province where the instructor is located.',
  `Country` varchar(50) NOT NULL COMMENT 'The country where the instructor is located.',
  `DOB` date DEFAULT NULL,
  `HireDate` datetime NOT NULL,
  `Salary` decimal(9,2) NOT NULL,
  `YearsOfExperience` tinyint(2) UNSIGNED NOT NULL CHECK (`YearsOfExperience` <= 70),
  `IfFullTime` tinyint(1) NOT NULL COMMENT 'A boolean column indicating whether the instructor is a full-time employee (true/false).',
  `IsActive` tinyint(1) NOT NULL COMMENT ' A boolean column indicating whether the instructor is currently active (true/false).',
  `Password` varchar(200) NOT NULL,
  `NationalIdentificationNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `StudentID` int(11) UNSIGNED NOT NULL,
  `NumberHoursSuccess` tinyint(3) NOT NULL,
  `AdmissionYear` date NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `DOB` date NOT NULL COMMENT 'Date Of Birth',
  `Gender` enum('Male','Female') NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`StudentID`, `NumberHoursSuccess`, `AdmissionYear`, `FirstName`, `LastName`, `DOB`, `Gender`, `Address`, `Email`, `PhoneNumber`) VALUES
(1, 50, '2023-07-14', 'Feras ', 'Barahmeh', '2013-07-17', 'Male', 'Amman-Jordan', 'ferasbarahmhe55@gmail.com', '0785012269');

-- --------------------------------------------------------

--
-- Table structure for table `UniversityMajors`
--

CREATE TABLE `UniversityMajors` (
  `MajorId` int(11) UNSIGNED NOT NULL,
  `NumberHoursMajor` tinyint(3) UNSIGNED NOT NULL,
  `NumberStudentInMajor` smallint(5) UNSIGNED NOT NULL,
  `CoursesNumber` tinyint(3) UNSIGNED NOT NULL,
  `MajorName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Collages`
--
ALTER TABLE `Collages`
  ADD PRIMARY KEY (`CollageID`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`CourseID`);

--
-- Indexes for table `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `Instructors`
--
ALTER TABLE `Instructors`
  ADD PRIMARY KEY (`InstructorID`),
  ADD KEY `FK_Instruct_In_Collage` (`Department`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`StudentID`);

--
-- Indexes for table `UniversityMajors`
--
ALTER TABLE `UniversityMajors`
  ADD PRIMARY KEY (`MajorId`),
  ADD UNIQUE KEY `MajorName` (`MajorName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Collages`
--
ALTER TABLE `Collages`
  MODIFY `CollageID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `CourseID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Departments`
--
ALTER TABLE `Departments`
  MODIFY `DepartmentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Enrollment`
--
ALTER TABLE `Enrollment`
  MODIFY `EnrollmentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Instructors`
--
ALTER TABLE `Instructors`
  MODIFY `InstructorID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `StudentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `UniversityMajors`
--
ALTER TABLE `UniversityMajors`
  MODIFY `MajorId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `FK_Collage_ID` FOREIGN KEY (`DepartmentID`) REFERENCES `Collages` (`CollageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Enrollment`
--
ALTER TABLE `Enrollment`
  ADD CONSTRAINT `Enrollment_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `Students` (`StudentID`),
  ADD CONSTRAINT `Enrollment_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `Courses` (`CourseID`);

--
-- Constraints for table `Instructors`
--
ALTER TABLE `Instructors`
  ADD CONSTRAINT `FK_Instruct_In_Collage` FOREIGN KEY (`Department`) REFERENCES `Collages` (`CollageID`);

--
-- Constraints for table `UniversityMajors`
--
ALTER TABLE `UniversityMajors`
  ADD CONSTRAINT `FK_Major` FOREIGN KEY (`MajorId`) REFERENCES `Collages` (`CollageID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
