<?php
require_once "includes/header.php";

if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$errors = array();
$add = isset($_POST["add"]);
if ($add) {
    $articleTitle = filterText($_POST["title"]);
    $text = filterText($_POST["text"]);
}

if ($add && (strlen($articleTitle) < $minTitleLng))
    $errors[] = "Название статьи должно содержать не менее " . $minTitleLng . " символов!";
if ($add && empty($text))
    $errors[] = "Введите текст статьи!";

$add2 = $add && empty($errors);
$article_id = false;
if ($add2) {
    $article_id = addArticle($db, $articleTitle, $text, $_SESSION['user_id']);
}
if ($add2 && !$article_id)
    $errors[] = "Во время добавления статьи возникли ошибки. Пожалуйста, повторите попытку позже!";
elseif ($add2) {
    header('Location: /article.php?article=' . $article_id);
    exit();
}

$title = "Добавление статьи";
require_once "templates/header.tpl.php";

include "templates/addArticle.tpl.php";

require_once "templates/footer.tpl.php";
