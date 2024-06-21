<div class="container min-vh-100 d-flex flex-column ps-4">
    <span class="d-none d-md-block fs-4 fw-bold pt-3 text-center"> 
        <?php echo $user["username"] ?> 
    </span>
    <div class="row w-100 pt-5">
        <div class="col-4 text-start text-md-end">
            <img src="<?php if ($templateParams["user"]["profilePic"] != NULL) echo $userData['profilePic']; else echo 'img/profile.png'; ?>" 
                 alt="Profile Picture" class="img-fluid" style="max-height: 100px">
        </div>
        <div class="col-8 d-flex align-items-center pe-0">
            <div class="row text-center w-100">
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0"><?php echo $userStats['numPost']; ?></h6>
                        <p class="m-0">Post</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0"><?php echo $userStats['numFollower']; ?></h6>
                        <p class="m-0">Follower</p>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-column justify-content-between h-100 text-center">
                        <h6 class="m-0"><?php echo $userStats['numFollowed']; ?></h6>
                        <p class="m-0">Seguiti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mt-3">
        <div class="col-4"></div>
        <div class="col-8">
            <p><strong>Informazioni</strong></p>
            <p><?php echo nl2br(htmlspecialchars($userData['bio'])); ?></p>
        </div>
    </div>
    <div class="row w-100 mt-2">
        <div class="col-4"></div>
        <div class="col-8 text-center">
            <button class="btn btn-success">
                Segui
            </button>
        </div>
    </div>
    <div class="row w-100 mt-3">
        <div class="col-4">
            <p class="text-start text-md-center">
                <strong>Post</strong>
            </p>
            <div class="row">
                <?php foreach ($userPosts as $post): ?>
                    <div class="col-4 mb-4">
                        <a href="post.php?id=<?php echo $post['IDpost']; ?>">
                            <img src="<?php echo $post['post_image']; ?>" alt="Post Image" class="img-fluid">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
