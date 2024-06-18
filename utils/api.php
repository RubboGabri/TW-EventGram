<?php
require_once '../bootstrap.php';
header("Content-Type: application/json");

$loggedUser = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : -1;
if (isset($_GET["op"]) && $_GET["op"] == "getLoggedUser") {
    echo json_encode(array("idUser" => $loggedUser));
}
else if (isset($_POST["op"]) && $_POST["op"] == "register" && isset($_POST["username"]) && isset($_POST["password"])) {
    $result["esito"] = false;
    $result["errore"] = "";
    $register_result = $dbh->insertUser($_POST["username"], $_POST["password"]);
    if($register_result==0) {
        $result["errore"] = "Errore! Username già utilizzato!";
    } else {
        $login_result = $dbh->login($_POST["username"], $_POST["password"]);
        if($login_result["esito"]==true) {
            registerLoggedUser($login_result[0]);
        }
    }
    error_log(isUserLoggedIn() ? "Utente loggato" : "Utente non loggato");
    if(isUserLoggedIn()) {
        $result["esito"] = true;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
}
else if (isset($_POST["op"]) && $_POST["op"] == "login" && isset($_POST["username"]) && isset($_POST["password"])) {
    $result["esito"] = false;
    $login_result = $dbh->login($_POST["username"], $_POST["password"]);
    if($login_result["esito"]==false) {
        $result["errore"] = $login_result["errore"];
    } else {
        registerLoggedUser($login_result[0]);
    }
    if(isUserLoggedIn()) {
        $result["esito"] = true;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>
