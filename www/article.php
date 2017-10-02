<?php
require_once "includes/functions.php";

session_start();

$id = (int)$_GET["article"];
$article = getArticleById($id, $DBhost, $DBlogin, $DBpassword, $DBname);
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
				<div class="addTime">Добавлено: '.date_format(date_create($article["date"]), "H:i d-m-Y").'<br/><br/>
					Автор: <strong>'.$article["login"].'</strong>
				</div>
				<div class="articleBody">'.decodeText($article["text"]).'</div>
			</div>';
		?>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>