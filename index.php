<?php
require_once('functions.php');
require_once('helpers.php');

$is_auth = rand(0, 1);

$user_name = 'Андрей'; // укажите здесь ваше имя

$con = mysqli_connect('localhost', 'root', '33', 'yeticave');
$sql = 'SELECT title, symbol_code FROM category';
mysqli_set_charset($con, 'utf8');

$categories = db_fetch_data($con, $sql);

$categories_count = count($categories);

$sql = 'SELECT l.title, l.starting_price, l.image, l.step_rate, l.end_date, l.image, c.title lot_title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.category_id
WHERE end_date > NOW()';

$goods = db_fetch_data($con, $sql);

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

?>
