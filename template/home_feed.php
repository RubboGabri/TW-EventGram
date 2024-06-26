<div class="container d-flex justify-content-center align-items-center min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="row pt-5">
        <?php foreach ($templateParams["posts"] as $post): ?>
            <div class="col-md-4 pb-5">
                <div class="card">
                    <div class="post-header" style="padding: 20px; margin: 3px;">
                        <div class="d-flex align-items-center">
                            <?php if ($post['profilePic'] != NULL): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($post['profilePic']); ?>" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                            <?php else: ?>
                                <img src="img/profile.png" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                            <?php endif; ?>
                            <span style="font-weight: bold;"><?php echo htmlspecialchars($post['username']); ?></span>
                        </div>
                    </div>
                    <?php if ($post['img']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top card-img" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body" style="padding: 20px;">
                        <h5 class="card-title" style="margin-bottom: 30px; font-size: 30px;"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 30px;">Luogo: <?php echo htmlspecialchars($post['location']); ?></h6>
                        <p class="card-text" style="margin-top: 20px; font-weight: bold;"><?php echo htmlspecialchars($post['description']); ?></p>
                        <p class="card-text"><small class="text-muted">Data Evento: <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small></p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            <a href="#" class="card-link" style="display: flex; align-items: center;">
                                <img src="img/like_outlined.png" alt="Like" class="img-fluid" style="max-height: 20px"/>
                                <span style="color: #000000; margin-left: 5px;"><?php echo htmlspecialchars($post['numLikes']); ?></span>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="card-link" style="display: flex; align-items: center;">
                                <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 20px;"/>
                                <span style="color: #000000; margin-left: 5px;"><?php echo htmlspecialchars($post['numComments']); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
