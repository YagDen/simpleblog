<?php
require_once "includes/header.php";

$errors = array();
$register = isset($_POST["register"]);
if ($register) {
    $login = filterLogin($db, $_POST["login"]);
    $pass = mysqli_escape_string($db, $_POST["pass"]);
    $rpass = mysqli_escape_string($db, $_POST["rpass"]);
}
if ($register && (strlen($login) < $minLoginLng))
    $errors[] = "Логин должен содержать не менее " . $minLoginLng . " символов!";
if ($register && (strlen($pass) < $minPasswordLng))
    $errors[] = "Пароль должен содержать не менее " . $minPasswordLng . " символов!";
if ($register && $pass !== $rpass)
    $errors[] = "Пароли не совпадают!";

$register2 = $register && empty($errors);
$register3 = false;
if ($register2 && checkLogin($db, $login))
    $errors[] = "Пользователь с таким логином уже зарегистрирован!";
elseif ($register2) {
    $register3 = true;
}
if ($register3 && (!$id = addUser($db, $login, $pass)))
    $errors[] = "Во время регистрации произошла ошибка. Пожалуйста, повторите попытку позже!";
else {
    $_SESSION['user_id'] = $id;
    $_SESSION['login'] = $login;
    header('Location: /');
    exit();
}

$title = "Регистрация";
require_once "templates/header.tpl.php";

include "templates/registration.tpl.php";

require_once "templates/footer.tpl.php";
