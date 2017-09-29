<?php
require_once "includes/functions.php";
$id = (int)$_GET["article"];
$article = getArticleById($id);
if(!$article)
{
	exit("Такой статьи не существует!");
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		$title = $article["title"];
		require_once "includes/head.php";
	?>
</head>
	<body>
		<?php require_once "includes/header.php"; ?>
		
		<div id="articleList">
		<?php

			echo '<div class="articleReview">
					<h2 class="articleHead">'.$article["title"].'</h2>
				<div class="addTime">Добавлено: '.date_format(date_create($article["date"]), "H:i d-m-Y").'</div>
				<div class="articleBody">'.$article["text"].'</div>
			</div>';
		?>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>