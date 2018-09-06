DROP TABLE `users`;

CREATE TABLE `users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `mobileno` INT(10) NULL,
  `email` VARCHAR(45) NULL,
  `group` VARCHAR(45) NULL,
  PRIMARY KEY (`idusers`));

INSERT INTO `users` (`idusers`, `firstname`, `lastname`, `username`, `password`, `mobileno`, `email`) VALUES (NULL, 'fname', 'lname', 'test', '098f6bcd4621d373cade4e832627b4f6', '00000000', 'test@example.com'); 
