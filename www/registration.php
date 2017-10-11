<?php
require_once "includes/header.php";

$errors = array();
$register = isset($_POST["register"]);
if ($register) {
    $login = filterLogin($db, $_POST["login"]);
    $pass = $db->mysqli_escape_string($_POST["pass"]);
    $rpass = $db->mysqli_escape_string($_POST["rpass"]);
}
if ($register && (strlen($login) < $minLoginLng))
    $errors[] = "Логин должен содержать не менее " . $minLoginLng . " символов!";
if ($register && (strlen($pass) < $minPasswordLng))
    $errors[] = "Пароль должен содержать не менее " . $minPasswordLng . " символов!";
if ($register && $pass !== $rpass)
    $errors[] = "Пароли не совпадают!";

$register2 = $register && empty($errors);
$check = false;
if ($register2) {
    $check = checkLogin($db, $login);
}
$id = false;
if ($check) {
    $errors[] = "Пользователь с таким логином уже зарегистрирован!";
} elseif ($register2) {
    $id = addUser($db, $login, $pass);
}

$register2 &= empty($errors);
if ($register2 && !$id)
    $errors[] = "Во время регистрации произошла ошибка. Пожалуйста, повторите попытку позже!";
if ($id) {
    $_SESSION['user_id'] = $id;
    $_SESSION['login'] = $login;
    header('Location: /');
    exit();
}

$title = "Регистрация";
require_once "templates/header.tpl.php";

include "templates/registration.tpl.php";

require_once "templates/footer.tpl.php";
