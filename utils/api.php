<?php
require_once '../bootstrap.php';
header("Content-Type: application/json");

$loggedUser = isset($_SESSION["idUser"]) ? $_SESSION["idUser"] : -1;

switch ($_REQUEST['op']) {
    case 'getLoggedUser':
        echo json_encode(["idUser" => $loggedUser]);
        break;

    case 'register':
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $result = ["esito" => false, "errore" => ""];
            $registerResult = $dbh->insertUser($_POST["username"], $_POST["password"]);
            
            if ($registerResult == 0) {
                $result["errore"] = "Errore! Username già utilizzato!";
            } else {
                $loginResult = $dbh->login($_POST["username"], $_POST["password"]);
                if ($loginResult["esito"] === true) {
                    registerLoggedUser($loginResult[0]);
                }
            }
            
            error_log(isUserLoggedIn() ? "Utente loggato" : "Utente non loggato");
            if (isUserLoggedIn()) {
                $result["esito"] = true;
            }
            
            echo json_encode($result);
        }
        break;

    case 'login':
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $result = ["esito" => false];
            $loginResult = $dbh->login($_POST["username"], $_POST["password"]);
            
            if ($loginResult["esito"] === false) {
                $result["errore"] = $loginResult["errore"];
            } else {
                registerLoggedUser($loginResult[0]);
            }
            
            if (isUserLoggedIn()) {
                $result["esito"] = true;
            }
            
            echo json_encode($result);
        }
        break;

    case 'logout':
        logout();
        break;

    case 'follow':
        if (isset($_SESSION['idUser']) && isset($_POST["idFollowed"])) {
            $dbh->insertFollower($loggedUser, $_POST["idFollowed"]);
            $result["esito"] = true;
            $result["errore"] = "Nessuno";
        
            $dbh->notifyFollow($loggedUser, $_POST["idFollowed"]);
        
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    case 'unfollow':
        if (isset($_SESSION['idUser']) && isset($_POST["idFollowed"])) {
            $dbh->removeFollower($loggedUser, $_POST["idFollowed"]);
            $result["esito"] = true;
            $result["errore"] = "Nessuno";
        
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    case 'updateProfile':
        if (isset($_POST["username"]) && isset($_POST["info"])) {
            $result["esito"] = false;
            $result["errore"] = "Non so!";
            if(isset($_POST["pic"])) $result["esito"] = $dbh->updateUserWithPic($_SESSION["idUser"], $_POST["username"], $_POST["bio"], $_POST["pic"]);
            else $result["esito"] = $dbh->updateUser($_SESSION["idUser"], $_POST["username"], $_POST["bio"]);
            
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    default:
        echo json_encode(["errore" => "Operazione non valida"]);
        break;
}

?>