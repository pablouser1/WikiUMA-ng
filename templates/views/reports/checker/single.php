<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Models\Report $report
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Informe',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <div class="content">
        <h1>Estado del informe</h1>
        <p>
            <span class="tag is-large <?= $this->e($report->status->color()) ?>">
                <?= $this->e($report->status->displayName()) ?>
            </span>
        </p>
        <?php if ($report->status !== \App\Enums\ReportStatusEnum::PENDING): ?>
            <p>Motivo: <?= $this->e($report->reason) ?></p>
            <p>
                Si tiene alguna pregunta o desea discutir esta decisión, no dude en contactar a <?= $this->contact(false) ?>
                usando el ID del informe como asunto.
            </p>
        <?php endif ?>
    </div>
</div>
