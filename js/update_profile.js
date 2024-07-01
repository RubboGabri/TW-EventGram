document.addEventListener('DOMContentLoaded', function() {
    const changePictureButton = document.getElementById('change-picture-button');
    const removePictureButton = document.getElementById('remove-picture-button');
    const profilePicture = document.getElementById('profile-picture');
    const imgInput = document.getElementById('img');
    const removeImageFlag = document.getElementById('remove-image-flag');
    const resizedImageInput = document.getElementById('resizedImage');
    const deleteAccountButton = document.querySelector('[aria-label="Elimina account"]');

    const defaultPicture = 'img/profile.png';

    changePictureButton.addEventListener('click', function() {
        imgInput.click();
    });

    imgInput.addEventListener('change', function() {
        const file = imgInput.files[0];
        if (file) {
            removeImageFlag.value = '0'; // Reset the flag if a new image is selected
            resizeImage(file, 350, 350, function(resizedDataUrl) {
                profilePicture.src = resizedDataUrl;
                resizedImageInput.value = resizedDataUrl; // Store the resized image data URL in hidden input
            });
        }
    });

    removePictureButton.addEventListener('click', function() {
        profilePicture.src = defaultPicture;
        imgInput.value = '';
        removeImageFlag.value = '1'; // Set the flag to indicate the image should be removed
        resizedImageInput.value = ''; // Clear the hidden input
    });

    document.getElementById('profile-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const errorMessage = document.getElementById('error-message');
        errorMessage.innerText = '';

        const username = document.getElementById('username').value.trim();
        const info = document.getElementById('info').value;
        const picElem = document.getElementById('img');

        const result = await updateProfile(username, info, picElem);
        if (result === 0) {
            location.href = 'user.php'; // Redirect to user profile page
        } else {
            errorMessage.innerText = result.errore;
        }
    });

    async function updateProfile(username, info, picElem) {
        const formData = new FormData();
        formData.append('op', "updateProfile");
        formData.append('username', username);
        formData.append('info', info);

        if (removeImageFlag.value === '1') {
            formData.append('removeImage', '1');
        } else if (resizedImageInput.value) {
            // Convert data URL to Blob
            const blob = dataURLToBlob(resizedImageInput.value);
            formData.append('pic', blob, 'profile.png');
        }

        try {
            const response = await axios.post('utils/api.php', formData, { headers: { "Content-Type": "multipart/form-data" } });

            if (response.data["esito"] === true) {
                return 0;
            } else {
                return response.data;
            }
        } catch (error) {
            console.error(error);
            return { esito: false, errore: "Errore durante l'aggiornamento del profilo." };
        }
    }

    deleteAccountButton.addEventListener('click', async function() {
        if (confirm('Sei sicuro di voler eliminare il tuo account?')) {
            const result = await deleteAccount();
            if (result === 0) {
                console.log('Account eliminato con successo');
                location.href = 'index.php'; // Redirect to home page after account deletion
            } else {
                document.getElementById('error-message').innerText = result.errore;
            }
        }
    });

    async function deleteAccount() {
        const formData = new FormData();
        formData.append('op', "deleteAccount");

        try {
            const response = await axios.post('utils/api.php', formData);
            
            if (response.data["esito"] === true) {
                return 0;
            } else {
                return response.data;
            }
        } catch (error) {
            console.error(error);
            return { esito: false, errore: "Errore durante l'eliminazione dell'account." };
        }
    }

    function resizeImage(file, width, height, callback) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                const scaleFactor = 2; // Increase this factor to improve quality
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
    
                // Set the canvas size to the scaled dimensions
                canvas.width = width * scaleFactor;
                canvas.height = height * scaleFactor;
    
                // Clear the canvas to make it transparent
                ctx.clearRect(0, 0, canvas.width, canvas.height);
    
                // Calculate the dimensions to maintain aspect ratio and cover the entire circle
                const aspectRatio = img.width / img.height;
                let newWidth, newHeight, offsetX, offsetY;
    
                if (aspectRatio > 1) {
                    newHeight = canvas.height;
                    newWidth = canvas.height * aspectRatio;
                    offsetX = (canvas.width - newWidth) / 2;
                    offsetY = 0;
                } else {
                    newWidth = canvas.width;
                    newHeight = canvas.width / aspectRatio;
                    offsetX = 0;
                    offsetY = (canvas.height - newHeight) / 2;
                }
    
                // Draw circular clipping path
                ctx.beginPath();
                ctx.arc(canvas.width / 2, canvas.height / 2, Math.min(canvas.width, canvas.height) / 2, 0, Math.PI * 2, true);
                ctx.closePath();
                ctx.clip();
    
                // Draw the image into the circle
                ctx.drawImage(img, offsetX, offsetY, newWidth, newHeight);
    
                // Scale down the canvas to the original size
                const outputCanvas = document.createElement('canvas');
                outputCanvas.width = width;
                outputCanvas.height = height;
                const outputCtx = outputCanvas.getContext('2d');
                outputCtx.drawImage(canvas, 0, 0, width, height);
    
                const dataUrl = outputCanvas.toDataURL('image/png'); // Use PNG to preserve transparency
                callback(dataUrl);
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
    
    
    
    
    function dataURLToBlob(dataURL) {
        const binaryString = atob(dataURL.split(',')[1]);
        const arrayBuffer = new ArrayBuffer(binaryString.length);
        const intArray = new Uint8Array(arrayBuffer);
        for (let i = 0; i < binaryString.length; i++) {
            intArray[i] = binaryString.charCodeAt(i);
        }
        return new Blob([intArray], { type: 'image/png' });
    }
});
