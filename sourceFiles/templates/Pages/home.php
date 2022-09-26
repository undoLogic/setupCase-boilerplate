<?= $updateCase->loadPageBySlug('Home'); ?>
<!--What We Offer-->
<section class="section section-sm text-center">
    <a name="About" class="anchor"></a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <h1 class=""><?= $updateCase->getContentBy('Below Banner', 'title'); ?></h1>
                <div class="lead big">
                    <?= $updateCase->getContentBy('Below Banner', 'text'); ?>
                </div>



                <div class="whatWeOfferBtns">
                    <?php $groups = $updateCase->getGroupNamesByLocation('Below Banner'); ?>
                    <?php if ($groups): foreach ($groups as $group): ?>
                        <!-- add code here -->
                        <a class="button button-default button-sm round-xs button-shadow smallerVersion" href="<?= $updateCase->getContentBy('Below Banner', 'target',  $group); ?>">
                            <?= $updateCase->getContentBy('Below Banner', 'links',  $group); ?>
                        </a>
                    <?php endforeach; endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- END OF What We Offer-->



<div class="page animated" style="animation-duration: 500ms; padding-bottom: 0px;">

    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.'images/subtle.jpg'; ?>);">
        <!--RD Navbar-->

    </header>
</div>

<!--Template Features--><!-- Custom Software -->
<section class="section section-sm bg-lighter relative  text-lg-left text-center">
    <a name="SaaS" class="anchor"></a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <h1 class=""><?= $updateCase->getContentBy('SAAS', 'sub_title', false); ?></h1>
                <div class="lead">
                    <?= $updateCase->getContentBy('SAAS', 'text'); ?>

                </div>
            </div>
        </div>

        <div class="row margin-1 row-30 pricing-border-left text-center">

            <?php $groups = $updateCase->getGroupNamesByLocation('SAAS'); ?>
            <?php if ($groups): foreach ($groups as $group): ?>
                <div class="col-md-6 col-xl-4 pricing-box pricing-box-hover bg-default">
                    <div class="thumbnail thumbnail-3">

                        <img  src="<?= $webroot.$updateCase->getImage('SAAS', 'image', $group); ?>" width="200"/>

                        <a class="button  button-default button-sm round-xl" style="font-size: 10px;"
                           href="<?= $updateCase->getContentBy('SAAS', 'link', $group); ?>" target="_blank"
                        >
                            <?= $updateCase->getContentBy('SAAS', 'link_label1',  $group); ?> <?= $updateCase->getContentBy('SAAS', 'title', $group); ?> <?= $updateCase->getContentBy('SAAS', 'link_label2',  $group); ?>
                        </a>

                        <div class="caption">

                            <?= $updateCase->getContentBy('SAAS', 'text', $group); ?>
                        </div>



                    </div>
                </div>
            <?php endforeach; endif; ?>

        </div>



    </div>
</section>

