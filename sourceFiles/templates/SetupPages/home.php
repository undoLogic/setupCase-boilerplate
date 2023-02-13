<style>
    th {
        white-space: nowrap;
        background-color: #def4ff;
        text-align: center;
    }
    td:first-child, th:first-child {
        padding-left: 15px;
    }
    .side-nav a, .top-nav-links a, th a, .actions a {
        color: #606c76;
        text-decoration: underline;
    }
    .active {
        font-weight: bold;
    }
</style>
<table class="table">
    <tr>
        <th>
            CodeBlock
        </th>
        <th>
            Description
        </th>
    </tr>
    <tr>
        <th>
            Language
        </th>
        <td>
            Current Lang: <?= $this->Lang->get(); ?>

            /


            <?php echo $this->Html->link('English', ['language' => 'en'], [
                'class' => $this->Lang->getActiveClass('en')
            ]); ?>

/
            <?php echo $this->Html->link('French', ['language' => 'fr'], [
                'class' => $this->Lang->getActiveClass('fr')
            ]); ?>

/

            <?php echo $this->Html->link('Spanish', ['language' => 'es'], [
                'class' => $this->Lang->getActiveClass('es')
            ]); ?>

            /

            <?php echo $this->Html->link('Lang-not-set', array()); ?>
        </td>
    </tr>
    <Tr>
        <th>
            Access
        </th>
        <td>

            <?php if ($this->Auth->isLoggedIn()): ?>
                LOGGED IN (<?php echo $this->Html->link('Logout', '/logout'); ?>)
            <?php else: ?>
                NOT logged in (<?php echo $this->Html->link('Login', '/login'); ?>)
            <?php endif; ?>

            /
            <?php echo $this->Html->link('Reset', array('prefix' => false, 'controller' => 'Users', 'action' => 'beginReset')); ?>
            /
            <?php echo $this->Html->link('AddUser', array('prefix' => false, 'controller' => 'Users', 'action' => 'add')); ?>
            /
            <?php echo $this->Html->link('StaffPrefx', array(
                'prefix' => 'Staff',
            )); ?>
            /
            <?php echo $this->Html->link('AdminPrefix', array(
                'prefix' => 'Admin',
            )); ?>
        </td>
    </Tr>
    <tr>
        <th>
            Object Storage
        </th>
        <td>
            <?php echo $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'SetupPages', 'action' => 'fileAdd']]); ?>

            <?php echo $this->Form->file('fileToUpload', ['type' => 'button']); ?>

            <?= $this->Form->control('key_name', ['class' => 'form_control']); ?>
            <?= $this->Form->button('Upload'); ?>

            <?php echo $this->Form->end(); ?>

            <?php if (!empty($allFiles)): ?><hr/><?php endif; ?>

            <?php foreach ($allFiles as $object) :

                //pr ($object);
                ?>
                <div class="row">

                    <div class="col-lg-3">
                        <?= $this->Html->image('/SetupPages/fileView/'.$object['key_name']); ?>
                    </div>

                    <div class="col-lg-9">

                        Filename: <?= $object['filename']; ?> (key_name: <?= $object['key_name']; ?>)
                        <?= $this->Html->link('Download', ['action' => 'fileDownload', $object['key_name']]); ?>

                        <br/>

                        <a style="color: red; font-weight: bold;" href="<?= $webroot;?>SetupPages/fileDelete/<?= $object['key_name']; ?>">X</a>

                    </div>

                </div>
            <?php endforeach; ?>


        </td>
    </tr>
    <tr>
        <th>
            <?php echo $this->Html->link('Responsive Table', ['controller' => 'SetupPages', 'action' => 'responsiveTable']); ?>
        </th>
        <td>
            HTML table adjusts to rows when on a mobile device. Desktop is a normal table view
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $this->Html->link('Sticky div / Floating div', ['controller' => 'SetupPages', 'action' => 'sticky']); ?>
        </th>
        <td>

            A div will float (or stick to the top of the window) as the user scrolls.

        </td>
    </tr>
    <tr>
        <th>
            <?php echo $this->Html->link('VUE validation', ['language' => 'en', 'controller' => 'SetupPages', 'action' => 'formValidation']); ?>

        </th>
        <td>
            Validate a form with a simple validation object
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $this->Html->link('VUE timed form submission', ['language' => 'en', 'controller' => 'SetupPages', 'action' => 'setTimer']); ?>

        </th>
        <td>
            Form input will only submit after the user stops typing for a few seconds
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $this->Html->link('Auto pagination', ['controller' => 'SetupPages', 'action' => 'increaseLimit']); ?>

        </th>
        <td>
            As the user scrolls to the bottom of the page, the system will automatically load the next page / set of results. Instead of manually pushing next / previous pages.
        </td>
    </tr>
    <tr><!-- digital signage -->
        <th>
            <?php echo $this->Html->link('Digital Signage Template', ['controller' => 'SetupPages', 'action' => 'digitalSignage']); ?>

        </th>
        <td>
           Basic template for digital signage. Title, subtitle, text cycling between slides which can be scheduled with a php array
        </td>
    </tr>
    <tr>
        <th>
            Activity Monitor
        </th>
        <td>
            Tracks actions of users on predefined actions in a database for long term and ease of viewing

            <br/>

            <?= $this->Html->link('View-ActivityLog', ['prefix' => 'Admin', 'controller' => 'SetupPages', 'action' => 'activity-logs']); ?>
            <?= $this->Html->link('Test-addToLog', ['controller' => 'SetupPages', 'action' => 'activityLogAddToLog']); ?>
        </td>
    </tr>
    <tr>
        <th>
            Drag and Drop Upload

        </th>
        <td>
            Drag and drop files on the screen to upload efficiently
            <br/>

            <?= $this->Html->link('Add-Files', ['prefix' => 'Staff', 'controller' => 'SetupPages', 'action' => 'dragDrop']); ?>

        </td>
    </tr>
    <tr>
        <th>
            Export to CSV
            <br/>
            (COMING SOON...)
        </th>
        <td>
            Export an array into a CSV file that is downloaded to your computer
        </td>
    </tr>
    <tr>
        <th>
            Render PDF
            <br/>
            (COMING SOON...)
        </th>
        <td>
            Render a PDF from a custom HTML view and export and save to your computer
        </td>
    </tr>
    <tr>
        <th>
            JSON API Headers
            <br/>
            (COMING SOON...)
        </th>
        <td>
            Common function to always call the correct JSON headers when you are sending data between the front-end / back-end API
        </td>
    </tr>
    <tr>
        <th>
            Transaction

        </th>
        <td>

            <pre>

$errors = false;

$connection = ConnectionManager::get('default');
$connection->begin();

if ($anyProblems) {
    $errors = true;
}

if ($errors) {
    $connection->rollback();
} else {
    $connection->commit();
}
            </pre>
        </td>
    </tr>
    <tr>
        <th>
            <a target="_blank" rel="noopener" href="<?= $webroot;?>Users/addUser">Add User</a>
        </th>
    </tr>


</table>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
