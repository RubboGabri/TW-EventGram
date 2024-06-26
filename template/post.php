<?php foreach ($postList as $post): ?>
    <div class="col-md-4 pb-5">
        <div class="card">
            <div class="post-header p-3">
                <div class="d-flex align-items-center">
                    <a href="user.php?id=<?php echo urlencode($post["IDuser"]); ?>" class="fw-bold text-decoration-none text-dark">
                        <?php if ($post['profilePic'] != NULL): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($post['profilePic']); ?>" alt="Profile picture" class="img-fluid" style="max-height: 20px; margin-right: 3px;"/>
                        <?php else: ?>
                            <img src="../img/profile.png" alt="Profile picture" class="img-fluid" style="max-height: 20px; margin-right: 3px;"/>
                        <?php endif; ?>
                        <span style="font-weight: bold;"><?php echo htmlspecialchars($post['username']); ?></span>
                    </a>
                </div>
            </div>
            <?php if ($post['img']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top card-img" alt="<?php echo htmlspecialchars($post['title']); ?>">
            <?php endif; ?>
            <div class="card-body p-3 py-2">
                <h5 class="card-title mb-2" style="font-size: 30px;"><?php echo htmlspecialchars($post['title']); ?></h5>
                <h6 class="card-subtitle mb-1 text-muted">Luogo: <?php echo htmlspecialchars($post['location']); ?></h6>
                <p class="card-text"><small class="text-muted">Data Evento: <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small></p>
            </div>
            <div class="d-flex justify-content-between card-footer">
                <div>
                    <a href="javascript:void(0)" class="card-link d-flex align-items-center text-decoration-none like-btn" data-post-id="<?php echo $post['IDpost']; ?>">
                        <?php
                            if ($dbh->isLiking($post["IDpost"], $_SESSION["idUser"]))
                                echo '<img src="../img/like_red.png" alt="Like" class="img-fluid like-icon" style="max-height: 20px"/> ';
                            else
                                echo '<img src="../img/like_empty.png" alt="Like" class="img-fluid like-icon" style="max-height: 20px"/> ';
                        ?>
                        <span class="like-count" style="color: #000000; margin-left: 5px;"><?php echo htmlspecialchars($post['numLikes']); ?></span>
                    </a>
                </div>
                <div>
                    <a href="#" class="card-link d-flex align-items-center text-decoration-none">
                        <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 20px;"/>
                        <span style="color: #000000; margin-left: 5px;"><?php echo htmlspecialchars($post['numComments']); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
