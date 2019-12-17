CREATE DATABASE yeticave DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users(
    id INT(3) NOT NULL AUTO_INCREMENT,
    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(40) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL,
    name VARCHAR(30) NOT NULL,
    contacts VARCHAR(200) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE lot(
    id INT NOT NULL AUTO_INCREMENT,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(80) NOT NULL,
    description VARCHAR(256) NOT NULL,
    image VARCHAR(50) NOT NULL,
    starting_price INT NOT NULL,
    end_date DATE NOT NULL,
    step_rate INT NOT NULL,
    user_id INT(10) NOT NULL,
    winner_id INT(10),
    category_id INT(1) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE category(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(40) UNIQUE NOT NULL,
    symbol_code VARCHAR(10) UNIQUE NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE rate(
    id INT NOT NULL AUTO_INCREMENT,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    price INT(10) NOT NULL,
    lot_id INT(10) NOT NULL,
    user_id INT(10) NOT NULL,
    PRIMARY KEY(id)
);

CREATE INDEX lot_description ON lot(description);
CREATE INDEX lot_title ON lot(title);
CREATE FULLTEXT INDEX lot_ft_search ON lot(title, description);
