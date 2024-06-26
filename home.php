<?php
require_once 'bootstrap.php';

// Verifica se l'utente è loggato e imposta i dati dell'utente
if (isset($_SESSION["idUser"])) {
    $templateParams["user"] = $dbh->getUserById($_SESSION["idUser"]);
}
$templateParams["navbar"] = "template/navbar.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js", "js/post.js", "js/search.js", "js/check_notification.js");
$templateParams["title"] = "EventGram";
$templateParams["post_details"] = "template/post_details.php";
$templateParams["comment_page"] = "template/comment_page.php";
$templateParams["postList"] = "template/post.php";
$templateParams["main"] = "home_feed.php";
$templateParams["header"] = "template/header.php";
$templateParams["posts"] = $dbh->getAllPosts();

require_once 'template/base.php';
?>
