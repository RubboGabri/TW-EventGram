function follow(idFollowed) {
    const formData = new FormData();
    formData.append('op', "follow");
    formData.append('idFollowed', idFollowed);
    axios.post('utils/api.php', formData);

    followButton.innerHTML="Smetti di seguire";
    followButton.setAttribute("aria-label", "Smetti di seguire");
    followButton.classList.replace("btn-success", "btn-danger");
    document.getElementById("numFollower").textContent = +document.getElementById("numFollower").textContent + 1;
    followButton.setAttribute('onclick', 'unfollow()');
}

function unfollow(idFollowed) {
    const formData = new FormData();
    formData.append('op', "unfollow");
    formData.append('idFollowed', idFollowed);
    axios.post('utils/api.php', formData);

    followButton.innerHTML="Segui";
    followButton.setAttribute("aria-label", "Segui");
    followButton.classList.replace("btn-danger", "btn-success");
    document.getElementById("numFollower").textContent = +document.getElementById("numFollower").textContent - 1;
    followButton.setAttribute('onclick', 'follow()');
}