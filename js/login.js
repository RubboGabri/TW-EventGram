document.querySelector("main form").addEventListener("submit", async function (event) {
    event.preventDefault();
    document.querySelector("form > p").innerText = "";
    const username = document.querySelector("#username").value;
    const password = document.querySelector("#password").value;
    const result = await login(username, password);
    if (result.esito === false) {
        document.querySelector("form > p").innerText = result.errore;
    }
});

async function login(username, password) {
    const formData = new FormData();
    formData.append('op', "login");
    formData.append('username', username);
    formData.append('password', password);
    try {
        const response = await axios.post('utils/api.php', formData);
        if (response.data.esito === true) {
            location.href = "home.php";
        }
        return response.data;
    } catch (error) {
        console.error('Login error:', error);
        return { esito: false, errore: "Errore durante il login. Si prega di riprovare." };
    }
}