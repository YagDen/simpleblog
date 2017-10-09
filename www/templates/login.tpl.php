<div id="articleList">
    <div id="regForm">
        <?php
        if (!isset($_SESSION['login'])) {
            ?>
            <form method="post" action="login.php">
                <fieldset>
                    <legend>Вход</legend>
                    <?php
                    include "showMessage.tpl.php";
                    ?>
                    <input type="text" name="login" placeholder="Логин" value="<?= @$login; ?>" required><br/><br/>
                    <input type="password" name="pass" placeholder="Пароль" required><br/><br/>
                    <input type="submit" name="enter" value="Войти">
                </fieldset>
            </form>
            <?php
        } else {
            ?>
            <div id="errorMessage">Вы уже вошли как <strong><?= $_SESSION['login']; ?></strong>.
                Если Вы хотите войти под другим именем, необходимо сначала <a href="logout.php">выйти из
                    текущей учетной записи.</a></div><br/>
            <?php
        }
        ?>
    </div>
</div>