<?php
require_once 'DatabaseHelper.php';

// Connessione al database
$db = new DatabaseHelper('localhost', 'your_username', 'your_password', 'eventgramdb', 3306);

// Recupero dei post dal database
$posts = $db->getAllPosts();
?>

<h2>Eventi Recenti</h2>
<div class="posts">
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($post['description']); ?></p>
                <?php if ($post['img']): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['img']); ?>" class="card-img-top" alt="Post Image">
                <?php endif; ?>
                <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($post['eventDate']); ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
