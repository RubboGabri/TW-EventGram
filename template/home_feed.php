<div class="container d-flex justify-content-center align-items-center min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="row pt-5">
        <?php foreach ($templateParams["posts"] as $post): ?>
            <div class="col-md-4 pb-5">
                <div class="card">
                <div class="post-header" style = "padding : 20px;margin: 3px;">
                <div class="d-flex align-items-center">
                    <a href="user.php?id=<?php echo urlencode($post["IDuser"]); ?>" class="fw-bold text-decoration-none text-dark">
                        <img src="img/profile.png" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                        <span>
                            <?php echo htmlspecialchars($post['username']); ?>
                        </span>
                    </a>
                </div>
                    </div>
                    <?php if ($post['img']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body" style="padding: 20px;">
                        <h5 class="card-title" style="margin-bottom: 30px;font-size : 30px"> <!-- Aumenta questo valore per più spazio -->
                            <?php echo htmlspecialchars($post['title']); ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted" style="margin-top: 30px;"> <!-- Aumenta questo valore per più spazio -->
                            Luogo: <?php echo htmlspecialchars($post['location']); ?>
                        </h6>
                        <p class="card-text" style = "margin-top : 20px;font-weight:bold;"><?php echo htmlspecialchars($post['description']); ?></p>
                        <p class="card-text"><small class="text-muted">Data Evento : <?php echo date('Y-m-d H:i', strtotime($post['eventDate'])); ?></small></p>
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
    </div>
</div>
