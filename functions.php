<?php
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

function db_fetch_data($link, $sql, $data = []) {
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

function db_insert_data($link, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($link);
    }
    return $result;
}
