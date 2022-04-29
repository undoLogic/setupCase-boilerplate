<?php
$cakeDescription = 'CakePHP4';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>  <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href=>



    <?= $this->Html->css([
        "https://getbootstrap.com/docs/4.0/examples/dashboard/",
        "https://fonts.googleapis.com/css?family=Raleway:400,700"

    ]) ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="<?= $base; ?>/css/dashboard.css" rel="stylesheet">

    <!-- jquery, bootstrap , angularjs-->
    <?= $this->Html->script([
        "https://code.jquery.com/jquery-3.6.0.min.js",
        "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js",
        "https://unpkg.com/vue@3.0.2"

    ]) ; ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>


    <!-- Bootstrap core CSS -->


    <style type="text/css">/* Chart.js */
        @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
    </style>

</head>
<body>

<?= $this->element('a/header'); ?>

<div class="container">
    <div class="row">
        <?= $this->element('a/navigation'); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>



        </main><!-- /main -->
    </div>
</div>

<?= $this->element('a/footer'); ?>
<script src="<?= $webroot; ?>js/a/app.js"></script>

</body>
</html>
