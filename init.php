<?php
session_start();

$con = mysqli_connect('localhost', 'root', '33', 'yeticave');
mysqli_set_charset($con, 'utf8');
if (!$con) {
    $error = mysqli_connect_error();
    printf('Ошибка соединения: %s/n', $error);
}
