<?php
require_once("bootstrap.php");
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js");
$templateParams["main"] = "user_profile.php";

if (isset($_GET["id"])) {
    $templateParams["user"] = $_GET["id"];
} else {
    $templateParams["user"] = $_SESSION["idUser"];
}

$templateParams["header"] = "header_profile.php";

$userData = $dbh->getUserById($templateParams["user"]);

$user = $userData[0];

$templateParams["title"] = $user["username"] . " - EventGram";

$userPosts = $dbh->getUserPosts($templateParams["user"]);
$userStat = $dbh->getUserStats($templateParams["user"]);

require_once("template/base.php");

?>