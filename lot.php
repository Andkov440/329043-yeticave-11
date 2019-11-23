<?php
require_once('init.php');
require_once('functions.php');

$lot_number = filter_input(INPUT_GET, 'id');

$sql = 'SELECT l.title, l.starting_price, l.image, l.description, l.end_date, c.title category_title
            FROM lot l
            INNER JOIN category c
            ON l.category_id = c.id
            WHERE l.id =' . $lot_number;

$lot_data = db_fetch_first_element($con, $sql);

if ($lot_data) {

    $lot_content = include_template('lot_page.php', ['lot_data' => $lot_data, 'categories' => $categories]);

    $layout_content = include_template('layout.php', [
        'content' => $lot_content,
        'title' => $lot_data['title'],
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print ($layout_content);
} else {
    http_response_code(404);
}
