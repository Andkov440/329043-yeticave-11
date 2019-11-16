<?php
require_once('helpers.php');
require_once('init.php');

$is_auth = rand(0, 1);
$cats_ids = [];

$user_name = 'Андрей';
$sql = 'SELECT id, title, symbol_code FROM category';

$categories = db_fetch_all_data($con, $sql);
$cats_ids = array_column($categories, 'id');

$categories_count = count($categories);
function price_format($sum)
{
    $result = '';
    $sum = ceil($sum);
    if ($sum >= 1000) {
        $result = number_format($sum, 0, '', ' ');
    }
    $result .= ' ₽';
    return $result;
}

function esc($str)
{
    $text = htmlspecialchars($str);

    return $text;
}

function time_left($remain_time)
{
    $timestamp_diff = strtotime($remain_time) - time();
    $hours = floor($timestamp_diff / 3600);
    if ($hours < 10) {
        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    }
    $minutes = floor(($timestamp_diff % 3600) / 60);
    if ($minutes < 10) {
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }
    return [$hours, $minutes];
}

function db_fetch_all_data($link, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_all($res, MYSQLI_ASSOC) : mysqli_error($link);
}

function db_fetch_first_element($link, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_assoc($res) : mysqli_error($link);
}

function db_insert_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    return ($result) ? mysqli_insert_id($link) : mysqli_error($link);
}

function validateNumber($value) {
    if ($value) {
        if ($value <= 0) {
            return "Значение должно быть больше ноля";
        }
    }
    return null;
}

function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }

    return null;
}

function validateLength($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }

    return null;
}

function validateDate($value) {
    $seconds_in_day = 86400;
    if ($value) {
        $timestamp_diff = strtotime($value) - time();
        if ($value !== date_create_from_format('Y-m-d', $value)) {
            return "Неправильный формат даты";
        }
        elseif ($timestamp_diff < $seconds_in_day) {
            return "Указанная дата меньше текущей даты";
        }
    }

    return null;
}

function getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}
