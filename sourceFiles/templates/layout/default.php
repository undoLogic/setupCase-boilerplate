<!DOCTYPE html>
<html class="wide wow-animation" lang="<?= $this->Lang->get(); ?>">
<head>
    <!--Site Title-->
    <title>undoLogic Inc.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?= $webroot; ?>images/undoLogic-favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico%7CLato:400,100,100italic,300,300italic,700,400italic,900,700italic,900italic%7CMontserrat:400,700">
    <link rel="stylesheet" href="<?= $base; ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?= $base; ?>css/fonts.css">
    <link rel="stylesheet" href="<?= $base; ?>css/style.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    <link rel="stylesheet" href="<?= $webroot; ?>css/a/added-styles-B.css">
</head>
<body>

<div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?= $base; ?>images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>

<?php if (0): ?>
<div class="preloader">

    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <p>Loading...</p>
    </div>
</div>
<?php endif; ?>
<!--The Main Wrapper-->

    <?php echo $this->Element('a/banner'); ?>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <!--Footer-->
    <?= $this->element("a/footer"); ?>

    <!-- end of footer -->

<!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"></div>
<!--Scripts-->
<script src="<?= $base; ?>js/core.min.js"></script>
<script src="<?= $base; ?>js/script.js"></script>
</body>
</html>
