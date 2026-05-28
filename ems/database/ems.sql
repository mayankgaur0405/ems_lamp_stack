create database if not exists `ems_db`;
use ems_db;

create table departments(
id INT auto_increment primary key,
name VARCHAR(100) not null unique,
created_at TIMESTAMP default current_timestamp
);

create table employees(
id INT auto_increment primary key,
name varchar(100) not null,
email varchar(100) not null unique,
phone varchar(15) not null,
password varchar(255) not null,
department_id INT,
role ENUM('admin' , 'employee') not null default 'employee',
joining_date date not null,
profile_pic varchar(255) null,
designation varchar(100) not null,
created_at TIMESTAMP default current_timestamp,
foreign key (department_id) references departments(id)
on delete set null
);

insert into employees (name,email,phone,password,department_id,role,joining_date,designation) values ('superadmin', 'superadmin@pefront.com', '1234567890', 'admin123',null, 'admin', '2023-01-01', 'Super Admin');
