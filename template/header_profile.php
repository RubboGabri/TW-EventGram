<?php
// Supponiamo che $templateParams['title'] contenga il titolo della pagina.
$title = $templateParams['title'];
$firstWord = strtok($title, ' ');
?>

<header class="d-md-none fixed-top bg-info d-flex justify-content-between align-items-center overflow-hidden" style="height: 7vh;">
    <a href="home.php" class="d-flex align-items-center m-2 p-1">
        <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/>
    </a>

    <?php
    switch ($firstWord) {
        case 'Home':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Home</span>';
            break;

        case 'Profile':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Profile</span>';
            break;

        case 'Notifications':
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">Notifications</span>';
            break;

        default:
            echo '<span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold">' . htmlspecialchars($user["username"]) . '</span>';
            echo '<a href="index.php" onclick="logout()" class="d-flex align-items-center m-2 p-1 text-decoration-none text-danger">';
            echo '<span class="mx-3 fs-5 fw-semibold">Esci</span>';
            echo '</a>';
            break;
    }
    ?>
</header>