CREATE TABLE `currency` (
  `code` char(3) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `email` (
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `subscription` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `currency` char(3) NOT NULL,
  `comparison` varchar(8) DEFAULT NULL,
  `value` decimal(12,8) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `currency` (`currency`),
  FOREIGN KEY (`currency`) REFERENCES `currency` (`code`) ON DELETE CASCADE,
  FOREIGN KEY (`email`) REFERENCES `email` (`email`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `currency_exchange` (
  `code` char(3) NOT NULL,
  `date_posted` date NOT NULL,
  `rate` decimal(12,8) NOT NULL,
  PRIMARY KEY (`code`,`date_posted`),
  FOREIGN KEY (`code`) REFERENCES `currency` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
