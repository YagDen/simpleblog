<?php
require_once "includes/functions.php";
require_once "includes/config.php";

session_start();

if(empty($_SESSION['user_id']))
{
	header('Location: /login.php');
	exit();
}

$error = "";
if(isset($_POST["add"]))
{
	$articleTitle = filterText($_POST["title"]);
	$text = filterText($_POST["text"]);
	if(strlen($articleTitle) < $minTitleLng)
		$error .= "<p>Название статьи должно содержать не менее ".$minTitleLng." символов!</p>";
	if(empty($text))
		$error .= "<p>Введите текст статьи!</p>";
	
	if(!$error)
	{
		if(!$article_id = addArticle($articleTitle, $text, $_SESSION['user_id'], $DBhost, $DBlogin, $DBpassword, $DBname))
			$error .= "<p>Во время добавления статьи возникли ошибки. Пожалуйста, повторите попытку позже!</p>";
		else
		{
			header('Location: /article.php?article='.$article_id);
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		$title = "Добавление статьи";
		require_once "includes/head.php";
	?>
</head>
	<body>
		<?php require_once "includes/header.php"; ?>
		
		<div id="articleList">
			<div id="regForm">
				<form method="post" action="addArticle.php">
					<fieldset>
						<legend>Добавление статьи</legend>
						<div id="errorMessage"><?=$error;?></div><br/>
						<input type="text" name="title" placeholder="Название статьи" value="<?=@decodeText($articleTitle);?>" required><br/><br/>
						<textarea name="text" placeholder="Введите текст статьи" cols=55 rows=25 required><?=@decodeText($text);?></textarea><br/><br/>
						<input type="submit" name="add" value="Добавить статью">
					</fieldset>
				</form>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>