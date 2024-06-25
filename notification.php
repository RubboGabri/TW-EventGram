<?php
require_once("bootstrap.php");
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/logout.js");
$templateParams["main"] = "template/notification_list.php";
$templateParams["header"] = "template/header.php";

if (isset($_SESSION["idUser"])) {
    $templateParams["user"] = $_SESSION["idUser"];
} else {
    header("Location: login.php");
    exit;
}

$notifications = $dbh->getNotifications($templateParams["user"]);

$today = [];
$this_week = [];
$this_month = [];
$earlier = [];

foreach ($notifications as &$notification) {
    $userInfo = $dbh->getUserById($notification['notifier']);
    $user = $userInfo[0];
    $notification['notifier_username'] = $user['username'];
    $notification['notifier_pic'] = $user['profilePic'];
    
    $notification_date = new DateTime($notification['date']);
    $current_date = new DateTime();

    $interval = $current_date->diff($notification_date);

    if ($interval->days == 0) {
        $today[] = $notification;
    } elseif ($interval->days <= 7) {
        $this_week[] = $notification;
    } elseif ($interval->days <= 30) {
        $this_month[] = $notification;
    } else {
        $earlier[] = $notification;
    }
}

//var_dump($updatedNotifications); // Debugging

$templateParams["title"] = "Notifiche - EventGram";
$templateParams["notifications"] = [
    "today" => $today,
    "this_week" => $this_week,
    "this_month" => $this_month,
    "earlier" => $earlier
];

require_once("template/base.php");
?>