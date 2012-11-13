--drop database if exists lowphashion;
--create database lowphashion;
--use lowphashion;

--GRANT ALL ON lowphashion.* TO 'lowphashion'@'localhost' IDENTIFIED BY 'password'

drop table if exists message;
create table message (
    id int primary key not null auto_increment,
    app_name varchar(50),
    message varchar(250),
    message_type varchar(20),
    posted timestamp
);
