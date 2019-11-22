CREATE DATABASE yeticave DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users(
    id INT(3) NOT NULL AUTO_INCREMENT,
    registration_date DATETIME NOT NULL CURRENT_TIMESTAMP,
    email VARCHAR(40) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL,
    name VARCHAR(30) NOT NULL,
    contacts VARCHAR(200) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE lot(
    id INT NOT NULL AUTO_INCREMENT,
    creation_date DATETIME NOT NULL CURRENT_TIMESTAMP,
    title VARCHAR(80) NOT NULL,
    description VARCHAR(256) NOT NULL,
    image VARCHAR(50) NOT NULL,
    starting_price INT NOT NULL,
    end_date DATE NOT NULL,
    step_rate INT NOT NULL,
    user_id INT(10) NOT NULL,
    winer_id INT(10),
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
    creation_date DATETIME,
    price INT(10),
    lot_id INT(10),
    user_id INT(10),
    PRIMARY KEY(id)
);

CREATE INDEX lot_description ON lot(description);
CREATE INDEX lot_title ON lot(title);

SELECT l.title, l.starting_price, l.image, l.step_rate, c.title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.id
WHERE end_date > NOW()
ORDER BY end_date ASC;

SELECT l.creation_date, l.title, l.description, l.image, l.starting_price, l.end_date, l.step_rate, c.title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.id
WHERE lot_id = 3;

UPDATE lot
SET title = 'DC Ply Mens 2019/2020 Snowboard'
WHERE id = 2;

SELECT lot.title, rate.creation_date, rate.price
FROM rate
    INNER JOIN lot
    ON rate.lot_id = lot.id
WHERE lot.id = 3
ORDER BY rate.creation_date
ASC;
