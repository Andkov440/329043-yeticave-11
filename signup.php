<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['email', 'password', 'name', 'message'];

    $rules = [
        'email' => function ($value) {
            return validateEmail($value);
        },
        'password' => function ($value) {
            return validateLength($value, 5, 10);
        },
        'name' => function ($value) {
            return validateLength($value, 3, 15);
        },
        'message' => function ($value) {
            return validateLength($value, 10, 300);
        }
    ];

    $new_user = filter_input_array(INPUT_POST, [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
        'name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT
    ], true);

    foreach ($new_user as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        }
        $new_user[$key] = trim($new_user[$key]);
    }

    $sql = "SELECT id FROM users WHERE email = '" . $new_user['email'] . "'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }
    $errors = array_filter($errors);

    if (!count($errors)) {
        $new_user['password'] = password_hash($new_user['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (email, password, name, contacts)
                VALUES (?, ?, ?, ?)';
        db_insert_data($con, $sql, $new_user);
        header("Location: login.php");
    }
}
$menu = include_template('nav_menu.php', ['categories' => category_list($con)]);
$add_content = include_template('signup_user.php', ['errors' => $errors, 'nav_menu' => $menu]);

$layout_content = include_template('layout.php', [
    'content' => $add_content,
    'title' => 'Регистрация',
    'categories' => category_list($con),
]);

print ($layout_content);
