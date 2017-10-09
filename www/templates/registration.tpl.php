<div id="articleList">
    <div id="regForm">
        <?php
        if (!isset($_SESSION['login'])) {
            ?>
            <form method="post" action="registration.php">
                <fieldset>
                    <legend>Регистрация</legend>
                    <?php
                    include "showMessage.tpl.php";
                    ?>
                    <input type="text" name="login" placeholder="Логин" value="<?= @$login; ?>" required><br/><br/>
                    <input type="password" name="pass" placeholder="Пароль" required><br/><br/>
                    <input type="password" name="rpass" placeholder="Повторите пароль" required><br/><br/>
                    <input type="submit" name="register" value="Регистрация">
                </fieldset>
            </form>
            <?php
        } else {
            ?>
            <div id="errorMessage">Вы уже зарегистрированы как <strong><?= $_SESSION['login']; ?></strong>.
                Если Вы все-таки хотите зарегистрироваться, необходимо сначала <a href="logout.php">выйти из
                    текущей учетной записи.</a></div><br/>
            <?php
        }
        ?>
    </div>
</div>