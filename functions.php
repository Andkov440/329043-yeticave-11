<?php
require_once('helpers.php');
require_once('init.php');

$category_ids = [];
$user_name = $_SESSION['user']['name'] ?? '';

$sql = 'SELECT id, title, symbol_code FROM category';

$categories = db_fetch_all_data($con, $sql);
$category_ids = array_column($categories, 'id');

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
    return htmlspecialchars($str);
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
    $seconds = $timestamp_diff % 60;
    if ($seconds < 10) {
        $seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
    }
    return [$hours, $minutes, $seconds];
}

function db_fetch_all_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_all($res, MYSQLI_ASSOC) : die('Ошибка соединения с БД');
}

function db_fetch_first_element($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_assoc($res) : die('Ошибка соединения с БД');
}

function db_insert_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    return ($result) ? mysqli_insert_id($link) : die('Ошибка соединения с БД');
}

function validateNumber($value)
{
    return (!empty($value) && $value <= 0) ? 'Значение должно быть больше ноля' : null;
}

function validateCategory($id, $allowed_list)
{
    return !in_array($id, $allowed_list) ? 'Указана несуществующая категория' : null;
}

function validateLength($value, $min, $max)
{
    return (strlen($value) < $min or strlen($value) > $max) ? 'Значение должно быть от ' . $min . ' до ' . $max . ' символов' : null;
}

function validateDate($value)
{
    $seconds_in_day = 86400;
    if ($value) {
        if (date('Y-m-d', strtotime($value)) !== $value) {
            return "Неправильный формат даты";
        }
        $timestamp_diff = strtotime($value) - time();
        if ($timestamp_diff < $seconds_in_day) {
            return "Указанная дата меньше текущей даты";
        }
    }

    return null;
}

function validateEmail($value)
{
    return !filter_var($value, FILTER_VALIDATE_EMAIL) ? 'Введите корректный email' : null;
}

function time_to_human_format($value)
{
    setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
    $seconds_in_hour = 3600;
    $timestamp_diff = time() - strtotime($value);
    $minutes = ltrim(strftime('%M ', $timestamp_diff), '0');
    if (($timestamp_diff > 60) && ($timestamp_diff < $seconds_in_hour)) {
        return $minutes . get_noun_plural_form(strftime('%M', $timestamp_diff), 'минута', 'минуты', 'минут') . ' назад';
    } else {
        if ($timestamp_diff < 60) {
            return 'только что';
        } else {
            if ($timestamp_diff === $seconds_in_hour) {
                return 'Час назад';
            }
        }
    }
    return strftime('%d.%m.%y в %H:%M', strtotime($value));
}
