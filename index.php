<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$sql = 'SELECT l.id, l.title, l.starting_price, l.image, l.step_rate, l.end_date, c.title lot_title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.id
WHERE end_date > NOW()';

$goods = db_fetch_all_data($con, $sql);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'goods' => $goods]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница',
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
