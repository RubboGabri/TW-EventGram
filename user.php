<?php
require_once("bootstrap.php");
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js", "js/user.js");
$templateParams["main"] = "user_profile.php";

if (isset($_GET["id"])) {
    $templateParams["user"] = $_GET["id"];
} else {
    $templateParams["user"] = $_SESSION["idUser"];
}

$templateParams["header"] = "header.php";

$userData = $dbh->getUserById($templateParams["user"]);
$userPosts = $dbh->getUserPosts($templateParams["user"]);
$userStatistics = $dbh->getUserStats($templateParams["user"]);

$user = $userData[0];
$userStats = $userStatistics[0];

$templateParams["title"] = $user["username"] . " - EventGram";

require_once("template/base.php");
?>