<?= $updateCase->loadPageBySlug('Contact'); ?>

<!-- support -->
<div class="page animated" style="animation-duration: 500ms; padding-bottom: 0px;">

    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.$updateCase->getImage('1-ContactInfo', 'background', false, 'medium'); ?>); ">
        <!--RD Navbar-->

        <div class="text-center">
            <div class="jumbotron text-center mt-5">
                <h1>
                    <?= $updateCase->getContentBy('1-ContactInfo', 'title', false); ?>
                </h1>
            </div>


        </div>

        <section class="section">
            <div class="container">

                <div class="row row-30">

                    <div class="col-lg-6 text-center text-lg-left">
                        <?= $updateCase->loadPageBySlug('All'); ?>
                        <address class="contact-block bg-default button-shadow py-5 px-4 round-large">

                            <h4>
                                undoLogic Inc.
                            </h4>
                            <dl class="list-md">
                                <dt class="heading-6"><?= $updateCase->Translate('ADDRESS'); ?></dt>
                                <dd>
                                    <?= $updateCase->getContentBy('Footer-left', 'address'); ?>
                                </dd>

                                <dt class="heading-6"><?= $updateCase->Translate('TELEPHONE'); ?></dt>
                                <dd>
                                    <?= $updateCase->Translate('Toll-Free'); ?>: <a href="tel:<?= $updateCase->getContentBy('Footer-left', 'tollFree_link', false); ?>" target="_blank">
                                        <?= $updateCase->getContentBy('Footer-left', 'tollFree_link', false); ?>
                                    </a>

                                    <?= $updateCase->Translate('Montreal'); ?>:
                                    <a href="tel: <?= $updateCase->getContentBy('Footer-left', 'phone_link', false); ?>">
                                        <?= $updateCase->getContentBy('Footer-left', 'phone_link', false); ?>
                                    </a>

                                </dd>
                                <dt class="heading-6">
                                    <?= $updateCase->Translate('E-MAIL'); ?>
                                </dt>
                                <dd>
                                    <a href="mailto:Info@undoLogic.com" target="_blank">
                                        <?= $updateCase->getContentBy('Footer-left', 'email_link'); ?>
                                    </a>

                                </dd>
                            </dl>
                            <br/>


                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.1029794222454!2d-73.58892704844844!3d45.48787097899862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a77d7411c5d%3A0x55eb2f54f64c13b5!2sundoLogic%20Inc.!5e0!3m2!1sen!2sca!4v1617404078514!5m2!1sen!2sca" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>


                        </address>








                    </div><!-- END OF LEFT -->


                    <?php if (0): ?>

                    <?= $updateCase->loadPageBySlug('Contact'); ?>

                    <!-- RIGHT STARTS HERE -->
                    <div class="col-lg-6">
                        <div class="button-shadow bg-default py-5 px-3 round-large">
                            <h5 class="text-center">
                                <?= $updateCase->getContentBy('Form', 'title', false); ?>

                            </h5>

                            <?= $updateCase->getContentBy('Form', 'text', false); ?>

                            <?= $this->element('a/customer_submit', array('random_number' => $random_number, 'current_language' => $lang)); ?>

                        </div>
                    </div>
                    <!-- END OF RIGHT -->

                    <?php endif; ?>
                </div>


            </div>
        </section>
    </header>

</div>











