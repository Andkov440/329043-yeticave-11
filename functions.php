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
