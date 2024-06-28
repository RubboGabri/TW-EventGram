<?php
require_once("bootstrap.php");
$templateParams["navbar"] = "template/navbar.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js", "js/notification.js");
$templateParams["main"] = "template/notification_list.php"; 
$templateParams["header"] = "template/header.php";

if (isset($_SESSION["idUser"])) {
    $templateParams["user"] = $_SESSION["idUser"];
} else {
    header("Location: login.php");
    exit;
}

$templateParams["title"] = "Notifiche - EventGram";

require_once("template/base.php");
?>