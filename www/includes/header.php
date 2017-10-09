<?php
require_once "includes/config.php";
require_once "includes/functions.php";

session_start();

$db = connectDB($dbHost, $dbLogin, $dbPassword, $dbName);
?>