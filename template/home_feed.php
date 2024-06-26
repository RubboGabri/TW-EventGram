<div class="container d-flex justify-content-center align-items-center min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="row pt-5">
        <?php
            if(isset($templateParams["postList"])){
                $postList = $templateParams["posts"];
                require($templateParams["postList"]);
            }
        ?>
    </div>
</div>
