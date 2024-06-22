<style>
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Previene lo scroll orizzontale */
    }
    .container{
        max-width: 100vw;
        box-sizing: border-box;
        padding: 0 20px;
        margin-top: auto;
    }
    *, *::before, *::after {
        box-sizing: inherit;
    }
    .text-center {
        text-align: center;
    }
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 2.5rem;
        color: #06192d;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .back-button a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 20px 0;
        color: #06192d; /* Cambia questo colore a seconda del tuo schema di colori */
        font-weight: bold;
        text-decoration: none;
    }
    .back-button i {
        margin-right: 8px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div class="back-button">
    <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Indietro</a>
</div>
<div class="container mt-5">
    <h1 class="text-center mb-4">Crea un nuovo Post</h1>
    <form action="#" method="post" enctype="multipart/form-data" class="w-75 mx-auto">
        <p class="text-danger"></p>
        <div class="form-group">
            <label for="title">Titolo:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">Descrizione:</label>
            <textarea class="form-control" id="description" name="description" rows="1" required></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="eventDate">Data dell'evento:</label>
            <input type="datetime-local" class="form-control" id="eventDate" name="eventDate" required>
        </div>
        <div class="form-group mt-3">
            <label for="location">Location:</label>
            <select class="form-control" id="location" name="location" required>
                <option value="">Seleziona una location</option>
                <?php foreach ($templateParams["locations"] as $location): ?>
                    <option value="<?php echo $location["IDlocation"]; ?>"><?php echo $location["name"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="category">Categoria:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">Seleziona una categoria</option>
                <?php foreach ($templateParams["categories"] as $category): ?>
                    <option value="<?php echo $category["IDcategory"]; ?>"><?php echo $category["name"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="price">Prezzo:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group mt-3">
            <label for="minAge">Età minima:</label>
            <input type="number" class="form-control" id="minAge" name="minAge">
        </div>
        <div class="form-group mt-3">
            <label for="img">Immagine:</label>
            <input type="file" class="form-control" id="img" name="img">
        </div>
        <button type="submit" class="btn btn-primary mt-4 w-100">Crea Post</button>
    </form>
</div>