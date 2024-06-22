<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-8 col-lg-6 p-5 text-center">
        <form action="#" method="POST" class="p-0 m-0">
            <?php
                if(isset($templateParams["title"]) && $templateParams["title"] == "Login - EventGram") {
                    echo '<div class="d-flex justify-content-center mb-4">
                                <img src="img/logo.PNG" alt="Logo" style="width: 200px; height: auto;">
                          </div>';
                }
            ?>
            <p class="text-danger"></p>
            <div class="form-group mb-3">
                <label for="username" class="fs-6 fw-semibold d-block text-start">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="fs-6 fw-semibold d-block text-start">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <input type="submit" name="submit" value="Login" class="btn btn-custom w-100">
            </div>
        </form>
        <section class="mt-5">
            <span>Don't have an account? </span>
            <h2 class="d-none">Login Section</h2>
            <a href="register.php" class="link-primary">Register</a>
        </section> 
    </div>
</div>