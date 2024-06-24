<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.html";  
$templateParams["header"] = "template/header_profile.php";
$templateParams["main"] = "template/createPost.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/create_post.js");
$templateParams["title"] = "Create Post - EventGram";
$templateParams["user"] = isset($_SESSION["idUser"]) ? $dbh->getUserById($_SESSION["idUser"]) : null;

$templateParams["categories"] = $dbh->getAllCategories();
$templateParams["locations"] = $dbh->getAllLocations();
require_once 'template/base.php';
?>
