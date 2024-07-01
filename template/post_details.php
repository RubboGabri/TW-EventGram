<div class="post-details d-none">
    <p class="card-text mb-1">Descrizione: <?php echo htmlspecialchars($post['description']); ?></p>
    <p class="card-text text-muted mb-1">Categoria: <?php echo htmlspecialchars($post['category']); ?></p>
    <p class="card-text text-muted mb-1">Prezzo: <?php echo htmlspecialchars($post['price']); ?> €</p>
    <p class="card-text text-muted mb-3">Età minima: 
        <?php
        if ($post['minAge'] != null) {
            echo htmlspecialchars($post['minAge']) . " anni";
        } else {
            echo "Nessuna";
        }
        ?>
    </p>
    <?php
        $isSubscribed = $dbh->isSubscribed($post['IDpost'], $_SESSION["idUser"]);
        $buttonText = $isSubscribed ? "Disiscriviti" : "Iscriviti";
        $buttonClass = $isSubscribed ? "btn-danger" : "btn-primary";
    ?>
    <button class="btn <?php echo $buttonClass; ?> subscribe-btn" data-post-id="<?php echo $post['IDpost']; ?>"><?php echo $buttonText; ?></button>
</div>