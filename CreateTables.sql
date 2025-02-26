SHOW DATABASES;
USE db_seat_select;

CREATE TABLE db_users (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    user_login VARCHAR(20) UNIQUE,
    user_password VARCHAR(8),
    user_name VARCHAR(20),
    user_email VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE roles (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    role_name VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE user_roles (
    user_id INTEGER NOT NULL,
    role_id INTEGER,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES db_users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE restaurant_tables (
    id INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    capacity INTEGER,
    PRIMARY KEY (id)
);

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
