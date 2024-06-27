document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-btn').forEach(function(likeButton) {
        likeButton.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const likeIcon = this.querySelector('.like-icon');
            const likeCountElement = this.querySelector('.like-count');
            const isLiked = likeIcon.getAttribute('src') === '../img/like_red.png';

            if (isLiked) {
                removeLike(postId, likeIcon, likeCountElement);
            } else {
                addLike(postId, likeIcon, likeCountElement);
            }
        });
    });

    document.querySelectorAll('.subscribe-btn').forEach(function(subscribeButton) {
        subscribeButton.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const isSubscribed = this.classList.contains('btn-danger');

            if (isSubscribed) {
                unsubscribeToPost(postId, this);
            } else {
                subscribeToPost(postId, this);
            }
        });
    });
});

async function addLike(postId, likeIcon, likeCountElement) {
    const formData = new FormData();
    formData.append('op', 'addLike');
    formData.append('idPost', postId);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito) {
            likeIcon.setAttribute('src', '../img/like_red.png');
            likeCountElement.textContent = +likeCountElement.textContent + 1;
        } else {
            console.error('Errore nell\'aggiungere il like:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta addLike:', error);
    }
}

async function removeLike(postId, likeIcon, likeCountElement) {
    const formData = new FormData();
    formData.append('op', 'removeLike');
    formData.append('idPost', postId);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito) {
            likeIcon.setAttribute('src', '../img/like_empty.png');
            likeCountElement.textContent = +likeCountElement.textContent - 1;
        } else {
            console.error('Errore nel rimuovere il like:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta removeLike:', error);
    }
}

async function subscribeToPost(postId, subscribeButton) {
    const formData = new FormData();
    formData.append('op', 'subscribeToPost');
    formData.append('idPost', postId);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito) {
            subscribeButton.textContent = 'Disiscriviti';
            subscribeButton.classList.remove('btn-primary');
            subscribeButton.classList.add('btn-danger');
        } else {
            console.error('Errore nella sottoscrizione al post:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta subscribeToPost:', error);
    }
}

async function unsubscribeToPost(postId, subscribeButton) {
    const formData = new FormData();
    formData.append('op', 'unsubscribeToPost');
    formData.append('idPost', postId);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito) {
            subscribeButton.textContent = 'Iscriviti';
            subscribeButton.classList.remove('btn-danger');
            subscribeButton.classList.add('btn-primary');
        } else {
            console.error('Errore nella disiscrizione al post:', response.data.errore);
        }
    } catch (error) {
        console.error('Errore nella richiesta unsubscribeToPost:', error);
    }
}

function toggleDetails(button) {
    var details = button.nextElementSibling;
    if (details.classList.contains('d-none')) {
        details.classList.remove('d-none');
        button.innerText = 'Meno';
    } else {
        details.classList.add('d-none');
        button.innerText = 'Altro';
    }
}
