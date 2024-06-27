<div class="container min-vh-100 d-flex flex-column ps-4 <?php if(isset($header_offset)) echo $header_offset ?>">
<h1 class="d-none d-md-block text-center pt-4">Notifiche</h1>
    <ul class="list-group">
        <?php
        function renderNotifications($title, $notifications) {
            if (count($notifications) > 0) {
                echo "<h2>$title</h2>";
                foreach ($notifications as $notification) {
                    echo '<li class="list-group-item d-flex align-items-center">';
                    // Immagine del profilo con link
                    echo '<a href="user.php?id=' . urlencode($notification['notifier']) . '">';
                    if ($notification['notifier_pic'] != NULL) {
                        $base64Image = base64_encode($notification['notifier_pic']);
                        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;
                        echo '<img src="' . $imageSrc . '" alt="Profile Image" class="img-fluid me-3" style="max-height: 40px;">';
                    } else {
                        echo '<img src="img/profile.png" alt="Profile Image" class="img-fluid me-3" style="max-height: 40px;">';
                    }
                    echo '</a>';
                    echo '<span>';
                    // Nome dell'utente con link
                    echo '<a href="user.php?id=' . htmlspecialchars($notification['notifier_id']) . '" class="fw-bold text-decoration-none text-dark">';
                    echo htmlspecialchars($notification['notifier_username']);
                    echo '</a> ';
                    // Descrizione della notifica
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
                    echo '</span>';
                    echo '</li>';
                }
            }
        }

        renderNotifications("Oggi", $templateParams["notifications"]["today"]);
        renderNotifications("Questa settimana", $templateParams["notifications"]["this_week"]);
        renderNotifications("Questo mese", $templateParams["notifications"]["this_month"]);
        renderNotifications("Prima", $templateParams["notifications"]["earlier"]);
        ?>
    </ul>
</div>