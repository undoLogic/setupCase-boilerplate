-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 08, 2022 at 09:04 PM
-- Server version: 5.6.39
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `LIVE_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
                          `id` int(11) NOT NULL,
                          `name` varchar(100) NOT NULL,
                          `created` datetime NOT NULL,
                          `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
                                                               (1, 'Main Group', '2022-11-08 18:48:17', '2022-11-08 18:48:17'),
                                                               (2, 'Secondary Group', '2022-11-08 18:48:17', '2022-11-08 18:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `user_type` varchar(19) NOT NULL,
                         `group_id` int(11) NOT NULL,
                         `name` varchar(99) NOT NULL,
                         `email` varchar(99) NOT NULL,
                         `password` varchar(1000) NOT NULL,
                         `reset_token` varchar(1000) NOT NULL,
                         `created` datetime NOT NULL,
                         `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;




























CREATE TABLE `activity_logs` (
                                 `id` int(11) NOT NULL,
                                 `user_id` int(11) DEFAULT NULL,
                                 `dealer_id` int(11) DEFAULT NULL,
                                 `supplier_id` int(11) DEFAULT NULL,
                                 `store_id` int(11) DEFAULT NULL,
                                 `page` varchar(20) NOT NULL,
                                 `notes` varchar(1000) NOT NULL,
                                 `ip` varchar(20) NOT NULL,
                                 `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;