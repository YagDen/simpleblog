<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <div id="logo"><a href="/" title="На главную">Шапка сайта</a></div>
    <div id="auth">
        <?php
        if (!isset($_SESSION['login'])) {
            ?>
            <a href="login.php">Вход</a> | <a href="registration.php">Регистрация</a>
            <?php
        } else {
            ?>
            Добро пожаловаь, <strong><?= $_SESSION['login']; ?></strong>! | <a href="logout.php">Выход</a><br/>
            <a href="addArticle.php"><img src="/icon/addArticle.png" alt="Добавить статью" title="Добавить статью"/></a>
            <?php
        }
        ?>
    </div>
</header>
