<?php
require_once "includes/header.php";

$errors = array();
if (isset($_POST["enter"])) {
    $login = filterLogin($db, $_POST["login"]);
    $pass = mysqli_escape_string($db, $_POST["pass"]);
    if (strlen($login) < $minLoginLng)
        $errors[] = "Логин должен содержать не менее " . $minLoginLng . " символов!";
    if (strlen($pass) < $minPasswordLng)
        $errors[] = "Пароль должен содержать не менее " . $minPasswordLng . " символов!";

    if (empty($errors)) {
        if (!$id = getUserID($db, $login, $pass))
            $errors[] = "Не верное имя пользователя или пароль!";
        else {
            $_SESSION['user_id'] = $id;
            $_SESSION['login'] = $login;
            header('Location: /');
            exit();
        }
    }
}

$title = "Вход";
require_once "templates/header.tpl.php";

include "templates/login.tpl.php";

require_once "templates/footer.tpl.php";
?>