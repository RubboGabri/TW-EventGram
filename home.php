<?php
require_once 'bootstrap.php';

// Verifica se l'utente è loggato e imposta i dati dell'utente
if (isset($_SESSION["idUser"])) {
    $templateParams["user"] = $dbh->getUserById($_SESSION["idUser"]);
}

$templateParams["header"] = "template/header_profile.php";
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js");
$templateParams["title"] = "EventGram";
$templateParams["user"] = $_SESSION["idUser"];

$templateParams["postList"] = "template/post.php";

$templateParams["main"] = "home_feed.php";
$templateParams["header"] = "template/header.php";

$templateParams["posts"] = $dbh->getAllPosts();
require_once 'template/base.php';
?>
