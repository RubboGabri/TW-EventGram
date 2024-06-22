<div class="container min-vh-100 d-flex flex-column ps-4">
    <h1>Notifiche</h1>
    <ul class="list-group">
        <?php if (count($templateParams["notifications"]) > 0): ?>
            <?php foreach ($templateParams["notifications"] as $notification): ?>
                <li class="list-group-item d-flex align-items-center">
                    <!-- Immagine del profilo -->
                    <img src="img/profile.png" alt="Profile Image" class="img-fluid me-3" style="max-height: 40px;">
                    <!-- Testo della notifica -->
                    <span>
                        <!-- Nome dell'utente -->
                        <span class="fw-bold text-dark">
                            <?php echo htmlspecialchars($notification['notifier_username']); ?>
                        </span>
                        <!-- Descrizione della notifica -->
                        <?php
                            switch ($notification['type']) {
                                case 'Comment':
                                    echo " ha commentato il tuo post ";
                                    if (!empty($notification['IDpost'])) {
                                        echo "con ID " . htmlspecialchars($notification['IDpost']);
                                    }
                                    break;
                                case 'Like':
                                    echo " ha messo mi piace al tuo post ";
                                    if (!empty($notification['IDpost'])) {
                                        echo "con ID " . htmlspecialchars($notification['IDpost']);
                                    }
                                    break;
                                case 'Follow':
                                    echo " ha iniziato a seguirti";
                                    break;
                                case 'Post':
                                    echo " ha pubblicato un nuovo post ";
                                    if (!empty($notification['IDpost'])) {
                                        echo "con ID " . htmlspecialchars($notification['IDpost']);
                                    }
                                    break;
                                default:
                                    echo " tipo di notifica sconosciuto";
                                    break;
                            }
                        ?>
                    </span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">Nessuna notifica trovata.</li>
        <?php endif; ?>
    </ul>
</div>