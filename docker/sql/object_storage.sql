CREATE DATABASE if not exists storage;
USE storage;
SET GLOBAL sql_mode = '';

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
                         `id` int(11) NOT NULL,
                         `current` tinyint(1) NOT NULL,
                         `domain` varchar(200) NOT NULL,
                         `key_name` varchar(200) NOT NULL,
                         `mime` varchar(50) NOT NULL,
                         `data` longblob NOT NULL,
                         `thumb_mime` varchar(50) NOT NULL,
                         `thumb_data` longblob NOT NULL,
                         `verify` varchar(200) NOT NULL,
                         `reference` varchar(200) NOT NULL,
                         `created` datetime NOT NULL,
                         `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
    ADD PRIMARY KEY (`id`),
  ADD KEY `current` (`current`,`key_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;