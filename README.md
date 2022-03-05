# CinemaSchedule
Нужен пользователь cinema с паролем 'asdf'. Нужна бд CinemaDB c таблицами films и schedule:

films:
id int primary key auto_increment unique, name varchar(255) not null, photo varchar(255) not null, description varchar(255) not null, duration int not null, limits int not null

schedule: 
id int primary key auto_increment unique, film int not null, time int not null, price int not null
