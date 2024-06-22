<?php
require_once 'bootstrap.php';
$templateParams["navbar"] = "template/navbar.html";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/update_profile.js");
$templateParams["title"] = "Modifica profilo - EventGram";
$templateParams["main"] = "template/login_form.php";
$templateParams["header"] = "header_profile.php";
require_once 'template/base.php';
?>