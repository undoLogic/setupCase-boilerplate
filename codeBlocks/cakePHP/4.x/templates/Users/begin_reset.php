<?= $this->Form->create(); ?>
    <div class="card">
        <div class="card-header">
            <h5>Reset</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-12">
                    <?= $this->Form->control('email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
                    <?= $this->Form->submit('Begin Reset Process', ['class' => 'btn btn-primary']); ?>
                </div>

            </div>
        </div>
    </div>
<?= $this->Form->end(); ?>
