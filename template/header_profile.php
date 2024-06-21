<header class="d-md-none fixed-top bg-info d-flex justify-content-between align-items-center overflow-hidden" style="height: 7vh;">
    <a href="home.php" class="d-flex align-items-center m-2 p-1">
        <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/>
    </a>
    <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center fs-4 fw-bold"> 
        <?php echo $user["username"] ?> 
    </span>
    <a href="index.php" onclick="logout()" class="d-flex align-items-center m-2 p-1 text-decoration-none text-danger">
        <span class="mx-3 fs-5 fw-semibold">Esci</span>
    </a>
</header>
