<?php
require_once "includes/header.php";

$id = (int)$_GET["article"];

$article = getArticleById($db, $id);
if (!$article) {
    exit("Такой статьи не существует!");
}

$title = $article["title"];
require_once "templates/header.tpl.php";

include "templates/viewArticle.tpl.php";

require_once "templates/footer.tpl.php";
?>