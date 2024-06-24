<?php
require_once 'bootstrap.php';
$templateParams["header"] = "header.php";
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/notification.js");
$templateParams["title"] = "Notifiche - EventGram";
$templateParams["main"] = "template/notification_list.php";
require_once 'template/base.php';
?>