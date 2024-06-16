<?php
session_start();
define("UPLOAD_DIR", "./db/upload/");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "eventgramdb", 3306);
?>