CREATE DATABASE yeticave DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users(
    user_id INT(3) NOT NULL AUTO_INCREMENT,
    registration_date DATETIME,
    email VARCHAR(40) UNIQUE NOT NULL,
    password VARCHAR NOT NULL,
    name VARCHAR(30) NOT NULL,
    contacts VARCHAR(200) NOT NULL,
    lot_id INT(10),
    rate_id INT(10),
    PRIMARY KEY(user_id)
);

CREATE TABLE lot(
    lot_id INT NOT NULL AUTO_INCREMENT,
    creation_date DATETIME,
    title VARCHAR(15) NOT NULL,
    description VARCHAR(256) NOT NULL,
    image VARCHAR(50) NOT NULL,
    starting_price INT NOT NULL,
    end_date DATE NOT NULL,
    step_rate  INT NOT NULL,
    user_id INT(10),
    winer_id INT(10),
    category_id INT(1),
    PRIMARY KEY(lot_id)
);

CREATE TABLE category(
    category_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(40) UNIQUE NOT NULL,
    symbol_code VARCHAR(10) UNIQUE NOT NULL,
    PRIMARY KEY(category_id)
);

CREATE TABLE rate(
    rate_id INT NOT NULL AUTO_INCREMENT,
    creation_date DATETIME,
    price INT(10),
    lot_id INT(10),
    user_id INT(10),
    PRIMARY KEY(rate_id)
);

CREATE INDEX lot_description ON lot(description);
CREATE INDEX lot_title ON lot(title);
