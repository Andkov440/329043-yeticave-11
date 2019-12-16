<?php
require_once('init.php');
require_once('functions.php');

$lot_number = filter_input(INPUT_GET, 'id');
$errors = [];
$new_rate = '';
$user_name = $_SESSION['user']['name'] ?? '';

$sql = 'SELECT l.title, l.starting_price, l.step_rate, l.image, l.description, l.end_date, c.title category_title
            FROM lot l
            INNER JOIN category c
            ON l.category_id = c.id
            WHERE l.id =' . $lot_number;
$lot_data = db_fetch_first_element($con, $sql);

$sql = 'SELECT MAX(price) FROM rate WHERE lot_id = ' . $lot_number;
$res = mysqli_query($con, $sql);
$max_rate = $res ? mysqli_fetch_array($res, MYSQLI_NUM) : null;

$min_rate = empty($max_rate[0]) ? ($lot_data['starting_price'] + $lot_data['step_rate']) : ($max_rate[0] + $lot_data['step_rate']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_rate = $_POST;

    if (empty($new_rate['cost'])) {
        $errors['cost'] = 'Сделайте ставку';
    } elseif (!filter_var($new_rate['cost'], FILTER_VALIDATE_INT)) {
        $errors['cost'] = 'Введите целое число';
    } elseif ($new_rate['cost'] < $min_rate) {
        $errors['cost'] = 'Значение должно быть больше';
    } else {
        $errors['cost'] = validateNumber($new_rate['cost']);
    }
    $errors = array_filter($errors);

    $new_rate['cost'] = trim($new_rate['cost']);
    $new_rate['lot_id'] = $lot_number;
    $new_rate['user_id'] = $_SESSION['user']['id'];

    if (!count($errors)) {
        $sql = 'INSERT INTO rate (price, lot_id, user_id)
                VALUES (?, ?, ?)';
        db_insert_data($con, $sql, $new_rate);
    }
}

$sql = 'SELECT MAX(price) FROM rate WHERE lot_id = ' . $lot_number;
$res = mysqli_query($con, $sql);
$max_rate = $res ? mysqli_fetch_array($res, MYSQLI_NUM) : null;
$min_rate = empty($max_rate[0]) ? ($lot_data['starting_price'] + $lot_data['step_rate']) : ($max_rate[0] + $lot_data['step_rate']);

$sql = 'SELECT r.creation_date, r.price, u.name
        FROM rate r
        INNER JOIN users u
        ON r.user_id = u.id
        WHERE r.lot_id = ' . $lot_number . ' ORDER BY r.creation_date DESC';
$rate_data = db_fetch_all_data($con, $sql);
$count_rates = count($rate_data);

if ($lot_data) {
    $menu = include_template('nav_menu.php', ['categories' => $categories]);

    $lot_content = include_template('lot_page.php',
        [
            'lot_data' => $lot_data,
            'nav_menu' => $menu,
            'min_rate' => $min_rate,
            'max_rate' => $max_rate[0],
            'rate_data' => $rate_data,
            'errors' => $errors,
            'count_rates' => $count_rates
        ]);

    $layout_content = include_template('layout.php', [
        'content' => $lot_content,
        'title' => $lot_data['title'],
        'categories' => $categories,
        'user_name' => $user_name
    ]);

    print ($layout_content);
} else {
    http_response_code(404);
}
