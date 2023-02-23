<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        SetupCase
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="<?= $webroot; ?>modules/prism.js"></script>
    <link rel="stylesheet" href="<?= $webroot; ?>modules/prism.css">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>




    <style>
        h1, h2, h3, h4, h5, h6 {
            font-weight: 300;
            letter-spacing: -.1rem;
            margin-bottom: 0;
            margin-top: 0;
        }

        .card {
            border-radius: 0;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }

        .card .card-header {
            background-color: #18b3ff5e;
            border-bottom: 1px solid #f1f1f1;
            padding: 20px 25px;
            position: relative;
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            color: inherit;
            background-color: rgba(0,0,0,.03);
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        .card-header-right {
            position: absolute;
            right: 20px;
            top: 20px;
        }

    </style>



</head>
<body>
    <nav class="top-nav">

            <a href="https://www.setupcase.com">
                SetupCase - Code Blocks</a>


    </nav>

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>

    <footer>
    </footer>
</body>
</html>
