CREATE DATABASE 10020569_db_cejasmy;

CREATE TABLE `10020569_db_cejasmy`.`products` (
id_product int NOT NULL AUTO_INCREMENT,
price float NOT NULL,
name VARCHAR(200) NOT NULL,
description TEXT,
PRIMARY KEY (id_product)
) ENGINE = InnoDB;

CREATE TABLE `10020569_db_cejasmy`.`orders` (
 `id_order` INT NOT NULL AUTO_INCREMENT ,
 `id_customer` INT NOT NULL , 
 `amount` DECIMAL(10,2) NOT NULL DEFAULT 0,
 `id_cart` INT NOT NULL,
 `ref` VARCHAR(255) NOT NULL, 
 `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
 PRIMARY KEY (`id_order`)
 ) ENGINE = InnoDB; 
 
 CREATE TABLE `10020569_db_cejasmy`.`order_details` (
 `id_order_details` INT NOT NULL AUTO_INCREMENT ,
 `id_order` INT NOT NULL , 
 `id_product` INT NOT NULL ,
 PRIMARY KEY (`id_order_details`)
 ) ENGINE = InnoDB;
 
 CREATE TABLE `10020569_db_cejasmy`.`customers` (
 `id_customer` INT NOT NULL AUTO_INCREMENT ,
 `firstname` VARCHAR(255) NOT NULL , 
 `lastname` VARCHAR(255) NOT NULL , 
 `email` VARCHAR(255) NOT NULL , 
 `password` VARCHAR(250) NOT NULL,
 `phone` INT(20),
 `dni` VARCHAR(9),
 `birthday`DATE,
 `newsletter` TINYINT NOT NULL DEFAULT 0,
 `ip_registration_newsletter` VARCHAR(15),
 `date_registration_newsletter` DATETIME,
 `active` TINYINT NOT NULL DEFAULT 1,
 `deleted` TINYINT NOT NULL DEFAULT 0,
 `date_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_customer`)
 ) ENGINE = InnoDB;
 
  CREATE TABLE `10020569_db_cejasmy`.`appointments` (
 `id_appointment` INT NOT NULL AUTO_INCREMENT ,
 `id_customer` INT NOT NULL,
 `id_employee` INT NOT NULL DEFAULT 1,
 `date_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `turn` INT,
 `status` INT NOT NULL,
 PRIMARY KEY (`id_appointment`)
 ) ENGINE = InnoDB;
 
CREATE TABLE `10020569_db_cejasmy`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT , 
  `nombreUsuario` VARCHAR(255) NOT NULL , 
  `contrasena` VARCHAR(255) NOT NULL , 
  `salt` VARCHAR(255) NOT NULL , 
  `reset_key` VARCHAR(255), 
  PRIMARY KEY (`id`)
  ) ENGINE = InnoDB; 

 CREATE TABLE `10020569_db_cejasmy`.`employees` (
 `id_employee` INT NOT NULL AUTO_INCREMENT ,
 `firstname` VARCHAR(255) NOT NULL , 
 `lastname` VARCHAR(255) NOT NULL , 
 `email` VARCHAR(255) NOT NULL , 
 `password` VARCHAR(250) NOT NULL,
 `birthday`DATE,
 `active` TINYINT DEFAULT 1,
 `deleted` TINYINT DEFAULT 0,
 `date_add` DATE,
 `date_upd` DATE,
 PRIMARY KEY (`id_employee`)
 ) ENGINE = InnoDB;
 
 CREATE TABLE `10020569_db_cejasmy`.`product_comment` (
  `id_product_comment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_product` int(10) UNSIGNED NOT NULL,
  `id_customer` int(10) UNSIGNED NOT NULL,
  `id_guest` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `content` text NOT NULL,
  `customer_name` varchar(64) DEFAULT NULL,
  `grade` float UNSIGNED NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
CREATE TABLE `10020569_db_cejasmy`.`carts` ( 
  `id_cart` INT NOT NULL AUTO_INCREMENT , 
  `id_customer` INT NOT NULL , 
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.0' , 
  PRIMARY KEY (`id_cart`)) ENGINE = InnoDB; 

  CREATE TABLE `10020569_db_cejasmy`.`cart_details` ( 
    `id_cart` INT NOT NULL , 
    `id_cart_details` INT NOT NULL AUTO_INCREMENT , 
    `id_product` INT NOT NULL , 
    `id_appointment` INT NOT NULL , 
    `price` DECIMAL(10,2) NOT NULL , 
    `amount` INT NOT NULL DEFAULT '1' , 
    PRIMARY KEY (`id_cart_details`)) ENGINE = InnoDB; 

    CREATE TABLE `10020569_db_cejasmy`.`products` ( 
      `id_product` INT NOT NULL AUTO_INCREMENT , 
      `price` DECIMAL(10,2) NOT NULL , 
      `name` VARCHAR(255) NOT NULL , 
      `description` TEXT NOT NULL , 
      PRIMARY KEY (`id_product`)) ENGINE = InnoDB; 