<section class="section section-sm text-center text-lg-left section-border">
    <a name="CustomSoftware" class="anchor"></a>
    <a name="BusinessSolutions" class="anchor"></a>
    <div class="container">
        <h1 class="text-center"><?= $updateCase->getContentBy('CustomSoftware', 'title'); ?></h1>
        <div class="row">
            <div class="col-md-12 col-lg-4 text-center inset-md order-lg-2">
                <div class="relative"> <img class="phone_1 active" src="<?= $webroot; ?>images/phone.jpg" alt="">
                    <svg id="svg-phone_1" version="1.1" viewBox="0 0 275 540" width="275px" height="540px" class="active">
                        <path id="phone" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M183,1c18.665,0,29.335,0,44,0c0,1,0,2,0,3c21.595-0.146,30.235,5.71,39,22c1,0.667,2,1.333,3,5c4.243,11.06,4,37.589,4,60c0,44.996,0,90.004,0,135c0,73.326,0,146.674,0,220c0,18.998,0,38.002,0,46c0,12.022,0.526,22.817-4,30c-11.989,19.022-32.434,17-63,17c-39.33,0-78.67,0-118,0c-17.998,0-36.002,0-52,0c-15.333-0.333-12.667-4.667-16-3c-2.538-1.92-12.781-16.644-14-27c0-1.667,0-3.333,0-5c-3.723-13.422-1-38.227-1-54c0-55.995,0-112.005,0-168c0-30.33,0-60.67,0-91c0-6.666,0-13.334,0-20c-0.667,0-1.333,0-2,0c0-6,0-12,0-18c0.667-0.333,1.333-0.667,2-1c0-9.666,0-19.334,0-29c-0.667,0-1.333,0-2,0c0-6,0-12,0-18c0.667,0,1.333,0,2,0c0-1.667,0-3.333,0-5c0-8.666,0-17.334,0-26c-0.667,0-1.333,0-2,0c0-8.666,0-17.334,0-26c0.667,0,1.333,0,2,0c0-4.666,0-9.334,0-14c2.542-8.685,7.445-18.225,14-23C32.223,1.911,49.231,4,75,4c35.997,0,72.003,0,108,0C183,3,183,2,183,1z"></path>
                        <path id="screen" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M22,97c77.659,0,155.341,0,233,0c0,116.322,0,232.678,0,349c-77.659,0-155.341,0-233,0C22,329.678,22,213.322,22,97z"></path>
                        <path id="rnd1" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M139,467c13.807,0,25,11.193,25,25s-11.193,25-25,25s-25-11.193-25-25S125.193,467,139,467z"></path>
                        <path id="rnd" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M92,43c3.866,0,7,3.134,7,7s-3.134,7-7,7s-7-3.134-7-7S88.134,43,92,43z"></path>
                        <path id="din1" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M123,23c9.666,0,19.334,0,29,0c0,2,0,4,0,6c-9.666,0-19.334,0-29,0C123,27,123,25,123,23z"></path>
                        <path id="din" fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke-miterlimit="10" d="M113,45c16.998,0,34.001,0,51,0c0,3,0,6,0,9c-16.999,0-34.002,0-51,0C113,51,113,48,113,45z"></path>
                    </svg>
                </div>
            </div>

            <div class="col-md-6 col-lg-8 order-lg-1">

                <div class="lead margin-2">
                    <?= $updateCase->getContentBy('CustomSoftware', 'text_one'); ?>
                </div>
                <img class="pull-md-left" style="margin: 20px 30px 30px 0px;" src="<?= $webroot.$updateCase->getImage('CustomSoftware', 'image'); ?>" width="400" alt="">



                <!-- right text -->
                <div class="lead">
                    <?= $updateCase->getContentBy('CustomSoftware', 'text-right'); ?>
                </div>


                <?= $this->Html->link($updateCase->getContentBy('CustomSoftware', 'callToAction', false), array(
                    'action' => 'contact'
                ), array(
                    'class' => 'button button-default button-sm round-xl button-shadow smallerVersion btn-block'
                )); ?>


            </div>
        </div>
    </div>






</section>


<div class="page animated" style="animation-duration: 500ms; padding-bottom: 10px;">

    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.'images/subtle.jpg'; ?>); ">
        <!--RD Navbar-->


    </header>
</div>




<?= $this->Element('a/visual-dev'); ?>


<!-- support -->
<div class="page animated" style="animation-duration: 500ms; padding-bottom: 0px;">
    <a name="Support" class="anchor"></a>
    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.$updateCase->getImage('Support', 'background'); ?>); ">
        <!--RD Navbar-->

        <div class="text-center">
            <div class="jumbotron text-center mt-5">
                <h1><?= $updateCase->getContentBy('Support', 'title'); ?></h1>
            </div>


        </div>
        <section class="section">
            <div class="container">
                <div class="row row-30">


                    <div class="container">
                        <div class="row margin-1 row-11">
                            <?php $groups = $updateCase->getGroupNamesByLocation('Support'); ?>

                            <?php if ($groups): foreach ($groups as $group): ?>
                                <!-- add code here -->

                                <div class="col-md-6">
                                    <div class="box-sm box-skin-1 bg-lighter box-skin-left-offset-negative supportBox">
                                        <div class="box__left box-md-inset-1"><span class="icon icon-md icon-primary line-height-1 <?= $updateCase->getContentBy('Support', 'fa',  $group); ?>"></span></div>
                                        <div class="box__body box__middle">
                                            <h5><?= $updateCase->getContentBy('Support', 'title',  $group); ?></h5>
                                            <p><?= $updateCase->getContentBy('Support', 'link1',  $group); ?>
                                                <a href="<?= $updateCase->getContentBy('Support', 'href',  $group); ?>" target="_blank">
                                                    <?= $updateCase->getContentBy('Support', 'link2',  $group); ?></a>
                                                <?= $updateCase->getContentBy('Support', 'link3',  $group); ?>
                                            </p>
                                                <?= $updateCase->getContentBy('Support', 'text',  $group); ?>
                                                <?php if($group == 3): ?>
                                                <a href="http://www.updatecase.com/eng/Pages/faqs">UpdateCase FAQ</a>
                                                |
                                                <a href="https://www.setupcase.com/Pages/faqs">SetupCase FAQ</a>
                                                |
                                                <a href="https://www.projectbrowser.com/Pages/faqs">Project Browser FAQ</a>

                                                <?php endif; // for group 3 ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; endif; ?>

                        </div>
                    </div>




                </div>
            </div>
        </section>
    </header>

</div>









<div class="page animated" style="animation-duration: 500ms; padding-bottom: 0px;">

    <header class="header-custom  bg-image bg-image-2 inset-bottom-3" style="
        background-attachment: fixed;
        background-position: center center;
        background-image: url(<?= $webroot.'images/subtle.jpg'; ?>);">
        <!--RD Navbar-->

    </header>
</div>
