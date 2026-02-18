<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Models\Report $report
 * @var string $back
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Informe creado',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <p class="title">Tu informe al usuario "<?= $this->e($report->review->username) ?>" ha sido creado.</p>
    <div class="content">
        <p>Tu informe está siendo valorado por la administración.</p>
        <p>Tu ID de informe es: <b><?= $this->e($report->uuid) ?></b>.</p>

        <p>
            Puedes saber en todo momento el estado de tu informe usando tu ID en el
            <a href="<?= $this->url('/reports/checker') ?>">siguiente enlace</a>.
        </p>

        <a href="<?= $back ?>" class="button">Atrás</a>
    </div>

    <article class="message is-success">
        <div class="message-body">Gracias por hacer de WikiUMA un espacio más cívico y respetuoso <span style="color: #e25555;">&#9829;</span></div>
    </article>
</div>
