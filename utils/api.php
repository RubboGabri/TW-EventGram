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

    // api.php
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
            if ($user['profilePic'] != null) {
                $notification['notifier_pic'] = base64_encode($user['profilePic']);
            }

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
        if (
            isset($_POST["op"]) && $_POST["op"] == "createPost" && isset($_POST["title"])
            && isset($_POST["description"]) && isset($_POST["eventDate"]) && isset($_POST["location"])
            && isset($_POST["category"]) && isset($_POST["price"])
        ) {
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
            }

            // Chiama la funzione per creare il post
            $postCreated = $dbh->createPost($imgData, $title, $description, $eventDate, $loggedUser, $location, $price, $category, $minAge);

            if ($postCreated) {
                // Ottieni i follower dell'utente
                $followers = $dbh->getFollowers($loggedUser);
                foreach ($followers as $follower) {
                    $dbh->insertNotification('Post', $follower['IDfollower'], $loggedUser, $postCreated);
                }
                $result["esito"] = true;
            } else {
                $result["errore"] = "Errore nella creazione del post.";
            }

            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    case 'follow':
        if (isset($_SESSION['idUser']) && isset($_POST["idFollowed"])) {
            $dbh->insertFollower($loggedUser, $_POST["idFollowed"]);
            $dbh->insertNotification('Follow', $_POST["idFollowed"], $loggedUser);
            $result["esito"] = true;
            $result["errore"] = "Nessuno";
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

            $username = $_POST["username"];
            $info = $_POST["info"];
            $removeImage = isset($_POST["removeImage"]) && $_POST["removeImage"] === '1';
            $pic = isset($_FILES["pic"]) ? $_FILES["pic"] : null;

            if (empty(trim($info))) {
                $info = null;
            }

            $existingUser = $dbh->getUserByUsername($username);
            if (!empty($existingUser) && $existingUser[0]['IDuser'] != $_SESSION["idUser"]) {
                $result["errore"] = "Questo username è già utilizzato.";
            } else {
                if ($removeImage) {
                    $update_result = $dbh->updateUser($_SESSION["idUser"], $username, $info, 'REMOVE');
                } elseif ($pic !== null) {
                    $imgData = file_get_contents($pic['tmp_name']);
                    $update_result = $dbh->updateUser($_SESSION["idUser"], $username, $info, $imgData);
                } else {
                    $update_result = $dbh->updateUser($_SESSION["idUser"], $username, $info);
                }

                if ($update_result) {
                    $result["esito"] = true;
                } else {
                    $result["errore"] = "Errore durante l'aggiornamento del profilo.";
                }
            }

            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    case 'deleteAccount':
        $result["esito"] = false;
        $result["errore"] = "Non so!";

        if ($loggedUser) {
            $delete_result = $dbh->deleteUser($loggedUser);
            if ($delete_result) {
                $result["esito"] = true;
                // Distruggi la sessione dopo aver eliminato l'account
                session_destroy();
            } else {
                $result["esito"] = false;
                $result["errore"] = "Errore durante l'eliminazione dell'account.";
            }
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;

    case 'addLike':
        if (isset($_POST["idPost"])) {
            $idPost = $_POST["idPost"];
            $dbh->insertLike($idPost, $loggedUser);

            $postOwner = $dbh->getUserByPost($idPost);
            $ownerId = $postOwner[0]['IDuser'];
            $postTitle = $postOwner[0]['title'];
            $dbh->insertNotification('Like', $ownerId, $loggedUser, $idPost);

            $result["esito"] = true;
            $result["errore"] = "Nessuno";

            echo json_encode($result);
        }
        break;

    case 'removeLike':
        if (isset($_POST["idPost"])) {
            $dbh->removeLike($_POST["idPost"], $loggedUser);
            $result["esito"] = true;
            $result["errore"] = "Nessuno";

            header('Content-Type: application/json');
            echo json_encode($result);
        }
        break;
    case 'subscribeToPost':
        if (isset($_POST['idPost']) && isUserLoggedIn()) {
            $result = $dbh->insertSubscription($_SESSION["idUser"], $_POST['idPost']);
            echo json_encode(["esito" => $result]);
        }
        break;
        
    case 'unsubscribeToPost':
        if (isset($_POST['idPost']) && isUserLoggedIn()) {
            $result = $dbh->removeSubscription($_SESSION["idUser"], $_POST['idPost']);
            echo json_encode(["esito" => $result]);
        }
        break;
    case 'addComment':
        if (isset($_POST['idPost']) && isset($_POST['comment']) && $loggedUser != -1) {
            $result = $dbh->addComment($_POST['idPost'], $loggedUser, $_POST['comment']);
            echo json_encode(["esito" => $result]);
        } else {
            echo json_encode(["esito" => false, "errore" => "Dati mancanti o utente non loggato."]);
        }
        break;
    
    case 'getComments':
        if (isset($_POST['idPost'])) {
            $comments = $dbh->getComments($_POST['idPost']);
            // Genera l'HTML per i commenti
            ob_start();
            foreach ($comments as $comment) {
                echo "<div class='comment'><strong>{$comment['username']}</strong>: {$comment['text']}</div>";
            }
            $html = ob_get_clean();
            echo json_encode(["html" => $html]);
        } else {
            echo json_encode(["html" => ""]);
        }
        break;

    default:
        echo json_encode(["errore" => "Operazione non valida"]);
        break;
}
