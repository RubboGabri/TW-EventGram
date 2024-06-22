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

    const result = await createPost(title, description, eventDate, location, category, price, minAge, imgFile);
    handlePostCreationResult(result);
});

function handlePostCreationResult(result) {
    if (result && result.esito === false) {
        document.querySelector("form > p").innerText = result.errore || "An error occurred.";
    } else if (result && result.esito === true) {
        window.location.href = "home.php";
    } else {
        document.querySelector("form > p").innerText = "Unexpected error: the server response is not in the expected format.";
    }
}

async function createPost(title, description, eventDate, location, category, price, minAge, imgFile) {
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

    if (imgFile !== null) {
        formData.append('imgFile', imgFile); // Append the binary file directly
    }

    try {
        const response = await axios.post('utils/api.php', formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            }
        });

        if (response.data["esito"] === true) {
            return { esito: true, IDpost: response.data["IDpost"] };
        } else {
            return { esito: false, errore: response.data["errore"] };
        }
    } catch (error) {
        if (error.response) { // Response with a status code not in range 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
        } else if (error.request) { // No response
            console.log(error.request);
        } else { // Error in setting up the request
            console.log('Error', error.message);
        }
        console.log(error.config);
        return { esito: false, errore: "Error during the request. Please try again." };
    }
}
