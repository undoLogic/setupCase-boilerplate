<?php if (isset($isLoggedIn)): ?>
    LOGGED IN (<?php echo $this->Html->link('Logout', '/logout'); ?>)
<?php else: ?>
    NOT logged in (<?php echo $this->Html->link('Login', '/login'); ?>)
<?php endif; ?>

- <?php echo $this->Html->link('Reset', array('prefix' => false, 'controller' => 'Users', 'action' => 'beginReset')); ?>

- <?php echo $this->Html->link('Signup', array('prefix' => false, 'controller' => 'Users', 'action' => 'signup')); ?>

<hr/>

<h2>
    current lang: <?php echo $baseLang; ?>
</h2>

<br/>

<?php echo $this->Html->link('Home page EN', array(
    'language' => 'en_US'
)); ?>

<br/>

<?php echo $this->Html->link('Home page FR', array(
    'language' => 'fr_CA'
)); ?>

<br/>

<?php echo $this->Html->link('Home page NOT SET', array()); ?>

<hr/>

<h2>
    Prefix
</h2>

<?php echo $this->Html->link('Admin page', array(
    'prefix' => 'Admin',
)); ?>

<hr/>

<h2>
    Object Storage
</h2>

<div class="row">
    <div class="col-4">
        <?php echo $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'SetupPages', 'action' => 'objAdd']]); ?>

        <?php echo $this->Form->file('fileToUpload', ['type' => 'button']); ?>

        <?= $this->Form->button('Upload'); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php foreach ($objects as $object) : ?>
    <div class="row">
        <div class="col-lg-3">Filename: <?= $object['filename']; ?> (key_name: <?= $object['key_name']; ?>)</div>
        <div class="col-lg-3" style="margin-left: 5px;">

            <?php if ($object['current']): ?>
                CURRENT
            <?php else: ?>
                ARCHIVED
            <?php endif; ?>

            <?= $this->Html->link('Download', ['action' => 'objDownload', $object['key_name']]); ?>
            <a style="color: #000000; font-weight: bold;" href="<?= $webroot;?>SetupPages/objRemoveCache/<?= $object['key_name']; ?>">Remove-Cache</a>
            <a style="color: red; font-weight: bold;" href="<?= $webroot;?>SetupPages/objDelete/<?= $object['key_name']; ?>">X</a>
        </div>
    </div>
<?php endforeach; ?>





<h2>
    Responsive Table
</h2>

<style>
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        padding: 14px 10px;
        font-size: 9px;
        line-height: 1.6;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;
        color: #ffffff;
        background: #403254;
    }
    input{
        max-width: 140px;
        text-align: right;
    }

    td.title {
        font-weight: bold;
        color: #7acad1;
        float: left;
        background-color: white;

    }
    .title-row{
        background-color: white;
    }


    @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
            color: #ffffff;
            background: #403254;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }

        input{
            max-width: 100px;
        }
        td.title {
            font-weight: bold;
            color: #7acad1;
            float: left;
            background-color: white;


        }

    }


    /* general styling */
    body {
        font-family: "Open Sans", sans-serif;
        line-height: 1.25;
    }


</style>


<table>
    <thead>
        <tr>
            <th>
                one
            </th>
            <th>
                two
            </th>
            <th>
                three
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="One"">
                1
            </td>
            <td data-label="Two">
                2
            </td>
            <td data-label="Three">
                3
            </td>
        </tr>
        <tr>
            <td data-label="One"">
            1
            </td>
            <td data-label="Two">
                2
            </td>
            <td data-label="Three">
                3
            </td>
        </tr>
    </tbody>
</table>



<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
