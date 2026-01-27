<?= $this->Form->create($entity, [
    'class' => 'needs-validation',
    'novalidate' => true
]) ?>

<?= $this->Form->hidden('cameFrom', ['value' => $cameFrom]) ?>

<div class="card shadow-sm mb-4">

    <!-- Header -->
    <div class="card-header">
        <div class="d-flex align-items-start gap-3">

            <!-- Back icon + title -->
            <div class="d-flex align-items-center gap-2">

                <?= $this->Html->link(
                    '←',
                    ['prefix' => 'Staff', 'action' => 'index'],
                    [
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'title' => 'Back to list',
                    ]
                ) ?>

                <div>
                    <h5 class="mb-1"><?= h($pageTitle) ?></h5>
                    <p class="mb-0 text-muted small"><?= h($pageSubTitle) ?></p>
                </div>

            </div>

            <!-- Actions -->
            <div class="ms-auto d-flex gap-2 flex-wrap">


            </div>

        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Left column -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Basic Information</h6>
            </div>

            <div class="card-body">

                <div class="mb-3 row">
                    <?= $this->Form->label('name', 'Name', ['class' => 'col-sm-3 col-form-label']) ?>
                    <div class="col-sm-9">
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control',
                        ]) ?>
                    </div>
                </div>





                <?= $this->Form->button(
                    $isCreate ? 'Create' : 'Save Changes',
                    ['class' => 'btn btn-primary w-100']
                ) ?>

            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Users</h6>
            </div>

            <div class="card-body">
                <?= $this->Form->control('users._ids', [
                    'multiple' => 'checkbox',
                    'label' => 'Users',
                    'options' => $users,
                    //'class' => 'form-control select2'

                    // 'class' => 'multiple-checkbox'
                ]);
                ?>

            </div>
        </div>
    </div>

</div>

<?= $this->Form->end() ?>

<!-- Help Modal -->
<div class="modal fade" id="exampleModalLive" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Help</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Popup
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
