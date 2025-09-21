<?php $this->layout('layouts/hero', [
    'title' => 'Informe',
    'withNavbar' => true,
]) ?>

<div class="box">
    <p class="title">Estado de informe:</p>
    <p><?= $report->status->displayName() ?></p>
    <?php if ($report->status !== \App\Enums\ReportStatusEnum::PENDING): ?>
        <p>Motivo: <?= $this->e($report->reason ?? 'Sin Especificar') ?></p>
    <?php endif ?>
</div>
