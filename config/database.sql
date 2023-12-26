

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `magnadokan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminId` int(11) NOT NULL,
  `adminUsername` varchar(32) NOT NULL,
  `adminEmail` varchar(64) NOT NULL,
  `adminPassword` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookLogs`
--

CREATE TABLE `bookLogs` (
  `logId` int(11) NOT NULL,
  `userIp` varchar(64) NOT NULL,
  `userLoggedIn` tinyint(1) NOT NULL,
  `userId` int(11) NOT NULL,
  `userCountry` varchar(32) NOT NULL,
  `pageUrl` varchar(128) NOT NULL,
  `event` varchar(32) NOT NULL,
  `clientUid` varchar(64) NOT NULL,
  `bookId` int(12) NOT NULL,
  `bookCategory` varchar(64) NOT NULL,
  `logTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookRequests`
--

CREATE TABLE `bookRequests` (
  `bookName` varchar(64) NOT NULL,
  `bookPublicationYear` year(4) NOT NULL,
  `bookRequestId` int(11) NOT NULL,
  `bookWritters` varchar(64) NOT NULL,
  `requestFrom` int(32) NOT NULL,
  `requestNote` text NOT NULL,
  `requestStatus` varchar(32) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookId` int(11) NOT NULL,
  `bookName` varchar(128) NOT NULL,
  `bookWritters` varchar(128) NOT NULL,
  `bookTags` varchar(512) NOT NULL,
  `bookDescription` text NOT NULL,
  `clicks` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `bookCover` varchar(128) NOT NULL,
  `bookPdf` varchar(128) NOT NULL,
  `bookLanguage` varchar(16) NOT NULL,
  `bookCategory` varchar(32) NOT NULL,
  `bookBuyingLink` varchar(128) NOT NULL,
  `bookAddedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `bookUpdatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL,
  `category` varchar(32) NOT NULL,
  `categoryIcon` varchar(128) NOT NULL,
  `clicks` int(11) NOT NULL,
  `downloads` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(11) NOT NULL,
  `clientUid` varchar(64) NOT NULL,
  `clientAddedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `clientBrowser` varchar(32) NOT NULL,
  `clientDevice` varchar(32) NOT NULL,
  `clientLastActive` datetime NOT NULL DEFAULT current_timestamp(),
  `clientLastIp` varchar(32) NOT NULL,
  `clientLastLocation` varchar(64) NOT NULL,
  `clientOs` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `fileId` int(11) NOT NULL,
  `fileName` varchar(128) NOT NULL,
  `fileStatus` varchar(32) NOT NULL DEFAULT 'uploaded',
  `filePurpous` varchar(32) NOT NULL,
  `addedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `languageId` int(11) NOT NULL,
  `language` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `libraryId` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `addedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE `userLogs` (
  `logId` int(11) NOT NULL,
  `clientUid` varchar(64) NOT NULL,
  `pageUrl` varchar(128) NOT NULL,
  `userIp` varchar(64) NOT NULL,
  `userCountry` varchar(32) NOT NULL,
  `userId` int(11) NOT NULL DEFAULT 0,
  `event` varchar(32) NOT NULL,
  `logTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(32) NOT NULL,
  `userEmail` varchar(64) NOT NULL,
  `userFullName` varchar(32) NOT NULL,
  `userPassword` varchar(128) NOT NULL,
  `userSignedUpAt` datetime NOT NULL DEFAULT current_timestamp(),
  `userStatus` varchar(32) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usersessions`
--

CREATE TABLE `userSessions` (
  `sessionId` int(32) NOT NULL,
  `sessionUid` varchar(64) NOT NULL,
  `sessionBrowser` varchar(32) NOT NULL,
  `sessionOs` varchar(32) NOT NULL,
  `sessionTimeout` int(32) NOT NULL,
  `userId` int(32) NOT NULL,
  `sessionStatus` varchar(16) NOT NULL DEFAULT 'active',
  `userName` varchar(64) NOT NULL,
  `sessionLastIp` varchar(32) NOT NULL,
  `sessionLastCountry` varchar(32) NOT NULL,
  `clientId` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `writters`
--

CREATE TABLE `writters` (
  `writterId` int(11) NOT NULL,
  `writterName` varchar(32) NOT NULL,
  `writterImg` varchar(128) NOT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `bookLogs`
--
ALTER TABLE `bookLogs`
  ADD PRIMARY KEY (`logId`);

--
-- Indexes for table `bookRequests`
--
ALTER TABLE `bookRequests`
  ADD PRIMARY KEY (`bookRequestId`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`fileId`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`languageId`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`libraryId`);

--
-- Indexes for table `userlogs`
--
ALTER TABLE `userLogs`
  ADD PRIMARY KEY (`logId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `usersessions`
--
ALTER TABLE `userSessions`
  ADD PRIMARY KEY (`sessionId`);

--
-- Indexes for table `writters`
--
ALTER TABLE `writters`
  ADD PRIMARY KEY (`writterId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookLogs`
--
ALTER TABLE `bookLogs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookRequests`
--
ALTER TABLE `bookRequests`
  MODIFY `bookRequestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `languageId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `libraryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usersessions`
--
ALTER TABLE `usersessions`
  MODIFY `sessionId` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `writters`
--
ALTER TABLE `writters`
  MODIFY `writterId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
