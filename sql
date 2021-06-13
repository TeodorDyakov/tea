CREATE DATABASE chat
CREATE TABLE `chat`.`messages` 
( `id` INT NOT NULL AUTO_INCREMENT , `text` VARCHAR(2000) NOT NULL , 
`author` VARCHAR(50) NOT NULL ,
 `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;

  CREATE TABLE `chat`.`last_active` ( `id_of_user` CHAR(20) NOT NULL , `last_active` DATETIME NOT NULL ) ENGINE = InnoDB;
