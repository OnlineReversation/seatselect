SHOW DATABASES;
USE db_seat_select;

DROP TABLE IF EXISTS db_users;
CREATE TABLE db_users (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    user_login VARCHAR(20) UNIQUE,
    user_password VARCHAR(8),
    user_name VARCHAR(20),
    user_email VARCHAR(50),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    role_name VARCHAR(50),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS user_roles;
CREATE TABLE user_roles (
    user_id INTEGER NOT NULL,
    role_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES db_users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS restaurant_tables;
CREATE TABLE restaurant_tables (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    capacity INTEGER,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS reservations;
CREATE TABLE reservations (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    table_id INTEGER,
    user_id INTEGER,
    reservation_date DATE,
    reservation_time TIME,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES db_users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES restaurant_tables(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    user_id INTEGER,
    table_id INTEGER,
    rating INTEGER,
    review_text TEXT(65535),
    review_date DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES db_users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES restaurant_tables(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS user_security_questions;
CREATE TABLE user_security_questions (
	id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	user_id INTEGER,
	question VARCHAR(255),
	answer VARCHAR(50),
	PRIMARY KEY(id),
	FOREIGN KEY (user_id) REFERENCES db_users(id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

