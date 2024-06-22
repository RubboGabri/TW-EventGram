<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.html";  //commentato per non visualizzare la navbar
$templateParams["main"] = "template/createPost.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/create_post.js");
$templateParams["title"] = "Crea post - EventGram";
$templateParams["user"] = $_SESSION["idUser"];

$templateParams["categories"] = $dbh->getAllCategories();
$templateParams["locations"] = $dbh->getAllLocations();
require_once 'template/base.php';

?>
