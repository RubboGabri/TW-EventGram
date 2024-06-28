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

    document.querySelectorAll('.details-btn').forEach(function(detailsButton) {
        detailsButton.addEventListener('click', function() {
            toggleDetails(this);
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
    const cardBody = button.closest('.card-body');
    const details = cardBody.querySelector('.post-details');
    const isDetailsVisible = !details.classList.contains('d-none');

    if (isDetailsVisible) {
        details.classList.add('d-none');
        button.innerText = 'Altro';
    } else {
        details.classList.remove('d-none');
        button.innerText = 'Meno';
    }
}

function toggleComments(element) {
    const postId = element.getAttribute('id');
    console.log('Toggling comments for post:', postId);
    const commentsSection = document.getElementById(`commentsSection_${postId}`);
    if (commentsSection.style.display === 'none') {
        commentsSection.style.display = 'block';
        loadComments(postId);
    } else {
        commentsSection.style.display = 'none';
    }
}

function loadComments(postId) {
    const commentsContainer = document.getElementById(`comments_${postId}`);
    commentsContainer.innerHTML = ''; // Clear current comments
    fetch(`utils/api.php?op=getComments&idPost=${postId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Comments loaded:', data);
            if (data.comments.length > 0) {
                data.comments.forEach(comment => {
                    const commentElement = document.createElement('div');
                    commentElement.innerHTML = `
                        <div class="d-flex align-items-start mb-2">
                            <a href="user.php?id=${comment.IDuser}">
                                <img src="data:image/jpeg;base64,${comment.profilePic ? comment.profilePic : '../img/profile.png'}" alt="Profile picture" class="img-fluid border border-dark rounded-circle" style="width: 20px; height: 20px"/>
                            </a>
                            <span class="w-100 text-start ps-2" style="word-break: break-word; white-space: normal;">
                                <div>
                                    <a href="user.php?id=${comment.IDuser}" class="fw-bold text-decoration-none text-dark"> 
                                    ${comment.username}
                                    </a>
                                    ${comment.text}
                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted small-text m-0">${new Date(comment.date).toLocaleString('it-IT', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' })}</small>
                                    <button class="btn btn-link text-decoration-none small-text m-0" onclick="replyToComment('${comment.username}', ${postId}, ${comment.IDcomment})">Rispondi</button>
                                </div>
                            </span>
                        </div>
                    `;                
                    commentsContainer.appendChild(commentElement);
                });
            } else {
                commentsContainer.innerHTML = '<p>Ancora nessun commento.</p>';
            }
        })
        .catch(error => {
            commentsContainer.innerHTML = `<p>Errore di caricamento dei commenti: ${error.message}</p>`;
        });
}

function replyToComment(username, postId, parentId) {
    const commentInput = document.getElementById(`addComment_${postId}`);
    commentInput.value = `@${username} `;
    commentInput.setAttribute('data-parent-id', parentId); // Imposta l'ID del commento genitore
    commentInput.focus();
}

async function postComment(postId) {
    const commentInput = document.getElementById(`addComment_${postId}`);
    const commentText = commentInput.value;
    const parentId = commentInput.getAttribute('data-parent-id') || null; // Leggi l'ID del commento genitore

    if (commentText.trim() === '') return;

    const formData = new FormData();
    formData.append('op', 'addComment');
    formData.append('comment', commentText);
    formData.append('idPost', postId);
    formData.append('idParent', parentId); // Invia l'ID del commento genitore

    try {
        const response = await axios.post('utils/api.php', formData);
        console.log('Comment posted:', response.data);
        if (response.data.esito) {
            commentInput.value = '';
            commentInput.removeAttribute('data-parent-id'); // Resetta l'attributo dopo l'invio del commento
            loadComments(postId); // Ricarica i commenti dopo la pubblicazione
        } else {
            console.error('Error posting comment:', response.data.errore);
        }
    } catch (error) {
        console.error('Error posting comment:', error);
    }
}


