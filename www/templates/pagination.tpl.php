<div id="pagination">
    <?php
    /**
     * @var int $numPages количество страниц
     */
    for ($i = 1; $i <= $numPages; $i++) {
        echo "<a href=\"index.php?page=" . $i . "\">" . $i . "</a>";
    }
    ?>
</div>