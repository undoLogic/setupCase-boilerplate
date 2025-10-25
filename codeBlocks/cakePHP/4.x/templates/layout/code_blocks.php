<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SetupCase - CodeBlocks</title>
    <link href="<?= $webroot; ?>css/bootstrap.min.css" rel="stylesheet">
<!--    <link href="--><?php //= $webroot; ?><!--css/bootstrap-icons.css" rel="stylesheet">-->
    <style>
        /* custom styles */

        .sidebar .nav-link {
            color: #333;
            font-weight: 500;
            transition: background 0.2s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .collapse .nav-link {
            font-size: 0.95rem;
            padding-left: 1.5rem;
        }
        .sidebar .bi-chevron-down {
            transition: transform 0.2s;
        }
        .sidebar .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }



    </style>
</head>
<body>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CodeBlocks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTop">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.setupcase.com/">SetupCase.com</a></li>
                <li class="nav-item"><a class="nav-link" target="_blank" href="https://store.setupcase.com/">Store</a></li>
                <li class="nav-item"><a class="nav-link" target="_blank" href="https://github.com/undoLogic/setupCase-boilerplate">GitHub</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Layout -->
<div class="container-fluid" style="margin-top: 56px;">
    <div class="row">


        <div class="col-4">

            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= $webroot; ?>CodeBlocks/">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>

                        <!-- Sub-menu example -->
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center"
                               data-bs-toggle="collapse"
                               href="#modulesMenu"
                               role="button"
                               aria-expanded="false"
                               aria-controls="modulesMenu">
                                <span><i class="bi bi-box me-1"></i> Blocks</span>
                                <i class="bi bi-chevron-down small"></i>
                            </a>
                            <div class="collapse ps-3" id="modulesMenu">
                                <ul class="nav flex-column">
                                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>CodeBlocks/responsiveTable">Responsive Table</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?= $webroot; ?>CodeBlocks/uploadFile">Upload File</a></li>
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
                </div>
            </nav>

        </div>
        <div class="col-8">

            <?= $this->Flash->render() ?>


            <?php if (isset($codeBlocks_title)): ?>
                <h1>
                    <?= $codeBlocks_title; ?>
                </h1>

            <?php endif; ?>

            <?= $this->fetch('content') ?>



            <?php if (isset($codeBlocks_renderFiles)): ?>
                <?php foreach ($codeBlocks_renderFiles as $title => $file): ?>

                    <h3>
                        <?= $title; ?>
                    </h3>
                    <?php echo $this->element('codeBlocks/render_file', ['file' => $file]); ?>
                <hr/>
                <?php endforeach; ?>
            <?php endif; ?>



            <?php if (isset($codeBlocks_renderController)): ?>
                <?php foreach ($codeBlocks_renderController as $title => $actionVar): ?>
                    <h3>
                        <?= $title; ?>
                    </h3>
                    <?php echo $this->element('codeBlocks/render_var', ['actionVar' => $actionVar]); ?>
                <hr/>
                <?php endforeach; ?>
            <?php endif; ?>







        </div>










    </div>
</div>

<script src="<?= $webroot; ?>js/bootstrap.bundle.min.js"></script>
</body>
