<?php
// Supponiamo che $templateParams['title'] contenga il titolo della pagina.
$title = $templateParams['title'];
$firstWord = strtok($title, ' ');
?>

<header class="d-md-none fixed-top border-bottom border-dark bg-info d-flex justify-content-between align-items-center" style="height: 7vh;">
    
    <?php
    switch ($firstWord) {
        case 'EventGram':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Home</span>';
            echo '<a href="notification.php" class="ms-auto d-flex align-items-center m-2 p-3 position-relative">';
            echo '<img src="../img/notification.png" alt="Notifiche" class="img-fluid" style="max-height: 28px;">';
            echo '<span class="unread-notifications badge rounded-pill bg-danger position-absolute d-none" style="top: 0; right: 0; font-size: 0.8rem; padding: 3px 6px;"></span>';
            echo '</a>';
            break;

        case 'Modifica':
            echo '<a href="javascript:history.back()" class="d-flex align-items-center m-2 p-1"><img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 25px;"></a>';
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Modifica profilo</span>';
            break;

        case 'Notifiche':
            echo '<a href="javascript:history.back()" class="d-flex align-items-center m-2 p-1"><img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 27px;"></a>';
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Notifiche</span>';
            break;

        case 'Crea':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Nuovo post</span>';
            break;

        case 'Search':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Cerca Utente</span>';
            break;

        default:
            if (isset($user) && $user["IDuser"] != $_SESSION["idUser"]) {
                echo '<a href="javascript:history.back()" class="d-flex align-items-center m-2 p-1"><img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px;"></a>';
            } else {
                echo '<a href="index.php" onclick="logout()" class="ms-auto d-flex align-items-center m-2 p-3 text-decoration-none text-dark">';
                echo '<img src="../img/logout.PNG" alt="Esci" class="img-fluid" style="max-height: 25px">';
                echo '</a>';
            }
            if (isset($user)) {
                echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">' . htmlspecialchars($user["username"]) . '</span>';
            }
            break;
    }
    ?>
</header>
