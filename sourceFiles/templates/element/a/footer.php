<?= $updateCase->loadPageBySlug('All'); ?>
<footer class="page-footer footer-widget text-center">
    <div class="footer-content text-center text-md-left">
        <div class="container">
            <a name="Contact" class="anchor"></a>
            <div class="row row-30">

                <!-- left -->
                <div class="col-6 col-lg-3">

                    <div class="navbar-brand">
                        <!--Brand-->
                        <a class="brand" href="http://www.undologic.comeng/pages/home" target="_blank">
                            <img src="<?= $webroot.$updateCase->getImage('Header', 'logo'); ?>" alt="" width="155" height="35">
                        </a>
                    </div>


                    <div class="row" style="margin-top: 0px;">
                        <div class="col-6">


                            <div class="contact-info">
                                <dl>
                                    <dt><?= $updateCase->getContentBy('Footer-left', 'phone'); ?></dt>
                                    <dd><a href="tel:<?= $updateCase->getContentBy('Footer-left', 'phone_link'); ?>"><?= $updateCase->getContentBy('Footer-left', 'phone_link'); ?></a></dd>
                                    <dt><?= $updateCase->getContentBy('Footer-left', 'tollFree'); ?></dt>
                                    <dd><a href="tel:<?= $updateCase->getContentBy('Footer-left', 'tollFree_link'); ?>"><?= $updateCase->getContentBy('Footer-left', 'tollFree_link'); ?></a></dd>
                                    <dt><?= $updateCase->getContentBy('Footer-left', 'email'); ?></dt>
                                    <dd><a href="mailto:Info@undoLogic.com">
                                            <?= $updateCase->getContentBy('Footer-left', 'email_link'); ?></a></dd>
                                </dl>
                            </div>

                            <address>
                                <div><?= $updateCase->getContentBy('Footer-left', 'address'); ?></div>
                            </address>



                        </div>

                    </div>





                </div><!-- /left col -->


                <!-- end of left col -->


                <div class="col-6 col-lg-3">
                    <div class="" style="margin-top: 65px;">
                        <h6>Sitemap</h6>
                        <ul class="marked-list text-primary">
                            <?= $this->Element('a/menu'); ?>
                        </ul>
                    </div>
                </div>


                <div class="col-6 col-lg-6">
                    <div class="" style="    margin-top: 65px;">
                        <h6><?= $updateCase->getContentBy('Footer-Right', 'title'); ?></h6>
                        <article class="text-primary">
                            <p><a class="text-primary" target="_blank" href="<?= $updateCase->getContentBy('Footer-Right', 'url', '1'); ?>"><?= $updateCase->getContentBy('Footer-Right', 'link', '1'); ?></a></p>
                            <time class="text-light-clr" datetime="2020"><?= $updateCase->getContentBy('Footer-Right', 'sub_title', '1'); ?></time>
                        </article>
                        <article class="text-primary">
                            <p><a class="text-primary" target="_blank" href="<?= $updateCase->getContentBy('Footer-Right', 'url', '2'); ?>"><?= $updateCase->getContentBy('Footer-Right', 'link', '2'); ?></a></p>
                            <time class="text-light-clr" datetime="2020"><?= $updateCase->getContentBy('Footer-Right', 'sub_title', '2'); ?></time>
                        </article>
                        <article class="text-primary">
                            <p><a class="text-primary" target="_blank" href="<?= $updateCase->getContentBy('Footer-Right', 'url', '3'); ?>"><?= $updateCase->getContentBy('Footer-Right', 'link', '3'); ?></a></p>
                            <time class="text-light-clr" datetime="2020"><?= $updateCase->getContentBy('Footer-Right', 'sub_title', '3'); ?></time>
                        </article>
                    </div>
                </div>



                <!-- end of right -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div>
    <div class="copyright text-center">
        <div class="container">
            <div class="d-flex justify-content-center justify-content-md-between align-items-center flex-wrap flex-md-nowrap flex-md-row-reverse">
                <ul class="list-inline">
                    <?= $this->Element('a/social'); ?>
                </ul>
                <p class="rights"><span>
                        ©&nbsp;</span><span class="copyright-year"><?= date('Y'); ?>>
                    </span><span>&nbsp;</span>

                    <span><?= $updateCase->getContentBy('Footer-bottom', 'company'); ?></span>

                    <span>&nbsp;</span><span><?= $updateCase->getContentBy('Footer-bottom', 'rights'); ?></span>

                    <span>.&nbsp;</span>

                    <?= $this->Html->link('Terms and Conditions', [
                        'action' => 'terms'
                    ]); ?>

                </p>
            </div>
        </div>
    </div>
</footer>
