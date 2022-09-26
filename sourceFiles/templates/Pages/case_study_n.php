<?php $updateCase->loadPageBySlug($slug); ?>
<?php
$url = strip_tags($updateCase->getContentBy('Main', 'url', false));
if (strpos($url, 'http://')) {
    $websiteUrl = $url;
} else if (strpos($url, 'https://')) {
    $websiteUrl = $url;
} else {
    $websiteUrl = 'http://'.$url;
}
?>
<style>
   .sticky{
       position: -webkit-sticky;
       position: sticky;
       top: 0;
       margin: 5px;
   }
    p {
        margin: 10px;
    }
</style>
<section class="section text-center text-lg-left">
    <div class="container">
        <div class="row">
            <div class="col-12 section-border">
                <article class="section-custom" style="padding-bottom: 25px; padding-top: 20px;">
                    <h1>
                        <?= $updateCase->getContentBy('Main', 'title', false); ?>
                    </h1>
                    <div class="blog-info" style="background-color: whitesmoke; padding-left: 13px;">
                        <div class="pull-md-left">
                            <time class="meta fa-calendar" datetime="2020">Launched: <?= $updateCase->getPageDate('F Y'); ?></time>
                            <?php $poweredBy = $updateCase->getContentBy('Main', 'poweredBy', false); ?>
                            <?php if ($poweredBy == 'website'): ?>
                                <?= $this->Html->link($updateCase->Translate('Business Websites Using SaaS'), array(
                                    'action' => 'home',
                                    '#' => 'SaaS'
                                ), array('class' => 'badge fa-arrow-right text-uppercase font-secondary')); ?>
                            <?php else: ?>
                                <?= $this->Html->link($updateCase->Translate('Custom Cloud Software'), array(
                                    'action' => 'home',
                                    '#' => 'CustomSoftware'
                                ), array('class' => 'badge fa-arrow-right text-uppercase font-secondary')); ?>
                            <?php endif; ?>
                            <a class="badge fa-link text-uppercase font-secondary" href="<?= $websiteUrl; ?>" target="_blank"><?= $url; ?></a>
                        </div>
                    </div>
                    <br/>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"></div>
            <div class="col-lg-6 ">
                <div class="sticky">
                    <?= $updateCase->getContentBy('Main', 'text', false); ?>
                </div>
            </div>
            <div class="col-lg-6">
                <img style=" padding-bottom: 5px; padding-top: 0;" src="<?= $webroot.$updateCase->getImage('Main', 'image', false, 'medium'); ?>" alt=""/>



                <div class="isotope" data-isotope-layout="masonry" data-isotope-group="gallery" data-lightgallery="group">
                    <div class="row">


                        <?php $groups = $updateCase->getGroupNamesByLocation('Gallery'); ?>
                        <?php if ($groups): foreach ($groups as $key => $group): ?>

                            <div class="col-12 col-lg-6 isotope-item eachItem" data-filter="type-1">
                                <div class="thumbnail-variant-2 thumbnail-4 text-center">
                                    <a href="<?= $webroot . $updateCase->getImage('Gallery', 'picture', $group, 'medium'); ?>" data-sub-html="<?=  $updateCase->getContentBy('Gallery', 'feature-title',  $group); ?>" data-lightgallery="item">
                                        <img src="<?= $webroot . $updateCase->getImage('Gallery', 'picture', $group, 'medium'); ?>" alt=""/>
                                        <div class="caption">
                                            <h4 class="text-white">

                                                Click to ZOOM

                                                <small>undoLogic Solutions</small>
                                            </h4>
                                        </div>
                                    </a>

                                    <?=  $updateCase->getContentBy('Gallery', 'feature-title',  $group); ?>

                                </div>
                            </div>

                        <?php endforeach; endif; ?>

                        <style>
                            .eachItem {
                                height: 200px;
                            }
                        </style>






                    </div>









                </div>
            </div><!-- /right col-lg-6 -->
        </div>
    </div>
</section>
<!-- BELOW IS STICKY -->

<section class="section section-sm inset-bottom-2 bg-dark-var2 text-center case-study-extra-box">
    <div class="jumbotron">
        <h1><small>undoLogic solutions</small>Learn more about</h1>

        <div class="button-group-variant no-offset">


            <?php $poweredBy = $updateCase->getContentBy('Intro', 'poweredBy', false); ?>
            <?php if ($poweredBy == 'website'): ?>



                <?= $this->Html->link($updateCase->Translate('Business Websites Using SaaS'), array(

                    'action' => 'home',
                    '#' => 'SaaS'

                ), array('class' => 'button button-default round-xl button-sm')); ?>
            <?php else: ?>


                <?= $this->Html->link($updateCase->Translate('Custom Cloud Software'), array(

                    'action' => 'home',
                    '#' => 'CustomSoftware'

                ), array('class' => 'button button-default round-xl button-sm')); ?>
            <?php endif; ?>



            <?= $this->Html->link($updateCase->Translate('Other Case Studies'), array(
                'controller' => 'Pages',
                'action' => 'caseStudies',
            ), array('class' => 'button button-default round-xl button-sm')); ?>



        </div>




    </div>
</section>

<?= $this->Element('a/visual-dev'); ?>
