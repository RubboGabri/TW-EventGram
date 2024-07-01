<?php foreach ($postList as $post): ?>
    <div class="col-12 pb-5">
        <div class="card" data-post-id="<?php echo $post['IDpost']; ?>">
            <div class="post-header py-2 px-3">
                <div class="d-flex align-items-center">
                    <a href="user.php?id=<?php echo urlencode($post["IDuser"]); ?>" class="fw-bold text-decoration-none text-dark">
                        <?php if ($post['profilePic'] != NULL): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($post['profilePic']); ?>" alt="Profile picture" class="img-fluid border border-dark rounded-circle" style="max-height: 40px;">
                        <?php else: ?>
                            <img src="../img/profile.png" alt="Profile picture" class="img-fluid" style="max-height: 40px;">
                        <?php endif; ?>
                        <span class="fw-bold ps-2"><?php echo htmlspecialchars($post['username']); ?></span>
                    </a>
                </div>
            </div>
            <?php if ($post['img']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img px-2" style="border-radius: 25px" alt="<?php echo htmlspecialchars($post['title']); ?>">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title" style="font-size: 30px;"><?php echo htmlspecialchars($post['title']); ?></h5>
                <h6 class="card-subtitle fs-5 mb-1 text-muted">Luogo: <?php echo htmlspecialchars($post['location']); ?></h6>
                <p class="card-text fs-5 mb-1">
                    <small class="text-muted">Data Evento: <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small>
                </p>
                <button class="btn btn-link p-0 text-decoration-none details-btn">
                    <img src="../img/more.png" alt="Espandi" style="height: 25px;">
                </button>
                <?php
                    if(isset($templateParams["post_details"])) {
                        require($templateParams["post_details"]);
                    }
                    if(isset($templateParams["comment_page"])) {
                        require($templateParams["comment_page"]);
                    }
                ?>
            </div>
            <div class="d-flex justify-content-between card-footer fs-5">
                <div>
                    <a href="javascript:void(0)" class="card-link d-flex align-items-center text-decoration-none like-btn" data-post-id="<?php echo $post['IDpost']; ?>">
                        <?php
                            if ($dbh->isLiking($post["IDpost"], $_SESSION["idUser"]))
                                echo '<img src="../img/like_red.png" alt="Like" class="img-fluid like-icon" style="max-height: 25px"> ';
                            else
                                echo '<img src="../img/like_empty.png" alt="Like" class="img-fluid like-icon" style="max-height: 25px"> ';
                        ?>
                        <span class="like-count ms-1 text-dark"><?php echo htmlspecialchars($post['numLikes']); ?></span>
                    </a>
                </div>
                <div>
                    <a href="javascript:void(0)" class="card-link d-flex align-items-center text-decoration-none comment-btn" data-post-id="<?php echo $post['IDpost']; ?>">
                        <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 22px;">
                        <span class="comment-count ms-1 text-dark" data-post-id="<?php echo $post['IDpost']; ?>"><?php echo htmlspecialchars($post['numComments']); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
