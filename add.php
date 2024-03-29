<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}
$category_ids = array_column(category_list($con), 'id');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-date', 'lot-step'];

    $valid_mime = ['image/jpeg', 'image/png'];

    $rules = [
        'category' => function ($value) use ($category_ids) {
            return validateCategory($value, $category_ids);
        },
        'lot-name' => function ($value) {
            return validateLength($value, 3, 200);
        },
        'message' => function ($value) {
            return validateLength($value, 3, 3000);
        },
        'lot-rate' => function ($value) {
            return validateNumber($value);
        },
        'lot-date' => function ($value) {
            return validateDate($value);
        },
        'lot-step' => function ($value) {
            return validateNumber($value);
        }
    ];

    $new_lot = filter_input_array(INPUT_POST, [
        'lot-name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT,
        'category' => FILTER_DEFAULT,
        'lot-date' => FILTER_DEFAULT,
        'lot-rate' => FILTER_DEFAULT,
        'lot-step' => FILTER_DEFAULT
    ], true);

    foreach ($new_lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        }
        $new_lot[$key] = trim($new_lot[$key]);
    }

    $errors = array_filter($errors);
    if (!empty($_FILES['jpg_img']['name'])) {
        $tmp_name = $_FILES['jpg_img']['tmp_name'];
        $filename = $_FILES['jpg_img']['name'];
        $file_type = mime_content_type($tmp_name);
        if (!in_array($file_type, $valid_mime)) {
            $errors['jpg_img'] = 'Загрузите картинку в формате JPG, JPEG или PNG';
        }

    } else {
        $errors['jpg_img'] = 'Вы не загрузили файл';
    }

    if (!count($errors)) {
        move_uploaded_file($_FILES['jpg_img']['tmp_name'], 'uploads/' . $filename);
        $new_lot['path'] = $filename;
        $new_lot['username'] = $_SESSION['user']['id'];
        $sql = 'INSERT INTO lot (title, description, category_id, end_date, starting_price, step_rate, image, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $lot_id = db_insert_data($con, $sql, $new_lot);
        header("Location: lot.php?id=" . $lot_id);
    }
}
$menu = include_template('nav_menu.php', ['categories' => category_list($con)]);
$add_content = include_template('add_lot.php',
    ['nav_menu' => $menu, 'errors' => $errors, 'categories' => category_list($con)]);
$layout_content = include_template('layout.php', [
    'content' => $add_content,
    'title' => 'Добавление лота',
    'categories' => category_list($con),
    'user_name' => $_SESSION['user']['name']
]);

print ($layout_content);
