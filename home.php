<?php
require_once 'bootstrap.php';
$templateParams["sidebar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js");
$templateParams["title"] = "EventGram";
$templateParams["main"] = "homePage.php";
require_once 'template/base.php';
?>
