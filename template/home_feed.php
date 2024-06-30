<div class="container d-flex justify-content-between px-4 min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="col-md-7 pt-5" style="margin-right: 0.5rem;"> <!-- Riduci la larghezza della lista dei post -->
        <?php
            if(isset($templateParams["postList"])){
                $postList = $templateParams["posts"];
                require($templateParams["postList"]);
            }
        ?>
    </div>
    <div class="col-md-4 pt-5 d-none d-md-block" style="margin-left: 0.5rem;"> <!-- Aggiungi margine destro alla sezione di ricerca -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Search Users</h5>
                <form id="search-form" class="d-flex align-items-center mb-4">
                    <input type="text" id="search" name="search" placeholder="Enter name" class="form-control flex-grow-1 me-2">
                    <button type="button" id="search-button" class="btn btn-primary">Search</button>
                </form>
                <div id="search-results"></div>
            </div>
        </div>
    </div>
</div>
