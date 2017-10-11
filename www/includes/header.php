<?php
require_once "includes/config.php";
require_once "classes/database.php";
require_once "includes/functions.php";

session_start();

$db = new Database($dbHost, $dbLogin, $dbPassword, $dbName);
