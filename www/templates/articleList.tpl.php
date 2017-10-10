<div id="articleList">
    <?php
    /**
     * @var array $articles массив всех параметров всех статей
     */
    foreach ($articles as $article) {
        echo '<div class="articleReview">
				<a href="article.php?article=' . $article["id"] . '">
					<h2>' . $article["title"] . '</h2>
			    </a>
				<div class="addTime">
					Добавлено: ' . date_format(date_create($article["date"]), "H:i d-m-Y") . '<br/><br/>
					Автор: <strong>' . $article["login"] . '</strong>
				</div>
		   </div>';
    }
    ?>

