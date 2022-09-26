
<?php if (isset($form_submitted)): ?>

<?php else: ?>

<?= $this->Form->create(null, ['url' => ['language' => $current_language, 'controller' => 'Users', 'action' => 'submitToUpdatecase']]); ?>
<div class="row">

	<div class="col-lg-6">
        <label><?= $updateCase->Translate('Name'); ?></label>
        <?= $this->Form->control('User.name', ['class' => 'form-control', 'required' => true, 'label' => false]); ?>

	</div>
	<div class="col-lg-6">
        <label><?= $updateCase->Translate('Last Name'); ?></label>
		<?= $this->Form->control('User.last_name', ['class' => 'form-control' ,'required' => true, 'label' => false]); ?>
	</div>
	<div class="col-lg-6">
        <label><?= $updateCase->Translate('Company Name'); ?></label>
		<?= $this->Form->control('User.company_name', array('class' => 'form-control','required' => true, 'label' => false)); ?>
	</div>

	<div class="col-lg-6">
        <label><?= $updateCase->Translate('Telephone'); ?></label>
		<?= $this->Form->control('User.telephone', array('class' => 'form-control' ,'required' => true, 'label' => false)); ?>
	</div>
	<div class="col-lg-12">
        <label><?= $updateCase->Translate('Email'); ?></label>
		<?= $this->Form->control('User.email', array('class' => 'form-control' ,'required' => true, 'label' => false)); ?>
	</div>
	<div class="col-lg-12">
        <label><?= $updateCase->Translate('Your company overview'); ?></label>
		<?= $this->Form->control('User.description', array(
            'type' => 'textarea',
            'class' => 'form-control', 'required' => true, 'label' => false)); ?>
	</div>
	<div class="col-lg-12 mb-2 mt-1">
		<p class="text-center"><?= $updateCase->Translate('Verify You are NOT Robot'); ?></p>
	</div>
	<div class="col-lg-12">

		<?= $this->Form->control('User.random_number', array(
				'class' => 'form-control',
				'value' => $random_number,
				'label' => false,
				'style' => '{background: black;, color: white}',
				'readonly' => true,


		)); ?>
	</div>
	<div class="col-lg-12">
	<?= $this->Form->control('User.human_verification', array(
		//'type' => 'password',
			'label' => false,
			'placeholder' => $updateCase->Translate('Put the above number in  reverse order'),
			'class' => 'form-control',
            'required' => true


	)); ?>
	</div>

	<div class="col-lg-12 mt-2">
		<?= $this->Form->submit($updateCase->Translate('Submit'), array('class'=>"btn btn-primary")); ?>
	</div>

</div>
<?= $this->Form->end(); ?>

<?php endif; //set the variable ?>
