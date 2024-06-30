<?php
require_once 'bootstrap.php';
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/login.js");
$templateParams["title"] = "Login - EventGram";
$templateParams["main"] = "template/login_form.php";
require_once 'template/base.php';
?>
