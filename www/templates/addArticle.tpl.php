<div id="articleList">
    <div id="regForm">
        <form method="post" action="addArticle.php">
            <fieldset>
                <legend>Добавление статьи</legend>
                <?php
                include "showMessage.tpl.php";
                ?>
                <input type="text" name="title" placeholder="Название статьи" value="<?=@decodeText($articleTitle);?>" required><br/><br/>
                <textarea name="text" placeholder="Введите текст статьи" cols=55 rows=25 required><?=@decodeText($text);?></textarea><br/><br/>
                <input type="submit" name="add" value="Добавить статью">
            </fieldset>
        </form>
    </div>