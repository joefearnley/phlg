/*
  This script creates the lowphashion database.

  Run the following from the mysql prompt to create a user 
  to access the database:

  GRANT ALL ON lowphashion.* TO 'lowphashion'@'localhost' IDENTIFIED BY 'password'
*/

drop database if exists lowphashion;
create database lowphashion;
use lowphashion;

drop table if exists message;
create table message (
  id int primary key not null auto_increment,
  app_name varchar(50),
  body varchar(250),
  type varchar(20),
  posted timestamp
);
