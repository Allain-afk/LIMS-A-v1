-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 10:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lims`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `FirstName`, `LastName`, `email`, `created_at`) VALUES
(1, 'allain', '123', 'Allain', 'Legaspi', '', '2025-03-24 07:30:46'),
(2, 'ayham', '123', 'Ayham', 'Kalsam', '', '2025-03-24 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `language` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `availability` varchar(20) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `language`, `type`, `created_at`, `availability`) VALUES
(1, 'The Art of Computer Programming', 'Donald Knuth', 'English', 'Technical', '2025-03-24 15:35:33', 'Available'),
(2, 'Pride and Prejudice', 'Jane Austen', 'English', 'Literature', '2025-03-24 15:35:33', 'Available'),
(3, 'One Hundred Years of Solitude', 'Gabriel García Márquez', 'English', 'Fiction', '2025-03-24 15:35:33', 'Available'),
(4, 'Introduction to Algorithms', 'Thomas H. Cormen', 'English', 'Educational', '2025-03-24 15:35:33', 'Available'),
(5, 'The Great Gatsby', 'F. Scott Fitzgerald', 'English', 'Literature', '2025-03-24 15:35:33', 'Available'),
(6, 'Hibernate - Core', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(7, 'Java Programming', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(8, 'Web Development', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(9, 'Database Design', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(10, 'Python Basics', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(11, 'Data Structures', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available'),
(12, 'Algorithms', 'Allain', 'English', 'Educational', '2025-03-26 19:59:11', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` timestamp NOT NULL DEFAULT (current_timestamp() + interval 7 day),
  `return_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`) VALUES
(1, 5, 1, '2025-03-26 21:02:42', '2025-04-02 13:02:42', '2025-03-26 21:15:39'),
(2, 5, 2, '2025-03-26 21:33:10', '2025-04-02 13:33:10', '2025-03-26 21:33:26'),
(3, 5, 3, '2025-03-26 21:33:10', '2025-04-02 13:33:10', '2025-03-26 21:33:31'),
(4, 5, 4, '2025-03-26 21:33:10', '2025-04-02 13:33:10', '2025-03-26 21:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_name`, `branch_location`) VALUES
(1, 'Ayham Bookstore', 'Cebu City'),
(2, 'Allain Library', 'Carcar City'),
(3, 'Good Stuff Books', 'Lapu Lapu City');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `FirstName` varchar(155) DEFAULT NULL,
  `LastName` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `FirstName`, `LastName`) VALUES
(1, 'norman', '123', 'norman@gmail.com', '2025-03-24 16:04:16', 'Norman', 'Curato'),
(2, 'darlly', '123', 'darlly@gmail.com', '2025-03-24 16:04:16', 'Darlly', 'Restauro'),
(3, 'rodney', '123', 'rodney@gmail.com', '2025-03-24 16:04:16', 'Rodney', 'Portes'),
(4, 'raiken', '123', 'raiken@gmail.com', '2025-03-24 16:04:16', 'Raiken', 'Gwapo'),
(5, 'laysa', '123', 'lalai@gmail.com', '2025-03-24 16:42:04', 'Elyssa', 'Solon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
