<?php
require_once('helpers.php');
require_once('init.php');

/**
 * Запрос к таблице категорий
 * @param mysqli $link Ресурс соединения
 * @return array Возвращает данные из таблицы категорий
 */

/**
 * Запрос к таблице категорий
 * @param mysqli $link Ресурс соединения
 * @return array Возвращает данные из таблицы категорий
 */
function category_list($link)
{
    $sql = 'SELECT id, title, symbol_code FROM category';
    return db_fetch_all_data($link, $sql);
}

/**
 * Форматирует отображение цены
 * @param int $sum Значение цены
 * @return string Отформатированная цена
 */
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

/**
 * Возвращает строку с пререобразованными специальными символами
 * @param string $str Строка
 * @return string Пререобразованная строка
 */
function esc($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Вычисляет оставшееся время до окончания лота в часах,минутах,секундах
 * @param string $remain_time Дата
 * @return array Массив из 3-х элементов, содержащий часы,минуты,секунды
 */
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

/**
 * Выполняет запрос к БД с помощью подготовленных выражений и возвращает результат запроса
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return array Возвращает все данные запроса из БД
 */
function db_fetch_all_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_all($res, MYSQLI_ASSOC) : die('Ошибка соединения с БД');
}

/**
 * Выполняет запрос к БД с помощью подготовленных выражений и возвращает результат запроса
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return array Возвращает данные запроса из БД в виде ассоциативного массива
 */
function db_fetch_first_element($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return ($res) ? mysqli_fetch_assoc($res) : die('Ошибка соединения с БД');
}

/**
 * Выполняет запрос к БД с помощью подготовленных выражений и возвращает id запроса
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return int Возвращает id запроса
 */
function db_insert_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    return ($result) ? mysqli_insert_id($link) : die('Ошибка соединения с БД');
}

/**
 * Проверяет, что значение больше ноля
 * @param int $value Число
 * @return string Возвращает текст ошибки
 */
function validateNumber($value)
{
    return (!empty($value) && $value <= 0) ? 'Значение должно быть больше ноля' : null;
}

/**
 * Проверяет правильность выбранной категории
 * @param int $id id категории
 * @param array $allowed_list Массив категорий
 * @return string Возвращает текст ошибки
 */
function validateCategory($id, $allowed_list)
{
    return !in_array($id, $allowed_list) ? 'Указана несуществующая категория' : null;
}

/**
 * Проверяет длину строки в пределах диапазона
 * @param string $value Строка
 * @param int $min Минимальное число символов
 * @param int $max Максимальное число символов
 * @return string Возвращает текст ошибки
 */
function validateLength($value, $min, $max)
{
    return (strlen($value) < $min or strlen($value) > $max) ? 'Значение должно быть от ' . $min . ' до ' . $max . ' символов' : null;
}

/**
 * Проверяет дату на соответствие формату и чтобы введенная дата не была меньше текущей даты
 * @param string $value Строка
 * @return string Возвращает текст ошибки
 */
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

/**
 * Проверяет адрес электронной почты на соответствие формату
 * @param string $value Email
 * @return string Возвращает текст ошибки
 */
function validateEmail($value)
{
    return !filter_var($value, FILTER_VALIDATE_EMAIL) ? 'Введите корректный email' : null;
}

/**
 * Преобразует дату в "человеческий" формат
 * @param string $value Дата
 * @return string Возвращает дату в "человеческом" формате
 */
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
