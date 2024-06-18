<?php
require_once 'bootstrap.php';
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js");
$templateParams["title"] = "EventGram";
$templateParams["main"] = "template/home_feed.php";
require_once 'template/base.php';
?>
