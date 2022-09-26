<?= $updateCase->loadPageBySlug('Team'); ?>

<!-- support -->
<div class="page animated" style="animation-duration: 500ms; padding-bottom: 0px;">

    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.$updateCase->getImage('Main', 'background', false, 'medium'); ?>); ">
        <!--RD Navbar-->

        <div class="text-center">
            <div class="jumbotron text-center mt-5">
                <h1>
                    <?= $updateCase->getContentBy('Main', 'title', false); ?>
                </h1>
            </div>


        </div>

        <section class="section">
            <div class="container">

                <div class="row row-30">

                    <div class="col-lg-12 text-center text-lg-left">
                        <!-- sacha -->
                        <div class="card mb-1">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <!-- left image -->
                                    <div class="col-md-4 col-lg-3 text-center">

                                        <img src="<?= $webroot.$updateCase->getImage('Large', 'image', false, 'medium'); ?>"

                                             alt="">


                                    </div>
                                    <!-- right section -->
                                    <div class="col-md-8 col-lg-8" style="">
                                        <!-- title -->
                                        <div class="box-sm inset-2" style="padding-top: 20px;">
                                            <div class="box__body box__middle">

                                                <ul class="list-inline list-inline list-inline-3" style="float: right;">
                                                    <li><a class="icon fa-linkedin-square icon-xxs" href="https://www.linkedin.com/in/sacha-lewis/" target="_blank"></a></li>
                                                    <li><a class="icon fa-instagram icon-xxs" href="https://www.instagram.com/sacha.lewis.d/" target="_blank"></a></li>
                                                    <li><a class="icon fa-phone-square icon-xxs" href="tel:18883888636ext6" target="_blank"></a></li>
                                                </ul>

                                                <h5><?= $updateCase->getContentBy('Large', 'title', false); ?></h5>
                                                <h6><?= $updateCase->getContentBy('Large', 'sub_title', false); ?></h6>
                                                <span class="mt-2 text-justify">
                                                    <br/>
                                                    <?= $updateCase->getContentBy('Large', 'text', false); ?>
                                                </span>


                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of sacha -->
                    </div><!-- top -->
                </div>









                <?php $groups = $updateCase->getGroupNamesByLocation('Medium'); ?>
                <?php if ($groups): foreach ($groups as $group): ?>

                    <div class="row row-30">

                        <div class="col-lg-12 text-center text-lg-left">
                            <!-- sacha -->
                            <div class="card mb-1">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <!-- left image -->
                                        <div class="col-md-4 col-lg-3 text-center">

                                            <img src="<?= $webroot.$updateCase->getImage('Medium', 'image', $group, 'medium'); ?>"

                                                 alt="">


                                        </div>
                                        <!-- right section -->
                                        <div class="col-md-8 col-lg-8" style="">
                                            <!-- title -->
                                            <div class="box-sm inset-2" style="padding-top: 20px;">
                                                <div class="box__body box__middle">

                                                    <ul class="list-inline list-inline list-inline-3" style="float: right;">

                                                        <?php if ($updateCase->isNotEmpty('Medium', 'social_linkedin',  $group)): ?>
                                                            <li><a class="icon fa-linkedin-square icon-xxs" href="<?= $updateCase->getContentBy('Medium', 'social_linkedin',  $group); ?>" target="_blank"></a></li>
                                                        <?php endif; ?>

                                                        <?php if ($updateCase->isNotEmpty('Medium', 'phone',  $group)): ?>
                                                            <li><a class="icon fa-phone-square icon-xxs" href="tel:<?= $updateCase->getContentBy('Medium', 'phone',  $group); ?>" target="_blank"></a></li>
                                                        <?php endif; ?>

                                                    </ul>

                                                    <h5><?= $updateCase->getContentBy('Medium', 'title', $group); ?></h5>
                                                    <h6><?= $updateCase->getContentBy('Medium', 'sub_title', $group); ?></h6>
                                                    <span class="mt-2 text-justify">
                                                    <br/>
                                                    <?= $updateCase->getContentBy('Medium', 'text', $group); ?>
                                                </span>


                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of sacha -->
                        </div><!-- top -->
                    </div>


                <?php endforeach; endif; ?>







            </div>
        </section>
    </header>

</div>



















