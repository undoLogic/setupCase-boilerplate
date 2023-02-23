<?php $classEach = 'col-12 col-md-6 col-lg-4'; ?>


<?php if (0): ?>


    <div class="<?= $classEach; ?>">
        <div class="card">
            <div class="card-header">
                <h5>Title</h5>

                <div class="card-header-right">

                </div>
            </div>
            <div class="card-body">
                <pre><code class="language-php">

                    </code></pre>
            </div>
        </div>
    </div>


<?php endif; ?>


<div class="row">

    <div class="<?= $classEach; ?>">
        <div class="card">
            <div class="card-header">
                <h5>HTML Link</h5>
            </div>
            <div class="card-body">
                <pre><code class="language-php">$this->Html->link('Name', ['controller' => '', 'action' => ''], ['class' => 'btn btn-primary']);</code></pre>
            </div>
        </div>
    </div>

    <div class="<?= $classEach; ?>">
        <div class="card">
            <div class="card-header">
                <h5>Language Switching</h5>
                <div class="card-header-right">

                    <?= $this->Lang->get(); ?>

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

                </div>
            </div>
            <div class="card-body">
            <pre><code class="language-php">$this->Html->link('English',
    ['language' => 'en'],
    ['class' => $this->Lang->getActiveClass('en')
    ]);</code></pre>
                <pre><code class="language-php">$this->Html->link('French',
    ['language' => 'fr'],
    ['class' => $this->Lang->getActiveClass('fr')]
    );</code></pre>
                <pre><code class="language-php">$this->Html->link('Spanish',
    ['language' => 'es'],
    ['class' => $this->Lang->getActiveClass('es')]
    );</code></pre>
                <pre><code class="language-php">$this->Html->link('Lang-not-set', array());</code></pre>
            </div>
        </div>
    </div>

    <div class="<?= $classEach; ?>">
        <div class="card">
            <div class="card-header">
                <h5>Auth</h5>

                <div class="card-header-right">

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

                </div>
            </div>
            <div class="card-body">
                <pre><code class="language-php">

    &lt;?php if ($this->Auth->isLoggedIn()): ?>
    LOGGED IN (&lt;?php echo $this->Html->link('Logout', '/logout'); ?>)
    &lt;?php else: ?>
    NOT logged in (&lt;?php echo $this->Html->link('Login', '/login'); ?>)
    &lt;?php endif; ?>

    &lt;?php echo $this->Html->link('Reset', array('prefix' => false, 'controller' => 'Users', 'action' => 'beginReset')); ?>

    &lt;?php echo $this->Html->link('AddUser', array('prefix' => false, 'controller' => 'Users', 'action' => 'add')); ?>

    &lt;?php echo $this->Html->link('StaffPrefx', array(
    'prefix' => 'Staff',
    )); ?>

    &lt;?php echo $this->Html->link('AdminPrefix', array(
    'prefix' => 'Admin',
    )); ?>


                    </code></pre>
            </div>
        </div>
    </div>

    <div class="<?= $classEach; ?>">
    <div class="card">
        <div class="card-header">
            <h5>VUE - Axios POST</h5>

            <div class="card-header-right">

            </div>
        </div>
        <div class="card-body">
                <pre><code class="language-javascript">

    function postExample() {

    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = "< ? = $csrf; ?>";

    console.log('formdata - submit form');
    console.log(this.formData);

    var objData = JSON.stringify(this.formData);

    console.log('objData');
    console.log(objData);
    let URL = "< ? = $webroot; ?>SetupPages/get";
    axios.post(URL, objData).then(function (response) {
    console.log("response");
    console.log(response);
    if (response.data.STATUS == 200) {
    console.log();
    } else {
    console.log('Fail - something went wrong');
    }
    });
    }
                    </code></pre>
        </div>
    </div>
    </div>

    <div class="<?= $classEach; ?>">
    <div class="card">
        <div class="card-header">
            <h5>VUE - Axios GET</h5>

            <div class="card-header-right">

            </div>
        </div>
        <div class="card-body">
                <pre><code class="language-php">
    function getExample() {
    console.log(URL);
    let URL = "< ? = $webroot; ?>SetupPages/get";
    axios.get(URL).then(function (response) {
    console.log("response");
    console.log(response);
    if (response.data.STATUS == 200) {
        console.log();
    } else {
        console.log('Fail - something went wrong');
    }
    });
    }
                    </code></pre>
        </div>
    </div>
    </div>

    <div class="<?= $classEach; ?>">
    <div class="card">
        <div class="card-header">
            <h5>JSON</h5>

            <div class="card-header-right">

            </div>
        </div>
        <div class="card-body">
                <pre><code class="language-php">

    function jsonName(){

    $jsonData = file_get_contents('php://input');
    if (empty($jsonData)) {
    $jsonData ='{"id":-1}';
    }

    $user_id = $this->getUserId();
    $res = $this->Models->function($user_id, $jsonData);

    $this->jsonHeaders( json_encode($res) );

    }
                    </code></pre>
        </div>
    </div>
    </div>

    <div class="<?= $classEach; ?>">
    <div class="card">
        <div class="card-header">
            <h5>Transaction</h5>

            <div class="card-header-right">

            </div>
        </div>
        <div class="card-body">
                <pre><code class="language-php">

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

                    </code></pre>
        </div>
    </div>
    </div>

    <div class="<?= $classEach; ?>">
        <div class="card">
            <div class="card-header">
                <h5> CSS Hide / show on Desktop / phone</h5>

                <div class="card-header-right">

                </div>
            </div>
            <div class="card-body">
                <pre><code class="language-css">
