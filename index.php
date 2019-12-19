<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');
require_once('getwinner.php');

$user_name = $_SESSION['user']['name'] ?? '';
$PAGE_ITEMS = 9;
$category_ids = array_column(category_list($con), 'id');
$ids = $_GET['id'] ?? implode(', ', $category_ids);
$CURRENT_PAGE = $_GET['page'] ?? 1;
$offset = ($CURRENT_PAGE - 1) * $PAGE_ITEMS;

$filename = basename(__FILE__);
if (isset($_GET['id'])) {
    $sql = 'SELECT COUNT(*) AS cnt FROM lot WHERE end_date > NOW() AND category_id = ?';
    $result = db_fetch_first_element($con, $sql, [$_GET['id']]);
} else {
    $result = db_fetch_first_element($con, 'SELECT COUNT(*) AS cnt FROM lot WHERE end_date > NOW()');
}
$items_count = $result['cnt'];

$ids = mysqli_real_escape_string($con, $ids);
$PAGE_ITEMS = mysqli_real_escape_string($con, $PAGE_ITEMS);
$offset = mysqli_real_escape_string($con, $offset);

$sql = 'SELECT l.id, l.title, l.starting_price, l.image, l.step_rate, l.end_date, c.title lot_title
FROM lot l
    INNER JOIN category c
    ON l.category_id = c.id
WHERE l.category_id in (' . $ids . ')
AND end_date > NOW()
LIMIT ' . $PAGE_ITEMS . '
OFFSET ' . $offset;
$goods = db_fetch_all_data($con, $sql);

$pages_count = ceil($items_count / $PAGE_ITEMS);
$pages = range(1, $pages_count);

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'pages_count' => $pages_count,
    'current_page' => $CURRENT_PAGE,
    'category_id' => $_GET['id'] ?? '',
    'filename' => $filename
]);

$page_content = include_template('main.php', [
    'categories' => category_list($con),
    'goods' => $goods,
    'category_id' => $_GET['id'] ?? '',
    'pagination' => $pagination
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница',
    'categories' => category_list($con),
    'user_name' => $user_name
]);

print($layout_content);
