
<style>
    h2 {
        text-align: center;
    }
</style>


<?php if (1): ?>

<?php $updateCase->loadPageBySlug($GLOBALS['UpdateCase']['slug']); ?>
<main class="page-content">

    <section class="text-center text-md-left well well-sm section-border">

        <!-- projects -->

        <div class="container">
            <h1 style="text-align: center;">
                <?= $updateCase->getContentBy('Main', 'title'); ?>
            </h1>

            <?= $updateCase->getContentBy('Main', 'content'); ?>


        </div>


    </section>
</main>

<?php else: ?>


    <?php $updateCase->loadPageBySlug($GLOBALS['UpdateCase']['slug']); ?>
    <main class="page-content">

        <section class="text-center text-md-left well well-sm section-border">

            <!-- projects -->

            <div class="container">
                <h2 style="text-align: center;"><?= $updateCase->getContentBy('Projects', 'title_top'); ?></h2>

                <?php $groups = $updateCase->getGroupNamesByLocation("Projects", 'ASC'); ?>
                <?php if ($groups): foreach ($groups as $group): ?>
                    <h3><?= $updateCase->getContentBy("Projects", "title", $group); ?></h3>
                    <?= $updateCase->getContentBy("Projects", "text", $group); ?>

                <?php endforeach; endif; ?>
            </div>


            <!-- hostinganddomains -->

            <div class="container">
                <h2 style="text-align: center;"><?= $updateCase->getContentBy('HostingAndDomains', 'title_top'); ?></h2>

                <?php $groups = $updateCase->getGroupNamesByLocation("HostingAndDomains", 'ASC'); ?>
                <?php if ($groups): foreach ($groups as $group): ?>
                    <h3><?= $updateCase->getContentBy("HostingAndDomains", "title", $group); ?></h3>
                    <?= $updateCase->getContentBy("HostingAndDomains", "text", $group); ?>

                <?php endforeach; endif; ?>
            </div>


            <!-- General -->

            <div class="container">
                <h2 style="text-align: center;"><?= $updateCase->getContentBy('General', 'title_top'); ?></h2>

                <?php $groups = $updateCase->getGroupNamesByLocation("General", 'ASC'); ?>
                <?php if ($groups): foreach ($groups as $group): ?>
                    <h3><?= $updateCase->getContentBy("General", "title", $group); ?></h3>
                    <?= $updateCase->getContentBy("General", "text", $group); ?>

                <?php endforeach; endif; ?>
            </div>
        </section>

    </main>

<?php endif; ?>




<br/>
<br/>
<br/>
<br/>
