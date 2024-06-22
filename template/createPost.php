<div class="container min-vh-100 d-flex flex-column ps-4">
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