-- =================================================================
-- Create a database called personal_website
-- DROP DATABASE IF EXISTS csc337_final_project;

-- CREATE DATABASE csc337_final_project;
-- USE csc337_final_project;

-- Drop Table messages
DROP DATABASE IF EXISTS messages;

-- Drop Table users
DROP TABLE IF EXISTS users;

-- Drop Table customers
DROP TABLE IF EXISTS customers;

-- Drop Table orders
DROP TABLE IF EXISTS orders;

-- Drop Table order_details
DROP TABLE IF EXISTS order_details;
-- =================================================================

CREATE TABLE users ( 
	user_ID int(11) NOT NULL AUTO_INCREMENT,
	username varchar(64) NOT NULL DEFAULT '',
	password varchar(255) NOT NULL DEFAULT '', 
	PRIMARY KEY (user_ID),  
	UNIQUE KEY username (username) );


CREATE TABLE customers ( 
	customer_ID int(11) NOT NULL AUTO_INCREMENT,
	first_name varchar(20) NOT NULL DEFAULT '',
	last_name varchar(20) NOT NULL DEFAULT '', 
	user_email varchar(30) NOT NULL DEFAULT '',
	user_ID int(11) NOT NULL,
	create_date datetime,
	PRIMARY KEY (customer_ID),
	FOREIGN KEY(user_ID) references users(user_ID),
	UNIQUE KEY user_email (user_email) );



CREATE TABLE messages (
	message_ID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY , 
	message varchar(500) NULL, 
	guest_name varchar(20) NULL, 
	guest_phone varchar(15) NULL, 
	guest_email varchar(30) NULL , 
	message_date datetime ) ;



CREATE TABLE orders ( 
	order_ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	customer_ID int(11) NOT NULL, 
	order_date datetime,  
	FOREIGN KEY(customer_ID) references customers(customer_ID) );



CREATE TABLE order_details (
	order_detail_ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	movie_ID int(11) NOT NULL, 
	order_ID int(11) NOT NULL,
	FOREIGN KEY(order_ID) references orders(order_ID)
	) ;




-- Insert data 
INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is good day', 'Mouse', 'mouse@gmail.com', '555-000-0001', NOW() );

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is bad day', 'Bat Man','batman@gmail.com', '555-000-0002', NOW());

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is perfect day', 'Wonder Woman','@gmail.com', '555-000-0003', NOW());

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is wonderful day', 'Donald Duck','@gmail.com', '555-000-0004', NOW() );

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is nice day', 'Bugs Bunny','bugs@gmail.com', '555-000-0005', NOW() );

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is happy day', 'Harry Potter','harry@gmail.com', '555-000-0006', NOW() );

INSERT INTO messages (message, guest_name, guest_email, guest_phone, message_date) VALUES 
('Today is cool day', 'Johnny Hsu', 'johnny@gmail.com', '555-000-0007',NOW() );



