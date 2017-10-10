<?php
/**
 * @var array $errors массив ошибок для вывода
 */
if (!empty($errors)) {
    echo "<div id=\"errorMessage\">";
    foreach ($errors as $error) {
        echo "<p>" . $error . "</p>";
    }
    echo "</div><br/>";
}
