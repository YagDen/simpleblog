<?php
require_once "includes/header.php";

$page = (int)$_GET["page"];
if (!$page || $page <= 0)
    $page = 1;
$start = getStart($page, $articlesPerPage);
$articles = getArticleList($db, $start, $articlesPerPage);
if (!$articles) {
    $page = 1;
    $start = getStart($page, $articlesPerPage);
    $articles = getArticleList($db, $start, $articlesPerPage);
}
if (!$articles)
    exit("Вероятно база данных пуста!");

$title = "Главная";
require_once "templates/header.tpl.php";

include "templates/articleList.tpl.php";

$numPages = pagination($db, $articlesPerPage);
include "templates/pagination.tpl.php";

require_once "templates/footer.tpl.php";
?>