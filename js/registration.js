document.querySelector("main form").addEventListener("submit", async function (event) {
    event.preventDefault();
    document.querySelector("form > p").innerText = "";
    const username = document.querySelector("#username").value;
    const password = document.querySelector("#password").value;
    const confirmPassword = document.querySelector("#confirm_password").value;
    const result = await register(username, password, confirmPassword);
    if (result.esito === false) {
        document.querySelector("form > p").innerText = result.errore;
    }
});

async function register(username, password, confirmPassword) {
    if (username === '' || password === '') {
        return { esito: false, errore: "Errore! Devi scegliere un'username e una password!" };
    }
    if (password !== confirmPassword) {
        return { esito: false, errore: "Error! The passwords do not match!" };
    }
    const formData = new FormData();
    formData.append('op', "register");
    formData.append('username', username);
    formData.append('password', password);

    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito === true) {
            location.href = "home.php";
            return { esito: true };
        } else {
            return response.data;
        }
    } catch (error) {
        console.error('Errore di registrazione:', error);
        return { esito: false, errore: "Errore durante la richiesta. Riprovare." };
    }
}