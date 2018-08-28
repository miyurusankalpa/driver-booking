#DROP TABLE `users`;

CREATE TABLE `users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`idusers`));

INSERT INTO users (`idusers`,`username`, `password`,`email`) VALUES (null,"test","test","test@test.com");
INSERT INTO users (`idusers`,`username`, `password`,`email`) VALUES (null,"admin","admin","admin@test.com");