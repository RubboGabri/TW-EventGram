<div class="container min-vh-100 d-flex flex-column <?php if(isset($header_offset)) echo $header_offset ?>">
    <h1 class="d-none d-md-block col-12 text-center pt-3">
        Modifica profilo
    </h1>
    <picture class="col-12 text-center py-5">
        <img id="profile-picture" src="<?php if ($user["profilePic"] != NULL) {
                        $base64Image = base64_encode($user['profilePic']);
                        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;
                        echo $imageSrc;
                    } else echo '../img/profile.png'; ?>" 
                    alt="Profile Picture" class="img-fluid" style="max-height: 150px">
    </picture>
    <div class="text-center mb-3">
        <label for="img" hidden>Caricamento immagine</label>
        <input type="file" accept=".jpg,.jpeg,.png" class="d-none" id="img" name="img">
        <input type="hidden" id="remove-image-flag" name="removeImage" value="0">
        <input type="hidden" id="resizedImage" name="resizedImage">
        <button type="button" class="btn btn-primary" id="change-picture-button" aria-label="Cambia" style="border-radius: 25px">Cambia</button>
        <button type="button" class="btn btn-danger" id="remove-picture-button" aria-label="Rimuovi" style="border-radius: 25px">Rimuovi</button>
    </div>
    <form id="profile-form" action="#" method="post" enctype="multipart/form-data" class="w-75 mx-auto">
        <p class="text-danger" id="error-message"></p>
        <div class="form-group mt-3">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
        </div>
        <div class="form-group mt-3">
            <label for="info">Informazioni:</label>
            <textarea class="form-control" id="info" name="info" rows="5" ><?= $user["info"] !== NULL ? $user['info'] : '' ?></textarea>
        </div>
        <div class="row col-12 text-center py-5 mx-auto">
            <div class="col-6">
                <button type="submit" name="submit" class="btn btn-primary w-100" aria-label="Salva" style="border-radius: 25px">Salva</button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-danger w-100" aria-label="Elimina account" style="border-radius: 25px">Elimina account</button>
            </div>
        </div>
    </form>
</div>
