CREATE TABLE `events` (
 `username` varchar(10) NOT NULL,
 `event_id` mediumint(10) NOT NULL AUTO_INCREMENT,
 `day` mediumint(8) unsigned NOT NULL,
 `month` mediumint(8) unsigned NOT NULL,
 `year` mediumint(8) unsigned NOT NULL,
 `title` varchar(50) NOT NULL,
 `categorial` enum('work','social','none') NOT NULL,
 `if_finished` tinyint(1) DEFAULT 0,
 PRIMARY KEY (`event_id`),
 KEY `username` (`username`),
 CONSTRAINT `events_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `users` (
 `username` varchar(10) NOT NULL,
 `hashed_password` varchar(255) NOT NULL,
 PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

