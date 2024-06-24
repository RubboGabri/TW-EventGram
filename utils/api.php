<?php
require_once '../bootstrap.php';
header("Content-Type: application/json");

$loggedUser = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : -1;

if (isset($_GET["op"]) && $_GET["op"] == "getLoggedUser") {
    echo json_encode(array("idUser" => $loggedUser));
} else if (isset($_POST["op"]) && $_POST["op"] == "register" && isset($_POST["username"]) && isset($_POST["password"])) {
    $result["esito"] = false;
    $result["errore"] = "";
    $register_result = $dbh->insertUser($_POST["username"], $_POST["password"]);
    if ($register_result == 0) {
        $result["errore"] = "Errore! Username già utilizzato!";
    } else {
        $login_result = $dbh->login($_POST["username"], $_POST["password"]);
        if ($login_result["esito"] == true) {
            registerLoggedUser($login_result[0]);
        }
    }
    error_log(isUserLoggedIn() ? "Utente loggato" : "Utente non loggato");
    if (isUserLoggedIn()) {
        $result["esito"] = true;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
} else if (isset($_POST["op"]) && $_POST["op"] == "login" && isset($_POST["username"]) && isset($_POST["password"])) {
    $result["esito"] = false;
    $login_result = $dbh->login($_POST["username"], $_POST["password"]);
    if ($login_result["esito"] == false) {
        $result["errore"] = $login_result["errore"];
    } else {
        registerLoggedUser($login_result[0]);
    }
    if (isUserLoggedIn()) {
        $result["esito"] = true;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
} else if (isset($_POST["op"]) && $_POST["op"] == "logout") {
    logout();
    header('Content-Type: application/json');
    echo json_encode(array("esito" => true));
} else if (isset($_POST["op"]) && $_POST["op"] == "createPost" && isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["eventDate"]) && isset($_POST["location"]) && isset($_POST["category"]) && isset($_POST["price"])) {
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

    // Gestione del caricamento dell'immagine
    $imgData = null;
    if (isset($_FILES['imgFile']) && $_FILES['imgFile']['error'] === UPLOAD_ERR_OK) {
        $imgTmpPath = $_FILES['imgFile']['tmp_name'];
        $imgData = file_get_contents($imgTmpPath); // Ottieni il contenuto dell'immagine

        // Aggiungi log per verificare i dati dell'immagine
        error_log("Lunghezza dati immagine: " . strlen($imgData));
    } else {
        error_log("Errore durante il caricamento dell'immagine: " . $_FILES['imgFile']['error']);
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
}
?>
