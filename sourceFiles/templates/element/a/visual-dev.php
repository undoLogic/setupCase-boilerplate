<?= $updateCase->loadPageBySlug('VisualDev'); ?>
<section class="section section-sm  relative text-center">
    <a name="visualDev" class="anchor"></a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <h1 class=""><?= $updateCase->getContentBy('Main', 'title', false); ?></h1>
                <div class="lead">
                    <p>
                        <?= $updateCase->getContentBy('Main', 'text', false); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>





<section class="section text-center text-lg-left timeline">


    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 text-left text-lg-center">
                <time class="h5 meta-timeline" datetime="2020"><?= $updateCase->getContentBy('BrainStorming', 'title', false); ?></time>
            </div>
            <div class="col-11 col-lg-5 col-lg-offset-0">
                <article class="thumbnail section-custom view-animate slow-hover">

                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('BrainStorming', 'title_left', false); ?></h4>
                        <p class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('BrainStorming', 'text_left', false); ?>
                        </p>

                    </div>
                </article>

            </div>
            <div class="col-11 col-lg-5 inset-1 timeline-right">
                <article class="thumbnail section-custom view-animate slow-hover">
                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('BrainStorming', 'title_right', false); ?></h4>
                        <p class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('BrainStorming', 'text_right', false); ?>
                        </p>

                    </div>
                </article>
            </div>








            <div class="col-12 text-left text-lg-center">
                <time class="h5 meta-timeline" datetime="2020"><?= $updateCase->getContentBy('VISUAL DEVELOPMENT', 'title', false); ?></time>
            </div>

            <div class="col-11 col-lg-5 col-lg-offset-0">
                <article class="thumbnail section-custom view-animate slow-hover">

                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('VISUAL DEVELOPMENT', 'title_left', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('VISUAL DEVELOPMENT', 'text_left', false); ?>
                        </span>

                    </div>
                </article>

            </div>
            <div class="col-11 col-lg-5 inset-1 timeline-right">
                <article class="thumbnail section-custom view-animate slow-hover">
                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('VISUAL DEVELOPMENT', 'title_right', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('VISUAL DEVELOPMENT', 'text_right', false); ?>
                        </span>

                    </div>
                </article>

            </div>





            <div class="col-12 text-left text-lg-center">
                <time class="h5 meta-timeline" datetime="2020"><?= $updateCase->getContentBy('PROGRAMMING', 'title', false); ?></time>
            </div>

            <div class="col-11 col-lg-5 col-lg-offset-0">
                <article class="thumbnail section-custom view-animate slow-hover">

                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('PROGRAMMING', 'title_left', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('PROGRAMMING', 'text_left', false); ?>
                        </span>

                    </div>
                </article>

            </div>
            <div class="col-11 col-lg-5 inset-1 timeline-right">
                <article class="thumbnail section-custom view-animate slow-hover">
                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('PROGRAMMING', 'title_right', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('PROGRAMMING', 'text_right', false); ?>
                           </span>

                    </div>
                </article>

            </div>







            <div class="col-12 text-left text-lg-center">
                <time class="h5 meta-timeline" datetime="2020"><?= $updateCase->getContentBy('LAUNCH', 'title', false); ?></time>
            </div>

            <div class="col-11 col-lg-5 col-lg-offset-0">
                <article class="thumbnail section-custom view-animate slow-hover">

                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('LAUNCH', 'title_left', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('LAUNCH', 'text_left', false); ?>
                        </span>

                    </div>
                </article>

            </div>
            <div class="col-11 col-lg-5 inset-1 timeline-right">
                <article class="thumbnail section-custom view-animate slow-hover">
                    <div class="caption max-width">
                        <h4><?= $updateCase->getContentBy('LAUNCH', 'title_right', false); ?></h4>
                        <span class="text-dark-variant-2">
                            <?= $updateCase->getContentBy('LAUNCH', 'text_right', false); ?>
                           </span>

                    </div>
                </article>

            </div>




            <div class="col-12 text-center margin-4">
                <a href="<?= $webroot; ?>Pages/contact" class="button button-primary round-xl timeline-button">
                    <span class="hiddenPhone"><?= $updateCase->getContentBy('Main', 'hidden_phone', false); ?></span>
                    <span class="hiddenDesktop"><?= $updateCase->getContentBy('Main', 'hidden_desktop', false); ?></span>

                </a>
            </div>
        </div>
    </div>
</section>
<?= $updateCase->loadPageBySlug('Home'); ?>
