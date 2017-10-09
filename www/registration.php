<?php
require_once "includes/header.php";

$errors = array();
if (isset($_POST["register"])) {
    $login = filterLogin($db, $_POST["login"]);
    $pass = mysqli_escape_string($db, $_POST["pass"]);
    $rpass = mysqli_escape_string($db, $_POST["rpass"]);

    if (strlen($login) < $minLoginLng)
        $errors[] = "Логин должен содержать не менее " . $minLoginLng . " символов!";
    if (strlen($pass) < $minPasswordLng)
        $errors[] = "Пароль должен содержать не менее " . $minPasswordLng . " символов!";
    if ($pass !== $rpass)
        $errors[] = "Пароли не совпадают!";

    if (empty($errors)) {
        if (checkLogin($db, $login))
            $errors[] = "Пользователь с таким логином уже зарегистрирован!";
        else {
            if (!$id = addUser($db, $login, $pass))
                $errors[] = "Во время регистрации произошла ошибка. Пожалуйста, повторите попытку позже!";
            else {
                $_SESSION['user_id'] = $id;
                $_SESSION['login'] = $login;
                header('Location: /');
                exit();
            }
        }
    }
}

$title = "Регистрация";
require_once "templates/header.tpl.php";

include "templates/registration.tpl.php";

require_once "templates/footer.tpl.php";
?>