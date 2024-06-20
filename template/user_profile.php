<div class="container min-vh-100">
    <div class="row">
        <div class="col-8 text-center">
            <h4><?php echo htmlspecialchars($userData['username']); ?></h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-4 text-center">
            <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" class="img-thumbnail" style="width: 100px; height: 100px;">
        </div>
        <div class="col-8">
            <div class="row text-center">
                <div class="col-4">
                    <h6><?php echo $userStat['posts_count']; ?></h6>
                    <p>Post</p>
                </div>
                <div class="col-4">
                    <h6><?php echo $userStat['followers_count']; ?></h6>
                    <p>Follower</p>
                </div>
                <div class="col-4">
                    <h6><?php echo $userStat['following_count']; ?></h6>
                    <p>Seguiti</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <p><strong>Informazioni</strong></p>
            <p><?php echo nl2br(htmlspecialchars($userData['bio'])); ?></p>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 text-center">
            <button class="btn btn-success">
                Segui
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <p><strong>Post</strong></p>
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
