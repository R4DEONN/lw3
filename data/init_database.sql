CREATE DATABASE php_course;
USE php_course;

CREATE TABLE user (
	user_id INT AUTO_INCREMENT,
    first_name VARCHAR(200) NOT NULL,
    last_name VARCHAR(200) NOT NULL,
    middle_name VARCHAR(200),
    gender VARCHAR(6) NOT NULL,
    birth_date DATE NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE,
    avatar_path VARCHAR(200),
    PRIMARY KEY (user_id)
);

SELECT * FROM user;