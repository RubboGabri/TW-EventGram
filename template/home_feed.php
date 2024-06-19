<style>
        .header {
            background-color: #6f42c1; /* Colore viola */
            border-bottom: 1px solid #e0e0e0;
        }
</style>
<header class="header">
    <?php
    if(isset($templateParams["sidebar"])){
        require($templateParams["sidebar"]);
    }
    ?>
</header>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-8 col-lg-6 p-5 text-center">
        <form action="#" method="POST" class="p-0 m-0">
            <div class="d-flex justify-content-center mb-4">
                <img src="img/logo.PNG" alt="Logo" style="width: 200px; height: auto;">
            </div>
            <p class="text-danger"></p>
            <div class="form-group mb-3">
                <label for="homefeed" class="fs-6 fw-semibold d-block text-start">homefeed:</label>
                <input type="text" id="username" name="username" placeholder="Username" class="form-control"/>
            </div>
        </form>
    </div>
</div>
