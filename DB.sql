DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `booking`;

CREATE TABLE `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `mobileno` INT(10) NULL,
  `email` VARCHAR(45) NULL,
  `group` VARCHAR(45) NULL,
  PRIMARY KEY (`user_id`)
);

INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`) VALUES ('fname', 'lname', 'test', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'test@example.com','customer'); 

CREATE TABLE `booking` (
  `booking_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date` DATE NULL,
  `time` TIME NULL,
  `pickup` VARCHAR(60) NULL,
  `destination` VARCHAR(60) NULL,
  `status` INT NULL DEFAULT '0',
  PRIMARY KEY (`booking_id`)
);