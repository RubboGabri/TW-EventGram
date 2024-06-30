document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search");
    const searchButton = document.getElementById("search-button");
    const searchResults = document.getElementById("search-results");
    const suggestedUsersContainer = document.getElementById("suggested-users");
 
    function createUserItem(user) {
        const userItem = document.createElement("div");
        userItem.className = "user-item d-flex align-items-center my-2";
 
        const imgLink = document.createElement("a");
        imgLink.href = `user.php?id=${user.IDuser}`;
 
        const img = document.createElement("img");
        if (user.profilePic) {
            img.src = `data:image/jpeg;base64,${user.profilePic}`;
            img.className = "img-fluid border border-dark rounded-circle";
        } else {
            img.src = "img/profile.png";
            img.className = "img-fluid";
        }
        img.alt = "Profile Image";
        img.style.maxHeight = "40px";
 
        imgLink.appendChild(img);
 
        const username = document.createElement("span");
        username.className = "ms-3";
        const usernameLink = document.createElement("a");
        usernameLink.href = `user.php?id=${user.IDuser}`;
        usernameLink.textContent = user.username;
        usernameLink.className = "fw-bold text-decoration-none text-dark";
 
        userItem.appendChild(imgLink);
        userItem.appendChild(username);
        username.appendChild(usernameLink);
        return userItem;
    }
 
    async function loadSuggestedUsers() {
        try {
            const response = await axios.get('utils/api.php?op=getSuggestedUsers');
            const users = response.data;
 
            suggestedUsersContainer.innerHTML = ""; // Clear previous results
            if (users.length > 0) {
                users.forEach(user => {
                    suggestedUsersContainer.appendChild(createUserItem(user));
                });
            } else {
                suggestedUsersContainer.innerHTML = "<p>No suggestions found</p>";
            }
        } catch (error) {
            console.error('Error fetching suggested users:', error);
        }
    }
 
    searchButton.addEventListener("click", async function () {
        const query = searchInput.value.trim();
 
        if (query.length > 0) {
            try {
                const response = await axios.get(`utils/api.php?op=searchUsers&query=${encodeURIComponent(query)}`);
                const users = response.data;
 
                searchResults.innerHTML = ""; // Clear previous results
                if (users.length > 0) {
                    users.forEach(user => {
                        searchResults.appendChild(createUserItem(user));
                    });
                } else {
                    searchResults.innerHTML = "<p>Nessun utente trovato.</p>";
                }
            } catch (error) {
                console.error('Error fetching search results:', error);
            }
        } else {
            searchResults.innerHTML = ""; // Clear results if query is empty
        }
    });
 
    // Carica gli utenti suggeriti al caricamento della pagina
    loadSuggestedUsers();
});
 