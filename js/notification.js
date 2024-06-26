document.addEventListener("DOMContentLoaded", async function() {
    const notificationsList = document.getElementById("notifications");

    try {
        const response = await axios.get('utils/api.php?op=getNotifications');
        const groupedNotifications = response.data;

        // Funzione per creare un elemento di lista per una notifica
        function createNotificationItem(notification) {
            const listItem = document.createElement("li");
            listItem.className = "list-group-item d-flex align-items-center";

            const imgLink = document.createElement("a");
            imgLink.href = `template/user_profile.php?id=${notification.notifier}`;

            const img = document.createElement("img");
            img.src = "img/profile.png";
            img.alt = "Profile Image";
            img.className = "img-fluid me-3";
            img.style.maxHeight = "40px";

            imgLink.appendChild(img);

            const notificationText = document.createElement("span");

            const usernameLink = document.createElement("a");
            usernameLink.href = `template/user_profile.php?id=${notification.notifier}`;
            usernameLink.textContent = notification.notifier_username;
            usernameLink.className = "fw-bold text-decoration-none text-dark";

            switch (notification.type) {
                case 'Comment':
                    notificationText.append(usernameLink, ` ha commentato il tuo post ${notification.IDpost}`);
                    break;
                case 'Like':
                    notificationText.append(usernameLink, ` ha messo mi piace al tuo post ${notification.IDpost}`);
                    break;
                case 'Follow':
                    notificationText.append(usernameLink, ` ha iniziato a seguirti`);
                    break;
                case 'Post':
                    notificationText.append(usernameLink, ` ha pubblicato un nuovo post`);
                    break;
                default:
                    notificationText.append("tipo di notifica sconosciuto");
            }

            listItem.appendChild(imgLink);
            listItem.appendChild(notificationText);
            return listItem;
        }

        // Aggiungi le notifiche alla lista, raggruppate per periodo di tempo
        function addGroupedNotifications(groupTitle, notifications) {
            if (notifications.length > 0) {
                const groupTitleElement = document.createElement("h4");
                groupTitleElement.textContent = groupTitle;
                notificationsList.appendChild(groupTitleElement);

                notifications.forEach(notification => {
                    notificationsList.appendChild(createNotificationItem(notification));
                });
            }
        }

        addGroupedNotifications("Oggi", groupedNotifications.today);
        addGroupedNotifications("Questa settimana", groupedNotifications.lastWeek);
        addGroupedNotifications("Questo mese", groupedNotifications.lastMonth);
        addGroupedNotifications("Prima", groupedNotifications.earlier);

    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
});