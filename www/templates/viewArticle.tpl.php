<div id="articleList">
    <?php
    /**
     * @var array $article массив параметров статьи
     */
    echo '<div class="articleReview">
					<h2 class="articleHead">' . $article["title"] . '</h2>
				<div class="addTime">Добавлено: ' . date_format(date_create($article["date"]), "H:i d-m-Y") . '<br/><br/>
					Автор: <strong>' . $article["login"] . '</strong>
				</div>
				<div class="articleBody">' . decodeText($article["text"]) . '</div>
			</div>';
    ?>
</div>