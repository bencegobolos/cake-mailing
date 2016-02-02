CREATE TABLE IF NOT EXISTS `messages` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(40),
  `subject` varchar(40),
  `message` text
) ENGINE=InnoDB