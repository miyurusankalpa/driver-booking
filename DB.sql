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

INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`) VALUES ('John', 'Doe', 'test1', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'customer@example.com','Customer'); 
INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`) VALUES ('John', 'the Driver', 'test2', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'driver@example.com','Driver'); 
INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`) VALUES ('Admin', 'Istrator', 'admin', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'admin@example.com','Admin'); 

CREATE TABLE `booking` (
  `booking_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `booking_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` DATE NULL,
  `time` TIME NULL,
  `pickup` VARCHAR(60) NULL,
  `destination` VARCHAR(60) NULL,
  `driver_id` INT NULL DEFAULT '0',
  `status` INT NULL DEFAULT '0',
  PRIMARY KEY (`booking_id`)
);