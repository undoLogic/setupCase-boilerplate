<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Upload File</h5>
        </div>
        <div class="card-body">
            <?= $this->Form->create(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <?= $this->Form->control('file_upload', ['type' => 'file']); ?>
                </div>
                <div class="col-lg-6">
                    <?= $this->Form->button('Submit'); ?>
                </div>

            </div>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
