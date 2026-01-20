<div class="card shadow-sm mb-4">

    <!-- Header -->
    <div class="card-header">
        <div class="d-flex align-items-start gap-3">

            <!-- Back icon + title -->
            <div class="d-flex align-items-center gap-2">

                <?= $this->Html->link(
                    '←',
                    ['action' => 'index'],
                    [
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'escape' => false,
                        'title' => 'Back to list',
                    ]
                ) ?>

                <div>
                    <h5 class="mb-1">
                        Email Record
                    </h5>
                    <p class="mb-0 text-muted small">
                        Record #<?= h($entity->id) ?>
                    </p>
                </div>

            </div>

            <!-- Actions -->
            <div class="ms-auto d-flex gap-2 flex-wrap">



                <?= $this->Form->postLink(
                    'Delete',
                    ['prefix' => 'Manager', 'action' => 'delete', $entity->id],
                    [
                        'class' => 'btn btn-sm btn-danger',
                        'confirm' => 'Are you sure you want to delete this record?'
                    ]
                ) ?>

                <button
                    type="button"
                    class="btn btn-sm btn-outline-info"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModalLive">
                    Help
                </button>

            </div>

        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Left column: Core fields -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Details</h6>
            </div>

            <div class="card-body">
                <dl class="row mb-0">

                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8"><?= h($entity->id) ?></dd>

                    <dt class="col-sm-4">User ID</dt>
                    <dd class="col-sm-8"><?= h($entity->user_id) ?></dd>

                    <dt class="col-sm-4">Email To</dt>
                    <dd class="col-sm-8">
                        <a href="mailto:<?= h($entity->email_to) ?>">
                            <?= h($entity->email_to) ?>
                        </a>
                    </dd>

                    <dt class="col-sm-4">Email From</dt>
                    <dd class="col-sm-8"><?= h($entity->email_from) ?></dd>

                    <dt class="col-sm-4">Language</dt>
                    <dd class="col-sm-8"><?= h($entity->lang) ?></dd>


                    <dt class="col-sm-4">Letter</dt>
                    <dd class="col-sm-8"><?= h($entity->letter) ?></dd>




                    <dt class="col-sm-4">Sent</dt>
                    <dd class="col-sm-8">
                        <?= $entity->sent
                            ? '<span class="badge bg-success">Sent</span>'
                            : '<span class="badge bg-secondary">Pending</span>' ?>
                    </dd>


                    <h6 class="text-muted">Response</h6>
                    <div class="border rounded p-2 bg-light small">
                        <?= $entity->response
                            ? nl2br(h($entity->response))
                            : '<span class="text-muted">No response recorded</span>' ?>
                    </div>

                </dl>
            </div>
        </div>
    </div>

    <!-- Right column: Content / response -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Message Data</h6>
            </div>

            <div class="card-body">



                <h3>Message HTML</h3>
                <pre>
                    <code><?= $entity->message_html; ?>

                    </code>
                </pre>

                <h3>Message TEXT</h3>

                <pre>
                    <code> <?= $entity->message_text; ?>
                    </code>
                </pre>






            </div>
        </div>
    </div>

</div>

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
