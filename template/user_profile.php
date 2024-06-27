<div class="container min-vh-100 d-flex flex-column px-4 <?php if(isset($header_offset)) echo $header_offset ?>">
    <span class="d-none d-md-block fs-4 fw-bold pt-3 text-center"> 
        <?php echo $user["username"] ?> 
    </span>
    <div class="row pt-5">
        <picture class="col-4 text-start text-md-end">
        <img id="profile-picture" src="<?php if ($user["profilePic"] != NULL) {
                        $base64Image = base64_encode($user['profilePic']);
                        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;
                        echo $imageSrc;
                    } else echo 'img/profile.png'; ?>" 
                    alt="Profile Picture" class="img-fluid <?php if ($user["profilePic"] != NULL) echo 'border border-dark rounded-circle' ?>" style="max-height: 200px">
        </picture>
        <div class="col-8 d-flex align-items-center pe-0">
            <div class="row text-center w-100">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center" style="min-width: 33.33%">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numPost"><?php echo $userStats['numPost']; ?></h6>
                        <p class="m-0">Post</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center" style="min-width: 33.33%">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numFollower"><?php echo $userStats['numFollower']; ?></h6>
                        <p class="m-0">Follower</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center" style="min-width: 33.33%">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numFollowed"><?php echo $userStats['numFollowed']; ?></h6>
                        <p class="m-0">Seguiti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 ps-md-5">
        <div class="col-4">
            <p class="text-start mb-0">
                <strong>Informazioni</strong>
            </p>
        </div>
    </div>
    <div class="row ps-md-5">
        <div class="col-12">
            <p class="text-start">
                <?php
                    if($user["info"] !== NULL) echo $user['info'];
                    else echo "Nessuna informazione disponibile.";
                ?>
            </p>
        </div>
    </div>
        
    <div class="row mt-1 justify-content-center">
        <div class="col-6 d-flex justify-content-center">
            <?php
                if ($templateParams["user"] != $_SESSION["idUser"]) {
                    if ($dbh->isFollowing($_SESSION["idUser"], $templateParams["user"])) {
                        echo '<button id="followButton" class="btn btn-danger" aria-label="Smetti di seguire" onclick="unfollow(' . $templateParams["user"] . ')" style="border-radius: 25px">Smetti di seguire</button>';
                    } else {
                        echo '<button id="followButton" class="btn btn-success" aria-label="Segui" onclick="follow(' . $templateParams["user"] . ')" style="border-radius: 25px">Segui</button>';
                    }
                } else {
                    echo '<a href="edit_profile.php" class="btn btn-primary" style="border-radius: 25px">Modifica Profilo</a>';
                }
            ?>
        </div>
    </div>
    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-12 text-center">
            <button id="postsBtn" class="btn mx-2 active" onclick="showSection('posts')" style="border-radius: 25px;
                background-color: rgba(184, 184, 184, 0.4); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">Post</button>
            <button id="subscriptionsBtn" class="btn mx-2" onclick="showSection('subscriptions')" style="border-radius: 25px;
                background-color: rgba(184, 184, 184, 0.4); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">Iscrizioni</button>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="row posts-section">
            <div id="postsContent">
                <?php if (count($userPosts) == 0): ?>
                    <div class="no-content d-flex flex-column align-items-center justify-content-center" style="height: 40vh;">
                        <img src="img/no_image.png" alt="Ancora nessun post" class="img-fluid" style="max-height: 100px">
                        <p class="fw-bold text-center fs-4 mt-2">Ancora nessun post</p>
                    </div>
                    <?php else: 
                        if(isset($templateParams["postList"])){
                            $postList = $userPosts;
                            require($templateParams["postList"]);
                        }
                    ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row subscriptions-section d-none">
            <div id="subscriptionsContent">
                <?php if (count($userSubs) == 0): ?>
                    <div class="no-content d-flex flex-column align-items-center justify-content-center" style="height: 40vh;">
                        <img src="img/no_image.png" alt="Nessuna iscrizione" class="img-fluid" style="max-height: 100px">
                        <p class="fw-bold text-center fs-4 mt-2">Nessuna iscrizione</p>
                    </div>
                    <?php else: 
                        if(isset($templateParams["postList"])){
                            $postList = $userSubs;
                            require($templateParams["postList"]);
                        }
                    ?>    
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
