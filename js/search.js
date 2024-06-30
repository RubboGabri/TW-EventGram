document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search");
    const searchButton = document.getElementById("search-button");
    const searchResults = document.getElementById("search-results");

    searchButton.addEventListener("click", async function () {
        const query = searchInput.value.trim();

        if (query.length > 0) {
            try {
                const response = await axios.get(`utils/api.php?op=searchUsers&query=${encodeURIComponent(query)}`);
                const users = response.data;

                searchResults.innerHTML = ""; // Clear previous results
                if (users.length > 0) {
                    users.forEach(user => {
                        const userItem = document.createElement("div");
                        userItem.className = "user-item d-flex align-items-center my-2";

                        const imgLink = document.createElement("a");
                        imgLink.href = `user.php?id=${user.IDuser}`;
                        imgLink.className = ''

                        const img = document.createElement("img");
                        if (user.profilePic) {
                            img.src = `data:image/jpeg;base64,${user.profile_pic}`;
                        } else {
                            img.src = "img/profile.png";
                        }
                        img.alt = "Profile Image";
                        img.className = "img-fluid rounded-circle";
                        img.style.maxHeight = "50px";

                        imgLink.appendChild(img);

                        const usernameLink = document.createElement("a");
                        usernameLink.href = `user.php?id=${user.IDuser}`;
                        usernameLink.textContent = user.username;
                        usernameLink.className = "fw-bold text-decoration-none text-dark ms-3";

                        userItem.appendChild(imgLink);
                        userItem.appendChild(usernameLink);
                        searchResults.appendChild(userItem);
                    });
                } else {
                    searchResults.innerHTML = "<p>No users found</p>";
                }
            } catch (error) {
                console.error('Error fetching search results:', error);
            }
        } else {
            searchResults.innerHTML = ""; // Clear results if query is empty
        }
    });
});
