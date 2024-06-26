document.addEventListener("DOMContentLoaded", function() {
    const unreadNotificationsSpans = document.querySelectorAll(".unread-notifications");

    function updateUnreadNotificationCount() {
        axios.get('utils/api.php?op=getUnreadNotificationCount')
            .then(response => {
                const count = response.data.unread_count;
                unreadNotificationsSpans.forEach(unreadNotificationsSpan => {
                    if (count > 0) {
                        unreadNotificationsSpan.textContent = count > 99 ? '99+' : count;
                        unreadNotificationsSpan.classList.remove('d-none');
                    } else {
                        unreadNotificationsSpan.classList.add('d-none');
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching unread notification count:', error);
            });
    }

    // Update the notification count every 30 seconds
    setInterval(updateUnreadNotificationCount, 30000);
    // Initial call to display the count on page load
    updateUnreadNotificationCount();
});
