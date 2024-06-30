<nav class="d-md-none container">
    <ul class="border-top border-dark fixed-bottom navbar-nav d-flex flex-row bg-info justify-content-around" style="height: 7vh;">
        <li class="d-flex justify-content-center align-items-center" style="min-width: 25%;">
            <a href="home.php">
                <img src="../img/home.png" alt="Home" class="img-fluid" style="max-height: 23px">
            </a>
        </li>
        <li class="d-flex justify-content-center align-items-center" style="min-width: 25%;">
            <a href="create.php">
                <img src="../img/create.png" alt="Crea" class="img-fluid" style="max-height: 27px">
            </a>
        </li>
        <li class="d-flex justify-content-center align-items-center" style="min-width: 25%;">
            <a href="search.php">
                <img src="../img/search.png" alt="Search" class="img-fluid" style="max-height: 27px">
            </a>
        </li>
        <li class="d-flex justify-content-center align-items-center position-relative" style="min-width: 25%;">
            <a href="user.php">
                <?php
                $currentUser = $dbh->getUserById($_SESSION["idUser"])[0];
                if ($currentUser["profilePic"] != NULL)
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($currentUser["profilePic"]) . '" alt="Profilo" class="img-fluid border border-dark rounded-circle" style="max-height: 25px">';
                else
                    echo '<img src="../img/profile.png" alt="Profilo" class="img-fluid" style="max-height: 25px">';
                ?>
            </a>
        </li>
    </ul>
</nav>


<nav class="d-none d-md-block">
    <ul class="fixed-top col-1 col-lg-3 border-dark border-end d-flex flex-column bg-info text-dark p-3 navbar-nav" style="height: 100vh;">
        <li class="navbar-item d-flex justify-content-center">
            <img src="../img/logo.png" alt="Logo" class="img-fluid" style="max-height: 120px">
        </li>
        <li class="navbar-item">
            <a href="home.php" class="d-flex align-items-center my-4 p-1 text-decoration-none text-dark">
                <img src="../img/home.png" alt="Home" class="img-fluid" style="max-height: 40px">
                <span class="d-none d-lg-block ms-5 me-5 fs-5 fw-semibold">Home</span>
                <div class="mask rounded" style="background-color: hsla(0, 3%, 6%, 0.2)"></div>
            </a>
        </li>
        <li class="navbar-item position-relative">
            <a href="notification.php" class="d-flex align-items-center my-4 p-1 text-decoration-none text-dark position-relative">
                <img src="../img/notification.png" alt="Notifiche" class="img-fluid" style="max-height: 40px; margin-right: 10px;">
                <span class="d-none d-lg-block ms-5 fs-5 fw-semibold">Notifiche</span>
                <span id="unread-notifications" class="d-none badge rounded-pill bg-danger position-absolute"></span>
                <div class="mask rounded" style="background-color: hsla(0, 3%, 6%, 0.2)"></div>
            </a>
        </li>
        <li class="navbar-item">
            <a href="create.php" class="d-flex align-items-center my-4 p-1 text-decoration-none text-dark">
                <img src="../img/create.png" alt="Crea" class="img-fluid" style="max-height: 40px">
                <span class="d-none d-lg-block ms-5 me-5 fs-5 fw-semibold">Crea</span>
                <div class="mask rounded" style="background-color: hsla(0, 3%, 6%, 0.2)"></div>
            </a>
        </li>
        <li class="navbar-item">
            <a href="user.php" class="d-flex align-items-center my-4 p-1 text-decoration-none text-dark">
                <?php
                $currentUser = $dbh->getUserById($_SESSION["idUser"])[0];
                if ($currentUser["profilePic"] != NULL)
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($currentUser["profilePic"]) . '" alt="Profilo" class="img-fluid border border-dark rounded-circle" style="max-height: 40px">';
                else
                    echo '<img src="../img/profile.png" alt="Profilo" class="img-fluid" style="max-height: 40px">';
                ?>
                <span class="d-none d-lg-block ms-5 me-5 fs-5 fw-semibold">Profilo</span>
                <div class="mask rounded" style="background-color: hsla(0, 3%, 6%, 0.2)"></div>
            </a>
        </li>
        <li class="navbar-item">
            <a href="index.php" onclick="logout()" class="d-flex align-items-center my-4 p-1 text-decoration-none text-dark">
                <img src="../img/logout.PNG" alt="Esci" class="img-fluid" style="max-height: 40px">
                <span class="d-none d-lg-block ms-5 me-5 fs-5 fw-semibold">Esci</span>
                <div class="mask rounded" style="background-color: hsla(0, 3%, 6%, 0.2)"></div>
            </a>
        </li>
    </ul>
</nav>