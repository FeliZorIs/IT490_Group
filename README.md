# IT490_Group
#DB Documentation
==========================
Packages Needed:
mysql-server
Mysqlworkbench (optional)

Common Queries:
show databases;
show tables;
select * from <table>;
insert into  <table> values();
update <table> set <variable=variable>;truncate <table>; (removes data)
drop  <table>; (removes table)
select user from mysql.user; (For and when needing to add another actual user)


Instructions:
1. Install all the necessary packages from above
2. Add 'DB' user to DB user table
3. Grant all privileges to that new DB user
4. Use the queries down below to help create the necessary tables 
5. Use the common queries if get lost
6. Exit mySQL




CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
Set reset root password:
UPDATE mysql.user SET authentication_string = PASSWORD('password') WHERE User = 'root';
then flush privileges;
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';


List of Queries (… = continues):
1. CREATE SCHEMA 'name'; (ie. 'KitchenWars')
2. CREATE TABLE `KitchenWars`.`Account` ( `Username` VARCHAR(45) NOT NULL, `Password` VARCHAR(100) NOT NULL, `GameID` INT(11) NULL, `Progress` VARCHAR(45) NULL, …
3. CREATE TABLE `KitchenWars`.`KitchenCardWars_Cards` ( `Card_Name` varchar(45) NOT NULL, `Atk_Dmg` int(11) DEFAULT NULL, …
4. CREATE TABLE `KitchenWars`.`KitchenCardWars_Enemies` ( `Enemy_Name` varchar(45) NOT NULL, `HP` int(11) DEFAULT NULL, …

