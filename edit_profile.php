<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/update_profile.js", "js/logout.js", "js/check_notification.js");
$templateParams["title"] = "Modifica profilo - EventGram";
$templateParams["user"] = $_SESSION["idUser"];

$userData = $dbh->getUserById($templateParams["user"]);
$user = $userData[0];

$templateParams["main"] = "template/edit_profile_page.php";
$templateParams["header"] = "header.php";
require_once 'template/base.php';
?>