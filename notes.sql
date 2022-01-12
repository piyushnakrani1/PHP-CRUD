CREATE TABLE `notes` (
  `sr.no` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `notes`
  ADD PRIMARY KEY (`sr.no`);

ALTER TABLE `notes`
  MODIFY `sr.no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

