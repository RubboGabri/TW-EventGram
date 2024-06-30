<div class="container d-flex flex-column align-items-center px-4 min-vh-100 <?php if(isset($header_offset)) echo $header_offset ?>">
    <div class="search-container mt-4 w-100">
        <h2 class="text-center mb-4">Cerca Utente</h2>
        <div class="row justify-content-center">
            <div class="col-12 d-flex flex-column align-items-center">
                <form id="search-form" class="d-flex align-items-center mb-4 w-100" style="max-width: 500px;">
                    <input type="text" id="search" name="search" placeholder="Enter name" class="form-control flex-grow-1 me-2">
                    <button type="button" id="search-button" class="btn btn-primary">Search</button>
                </form>
                <div id="search-results" class="w-100" style="max-width: 500px;"></div>
            </div>
        </div>
    </div>
</div>
