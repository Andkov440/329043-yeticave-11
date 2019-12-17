<?php
require_once('vendor/autoload.php');
require_once('init.php');
require_once('functions.php');

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');

$mailer = new Swift_Mailer($transport);

$message = new Swift_Message();
$message->setSubject('Ваша ставка победила');
$message->setFrom(['keks@phpdemo.ru']);

$sql = 'SELECT l.id, l.title, r.user_id winner_id, u.name winner_name, u.email winner_email FROM lot l
            INNER JOIN (SELECT lot_id, MAX(price) max_rate FROM rate GROUP BY lot_id) rates
                ON l.id = rates.lot_id
            INNER JOIN rate r
                ON l.id = r.lot_id AND r.price = rates.max_rate
            INNER JOIN users u
                ON u.id = r.user_id
            WHERE l.end_date <= NOW()
                AND l.winner_id IS NULL
                AND rates.max_rate IS NOT NULL';

$winners_result = db_fetch_all_data($con, $sql);

foreach ($winners_result as $item) {
    $update_lot = 'UPDATE lot SET winner_id = ' . $item['winner_id'] . ' WHERE id = ' . $item['id'];
    mysqli_query($con, $update_lot);

    $message->addTo($item['winner_email'], $item['winner_name']);

    $mail_data = include_template('email.php', [
        'winner_name' => $item['winner_name'],
        'lot_url' => 'lot.php?id=' . $item['id'],
        'rates_url' => 'rates.php',
        'lot_title' => $item['title']
    ]);

    $message->setBody($mail_data, 'text/html');
    $mailer->send($message);
}
