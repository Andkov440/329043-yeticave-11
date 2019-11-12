<?php
require_once('helpers.php');
require_once('init.php');

$is_auth = rand(0, 1);

$user_name = 'Андрей';
$sql = 'SELECT title, symbol_code FROM category';

$categories = db_fetch_all_data($con, $sql);

$categories_count = count($categories);
function price_format($sum) {
    $result = '';
    $sum = ceil($sum);
    if($sum >= 1000) {
        $result = number_format($sum, 0, '', ' ');
    }
    $result.=' ₽';
    return $result;
}

function esc($str) {
    $text = htmlspecialchars($str);

    return $text;
}

function time_left($remain_time) {
    $timestamp_diff = strtotime($remain_time) - time();
    $hours = floor($timestamp_diff / 3600);
    if($hours < 10) {
        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    }
    $minutes = floor(($timestamp_diff % 3600) / 60);
    if($minutes < 10) {
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }
    return [$hours, $minutes];
}

function db_fetch_all_data($link, $sql, $data = []) {
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $result = ($res) ? mysqli_fetch_all($res, MYSQLI_ASSOC) : mysqli_error($link);

    return $result;
}

function db_fetch_first_element($link, $sql, $data = []) {
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_assoc($res) : mysqli_error($link);
}

function db_insert_data($link, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    return ($result) ? mysqli_insert_id($link) : mysqli_error($link);
}
