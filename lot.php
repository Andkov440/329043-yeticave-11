<?php
require_once('functions.php');
require_once('helpers.php');

$con = mysqli_connect('localhost', 'root', '33', 'yeticave');
mysqli_set_charset($con, 'utf8');
if(!$con) {
    $error = mysqli_connect_error();
    printf('Ошибка соединения: %s/n', $error);
}
$sql = 'SELECT lot_id FROM lot';
$result = db_fetch_all_data($con, $sql);
$row_count = count($result);

$lot_number = filter_input(INPUT_GET, 'lot_id');

if ($lot_number > 0 && $lot_number <= $row_count) {
    $sql = 'SELECT l.title, l.starting_price, l.image, l.description, l.end_date, c.title category_title
            FROM lot l
            INNER JOIN category c
            ON l.category_id = c.category_id
            WHERE l.lot_id ='.$lot_number.'';

    $lot_data = db_fetch_first_element($con, $sql);
    $lot = include_template('lot_template.php', ['lot_data' => $lot_data]);

    print ($lot);
} else {
    http_response_code(404);
}
