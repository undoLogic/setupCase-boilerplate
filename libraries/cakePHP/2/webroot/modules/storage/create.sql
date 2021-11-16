CREATE DATABASE if not exists storage;

CREATE TABLE `files` (
                         `id` int(11) NOT NULL,
                         `current` tinyint(1) NOT NULL,
                         `domain` varchar(200) NOT NULL,
                         `key_name` varchar(200) NOT NULL,
                         `mime` varchar(50) NOT NULL,
                         `data` longblob NOT NULL,
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
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;