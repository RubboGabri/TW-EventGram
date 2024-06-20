function logout() {
    const formData = new FormData();
    formData.append('op', "logout");
    axios.post('utils/api.php', formData);
}