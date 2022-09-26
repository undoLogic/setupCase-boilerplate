<?php $updateCase->loadPageBySlug('Projects'); ?>

<section class="section section-sm text-center allProjects">
	<div class="container-fluid no-gutter-md">
		<div class="row">
			<div class="col-12">
				<h1><?= $updateCase->getContentBy('Main', 'title', false); ?></h1>
				<div class="lead">

					<?= $updateCase->getContentBy('Main', 'text', false); ?>

				</div>
			</div>
			<div class="col-12 margin-1">
				<div class="isotope-filters isotope-filters-horizontal">
					<ul class="inline-list button-group-isotope isotope-filters-list" id="isotope-filters">
                        <?php $groups = $updateCase->getGroupNamesByLocation('Main'); ?>

                        <?php if ($groups): foreach ($groups as $group): ?>
                            <!-- add code here -->
                            <li>
                                <a class="active button button-default button-xs round-xl" href="#" data-isotope-filter="<?= $updateCase->getContentBy('Main', 'filter',  $group); ?>" data-isotope-group="gallery">
                                    <?= $updateCase->getContentBy('Main', 'label',  $group); ?>
                                </a>
                            </li>
                        <?php endforeach; endif; ?>

					</ul>
				</div>
			</div>
		</div>

		<div class="isotope margin-1 isotope-condensed" data-isotope-layout="masonry" data-isotope-group="gallery" data-lightgallery="group">
			<?php $slugsFromTags = $updateCase->getPageSlugsByTag('Project', 'DATE-DESC');
				//pr ($updateCase->getContentBy('Intro', 'title', false));
				//pr ($slugsFromTags);exit;
			?>


			<?php foreach ($slugsFromTags as $slugFromTag): ?>

				<?php $updateCase->loadPageBySlug($slugFromTag);

                if (!$updateCase->isNotEmpty('Main','title')) continue;
                ?>

				<div class="thumbnail-variant-2 thumbnail-4_col10 width_20 text-center isotope-item eachProject" data-filter="<?= strtolower($updateCase->getContentBy('Main', 'poweredBy', false)); ?>">



						<a href="<?= $webroot; ?><?= $this->Lang->get(); ?>/Pages/caseStudy/<?= $slugFromTag; ?>">

                            <img src="<?= $webroot.$updateCase->getImage('Main', 'image', false, 'medium'); ?>" alt=""/>


                            <div class="caption" >
                                <h4 class="text-white"><?= $updateCase->getContentBy('Main', 'title', false); ?>

                                    <small>
                                        <?php $poweredBy = $updateCase->getContentBy('Main', 'poweredBy', false); ?>
                                        <?php if ($poweredBy == 'website'): ?>
                                            <?= $updateCase->Translate('Business Websites Using SaaS'); ?>
                                        <?php else: ?>
                                            <?= $updateCase->Translate('Custom Cloud Software'); ?>
                                        <?php endif; ?>
                                    </small>
                                </h4>
                            </div>

						</a>







				</div>

			<?endforeach; //tags ?>

		</div>
	</div>
</section>
