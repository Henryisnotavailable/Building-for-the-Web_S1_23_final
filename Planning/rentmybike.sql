-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 01, 2021 at 03:06 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentmycar`
--
CREATE DATABASE IF NOT EXISTS `rentmybike` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rentmybike`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `pronouns` varchar(20) NOT NULL,
  `dateofbirth` DATE NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `favourite_bike` varchar(50) DEFAULT NULL,
  `telephone` varchar(15) NOT NULL,
  `profile_blob` longblob,
  `profile_url` varchar(200) DEFAULT NULL,
  `visibility` BOOL NOT NULL,
  `registration_date` DATE NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bike_details`
--

DROP TABLE IF EXISTS `bike_details`;
CREATE TABLE IF NOT EXISTS `bike_details` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `advert_title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `bike_model` varchar(50) NOT NULL,
  `bike_lower_price` int(4) NOT NULL,
  `bike_upper_price` int(4) NOT NULL,
  `bike_quality` int(1) NOT NULL,
  `bike_mileage` int(5) NOT NULL,
  `manufacture_year` varchar(5) NOT NULL,
  `num_seats` int(2) NOT NULL,
  `other_media_url` varchar(100) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `colour` varchar(7) NOT NULL,
  `is_electric` BOOL NOT NULL,
  PRIMARY KEY (`vehicle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*Password for root is fzfN%E,eS5@"mD!*/
INSERT INTO 
users (username,password,
email,first_name,last_name,
pronouns,dateofbirth,description,
favourite_bike,telephone,profile_blob,
profile_url,visibility,registration_date)
VALUES ("root","$2y$10$A/.4WGR7Ar4GwU1OjySHnO4Q6QxzJw/9TOgGdUXgh6pCHeWLvnBn6",
"ad@min.com","admin","root",
"they/them",DATE("2004-12-02"),"No",
"None","09888764789",NULL,"./assets/users/profile_pictures/default_avatar.png",1,DATE("2023-12-02"));

INSERT INTO bike_details (
user_id,advert_title,description,
bike_model,bike_lower_price,bike_upper_price,
bike_quality,bike_mileage,manufacture_year,num_seats,
other_media_url,image_url,
colour,is_electric
) 
VALUES (1,"Road Bike for rent!","This is an old road bike",
"Road Bike",500,1000,
1,1100,2001,1,
NULL,"./assets/users/bikes/bike_3.jpg",
"#ff0000",1
)

INSERT INTO bike_details (
user_id,advert_title,description,
bike_model,bike_lower_price,bike_upper_price,
bike_quality,bike_mileage,manufacture_year,num_seats,
other_media_url,image_url,
colour,is_electric
) 
VALUES (1,"Tandem bike for rent!","This is a great new tandem bike",
"Tandem bike",1000,2200,
4,200,2020,2,
NULL,"./assets/users/bikes/bike_4_and_5.jpg",
"#ff8040",1
)

INSERT INTO bike_details (
user_id,advert_title,description,
bike_model,bike_lower_price,bike_upper_price,
bike_quality,bike_mileage,manufacture_year,num_seats,
other_media_url,image_url,
colour,is_electric
) 
VALUES (1,"Brand NEW bike for rent!","This is a brand new bike!",
"BMX bike",100,200,
5,100,2023,1,
NULL,"./assets/users/bikes/bike_2.jpg",
"#0000ff",1
)