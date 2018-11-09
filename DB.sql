DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `booking`;
DROP TABLE IF EXISTS `maps_location`;
DROP TABLE IF EXISTS `driver_times`;

CREATE TABLE `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `mobileno` INT(10) NULL,
  `email` VARCHAR(45) NULL,
  `group` VARCHAR(45) NULL,
  `status` INT(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
);

INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`,`status`) VALUES ('John', 'Doe', 'test1', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'customer@example.com','Customer',1); 
INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`,`status`) VALUES ('John', 'the Driver', 'test2', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'driver@example.com','Driver',1); 
INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `mobileno`, `email`,`group`,`status`) VALUES ('Admin', 'Istrator', 'admin', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'admin@example.com','Admin',1); 

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

CREATE TABLE `maps_location` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `pickup` text NOT NULL,
  `destination` text NOT NULL,
  `distance` int(10) NOT NULL,
  `duration` int(20) NOT NULL,
  PRIMARY KEY (`map_id`)
);

CREATE TABLE `driver_times` (
  `time_id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `start` TIMESTAMP NULL DEFAULT NULL,
  `end` TIMESTAMP NULL DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  PRIMARY KEY (`time_id`)
);

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trip_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `status` int(2) NOT NULL,
   PRIMARY KEY (`bill_id`),
   UNIQUE KEY `trip_id` (`trip_id`);
);
