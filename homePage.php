<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventGram Homepage</title>
    <link rel="stylesheet" href="css/homePageStyle.css">
</head>
<body>
    <div class="sidebar">
        <img src="img/logo.PNG" alt="EventGram Logo" class="sidebar-logo">
        <h1></h1>
        <nav>
            <ul>
            <li class="d-flex justify-content-center p-2 navbar-item" style="min-width: 20%">
                    <a href="home.php"><img src="img/home.png" alt="Home" class="img-fluid" style="max-height: 50px"/></a>
                </li>
                <li>
                    <img src="img/notification.png" alt="Notifiche" class="icon" title="Notifiche"><span>Notifiche</span>
                </li>
                <li>
                    <img src="img/create.png" alt="Crea" class="icon" title="Crea"><span>Crea</span>
                </li>
                <li>
                    <img src="img/profile.png" alt="Profilo" class="icon" title="Profilo"><span>Profilo</span>
                </li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <section class="event">
            <div class="event-header">
                <div class="event-profile">
                    <img src="img/profile.png" alt="Profile" class="profile-icon">
                    <h2>Rock Planet</h2>
                </div>
                <h3>Mamacita</h3>
            </div>
            <div class="event-details">
                <div class="event-image">
                    <!-- Image placeholder -->
                </div>
                <div class="event-info">
                    <span class="date">GG/MM/YYYY</span>
                    <div class="event-stats">
                        <span class="likes">21 <img src="img/like_outlined.png" alt="Like" class="like-icon"></span>
                        <span class="comments">12 <img src="img/comment.png" alt="Comment" class="comments-icon"></span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
