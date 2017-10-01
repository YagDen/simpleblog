<?php
require_once "includes/functions.php";
require_once "includes/config.php";

session_start();

$error = "";
if(isset($_POST["enter"]))
{
	$login = filterLogin($_POST["login"]);
	$pass = mysql_escape_string($_POST["pass"]);
	if(strlen($login) < $minLoginLng)
		$error .= "<p>Логин должен содержать не менее ".$minLoginLng." символов!</p>";
	if(strlen($pass) < $minPasswordLng)
		$error .= "<p>Пароль должен содержать не менее ".$minPasswordLng." символов!</p>";
	
	if(!$error)
	{
		if(!$id = getUserID($login, $pass))
			$error .= "<p>Не верное имя пользователя или пароль!</p>";
		else
		{
			$_SESSION['user_id'] = $id;
			$_SESSION['login'] = $login;
			header('Location: /');
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		$title = "Вход";
		require_once "includes/head.php";
	?>
</head>
	<body>
		<?php require_once "includes/header.php"; ?>
		
		<div id="articleList">
			<div id="regForm">
			<?php
				if(!isset($_SESSION['login']))
				{
			?>
				<form method="post" action="login.php">
					<fieldset>
						<legend>Вход</legend>
						<div id="errorMessage"><?=$error;?></div><br/>
						<input type="text" name="login" placeholder="Логин" value="<?=@$login;?>" required><br/><br/>
						<input type="password" name="pass" placeholder="Пароль" required><br/><br/>
						<input type="submit" name="enter" value="Войти">
					</fieldset>
				</form>
			<?php
				}
				else
				{
			?>
			<div id="errorMessage">Вы уже вошли как <strong><?=$_SESSION['login'];?></strong>. 
				Если Вы хотите войти под другим именем, необходимо сначала <a href="logout.php">выйти из 
				текущей учетной записи.</a></div><br/>
			<?php
				}
			?>
			</div>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>