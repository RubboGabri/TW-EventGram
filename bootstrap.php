<?php
session_start();
define("UPLOAD_DIR", "./db/upload/");
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "eventgramdb", 3306);
$current_file = basename($_SERVER['PHP_SELF']);
//error_log("entrato in bootstrap da: " . $current_file);

if (!isUserLoggedIn()) {
    if ($current_file != 'login.php' && $current_file != 'register.php' && $current_file != 'api.php') {
        header("Location: login.php");
        exit;
    }
} else {
    if ($current_file != 'home.php' && $current_file != 'user.php' && $current_file != 'api.php') {
        header("Location: home.php");
        exit;
    }
}
?>