@media screen and (max-width: 600px) {
    .hiddenDesktop {
        display: none;
    }
}

@media screen and (min-width: 600px) {
    .hiddenPhone {
        display: none;
    }
}
                    </code></pre>
            </div>
        </div>
    </div>







</div>




    <h3> OLD TO BE MOVED ABOVE</h3>
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

            </td>
        </tr>

        <tr>
            <th>
                File Storage (Store files on your server)
            </th>
            <td>
                <?php echo $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'SetupPages', 'action' => 'fileAdd']]); ?>

                <?php echo $this->Form->file('fileToUpload', ['type' => 'button']); ?>

                <?= $this->Form->control('key_name', ['class' => 'form_control']); ?>
                <?= $this->Form->button('Upload'); ?>

                <?php echo $this->Form->end(); ?>

                <?php if (!empty($allFiles)): ?>
                    <hr/><?php endif; ?>

                <?php foreach ($allFiles as $object) :

                    //pr ($object);
                    ?>
                    <div class="row">

                        <div class="col-lg-3">
                            <?= $this->Html->image('/SetupPages/fileView/' . $object['key_name'], ['style' => 'width: 250px;']); ?>
                        </div>

                        <div class="col-lg-9">

                            Filename: <?= $object['filename']; ?> (key_name: <?= $object['key_name']; ?>)
                            <?= $this->Html->link('Download', ['action' => 'fileDownload', $object['key_name']]); ?>

                            <br/>

                            <a style="color: red; font-weight: bold;"
                               href="<?= $webroot; ?>SetupPages/fileDelete/<?= $object['key_name']; ?>">X</a>

                        </div>

                    </div>
                <?php endforeach; ?>


            </td>
        </tr>
        <tr>
            <th>
                Object Storage (Store files in a database)
            </th>
            <td>
                <?php echo $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'SetupPages', 'action' => 'objAdd']]); ?>

                <?php echo $this->Form->file('fileToUpload', ['type' => 'button']); ?>

                <?= $this->Form->control('key_name', ['class' => 'form_control']); ?>
                <?= $this->Form->button('Upload'); ?>

                <?php echo $this->Form->end(); ?>

                <?php if (!empty($allFiles)): ?>
                    <hr/><?php endif; ?>

                <?php foreach ($allFiles as $object) :

                    //pr ($object);
                    ?>
                    <div class="row">

                        <div class="col-lg-3">
                            <?= $this->Html->image('/SetupPages/fileView/' . $object['key_name'],['style' => 'width: 250px;']); ?>
                        </div>

                        <div class="col-lg-9">

                            Filename: <?= $object['filename']; ?> (key_name: <?= $object['key_name']; ?>)
                            <?= $this->Html->link('Download', ['action' => 'fileDownload', $object['key_name']]); ?>

                            <br/>

                            <a style="color: red; font-weight: bold;"
                               href="<?= $webroot; ?>SetupPages/fileDelete/<?= $object['key_name']; ?>">X</a>

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
                As the user scrolls to the bottom of the page, the system will automatically load the next page / set of
                results. Instead of manually pushing next / previous pages.
            </td>
        </tr>
        <tr><!-- digital signage -->
            <th>
                <?php echo $this->Html->link('Digital Signage Template', ['controller' => 'SetupPages', 'action' => 'digitalSignage']); ?>

            </th>
            <td>
                Basic template for digital signage. Title, subtitle, text cycling between slides which can be scheduled
                with a php array
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
                Google Analytics GA4
            </th>
            <td>
                Google Analytics
                <br/>

                <?= $this->Html->link('GoogleAnalytics', [
                    'prefix' => false,
                    'controller' => 'SetupPages',
                    'action' => 'googleAnalytics'
                ]); ?>

            </td>
        </tr>
        <tr>
            <th>
                Export to CSV

            </th>
            <td>
                Export an array into a CSV file that is downloaded to your computer. Simply add to your controller a
                basic array of your prepared data.
                It will auto create the CSV and add headers to download to your computer

                <br/>
                SetupCase::downloadCsv($rows, $filename, $columnsSort = false);
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
                Common function to always call the correct JSON headers when you are sending data between the front-end
                / back-end API
            </td>
        </tr>




        <tr>
            <th>
                Read more with fade
            </th>
            <td>

                Show partial text with a fade out and link to reveal all

                <?= $this->Html->link('Read more with fade', ['action' => 'readMore'], ['class' => 'btn btn-primary']); ?>


            </td>
        </tr>


    </table>


    Code Blocks


    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
