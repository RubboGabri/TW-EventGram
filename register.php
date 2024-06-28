<?php
require_once 'bootstrap.php';
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/registration.js", "js/check_notification.js");
$templateParams["title"] = "Registrati - EventGram";
$templateParams["main"] = "template/registration_form.php";
require_once 'template/base.php';
?>
