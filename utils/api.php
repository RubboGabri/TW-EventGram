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

    default:
        echo json_encode(["errore" => "Operazione non valida"]);
        break;
}
