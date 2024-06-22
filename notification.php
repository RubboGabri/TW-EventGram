<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("bootstrap.php");

// Imposta i template
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js");
$templateParams["main"] = "template/notification_list.php";

// Ottieni l'ID utente loggato
if (isset($_SESSION["idUser"])) {
    $templateParams["user"] = $_SESSION["idUser"];
    echo "Logged User ID: " . $templateParams["user"] . "<br>";  // Debugging
} else {
    header("Location: login.php");
    exit;
}

// Recupera le notifiche per l'utente loggato
$notifications = $dbh->getNotifications($templateParams["user"]);
foreach ($notifications as &$notification) {
    $userInfo = $dbh->getUserById($notification['notifier']);
    $user = $userInfo[0];
    $notification['notifier_username'] = $user['username'];
    $notification['notifier_pic'] = $user['profilePic'];
}

$templateParams["title"] = "Notifiche - EventGram";
$templateParams["notifications"] = $notifications;

require_once("template/base.php");
?>