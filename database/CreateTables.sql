USE db_seat_select;

DROP TABLE IF EXISTS db_users;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS user_roles;
DROP TABLE IF EXISTS restaurant_tables;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS user_security_questions;


CREATE TABLE db_users (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	user_login VARCHAR(20) NOT NULL UNIQUE,
	user_password VARCHAR(8) NOT NULL,
	user_email VARCHAR(50) NOT NULL,
	is_admin BOOLEAN NOT NULL, 
	PRIMARY KEY(id)
);


CREATE TABLE restaurant_tables (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	capacity INTEGER NOT NULL,
	PRIMARY KEY(id)
);


CREATE TABLE reservations (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	table_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL,
	reservation_date DATE NOT NULL,
	reservation_time TIME NOT NULL,
	PRIMARY KEY(id)
);


CREATE TABLE reviews (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	table_id INTEGER NOT NULL,
	rating INTEGER NOT NULL,
	review_text TEXT NOT NULL,
	review_date DATE NOT NULL,
	PRIMARY KEY(id)
);


CREATE TABLE user_security_questions (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	question VARCHAR(255) NOT NULL,
	answer VARCHAR(50) NOT NULL,
	PRIMARY KEY(id)
);


ALTER TABLE reservations
ADD CONSTRAINT fk_reservations_user_id FOREIGN KEY(user_id) REFERENCES db_users(id)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE reservations
ADD CONSTRAINT fk_reservations_table_id FOREIGN KEY(table_id) REFERENCES restaurant_tables(id)
ON UPDATE NO ACTION ON DELETE NO ACTION;


ALTER TABLE reviews
ADD CONSTRAINT fk_reviews_user_id FOREIGN KEY(user_id) REFERENCES db_users(id)
ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE reviews
ADD CONSTRAINT fk_reviews_table_id FOREIGN KEY(table_id) REFERENCES restaurant_tables(id)
ON UPDATE NO ACTION ON DELETE NO ACTION;


ALTER TABLE user_security_questions
ADD CONSTRAINT fk_user_security_questions_user_id FOREIGN KEY(user_id) REFERENCES db_users(id)
ON UPDATE NO ACTION ON DELETE NO ACTION;
