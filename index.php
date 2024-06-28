<?php
require_once("bootstrap.php");
$templateParams["title"] = "EventGram - Home"; 
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/check_notification.js");
require_once("template/base.php");
?>