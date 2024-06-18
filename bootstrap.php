<?php
session_start();
unset($_SESSION['idUser']);
unset($_SESSION['username']);
define("UPLOAD_DIR", "./db/upload/");
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "eventgramdb", 3306);

if (!isUserLoggedIn()) {
    $current_file = basename($_SERVER['PHP_SELF']);
    if ($current_file != 'login.php' && $current_file != 'register.php' && $current_file != 'api.php') {
        header("Location: login.php");
        exit;
    }
}

?>