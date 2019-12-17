<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$search = $_GET['search'] ?? '';
$user_name = $_SESSION['user']['name'] ?? '';
$filename = basename(__FILE__);
$PAGE_ITEMS = 9;
$CURRENT_PAGE = $_GET['page'] ?? 1;
$offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

if (!empty($search)) {
    $search = trim($search);

    $count_sql = mysqli_query($con,
        'SELECT COUNT(*) as cnt
                FROM lot
                WHERE MATCH(title, description) AGAINST("' . $search . '")
                AND end_date > NOW()');

    $items_count = mysqli_fetch_assoc($count_sql)['cnt'];

    $sql = 'SELECT id, title, starting_price, image, step_rate, end_date
            FROM lot
            WHERE MATCH(title, description) AGAINST(?)
            AND end_date > NOW()
            ORDER BY creation_date ASC
            LIMIT ' . $PAGE_ITEMS . '
            OFFSET ' . $offset;
    $result = db_fetch_all_data($con, $sql, [$search]);
} else {
    $result = '';
}
$pages_count = ceil($items_count / $PAGE_ITEMS);
$pages = range(1, $pages_count);

$menu = include_template('nav_menu.php', ['categories' => category_list($con)]);

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'pages_count' => $pages_count,
    'current_page' => $CURRENT_PAGE,
    'filename' => $filename,
    'search' => $search
]);

$add_content = include_template('search_lot.php', [
    'nav_menu' => $menu,
    'search' => $search,
    'result' => $result,
    'pagination' => $pagination
]);

$layout_content = include_template('layout.php', [
    'content' => $add_content,
    'title' => 'Результаты поиска',
    'categories' => category_list($con),
    'user_name' => $user_name
]);

print ($layout_content);
