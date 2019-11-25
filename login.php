<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните это поле';
        }
    }

    $sql = "SELECT * FROM users WHERE email = '" . $form['email'] . "'";
    $res = mysqli_query($con, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    if (!count($errors)) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
        if (mysqli_num_rows($res) === 0) {
            $errors['email'] = 'Такой пользователь не найден';
        }
    }
}

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit();
}
$add_content = include_template('login_user.php', ['errors' => $errors, 'categories' => $categories]);

$layout_content = include_template('layout.php', [
    'content' => $add_content,
    'title' => 'Вход',
    'categories' => $categories,
]);


print ($layout_content);
