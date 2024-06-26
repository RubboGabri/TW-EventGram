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
                <?php else: ?>
                    <?php foreach ($userPosts as $post): ?>
                        <div class="col-md-4 pb-5">
                            <div class="card">
                                <div class="post-header" style="padding: 20px; margin: 3px;">
                                    <div class="d-flex align-items-center">
                                        <a href="user.php?id=<?php echo $post['IDuser']; ?>" class="fw-bold text-decoration-none text-dark">
                                            <img src="img/profile.png" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                                            <span><?php echo htmlspecialchars($post['username']); ?></span>
                                        </a>
                                    </div>
                                </div>
                                <?php if ($post['img']): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                <?php endif; ?>
                                <div class="card-body" style="padding: 20px;">
                                    <h5 class="card-title" style="margin-bottom: 30px; font-size: 30px;"><?php echo htmlspecialchars($post['title']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 30px;">Luogo: <?php echo htmlspecialchars($post['location']); ?></h6>
                                    <p class="card-text" style="margin-top: 20px; font-weight: bold;"><?php echo htmlspecialchars($post['description']); ?></p>
                                    <p class="card-text"><small class="text-muted">Data Evento: <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small></p>
                                    <p class="card-text">Categoria: <?php echo htmlspecialchars($post['category']); ?></p>
                                    <p class="card-text">Prezzo: <?php echo htmlspecialchars($post['price']); ?>€</p>
                                    <p class="card-text">Età minima: <?php echo htmlspecialchars($post['minAge']); ?> anni</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="card-link d-flex align-items-center">
                                            <img src="img/like_outlined.png" alt="Like" class="img-fluid" style="max-height: 20px"/>
                                            <span class="ms-1"><?php echo htmlspecialchars($post['numLikes']); ?></span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="card-link d-flex align-items-center">
                                            <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 20px"/>
                                            <span class="ms-1"><?php echo htmlspecialchars($post['numComments']); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row subscriptions-section d-none">
            <div id="subscriptionsContent">
                <?php if (count($userSubcriptions) == 0): ?>
                    <div class="no-content d-flex flex-column align-items-center justify-content-center" style="height: 40vh;">
                        <img src="img/no_image.png" alt="Nessuna iscrizione" class="img-fluid" style="max-height: 100px">
                        <p class="fw-bold text-center fs-4 mt-2">Nessuna iscrizione</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($userSubcriptions as $post): ?>
                        <div class="col-md-4 pb-5">
                            <div class="card">
                                <div class="post-header" style="padding: 20px; margin: 3px;">
                                    <div class="d-flex align-items-center">
                                        <a href="user.php?id=<?php echo $post['IDuser']; ?>" class="fw-bold text-decoration-none text-dark">
                                            <img src="img/profile.png" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                                            <span><?php echo htmlspecialchars($post['username']); ?></span>
                                        </a>
                                    </div>
                                </div>
                                <?php if ($post['img']): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                <?php endif; ?>
                                <div class="card-body" style="padding: 20px;">
                                    <h5 class="card-title" style="margin-bottom: 30px; font-size: 30px;"><?php echo htmlspecialchars($post['title']); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 30px;">Luogo: <?php echo htmlspecialchars($post['location']); ?></h6>
                                    <p class="card-text" style="margin-top: 20px; font-weight: bold;"><?php echo htmlspecialchars($post['description']); ?></p>
                                    <p class="card-text"><small class="text-muted">Data Evento: <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small></p>
                                    <p class="card-text">Categoria: <?php echo htmlspecialchars($post['category']); ?></p>
                                    <p class="card-text">Prezzo: <?php echo htmlspecialchars($post['price']); ?>€</p>
                                    <p class="card-text">Età minima: <?php echo htmlspecialchars($post['minAge']); ?> anni</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="card-link d-flex align-items-center">
                                            <img src="img/like_outlined.png" alt="Like" class="img-fluid" style="max-height: 20px"/>
                                            <span class="ms-1"><?php echo htmlspecialchars($post['numLikes']); ?></span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="card-link d-flex align-items-center">
                                            <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 20px"/>
                                            <span class="ms-1"><?php echo htmlspecialchars($post['numComments']); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
