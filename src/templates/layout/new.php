<?php
$cakeDescription = 'CakePHP4';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>  <?= $cakeDescription ?>: <?= $this->fetch('title') ?> </title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap core CSS ---->
    <link href="<?= $webroot; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= $webroot; ?>css/dashboard.css" rel="stylesheet">
    <link href="<?= $webroot; ?>css/added_styles.css" rel="stylesheet">

    <?= $this->Html->script([
        "https://code.jquery.com/jquery-3.6.0.min.js",
        "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js",
        "https://unpkg.com/vue@3.0.2"


    ]) ; ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>

<body>
<?= $this->element('a/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?= $this->element('a/navigation'); ?>


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>

        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="<?= $webroot; ?>assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="<?= $webroot; ?>assets/js/vendor/popper.min.js"></script>
<script src="<?= $webroot; ?>js/bootstrap.min.js"></script>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

<!-- Graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>
<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [{
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
    });
</script>
<script src="<?= $webroot; ?>js/a/app.js"></script>
</body>
</html>
