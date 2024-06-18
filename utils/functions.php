<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idUser']);
}

function registerLoggedUser($user){
    $_SESSION["idUser"] = $user["IDuser"];
    $_SESSION["username"] = $user["username"];
}

?>
