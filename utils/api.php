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

    case 'getNotifications':
        $notifications = $dbh->getNotifications($loggedUser);

        // Raggruppa le notifiche per periodo di tempo
        $groupedNotifications = [
            "today" => [],
            "lastWeek" => [],
            "lastMonth" => [],
            "earlier" => []
        ];

        $now = new DateTime();
        foreach ($notifications as $notification) {
            $notificationDate = new DateTime($notification['date']);
            $interval = $now->diff($notificationDate);

            $userInfo = $dbh->getUserById($notification['notifier']);
            $user = $userInfo[0];
            $notification['notifier_username'] = $user['username'];

            if ($interval->days == 0) {
                $groupedNotifications["today"][] = $notification;
            } elseif ($interval->days <= 7) {
                $groupedNotifications["lastWeek"][] = $notification;
            } elseif ($interval->days <= 30) {
                $groupedNotifications["lastMonth"][] = $notification;
            } else {
                $groupedNotifications["earlier"][] = $notification;
            }
        }

        echo json_encode($groupedNotifications);
        break;

    case 'createPost':
        $result["esito"] = false;
        $result["errore"] = "";

        // Ottieni i dati dal modulo
        $title = $_POST['title'];
        $description = $_POST['description'];
        $eventDate = $_POST['eventDate'];
        $location = $_POST['location'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $minAge = isset($_POST['minAge']) ? $_POST['minAge'] : null;

        $imgData = null;
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $imgTmpPath = $_FILES['img']['tmp_name'];
            $imgData = file_get_contents($imgTmpPath); // Ottieni il contenuto dell'immagine

            // Aggiungi log per verificare i dati dell'immagine
            error_log("Lunghezza dati immagine: " . strlen($imgData));
            error_log("Dati immagine: " . bin2hex(substr($imgData, 0, 32))); // Log dei primi 32 byte dell'immagine in formato esadecimale
        } else {
            error_log("Errore durante il caricamento dell'immagine: " . (isset($_FILES['img']['error']) ? $_FILES['img']['error'] : 'File non caricato'));
        }
        // Log dei parametri per il debug
        error_log("Title: " . $title);
        error_log("Description: " . $description);
        error_log("Event Date: " . $eventDate);
        error_log("Location: " . $location);
        error_log("Category: " . $category);
        error_log("Price: " . $price);
        error_log("Min Age: " . $minAge);

        $dbh->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Chiama la funzione per creare il post
        $postCreated = $dbh->createPost($imgData, $title, $description, $eventDate, $loggedUser, $location, $price, $category, $minAge);

        $dbh->db->query('SET FOREIGN_KEY_CHECKS=1');

        if ($postCreated) {
            $result["esito"] = true;
        } else {
            $result["errore"] = "Errore nella creazione del post.";
        }
        header('Content-Type: application/json');
        echo json_encode($result);
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
