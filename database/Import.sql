DROP DATABASE IF EXISTS `climb_logger`;

CREATE DATABASE `climb_logger`;

USE `climb_logger`;

CREATE TABLE `users` (
    id int AUTO_INCREMENT PRIMARY KEY,
    email varchar(100),
    username varchar(100),
    password varchar(100)
);


CREATE TABLE `password_reset_request` (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email varchar(255) NOT NULL,
    token varchar(255) NOT NULL
);

CREATE TABLE `climbing_routes` (
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid int NOT NULL,
    grade ENUM("2+", "3a", "3b", "3c", "4a", "4b", "4c", "5a", "5a+", "5b", "5b+", "5c", "5c+", "6a", "6a+", "6b", "6b+", "6c", "6c+", "7a", "7a+", "7b", "7b+", "7c", "7c+", "8a", "8a+", "8b", "8b+", "8c", "8c+") NOT NULL,
    climbinghall ENUM("Zuidhaven", "National Climbing Centre") NOT NULL,
    climbingwall VARCHAR(255) NOT NULL,
    color VARCHAR(20) NOT NULL,
    flashattempt ENUM("yes", "no") NOT NULL
);