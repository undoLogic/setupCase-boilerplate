<style>
    .card td {
        word-wrap: anywhere;
    }

    pre {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        padding: 8px;
        font-size: 0.85rem;
    }
    pre {
        max-height: 500px;
        overflow: auto;
        max-width: 500px;
    }




</style>
<div class="card shadow-sm mb-4">

    <!-- Header -->
    <div class="card-header">
        <div class="d-flex align-items-start gap-3">

            <!-- Back + Title -->
            <div class="d-flex align-items-center gap-2">

                <?= $this->Html->link(
                    '←',
                    ['action' => 'index'],
                    [
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'escape' => false,
                        'title' => 'Back to audit log',
                    ]
                ) ?>

                <div>
                    <h5 class="mb-1">
                        <?= strtoupper(h($entity->action)) ?>
                        on <?= h($entity->table_name) ?>
                    </h5>
                    <p class="mb-0 text-muted small">
                        Record ID: <?= $entity->entity_id ?? '—' ?>
                    </p>
                </div>

            </div>

            <!-- Meta -->
            <div class="ms-auto text-end">
                <div class="small text-muted">
                    <?= $entity->created?->format('Y-m-d H:i:s') ?>
                </div>
                <div class="small">
                    <?= $entity->user_id !== null
                        ? 'User #' . h($entity->user_id)
                        : '<span class="text-muted">System</span>' ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Left column: Audit Details -->
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Audit Details</h6>
            </div>

            <div class="card-body">

                <dl class="row mb-0">

                    <div class="col-6">
                        <dt class="col-4 text-muted">Action</dt>
                        <dd class="col-8">
                            <span class="badge bg-<?= match ($entity->action) {
                                'insert' => 'success',
                                'update' => 'warning',
                                'delete' => 'danger',
                                default => 'secondary',
                            } ?>">
                                <?= strtoupper(h($entity->action)) ?>
                            </span>
                        </dd>

                        <dt class="col-4 text-muted">Table</dt>
                        <dd class="col-8"><?= h($entity->table_name) ?></dd>

                        <dt class="col-4 text-muted">Record ID</dt>
                        <dd class="col-8"><?= h($entity->entity_id ?? '—') ?></dd>


                        <dt class="col-4 text-muted">Date</dt>
                        <dd class="col-8">
                            <?= $entity->created?->format('Y-m-d H:i:s') ?>
                        </dd>
                    </div>

                    <div class="col-6">
                        <dt class="col-4 text-muted">User</dt>
                        <dd class="col-8">
                            <?= $entity->user_id !== null
                                ? 'User #' . h($entity->user_id)
                                : 'System / CLI' ?>

                            <?php if (isset($entity['user']['fullName'])): ?>
                                <?= $entity['user']['fullName']; ?>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-4 text-muted">IP</dt>
                        <dd class="col-8"><?= h($entity->ip_address ?? '—') ?></dd>


                    </div>

                </dl>



            </div>
        </div>
    </div>

    <!-- Right column: Changes -->
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Changes</h6>
            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Field</th>
                        <th>Before</th>
                        <th>After</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $before = (array)json_decode($entity->original_fields ?? '{}', true);
                    $after  = (array)json_decode($entity->changed_fields ?? '{}', true);

                    $fields = array_unique(array_merge(
                        array_keys($before),
                        array_keys($after)
                    ));

                    // Normalize values for reliable comparison
                    $normalize = function ($value) {
                        if (is_array($value) || is_object($value)) {
                            return json_encode(
                                $value,
                                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                            );
                        }
                        return (string)$value;
                    };
                    ?>

                    <?php if (empty($fields)): ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center py-3">
                                No field-level changes recorded
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($fields as $field):

                            $beforeVal = $before[$field] ?? null;
                            $afterVal  = $after[$field]  ?? null;

                            $beforeNorm = isset($beforeVal) ? $normalize($beforeVal) : null;
                            $afterNorm  = isset($afterVal)  ? $normalize($afterVal)  : null;

                            $isDifferent = $beforeNorm !== $afterNorm;


                            if ($beforeNorm == '[]' && $afterNorm == '') {
                                $isDifferent = false;
                            }



                            ?>
                            <tr class="<?= $isDifferent ? 'table-danger' : '' ?>">
                                <th class="fw-semibold">
                                    <?= h($field) ?>


                                </th>

                                <!-- BEFORE -->
                                <td class="<?= $isDifferent ? 'bg-danger-subtle' : '' ?>">
                                    <?php if (isset($beforeVal)): ?>
                                        <?php if (is_array($beforeVal) || is_object($beforeVal)): ?>
                                            <pre class="mb-0"><?= h(json_encode(
                                                    $beforeVal,
                                                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                                )) ?></pre>
                                        <?php else: ?>
                                            <?= h($beforeVal) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>

                                <!-- AFTER -->
                                <td class="<?= $isDifferent ? 'bg-danger-subtle fw-semibold' : '' ?>">
                                    <?php if (isset($afterVal)): ?>
                                        <?php if (is_array($afterVal) || is_object($afterVal)): ?>
                                            <pre class="mb-0"><?= h(json_encode(
                                                    $afterVal,
                                                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                                )) ?></pre>
                                        <?php else: ?>
                                            <?= h($afterVal) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
