<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['lot_name', 'category', 'lot_name', 'lot-rate', 'lot-date', 'lot-step'];
    $errors = [];

    $rules = [
        'category' => function ($value) use ($cats_ids) {
            return validateCategory($value, $cats_ids);
        },
        'lot_name' => function ($value) {
            return validateLength($value, 5, 200);
        },
        'message' => function ($value) {
            return validateLength($value, 10, 3000);
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
        'lot_name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT,
        'category' => FILTER_DEFAULT,
        'lot-date' => FILTER_DEFAULT,
        'lot-rate' => FILTER_DEFAULT,
        'lot-step' => FILTER_DEFAULT
    ], true);
print_r($new_lot);
    foreach ($new_lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (!empty($_FILES['jpg_img']['name'])) {
        $tmp_name = $_FILES['jpg_img']['tmp_name'];
        $filename = $_FILES['jpg_img']['name'];
        $file_type = mime_content_type($tmp_name);

        if ($file_type !== "image/jpeg" || $file_type !== "image/png" || $file_type !== "image/jpg") {
            $errors['image'] = 'Загрузите картинку в формате JPG, JPEG или PNG';
        } else {
            move_uploaded_file($_FILES['jpg_img']['tmp_name'], 'uploads/' . $filename);
            $new_lot['path'] = $filename;
        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }
print_r($errors);

    if (count($errors)) {
        $add_content = include_template('add_template.php',
            ['new_lot' => $new_lot, 'errors' => $errors, 'categories' => $categories]);
    } else {
        $sql = "SELECT id FROM category WHERE title = '" . $new_lot['category'] . "'";
        $cat_id = db_fetch_first_element($con, $sql);

        //$new_lot['category'] = $cat_id['id'];
        $new_lot['username'] = 1;
        $new_lot['winer'] = 100;

        $sql = 'INSERT INTO lot (title, category_id, description, starting_price, step_rate, end_date, image, creation_date, user_id, winer_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)';
        $result = db_insert_data($con, $sql, $new_lot);
        if ($result) {
            $lot_id = mysqli_insert_id($result);

            header("Location: lot.php?id=" . $lot_id);
        }

    }
}
$add_content = include_template('add_template.php', ['categories' => $categories]);

$layout_content = include_template('layout.php', [
    'content' => $add_content,
    'title' => 'Добавление лота',
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);
print ($layout_content);
