<?php
require_once('data.php');
require_once('functions.php');

$is_auth = rand(0, 1);

$user_name = 'Андрей'; // укажите здесь ваше имя

$categories_count = count($categories);

require_once('helpers.php');

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
