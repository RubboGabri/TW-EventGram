async function follow(idFollowed) {
    const formData = new FormData();
    formData.append('op', "follow");
    formData.append('idFollowed', idFollowed);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito === true) {
            updateFollowButton(true);
            document.getElementById("numFollower").textContent = +document.getElementById("numFollower").textContent + 1;
            followButton.setAttribute('onclick', 'unfollow(' + idFollowed + ')');
        } else {
            console.error('Errore nel seguire:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta follow:', error);
    }
}

async function unfollow(idFollowed) {
    const formData = new FormData();
    formData.append('op', "unfollow");
    formData.append('idFollowed', idFollowed);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito === true) {
            updateFollowButton(false);
            document.getElementById("numFollower").textContent = +document.getElementById("numFollower").textContent - 1;
            followButton.setAttribute('onclick', 'follow(' + idFollowed + ')');
        } else {
            console.error('Errore nel smettere di seguire:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta unfollow:', error);
    }
}

function updateFollowButton(isFollowing) {
    const followButton = document.getElementById('followButton');
    if (isFollowing) {
        followButton.innerHTML = "Smetti di seguire";
        followButton.setAttribute("aria-label", "Smetti di seguire");
        followButton.classList.replace("btn-success", "btn-danger");
    } else {
        followButton.innerHTML = "Segui";
        followButton.setAttribute("aria-label", "Segui");
        followButton.classList.replace("btn-danger", "btn-success");
    }
}

function showSection(section) {
    const postsSection = document.querySelector('.posts-section');
    const subscriptionsSection = document.querySelector('.subscriptions-section');
    const postsBtn = document.getElementById('postsBtn');
    const subscriptionsBtn = document.getElementById('subscriptionsBtn');

    if (section === 'posts') {
        postsSection.classList.remove('d-none');
        subscriptionsSection.classList.add('d-none');
        postsBtn.classList.add('active');
        subscriptionsBtn.classList.remove('active');
    } else if (section === 'subscriptions') {
        postsSection.classList.add('d-none');
        subscriptionsSection.classList.remove('d-none');
        postsBtn.classList.remove('active');
        subscriptionsBtn.classList.add('active');
    }
}
