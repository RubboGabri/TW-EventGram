<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.php";  //commentato per non visualizzare la navbar
$templateParams["main"] = "template/createPost.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/create_post.js", "js/logout.js");//, "js/check_notifications.js");
$templateParams["title"] = "Crea Post - EventGram";
$templateParams["header"] = "header.php";
$templateParams["user"] = isset($_SESSION["idUser"]) ? $dbh->getUserById($_SESSION["idUser"]) : null;

$templateParams["categories"] = $dbh->getAllCategories();
$templateParams["locations"] = $dbh->getAllLocations();
require_once 'template/base.php';
?>
