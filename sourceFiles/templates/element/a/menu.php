<?php if (isset($home)) {
	$action = false;
} else {
	$action = 'home';
} ?>

<li class="rd-nav-item">
	<?= $this->Html->link($updateCase->Translate('Home'), array(

			'controller' => 'Pages',
		'action' => $action,

	), array('class' => 'rd-nav-link')); ?>

</li><li class="rd-nav-item">


	<?= $this->Html->link('About', array(
			'controller' => 'Pages',
		'action' => $action,
		'#' => 'About'

	), array('class' => 'rd-nav-link')); ?>

</li><li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('SaaS'), array(
			'controller' => 'Pages',
		'action' => $action,
		'#' => 'SaaS'

	), array('class' => 'rd-nav-link')); ?>

</li><li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('Custom Cloud Software / Business Solutions'), array(
			'controller' => 'Pages',
		'action' => $action,
		'#' => 'CustomSoftware'

	), array('class' => 'rd-nav-link')); ?>

</li>



<li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('Our Process'), array(
			'controller' => 'Pages',
			'action' => $action,
			'#' => 'visualDev'

	), array('class' => 'rd-nav-link')); ?>

</li>


<li class="rd-nav-item">

    <?= $this->Html->link($updateCase->Translate('Team'), array(
        'controller' => 'Pages',
        'action' => 'team',

    ), array('class' => 'rd-nav-link')); ?>
</li>



<li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('Case Studies'), array(
			'controller' => 'Pages',
			'action' => 'caseStudies',


	), array('class' => 'rd-nav-link')); ?>

</li>

<li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('Support'), array(
			'controller' => 'Pages',
		'action' => $action,
		'#' => 'Support'

	), array('class' => 'rd-nav-link')); ?>

</li>

<li class="rd-nav-item">

	<?= $this->Html->link($updateCase->Translate('Contact'), array(
		'controller' => 'Pages',
		'action' => 'contact',

	), array('class' => 'rd-nav-link')); ?>
</li>
