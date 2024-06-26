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
