
create table user(id int auto_increment primary key, name varchar(60) not null, email varchar(255) not null, password varchar(255) not null);

insert into user (name, email, password) value('mateo', 'mateo@test.com', '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e');

insert into user (name, email, password) value('ruben', 'ruben@test.com', '6cf615d5bcaac778352a8f1f3360d23f02f34ec182e259897fd6ce485d7870d4');
