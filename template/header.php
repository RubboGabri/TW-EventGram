<?php
// Supponiamo che $templateParams['title'] contenga il titolo della pagina.
$title = $templateParams['title'];
$firstWord = strtok($title, ' ');
?>

<header class="d-md-none fixed-top bg-info d-flex justify-content-between align-items-center overflow-hidden" style="height: 7vh;">

    <?php
    switch ($firstWord) {
        case 'EventGram':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Home</span>';
            echo '<a href="notification.php" class="ms-auto d-flex align-items-center m-2 p-3"> <img src="img/notification.png" alt="Notifiche" class="img-fluid" style="max-height: 30px"/> </a>';
            break;

        case 'Modifica':
            echo '<a href="user.php" class="d-flex align-items-center m-2 p-1"> <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/> </a>';
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Modifica profilo</span>';
            break;

        case 'Notifiche':
            echo '<a href="home.php" class="d-flex align-items-center m-2 p-1"> <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/> </a>';
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Notifiche</span>';
            break;

        case 'Create':
            echo '<a href="home.php" class="d-flex align-items-center m-2 p-1"> <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/> </a>';
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Crea post</span>';
            break;

        default:
            if (isset($user) && $user["IDuser"] != $_SESSION["idUser"]) {
                echo '<a href="home.php" class="d-flex align-items-center m-2 p-1"> <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/> </a>';
            }
            if (isset($user)) {
                echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">' . htmlspecialchars($user["username"]) . '</span>';
            }
            echo '<a href="index.php" onclick="logout()" class="ms-auto d-flex align-items-center m-2 p-1 text-decoration-none text-danger">';
            echo '<span class="mx-3 fs-5 fw-semibold">Esci</span>';
            echo '</a>';
            break;
    }
    ?>
</header>

