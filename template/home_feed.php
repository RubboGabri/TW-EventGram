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

    .card-img {
        width: 100%;
        height: 200px;
        object-fit: contain; /* Assicura che l'immagine sia completamente visibile */
        padding: 10px; /* Aggiunge spazio interno intorno all'immagine */
    }

    .header-offset {
        margin-top: 60px; /* Aggiungi uno spazio sufficiente per l'header */
        padding-bottom: 60px; /* Aggiungi uno spazio sufficiente per il footer */
    }
</style>

<div class="container min-vh-100 d-flex flex-column ps-4 header-offset">
    <div class="row">
        <?php foreach ($templateParams["posts"] as $post): ?>
            <div class="col-md-4 mb-4">
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
