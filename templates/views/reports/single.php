<?php $this->layout('layouts/hero', [
    'title' => 'Informe',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <div class="content">
        <h1>Estado de informe</h1>
        <p>
            <span class="tag is-large <?= $this->e($report->status->color()) ?>">
                <?= $this->e($report->status->displayName()) ?>
            </span>
        </p>
        <?php if ($report->status !== \App\Enums\ReportStatusEnum::PENDING): ?>
            <p>Motivo: <?= $this->e($report->reason) ?></p>
        <?php endif ?>
    </div>
</div>
