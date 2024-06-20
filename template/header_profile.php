<header class="d-md-none fixed-top bg-info d-flex justify-content-end overflow-hidden" style="height: 7vh;">
    <div class="col-12 col-md-11 col-lg-9 h-100 d-flex justify-content-between">
        <a href="home.php" class="d-flex align-items-center m-2 p-1">
            <img src="img/back.png" alt="Back" class="img-fluid" style="max-height: 30px"/>
        </a>
        <span class="me-auto d-flex align-items-center m-1"> <?php echo $user["username"] ?> </span>
        <a href="index.php" onclick="logout()" class="d-flex align-items-center m-2 p-1 text-decoration-none text-danger">
            <span class="mx-3 fs-5 fw-semibold">Esci</span>
        </a>
    </div>
</header>
