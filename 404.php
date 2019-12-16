<?php
require_once('functions.php');

$not_found_content = include_template('error404.php');
$layout_content = include_template('layout.php', [
    'content' => $not_found_content,
    'title' => 'DC Ply Mens 2016/2017 Snowboard',
    'categories' => $categories
]);

print ($layout_content);
