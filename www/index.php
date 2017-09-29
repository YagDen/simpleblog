﻿<?php
require_once "includes/config.php";
require_once "includes/functions.php";

$page = (int)$_GET["page"];
if(!$page || $page <= 0)
	$page = 1;
$start = getStart($page, $articlesPerPage);
require_once "includes/functions.php";
$articles = getArticleList($start, $articlesPerPage);
if(!$articles)
{
	$page = 1;
	$start = getStart($page, $articlesPerPage);
	$articles = getArticleList($start, $articlesPerPage);
}
if(!$articles)
	exit("Вероятно база данных пуста!");
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		$title = "Главная";
		require_once "includes/head.php";
	?>
</head>
	<body>
		<?php require_once "includes/header.php"; ?>
		
		<div id="articleList">
		<?php
		foreach($articles as $article)
		{
			echo '<div class="articleReview">
				<a href="article.php?article='.$article["id"].'">
					<h2>'.$article["title"].'</h2>
			</a>
				<div class="addTime">Добавлено: '.date_format(date_create($article["date"]), "H:i d-m-Y").'</div>
			</div>';
		}
		?>
			<div id="pagination"><?=pagination($page, $articlesPerPage, $nearPagesCount);?></div>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>