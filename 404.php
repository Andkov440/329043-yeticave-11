<?php
require_once('functions.php');

$not_found_content = include_template('error404.php');
$layout_content = include_template('layout.php', ['content' => $not_found_content, 'categories' => $categories]);

print ($layout_content);
