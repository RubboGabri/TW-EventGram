<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js");
$templateParams["title"] = "EventGram";
$templateParams["main"] = "home_feed.php";
$templateParams["header"] = "template/header.php";
$templateParams["user"] = $_SESSION["idUser"];
require_once 'template/base.php';
?>
