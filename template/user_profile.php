<div class="container min-vh-100 d-flex flex-column ps-4 <?php if(isset($header_offset)) echo $header_offset ?>">
    <span class="d-none d-md-block fs-4 fw-bold pt-3 text-center"> 
        <?php echo $user["username"] ?> 
    </span>
    <div class="row w-100 pt-5">
        <picture class="col-4 text-start text-md-end">
            <img src="<?php if ($user["profilePic"] != NULL) {
                                $base64Image = base64_encode($user['profilePic']);
                                $imageSrc = 'data:image/jpeg;base64,' . $base64Image;
                                echo $imageSrc;
                            } else echo 'img/profile.png'; ?>" 
                        alt="Profile Picture" class="img-fluid" style="max-height: 200px">
        </picture>
        <div class="col-8 d-flex align-items-center pe-0">
            <div class="row text-center w-100">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numPost"><?php echo $userStats['numPost']; ?></h6>
                        <p class="m-0">Post</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numFollower"><?php echo $userStats['numFollower']; ?></h6>
                        <p class="m-0">Follower</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0" id="numFollowed"><?php echo $userStats['numFollowed']; ?></h6>
                        <p class="m-0">Seguiti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mt-5 ps-md-5">
        <div class="col-4">
            <p class="text-start mb-0">
                <strong>Informazioni</strong>
            </p>
        </div>
    </div>
    <div class="row w-100 ps-md-5">
        <div class="col-12">
            <p class="text-start">
                <?php
                    if($user["info"] !== NULL) echo $user['info'];
                    else echo "Nessuna informazione disponibile.";
                ?>
            </p>
        </div>
    </div>
        
    <div class="row w-100 mt-1 ps-md-5">
        <div class="col-8">
            <?php
                if ($templateParams["user"] != $_SESSION["idUser"]) {
                    if ($dbh->isFollowing($_SESSION["IDuser"], $templateParams["user"])) {
                        echo '<button class="btn btn-danger" aria-label="Smetti di seguire" onclick="unfollow(' . $_SESSION["IDuser"] . ', ' . $templateParams["user"] . ')">
                                Smetti di seguire
                            </button>';
                    } else {
                        echo '<button class="btn btn-success" aria-label="Segui" onclick="follow(' . $_SESSION["IDuser"] . ', ' . $templateParams["user"] . ')">
                                Segui
                            </button>';
                    }
                } else {
                    echo '<a href="edit_profile.php" class="btn btn-primary">Modifica Profilo</a>';
                }
            ?>
        </div>
    </div>
    <div class="row w-100 mt-3 ps-md-5">
        <div class="col-4">
            <p class="text-start">
                <strong>Post</strong>
            </p>
            <div class="row">
                <?php foreach ($userPosts as $post): ?>
                    <div class="col-4 mb-4">
                        <a href="post.php?id=<?php echo $post['IDpost']; ?>">
                            <img src="<?php echo $post['img']; ?>" alt="Post Image" class="img-fluid">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
