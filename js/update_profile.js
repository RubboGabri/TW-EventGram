async function updateProfile(username, info, picElem) {
    if (!username) {
        return -1;
    }

    const formData = new FormData();
    formData.append('op', "updateUser");
    formData.append('username', username);
    formData.append('info', info);

    try {
        let headers = {};
        if (picElem.files.length > 0) { // Update user including profile image
            const pic = picElem.files[0];
            const base64 = await readAsDataURL(pic);
            const resizedImage = await resizeBase64(base64);
            formData.append('pic', resizedImage);
            headers["Content-Type"] = "multipart/form-data";
        }

        const response = await axios.post('utils/api.php', formData, { headers });

        if (response.data["esito"] === true) {
            location.href = "user.php";
            return 0;
        } else {
            return -2;
        }
    } catch (error) {
        console.error(error);
        return -2;
    }
}

function readAsDataURL(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result.split(',')[1]);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

function resizeBase64(base64, maxWidth = 256, maxHeight = 256) {
    return new Promise(resolve => {
        const img = new Image();
        img.onload = () => {
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");
            const canvasCopy = document.createElement("canvas");
            const copyContext = canvasCopy.getContext("2d");

            let ratio = 1;
            if (img.width > maxWidth) ratio = maxWidth / img.width;
            else if (img.height > maxHeight) ratio = maxHeight / img.height;

            canvasCopy.width = img.width;
            canvasCopy.height = img.height;
            copyContext.drawImage(img, 0, 0);

            canvas.width = img.width * ratio;
            canvas.height = img.height * ratio;
            ctx.drawImage(canvasCopy, 0, 0, canvasCopy.width, canvasCopy.height, 0, 0, canvas.width, canvas.height);

            resolve(canvas.toDataURL().split(',')[1]);
        };
        img.src = 'data:image/png;base64,' + base64;
    });
}
