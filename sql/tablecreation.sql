-- Visit localhost/phpmyadmin and create the following tables

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `card_no` varchar(255) NOT NULL,
    `cvv` varchar(50) NOT NULL,
    `card_type` varchar(50) NOT NULL,
    `expiry_date` DATE NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_no`),
  FOREIGN KEY (username)
  REFERENCES users(username),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `name` varchar(50) NOT NULL,
  `sender_card` varchar(255) NOT NULL,
  `beneficiary_card` varchar(255) NOT NULL,
    `beneficiary_name` varchar(255) NOT NULL,
  `transfer_amt` int(25) NOT NULL,
  `time_of_transaction` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
    FOREIGN KEY (username, name)
  REFERENCES users(username, name),
  FOREIGN KEY (sender_card)
  REFERENCES cards(card_no)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;