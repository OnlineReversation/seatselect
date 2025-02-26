CREATE TABLE  db_users  (
	 id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 user_login  VARCHAR(20) UNIQUE,
	 user_password  VARCHAR(8),
	 user_name  VARCHAR(20),
	 user_email  VARCHAR(50),
	PRIMARY KEY( id )
);


CREATE TABLE  roles  (
	 id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 role_name  VARCHAR(50),
	PRIMARY KEY( id )
);


CREATE TABLE  user_roles  (
	 user_id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 role_id  INTEGER,
	PRIMARY KEY( user_id ,  role_id )
);


CREATE TABLE  restaurant_tables  (
	 id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 capacity   INTEGER,
	PRIMARY KEY( id )
);


CREATE TABLE  reservations  (
	 id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 table_id   INTEGER,
	 user_id  INTEGER,
	 reservation_date  DATE,
	 reservation_time   TIME,
	PRIMARY KEY( id )
);


CREATE TABLE  reviews   (
	 id  INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	 user_id  INTEGER,
	 table_id   INTEGER,
	 rating   INTEGER,
	 review_text  TEXT(65535),
	 review_date   DATE,
	PRIMARY KEY( id )
);


ALTER TABLE  user_roles 
ADD FOREIGN KEY( user_id ) REFERENCES  db_users ( id )
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE  user_roles 
ADD FOREIGN KEY( role_id ) REFERENCES  roles ( id )
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE  reservations 
ADD FOREIGN KEY( user_id ) REFERENCES  db_users ( id )
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE  restaurant_tables 
ADD FOREIGN KEY( id ) REFERENCES  reservations ( table_id  )
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE  restaurant_tables 
ADD FOREIGN KEY( id ) REFERENCES  reviews  ( table_id  )
ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE  reviews  
ADD FOREIGN KEY( user_id ) REFERENCES  db_users ( id )
ON UPDATE NO ACTION ON DELETE NO ACTION;