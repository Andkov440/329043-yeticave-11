INSERT INTO category (title, symbol_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO users (registration_date, email, password, name, contacts)
VALUES ('2019-09-13 15:02:12', 'svs7@yandex.ru', '33', 'Владимир', 'Ростов-на-Дону, +79043458956'),
       ('2019-09-26 15:11:25', 'arina_m@list.ru', 'qwerty', 'Арина', 'Москва, +74952003456'),
       ('2019-09-10 08:50:44', 'artushkov@prognoz.ru', '123456', 'Виктор', 'Воронеж, +79612317845');

INSERT INTO lot (creation_date, title, description, image, starting_price, end_date, step_rate, user_id, winer_id, category_id)
VALUES ('2019-10-14 17:03:12', '2014 Rossignol District Snowboard', 'Сноуборд DISTRICT от известного французского производителя ROSSIGNOL, разработанный специально для начинающих фрирайдеров.', 'img/lot-1.jpg', 10999, '2019-11-02', 1000, 3, 2, 1),
       ('2019-10-15 10:11:13', 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке.', 'img/lot-2.jpg', 159999, '2019-11-03', 1500, 1, 2, 1),
       ('2019-10-16 11:12:10', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Невероятно легкие универсальные крепления весом всего 720 грамм готовы порадовать прогрессирующих райдеров.', 'img/lot-3.jpg', 8000, '2019-11-04', 1200, 3, 1, 2),
       ('2019-10-17 11:12:10', 'Ботинки для сноуборда DC Mutiny Charocal', 'Лаконичный дизайн и простота традиционной шнуровки делают модель Mutiny прочным и универсальным фристайл-ботинком.', 'img/lot-4.jpg', 10999, '2019-11-05', 2000, 2, 3, 3),
       ('2019-10-18 11:12:10', 'Куртка для сноуборда DC Mutiny Charocal', 'Мужская куртка Charocal сделана из мембранной ткани с высокими показателями паро- и водонепроницаемости 10К на 10К. Свободный крой Regular Fit из качественного материала с утеплителем.', 'img/lot-5.jpg', 7500, '2019-11-06', 500, 2, 3, 4),
       ('2019-10-18 11:12:10', 'Маска Oakley Canopy', 'Увеличенный объем линзы и низкий профиль оправы маски Canopy способствуют широкому углу обзора, а специальное противотуманное покрытие поможет ориентироваться в условиях плохой видимости.', 'img/lot-6.jpg', 5400, '2019-11-07', 200, 1, 2, 6);

INSERT INTO rate (creation_date, price, lot_id, user_id)
VALUES ('2019-10-19 10:11:13', 9200, 3, 1),
       ('2019-10-19 10:11:13', 5600, 6, 2);

SELECT * FROM category;

SELECT l.title, l.starting_price, l.image, l.step_rate, l.end_date, c.title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.category_id
WHERE end_date > NOW();

SELECT l.title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.category_id
WHERE lot_id = 3;

UPDATE lot
SET title = 'DC Ply Mens 2019/2020 Snowboard'
WHERE lot_id = 2;

SELECT lot.title, rate.creation_date, rate.price
FROM rate
    INNER JOIN lot
    ON rate.lot_id = lot.lot_id
WHERE lot.lot_id = 3
ORDER BY rate.creation_date;
