<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SetupCase - CodeBlocks</title>
    <link href="<?= $webroot; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $webroot; ?>css/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $webroot; ?>css/custom.css" rel="stylesheet">
</head>
<body>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SetupCase.com - CodeBlocks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTop">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#docs">Docs</a></li>
                <li class="nav-item"><a class="nav-link" href="#github">GitHub</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Layout -->
<div class="container-fluid" style="margin-top: 56px;">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Modules</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Examples</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">API</a></li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h1 class="mt-4">Welcome to MyFramework</h1>
            <p class="lead">A modern open-source code framework with B
