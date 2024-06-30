document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        const likeButton = event.target.closest('.like-btn');
        if (likeButton) {
            handleLikeButtonClick(likeButton);
        }

        const subscribeButton = event.target.closest('.subscribe-btn');
        if (subscribeButton) {
            handleSubscribeButtonClick(subscribeButton);
        }

        const detailsButton = event.target.closest('.details-btn');
        if (detailsButton) {
            toggleDetails(detailsButton);
        }

        const commentButton = event.target.closest('.comment-btn');
        if (commentButton) {
            toggleComments(commentButton);
        }

        const replyButton = event.target.closest('.reply-btn');
        if (replyButton) {
            handleReplyButtonClick(replyButton);
        }
    });
});

function handleLikeButtonClick(likeButton) {
    const postId = likeButton.getAttribute('data-post-id');
    const likeIcon = likeButton.querySelector('.like-icon');
    const likeCountElement = likeButton.querySelector('.like-count');
    const isLiked = likeIcon.getAttribute('src') === '../img/like_red.png';

    if (isLiked) {
        removeLike(postId, likeIcon, likeCountElement);
    } else {
        addLike(postId, likeIcon, likeCountElement);
    }
}

function handleSubscribeButtonClick(subscribeButton) {
    const postId = subscribeButton.getAttribute('data-post-id');
    const isSubscribed = subscribeButton.classList.contains('btn-danger');

    if (isSubscribed) {
        unsubscribeToPost(postId, subscribeButton);
    } else {
        subscribeToPost(postId, subscribeButton);
    }
}

function handleReplyButtonClick(replyButton) {
    const postId = replyButton.getAttribute('data-post-id');
    const parentId = replyButton.getAttribute('data-parent-id');
    const username = replyButton.getAttribute('data-username');
    replyToComment(username, postId, parentId);
}

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
        button.querySelector('img').src = '../img/more.png'; // Cambia l'immagine in "more.png"
        button.querySelector('img').alt = 'Espandi';
    } else {
        details.classList.remove('d-none');
        button.querySelector('img').src = '../img/less.png'; // Cambia l'immagine in "less.png"
        button.querySelector('img').alt = 'Riduci';
    }
}

function toggleComments(element) {
    const card = element.closest('.card');
    const postId = element.getAttribute('data-post-id');
    console.log('Toggling comments for post:', postId);
    const commentsSection = card.querySelector(`#commentsSection_${postId}`);
    if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
        commentsSection.style.display = 'block';
        loadComments(card, postId);
    } else {
        commentsSection.style.display = 'none';
    }
}

function loadComments(card, postId) {
    const commentsContainer = card.querySelector(`#comments_${postId}`);
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
                const commentsTree = buildCommentsTree(data.comments);
                commentsTree.forEach(comment => {
                    appendComment(commentsContainer, comment, postId);
                });
            } else {
                commentsContainer.innerHTML = '<p>Ancora nessun commento.</p>';
            }
        })
        .catch(error => {
            commentsContainer.innerHTML = `<p>Errore di caricamento dei commenti: ${error.message}</p>`;
        });
}

function buildCommentsTree(comments, parentId = null) {
    const tree = [];
    comments.forEach(comment => {
        if (comment.IDparent === parentId) {
            const children = buildCommentsTree(comments, comment.IDcomment);
            if (children.length) {
                comment.children = children;
            }
            tree.push(comment);
        }
    });
    return tree;
}

