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
        break;

    default:
        echo json_encode(["errore" => "Operazione non valida"]);
        break;
}
