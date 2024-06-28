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
            imgLink.href = `user.php?id=${notification.notifier}`;
            imgLink.className = ''

            const img = document.createElement("img");
            if(notification.notifier_pic) {
                img.src = `data:image/jpeg;base64,${notification.notifier_pic}`;
            } else {
                img.src = "img/profile.png";
            }
            img.alt = "Profile Image";
            img.className = "img-fluid rounded-circle";
            img.style.maxHeight = "40px";

            imgLink.appendChild(img);

            const notificationText = document.createElement("span");
            notificationText.className = "w-75 text-start ps-3";
            const usernameLink = document.createElement("a");
            usernameLink.href = `user.php?id=${notification.notifier}`;
            usernameLink.textContent = notification.notifier_username;
            usernameLink.className = "fw-bold text-decoration-none text-dark";

            switch (notification.type) {
                case 'Comment':
                    notificationText.append(usernameLink, ` ha commentato il tuo post "${notification.post_title || ''}"`);
                    break;
                case 'Like':
                    notificationText.append(usernameLink, ` ha messo mi piace al tuo post "${notification.post_title || ''}"`);
                    break;
                case 'Follow':
                    notificationText.append(usernameLink, ` ha iniziato a seguirti`);
                    break;
                case 'Post':
                    notificationText.append(usernameLink, ` ha pubblicato un nuovo post "${notification.post_title || ''}"`);
                    break;
                case 'Subscribe':
                    /*ownerLink.href = `user.php?id=${notification.post_owner_id}`;
                    ownerLink.textContent = notification.post_owner_username;
                    ownerLink.className = "fw-bold text-decoration-none text-dark";

                    notificationText.append(usernameLink, ` si è iscritto al questo post "${notification.post_title || ''}" di `, ownerLink);*/
                    notificationText.append(usernameLink, ` si è iscritto a questo post "${notification.post_title || ''}"`);
                    break;
                default:
                    notificationText.append(" tipo di notifica sconosciuto");
            }

            listItem.appendChild(imgLink);
            listItem.appendChild(notificationText);
            return listItem;
        }

        // Aggiungi le notifiche alla lista, raggruppate per periodo di tempo
        function addGroupedNotifications(groupTitle, notifications) {
            if (notifications.length > 0) {
                const groupTitleElement = document.createElement("h4");
                groupTitleElement.className = "text-center py-2";
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
