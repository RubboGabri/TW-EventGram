<div class="container d-flex justify-content-center align-items-center px-4 min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="col col-md-6 mx-auto pt-5">
        <?php
            if(isset($templateParams["postList"])){
                $postList = $templateParams["posts"];
                require($templateParams["postList"]);
            }
        ?>
    </div>
</div>
 