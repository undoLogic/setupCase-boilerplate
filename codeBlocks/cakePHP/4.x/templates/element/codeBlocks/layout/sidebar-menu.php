<nav class="sidebar pt-3">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link active" href="<?= $webroot; ?>CodeBlocks/">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#blocksMenu"
               role="button">
                Blocks
                <span class="bi bi-chevron-down small"></span>
            </a>

            <div class="collapse ps-3" id="blocksMenu">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>CodeBlocks/responsiveTable">Responsive Table</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>CodeBlocks/uploadFile">Upload File</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>CodeBlocks/readMore">Read More Expand</a></li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#modulesMenu"
               role="button"
               aria-expanded="false"
               aria-controls="modulesMenu">
                <span><i class="bi bi-box me-1"></i> Blocks with DB</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ps-3" id="modulesMenu">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>Staff/CodeBlocks/crud">CRUD Starter</a></li>

                </ul>
            </div>
        </li>




    </ul>

    <hr class="my-3">

    <small class="text-muted px-3">
        Developed by <a href="https://www.undoLogic.com/" target="_blank">undoLogic</a>
    </small>
</nav>
