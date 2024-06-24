<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.5rem;
    }

    .card-subtitle {
        font-size: 1.25rem;
    }

    .card-text {
        font-size: 1.25rem;
    }

    .card-footer {
        font-size: 1.25rem;
    }
    .card-link { 
        text-decoration: none;
    }
</style>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row">
        <?php foreach ($templateParams["posts"] as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                <div class="post-header" style = "padding : 20px;margin: 3px;">
                <div class="d-flex align-items-center">
                    <img src="img/profile.png" alt="Profile" class="img-fluid" style="max-height: 20px; margin-right: 5px;"/>
                    <span style="font-weight: bold;"><?php echo htmlspecialchars($post['username']); ?></span>
                </div>
                    </div>
                    <?php if ($post['img']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($post['location']); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($post['description']); ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($post['eventDate']); ?></small></p>
                        <p class="card-text">Luogo: <?php echo htmlspecialchars($post['location']); ?></p>
                        <p class="card-text">Categoria: <?php echo htmlspecialchars($post['category']); ?></p>
                        <p class="card-text">Prezzo: <?php echo htmlspecialchars($post['price']); ?>€</p>
                        <p class="card-text">Età minima: <?php echo htmlspecialchars($post['minAge']); ?> anni</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            <a href="#" class="card-link">
                                <img src="img/like_outlined.png" alt="Like" class="img-fluid" style="max-height: 20px"/>
                                <span><?php echo htmlspecialchars($post['numLikes']); ?></span>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="card-link">
                                <img src="img/comment.png" alt="Comment" class="img-fluid" style="max-height: 20px"/>
                                <span><?php echo htmlspecialchars($post['numComments']); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
