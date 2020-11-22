--if the database exists we want to delete it.
drop database if exists drempeltoets;

--create database drempeltoets
create database drempeltoets;
use drempeltoets;

--create table jongere
create table jongere(
	jongerecode varchar(5) not null AUTO_INCREMENT,
	roepnaam varchar(20) not null,
	tussenvoegsel varchar(7),
	achternaam varchar(25) not null,
	inschrijfdatum date not null,
	primary key(jongerecode)
);

--create table activiteit
create table activiteit(
	activiteitcode varchar(3) not null AUTO_INCREMENT,
	activiteitnaam varchar(40) not null,
	primary key(activiteitcode)
);

--create table instituut
create table instituut(
	instituutscode varchar(5) not null AUTO_INCREMENT,
	instituut varchar(40) not null,
	instituuttelefoon varchar(11) not null,
	primary key(instituutscode)
);

--create table jongereinstituut
create table jongereinstituut(
	jongerecode varchar(5) AUTO_INCREMENT,
	instituutscode varchar(5),
	startdatum date not null,
	foreign key(jongerecode) references jongere(jongerecode),
	foreign key(instituutscode) references instituut(instituutscode)
);

--create table jongereactiviteit
create table jongereactiviteit(
	jongerecode varchar(5) AUTO_INCREMENT,
	activiteitcode varchar(3),
	startdatum date not null,
	afgerond tinyint(1) not null,
	foreign key(jongerecode) references jongere(jongerecode),
	foreign key(activiteitcode) references activiteit(activiteitcode)
);
--create table account 
create table account(
	id int not null AUTO_INCREMENT,
	username varchar(255) not null UNIQUE,
	email varchar(255) not null UNIQUE,
	password varchar(255) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id) 
);

create table koppel(
	koppelcode varchar(5) not null AUTO_INCREMENT,
	activiteitcode varchar(3),
	jongerecode varchar(5),
	foreign key(activiteitcode) references activiteit(activiteitcode),
	foreign key(jongerecode) references jongere(jongerecode)

);