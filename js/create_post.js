document.querySelector("main form").addEventListener("submit", async function (event) {
    event.preventDefault();
    document.querySelector("form > p").innerText = "";
    const title = document.querySelector("#title").value;
    const description = document.querySelector("#description").value;
    const eventDate = document.querySelector("#eventDate").value;
    const location = document.querySelector("#location").value;
    const category = document.querySelector("#category").value;
    const price = document.querySelector("#price").value;
    const minAge = document.querySelector("#minAge").value || null;

    // Gestione del caricamento dell'immagine
    const imgFile = document.querySelector("#img").files[0];
    let imgData = null;
    
    const reader = new FileReader();
    reader.onloadend = async () => {
        imgData = reader.result.split(',')[1]; // Ottieni solo i dati base64 dell'immagine
        const result = await createPost(title, description, eventDate, location, category, price, minAge, imgData);
        handlePostCreationResult(result);
    };
    
    if (imgFile) {
        reader.readAsDataURL(imgFile);
    } else {
        const result = await createPost(title, description, eventDate, location, category, price, minAge, imgData);
        handlePostCreationResult(result);
    }
});

function handlePostCreationResult(result) {
    if (result.esito === false) {
        document.querySelector("form > p").innerText = result.errore;
    } else {
        window.location.href = "home.php"; // Ensure window.location.href is used
    }
}

// Funzione per creare un post
async function createPost(title, description, eventDate, location, category, price, minAge, imgData) {
    const formData = new FormData();
    formData.append('op', "createPost");
    formData.append('title', title);
    formData.append('description', description);
    formData.append('eventDate', eventDate);
    formData.append('location', location);
    formData.append('category', category);
    formData.append('price', price);
    if (minAge !== null) {
        formData.append('minAge', minAge);
    }
    if (imgData !== null) {
        formData.append('img', imgData);
    }

    try {
        const response = await axios.post('utils/api.php', formData);
        return response.data;
    } catch (error) {
        return { esito: false, errore: error.message };
    }
}
