<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.php"; 
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js", "js/search.js", "js/check_notification.js");
$templateParams["title"] = "Search - EventGram";
$templateParams["header"] = "header.php";
$templateParams["main"] = "template/search_form.php";
require_once 'template/base.php';
?>