function appendComment(container, comment, postId, depth = 0) {
    const commentElement = document.createElement('div');
    const offset = depth > 0 ? 'offset-1' : '';
    commentElement.innerHTML = `
        <div class="d-flex align-items-start mb-3 ${offset}">
            <a href="user.php?id=${comment.IDuser}">
                <img src="data:image/jpeg;base64,${comment.profilePic ? comment.profilePic : '../img/profile.png'}" alt="Profile picture" class="img-fluid border border-dark rounded-circle" style="width: 30px; height: 30px"/>
            </a>
            <span class="text-start ps-2" style="word-break: break-word; white-space: normal; width: 88%">
                <div>
                    <a href="user.php?id=${comment.IDuser}" class="fw-bold text-decoration-none text-dark"> 
                    ${comment.username}
                    </a>
                    ${comment.text}
                </div>
                <div class="d-flex align-items-center">
                    <small class="text-muted small-text py-0 m-0">
                        ${new Date(comment.date).toLocaleString('it-IT', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' })}
                    </small>
                    <button class="btn btn-link text-decoration-none small-text py-0 m-0 reply-btn" data-username="${comment.username}" data-post-id="${postId}" data-parent-id="${comment.IDcomment}">
                        Rispondi
                    </button>
                </div>
            </span>
        </div>
    `;
    container.appendChild(commentElement);

    if (comment.children) {
        comment.children.forEach(childComment => {
            appendComment(container, childComment, postId, depth + 1);
        });
    }
}

function replyToComment(username, postId, parentId) {
    const activeSection = getVisibleSection();
    let card;

    if (activeSection) {
        card = activeSection.querySelector(`.card[data-post-id='${postId}']`);
    } else {
        card = document.querySelector(`.card[data-post-id='${postId}']`);
    }
    
    if (!card) {
        console.error(`Card not found for postId ${postId}`);
        return;
    }

    console.log("Selected card for postId", postId, card);
    const commentInput = card.querySelector(`#addComment_${postId}`);
    commentInput.value = `@${username} `;
    commentInput.setAttribute('data-parent-id', parentId); // Imposta l'ID del commento genitore
    commentInput.focus();
}

async function postComment(postId) {
    const activeSection = getVisibleSection();
    let card;

    if (activeSection) {
        card = activeSection.querySelector(`.card[data-post-id='${postId}']`);
    } else {
        card = document.querySelector(`.card[data-post-id='${postId}']`);
    }
    
    if (!card) {
        console.error(`Card not found for postId ${postId}`);
        return;
    }

    console.log("Selected card for postId", postId, card);
    const commentInput = card.querySelector(`#addComment_${postId}`);
    console.log("Selected comment input", commentInput);
    const commentText = commentInput.value;

    if (commentText.trim() === '') return;

    const formData = new FormData();
    formData.append('op', 'addComment');
    formData.append('comment', commentText);
    formData.append('idPost', postId);
    const parentId = commentInput.getAttribute('data-parent-id') || null; // Leggi l'ID del commento genitore
    if (parentId) {
        formData.append('idParent', parentId); // Invia l'ID del commento genitore
    }

    try {
        const response = await axios.post('utils/api.php', formData);
        console.log('Comment posted:', response.data);
        if (response.data.esito) {
            commentInput.value = '';
            commentInput.removeAttribute('data-parent-id'); // Resetta l'attributo dopo l'invio del commento
            loadComments(card, postId); // Ricarica i commenti dopo la pubblicazione
            incrementCommentCount(postId); // Incrementa il conteggio dei commenti
        } else {
            console.error('Error posting comment:', response.data.errore);
        }
    } catch (error) {
        console.error('Error posting comment:', error);
    }
}

function incrementCommentCount(postId) {
    const activeSection = getVisibleSection();
    let commentCountElement;

    if (activeSection) {
        commentCountElement = activeSection.querySelector(`.comment-count[data-post-id='${postId}']`);
    } else {
        commentCountElement = document.querySelector(`.comment-count[data-post-id='${postId}']`);
    }

    if (commentCountElement) {
        commentCountElement.textContent = +commentCountElement.textContent + 1;
    } else {
        console.error(`Comment count element not found for postId ${postId}`);
    }
}

function getVisibleSection() {
    const postsSection = document.querySelector('.posts-section');
    const subscriptionsSection = document.querySelector('.subscriptions-section');
    
    if (postsSection && subscriptionsSection) {
        if (!postsSection.classList.contains('d-none')) {
            return postsSection;
        } else {
            return subscriptionsSection;
        }
    }
    
    // Se non ci sono sezioni, restituire null
    return null;
}

