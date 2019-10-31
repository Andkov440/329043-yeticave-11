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
