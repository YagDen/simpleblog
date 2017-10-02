<?php
require_once "includes/functions.php";
require_once "includes/config.php";

session_start();

$error = "";
if(isset($_POST["register"]))
{
	$login = filterLogin($_POST["login"]);
	$pass = mysql_escape_string($_POST["pass"]);
	$rpass = mysql_escape_string($_POST["rpass"]);
	
	if(strlen($login) < $minLoginLng)
		$error .= "<p>Логин должен содержать не менее ".$minLoginLng." символов!</p>";
	if(strlen($pass) < $minPasswordLng)
		$error .= "<p>Пароль должен содержать не менее ".$minPasswordLng." символов!</p>";
	if($pass !== $rpass)
		$error .= "<p>Пароли не совпадают!</p>";
	
	if(!$error)
	{
		if(checkLogin($login, $DBhost, $DBlogin, $DBpassword, $DBname))
			$error .= "<p>Пользователь с таким логином уже зарегистрирован!</p>";
		else
		{
			if(!$id = addUser($login, $pass, $DBhost, $DBlogin, $DBpassword, $DBname))
				$error .= "<p>Во время регистрации произошла ошибка. Пожалуйста, повторите попытку позже!</p>";
			else
			{
				$_SESSION['user_id'] = $id;
				$_SESSION['login'] = $login;
				header('Location: /');
				exit();
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		$title = "Регистрация";
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
				<form method="post" action="registration.php">
					<fieldset>
						<legend>Регистрация</legend>
						<div id="errorMessage"><?=$error;?></div><br/>
						<input type="text" name="login" placeholder="Логин" value="<?=@$login;?>" required><br/><br/>
						<input type="password" name="pass" placeholder="Пароль" required><br/><br/>
						<input type="password" name="rpass" placeholder="Повторите пароль" required><br/><br/>
						<input type="submit" name="register" value="Регистрация">
					</fieldset>
				</form>
				<?php
				}
				else
				{
				?>
				<div id="errorMessage">Вы уже зарегистрированы как <strong><?=$_SESSION['login'];?></strong>. 
				Если Вы все-таки хотите зарегистрироваться, необходимо сначала <a href="logout.php">выйти из 
				текущей учетной записи.</a></div><br/>
				<?php
				}
				?>
			</div>
		</div>
		
		<?php require_once "includes/footer.php"; ?>
	</body>
</html>