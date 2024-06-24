function logout() {
    const formData = new FormData();
    formData.append('op', "logout");
    axios.post('utils/api.php', formData)
        .then(response => {
            // Optionally handle the response if needed
            location.href = "index.php"; // Redirect to the login page after logout
        })
        .catch(error => {
            console.error('Logout error:', error);
        });
}