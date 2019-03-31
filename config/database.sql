CREATE DATABASE api_test;

CREATE TABLE `api_test`.`storage` (
  `key` varchar(16) NOT NULL,
  `value` varchar(512) NOT NULL,
  PRIMARY KEY (`key`)
);