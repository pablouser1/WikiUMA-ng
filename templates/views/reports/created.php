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
            <?php if ($report->email !== null): ?>
                Se te enviará un correo electrónico cuando la administración tome una decisión.
            <?php endif ?>
        </p>

        <p>
            Puedes saber en todo momento el estado de tu informe consultando el
            <a href="<?= $this->url('/reports') ?>">siguiente enlace</a>.
        </p>

        <a href="<?= $back ?>" class="button">Atrás</a>
    </div>

    <article class="message is-success">
        <div class="message-body">Gracias por hacer de WikiUMA un espacio más cívico y respetuoso <span style="color: #e25555;">&#9829;</span></div>
    </article>
</div>
