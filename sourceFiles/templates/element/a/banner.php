<?= $updateCase->loadPageBySlug('All'); ?>
<header class="page-header">
    <!--RD Navbar-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar bg-default toggles-none" data-layout="rd-navbar-fixed"
             data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed"
             data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static"
             data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px"
             data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-top-panel">
                <div class="rd-navbar-inner">
                    <button class="rd-navbar-collapse-toggle"
                            data-rd-navbar-toggle=".list-inline, .fa-envelope, .fa-phone, .fa-shopping-cart">
                        <span></span></button>
                    <a class="fa-envelope" href="mailto:info@undologic.com">info@undologic.com</a><a class="fa-phone" href="tel:+18883888636">+1 (888) 388-UNDO (8636)</a>
                    <ul class="list-inline pull-right">
                        <!-- language -->
                        <?//= $this->Element('a/language'); ?>
                        <!-- end language -->

                        <?= $this->Element('a/social'); ?>


                    </ul>
                </div>
            </div>

            <div class="rd-navbar-inner">
                <!--RD Navbar Panel-->
                <div class="rd-navbar-panel">
                    <!--RD Navbar Toggle-->
                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar"><span></span></button>
                    <!--RD Navbar Brand-->
                    <div class="rd-navbar-brand">
                        <!--Brand--><a class="brand" href="<?= $webroot; ?>">
                            <img class="brand-logo-dark"
                                 src="<?= $webroot.$updateCase->getImage('Header', 'logo'); ?>"
                                 alt="" width="155"
                                 height="35"/><img
                                class="brand-logo-light" src="<?= $webroot.$updateCase->getImage('Header', 'logo'); ?>" alt=""
                                width="155" height="35"/></a>
                    </div>
                </div>
                <div class="rd-navbar-nav-wrap"><a class="fa-shopping-cart" href="shopping-cart.html"></a>
                    <!--RD Navbar Search-->
                    <div class="rd-navbar-search">
                        <form class="rd-search rd-navbar-search-form" action="search-results.html"
                              data-search-live="rd-search-results-live" method="GET">
                            <label class="rd-navbar-search-form-input">
                                <input type="text" name="s" placeholder="Search.." autocomplete="off">
                            </label>
                            <button class="rd-navbar-search-form-submit" type="submit"></button>
                            <div class="rd-search-results-live" id="rd-search-results-live"></div>
                        </form>
                        <button class="rd-navbar-search-toggle"
                                data-rd-navbar-toggle=".rd-navbar-search, .rd-navbar-live-search-results"></button>
                    </div>


                    <!--RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                        <?= $this->Element('a/menu'); ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <?= $updateCase->loadPageBySlug('Home'); ?>
    <!-- BANNER -->
    <?php if (isset($home)):?>
        <section>
            <!--Swiper-->
            <div class="swiper-container swiper-slider" data-autoplay="5000" data-slide-effect="fade" data-loop="false">
                <div class="jumbotron text-center">
                    <div class="shadedBackground">

                        <h1><small><?= $updateCase->getContentBy('Banner', 'sub_title'); ?></small>
                            <?= $updateCase->getContentBy('Banner', 'title'); ?>
                        </h1>
                        <div class="big"><?= $updateCase->getContentBy('Banner', 'text'); ?></div>

                        <div class='button-group-variant' style="margin-top: 38px;">
                            <a class='button button-default round-xl button-sm' href='<?= $updateCase->getContentBy('Banner', 'link'); ?>'>
                                <?= $updateCase->getContentBy('Banner', 'button'); ?>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="swiper-wrapper">


                    <?= $updateCase->loadPageBySlug('Home'); ?>

                    <?php $groups = $updateCase->getGroupNamesByLocation('Banner'); ?>

                    <?php if ($groups): foreach ($groups as $group): ?>
                        <div class="swiper-slide"

                             data-slide-bg="<?= $webroot.$updateCase->getImage('Banner', 'image', $group); ?>">
                            <div class="swiper-slide-caption"></div>
                        </div>
                    <?php endforeach; endif; ?>

                </div>
            </div>
        </section>
    <?php else: ?>




        <br/>
        <br/>

        <br/>
        <br/>






        <!-- END OF BANNER -->
    <?php endif; ?>
</header>
