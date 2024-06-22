<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js");
$templateParams["title"] = "EventGram";
require_once 'template/base.php';
?>
