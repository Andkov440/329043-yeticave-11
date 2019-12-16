<?php
require_once('init.php');
require_once('functions.php');

if (isset($_SESSION['user'])) {
    $sql = 'SELECT l.id lotid, l.image lot_image, l.title lot_title, l.end_date lot_end_date, l.winer_id winer, l.creation_date, c.title category_title, r.creation_date creation_rate, r.price rate_price, u.contacts user_contacts from rate r
            INNER JOIN lot l ON l.id = r.lot_id
            INNER JOIN category c ON l.category_id = c.id
            INNER JOIN users u ON r.user_id = u.id
            WHERE r.user_id =' . $_SESSION['user']['id'];

    $data = db_fetch_all_data($con, $sql);
    if ($data) {
        $menu = include_template('nav_menu.php', ['categories' => $categories]);

        $rates_content = include_template('user_rates.php',
            [
                'data' => $data,
                'nav_menu' => $menu
            ]);

        $layout_content = include_template('layout.php', [
            'content' => $rates_content,
            'title' => 'Мои ставки',
            'categories' => $categories,
            'user_name' => $user_name
        ]);

        print ($layout_content);
    } else {
        http_response_code(404);
    }
}

