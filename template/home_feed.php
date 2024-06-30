<div class="container d-flex justify-content-between px-4 min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="col-md-7 pt-5 mr-2">
        <?php
            if(isset($templateParams["postList"])){
                $postList = $templateParams["posts"];
                require($templateParams["postList"]);
            }
        ?>
    </div>
    <div class="col-md-4 pt-5 d-none d-md-block">
        <div style="position: sticky; top: 3rem;">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Cerca utente</h5>
                    <form id="search-form" class="d-flex align-items-center mb-4">
                        <input type="text" id="search" name="search" placeholder="Inserisci username" class="form-control flex-grow-1 me-2">
                        <button type="button" id="search-button" class="btn btn-primary">Cerca</button>
                    </form>
                    <div id="search-results"></div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Utenti Consigliati</h5>
                    <div id="suggested-users"></div>
                </div>
            </div>
        </div>
    </div>
</div>
