<?php
require_once "config.php";

/**
 * Создание подключения к базе данных
 * @param string $dbHost хост для подключения к базе данных
 * @param string $dbLogin имя пользователя для подключения к базе данных
 * @param string $dbPassword пароль для подключения к базе данных
 * @param string $dbName название базы данных
 * @return object подключение к базе данных
 */
function connectDB($dbHost, $dbLogin, $dbPassword, $dbName)
{
    $db = new mysqli($dbHost, $dbLogin, $dbPassword, $dbName);
    $db->query("SET NAMES 'utf8'");
    return $db;
}

/**
 * Возвращает массив результатов выборки
 * @param object $res результат запроса к базе данных
 * @return array массив результатов выборки
 */
function toArray($res)
{
    $arr = array();
    while ($row = $res->fetch_assoc())
        $arr[] = $row;
    return $arr;
}

/**
 * Получение списка статей на главной
 * @param object $db подключение к базе данных
 * @param int $start с какой статьи начинать вывод
 * @param int $limit сколько статей выводить на странице
 * @return array массив статей для отображения на странице
 */
function getArticleList($db, $start, $limit)
{
    $res = $db->query("SELECT articles.id AS id, title, date, login 
							FROM articles LEFT JOIN users ON articles.user_id = users.id 
							ORDER BY id DESC LIMIT $start, $limit");
    return toArray($res);
}

/**
 * Получение статьи по ее идентификатору
 * @param object $db подключение к базе данных
 * @param int $id идентификатор статьи для вывода
 * @return array получение статьи по ее идентификатору
 */
function getArticleById($db, $id)
{
    $res = $db->query("SELECT articles.id AS id, title, date, text, login 
							FROM articles LEFT JOIN users ON articles.user_id = users.id WHERE articles.id = $id");
    return $res->fetch_assoc();
}

/**
 * Получение общего количества статей в базе данных
 * @param object $db подключение к базе данных
 * @return int получение общего количества статей в базе данных
 */
function countArticles($db)
{
    $res = $db->query("SELECT COUNT(id) FROM articles");
    $result = $res->fetch_row();
    return $result[0];
}

/**
 * Получение номера статьи, с которой начинается страница
 * @param int $page страница, которую запрашивает пользователь
 * @param int $limit количество статей на странице
 * @return int возвращает номер статьи, с которой начинается страница
 */
function getStart($page, $limit)
{
    return ($page - 1) * $limit;
}

/**
 * Получение количества страниц
 * @param object $db подключение к базе данных
 * @param int $limit количество статей на странице
 * @return int возвращает количество страниц
 */
function pagination($db, $limit)
{
    return ceil(countArticles($db) / $limit);
}

/**
 * Функция для фильтрации логина
 * @param object $db подключение к базе данных
 * @param string $login логин, полученный от пользователя
 * @return string очищеный от специальных символов логин
 */
function filterLogin($db, $login)
{
    $login = trim($login);
    $login = strip_tags($login);
    $login = htmlspecialchars($login);
    return mysqli_escape_string($db, $login);
}

/**
 * Функция для фильтрации текста
 * @param string $text текст статьи, полученный от пользователя
 * @return string очищеный от недопустимых символов текст статьи
 */
function filterText($text)
{
    $text = get_magic_quotes_gpc() ? $text : addslashes($text);
    return $text;
}

/**
 * Функция для декодирования текста
 * @param string $text текст статьи, полученный из базы данных
 * @return string раскодированный текст статьи
 */
function decodeText($text)
{
    $text = get_magic_quotes_gpc() ? stripslashes($text) : $text;
    return $text;
}

/**
 * Функция для проверки существования логина
 * @param object $db подключение к базе данных
 * @param string $login логин, полученный от пользователя
 * @return int количество пользователей с введенным логином
 */
function checkLogin($db, $login)
{
    $res = $db->query("SELECT COUNT(id) FROM users WHERE login = '$login'");
    $result = $res->fetch_row();
    return $result[0];
}

/**
 * Получение идентификатора пользователя
 * @param object $db подключение к базе данных
 * @param string $login логин
 * @param string $pass пароль
 * @return int идентификатор пользователя
 */
function getUserID($db, $login, $pass)
{
    $res = $db->query("SELECT id FROM users WHERE login = '$login' AND password = '" . md5($pass) . "'");
    $result = $res->fetch_assoc();
    return $result['id'];
}

/**
 * Добавление нового пользователя
 * @param object $db подключение к базе данных
 * @param string $login логин
 * @param string $pass пароль
 * @return int идентификатор пользователя
 */
function addUser($db, $login, $pass)
{
    $db->query("INSERT INTO users SET login='$login', password='" . md5($pass) . "'");
    return $db->insert_id;
}

/**
 * Добавление статьи
 * @param object $db подключение к базе данных
 * @param string $title название статьи
 * @param string $text текст статьи
 * @param int $user_id идентификатор автора статьи
 * @return int идентификатор статьи
 */
function addArticle($db, $title, $text, $user_id)
{
    $title = mysqli_escape_string($db, $title);
    $text = mysqli_escape_string($db, $text);
    $db->query("INSERT INTO articles SET title='$title', text='$text', user_id=$user_id");
    return $db->insert_id;
}

?>